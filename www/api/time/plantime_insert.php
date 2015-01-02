<?php

$curdir = dirname(__FILE__);
include ($curdir."/../../config/config.php");
include ($curdir."/../api.lib/base.php");
include ($curdir."/../api.lib/auth.php");

if (!mwtAuth::isLogin())
	mwtBase::throwError(1007, 'Unauthorized request');

$result = array(
	'result' => 'fail',
	'data' => array(),
);

if (mwtBase::issetParam('start_time') && mwtBase::issetParam('stop_time'))
{
	$start_time = mwtBase::getParam('start_time', '0000-00-00 00:00:00');
	$stop_time = mwtBase::getParam('stop_time', '0000-00-00 00:00:00');

	try {
		
		$stmt = $conn->prepare('INSERT INTO plantime(start_time, stop_time) VALUES(?,?)');
		if ($stmt->execute(array($start_time,$stop_time)) == 1);
			$result['result'] = 'ok';
	} catch(PDOException $e) {
		mwtBase::throwError(1006, $e);
	}
}
else
{
	mwtBase::throwError(1005, 'Not found parameters: start_time or/and stop_time');
}

echo json_encode($result);
