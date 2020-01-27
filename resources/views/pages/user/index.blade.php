@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('includes.alert')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="callout callout-info">
                                            <small class="text-muted">Total Merchants</small>
                                            <br>
                                            <strong class="h4">{{ $totalMerchants }}</strong>
                                            <small class="text-muted">{{ number_format($percentageDifferenceTotalMerchantsLastMonth, 2)  }} % Last Month</small>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="callout callout-success">
                                            <small class="text-muted">Total Transactors</small>
                                            <br>
                                            <strong class="h4">{{ $totalTransactors }}</strong>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="callout callout-info">
                                            <small class="text-muted">Total Revolvers</small>
                                            <br>
                                            <strong class="h4">{{ $totalRevolvers }}</strong>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-3" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="callout callout-danger">
                                            <small class="text-muted">Total Defaulters</small>
                                            <br>
                                            <strong class="h4">{{ $totalDefaulters }}</strong>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-4" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr class="mt-0">

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Merchants</h4>
                                <table class="table table-striped table-bordered table-responsive-md data-table">
                                    <thead>
                                    <th> Date Created</th>
                                    <th> Merchant Name</th>
                                    <th> Mobile Number</th>
                                    <th> Email</th>
                                    {{--<th> Mobile Number</th>--}}
                                    <th> Establishment Name</th>
                                    <th> Status</th>
                                    <th> Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($merchants as $m)
                                        <tr>
                                            <td> {{ !empty($m->created_at) ? date('M j, Y', strtotime($m->created_at)) : '--' }}</td>
                                            <td> <a href="#" class="btn-view-merchant-kyc" data-user-id="{{ $m->user_id }}" data-kyc-id="{{ !empty($m->kyc_id) ? $m->kyc_id : '0' }}" data-toggle="modal" data-target="#kyc-modal">{{ $m->first_name . ' ' . $m->last_name }}</a></td>
                                            <td> {{ $m->mobile_number }}</td>
                                            <td> {{ $m->email }}</td>
{{--                                            <td> {{ $m->mobile_number }}</td>--}}
                                            <td> {{ $m->establishment_name }}</td>
                                            <td align="center">
                                                <a href="#" class="badge badge-{{ $m->badge_contextual_class }}">{{ @ucfirst($m->status) }}</a>
                                            </td>
                                            <td align="center">
                                                <div class="dropdown">
                                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-chevron"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a href="{{ url('merchant/' . $m->id) }}" class="dropdown-item">View</a>
                                                        @if(!empty($m->kyc_id))
                                                            <a href="#" class="btn-view-merchant-kyc dropdown-item" data-kyc-id="{{ $m->kyc_id }}" data-toggle="modal" data-target="#kyc-modal">View KYC Details</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <br />
                        <hr class="mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>KYC</h4>
                                <table class="table table-striped table-bordered table-responsive-md data-table">
                                    <thead>
                                    <th> Date Created</th>
                                    <th> Merchant Name</th>
                                    <th> Email</th>
                                    <th> Establishment Name</th>
                                    <th> Status</th>
                                    <th> Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($kycData as $k)
                                        <tr>
                                            <td> {{ date('M j, Y', strtotime($k->created_at)) }}</td>
                                            <td> {{ $k->first_name . ' ' . $k->last_name }}</td>
                                            <td> {{ $k->email }}</td>
                                            <td> {{ $k->establishment_name }}</td>
                                            <td>
                                                <a href="#" class="badge badge-{{ $k->bootstrap_badge_contextual_class }}">{{ @ucfirst($k->status) }}</a>
                                            </td>
                                            <td align="center" width="90">
                                                {{--<div class="col-md-6">--}}
                                                    <a href="#" class="btn btn-primary btn-update-kyc" data-kyc-id="{{ $k->id }}" data-toggle="modal" data-target="#kyc-modal"><i class="fa fa-edit"></i></a>
                                                {{--</div>--}}
                                                {{--<div class="col-md-6">--}}
                                                    {{--<a href="#" class="btn btn-primary btn-assign-kyc" data-kyc-id="{{ $k->id }}" data-toggle="modal" data-target="#kyc-assign-modal"><i class="fa fa-tasks"></i></a>--}}
                                                {{--</div>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    @include ('pages.user.modal')

@endsection