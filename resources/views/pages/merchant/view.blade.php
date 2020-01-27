@extends('layouts.app')

@section('content')
    <form>
        @csrf
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('includes.alert')
                <div class="card ">
                    <div class="card-body">
                        <input type="hidden" id="merchant-id" value="{{ $merchantData->id }}" />
                        <div class="row">
                            <div class="col-md-5">
                                <h5>{{ $merchantData->first_name }} {{ $merchantData->last_name }} <a href="{{ url('edit-merchant/' . $merchantData->id) }}" class="btn btn-primary btn-view-merchant-kyc" data-kyc-id="{{ $merchantData->kyc_id }}"><i class="fa fa-edit"></i></a></h5>
                                <hr />
                                <div class="row">
                                    <div class="col-md-6">
                                        Establishment:
                                        <p>{{ $merchantData->establishment_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        Mobile Number:
                                        <p>{{ $merchantData->mobile_number }}</p>
                                    </div>
                                </div>
                                {{--<div class="col">--}}
                                {{--Address: {{ $merchantData->address }}--}}
                                {{--</div>--}}
                            </div>
                            {{--<div class="col my-auto">--}}
                                {{--<h3 class="text-success">86</h3>--}}
                                {{--<p>Individual Credit Score</p>--}}
                            {{--</div>--}}
                            <div class="col my-auto">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control text-success font-weight-bold float-text-box" id="available-credit" value="{{ $merchantData->available_credit }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" id="update-available-credit" type="button"><i class="fa fa-check"></i></button>
                                    </div>
                                </div>
                                <p>Available Credit</p>
                            </div>
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
                                    @else
                                        &nbsp;
                                    @endif
                                </p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-body">
                        <h5>Payment Schedule</h5>
                        <table class="table table-hover table-bordered datatable">
                            <thead>
                                {{--<th>Bill ID</th>--}}
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Date Paid</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($billings as $b)
                                    <tr data-billing-id="{{ $b->id }}"
                                        data-payment-due-date="{{ $b->payment_due_date }}"
                                        data-amount="{{ $b->amount }}"
                                        data-date-paid="{{ $b->date_paid }}"
                                        data-status="{{ $b->status }}">
{{--                                        <td>{{ $b->id }}</td>--}}
                                        <td>{{ !empty($b->payment_due_date) ? date('M d, Y', strtotime($b->payment_due_date)) : '--' }}</td>
                                        <td>PHP {{ $b->amount }}</td>
                                        <td>{{ !empty($b->date_paid) ? date('M d, Y', strtotime($b->date_paid)) : '--' }}</td>
                                        <td>{{ ucfirst($b->status) }}</td>
                                        <td><button type="button" class="btn btn-primary update-payment" data-toggle="modal" data-target="#update-loan-modal">Update</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-body">
                        <h5>Transactions</h5>
                        <table class="table table-hover table-bordered data-table">
                            <thead>
                            <th>Date Transacted</th>
                            <th>Payment Type</th>
                            <th>Amount</th>
                            </thead>
                            <tbody>
                            @foreach($transactions as $t)
                                <tr>
                                    <td>{{ date('M d, Y h:i:s a', strtotime($t->date_transacted)) }}</td>
                                    <td>{{ $t->transaction_type_name }}</td>
                                    <td>PHP {{ $t->amount }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body">
                        <h5>Loans</h5>
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
                                    <td align="center"><span class="badge {{ $c->bootstrap_status_text_color_class }}">{{ $c->status_name }}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    @include('pages.merchant.modal')
@endsection
