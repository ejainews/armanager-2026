@extends('layouts.app')

@section('styles')
<link href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Autoresponders</div>

                <div class="card-body">

                    <p>
                        <a href="{{ route('autoresponders.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add New Autoresponder
                        </a>
                    </p>
                    <div class="table-responsive">
                    <table class="table table-bordered" id="autoresponders-table">

                        <colgroup>
                            <col style="width: 5%">
                            <col style="width: 15%">
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
                                <th>Project</th>
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
            url: '{!! route('autoresponders.datatables') !!}',
            type:'POST',
              'headers': {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        },
        columns: [
            { data: 'id', name: 'autoresponders.id' },
            { data: 'project.title', name: 'project.title' },
            { data: 'provider', name: 'autoresponders.provider' },
            { data: 'name', name: 'autoresponders.name' },
            { data: 'campaign', name: 'autoresponders.campaign' },
            { data: 'public_key', name: 'autoresponders.public_key' },
            { data: 'private_key', name: 'autoresponders.private_key' },
            { data: 'is_enabled', name: 'autoresponders.is_enabled' },
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
