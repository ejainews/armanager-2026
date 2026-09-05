@extends('layouts.app')

@section('styles')
<link href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Subscribers</div>

                <div class="card-body">

                    <table class="table table-bordered" id="subscribers-table">

                        <colgroup>
                            <col style="width: 5%">
                            <col style="width: 15%">
                            <col style="width: 20%">
                            <col style="width: 20%">
                            <col style="width: 10%">
                            <col style="width: 5%">
                            <col style="width: 15%">
                            <col style="width: 10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Project</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>IP Address</th>
                                <th>Status</th>
                                <th>Added At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>

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
    $('#subscribers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('subscribers.datatables') !!}',
            type:'POST',
              'headers': {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        },
        columns: [
            { data: 'id', name: 'subscribers.id' },
            { data: 'project.title', name: 'project.title' },
            { data: 'email', name: 'subscribers.email' },
            { data: 'name', name: 'subscribers.name' },
            { data: 'ip', name: 'subscribers.ip' },
            { data: 'status', name: 'subscribers.status' },
            { data: 'created_at', name: 'subscribers.created_at' },
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
