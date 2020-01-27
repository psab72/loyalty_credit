
<br />
<div class="d-flex align-items-center">
    <img class="mx-auto d-block" src="{{ asset('public/imgs/LClogo1.png') }}" width="100"/>
</div>
<br />
<br />
<div class="d-flex text-center align-items-center">
    <h5>Thanks, What is your birthdate
        <br /> and birthplace?</h5>
</div>
<br />
<br />
<br />

<div class="form-group row">
    {{--<label for="last-name" class="col-md-5 col-form-label text-md-right">{{ __('Last Name') }}</label>--}}

    <div class="col-md-12">
        <input id="date-of-birth" type="text" class="form-control datepicker" name="date_of_birth" required placeholder="Date of birth">
    </div>
</div>

<div class="form-group row">
    {{--<label for="last-name" class="col-md-5 col-form-label text-md-right">{{ __('Last Name') }}</label>--}}

    <div class="col-md-12">
        <input id="place-of-birth" type="text" class="form-control" name="place_of_birth" required placeholder="Place of birth">
    </div>
</div>