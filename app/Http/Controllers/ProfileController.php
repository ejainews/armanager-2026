<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = request()->validate([
            'name' => 'required|min:3',
            'username' => 'required|min:3|alpha_num',
            'email' => 'required|email'
        ]);

        $user = Auth::user();

        if ( !empty( $request->input('password') ) )
        {
            $data['password'] = bcrypt($request->input('password'));
        }

        $user->update($data);

        alert_success('The record has been updated!');

        return redirect()->back();
    }
}
