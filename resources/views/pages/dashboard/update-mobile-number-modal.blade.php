<div class="modal fade" id="update-mobile-number-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="wrapper-alert"></div>
                            <div class="form-group row">
                                <label for="staticWalletBalance" class="col-md-4 col-form-label">Mobile Number</label>
                                <div class="col-md-6">
                                    <input class="form-control int-text-box" id="mobile-number" value="" />
                                </div>
                                {{--<input type="text" readonly class="form-control-plaintext" id="staticWalletBalance" value="{{ !empty($eWalletData->outstanding_balance) ? $eWalletData->outstanding_balance : '0.00' }}">--}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="update-mobile-number">Update</button>
            </div>
        </div>
    </div>
</div>