<?php

namespace App\Http\Controllers;

use App\Project;
use App\Subscriber;
use Illuminate\Http\Request;

use DataTables;

class ProjectSubscriberController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        return view('project-subscribers.index', compact('project'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables(Project $project)
    {
        $query = $project->subscribers()
        ->select([
            'id',
            'email',
            'name',
            'ip',
            'browser',
            'status',
            'created_at'
        ]);

        return DataTables::of($query)
        ->addColumn('action', function ($item) {
            return view('subscribers.action', compact('item'));
        })
        ->rawColumns(['name', 'action'])
        ->make(true);
    }
}
