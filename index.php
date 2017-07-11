<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'classes/Sms.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "root";
$config['db']['dbname'] = "";

$config['sms']['key'] 	= "";
$config['sms']['secret']= "";
$config['sms']['phone'] = "";

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();
$container['view'] = new \Slim\Views\PhpRenderer("../templates/");

$container['db'] = function ($c) {
	$db = $c['settings']['db'];
	$pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'], $db['user'], $db['pass']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	return $pdo;
};

$container['sms'] = function($c) {
    	$sms = $c['settings']['sms'];
	return new NexmoSMS($sms['key'], $sms['secret'], $sms['phone']);
};

$app->get("/", function(Request $req, Response $res, array $args) {
	echo "Nothing to see here...move along!";
	echo "<br>";
});

$app->post('/mixpanel', function (Request $request, Response $response, array $args) use ($app) {
	/* Sample Mixpanel data for testing 
	$json = file_get_contents("../data/sample_mixpanel.json");
	*/
	$json = $response->getBody();
	$data = json_decode($json, true);

	/* make text variable name friendly */
	function normalize_var_name( $str ) {
		$str = preg_replace('/[\$]/', '', strtolower($str));
		$str = preg_replace('/[\s]/', '_', $str);

		return $str;
	}

	/* format incoming data */
	$data_int = 0;
	foreach ($data as $k => $v) {
		if (!is_array($v)) {
			$k = normalize_var_name($k);
			$data_db[$data_int][$k] = $v;
		} else {
			foreach ($v as $k => $v) {
				if (!is_array($v)) {
					$k = normalize_var_name($k);
					$data_db[$data_int][$k] = $v;
				} else {
					foreach ($v as $k => $v) {
						$k = normalize_var_name($k);
						$data_db[$data_int][$k] = $v;
					}
				}
			}
		}

		$data_int++;
	}

	/* looping through all the received data */
	foreach ($data_db as $value) {
		$unix_ts = time();
		$current_ts = date("Y-m-d H:i:s", $unix_ts);
		$value['sms_sent'] = 0;
		$value['added'] = $current_ts;
		$value['last_modified'] = $current_ts;

		$eventData = new EventEntity($value);
		$event_mapper = new EventMapper($this->db);

		/* add new event if distinct_id doesn't exist */
		if( ! $event_mapper->getEventStatus( $value['distinct_id'] )['status'] ) {
			$event_mapper->addNew($eventData);
		}

		/* send SMS if sms_sent is 0 */
		if( ! $event_mapper->getSmsSentStatus( $value['distinct_id'])['status'] ) {
			$sms_response = $this->sms->send('+85256322589', 'testing');
		}

		$decoded_response = json_decode($sms_response, true);

		/* update sms record accordingly */
		foreach ( $decoded_response['messages'] as $message ) {
			if( ! $event_mapper->getSmsSentStatus( $value['distinct_id'])['status'] ) {
				$unix_ts = time();
				$current_ts = date("Y-m-d H:i:s", $unix_ts);
				$data_sms['sms_to'] = $message['to'];
				$data_sms['sms_message_id'] = $message['message-id'];
				$data_sms['sms_status'] = $message['status'];
				$data_sms['sms_remaining_balance'] = $message['remaining-balance'];
				$data_sms['sms_message_price'] = $message['message-price'];
				$data_sms['sms_network'] = $message['network'];
				$data_sms['sms_error_text'] = $message['error-text'];
				$data_sms['sms_sent_date'] = $current_ts;
				$data_sms['sms_last_sent'] = $current_ts;

				if ($message['status'] == 0) {
					$data_sms['sms_sent'] = 1;
					error_log("Success " . $message['message-id']);
				} else {
					$data_sms['sms_sent'] = 0;
					error_log("Error {$message['status']} {$message['error-text']}");
				}

				$smsData = new EventEntity($data_sms);
				$sms_mapper = new EventMapper($this->db);
				$sms_mapper->addNewSMS($smsData, $value['distinct_id']);
			}
		}
	}

	return $response->withStatus(200);
});

$app->run();
