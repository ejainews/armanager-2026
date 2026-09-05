@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Projects</div>

                <div class="card-body">

                    {!! Form::open(['route' => 'projects.store']) !!}

                    @include('projects.form')

                    <div class="form-group row mb-0">
                        <div class="col-md-10 offset-md-2">
                            <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                                {{ __('Back') }}
                            </a>
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

@section('scripts')
<script>
var random_code = function ()
{
  return Math.random().toString(36).substr(2);
}
$( document ).ready(function() {

    if( !$('#code').val() ) {
        $('#code').val(random_code);
    }

});
</script>
@endsection
