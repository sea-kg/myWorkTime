<?php

$curdir = dirname(__FILE__);
include ($curdir."/../../engine/auth.php");

$auth = new auth();

$result = array(
	'result' => 'fail',
	'data' => array(),
);

if (isset($_GET['email']) && isset($_GET['password'])) {
	$email = $_GET['email'];
	$password = $_GET['password'];

	if( $auth->login($_GET['email'], $_GET['password']) ) {
		$result['result'] = 'ok';
	} else {
		$result['error']['code'] = '102';
		$result['error']['message'] = 'Error 102: it was not found login or password';
	}
} else {
	$result['error']['code'] = '101';
	$result['error']['message'] = 'Error 101: it was not found login or password';
}


echo json_encode($result);
