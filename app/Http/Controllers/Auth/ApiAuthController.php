<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\IntegrationRequestMailable;
use App\Models\ApplicationRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class ApiAuthController extends Controller
{
    public function index()
    {
        $data['applications'] = ApplicationRegistration::all();

        return view('auth.inc.system-interaction', $data);
    }

    public function create()
    {
        return view('auth.register-application');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'app_url' => 'required',
            'app_vendor' => 'required',
            'application_version' => 'required',
            'end_points' => 'required',
            'purpose_for_integration' => 'required',
        ]);

        \DB::transaction(function () {

            $request = \Request::all();
            $client_id = $this->generateOauthClientId();

            $user = new User;
            $user->name = $request['name'];
            $user->email = str_replace(' ', '', $request['email']);
            $user->is_active = 0;
            $user->password = bcrypt($request['password']);
            $user->save();

            //generate bearer token
            $token = $user->createToken('API Token', [$request['purpose_for_integration']])->accessToken;

            $oauth_client = \DB::insert('insert into oauth_clients (id,user_id, name,secret,provider)
      values (?,?,?,?,?)', ["$client_id", "$user->id", "$user->name", "$user->password", "$user->created_by"]);

            $app_registration = new ApplicationRegistration;

            $app_registration->url = $request['app_url'];
            $app_registration->oauth_client_id = $client_id;
            $app_registration->purpose_for_integration = $request['purpose_for_integration'];
            $app_registration->application_version = $request['application_version'];
            $app_registration->owner = $request['app_vendor'];
            $app_registration->bearer_token = $token;
            $app_registration->save();

            $mail_content = [
                'app_name' => $request['name'],
                'client_id' => $client_id,
                'version' => $request['application_version'],
                'vendor' => $request['app_vendor'],
            ];

            try {
                $admin_email = $user->email;
                // Mail::to(["$admin_email"])
                Mail::to(['benbyron24@gmail.com'])
                    ->queue(new IntegrationRequestMailable($mail_content));

                $this->close();
                echo "<script>alert('Successfuly submitted integration request. Please wait for approval');</script>";
            } catch (\Exception $e) {

                // dd($e);
                \Log::info($e);
            }
        });

        return redirect()->back()->with('success', 'Successfuly submitted integration request. Please wait for approval');
    }

    public function close()
    {

    }

    public function generateOauthClientId()
    {
        $uniqueKey = mb_strtolower(substr(sha1(microtime()), rand(1, 10), 31));
        $client_id = implode('-', str_split($uniqueKey, 6));

        return $client_id;
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        if (\Auth::attempt(['name' => $request->name, 'password' => $request->password], $request->get('remember'))) {

            $token = auth()->user()->createToken('API Token', ['make-test-request'])->accessToken;
            // $token = auth()->user()->createToken('authToken',['create-games'])->accessToken;
            return response()->json(['token' => $token], 200);

        } else {
            return response(['error_message' => 'Incorrect Credentials. Please try again']);
        }
    }
}
