/**
 * Created by USER on 12/12/2018.
 */
$(document).ready(function() {
    $(".alert").focus();

    // $('.data-table').DataTable( {
    // //     "ordering": false
    // } );
    if ( ! $.fn.DataTable.isDataTable( '.data-table' ) ) {
        $('.data-table').DataTable();
    }

    $('.btn-update-kyc').on('click', function() {
        kycData($(this));
        $('.btn-update-kyc-status').show();
    });

    $('.data-table').on('click', '.btn-view-merchant-kyc', function() {
        kycData($(this));
        $('.btn-update-kyc-status').hide();
    });

    $('.btn-assign-kyc').on('click', function() {
        kycAssignData($(this));
    });

    $('.btn-update-kyc-status').on('click', function() {
        updateKycStatus($(this));
    });

    $('.btn-update-kyc-assigned-to').on('click', function() {
        updateKycAssignedTo($(this));
    });

    function kycAssignData(obj) {
        $.get(url + '/kyc-data?kyc_id=' + $(obj).data('kyc-id'), function(data) {
            $('#kyc-id-active').val(data.kyc.id);
            $('#assigned-to-user-id option').each(function() {
                if($(this).val() == data.kyc.assigned_to_user_id) {
                    $(this).attr('selected', true);
                } else {
                    $(this).attr('selected', false);
                }
            });
        });
    }

    function updateKycAssignedTo(obj) {
        $.post(url + '/kyc-assign?kyc_id=' + $('#kyc-id-active').val(), {
            '_token': $('input[name=_token]').val(),
            assigned_to_user_id: $('#assigned-to-user-id').val()
        }).done(function(data) {
                location.reload();
            });
    }


    function updateKycStatus(obj) {
        $.post(url + '/update-kyc?kyc_id=' + $('#kyc-id-active').val(), {
            '_token': $('input[name=_token]').val(),
            status: $(obj).data('status'),
            comment: $('#comment').val()})
            .done(function(data) {
                location.reload();
            });
    }
});

function kycData(obj) {
    $.get(url + '/kyc-data?kyc_id=' + $(obj).data('kyc-id'), function(data) {
        if(!isEmpty(data.kyc)) {
            kycDom(data);
        }
    });
}

function kycDom(data) {
    $('.kyc-input').val('');
    $('.wrapper-kyc-files-form').empty();
    $('#kyc-id-active').val(data.kyc.kyc_id);
    $('#merchant-id-active').val(data.kyc.user_id);
    $('#staticEmail').val(data.kyc.email);
    $('#staticMerchantName').val(data.kyc.merchant_name);
    $('#staticMobileNumber').val(data.kyc.mobile_number);
    $('#staticEstablishmentName').val(data.kyc.establishment_name);
    $('#staticSourceOfIncome').val(data.kyc.source_of_income);
    $('#staticDateOfBirth').val(data.kyc.date_of_birth);
    $('#staticPlaceOfBirth').val(data.kyc.place_of_birth);
    // $('#staticAddress').val(data.kyc.address);
    $('#staticHouseNo').val(data.kyc.house_no);
    $('#staticProvince').val(data.kyc.province);
    $('#staticCity').val(data.kyc.city);
    $('#staticBrgy').val(data.kyc.brgy);
    $('#staticNationality').val(data.kyc.nationality);
    $('#staticStatus').val(data.kyc.status);

    var countKycFiles = data.kyc_files.length;
    var currKycFile;
    var html = '';
    for(var i=0;i<countKycFiles;i++) {
        currKycFile = data.kyc_files[i];
        html += '<div class="form-group">' +
            '<label>' + currKycFile.doc_name + '</label>' +
            '<img class="img-fluid zoom kyc-files" src="' + url + '/storage/app/' + currKycFile.file + '">' +
            '</div>'
    }

    $('.wrapper-kyc-files-form').html(html);
}