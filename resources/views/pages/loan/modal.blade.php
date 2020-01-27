<!-- Modal -->
<div class="modal fade" id="accept-loan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('update-loan-request') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Accept Loan?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="credit-request-id" name="credit_request_id" value="" />
                    <input type="hidden" class="merchant-id" name="merchant_id" value="" />
                    <input type="hidden" class="merchant-email" name="merchant_email" value="" />
                    <input type="hidden" class="merchant-name" name="merchant_name" value="" />
                    <div class="form-group">
                        <label>Lender</label>
                        <select class="form-control lender-id" name="lender_id">
                            <option style="display:none;" selected>Select a Lender</option>
                            @foreach($lenders as $l)
                                <option value="{{ $l->id }}" data-interest-rate="{{ $l->interest_rate }}">{{ $l->lender_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Interest Rate</label>
                        <input class="form-control float-text-box interest-rate" id="interest-rate-accept-modal" name="interest_rate" value="" placeholder="---">
                    </div>

                    <div class="form-group">
                        <label>Interest Amount</label>
                        <input class="form-control float-text-box interest-amount" id="interest-amount-accept-modal" name="interest_amount" value="" placeholder="---">
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input class="form-control amount" name="amount" value="" />
                    </div>

                    <div class="form-group">
                        <label>Payment Term</label>
                        <select class="form-control payment-term-id" name="payment_term_id">
                            <option style="display:none;" selected>Select a Payment Term</option>
                            @foreach($paymentTerms as $p)
                                <option value="{{ $p->id }}">{{ $p->payment_term_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Monthly Amortization</label>
                        <input class="form-control-plaintext monthly-amortization" name="monthly_amortization" value="---" readonly />
                        <br />
                        <button class="btn btn-secondary compute-amortization" type="button">Compute</button>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="accept" name="status" value="accepted">Accept</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="hold-loan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('update-loan-request') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hold Loan?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <input type="hidden" class="credit-request-id" name="credit_request_id" value="" />
                        <input type="hidden" class="merchant-id" name="merchant_id" value="" />
                        <input type="hidden" class="merchant-email" name="merchant_email" value="" />
                        <input type="hidden" class="merchant-name" name="merchant_name" value="" />
                        <input type="hidden" class="lender-id" name="lender_id" value="" />
                        <input type="hidden" class="amount" name="amount" value="" />
                        <input type="hidden" class="monthly-amortization" name="monthly_amortization" value="" />
                        <div class="form-group">
                            <label>Reason</label>
                            <select class="form-control" name="reason_id">
                                <option style="display:none;" selected>Select a Reason</option>
                                @foreach($loanRequestsHoldReasons as $l)
                                    <option value="{{ $l->id }}">{{ $l->reason }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Additional Comments</label>
                            <textarea class="form-control" name="comment" placeholder="Additional Comments"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" name="status" value="on_hold">Hold</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="deny-loan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('update-loan-request') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deny Loan?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="credit-request-id" name="credit_request_id" value="" />
                    <input type="hidden" class="merchant-id" name="merchant_id" value="" />
                    <input type="hidden" class="merchant-email" name="merchant_email" value="" />
                    <input type="hidden" class="merchant-name" name="merchant_name" value="" />
                    <input type="hidden" class="lender-id" name="lender_id" value="" />
                    <input type="hidden" class="amount" name="amount" value="" />
                    <input type="hidden" class="monthly-amortization" name="monthly_amortization" value="" />
                    <div class="form-group">
                        <label>Reason</label>
                        <select class="form-control" name="reason_id">
                            <option style="display:none;" selected>Select a Reason</option>
                            @foreach($loanRequestsRejectReasons as $l)
                                <option value="{{ $l->id }}">{{ $l->reason }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Additional Comments</label>
                        <textarea class="form-control" name="comment" placeholder="Additional Comments"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="status" value="rejected">Deny</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="kyc-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ url('update-loan-request') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Merchant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="submit" class="btn btn-danger" name="status" value="rejected">Deny</button>--}}
                </div>
            </form>
        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="update-current-loan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('update-loan-request') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Loan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="credit-request-id" id="credit-request-id-update" name="credit_request_id" value="" />
                    <input type="hidden" class="merchant-id" name="merchant_id" value="" />
                    <input type="hidden" class="merchant-email" name="merchant_email" value="" />
                    <input type="hidden" class="merchant-name" name="merchant_name" value="" />
                    <div class="form-group">
                        <label>Lender</label>
                        <select class="form-control lender-id" id="lender-id-update" name="lender_id">
                            <option style="display:none;" selected>Select a Lender</option>
                            @foreach($lenders as $l)
                                <option value="{{ $l->id }}" data-interest-rate="{{ $l->interest_rate }}">{{ $l->lender_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Interest Rate</label>
                        <input class="form-control float-text-box interest-rate" id="interest-rate-update" name="interest_rate" value="" placeholder="---">
                    </div>

                    <div class="form-group">
                        <label>Interest Amount</label>
                        <input class="form-control-plaintext float-text-box interest-amount" id="interest-amount-update" name="interest_amount" value="" readonly placeholder="---">
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input class="form-control amount" id="amount-update" name="amount" value="" />
                    </div>

                    <div class="form-group">
                        <label>Payment Term</label>
                        <select class="form-control payment-term-id" id="payment-term-id-update" name="payment_term_id">
                            <option style="display:none;" selected>Select a Payment Term</option>
                            @foreach($paymentTerms as $p)
                                <option value="{{ $p->id }}">{{ $p->payment_term_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Monthly Amortization</label>
                        <input class="form-control-plaintext monthly-amortization" id="monthly-amortization-update" name="monthly_amortization" value="---" readonly />
                        <br />
                        <button class="btn btn-secondary compute-amortization" type="button">Compute</button>
                    </div>

                    {{--<div class="form-group">--}}
                        {{--<label>Status</label>--}}
                        {{--<select class="form-control status" id="status-update" name="status">--}}
                            {{--<option style="display:none;" selected>Select a Status</option>--}}
                            {{--<option value="accepted">Accepted</option>--}}
                            {{--<option value="processing">Processing</option>--}}
                            {{--<option value="rejected">Rejected</option>--}}
                            {{--<option value="closed">Closed</option>--}}
                            {{--<option value="on_hold">On Hold</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update-current-loan">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>