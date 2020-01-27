<?php

namespace App\Http\Controllers;

use App\Http\Requests\KycUpdateRequest;
use App\Http\Requests\UploadKycDocumentsRequest;
use App\Model\Kyc;
use App\Model\KycDocument;
use App\Model\KycFile;
use App\Model\KycHistory;
use App\Model\Nationality;
use App\Model\Refbrgy;
use App\Model\Refcitymun;
use App\Model\Refprovince;
use App\User;
use Illuminate\Http\Request;
use DB;

class KycController extends Controller
{
    /**
     * View controller for upload KYC page
     *
     * @param KycDocument $kycDocument
     * @param Nationality $nationality
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Kyc $kyc, KycDocument $kycDocument, Nationality $nationality, KycFile $kycFile, Refbrgy $refbrgy, Refcitymun $refcitymun, Refprovince $refprovince)
    {
        if(!empty($kyc->kycUploadData())) {
            $kycData = $kyc->kycUploadData();
        } else {
            $kycData = auth()->user();
        }


//
        if(!empty($kycData)) {
            $cityData = $refcitymun->where('id', $kycData->city_id)
                ->first();

            $citymunCode = !empty($cityData->citymunCode) ? $cityData->citymunCode : 0;
            $barangays = $refbrgy->where('citymunCode', $citymunCode)->get();

            $provinceData = $refprovince->where('provCode', $kycData->province_id)
                ->first();

            $provCode = !empty($provinceData->provCode) ? $provinceData->provCode : 0;
            $cities = $refcitymun->where('provCode', $provCode)->get();

            $provinces = $refprovince->get();

        }

        $kycDocuments = $kycDocument->select('kyc_documents.id',
            'kyc_documents.doc_name')
            ->where('kyc_documents.country_id', auth()->user()->country_id)
            ->get();

        if(!empty($kycDocuments)) {
            $kycFiles = $kycFile->leftJoin('kyc', 'kyc_files.kyc_id', '=', 'kyc.id')
                ->where('kyc.merchant_id', auth()->user()->id)
                ->get();
            foreach($kycDocuments as $k) {
                foreach(config('constants.kyc_documents') as $i => $k2) {
                    if($k->id == $i) {
                        $k->name = $k2;
                    }
                }

                foreach($kycFiles as $k3) {
                    if($k->id == $k3->doc_type_id) {
                        $k->file = $k3->file;
                    }
                }
            }
        }

//        dd($kycDocuments);

        $nationalities = $nationality->get();

        return view('pages.kyc.upload', compact('kycData', 'kycDocuments', 'nationalities', 'barangays', 'cities', 'provinces', 'nationalities'));
    }

    /**
     * Store KYC files
     *
     * @return array
     */
    public function storeFiles()
    {
        $paths = [];
        foreach(request()->file() as $k => $f) {
            $paths[] = [
                'path' => request()->file($k)->store('public/imgs/kyc'),
                'name' => $k
            ];
        }

        return $paths;
    }

    /**
     * @param User $user
     */
    public function updateUserKycDetails($user)
    {
        $data = [];
        !empty(request()->first_name) ? $data['first_name'] = request()->first_name : '';
        !empty(request()->middle_name) ? $data['middle_name'] = request()->middle_name : '';
        !empty(request()->last_name) ? $data['last_name'] = request()->last_name : '';
        !empty(request()->email) ? $data['email'] = request()->email : '';
        !empty(request()->date_of_birth) ? $data['date_of_birth'] = request()->date_of_birth : '';
        !empty(request()->place_of_birth) ? $data['place_of_birth'] = request()->place_of_birth : '';
        !empty(request()->house_no) ? $data['house_no'] = request()->house_no : '';
        !empty(request()->brgy_id) ? $data['brgy_id'] = request()->brgy_id : '';
        !empty(request()->city_id) ? $data['city_id'] = request()->city_id : '';
        !empty(request()->province_id) ? $data['province_id'] = request()->province_id : '';
        !empty(request()->nationality_id) ? $data['nationality_id'] = request()->nationality_id : '';
        !empty(request()->mobile_number) ? $data['mobile_number'] = request()->mobile_number : '';
        !empty(request()->establishment_name) ? $data['establishment_name'] = request()->establishment_name : '';
        !empty(request()->source_of_income) ? $data['source_of_income'] = request()->source_of_income : '';

        $user->where('id', auth()->user()->id)
            ->update($data);
    }

    /**
     * @param $kyc
     */
    public function checkExistsKycRecord($kyc)
    {
        //check if user already submitted kyc if submitted, update the kyc record. If not, insert a new kyc record.
        if(!empty($kyc->checkExistsKycRecord())) {
            $kyc->updateKycStatus();
        } else {
            $kyc->insertKyc();
        }
    }

    /**
     * @param $kyc
     * @param $kycFile
     * @param $paths
     */
    public function insertKycFiles($kyc, $kycFile, $paths, $kycData)
    {
        $kycFileData = [];
        if(!empty($paths)) {
            foreach($paths as $p) {
                foreach(config('constants.kyc_documents') as $k2 => $kd) {
                    if($kd == $p['name']) {
                        $docTypeId = $k2;
                        $kycFileData[] = [
                            'kyc_id' => !empty($kyc->id) ? $kyc->id : $kycData->id,
                            'merchant_id' => auth()->user()->id,
                            'file' => $p['path'],
                            'doc_type_id' => $docTypeId
                        ];
                    }
                }
            }
        }

//        dd($kycFileData);
        $kycFile->insert($kycFileData);
    }

    /**
     * @param $kycFile
     * @param $paths
     */
    public function updateKycFiles($kycFile, $paths)
    {
        if(!empty($paths)) {
            foreach($paths as $p) {
                foreach(config('constants.kyc_documents') as $k2 => $kd) {
                    if($kd == $p['name']) {
                        $docTypeId = $k2;
                        $kycFile->updateKycFile($docTypeId, $p['path']);
                    }
                }
            }
        }
    }

    /**
     * @param $kyc
     * @param $kycFile
     * @param $paths
     */
    public function insertUpdateKycFiles($kyc, $kycFile, $paths)
    {
        $kycData = $kyc->where('merchant_id', auth()->user()->id)
            ->first();

        if(!empty($kycFile->checkKycFiles($kycData->id))) {
            $this->updateKycFiles($kycFile, $paths);
        } else {
            $this->insertKycFiles($kyc, $kycFile, $paths, $kycData);
        }
    }

    /**
     * Upload KYC documents
     *
     * @param UploadKycDocumentsRequest $uploadKycDocumentsRequest
     * @param User $user
     * @param Kyc $kyc
     * @param KycFile $kycFile
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function uploadKycDocuments(UploadKycDocumentsRequest $uploadKycDocumentsRequest, User $user, Kyc $kyc, KycFile $kycFile)
    {
        try {
            DB::beginTransaction();
                //store files
                $paths = $this->storeFiles();

                //update users table kyc fields
                $this->updateUserKycDetails($user);

                //check if kyc exists
                $this->checkExistsKycRecord($kyc);

                //insert or update kyc files
                $this->insertUpdateKycFiles($kyc, $kycFile, $paths);
        } catch(\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            throw $e;
        }

        DB::commit();

        return redirect()->to('kyc')
            ->with('success', 'Success!');
    }

    /**
     * @param Kyc $kyc
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assign(Kyc $kyc)
    {
        $kyc->where('id', request()->kyc_id)
            ->update([
                'assigned_to_user_id' => request()->assigned_to_kyc_id
            ]);

        return redirect()->to('dashboard-merchants')
            ->with('success', 'Success!');
    }
}
