@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-md-12">
            @include('includes/alert')
            <div class="card">
                <form action="{{ url('update-user') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $userData->id }}" />
                    {{--<div class="card-header">Merchant KYC</div>--}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h4>Basic Info</h4>
                                <hr class="m-2">
                                {{--<div class="form-group">--}}
                                    {{--<label for="staticFirstName" class="col-md-4 col-form-label">First Name</label>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<input class="form-control" id="staticFirstName" name="first_name" value="{{ old('first_name', $userData->first_name) }}">--}}
                                        {{--<input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" name="first_name" value="{{ old('first_name', $userData->first_name) }}" placeholder="First Name">--}}
                                        {{--@if($errors->has('first_name'))--}}
                                        {{--<div class="invalid-feedback d-block">--}}
                                            {{--{{ $errors->first('first_name') }}--}}
                                        {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="staticLastName" class="col-md-4 col-form-label">Last Name</label>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<input class="form-control" id="staticLastName" name="last_name" value="{{ old('last_name', $userData->last_name) }}">--}}
                                        {{--<input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" name="last_name" value="{{ old('last_name', $userData->last_name) }}" placeholder="Last Name">--}}
                                        {{--@if($errors->has('last_name'))--}}
                                        {{--<div class="invalid-feedback d-block">--}}
                                            {{--{{ $errors->first('last_name') }}--}}
                                        {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label class="col-md-4 col-form-label">Email</label>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<input class="form-control" name="email" value="{{ old('email', $userData->email) }}">--}}
                                        {{--<input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email', $userData->email) }}" placeholder="Email">--}}
                                        {{--@if($errors->has('email'))--}}
                                        {{--<div class="invalid-feedback d-block">--}}
                                            {{--{{ $errors->first('email') }}--}}
                                        {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                <div class="form-group">
                                    <label class="col-md-4 col-form-label">Password</label>
                                    <div class="col-md-8">
                                        {{--<input type="password" class="form-control" name="password" value="{{ old('email', $userData->email) }}">--}}
                                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" value="" placeholder="Password">
                                        @if($errors->has('password'))
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('password') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="text-right">
                            {{--                                @if(empty($userData->status) || $userData->status == 'on_hold')--}}
                            <button type="submit" class="btn btn-primary">Submit</button>
                            {{--@endif--}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



