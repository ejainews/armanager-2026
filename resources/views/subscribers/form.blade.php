
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
    <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Name') }}</label>

    <div class="col-md-9{{ $errors->has('name') ? ' is-invalid' : '' }}">

        @if ( $errors->has('name') )
        {!! Form::text('name', null, ['class' => 'form-control is-invalid', 'autofocus']) !!}
        @else
        {!! Form::text('name', null, ['class' => 'form-control', 'autofocus']) !!}
        @endif

        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('Email') }}</label>

    <div class="col-md-9{{ $errors->has('email') ? ' is-invalid' : '' }}">

        @if ( $errors->has('email') )
        {!! Form::email('email', null, ['class' => 'form-control is-invalid', 'required', 'autofocus']) !!}
        @else
        {!! Form::text('email', null, ['class' => 'form-control', 'required', 'autofocus']) !!}
        @endif

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="ip" class="col-md-3 col-form-label text-md-right">{{ __('IP Address') }}</label>

    <div class="col-md-9{{ $errors->has('ip') ? ' is-invalid' : '' }}">

        @if ( $errors->has('ip') )
        {!! Form::text('ip', null, ['class' => 'form-control is-invalid', 'autofocus']) !!}
        @else
        {!! Form::text('ip', null, ['class' => 'form-control', 'required', 'autofocus']) !!}
        @endif

        @if ($errors->has('ip'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('ip') }}</strong>
            </span>
        @endif

    </div>
</div>

<div class="form-group row">
    <label for="status" class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>

    <div class="col-md-9{{ $errors->has('status') ? ' is-invalid' : '' }}">

        {!! Form::checkbox('status', 1) !!} Tick to change status to 1 (completed)

        @if ($errors->has('status'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('status') }}</strong>
            </span>
        @endif

    </div>
</div>