
<br />
<div class="d-flex align-items-center">
    <img class="mx-auto d-block" src="{{ asset('public/imgs/LClogo1.png') }}" width="100"/>
</div>
<br />
<br />
<div class="d-flex text-center align-items-center">
    <h3>What is your current address?</h3>
</div>
<br />
<br />
<br />

<div class="form-group row">
    {{--<label for="last-name" class="col-md-5 col-form-label text-md-right">{{ __('Last Name') }}</label>--}}

    <div class="col-md-12">
        <input id="house-no" type="text" class="form-control" name="house_no" required placeholder="House No/Bldg/Street">
    </div>
</div>

<div class="form-group row">
    {{--<label for="last-name" class="col-md-5 col-form-label text-md-right">{{ __('Last Name') }}</label>--}}

    <div class="col-md-12">
        <select id="province-id" class="form-control" name="province_id">
            <option value="" style="display:none;" selected>Select a province</option>
            @foreach($provinces as $p)
                <option value="{{ $p->provCode }}">{{ $p->provDesc }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
    {{--<label for="last-name" class="col-md-5 col-form-label text-md-right">{{ __('Last Name') }}</label>--}}

    <div class="col-md-12">
        <select id="city-id" class="form-control" name="city_id">
            <option value="" style="display:none;" selected>Select a city</option>
        </select>
    </div>
</div>

<div class="form-group row">
    {{--<label for="last-name" class="col-md-5 col-form-label text-md-right">{{ __('Last Name') }}</label>--}}

    <div class="col-md-12">
        <select id="brgy-id" class="form-control" name="brgy_id">
            <option value="" style="display:none;" selected>Select a Barangay</option>
        </select>
    </div>
</div>