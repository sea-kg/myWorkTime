<?php

$curdir = dirname(__FILE__);
include ($curdir."/../../config/config.php");
include ($curdir."/../api.lib/base.php");
include ($curdir."/../api.lib/auth.php");

$result = array(
	'result' => 'fail',
	'data' => array(),
);

if (mwtBase::issetParam('email') && mwtBase::issetParam('password')) {
	$email = mwtBase::getParam('email', '');
	$password = mwtBase::getParam('password', '');
	
	mwtAuth::tryLogout($conn);
	mwtAuth::tryLogin($conn, $email, $password);

	if (!mwtAuth::isLogin()) {
		mwtBase::throwError(1000, "Could not login");
	} else {
		$result['result'] = 'ok';
	}
} else {
	mwtBase::throwError(1001, "It was not found email or password");
}

echo json_encode($result);
