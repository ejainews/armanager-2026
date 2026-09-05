<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use Str;

use App\Project;
use App\Autoresponder;
use App\Subscriber;
use DataTables;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('projects.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables()
    {
        $query = Project::select([
            'id',
            'title',
            'code',
            'redirect_uri',
            'created_at'
        ]);

        return DataTables::of($query)
        ->editColumn('title', function ($item) {
            return '<a href="'.route('projects.show', $item->id).'">'.$item->title.'</a>';
        })
        ->editColumn('redirect_uri', function ($item) {
            return '<a href="'.$item->redirect_uri.'">'.$item->redirect_uri.'</a>';
        })
        ->addColumn('action', function ($item) {
            return view('projects.action', compact('item'));
        })
        ->rawColumns(['title', 'redirect_uri', 'action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->all();

        Project::create($data);

        alert_success('New item has been added!');

        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->all();

        $project->update($data);

        alert_success('Record has been updated!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('alert-success', 'Selected item has been deleted.');
    }

    /**
     * Replicate the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function replicate(Request $request, Project $project)
    {
        # copy attributes from original model except code
        $new_project = $project->replicate(['code', 'title']);
        # set status value
        $new_project->code = Str::random(8);
        $new_project->title = $project->title . ' (replicated)';

        # save model before you recreate relations (so it has an id)
        $new_project->push();

        # reset relations on EXISTING MODEL (this way you can control which ones will be loaded
        $project->relations = [];

        # load relations on EXISTING MODEL
        $project->load('autoresponders');

        # re-sync the child relationships
        $relations = $project->getRelations();

        foreach ($relations as $item) {
            foreach ($item as $relation) {
                $new_relationship = $relation->replicate();
                $new_relationship->project_id = $new_project->id;
                $new_relationship->push();
            }
        }

        alert_success('The selected item has been replicated!');

        return redirect()->back();
    }
}
