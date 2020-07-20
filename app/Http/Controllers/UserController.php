<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\ActivationEmail;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        User::create([
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        $code = $this->getActivationCode();
        try{
            $this->sendSms($request->phone_number, 'Activation Code: '.$code, 'Twilio');
        }catch(Exception $e){
        //     //send email
            $data = ['user_email' => $request->email,
                     'code' => $code];
            Mail::to( $request->email )->send( new ActivationEmail($data) );
            return "Error: " . $e->getMessage();
        }
        return response()->json(['message'=>'done successfully .. will send sms using twilio or send email']);
    }

    private function getActivationCode()
    {
        return rand(1000,9999);
    }
    /**
     * Send SMS to user using Twilio
     * @param user $user
     * @param message $message
     */
    public function sendSms($user_number, $message, $platform)
    {
        if($platform == 'Twilio'){
            $account_sid = config('app.twilio')['TWILIO_SID'];
            $auth_token = config('app.twilio')['TWILIO_AUTH_TOKEN'];
            $twilio_number = config('app.twilio')['TWILIO_NUMBER'];

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($user_number,
                    ['from' => $twilio_number, 'body' => $message] );
        }
    }
}
