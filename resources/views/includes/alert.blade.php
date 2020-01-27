{{--<div class="row">--}}
    @if (session('success'))
        <div class="alert alert-success" tabindex="-1">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" tabindex="-1">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->has('user'))
        <div class="alert alert-danger" tabindex="-1">
                @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
        </div>
    @endif
{{--</div>--}}