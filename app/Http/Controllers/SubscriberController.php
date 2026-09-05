<?php

namespace App\Http\Controllers;

use App\Subscriber;
use App\Project;
use Illuminate\Http\Request;

use DataTables;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subscribers.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables()
    {
        $query = Subscriber::with('project')
        ->select([
            'subscribers.id',
            'subscribers.project_id',
            'subscribers.email',
            'subscribers.name',
            'subscribers.ip',
            'subscribers.browser',
            'subscribers.status',
            'subscribers.created_at'
        ]);

        return DataTables::of($query)
        ->addColumn('action', function ($item) {
            return view('subscribers.action', compact('item'));
        })
        ->rawColumns(['name', 'action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        #
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Autoresponder  $autoresponder
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Autoresponder  $autoresponder
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {

        $projects = Project::pluck('title', 'id');

        return view('subscribers.edit', compact('subscriber', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Autoresponder  $autoresponder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $data = $request->except('status');
        $data['status'] = $request->input('status', 0);

        $subscriber->update($data);

        return redirect()->back()->with('alert-success', 'Selected item has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Autoresponder  $autoresponder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('subscribers.index')->with('alert-success', 'Selected item has been deleted.');
    }
}
