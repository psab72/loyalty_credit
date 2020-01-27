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
                                <h4>Users</h4>
                                <table class="table table-striped table-bordered table-responsive-md datatable">
                                    <thead>
                                    <th> Date Created</th>
                                    <th> Name</th>
                                    <th> Mobile Number</th>
                                    <th> Email</th>
                                    {{--<th> Mobile Number</th>--}}
                                    <th> Establishment Name</th>
                                    <th> Role</th>
                                    <th> Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $u)
                                        <tr>
                                            <td> {{ !empty($u->created_at) ? date('M j, Y', strtotime($u->created_at)) : '--' }}</td>
                                            <td> <a href="#" class="btn-view-merchant-kyc" data-user-id="{{ $u->user_id }}" data-kyc-id="{{ !empty($u->kyc_id) ? $u->kyc_id : '0' }}" data-toggle="modal" data-target="#kyc-modal">{{ $u->first_name . ' ' . $u->last_name }}</a></td>
                                            <td> {{ $u->mobile_number }}</td>
                                            <td> {{ $u->email }}</td>
                                            <td> {{ $u->establishment_name }}</td>
                                            <td> {{ $u->role }}</td>
                                            <td align="center">
                                                <a href="{{ url('user/' . $u->id) }}" class="btn btn-primary">Update Password</a>
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