<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.head')
</head>&nbsp;
@php
    if(!empty(auth()->user()->role_id) && auth()->user()->role_id == 4) {
        $countNotifs = \App\Model\Notification::where('merchant_id', auth()->user()->id)->where('is_read', 0)->count();
        $notifications = \App\Model\Notification::where('merchant_id', auth()->user()->id)->where('is_read', 0)->orderBy('created_at', 'desc')->take(5)->get();
    } elseif(!empty(auth()->user()->role_id)){
        $countNotifs = \App\Model\Notification::whereNull('merchant_id')->where('is_read', 0)->count();
        $notifications = \App\Model\Notification::whereNull('merchant_id')->orderBy('created_at', 'desc')->take(5)->get();
    }
@endphp
<body class="app header-fixed">
    @if(!in_array(request()->segment(1), ['login', 'register']))
        <header class="navbar navbar-expand-md navbar-light bg-light" style="box-shadow: 0px 0.5px 15px grey;">
            <a class="navbar-brand" href="#">
                {{--Navbar--}}
                <img width="160" src="{{ asset('public/imgs/LC.png') }}" class="img-fluid" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                @if (auth()->check())
                    @if (in_array(auth()->user()->role_id, [config('constants.roles.admin'), config('constants.roles.super_user')]))
                        <li class="nav-item px-3 {{ request()->segment(1) == 'dashboard-admin' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('dashboard-admin') }}">Dashboard</a>
                        </li>
                        <li class="nav-item px-3 {{ in_array(request()->segment(1), ['users']) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('users') }}">Users</a>
                        </li>
                        <li class="nav-item px-3 {{ in_array(request()->segment(1), ['dashboard-merchants', 'merchant']) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('dashboard-merchants') }}">Merchants</a>
                        </li>
                    @endif

                    @if(in_array(auth()->user()->role_id, [config('constants.roles.merchant')]))
                        <li class="nav-item px-3 {{ request()->segment(1) == 'dashboard-merchant' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard-merchant') }}">Dashboard</a>
                        </li>
                        <li class="nav-item px-3 {{ request()->segment(1) == 'credit-request' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('credit-request') }}">Request Loan</a>
                        </li>
                    @else
                        <li class="nav-item px-3 {{ request()->segment(1) == 'loan-requests' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('loan-requests') }}">Loans</a>
                        </li>
                    @endif


                    <form>
                        @csrf
                    <li class="nav-item dropdown px-3 notifications">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i>
                            @if(!empty($countNotifs))
                            <span class="badge badge-pill badge-danger badge-notifications">{{ $countNotifs }}</span>
                            @endif
                        </a>
                        {{--@if(!empty($countNotifs))--}}
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                {{--<a class="dropdown-item dropdown-menu-left" href="#">test  <span><small>testess</small></span></a>--}}

                                @foreach($notifications as $i => $n)
                                    <a class="dropdown-item dropdown-menu-left {{ $n->is_read == 0 ? 'active' : '' }}" href="#">{{ $n->message }}  <span><small>{{ date('M d, Y h:i:sa', strtotime($n->created_at)) }}</small></span></a>
                                @endforeach
                            </div>
                        {{--@endif--}}
                    </li>

                    </form>


                @endif

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ auth()->user()->first_name }}
                            <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if(auth()->user()->role_id == config('constants.roles.merchant'))
                                <a class="dropdown-item" href="{{ route('kyc') }}">Profile</a>
                                <a class="dropdown-item" href="{{ url('user/' . auth()->user()->id) }}">Change Password</a>
                                {{--<a class="dropdown-item" href="{{ route('notification') }}">Notifications</a>--}}
                            @endif

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                </ul>
            </div>
        </header>

    {{--<header class="app-header navbar navbar-expand-lg bg-light">--}}
        {{--<!-- Header content here -->--}}
        {{--<a class="navbar-brand" href="{{ url('/') }}"> <img alt="{{ config('app.name', 'Loyalty Credit') }}" style='height: 100%; width: 100%; object-fit: contain' src="{{ asset('public/imgs/LClogo1.png') }}" /></a>--}}
        {{--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">--}}
            {{--<span class="navbar-toggler-icon"></span>--}}
        {{--</button>--}}
        {{--<div class="collapse navbar-collapse" id="navbarNavAltMarkup">--}}

        {{--</div>--}}
    {{--</header>--}}
    @endif

    <div class="app-body" style="margin-top: 16px;  !important">
        {{--<div class="sidebar">--}}
            <!-- Sidebar content here -->
            {{--@include('includes/sidebar')--}}
        {{--</div>--}}
        <main class="main">
            <!-- Main content here -->
            @yield('content')
        </main>
    </div>
    <footer class="app-footer">
        <div>
            <a href="{{ url('/') }}">Loyalty Credit</a>
            <span>© {{ date('Y') }}.</span>
        </div>
        {{--<div class="ml-auto">--}}
            {{--<span>Powered by</span>--}}
            {{--<a href="https://coreui.io/pro/">CoreUI Pro</a>--}}
        {{--</div>--}}
    </footer>
    <!-- Scripts -->
    @include ('includes/scripts')
</body>
</html>
