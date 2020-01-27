<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KycFile extends Model
{
    //
    protected $fillable = [
        'file',
    ];

    /**
     * @return mixed
     */
    public function getKycFiles()
    {
        return $this->leftJoin('kyc_documents', 'kyc_files.doc_type_id', '=', 'kyc_documents.id')
            ->where('kyc_id', request()->kyc_id)
            ->get();
    }

    /**
     * @param $kycFileId
     * @param $path
     */
    public function updateKycFile($kycFileId, $path)
    {
        $this->where('merchant_id', auth()->user()->id)
            ->where('doc_type_id', $kycFileId)
            ->update([
                'file' => $path
            ]);
    }

    /**
     * @param $kycId
     * @return mixed
     */
    public function checkKycFiles($kycId)
    {
        return $this->where('kyc_id', $kycId)
            ->count();
    }
}
