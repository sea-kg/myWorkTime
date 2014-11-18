<?php

$curdir = dirname(__FILE__);
include ($curdir."/../../engine/auth.php");

$auth = new auth();

$result = array(
	'result' => 'fail',
	'data' => array(),
);

$auth->logout();
$result['result'] = 'ok';

echo json_encode($result);
