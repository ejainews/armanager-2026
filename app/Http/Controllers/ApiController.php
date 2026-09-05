<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Autoresponder;
use App\Project;
use App\Subscriber;
use GuzzleHttp\Client;
use App\Helpers\GetResponse;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $code)
    {
        # Find project based on code given
        $project = Project::where('code', '=', $code)
        ->firstOrFail();

        if ($request->has('email'))
        {
            $email = $request->input('email');

            # Validate subscriber existance
            $subscriber = Subscriber::where('project_id', '=', $project->id)
            ->where('email', '=', $email)
            ->count();

            if ($subscriber > 0)
            {
                return redirect()->away($project->redirect_uri . '?email=' . $email);
            }

            # Validate email
            if (filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                # Get subscribers information
                $data['project_id'] = $project->id;
                $data['email'] = $email;
                $data['name'] = $request->input('name');
                $data['ip'] = $request->ip();
                $data['browser'] = $_SERVER['HTTP_USER_AGENT'];
                $data['status'] = 0; # zero status means not yet sync with all AR

                Subscriber::create($data);
            }
        }

        return redirect()->away($project->redirect_uri . '?email=' . $email);
    }

    /**
     * Sync autoresponder.
     *
     * @return \Illuminate\Http\Response
     */
    public function sync(Request $request, $code = null)
    {
        if (!is_null($code))
        {
            $project = Project::where('code', '=', $code)
            ->firstOrFail();

            $subscribers = Subscriber::where('project_id', '=', $project->id)
            ->where('status', '=', false)
            ->take(config('armanager.total_sync'))
            ->get();
        }
        else
        {
            $subscribers = Subscriber::where('status', '=', false)
            ->take(config('armanager.total_sync'))
            ->get();
        }

        if (is_null($subscribers))
        {
            # return 'no subscribers to sync';
            # Do nothing
            exit();
        }

        # Prevent cron overlap
        $fp = fopen(sys_get_temp_dir().DIRECTORY_SEPARATOR."lock.txt", "w+");

        if (flock($fp, LOCK_EX | LOCK_NB))
        { // do an exclusive lock

            foreach ($subscribers as $subscriber)
            {
                $autoresponders = $subscriber->project->autoresponders;

                foreach ($autoresponders as $autoresponder)
                {
                    # Start Convertkit
                    if ($autoresponder->provider == 'convertkit' && $autoresponder->is_enabled == true)
                    {
                        $client = new Client(["base_uri"=>"https://api.convertkit.com/v3/"]);

                        $result = $client->request('POST', 'forms/' . $autoresponder->campaign . '/subscribe', [
                            'form_params' => [
                                'email' => $subscriber->email,
                                'api_key' => $autoresponder->public_key
                            ]
                        ]);

                        # dd($result);
                    }
                    # End Convertkit

                    # Start GetResponse
                    if ($autoresponder->provider == 'getresponse' && $autoresponder->is_enabled == true)
                    {
                        $getresponse = new GetResponse($autoresponder->public_key);

                        $result = $getresponse->addContact(array(
                            # 'name'              => $name,
                            'email'             => $subscriber->email,
                            'dayOfCycle'        => 0,
                            'campaign'          => array('campaignId' => $autoresponder->campaign),
                            'ipAddress'         => $subscriber->ip
                        ));

                        # return var_export($result->getBody()->getContents(), true);
                    }
                    # End GetResponse

                    # Start TCP
                    if ($autoresponder->provider == 'theconversionpros' && $autoresponder->is_enabled == true)
                    {
                        // set POST variables
                        $url = 'https://api.theconversionpros.com/tcp-customized-form/rpc/?method=contact.add&params=';
                        $encode = urlencode('formId=' . $autoresponder->campaign . '&tcp[email]=' . $subscriber->email);

                        $header = null;

                        $header[] = "X_FORWARDED_FOR: " . $subscriber->ip;
                        $header[] = "REMOTE_ADDR: " . $subscriber->ip;

                        // open connection
                        $ch = curl_init();

                        // set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url . $encode);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

                        // execute post
                        $result = curl_exec($ch);

                        // close connection
                        curl_close($ch);

                        # return var_export($result->getBody()->getContents(), true);
                    }
                    # End TCP

                    # Start Predator
                    if ($autoresponder->provider == 'predator' && $autoresponder->is_enabled == true)
                    {
                        # Set POST variables
                        $url = $autoresponder->api_uri;
                        $fields = array(
                            'email' => $subscriber->email,
                            'name' => $subscriber->name
                        );

                        $header = null;

                        $header[] = "X_FORWARDED_FOR: " . $subscriber->ip;
                        $header[] = "REMOTE_ADDR: " . $subscriber->ip;

                        // open connection
                        $ch = curl_init();

                        // set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url . '?email=' . $subscriber->email);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POST, false);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

                        // execute post
                        $result = curl_exec($ch);

                        // close connection
                        curl_close($ch);

                        # return var_export($result->getBody()->getContents(), true);
                    }
                    # End Predator

                    # Start Mailwizz
                    if ($autoresponder->provider == 'mailwizz' && $autoresponder->is_enabled == true)
                    {
                        # Set POST variables
                        $url = $autoresponder->api_uri;

                        #API Connection to Mailwizz
                        #configuration object
                        $config = new \MailWizzApi_Config( array(
                            'apiUrl'        => $url,
                            'publicKey'     => $autoresponder->public_key,
                            'privateKey'    => $autoresponder->private_key,

                            #components
                            'components' => array(
                                'cache' => array(
                                    'class'     => 'MailWizzApi_Cache_File',
                                    'filesPath' => base_path('vendor/mailwizz-php-sdk/MailWizzApi/Cache/data/cache'),
                                )
                            ),
                        ));

                        #now inject the configuration and we are ready to make api calls
                        \MailWizzApi_Base::setConfig($config);

                        #start UTC
                        date_default_timezone_set('UTC');

                        #CREATE THE ENDPOINT
                        $endpoint = new \MailWizzApi_Endpoint_ListSubscribers();

                        $result = $endpoint->create( $autoresponder->campaign, array(
                            'EMAIL'    => $subscriber->email,
                            'FNAME'    => $subscriber->name
                        ));
                    }
                    # End MailWizz

                    # Start Sendlane
                    if ($autoresponder->provider == 'sendlane' && $autoresponder->is_enabled == true)
                    {
                        // set POST variables
                        $url = 'https://' . $autoresponder->api_uri . '/api/v1/list-subscriber-add';
                        $fields = array(
                            'api' => $autoresponder->public_key,
                            'hash' => $autoresponder->private_key,
                            'email' => $subscriber->email,
                            'list_id' => $autoresponder->campaign
                        );

                        $header = null;

                        $header[] = "X_FORWARDED_FOR: " . $subscriber->ip;
                        $header[] = "REMOTE_ADDR: " . $subscriber->ip;

                        // open connection
                        $ch = curl_init();

                        // set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

                        // execute post
                        $result = curl_exec($ch);

                        // close connection
                        curl_close($ch);

                        # return var_export($result->getBody()->getContents(), true);
                    }
                    # End Sendlane
                }

                # dd($result);
                # Update subscriber status
                // Subscriber::where('id', '=', $subscriber->id)
                // ->update(['status' => true]);


                $subscriber->update(['status' => 1]);
            }


            flock($fp, LOCK_UN); // release the lock
        }
        else
        {
            // echo "Couldn't get the lock!";
            exit();
        }

        fclose($fp);

        # return 'subscribers sync completed!';
    }
}
