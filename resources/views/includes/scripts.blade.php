<script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>
{{--<script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>--}}
<script>
    var url = '{{ url('/') }}';
    $("body").contents().filter(function(){ return this.nodeType != 1; }).remove();


    function isEmpty(value) {
        return typeof value == 'undefined' || value === null || value == '';
    }

    // Restricts input for each element in the set of matched elements to the given inputFilter.
    (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                }
            });
        };

        $('.notifications').on('click', function() {
            $.post('read-notifs', {
                '_token': $('input[name=_token]').val(),
                user_id: '{{ !empty(auth()->user()->id) ? auth()->user()->id : 0 }}'
            }).done(function() {
                $('.badge-notifications').remove();
            });
        });
    }(jQuery));

    // Install input filters.
    $(".int-text-box").inputFilter(function(value) {
        return /^-?\d*$/.test(value); });
    $(".uint-text-box").inputFilter(function(value) {
        return /^\d*$/.test(value); });
    $(".int-limit-text-box").inputFilter(function(value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });
    $(".float-text-box").inputFilter(function(value) {
        return /^-?\d*[.]?\d*$/.test(value); });
    $(".currency-text-box").inputFilter(function(value) {
        return /^-?\d*[.,]?\d{0,2}$/.test(value); });
    $(".hex-text-box").inputFilter(function(value) {
        return /^[0-9a-f]*$/i.test(value); });
</script>

@if (request()->segment(1) == 'dashboard-admin')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/js/dashboard-admin.js') }}"></script>
@endif

@if (request()->segment(1) == 'dashboard-merchants')
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('public/js/merchant.js') }}"></script>
@endif

@if (request()->segment(1) == 'kyc')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select a Nationality'
            });

            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });


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

        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('#date-of-birth').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '+0d',
        });
    </script>
@endif

@if(request()->segment(1) == 'dashboard-merchant')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('public/js/dashboard-merchant.js') }}"></script>
    <script src="{{ asset('public/js/merchant.js') }}"></script>
@endif

@if(in_array(request()->segment(1), ['credit-request']))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select a Payment Term'
            });
        });
    </script>
@endif

@if(in_array(request()->segment(1), ['loan-requests', 'merchant']))
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('public/js/admin/loan-requests.js') }}"></script>
    <script src="{{ asset('public/js/merchant.js') }}"></script>
@endif


@if(request()->segment(1) == 'credit-request')
    <script src="{{ asset('public/js/loan-request.js') }}"></script>
@endif


@if(request()->segment(1) == 'register')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select a Nationality'
            });

            $('#date-of-birth').datepicker({
                format: 'yyyy-mm-dd',
                endDate: '+0d',
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('public/js/SmartWizard-master/dist/js/jquery.smartWizard.js') }}"></script>

    <script type="text/javascript" src="{{ asset('public/js/registration.js') }}"></script>
@endif

@if(request()->segment(1) == 'merchant')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('public/js/admin/merchant-view.js') }}"></script>
    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '+0d',
        });
    </script>
@endif

@if(request()->segment(1) == 'notification')
    <script>
        $('.datatable').DataTable();
    </script>
@endif

@if(request()->segment(1) == 'edit-merchant')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                endDate: '+0d',
            });
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
        });

    </script>
@endif