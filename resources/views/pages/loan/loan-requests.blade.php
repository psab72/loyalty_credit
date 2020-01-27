@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('includes/alert')
                <div class="card">
                    <div class="card-body">
                        <h4>Loan Requests</h4>
                        <table class="table table-hover table-responsive-lg data-table">
                            <thead>
                                <th>Date Requested</th>
                                {{--<th>Date Accepted</th>--}}
                                <th>Lender</th>
                                <th>Merchant</th>
                                <th>Establishment Name</th>
                                <th>Amount</th>
                                <th>Payment Term</th>
                                <th>Interest</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($newCreditRequests as $c)
                                    <tr data-credit-request-id="{{ $c->id }}"
                                        data-lender-id="{{ $c->lender_id }}"
                                        data-merchant-id="{{ $c->merchant_id }}"
                                        data-merchant-email="{{ $c->email }}"
                                        data-merchant-name="{{ $c->merchant_name }}"
                                        data-interest-rate="{{ $c->interest_rate }}"
                                        data-interest-amount="{{ $c->interest_amount }}"
                                        data-amount="{{ $c->amount }}"
                                        data-payment-term-id="{{ $c->payment_term_id }}"
                                        data-monthly-amortization="{{ $c->monthly_amortization }}"
                                        data-status="{{ $c->status }}">
                                        <td>{{ date('M j, Y', strtotime($c->date_requested)) }}</td>
{{--                                        <td>{{ !empty($c->date_accepted) ? date('M j, Y', strtotime($c->date_accepted)) : '--' }}</td>--}}
                                        <td>{{ $c->lender_name }}</td>
                                        {{--<td><a href="{{ url('merchant/' . $c->merchant_id) }}">{{ $c->merchant_name }}</a></td>--}}
                                        <td><a href="{{ url('merchant/' . $c->merchant_id) }}">{{ $c->merchant_name }}</a></td>
                                        <td>{{ $c->establishment_name }}</td>
                                        <td>{{ $c->amount }}</td>
                                        <td>{{ $c->payment_term_name }}</td>
                                        <td>{{ $c->interest_amount }}({{ $c->interest_rate }}%)</td>
                                        <td><span class="badge {{ $c->bootstrap_status_text_color_class }}">{{ $c->status_name }}</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-chevron"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    @if($c->status == 'processing')
                                                        <a href="#" class="dropdown-item btn-accept-loan-request btn-action" data-toggle="modal" data-target="#accept-loan-modal">Accept</a>
                                                        <a href="#" class="dropdown-item btn-hold-loan-request btn-action" data-toggle="modal" data-target="#hold-loan-modal">Hold</a>
                                                        <a href="#" class="dropdown-item btn-deny-loan-request btn-action" data-toggle="modal" data-target="#deny-loan-modal">Deny</a>
                                                    @endif
                                                    <a href="{{ url('/merchant/' . $c->merchant_id) }}" class="dropdown-item ">View</a>
                                                    <a href="#" class="dropdown-item btn-view-merchant-kyc" data-kyc-id="{{ $c->kyc_id }}" data-toggle="modal" data-target="#kyc-modal">View KYC</a>
                                                        <a href="#" class="dropdown-item btn-update-current-loan" data-toggle="modal" data-target="#update-current-loan-modal">Update Current Loan</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr />
                        <h4>Current Loans</h4>
                        <table class="table table-hover table-responsive-lg data-table">
                            <thead>
                            <th>Date Requested</th>
                            {{--<th>Date Accepted</th>--}}
                            <th>Lender</th>
                            <th>Merchant</th>
                            <th>Establishment Name</th>
                            <th>Amount</th>
                            <th>Payment Term</th>
                            <th>Interest</th>
                            {{--<th>Status</th>--}}
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach($currentCreditRequests as $c)
                                <tr data-credit-request-id="{{ $c->id }}"
                                    data-lender-id="{{ $c->lender_id }}"
                                    data-merchant-id="{{ $c->merchant_id }}"
                                    data-merchant-email="{{ $c->email }}"
                                    data-merchant-name="{{ $c->merchant_name }}"
                                    data-interest-rate="{{ $c->interest_rate }}"
                                    data-amount="{{ $c->amount }}"
                                    data-payment-term-id="{{ $c->payment_term_id }}"
                                    data-monthly-amortization="{{ $c->monthly_amortization }}"
                                    data-status="{{ $c->status }}">
                                    <td>{{ date('M j, Y', strtotime($c->date_requested)) }}</td>
                                    {{--                                        <td>{{ !empty($c->date_accepted) ? date('M j, Y', strtotime($c->date_accepted)) : '--' }}</td>--}}
                                    <td>{{ $c->lender_name }}</td>
                                    {{--<td><a href="{{ url('merchant/' . $c->merchant_id) }}">{{ $c->merchant_name }}</a></td>--}}
                                    <td><a href="{{ url('merchant/' . $c->merchant_id) }}">{{ $c->merchant_name }}</a></td>
                                    <td>{{ $c->establishment_name }}</td>
                                    <td>PHP {{ $c->amount }}</td>
                                    <td>{{ $c->payment_term_name }}</td>
                                    <td>PHP {{ $c->interest_amount }}({{ $c->interest_rate }}%)</td>
                                    {{--<td><span class="badge {{ $c->bootstrap_status_text_color_class }}">{{ $c->status_name }}</span></td>--}}
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-chevron"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                @if($c->status == 'processing')
                                                    <a href="#" class="dropdown-item btn-accept-loan-request btn-action" data-toggle="modal" data-target="#accept-loan-modal">Accept</a>
                                                    <a href="#" class="dropdown-item btn-hold-loan-request btn-action" data-toggle="modal" data-target="#hold-loan-modal">Hold</a>
                                                    <a href="#" class="dropdown-item btn-deny-loan-request btn-action" data-toggle="modal" data-target="#deny-loan-modal">Deny</a>
                                                @endif
                                                <a href="{{ url('/merchant/' . $c->merchant_id) }}" class="dropdown-item ">View</a>
                                                <a href="#" class="dropdown-item btn-view-merchant-kyc" data-kyc-id="{{ $c->kyc_id }}" data-toggle="modal" data-target="#kyc-modal">View KYC</a>
                                            </div>
                                        </div>
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

    @include('pages.loan.modal')
@endsection



