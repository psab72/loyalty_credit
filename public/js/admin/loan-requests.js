
$(document).ready(function() {
    $('.data-table').DataTable({
//                 ordering: false,
//                 filter: false
    });

    $('.btn-action').on('click', function() {
        $('input[name=status]').attr('disabled', true);
    });

    $('.lender-id, #lender-id-update').on('change', function() {
        $('#interest-rate-accept-modal, #interest-rate-update').val($(this).find('option:selected').data('interest-rate'));
    });

    $('.btn-update-current-loan').on('click', function() {
        var lenderId = $(this).closest('tr').data('lender-id');
        var paymentTermId = $(this).closest('tr').data('payment-term-id');
        var status = $(this).closest('tr').data('status');
        $('.credit-request-id').val($(this).closest('tr').data('credit-request-id'));
        $('.lender-id option').each(function() {
            if($(this).val() == lenderId) {
                $(this).attr('selected', true);
            }
        });
        $('.interest-rate').val($(this).closest('tr').data('interest-rate'));
        $('.interest-amount').val($(this).closest('tr').data('interest-amount'));
        $('.amount').val($(this).closest('tr').data('amount'));
        $('.payment-term-id option').each(function() {
            if($(this).val() == paymentTermId) {
                $(this).attr('selected', true);
            }
        });

        $('.monthly-amortization').val($(this).closest('tr').data('monthly-amortization'));

        $('.status option').each(function() {
            if($(this).val() == status) {
                $(this).attr('selected', true);
            }
        });
    });

    $('.compute-amortization').on('click', function() {
        $('#lender-id-overlay').remove();
        $('#interest-rate-overlay').remove();
        $('#amount-overlay').remove();
        $('#payment-term-id-overlay').remove();

        $('#lender-id').removeClass('is-invalid');
        $('#interest-rate').removeClass('is-invalid');
        $('#amount').removeClass('is-invalid');
        $('#payment-term-id').removeClass('is-invalid');

        if(isEmpty($('.lender-id').val()) || isEmpty($('.interest-rate').val()) || isEmpty($('.amount').val()) || isEmpty($('.payment-term-id').val())) {

            if(isEmpty($('.lender-id').val())) {
                $('.lender-id').addClass('is-invalid');
                $('<div id="lender-id-overlay" class="invalid-feedback d-block">Please select a lender</div>').insertAfter('.lender-id');
            }

            if(isEmpty($('.interest-rate').val())) {
                $('.interest-rate').addClass('is-invalid');
                $('<div id="interest-rate-overlay" class="invalid-feedback d-block">Please select a lender</div>').insertAfter('.interest-rate');
            }

            if(isEmpty($('.amount').val())) {
                $('.amount').addClass('is-invalid');
                $('<div id="amount-overlay" class="invalid-feedback d-block">Please input an amount</div>').insertAfter('.amount');
            }

            if(isEmpty($('.payment-term-id').val())) {
                $('.payment-term-id').addClass('is-invalid');
                $('<div id="payment-term-id-overlay" class="invalid-feedback d-block">Please select a payment term</div>').insertAfter('.payment-term-id');
            }
        } else {
            var thisModal = $(this).closest('.modal');
            $.get('compute-amortization?lender_id=' + thisModal.find('.lender-id').val() + '&amount=' + thisModal.find('.amount').val() + '&payment_term_id=' + thisModal.find('.payment-term-id').val() + '&interest_rate=' + thisModal.find('.interest-rate').val(), function(data) {
                $('.interest-amount').val(data.data.interest_amount);
                $('.monthly-amortization').val(data.data.monthly_amortization);

            });
        }

        $('#accept').attr('disabled', false);
        $('.update-current-loan').attr('disabled', false);
    });

    $('.btn-accept-loan-request').on('click', function() {
        var trData = $(this).closest('tr');

        $('.credit-request-id').val(trData.data('credit-request-id'));
        $('.merchant-id').val(trData.data('merchant-id'));
        $('.merchant-email').val(trData.data('merchant-email'));
        $('.merchant-name').val(trData.data('merchant-name'));

        $('.lender-id option').each(function() {
            if($(this).val() == trData.data('lender-id')) {
                $(this).attr('selected', true);
            }
        });

        $('.payment-term-id option').each(function() {
            if($(this).val() == trData.data('payment-term-id')) {
                $(this).attr('selected', true);
            }
        });

        $('.amount').val(trData.data('amount'));

        $('.interest-rate').val(trData.data('interest-rate'));

        $('.interest-amount').val(trData.data('interest-amount'));

        $('.monthly-amortization').val(trData.data('monthly-amortization'));

    });

    $('.btn-hold-loan-request').on('click', function() {
        var trData = $(this).closest('tr');
        $('.credit-request-id').val(trData.data('credit-request-id'));
        $('.merchant-id').val(trData.data('merchant-id'));
        $('.merchant-email').val(trData.data('merchant-email'));
        $('.merchant-name').val(trData.data('merchant-name'));
    });

    $('.btn-deny-loan-request').on('click', function() {
        var trData = $(this).closest('tr');
        $('.credit-request-id').val(trData.data('credit-request-id'));
        $('.merchant-id').val(trData.data('merchant-id'));
        $('.merchant-email').val(trData.data('merchant-email'));
        $('.merchant-name').val(trData.data('merchant-name'));
    });

    $('.update-current-loan').on('click', function() {
        $.post('update-current-loan', {
            '_token': $('input[name=_token]').val(),
            credit_request_id: $('#credit-request-id-update').val(),
            lender_id: $('#lender-id-update').val(),
            interest_rate: $('#interest-rate-update').val(),
            interest_amount: $('#interest-amount-update').val(),
            amount: $('#amount-update').val(),
            payment_term_id: $('#payment-term-id-update').val(),
            monthly_amortization: $('#monthly-amortization-update').val(),
            // status: $('#status-update').val(),
        }).done(function(data) {
            location.reload();
        });
    });

});