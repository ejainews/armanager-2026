<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AutoresponderRequest;

use App\Autoresponder;
use App\Project;
use App\Server;

use DataTables;

class AutoresponderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoresponders.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables()
    {
        $query = Autoresponder::with('project')
        ->select([
            'autoresponders.id',
            'autoresponders.project_id',
            'autoresponders.provider',
            'autoresponders.name',
            'autoresponders.campaign',
            'autoresponders.public_key',
            'autoresponders.private_key',
            'autoresponders.is_enabled'
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::pluck('title', 'id');

        $providers = Server::pluck('name', 'slug');

        return view('autoresponders.create', compact('projects', 'providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AutoresponderRequest $request)
    {
        $data = $request->all();

        Autoresponder::create($data);

        alert_success('New item has been added!');

        return redirect()->route('autoresponders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Autoresponder  $autoresponder
     * @return \Illuminate\Http\Response
     */
    public function show(Autoresponder $autoresponder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Autoresponder  $autoresponder
     * @return \Illuminate\Http\Response
     */
    public function edit(Autoresponder $autoresponder)
    {
        $projects = Project::pluck('title', 'id');

        $providers = Server::pluck('name', 'slug');

        return view('autoresponders.edit', compact('autoresponder', 'projects', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Autoresponder  $autoresponder
     * @return \Illuminate\Http\Response
     */
    public function update(AutoresponderRequest $request, Autoresponder $autoresponder)
    {
        $data = $request->all();
        $data['is_enabled'] = $request->input('is_enabled', 0);

        $autoresponder->update($data);

        return redirect()->back()->with('alert-success', 'Selected item has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Autoresponder  $autoresponder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Autoresponder $autoresponder)
    {
        $autoresponder->delete();

        return redirect()->route('autoresponders.index')->with('alert-success', 'Selected item has been deleted.');
    }
}
