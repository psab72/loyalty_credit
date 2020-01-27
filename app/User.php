<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email_verified_at',
        'role_id',
        'mobile_number',
        'establishment_name',
        'email',
        'password',
        'country_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /** Get total Merchants
     * @return mixed
     */
    public function totalMerchants()
    {
        return $this->select('*',
            DB::raw('(CASE 
                WHEN status = \'processing\' THEN \'info\'
                WHEN status = \'on_hold\' THEN \'warning\'
                WHEN status = \'rejected\' THEN \'danger\'
            END) AS bootstrap_badge_contextual_class'))
            ->where('role_id', config('constants.roles.merchant'))
            ->count();
    }

    /** Get total users last month
     * @return mixed
     */
    public function totalUsersPastMonth()
    {
        return $this->whereBetween('created_at', [now()->subDays(30), now()])
            ->count();
    }

    /** Get percentage of total users last month
     * @return float|int
     */
    public function percentageDifferenceTotalMerchantsLastMonth()
    {
        return !empty($this->totalUsersPastMonth()) && !empty($this->totalMerchants()) ? $this->totalUsersPastMonth() / $this->totalMerchants() : 0.00;
    }

    /** User relation to countries table
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->hasOne('\App\Model\Country', 'id', 'country_id');
    }

    /** User relation to nationalities table
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nationality()
    {
        return $this->hasOne('\App\Model\Nationality', 'id', 'nationality_id');
    }

    /**
     * User relation to refcitymun table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city()
    {
        return $this->hasOne('\App\Model\Refcitymun', 'id', 'city_id');
    }

    /**
     * User relation to refprovince table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function province()
    {
        return $this->hasOne('\App\Model\Refprovince', 'provCode', 'province_id');
    }

    /**
     * User relation to refbrgy table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function brgy()
    {
        return $this->hasOne('\App\Model\Refbrgy', 'id', 'brgy_id');
    }

    /** User relation to credit_requests table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function creditRequest()
    {
        return $this->hasMany('\App\Model\CreditRequest', 'merchant_id', 'id');
    }

    /** Get users
     * @return mixed
     */
    public function getUsers()
    {
        return $this->select('id',
            'first_name',
            'last_name',
            'email',
            'mobile_number')
            ->whereIn('role_id', [
                config('constants.roles.admin'),
                config('constants.roles.super_user'),
                config('constants.roles.agent'),
            ])
            ->get();
    }

    public function stepOneRegister()
    {
        $verificationCode = $this->generateCode();
        if(!empty($this->where('email', request()->email)->count())) {
            //update
            $this->where('email', request()->email)
                ->update([
                    'password' => Hash::make(request()->password),
                    'verification_code' => $verificationCode,
                ]);
        } else {
            $this->insert([
                'email' => request()->email,
                'password' => Hash::make(request()->password),
                'verification_code' => $verificationCode,
                'role_id' => config('constants.roles.merchant'),
                'country_id' => 169
            ]);
        }

        $this->sendMail($verificationCode);
    }

    /**
     *
     */
    public function sendMail($verificationCode = 0)
    {
        Mail::send('emails.verification-code', ['verification_code' => $verificationCode], function($message) {
            $message->to(request()->email)
                ->subject('Your Verification Code');
            $message->from('support@loyaltycredit', 'Loyalty Credit Web');
        });
    }


    /**
     * Generate a six digits code
     *
     * @param int $codeLength
     * @return string
     */
    public function generateCode($codeLength = 5)
    {
        $min = pow(10, $codeLength);
        $max = $min * 10 - 1;
        $code = mt_rand($min, $max);

        return $code;
    }

    public function getMerchants()
    {
        return $this->select('users.*',
            DB::raw('CASE
                WHEN is_verified = 1 THEN \'Verified\'
                ELSE \'Not Verified\'
            END as status'),
            DB::raw('CASE
                WHEN is_verified = 1 THEN \'success\'
                ELSE \'warning\'
            END as badge_contextual_class'),
            'kyc.id as kyc_id')
            ->leftJoin('kyc', 'users.id', '=', 'kyc.merchant_id')
            ->where('role_id', config('constants.roles.merchant'))
            ->get();
    }

}
