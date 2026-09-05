@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('ARManager Installation') }}</div>

                <div class="card-body">

                    @include('layouts.alerts')

                    <p class="text-center">Installation Completed!.</p>
                    <p class="text-center">You can now login to the admin area using the following details.</p>
                    <ul>
                        <li>URL: <a href="{{ route('login') }}">{{ route('login') }}</a></li>
                        <li>Login ID: Your entered email address on previous page.</li>
                        <li>Password: Your entered password on previous page.</li>
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
