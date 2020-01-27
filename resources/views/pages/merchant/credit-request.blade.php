@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('includes.alert')
                <div class="card">
                    <form class="justify-content-center" action="{{ route('credit-request') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h4>Loan Request</h4>
                                    <hr class="m-2">
                                    <div class="form-group">
                                        <label class="col-md-4 col-form-label">Please select from our lending partners</label>
                                        <div class="col-md-6">
                                            <select class="form-control {{ $errors->has('lender_id') ? 'is-invalid' : '' }} " id="lender-id" name="lender_id">
                                                <option style="display:none;" value="" selected>Select a Lending Partner</option>
                                                @foreach($lenders as $l)
                                                    <option value="{{ $l->id }}" data-interest-rate="{{ $l->interest_rate }}" data-country-id="{{ $l->country_id }}" data-currency-id="{{ $l->currency_id }}" {{ old('lender_id') == $l->id ? 'selected' : '' }}>{{ $l->lender_name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('lender_id'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('lender_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-4 col-form-label">Interest Rate</label>
                                        <div class="col-md-6">
                                            <input class="form-control-plaintext" id="interest-rate" name="interest_rate" value="{{ old('interest_rate') }}" readonly placeholder="---">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-4 col-form-label">Loan Amount</label>
                                        <div class="col-md-6">
                                            <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }} float-text-box" id="amount" name="amount" value="{{ old('amount') }}" placeholder="0.00">
                                            @if($errors->has('amount'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('amount') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="staticMiddleName" class="col-md-4 col-form-label">Payment Term</label>
                                        <div class="col-md-6">
                                            <select class="form-control {{ $errors->has('payment_term_id') ? 'is-invalid' : '' }}" id="payment-term-id" name="payment_term_id">
                                                <option style="display:none;" value="">Select a Payment Term</option>
                                                @foreach($paymentTerms as $p)
                                                    <option value="{{ $p->id }}" {{ old('payment_term_id') == $p->id ? 'selected' : '' }}>{{ $p->payment_term_name }}
                                                @endforeach
                                            </select>
                                            @if($errors->has('payment_term_id'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('payment_term_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{--<div class="form-group">--}}
                                        {{--<label class="col-md-4 col-form-label">Monthly Amortization</label>--}}
                                        {{--<div class="col-md-6">--}}
                                            {{--<input class="form-control-plaintext" id="monthly-amortization" name="monthly_amortization" value="" readonly />--}}
                                            {{--<br />--}}
                                            {{--<button class="btn btn-secondary" type="button" id="compute-amortization">Compute</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="terms-and-conditions">
                                                <label class="custom-control-label" for="terms-and-conditions">By clicking here you accept the <a href="#" data-toggle="modal" data-target="#terms-and-conditions-modal">Terms and Conditions.</a></label>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary" id="apply-for-a-loan" disabled>Apply for a Loan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('pages.merchant.terms-and-conditions-modal')
@endsection



