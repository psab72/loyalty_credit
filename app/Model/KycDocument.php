<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KycDocument extends Model
{
    //
    /** Get Kyc Document Ids for Kyc
     * @return mixed
     */
    public function getKycDocumentsId()
    {
        return $this->where('country_id', auth()->user()->country_id)
            ->pluck('id')
            ->toArray();
    }
}
