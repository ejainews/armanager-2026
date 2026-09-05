@extends('layouts.app')

@section('styles')
<link href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Projects</div>

                <div class="card-body">

                    <p>
                        <a href="{{ route('projects.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add New Project
                        </a>
                    </p>

                    <table class="table table-bordered" id="projects-table">

                        <colgroup>
                            <col style="width: 5%">
                            <col style="width: 15%">
                            <col style="width: 15%">
                            <col style="width: 30%">
                            <col style="width: 20%">
                            <col style="width: 15%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Code</th>
                                <th>Redirect URI</th>
                                <th>Created At</th>
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
    $('#projects-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('projects.datatables') !!}',
            type:'POST',
              'headers': {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'code', name: 'code' },
            { data: 'redirect_uri', name: 'redirect_uri' },
            { data: 'created_at', name: 'created_at' },
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
