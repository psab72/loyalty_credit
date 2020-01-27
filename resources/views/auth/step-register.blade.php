@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form id="form-steps">
                @csrf
                <div id="smartwizard">
                    <ul>
                        {{--<li><a href="#step-1">Step Title<br /><small>Step description</small></a></li>--}}
                        {{--<li><a href="#step-2">Step Title<br /><small>Step description</small></a></li>--}}
                        {{--<li><a href="#step-3">Step Title<br /><small>Step description</small></a></li>--}}
                        {{--<li><a href="#step-4">Step Title<br /><small>Step description</small></a></li>--}}
                        {{--<li><a href="#step-5">Step Title<br /><small>Step description</small></a></li>--}}

                        <li><a href="#step-1"></a></li>
                        <li><a href="#step-2"></a></li>
                        <li><a href="#step-3"></a></li>
                        <li><a href="#step-4"></a></li>
                        <li><a href="#step-5"></a></li>
                        <li><a href="#step-6"></a></li>
                    </ul>

                    <div>
                        <div id="step-1" class="">
                            @include('auth.steps-register.step-one')
                        </div>
                        <div id="step-2" class="">
                            @include('auth.steps-register.step-two')
                        </div>
                        <div id="step-3" class="">
                            @include('auth.steps-register.step-three')
                        </div>
                        <div id="step-4" class="">
                            @include('auth.steps-register.step-four')
                        </div>
                        <div id="step-5" class="">
                            @include('auth.steps-register.step-five')
                        </div>
                        <div id="step-6" class="">
                            @include('auth.steps-register.step-six')
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
