
<div class="form-group row">
    <label for="project_id" class="col-md-3 col-form-label text-md-right">{{ __('Project') }}</label>

    <div class="col-md-9{{ $errors->has('project_id') ? ' is-invalid' : '' }}">

        {!! Form::select('project_id', $projects, request('project'), ['class' => 'form-control select2', 'required', 'autofocus', 'style' => 'width:100%']) !!}

        @if ($errors->has('project_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('project_id') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="provider" class="col-md-3 col-form-label text-md-right">{{ __('Provider') }}</label>

    <div class="col-md-9{{ $errors->has('provider') ? ' is-invalid' : '' }}">

        {!! Form::select('provider', $providers, null, ['class' => 'form-control select2', 'required', 'autofocus', 'style' => 'width:100%']) !!}

        @if ($errors->has('provider'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('provider') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Autoresponder name') }}</label>

    <div class="col-md-9{{ $errors->has('name') ? ' is-invalid' : '' }}">

        @if ( $errors->has('name') )
        {!! Form::text('name', null, ['class' => 'form-control is-invalid', 'required', 'autofocus']) !!}
        @else
        {!! Form::text('name', null, ['class' => 'form-control', 'required', 'autofocus']) !!}
        @endif

        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="api_uri" class="col-md-3 col-form-label text-md-right">{{ __('API URI') }}</label>

    <div class="col-md-9{{ $errors->has('api_uri') ? ' is-invalid' : '' }}">

        {!! Form::text('api_uri', null, ['class' => 'form-control', 'autofocus']) !!}

        @if ($errors->has('api_uri'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('api_uri') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="campaign" class="col-md-3 col-form-label text-md-right">{{ __('Campaign') }}</label>

    <div class="col-md-9{{ $errors->has('campaign') ? ' is-invalid' : '' }}">

        @if ( $errors->has('campaign') )
        {!! Form::text('campaign', null, ['class' => 'form-control is-invalid', 'required', 'autofocus']) !!}
        @else
        {!! Form::text('campaign', null, ['class' => 'form-control', 'required', 'autofocus']) !!}
        @endif

        @if ($errors->has('campaign'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('campaign') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="public_key" class="col-md-3 col-form-label text-md-right">{{ __('Public Key') }}</label>

    <div class="col-md-9{{ $errors->has('public_key') ? ' is-invalid' : '' }}">

        {!! Form::text('public_key', null, ['class' => 'form-control', 'autofocus']) !!}

        @if ($errors->has('public_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('public_key') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="private_key" class="col-md-3 col-form-label text-md-right">{{ __('Private Key') }}</label>

    <div class="col-md-9{{ $errors->has('private_key') ? ' is-invalid' : '' }}">

        {!! Form::text('private_key', null, ['class' => 'form-control', 'autofocus']) !!}   

        @if ($errors->has('private_key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('private_key') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="is_enabled" class="col-md-3 col-form-label text-md-right">{{ __('Enabled?') }}</label>

    <div class="col-md-9{{ $errors->has('is_enabled') ? ' is-invalid' : '' }}">

        {!! Form::checkbox('is_enabled', 1) !!} Tick to enable this autoresponder

        @if ($errors->has('is_enabled'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('is_enabled') }}</strong>
            </span>
        @endif

    </div>
</div>