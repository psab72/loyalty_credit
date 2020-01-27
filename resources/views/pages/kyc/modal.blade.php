<div class="modal fade" id="kyc-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kyc-modal-label">Merchant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Basic Info</h2>
                            <hr class="mt-0">
                            <input type="hidden" id="kyc-id-active" />
                            <div class="form-group row">
                                <label for="staticEmail" class="col-md-6 col-form-label">Email</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticMerchantName" class="col-md-6 col-form-label">Merchant Name</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticMerchantName" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticMobileNumber" class="col-md-6 col-form-label">Mobile Number</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticMobileNumber" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEstablishmentName" class="col-md-6 col-form-label">Establishment Name</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEstablishmentName" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticDateOfBirth" class="col-md-6 col-form-label">Date of Birth</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticDateOfBirth" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticPlaceOfBirth" class="col-md-6 col-form-label">Place of Birth</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticPlaceOfBirth" value="">
                                </div>
                            </div>
                            {{--<div class="form-group row">--}}
                                {{--<label for="staticAddress" class="col-md-6 col-form-label">Address</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<input type="text" readonly class="form-control-plaintext" id="staticAddress" value="">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group row">
                                <label for="staticProvince" class="col-md-6 col-form-label">Province</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticProvince" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticCity" class="col-md-6 col-form-label">City</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticCity" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticBrgy" class="col-md-6 col-form-label">Brgy</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticBrgy" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticNationality" class="col-md-6 col-form-label">Nationality</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticNationality" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticSourceOfIncome" class="col-md-6 col-form-label">Source of Income</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticSourceOfIncome" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticStatus" class="col-md-6 col-form-label">Status</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticStatus" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2>KYC Documents</h2>
                            <hr class="mt-0">
                            <div class="wrapper-kyc-files-form">

                            </div>

                            <div class="form-group">
                                <label>Comment</label>
                                <textarea class="form-control" id="comment" rows="2"></textarea>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger btn-update-kyc-status" id="btn-reject" data-status="rejected">Reject</button>
                <button type="button" class="btn btn-warning btn-update-kyc-status" id="btn-hold" data-status="on_hold">Hold</button>
                <button type="button" class="btn btn-success btn-update-kyc-status" id="btn-verify" data-status="verified">Verify</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kyc-assign-modal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kyc-assign-modal-label">Assign To</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('kyc-assign') }}">
                    {{--@csrf--}}
                    {{--<input type="hidden" id="kyc-id-active" />--}}
                    {{--<div class="form-group row">--}}
                        {{--<label class="col-md-2 col-form-label">Name</label>--}}
                        {{--<div class="col-md-10">--}}
                            {{--<select class="form-control" id="assigned-to-user-id" name="assigned_to_user_id">--}}
                                {{--<option></option>--}}
                                {{--@foreach($users as $u)--}}
                                    {{--<option value="{{ $u->id }}">{{ $u->first_name }} {{ $u->last_name }}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-update-kyc-assigned-to">Assign</button>
            </div>
        </div>
    </div>
</div>