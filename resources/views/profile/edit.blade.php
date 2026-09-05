@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                <div class="card-body">

                    {!! Form::model(Auth::user(), ['route' => 'profile.update']) !!}
                    @method('patch')

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-10{{ $errors->has('name') ? ' is-invalid' : '' }}">

                            @if ( $errors->has('name') )
                            {!! Form::text('name', null, ['class' => 'form-control is-invalid', 'required', 'autofocus']) !!}
                            @else
                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'required', 'autofocus']) !!}
                            @endif

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-md-2 col-form-label text-md-right">{{ __('Username') }}</label>

                        <div class="col-md-10{{ $errors->has('username') ? ' is-invalid' : '' }}">

                            @if ( $errors->has('username') )
                            {!! Form::text('username', null, ['class' => 'form-control is-invalid', 'required', 'autofocus']) !!}
                            @else
                            {!! Form::text('username', null, ['class' => 'form-control', 'id' => 'username', 'required', 'autofocus']) !!}
                            @endif

                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('Email') }}</label>

                        <div class="col-md-10{{ $errors->has('email') ? ' is-invalid' : '' }}">

                            @if ( $errors->has('email') )
                            {!! Form::email('email', null, ['class' => 'form-control is-invalid', 'required', 'autofocus']) !!}
                            @else
                            {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email', 'required', 'autofocus']) !!}
                            @endif

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-10{{ $errors->has('password') ? ' is-invalid' : '' }}">

                            @if ( $errors->has('password') )
                            {!! Form::password('password', ['class' => 'form-control is-invalid', 'autofocus']) !!}
                            @else
                            {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'autofocus']) !!}
                            @endif

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
