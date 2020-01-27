<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Loyalty Credit') }}</title>

<link rel="shortcut icon" href="{{ asset('public/imgs/LClogo2-fav.png') }}">

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

<!-- Styles -->
{{--<link href="{{ asset('public/css/app.css') }}" rel="stylesheet">--}}
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
@if (in_array(request()->segment(1), ['dashboard-admin']))
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('public/css/picker.css') }}" />--}}
    <style>
        .chart-container {
            width: 1500px;
            height:300px
        }
    </style>
@endif

@if (in_array(request()->segment(1), ['dashboard-merchants', 'dashboard-merchant']))
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
    <style>
        .zoom {
            padding: 10px;
            transition: transform .2s;
            width: 300px;
            height: 300px;
            margin: 0 auto;
        }

        .zoom:hover {
            -ms-transform: scale(2); /* IE 9 */
            -webkit-transform: scale(2); /* Safari 3-8 */
            transform: scale(2);
        }
    </style>
@endif

@if (in_array(request()->segment(1), ['kyc']))
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />

@endif

@if (in_array(request()->segment(1), ['credit-request']))
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
@endif

@if (in_array(request()->segment(1), ['loan-requests', 'merchant']))
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />
@endif

@if(request()->segment(1) == 'register')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link href="{{ asset('public/js/SmartWizard-master/dist/css/smart_wizard.css') }}" rel="stylesheet" type="text/css" />
@endif


@if(request()->segment(1) == 'notification')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
@endif

@if(request()->segment(1) == 'edit-merchant')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet" />
@endif