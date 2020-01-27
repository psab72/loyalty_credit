$(document).ready(function() {
    $('.data-table').DataTable({
        "ordering": false,
        "filter": false,
    });

    $('.btn-pay').on('click', function() {
        pay().done(function(data) {
            var html = '';

            if(data.errors == true) {
                var currMessage = '';
                html += '<div class="alert alert-danger" tabindex="-1">';
                for(var i=0;i<data.messages.length;i++) {
                    currMessage = data.messages[i];
                    html += '<li>' + currMessage + '</li>';
                }
                html += '</div>';

                $('.wrapper-alert').html(html);
            } else {
                location.reload();
            }
        });
    });

    $('#update-mobile-number').on('click', function() {
        updateMobileNumber().done(function(data) {
            location.reload();
        });
    });

    function pay() {
        return $.post('pay', {
            '_token': $('input[name=_token]').val(),
            billing_id: $('#billing-id').val(),
            from: $('#from').val(),
            amount: $('#amount').val(),
            lender_id: $('#lender-id').val(),
            credit_request_id: $('#credit-request-id').val()
        });
    }

    function updateMobileNumber() {
        return $.post('update-mobile-number', {
            '_token': $('input[name=_token]').val(),
            mobile_number: $('#mobile-number').val(),
        });
    }
});