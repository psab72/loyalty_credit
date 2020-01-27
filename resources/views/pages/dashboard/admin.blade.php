@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card ">
                    {{--<div class="card-header">Traffic &amp; Sales</div>--}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="callout callout-info">
                                            <small class="text-muted">Total Amount Lent</small>
                                            <br>
                                            PHP <strong class="h4">{{ $totalAmountLent }}</strong>
                                            <br />
                                            <small class="text-muted">Interest Charged: PHP {{ $interestCharged }}</small>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="callout callout-danger">
                                            <small class="text-muted">Total Amount at Risk</small>
                                            <br>
                                            PHP <strong class="h4">{{ $totalAmountAtRisk }}</strong>
                                            <br />
                                            <small class="text-muted">&nbsp;</small>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr class="mt-0">
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="callout callout-warning">
                                            <small class="text-muted">Total Late Payments</small>
                                            <br>
                                            PHP <strong class="h4">{{ $totalLateBills }}</strong>
                                            <br />
                                            <small class="text-muted">&nbsp;</small>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-3" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="callout callout-success">
                                            <small class="text-muted">Total Repaid</small>
                                            <br>
                                            PHP <strong class="h4">{{ $totalRepaid }}</strong>
                                            <br />
                                            <small class="text-muted">&nbsp;</small>
                                            <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-4" width="100" height="30"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr class="mt-0">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h4>Select Range</h4>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group my-auto">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">From</span>
                                            </div>
                                            <select class="custom-select month-range month-range-from month-range-from-month" id="inputGroupSelect01">
                                                <option style="display:none;" value="" selected>Month</option>
                                                @foreach($months as $i => $m)
                                                    <option value="{{ $i }}" {{ $i == date('m', strtotime("-5 months")) ? 'selected' : '' }}>{{ $m }}</option>
                                                @endforeach
                                            </select>
                                            <select class="custom-select month-range month-range-from month-range-from-year" id="inputGroupSelect02">
                                                <option style="display:none;" value="" selected>Year</option>
                                                <option value="2019" {{ '2019' == date('Y', strtotime("-5 months")) ? 'selected' : '' }}>2019</option>
                                                <option value="2018" {{ '2018' == date('Y', strtotime("-5 months")) ? 'selected' : '' }}>2018</option>
                                                <option value="2017" {{ '2017' == date('Y', strtotime("-5 months")) ? 'selected' : '' }}>2017</option>
                                            </select>
                                        </div>
                                    </div>

                                    <br />
                                    <br />
                                    <div class="col-md-5">
                                        <div class="input-group my-auto">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">To</span>
                                            </div>
                                            <select class="custom-select month-range month-range-to month-range-to-month" id="inputGroupSelect03">
                                                <option style="display:none;" value="" selected>Month</option>
                                                @foreach($months as $i => $m)
                                                    <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>{{ $m }}</option>
                                                @endforeach
                                            </select>
                                            <select class="custom-select month-range month-range-to month-range-to-year" id="inputGroupSelect04">
                                                <option style="display:none;" value="" selected>Year</option>
                                                <option value="2019" {{ '2019' == date('Y') ? 'selected' : '' }}>2019</option>
                                                <option value="2018" {{ '2018' == date('Y') ? 'selected' : '' }}>2018</option>
                                                <option value="2017" {{ '2017' == date('Y') ? 'selected' : '' }}>2017</option>
                                            </select>
                                        </div>
                                    </div>

                                    <br />
                                    <br />

                                    <div class="col-md-2 float-right">
                                        <button class="btn btn-primary"><i class="fa fa-check"></i></button>
                                    </div>
                                </div>

                            </div>


                            <div class="chart-container" width="400" height="400">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                        <br />
                        <hr class="my-0" />
                        <br />
                        <div class="row">
                            <div class="col">
                                <h4> Latest Transactions</h4>
                                <table class="table table-striped table-bordered datatable table-responsive-md">
                                    <thead>
                                    <th> Date</th>
                                    <th> Merchant Name</th>
                                    <th> Transaction Type</th>
                                    <th> Amount</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($latestTransactions as $lt)
                                            <tr>
                                                <td>{{ !empty($lt->date_transacted) ? date('M j, Y', strtotime($lt->date_transacted)) : '--' }}</td>
                                                <td><a href="{{ url('/merchant/' . $lt->merchant_id) }}">{{ $lt->first_name . ' ' . $lt->last_name }}</a></td>
                                                <td>{{ $lt->transaction_type_name }}</td>
                                                <td>PHP {{ number_format($lt->amount, 2, '.', ',') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col">
                                <h4> Upcoming Repayments</h4>
                                <table class="table table-striped table-bordered datatable table-responsive-md">
                                    <thead>
                                    <th> Due Date</th>
                                    <th> Merchant Name</th>
                                    {{--<th> Currency</th>--}}
                                    <th> Amount</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($upcomingBillings as $ub)
                                            <tr>
                                                <td>{{ !empty($ub->payment_due_date) ? date('M j, Y', strtotime($ub->payment_due_date)) : '--' }}</td>
                                                <td><a href="{{ url('/merchant/' . $ub->merchant_id) }}">{{ $ub->first_name . ' ' . $ub->last_name }}</a></td>
                                                {{--<td> {{ $b->transaction_type_name }}</td>--}}
                                                <td>PHP {{ number_format($ub->amount, 2, '.', ',') }}</td>
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
    <input id="chart-data" type="hidden" value="{{ json_encode($dataPerMonth) }}">
@endsection
