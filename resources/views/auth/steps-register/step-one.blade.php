<br />
<div class="d-flex align-items-center">
    <img class="mx-auto d-block" src="{{ asset('public/imgs/LClogo1.png') }}" width="200"/>
</div>
<br />
<br />
<div class="d-flex text-center align-items-center">
    <h3>SIGN UP FOR A FREE ACCOUNT!</h3>
</div>
<br />
<br />
<br />
<div class="form-group row">
    {{--<label for="first-name" class="col-md-5 col-form-label text-md-right">{{ __('First Name') }}</label>--}}

    <div class="col-md-12">
        <input id="email" class="form-control" name="email" required placeholder="Email">
        {{--<div class="float-md-right">--}}
            {{--<a href="#">Sign up with mobile number instead</a>--}}
        {{--</div>--}}
    </div>
</div>

<div class="form-group row">
    {{--<label for="middle-name" class="col-md-5 col-form-label text-md-right">{{ __('Middle Name') }}</label>--}}

    <div class="col-md-12">
        <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
    </div>
</div>