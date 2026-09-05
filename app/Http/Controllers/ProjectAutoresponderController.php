<?php

namespace App\Http\Controllers;

use App\Project;
use App\Autoresponder;
use Illuminate\Http\Request;

use DataTables;

class ProjectAutoresponderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables(Project $project)
    {
        $query = $project->autoresponders()
        ->select([
            'id',
            'project_id',
            'provider',
            'name',
            'campaign',
            'public_key',
            'private_key',
            'is_enabled'
        ]);

        return DataTables::of($query)
        ->addColumn('action', function ($item) {
            return view('autoresponders.action', compact('item'));
        })
        ->editColumn('is_enabled', function ($item) {
            if( $item->is_enabled == false )
            {
                return '<span class="btn btn-sm btn-secondary"><i class="fa fa-times"></i></span>';
            }
            return '<span class="btn btn-sm btn-success"><i class="fa fa-check"></i></span>';
        })
        ->rawColumns(['name', 'is_enabled', 'action'])
        ->make(true);
    }

}
