$(document).ready(function() {
    $('.datatable').DataTable( {
        "ordering": false
    } );

    $('#update-available-credit').on('click', function() {
        $.post(url + '/update-available-credit', {
            '_token': $('input[name=_token]').val(),
            merchant_id: $('#merchant-id').val(),
            credit: $('#available-credit').val()
        }).done(function(data) {
            $('#available-credit-overlay').remove();
            $('<div id="available-credit-overlay" class="valid-tooltip d-block">Successfully Updated!</div>').insertAfter('#available-credit');

            setTimeout(function() {
                $('#available-credit-overlay').remove();
            }, 5000);
        });
    });

    $('.update-payment').on('click', function() {
        var row = $(this).closest('tr');

        $('#billing-id').val(row.data('billing-id'));
        $('#payment-due-date').val(row.data('payment-due-date'));
        $('#amount').val(row.data('amount'));
        $('#date-paid').val(row.data('date-paid'));
        $('#status').val(row.data('status'));
    });

    $('#btn-update-payment').on('click', function() {
        $.post(url + '/update-payment', {
            '_token': $('input[name=_token]').val(),
            billing_id: $('#billing-id').val(),
            payment_due_date: $('#payment-due-date').val(),
            amount: $('#amount').val(),
            date_paid: $('#date-paid').val(),
            status: $('#status').val(),
        }).done(function(data) {

            location.reload();
            // $('#available-credit-overlay').remove();
            // $('<div id="available-credit-overlay" class="valid-tooltip d-block">Successfully Updated!</div>').insertAfter('#available-credit');
            //
            // setTimeout(function() {
            //     $('#available-credit-overlay').remove();
            // }, 5000);
        });
    });
});