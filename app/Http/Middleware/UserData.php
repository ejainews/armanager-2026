<?php

namespace App\Http\Middleware;

use Closure;

//Load file with Auto PHP Licenser settings
require_once(app_path("Helpers/account.php"));

//Load file with Auto PHP Licenser functions
require_once(app_path("Helpers/logout.php"));

class UserData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Check if configuration file is genuine
        if (APL_INCLUDE_KEY_CONFIG!='cd111d677b00daf6') //Secret key modified
        {
            \Auth::logout();
            alert_danger('Unauthorized modification detected! Please beware. Your hosting will be wiped out! Code: 01');
            return redirect()->route('login');
        }


        //Check if hash value of "app/Helpers/logout.php" matches previously calculated value
        if (md5_file(app_path('Helpers/logout.php'))!='d6b7d6237bb680e488e8dfc825b4c8c7' || md5_file(app_path('Helpers/account.php'))!='0d02e10e7c385dc120e2d963e7bc1e9d') //Checksum doesn't match
        {
            \Auth::logout();
            alert_danger('Unauthorized modification detected! Please beware. Your hosting will be wiped out! Code: 02');
            return redirect()->route('login');
        }

        /*
        -----------------------------------------------------------------------------------------------------------------
        START OF REQUIRED AUTO PHP LICENSER LICENSE VERIFICATION FUNCTIONS. YOU SHOULD ADD THIS CODE TO YOUR SCRIPT.
        -----------------------------------------------------------------------------------------------------------------
        */

        //Function can be provided with MySQLi link (only when database is used).
        //Function will return array with 'notification_case' and 'notification_text' keys, where 'notification_case' contains action status and 'notification_text' contains action summary.
        $GLOBALS["mysqli"] = mysqli_connect(config('database.connections.mysql.host'), config('database.connections.mysql.username'), config('database.connections.mysql.password'), config('database.connections.mysql.database'), config('database.connections.mysql.port'));

        $license_notifications_array=aplVerifyLicense($GLOBALS["mysqli"], 0); //$FORCE_VERIFICATION value set to 1 in this script for demo purposes only. A value of 0 should always be used in real-life scripts.

        if ($license_notifications_array['notification_case']!="notification_license_ok") //'notification_license_ok' case returned - operation succeeded
        {
            \Auth::logout();
            alert_danger('Predator license verification failed because of this reason: ' . $license_notifications_array['notification_text']);
            return redirect()->route('login');
        }

        /*
        -----------------------------------------------------------------------------------------------------------------
        END OF REQUIRED AUTO PHP LICENSER LICENSE VERIFICATION FUNCTIONS. YOU SHOULD ADD THIS CODE TO YOUR SCRIPT.
        -----------------------------------------------------------------------------------------------------------------
        */

        return $next($request);
    }
}
