
<div class="form-group row">
    <label for="title" class="col-md-2 col-form-label text-md-right">{{ __('Project Title') }}</label>

    <div class="col-md-10{{ $errors->has('title') ? ' is-invalid' : '' }}">

        @if ( $errors->has('title') )
        {!! Form::text('title', null, ['class' => 'form-control is-invalid', 'required', 'autofocus']) !!}
        @else
        {!! Form::text('title', null, ['class' => 'form-control', 'required', 'autofocus']) !!}
        @endif

        @if ($errors->has('title'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="code" class="col-md-2 col-form-label text-md-right">{{ __('Form Code') }}</label>

    <div class="col-md-10{{ $errors->has('code') ? ' is-invalid' : '' }}">

        @if ( $errors->has('code') )
        {!! Form::text('code', null, ['class' => 'form-control is-invalid', 'required', 'autofocus']) !!}
        @else
        {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'code', 'required', 'autofocus']) !!}
        @endif

        @if ($errors->has('code'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('code') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="redirect_uri" class="col-md-2 col-form-label text-md-right">{{ __('Redirect URI') }}</label>

    <div class="col-md-10{{ $errors->has('redirect_uri') ? ' is-invalid' : '' }}">

        @if ( $errors->has('redirect_uri') )
        {!! Form::text('redirect_uri', null, ['class' => 'form-control is-invalid', 'required', 'autofocus']) !!}
        @else
        {!! Form::text('redirect_uri', null, ['class' => 'form-control', 'id' => 'redirect_uri', 'required', 'autofocus']) !!}
        @endif

        @if ($errors->has('redirect_uri'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('redirect_uri') }}</strong>
            </span>
        @endif

    </div>
</div>