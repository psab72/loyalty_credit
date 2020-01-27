$(document).ready(function(){
    $('#province-id').on('change', function () {
        $.get(url + '/cities?province_id=' + $(this).val(), function(data) {
            var countData = data.length;
            var currRow;
            var html = '<option value="" style="display:none;">Select a city</option>';
            for(var i=0;i<countData;i++) {
                currRow = data[i];
                html += '<option value="' + currRow.id + '" data-city-mun-code="' + currRow.citymunCode + '">' + currRow.citymunDesc + '</option>';
            }

            $('#city-id').html(html);
        });
    });

    $('#city-id').on('change', function () {
        $.get(url + '/barangays?city_id=' + $(this).find('option:selected').data('city-mun-code'), function(data) {
            var countData = data.length;
            var currRow;
            var html = '<option value="" style="display:none;">Select a Barangay</option>';
            for(var i=0;i<countData;i++) {
                currRow = data[i];
                html += '<option value="' + currRow.id + '">' + currRow.brgyDesc + '</option>';
            }

            $('#brgy-id').html(html);
        });
    });


    $('#smartwizard').smartWizard({
        backButtonSupport: true,
        showStepURLhash: false,
        toolbarSettings: {
            toolbarPosition: 'bottom', // none, top, bottom, both
            toolbarButtonPosition: 'center', // left, right
            showPreviousButton: false,
            toolbarExtraButtons: [
                $('<button style="display:none;" type="button"></button>').text('Finish')
                    .addClass('btn btn-info finish-button')
                    .on('click', function(){
                        // $('#submitWizard').click();
                        stepSix().done(function(data) {
                            $('.overlay').remove();
                            $('input').removeClass('is-invalid');
                            if(data.errors == true) {
                                if(!isEmpty(data.messages.house_no)) {
                                    var errHouseNoMessage = data.messages.house_no[0];
                                    $('#house-no').addClass('is-invalid');
                                    $('<div id="house-no-overlay" class="invalid-feedback d-block overlay">' + errHouseNoMessage + '</div>').insertAfter('#house-no');
                                }

                                if(!isEmpty(data.messages.city_id)) {
                                    var errCityIdMessage = data.messages.city_id[0];
                                    $('#city-id').addClass('is-invalid');
                                    $('<div id="city-id-overlay" class="invalid-feedback d-block overlay">' + errCityIdMessage + '</div>').insertAfter('#city-id');
                                }

                                if(!isEmpty(data.messages.province_id)) {
                                    var errProvinceIdMessage = data.messages.province_id[0];
                                    $('#province-id').addClass('is-invalid');
                                    $('<div id="province-id-overlay" class="invalid-feedback d-block overlay">' + errProvinceIdMessage + '</div>').insertAfter('#province-id');
                                }

                                if(!isEmpty(data.messages.brgy_id)) {
                                    var errBrgyIdMessage = data.messages.brgy_id[0];
                                    $('#brgy-id').addClass('is-invalid');
                                    $('<div id="brgy-id-overlay" class="invalid-feedback d-block overlay">' + errBrgyIdMessage + '</div>').insertAfter('#brgy-id');
                                }

                                $('#smartwizard').smartWizard("goToStep", 5);
                            } else {
                                loginUser().done(function(data) {
                                    if(data.status == true) {
                                        window.location.replace(url + '/dashboard-merchant');
                                    }
                                })
                            }
                        });

                        // stepSix().done(function(data) {
                        //
                        // });

                    }),
            ],
        },
        disabledSteps: []
    });

    $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
        if(stepNumber == 5){
            $('.finish-button').show(); // show the button extra only in the last page
        } else {
            $('.finish-button').hide();
        }
    });

    // Initialize the leaveStep even
    $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
        if(stepNumber == 0 && stepDirection == 'forward') {
            stepOne().done(function (data) {
                $('.overlay').remove();
                $('input').removeClass('is-invalid');
                if (data.errors == true) {
                    if(!isEmpty(data.messages.email)) {
                        var errEmailMessage = data.messages.email[0];
                        $('#email').addClass('is-invalid');
                        $('<div id="email-overlay" class="invalid-feedback d-block overlay">' + errEmailMessage + '</div>').insertAfter('#email');
                    }

                    if(!isEmpty(data.messages.password)) {
                        var errPasswordMessage = data.messages.password[0];
                        $('#password').addClass('is-invalid');
                        $('<div id="password-overlay" class="invalid-feedback d-block overlay">' + errPasswordMessage + '</div>').insertAfter('#password');
                    }

                    $('#smartwizard').smartWizard("goToStep", 0);
                }
            });
        } else if(stepNumber == 1 && stepDirection == 'forward') {
            stepTwo().done(function(data) {
                $('.overlay').remove();
                $('input').removeClass('is-invalid');
                if(data.errors == true) {
                    if(!isEmpty(data.messages.verification_code)) {
                        var errVerificationCodeMessage = data.messages.verification_code[0];
                        $('#verification-code').addClass('is-invalid');
                        $('<div id="verification-code-overlay" class="invalid-feedback d-block overlay">' + errVerificationCodeMessage + '</div>').insertAfter('#verification-code');
                    }

                    $('#smartwizard').smartWizard("goToStep", 1);
                }
            });
        } else if(stepNumber == 2 && stepDirection == 'forward') {
            stepThree().done(function(data) {
                $('.overlay').remove();
                $('input').removeClass('is-invalid');
                if(data.errors == true) {
                    if(!isEmpty(data.messages.first_name)) {
                        var errFirstNameMessage = data.messages.first_name[0];
                        $('#first-name').addClass('is-invalid');
                        $('<div id="first-name-overlay" class="invalid-feedback d-block overlay">' + errFirstNameMessage + '</div>').insertAfter('#first-name');
                    }

                    if(!isEmpty(data.messages.middle_name)) {
                        var errMiddleNameMessage = data.messages.middle_name[0];
                        $('#middle-name').addClass('is-invalid');
                        $('<div id="middle-name-overlay" class="invalid-feedback d-block overlay">' + errMiddleNameMessage + '</div>').insertAfter('#middle-name');
                    }

                    if(!isEmpty(data.messages.last_name)) {
                        var errLastNameMessage = data.messages.last_name[0];
                        $('#last-name').addClass('is-invalid');
                        $('<div id="last-name-overlay" class="invalid-feedback d-block overlay">' + errLastNameMessage + '</div>').insertAfter('#last-name');
                    }

                    if(!isEmpty(data.messages.establishment_name)) {
                        var errEstablishmentNameMessage = data.messages.establishment_name[0];
                        $('#establishment-name').addClass('is-invalid');
                        $('<div id="establishment-name-overlay" class="invalid-feedback d-block overlay">' + errEstablishmentNameMessage + '</div>').insertAfter('#establishment-name');
                    }

                    if(!isEmpty(data.messages.mobile_number)) {
                        var errMobileNumberMessage = data.messages.mobile_number[0];
                        $('#mobile-number').addClass('is-invalid');
                        $('<div id="mobile-number-overlay" class="invalid-feedback d-block overlay">' + errMobileNumberMessage + '</div>').insertAfter('#mobile-number');
                    }

                    $('#smartwizard').smartWizard("goToStep", 2);
                }
            });
        } else if(stepNumber == 3 && stepDirection == 'forward') {
            stepFour().done(function(data) {
                $('.overlay').remove();
                $('input').removeClass('is-invalid');
                if(data.errors == true) {
                    if(!isEmpty(data.messages.date_of_birth)) {
                        var errDateOfBirthMessage = data.messages.date_of_birth[0];
                        $('#date-of-birth').addClass('is-invalid');
                        $('<div id="date-of-birth-overlay" class="invalid-feedback d-block overlay">' + errDateOfBirthMessage + '</div>').insertAfter('#date-of-birth');
                    }

                    if(!isEmpty(data.messages.place_of_birth)) {
                        var errPlaceOfBirthMessage = data.messages.place_of_birth[0];
                        $('#place-of-birth').addClass('is-invalid');
                        $('<div id="place-of-birth-overlay" class="invalid-feedback d-block overlay">' + errPlaceOfBirthMessage + '</div>').insertAfter('#place-of-birth');
                    }

                    $('#smartwizard').smartWizard("goToStep", 3);
                }
            });
        } else if(stepNumber == 4 && stepDirection == 'forward') {
            stepFive().done(function(data) {
                $('.overlay').remove();
                $('input').removeClass('is-invalid');
                if(data.errors == true) {
                    if(!isEmpty(data.messages.nationality_id)) {
                        var errNationalityIdMessage = data.messages.nationality_id[0];
                        $('#nationality-id').addClass('is-invalid');
                        $('<div id="nationality-id-overlay" class="invalid-feedback d-block overlay">' + errNationalityIdMessage + '</div>').insertAfter('#nationality-id');
                    }

                    if(!isEmpty(data.messages.source_of_income)) {
                        var errSourceOfIncomeMessage = data.messages.source_of_income[0];
                        $('#source-of-income').addClass('is-invalid');
                        $('<div id="source-of-income-overlay" class="invalid-feedback d-block overlay">' + errSourceOfIncomeMessage + '</div>').insertAfter('#source-of-income');
                    }

                    $('#smartwizard').smartWizard("goToStep", 4);
                }
            });
        } else if(stepNumber == 5 && stepDirection == 'forward') {
            // stepSix().done(function(data) {
            //     $('.overlay').remove();
            //     $('input').removeClass('is-invalid');
            //     if(data.errors == true) {
            //         var errHouseNoMessage = !isEmpty(data.messages.house_no) ? data.messages.house_no[0] : '';
            //         var errCityIdMessage = !isEmpty(data.messages.city_id) ? data.messages.city_id[0] : '';
            //         var errProvinceIdMessage = !isEmpty(data.messages.province_id) ? data.messages.province_id[0] : '';
            //         var errPostalCodeMessage = !isEmpty(data.messages.postal_code) ? data.messages.postal_code[0] : '';
            //
            //         $('#house-no').addClass('is-invalid');
            //         $('#city-id').addClass('is-invalid');
            //         $('#province-id').addClass('is-invalid');
            //         $('#postal-code').addClass('is-invalid');
            //         $('<div id="house-no-overlay" class="invalid-feedback d-block overlay">' + errHouseNoMessage + '</div>').insertAfter('#house-no');
            //         $('<div id="city-id-overlay" class="invalid-feedback d-block overlay">' + errCityIdMessage + '</div>').insertAfter('#city-id');
            //         $('<div id="province-id-overlay" class="invalid-feedback d-block overlay">' + errProvinceIdMessage + '</div>').insertAfter('#province-id');
            //         $('<div id="postal-code-overlay" class="invalid-feedback d-block overlay">' + errPostalCodeMessage + '</div>').insertAfter('#postal-code');
            //
            //         $('#smartwizard').smartWizard("goToStep", 5);
            //     }
            // });
        }

        });

    function stepOne() {
        return $.post('step-one-register', {
            '_token': $('input[name=_token]').val(),
            email: $('input[name=email]').val(),
            password: $('input[name=password]').val()
        })
    }

    function stepTwo() {
        return $.post('step-two-register', {
            '_token': $('input[name=_token]').val(),
            email: $('input[name=email]').val(),
            verification_code: $('input[name=verification_code]').val(),
        })
    }

    function stepThree() {
        return $.post('step-three-register', {
            '_token': $('input[name=_token]').val(),
            email: $('input[name=email]').val(),
            first_name: $('input[name=first_name]').val(),
            middle_name: $('input[name=middle_name]').val(),
            last_name: $('input[name=last_name]').val(),
            establishment_name: $('input[name=establishment_name]').val(),
            mobile_number: $('input[name=mobile_number]').val(),
        })
    }

    function stepFour() {
        return $.post('step-four-register', {
            '_token': $('input[name=_token]').val(),
            email: $('input[name=email]').val(),
            date_of_birth: $('input[name=date_of_birth]').val(),
            place_of_birth: $('input[name=place_of_birth]').val(),
        })
    }

    function stepFive() {
        return $.post('step-five-register', {
            '_token': $('input[name=_token]').val(),
            email: $('input[name=email]').val(),
            nationality_id: $('select[name=nationality_id]').val(),
            source_of_income: $('input[name=source_of_income]').val(),
        })
    }

    function stepSix() {
        return $.post('step-six-register', {
            '_token': $('input[name=_token]').val(),
            email: $('input[name=email]').val(),
            house_no: $('input[name=house_no]').val(),
            province_id: $('select[name=province_id]').val(),
            city_id: $('select[name=city_id]').val(),
            brgy_id: $('select[name=brgy_id]').val(),
        })
    }

    function loginUser() {
        return $.post('login-user', {
            '_token': $('input[name=_token]').val(),
            email: $('input[name=email]').val(),
            password: $('input[name=password]').val(),
        });
    }
});