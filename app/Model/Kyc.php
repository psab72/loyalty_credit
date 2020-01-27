<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Kyc extends Model
{
    //
    protected $table = 'kyc';

    /** Get Kyc Data
     * @return mixed
     */
    public function kycData()
    {
        return $this->select('kyc.id',
            'kyc.merchant_id',
            'kyc.status',
            DB::raw('(CASE 
                WHEN status = \'incomplete\' THEN \'primary\'
                WHEN status = \'submitted\' THEN \'info\'
                WHEN status = \'on_hold\' THEN \'warning\'
                WHEN status = \'rejected\' THEN \'danger\'
            END) AS bootstrap_badge_contextual_class'),
            'kyc.created_at',
            'users.email',
            'users.first_name',
            'users.last_name',
            'users.mobile_number',
            'users.establishment_name',
            'users.signup_status',
            'users.kyc_status')
            ->leftJoin('users', 'kyc.merchant_id', '=', 'users.id')
            ->where('status', '!=', 'verified')
            ->where('role_id', 4)
//            ->orWhereNull('status')
//            ->when(auth()->user()->role_id == config('constants.roles.agent'), function($query) {
//                return $query->where('kyc.assigned_to_user_id', auth()->user()->id);
//            })
            ->get();
    }

    /** Get Kyc data by Id
     * @return mixed
     */
    public function getKycDataById()
    {
        return $this->select('kyc.id as kyc_id',
            'kyc.merchant_id',
            'kyc.status',
            'kyc.created_at',
            DB::raw('CONCAT(users.first_name, IF(users.middle_name IS NULL, \' \', CONCAT(\' \', users.middle_name, \' \')), users.last_name) as merchant_name'),
            'kyc.assigned_to_user_id',
            'users.id as user_id',
            'users.first_name',
            'users.middle_name',
            'users.last_name',
            'users.email',
            'users.date_of_birth',
            'users.place_of_birth',
            'users.address',
            'users.mobile_number',
            'users.establishment_name',
            'users.source_of_income',
            'users.signup_status',
            'refprovince.provDesc as province',
            'refcitymun.citymunDesc as city',
            'refbrgy.brgyDesc as brgy',
            'nationalities.nationality')
            ->leftJoin('users', 'kyc.merchant_id', '=', 'users.id')
            ->leftJoin('refprovince', 'users.province_id', '=', 'refprovince.provCode')
            ->leftJoin('refcitymun', 'users.city_id', '=', 'refcitymun.id')
            ->leftJoin('refbrgy', 'users.brgy_id', '=', 'refbrgy.id')
            ->leftJoin('nationalities', 'users.nationality_id', '=', 'nationalities.id')
            ->leftJoin('kyc_files', 'kyc.id', '=', 'kyc_files.kyc_id')
            ->leftJoin('kyc_documents', 'kyc_files.doc_type_id', '=', 'kyc_documents.id')
            ->where('kyc.id', request()->kyc_id)
            ->first();
    }

    /**
     * Update Kyc record
     */
    public function updateKycData()
    {
        $data = [
            'id' => request()->kyc_id,
            'status' => request()->status,
            'last_update_by_user_id' => auth()->user()->id,
            'comment' => request()->comment
        ];
        $this->where('id', request()->kyc_id)
            ->update($data);

        $this->insertKycHistory($data);
    }

    /**
     * Trigger insert Kyc history record
     */
    public function insertKycHistory()
    {
        $kycData = $this->where('id', request()->kyc_id)
            ->first();
        $data = [
            'kyc_id' => $kycData->id,
            'status' => $kycData->status,
            'assigned_to_user_id' => $kycData->assigned_to_user_id,
            'last_update_by_user_id' => $kycData->last_update_by_user_id,
            'comment' => $kycData->comment
        ];

        KycHistory::insert($data);
    }

    /**
     * Update Kyc record
     */
    public function updateKycAssignedTo()
    {
        try {
            DB::beginTransaction();
                $this->where('id', request()->kyc_id)
                    ->update([
                        'assigned_to_user_id' => request()->assigned_to_user_id,
                    ]);

                $data = $this->where('id', request()->id)
                    ->first();

                $this->insertKycHistory($data);

                DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    /** Check if user has kyc submitted
     * @return mixed
     */
    public function checkExistsKycRecord()
    {
        return $this->where('merchant_id', auth()->user()->id)
            ->count();
    }

    /**
     *
     */
    public function updateKycStatus()
    {
        $this->where('merchant_id', auth()->user()->id)
            ->update([
                'status' => 'submitted'
            ]);
    }

    /**
     *
     */
    public function insertKyc()
    {
        $this->merchant_id = auth()->user()->id;
        $this->status = 'submitted';
        $this->save();

        KycHistory::insert([
            'kyc_id' => $this->id,
            'status' => 'submitted'
        ]);
    }

    public function kycUploadData()
    {
        return $this->select('kyc.id',
            'kyc.status',
            'users.first_name',
            'users.middle_name',
            'users.last_name',
            'users.email',
            'users.date_of_birth',
            'users.place_of_birth',
            'users.house_no',
            'users.brgy_id',
            'users.city_id',
            'users.province_id',
            'users.source_of_income',
            'users.mobile_number',
            'users.establishment_name',
            'users.country_id',
            'users.nationality_id',
            'refbrgy.brgyDesc',
            'refcitymun.citymunDesc',
            'refprovince.provDesc',
            'countries.nicename',
            DB::raw('(CASE 
                WHEN status = \'submitted\' THEN \'badge-info\'
                WHEN status = \'on_hold\' THEN \'badge-warning\'
                WHEN status = \'rejected\' THEN \'badge-danger\'
                WHEN status = \'verified\' THEN \'badge-success\'
                ELSE \'badge-secondary\'
            END) AS bootstrap_status_text_color_class'))
            ->leftJoin('users', 'kyc.merchant_id', '=', 'users.id')
            ->leftJoin('countries', 'users.country_id', '=', 'countries.id')
            ->leftJoin('refbrgy', 'users.brgy_id', '=', 'refbrgy.id')
            ->leftJoin('refcitymun', 'users.city_id', '=', 'refcitymun.id')
            ->leftJoin('refprovince', 'users.province_id', '=', 'refprovince.provCode')
            ->leftJoin('kyc_reject_reasons', 'kyc.kyc_reject_reason_id', '=', 'kyc_reject_reasons.id')
            ->where('merchant_id', auth()->user()->id)
            ->first();
    }
}
