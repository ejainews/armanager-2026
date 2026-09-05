<a href="{{ route('projects.show', $item->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-folder-open"></i></a>

<a href="{{ route('projects.subscribers.index', $item->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-users"></i></a>

<a href="{{ route('projects.edit', $item->id) }}" class="btn btn-xs btn-secondary"><i class="fa fa-edit"></i></a>

<!-- Button trigger modal -->
<button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modal-replicate-{{ $item->id }}">
    <i class="fa fa-copy"></i>
</button>

{!! Form::open(['route' => ['projects.replicate', $item->id]]) !!}
<!-- Modal -->
<div class="modal fade" id="modal-replicate-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-replicate-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Replicate Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Are you sure to replicate the following item?</p>

                <ul>
                    <li>{{ $item->title }}</li>
                </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Clone</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

<!-- Button trigger modal -->
<button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-delete-{{ $item->id }}">
    <i class="fa fa-trash"></i>
</button>

{!! Form::open(['method' => 'delete', 'route' => ['projects.destroy', $item->id]]) !!}
<!-- Modal -->
<div class="modal fade" id="modal-delete-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-delete-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Are you sure to delete the following item?</p>

                <ul>
                    <li>{{ $item->title }}</li>
                </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
