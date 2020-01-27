<div class="modal fade" id="repayment-modal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kyc-modal-label">Repay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <input type="hidden" value="{{ !empty($nextBilling->id) ? $nextBilling->id : '' }}" id="billing-id" />
                    <input type="hidden" value="{{ !empty($nextBilling->credit_request_id) ? $nextBilling->credit_request_id: '' }}" id="credit-request-id" />
                    <input type="hidden" value="{{ !empty($nextBilling->lender_id) ? $nextBilling->lender_id : '' }}" id="lender-id" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="wrapper-alert"></div>
                            <div class="form-group row">
                                <label for="staticWalletBalance" class="col-md-4 col-form-label">From</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="from">
                                        <option value="" style="display:none;" selected>Select Source Fund</option>
                                        {{--<option value="available_credit">Available Credit({{ auth()->user()->available_credit }})</option>--}}
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="post_dated_checks">Post Dated Checks</option>
                                        <option value="others">Others</option>
                                        {{--<option value="ewallet">eWallet(Balance: {{ !empty($eWalletData->outstanding_balance) ? $eWalletData->outstanding_balance : '0.00' }})</option>--}}
                                    </select>
                                </div>
                                {{--<input type="text" readonly class="form-control-plaintext" id="staticWalletBalance" value="{{ !empty($eWalletData->outstanding_balance) ? $eWalletData->outstanding_balance : '0.00' }}">--}}
                            </div>
                            <div class="form-group row">
                                <label for="staticWalletBalance" class="col-md-4 col-form-label">Due Date</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="staticWalletBalance" value="{{ !empty($nextBilling->payment_due_date) ? date('M j, Y', strtotime($nextBilling->payment_due_date)) : '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Amount</label>
                                <div class="col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="amount" value="{{ !empty($nextBilling->amount) ? $nextBilling->amount : '0.00' }}">

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @if(!empty($nextBilling))
                    <button type="button" class="btn btn-success btn-pay" id="btn-verify" data-status="verified">Pay</button>
                @endif
            </div>
        </div>
    </div>
</div>