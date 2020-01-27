@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-12">
                @include('includes/alert')
                @if(!empty($kycData) && $kycData->status == 'processing')
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">KYC Submitted</h4>
                        <p class="card-text"> Please wait for about n days for our agents to verify you account.</p>
                    </div>

                @elseif(!empty($kycData) && $kycData->status == 'on_hold')
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">KYC Held</h4>
                        <p class="card-text"> {{ $kycData->reject_reason }}</p>
                        <hr class="mb-3" />
                        <p class="card-text"> {{ $kycData->comment }}</p>
                    </div>
                @endif
                <div class="card">
                    <form action="{{ route('upload-kyc') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{--<div class="card-header">Merchant KYC</div>--}}
                        <div class="card-body">
{{--                            <input type="hidden" value="{{ $kycData-> }}"--}}
                            <h3><small class="text-black-50">Status:</small> <span class="badge {{ !empty($kycData->bootstrap_status_text_color_class) ? $kycData->bootstrap_status_text_color_class : 'badge-secondary'  }}">{{ !empty($kycData) ? ucfirst($kycData->status) : 'For Submission' }}</span></h3>

                            <div class="row">
                                <div class="col">
                                    <h4>Basic Info</h4>
                                    <hr class="m-2">
                                    <div class="form-group">
                                        <label for="staticFirstName" class="col-md-4 col-form-label">First Name</label>
                                        <div class="col-md-8">
                                            {{--<input class="form-control" id="staticFirstName" name="first_name" value="{{ old('first_name', $kycData->first_name) }}">--}}
                                            <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" name="first_name" value="{{ old('first_name', $kycData->first_name) }}" placeholder="First Name">
                                            @if($errors->has('first_name'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('first_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="staticMiddleName" class="col-md-4 col-form-label">Middle Name</label>
                                        <div class="col-md-8">
                                            {{--<input class="form-control" id="staticMiddleName" name="middle_name" value="{{ old('middle_name', $kycData->middle_name) }}">--}}

                                            <input type="text" class="form-control {{ $errors->has('middle_name') ? 'is-invalid' : '' }}" name="middle_name" value="{{ old('middle_name', $kycData->middle_name) }}" placeholder="Middle Name">
                                            @if($errors->has('middle_name'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('middle_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="staticLastName" class="col-md-4 col-form-label">Last Name</label>
                                        <div class="col-md-8">
                                            {{--<input class="form-control" id="staticLastName" name="last_name" value="{{ old('last_name', $kycData->last_name) }}">--}}
                                            <input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" name="last_name" value="{{ old('last_name', $kycData->last_name) }}" placeholder="Last Name">
                                            @if($errors->has('last_name'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('last_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-form-label">Email</label>
                                        <div class="col-md-8">
                                            {{--<input class="form-control" name="email" value="{{ old('email', $kycData->email) }}">--}}
                                            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email', $kycData->email) }}" placeholder="Email">
                                            @if($errors->has('email'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="staticDateOfBirth" class="col-md-4 col-form-label">Date of Birth</label>
                                        <div class="col-md-8">
                                            {{--<input class="form-control" id="staticDateOfBirth" value="{{ old('date_of_birth', $kycData->date_of_birth) }}">--}}
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" id="date-of-birth" name="date_of_birth" value="{{ old('date_of_birth', $kycData->date_of_birth) }}" placeholder="Date of Birth">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                            @if($errors->has('date_of_birth'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('date_of_birth') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="staticPlaceOfBirth" class="col-md-4 col-form-label">Place of Birth</label>
                                        <div class="col-md-8">
                                            {{--<input class="form-control" value="{{ old('place_of_birth', $kycData->date_of_birth) }}" name="place_of_birth">--}}

                                            <input type="text" class="form-control {{ $errors->has('place_of_birth') ? 'is-invalid' : '' }}" name="place_of_birth" value="{{ old('place_of_birth', $kycData->place_of_birth) }}" placeholder="Place of Birth">
                                            @if($errors->has('place_of_birth'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('place_of_birth') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="staticCountry" class="col-md-4 col-form-label">Country</label>
                                        <div class="col-md-8">
                                            <input type="text" readonly class="form-control-plaintext" id="staticCountry" value="{{ $kycData->nicename }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="staticNationality" class="col-md-4 col-form-label">Nationality</label>
                                        <div class="col-md-8">

                                            {{--<input type="text" readonly class="form-control-plaintext" id="staticAddress" value="{{ !empty(auth()->user()->nationality) ? auth()->user()->nationality->nationality : '' }}">--}}

                                            <select class="form-control {{ $errors->has('nationality_id') ? 'is-invalid' : '' }}" name="nationality_id">
                                                <option value="" selected>Select a Nationality</option>
                                                @foreach($nationalities as $n)
                                                    <option value="{{ $n->id }}" {{ $kycData->nationality_id == $n->id ? 'selected' : '' }}>{{ $n->nationality }}</option>
                                                @endforeach
                                            </select>

                                            @if($errors->has('nationality_id'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('nationality_id') }}
                                                </div>
                                            @endif


                                            {{--@if(!empty(auth()->user()->nationality))--}}
                                            {{--<input type="hidden" value="{{ auth()->user()->nationality_id }}">--}}
                                            {{--<input type="text" readonly class="form-control-plaintext" id="staticNationality" value="{{ auth()->user()->nationality->nationality }}">--}}
                                            {{--@else--}}
                                            {{--<select class="form-control select2 {{ $errors->has('nationality_id') ? 'is-invalid' : '' }}" name="nationality_id" data-placeholder="Select a Nationality">--}}
                                            {{--<option></option>--}}
                                            {{--@foreach($nationalities as $n)--}}
                                            {{--<option value="{{ $n->id }}" {{ old('nationality_id') !== NULL && old('nationality_id') == $n->nationality_id ? 'selected' : '' }}>{{ $n->nationality }}</option>--}}
                                            {{--@endforeach--}}
                                            {{--</select>--}}
                                            {{--@if($errors->has('nationality_id'))--}}
                                            {{--<div class="invalid-feedback d-block">--}}
                                            {{--{{ $errors->first('nationality_id') }}--}}
                                            {{--</div>--}}
                                            {{--@endif--}}
                                            {{--@endif--}}
                                        </div>
                                    </div>
                                    {{--<div class="form-group">--}}
                                        {{--<label for="staticAddress" class="col-md-4 col-form-label">Address</label>--}}
                                        {{--<div class="col-md-8">--}}
                                            {{--<input type="text" readonly class="form-control-plaintext" id="staticAddress" value="{{ auth()->user()->address }}">--}}
                                            {{--<input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" value="{{ old('address', auth()->user()->address) }}" placeholder="Address">--}}
                                            {{--@if($errors->has('address'))--}}
                                                {{--<div class="invalid-feedback d-block">--}}
                                                    {{--{{ $errors->first('address') }}--}}
                                                {{--</div>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}


                                    <div class="form-group">
                                        <label class="col-md-4 col-form-label">Province</label>
                                        <div class="col-md-8">
                                            {{--<input class="form-control-plaintext" value="{{ $kycData->date_of_birth }}" />--}}
                                            <select class="form-control {{ $errors->has('province_id') ? 'is-invalid' : '' }}" id="province-id" name="province_id">
                                                <option value="" style="display:none;" selected>Select a Province</option>
                                                @foreach($provinces as $p)
                                                    <option value="{{ $p->provCode }}" {{ $kycData->province_id == $p->provCode ? 'selected' : '' }}>{{ $p->provDesc }}</option>
                                                @endforeach
                                            </select>

                                            @if($errors->has('province_id'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('province_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-4 col-form-label">City</label>
                                        <div class="col-md-8">
                                            {{--                                            <input class="form-control-plaintext" value="{{ old('city_id', $kycData->citymunDesc) }}" />--}}
                                            <select class="form-control {{ $errors->has('city_id') ? 'is-invalid' : '' }}" id="city-id" name="city_id">
                                                <option value="" style="display:none;" selected>Select a City</option>
                                                @foreach($cities as $c)
                                                    <option value="{{ $c->id }}" {{ $kycData->city_id == $c->id ? 'selected' : '' }}>{{ $c->citymunDesc }}</option>
                                                @endforeach
                                            </select>

                                            @if($errors->has('city_id'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('city_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-4 col-form-label">Barangay</label>
                                        <div class="col-md-8">
                                            {{--<input class="form-control-plaintext" value="{{ old('brgy_id', $kycData->brgyDesc) }}" />--}}
                                            {{--<input type="text" class="form-control {{ $errors->has('brgy_id') ? 'is-invalid' : '' }}" name="place_of_birth" value="{{ old('place_of_birth', auth()->user()->place_of_birth) }}" placeholder="Place of Birth">--}}
                                            <select class="form-control {{ $errors->has('brgy_id') ? 'is-invalid' : '' }}" id="brgy-id" name="brgy_id">
                                                <option value="" style="display:none;" selected>Select a Barangay</option>
                                                @foreach($barangays as $b)
                                                    <option value="{{ $b->id }}" {{ $kycData->brgy_id == $b->id ? 'selected' : '' }}>{{ $b->brgyDesc }}</option>
                                                @endforeach
                                            </select>

                                            @if($errors->has('brgy_id'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('brgy_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-4 col-form-label">House No/Bldg./Street</label>
                                        <div class="col-md-8">
                                            {{--<input class="form-control-plaintext" readonly value="{{ old('house_no', $kycData->house_no) }}">--}}
                                            <input type="text" class="form-control {{ $errors->has('house_no') ? 'is-invalid' : '' }}" name="house_no" value="{{ old('house_no', $kycData->house_no) }}" placeholder="House No/Bldg/Street">
                                            @if($errors->has('house_no'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('house_no') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>



                                    {{--<div class="form-group">--}}
                                        {{--<label for="staticSourceOfIncome" class="col-md-4 col-form-label">Source of Income</label>--}}
                                        {{--<div class="col-md-8">--}}
                                            {{--<input type="text" readonly class="form-control-plaintext" id="staticSourceOfIncome" value="">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="form-group">
                                        <label for="staticMobileNumber" class="col-md-4 col-form-label">Mobile Number</label>
                                        <div class="col-md-8">
                                            {{--<input type="text" readonly class="form-control-plaintext" id="staticMobileNumber" value="{{ old('mobile_number', $kycData->mobile_number') }}">--}}
                                            <input type="text" class="form-control int-text-box {{ $errors->has('mobile_number') ? 'is-invalid' : '' }}" name="mobile_number" value="{{ old('mobile_number', $kycData->mobile_number) }}" placeholder="Mobile Number">
                                            @if($errors->has('mobile_number'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('mobile_number') }}
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="staticEstablishmentName" class="col-md-4 col-form-label">Establishment Name</label>
                                        <div class="col-md-8">
                                            {{--<input type="text" readonly class="form-control-plaintext" id="staticEstablishmentName" value="{{ old('establishment_name', $kycData->establishment_name) }}">--}}
                                            <input type="text" class="form-control {{ $errors->has('establishment_name') ? 'is-invalid' : '' }}" name="establishment_name" value="{{ old('establishment_name', $kycData->establishment_name) }}" placeholder="Establishment Name">
                                            @if($errors->has('establishment_name'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('establishment_name') }}
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="staticSourceOfIncome" class="col-md-4 col-form-label">What is the Loan for</label>
                                        <div class="col-md-8">
                                            {{--<input type="text" readonly class="form-control-plaintext" id="staticSourceOfIncome" value="{{ old('source_of_income', $kycData->source_of_income) }}">--}}
                                            <input type="text" class="form-control {{ $errors->has('source_of_income') ? 'is-invalid' : '' }}" name="source_of_income" value="{{ old('source_of_income', $kycData->source_of_income) }}" placeholder="What is the Loan for">
                                            @if($errors->has('source_of_income'))
                                                <div class="invalid-feedback d-block">
                                                    {{ $errors->first('source_of_income') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h4>KYC Documents</h4>
                                    <hr class="m-2">
                                    @foreach($kycDocuments as $k)
                                        <div class="form-group">
                                            <label>{{ $k->doc_name }}</label>
                                            <div class="col-md-6">
                                                @if(!empty($k->file))
                                                    <img src="{{ asset('storage/app/' . $k->file) }}" class="img-fluid rounded d-block" />
                                                    <br />

                                                    <div class="input-group mb-3">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input {{ $errors->has($k->name) ? 'is-invalid' : '' }}" name="{{ $k->name }}">
                                                            <label class="custom-file-label text-truncate">Choose file</label>
                                                        </div>
                                                        @if($errors->has($k->name))
                                                            <div class="invalid-feedback d-block">
                                                                {{ $errors->first($k->name) }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                @elseif($kycData->status == 'incomplete' || $kycData->status == 'submitted' || $kycData->status == 'on_hold')
                                                    <div class="input-group mb-3">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input {{ $errors->has($k->name) ? 'is-invalid' : '' }}" name="{{ $k->name }}">
                                                            <label class="custom-file-label text-truncate">Choose file</label>
                                                        </div>
                                                        @if($errors->has($k->name))
                                                            <div class="invalid-feedback d-block">
                                                                {{ $errors->first($k->name) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <hr class="mt-0">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="text-right">
{{--                                @if(empty($kycData->status) || $kycData->status == 'on_hold')--}}
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



