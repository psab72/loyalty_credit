
<br />
<div class="d-flex align-items-center">
    <img class="mx-auto d-block" src="{{ asset('public/imgs/LClogo1.png') }}" width="100"/>
</div>
<br />
<br />
<div class="d-flex text-center align-items-center">
    <h3>What is your nationality?</h3>
</div>
<br />
<br />
<br />

<div class="form-group row">
    {{--<label for="last-name" class="col-md-5 col-form-label text-md-right">{{ __('Last Name') }}</label>--}}

    <div class="col-md-12">
        <select id="nationality-id" class="form-control select2" name="nationality_id" required>
            <option></option>
            @foreach($nationalities as $n)
                <option value="{{ $n->id }}" {{ $n->id == 66 ? 'selected' : '' }}>{{ $n->nationality }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
    {{--<label for="last-name" class="col-md-5 col-form-label text-md-right">{{ __('Last Name') }}</label>--}}

    <div class="col-md-12">
        <input id="source-of-income" type="text" class="form-control" name="source_of_income" required placeholder="What is the Loan for">
    </div>
</div>