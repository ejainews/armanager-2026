<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (session('alert-success'))
            <div class="alert alert-success">
            {!! session('alert-success') !!}
            </div>
            @endif

            @if (session('alert-danger'))
            <div class="alert alert-danger">
            {!! session('alert-danger') !!}
            </div>
            @endif

        </div>
    </div>
</div>
