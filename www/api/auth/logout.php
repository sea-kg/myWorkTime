<?php

$curdir = dirname(__FILE__);
include ($curdir."/../../config/config.php");
include ($curdir."/../api.lib/base.php");
include ($curdir."/../api.lib/auth.php");

$result = array(
	'result' => 'fail',
	'data' => array(),
);

mwtAuth::tryLogout($conn);

if (mwtAuth::isLogin()) {
	mwtBase::throwError(1002, "Could not logout");
} else {
	$result['result'] = 'ok';
}

echo json_encode($result);
