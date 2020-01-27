@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('includes.alert')
                <div class="card ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <h5>Hi, {{ auth()->user()->first_name }}</h5>
                                <hr />
                                <div class="row">
                                    <div class="col-md-6">
                                        Establishment:
                                        <p>{{ auth()->user()->establishment_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        Mobile Number:
                                        <p>{{ auth()->user()->mobile_number }} <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update-mobile-number-modal"><i class="fa fa-edit"></i></button></p>
                                    </div>
                                </div>
                                {{--<div class="col">--}}
                                {{--Address: {{ $merchantData->address }}--}}
                                {{--</div>--}}
                            </div>

                            {{--<div class="col my-auto">--}}
                                {{--<h3 class="text-success">PHP {{ !empty($eWalletData->outstanding_balance) ? $eWalletData->outstanding_balance : '0.00' }}</h3>--}}
                                {{--<p>Wallet Balance</p>--}}
                            {{--</div>--}}
                            <div class="col my-auto">
                                <h3 class="text-success">{{ auth()->user()->available_credit }}</h3>
                                <p>Available Credit</p>
                            </div>
                            {{--<div class="col my-auto">--}}
                                {{--<h3 class="text-info">86</h3>--}}
                                {{--<p>Individual Credit Score</p>--}}
                            {{--</div>--}}
                            {{--<div class="col my-auto">--}}
                                {{--<h3 class="text-info">86</h3>--}}
                                {{--<p>Interest Rate</p>--}}
                            {{--</div>--}}
                            <div class="col my-auto">
                                <h3 class="text-danger">PHP {{ $totalBills }}</h3>
                                <p>Loan Outstanding <small>(Principle + Interest)</small></p>
                            </div>

                            <div class="col my-auto">
                                @if(!empty($nextBilling))
                                <p>&nbsp;</p>
                                @endif
                                <h3 class="text-warning">PHP {{ !empty($nextBilling->amount) ? $nextBilling->amount : '0.00' }}</h3>
                                <p>
                                    Next Payment
                                    @if(!empty($nextBilling->payment_due_date))
                                        (Due: <strong>{{ date('M j, Y', strtotime($nextBilling->payment_due_date)) }})</strong>
                                    @endif
                                </p>
                                @if(!empty($nextBilling))
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#repayment-modal">Pay</button>
                                @endif
                            </div>
                        </div>


                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Payment Schedule</h4>
                                <table class="table table-bordered table-hover data-table">
                                    <thead>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Date Paid</th>
                                    <th>Status</th>
                                    {{--<th>Action</th>--}}
                                    </thead>
                                    <tbody>
                                    @foreach($billings as $b)
                                        <tr>
                                            <td>{{ !empty($b->payment_due_date) ? date('M j, Y', strtotime($b->payment_due_date)) : '--' }}</td>
                                            <td>{{ $b->amount }}</td>
                                            <td>{{ !empty($b->date_paid) ? date('M j, Y', strtotime($b->date_paid)) : '--' }}</td>
                                            <td>{{ ucfirst($b->status) }}</td>
                                            {{--<td>--}}
                                                {{--<a class="btn btn-primary" data-toggle="modal" data-target="#kyc-assign-modal"></a>--}}
                                            {{--</td>--}}
                                        </tr>
                                    @endforeach
                                    {{--<td>Test</td>--}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h4>Transactions</h4>
                                <table class="table table-bordered table-hover data-table">
                                    <thead>
                                    <th>Date Transacted</th>
                                    <th>Amount</th>
                                    <th>Transaction Type</th>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $t)
                                        <tr>
                                            <td>{{ !empty($t->date_transacted) ? date('M j, Y', strtotime($t->date_transacted)) : '--' }}</td>
                                            <td>{{ $t->amount }}</td>
                                            <td>{{ $t->transaction_type_name }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr />
                        <div class="row">

                            <div class="col">
                                <h4>Loans</h4>
                                <table class="table table-bordered table-hover data-table">
                                    <thead>
                                    <th>Lender</th>
                                    <th>Amount</th>
                                    <th>Payment Term</th>
                                    <th>Interest</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                    @foreach($creditRequests as $c)
                                    <tr>
                                        <td>{{ $c->lender_name }}</td>
                                        <td>PHP {{ $c->amount }}</td>
                                        <td>{{ $c->payment_term_name }}</td>
                                        <td>PHP {{ $c->interest_amount }}({{ $c->interest_rate }}%)</td>
                                        <td>{{ $c->status_name }}</td>
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

    @include('pages.dashboard.repayment-modal')
    @include('pages.dashboard.update-mobile-number-modal')
@endsection
