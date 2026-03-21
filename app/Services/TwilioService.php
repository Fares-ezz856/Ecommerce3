<?php
namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $sid;
    protected $token;
    protected $from;

    public function __construct()
    {
        $this->sid   = env('TWILIO_SID');
        $this->token = env('TWILIO_AUTH_TOKEN');
        $this->from  = env('TWILIO_NUMBER');
    }

    public function sendSms($to, $message)
    {
        $client = new Client($this->sid, $this->token);

        return $client->messages->create($to, [
            'from' => $this->from,
            'body' => $message
        ]);
    }
}
