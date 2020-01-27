$(document).ready(function() {
    $('#lender-id').on('change', function() {
        // alert($(this).find('option:selected').data('interest-rate'))
        $('#interest-rate').val($(this).find('option:selected').data('interest-rate'));
    });

    $('#compute-amortization').on('click', function() {
        $('#lender-id-overlay').remove();
        $('#interest-rate-overlay').remove();
        $('#amount-overlay').remove();
        $('#payment-term-id-overlay').remove();

        $('#lender-id').removeClass('is-invalid');
        $('#interest-rate').removeClass('is-invalid');
        $('#amount').removeClass('is-invalid');
        $('#payment-term-id').removeClass('is-invalid');

        if(isEmpty($('#lender-id').val()) || isEmpty($('#interest-rate').val()) || isEmpty($('#amount').val()) || isEmpty($('#payment-term-id').val())) {

            if(isEmpty($('#lender-id').val())) {
                $('#lender-id').addClass('is-invalid');
                $('<div id="lender-id-overlay" class="invalid-feedback d-block">Please select a lender</div>').insertAfter('#lender-id');
            }

            if(isEmpty($('#interest-rate').val())) {
                $('#interest-rate').addClass('is-invalid');
                $('<div id="interest-rate-overlay" class="invalid-feedback d-block">Please select a lender</div>').insertAfter('#interest-rate');
            }

            if(isEmpty($('#amount').val())) {
                $('#amount').addClass('is-invalid');
                $('<div id="amount-overlay" class="invalid-feedback d-block">Please input an amount</div>').insertAfter('#amount');
            }

            if(isEmpty($('#payment-term-id').val())) {
                $('#payment-term-id').addClass('is-invalid');
                $('<div id="payment-term-id-overlay" class="invalid-feedback d-block">Please select a payment term</div>').insertAfter('#payment-term-id');
            }
        } else {
            $.get('compute-amortization?lender_id=' + $('#lender-id').val() + '&amount=' + $('#amount').val() + '&payment_term_id=' + $('#payment-term-id').val() + '&interest_rate=' + $('#interest-rate').val(), function(data) {
                $('#monthly-amortization').val(data.data.monthly_amortization);

            });
        }
    });

    $('#terms-and-conditions').on('change', function() {
        // if(!isEmpty($('#monthly-amortization').val())) {
            if($(this).is(':checked')) {
                $('#apply-for-a-loan').attr('disabled', false);
            } else {
                $('#apply-for-a-loan').attr('disabled', true);
            }
        // }
    });
});