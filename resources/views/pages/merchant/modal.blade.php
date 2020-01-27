<!-- Modal -->
<div class="modal fade" id="update-loan-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('update-payment') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Update Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="billing-id" value="" />
                    <div class="form-group">
                        <label>Due Date</label>
                        <input class="form-control payment-due-date datepicker" id="payment-due-date" value="" />
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input class="form-control amount" id="amount" value="" />
                    </div>

                    <div class="form-group">
                        <label>Date Paid</label>
                        <input class="form-control date-paid datepicker" id="date-paid" value="" />
                    </div>


                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control status" id="status">
                            <option value="" selected></option>
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="btn-update-payment" name="status" value="accepted">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
