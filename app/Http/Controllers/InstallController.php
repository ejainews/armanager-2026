<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Artisan;
use Str;
use App\User;


//Load file with Auto PHP Licenser settings
require_once(app_path("Helpers/account.php"));

//Load file with Auto PHP Licenser functions
require_once(app_path("Helpers/logout.php"));

class InstallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Schema::hasTable('user_data'))
        {
            alert_danger('The predator has already been installed. Please login to your account.');
            return redirect()->route('login');
        }

        return view('install.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeLicense(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $ROOT_URL = url('/');
        $CLIENT_EMAIL = $request->input('email');
        $LICENSE_CODE = '';

        //Function should be provided with root URL of this script, licensed email address/license code and MySQLi link (only when database is used).
        //Function will return array with 'notification_case' and 'notification_text' keys, where 'notification_case' contains action status and 'notification_text' contains action summary.
        $GLOBALS["mysqli"] = mysqli_connect(config('database.connections.mysql.host'), config('database.connections.mysql.username'), config('database.connections.mysql.password'), config('database.connections.mysql.database'), config('database.connections.mysql.port'));
        $license_notifications_array=aplInstallLicense($ROOT_URL, $CLIENT_EMAIL, $LICENSE_CODE, $GLOBALS["mysqli"]);
        

        if ($license_notifications_array['notification_case']!="notification_license_ok") //'notification_license_ok' case returned - operation succeeded
        {
            alert_danger('Installation failed because of this reason: ' . $license_notifications_array['notification_text']);
            return redirect()->back();
        }

        alert_success('Predator License is valid. Now please complete your Predator installation.');

        return redirect()->route('install.final');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function final()
    {
        if (Schema::hasTable('users'))
        {
            alert_danger('The predator has already been installed. Please login to your account.');
            return redirect()->route('login');
        }

        return view('install.final');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFinal(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed'
        ]);

        Artisan::call('migrate', array('--force' => true));

        $data = $request->except('password');
        $data['password'] = bcrypt($request->input('password'));
        $data['username'] = Str::random(6);

        User::create($data);

        alert_success('Predator database table installed successfully!');

        return redirect()->route('install.completed');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function completed()
    {
        return view('install.completed');
    }

    
}
