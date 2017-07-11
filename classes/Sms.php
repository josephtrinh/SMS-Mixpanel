<?php

interface SMS
{
    public function send($to, $text);
}

class NexmoSMS implements SMS
{
    protected $key;
    protected $secret;
    protected $fromNumber;

    public function __construct($key, $secret, $fromNumber)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->fromNumber = $fromNumber;
    }

    public function send($to, $text)
    {
	$params = [
	      'api_key' =>  $this->key,
	      'api_secret' => $this->secret,
	      'to' => $to,
	      'from' => $this->fromNumber,
	      'text' => $text 
	];
	$url = 'https://rest.nexmo.com/sms/json?' . http_build_query($params);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	
	return $response;
    }
}
