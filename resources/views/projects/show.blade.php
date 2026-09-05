@extends('layouts.app')

@section('styles')
<link href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-info">
                <div class="card-header">{{ $project->title }} Redirect URI</div>

                <div class="card-body">

                    <p>Use the following URI for your main autoresponder redirection (Thank You Page). Please make sure to pass the parameters (email) in your main autoresponder settings to this endpoint.</p>

                    <!-- Target -->
                    <div class="input-group">
                        <div class="input-group-prepend copy" style="cursor: pointer;" data-clipboard-target="#redirect_uri">
                            <div class="input-group-text">
                                <i class="fa fa-copy"></i>
                            </div>
                        </div>
                        <input class="form-control" id="redirect_uri" value="{{ url('/' . $project->code ) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-info">
                <div class="card-header">{{ $project->title }} Cron Job (Optional)</div>

                <div class="card-body">

                    <p>Use the following command for Cron Job IF needed.</p>

                    <!-- Target -->
                    <div class="input-group">
                        <div class="input-group-prepend copy" style="cursor: pointer;" data-clipboard-target="#cron_job">
                            <div class="input-group-text">
                                <i class="fa fa-copy"></i>
                            </div>
                        </div>
                        <input class="form-control" id="cron_job" value="wget -q -O /dev/null  {{ url('/sync/' . $project->code ) }} >/dev/null 2>&1">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $project->title }} Autoresponders</div>

                <div class="card-body">

                    <p>
                        <a href="{{ route('autoresponders.create', ['project' => $project->id]) }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add New Autoresponder
                        </a>
                    </p>

                    <div class="table-responsive">
                    <table class="table table-bordered" id="autoresponders-table">

                        <colgroup>
                            <col style="width: 5%">
                            <col style="width: 10%">
                            <col style="width: 15%">
                            <col style="width: 10%">
                            <col style="width: 15%">
                            <col style="width: 15%">
                            <col style="width: 5%">
                            <col style="width: 10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Provider</th>
                                <th>Name</th>
                                <th>Campaign</th>
                                <th>Public Key</th>
                                <th>Private Key</th>
                                <th>Enabled?</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script>
$(function() {
    $('#autoresponders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('projects.autoresponders.datatables', $project->id) !!}',
            type:'POST',
              'headers': {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'provider', name: 'provider' },
            { data: 'name', name: 'name' },
            { data: 'campaign', name: 'campaign' },
            { data: 'public_key', name: 'public_key' },
            { data: 'private_key', name: 'private_key' },
            { data: 'is_enabled', name: 'is_enabled' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        "ordering": true,
        "info": true,
        "autoWidth": false,
        order: [[0, "desc"]]
    });
});
</script>
@endsection
