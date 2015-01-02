<?php

$curdir = dirname(__FILE__);
include ($curdir."/../../config/config.php");
include ($curdir."/../api.lib/base.php");
include ($curdir."/../api.lib/auth.php");

if (!mwtAuth::isLogin())
	mwtBase::throwError(1011, 'Unauthorized request');

$result = array(
	'result' => 'fail',
	'data' => array(),
);

if (
	mwtBase::issetParam('start_time')
	&& mwtBase::issetParam('stop_time')
	&& mwtBase::issetParam('id')
)
{
	$start_time = mwtBase::getParam('start_time', '0000-00-00 00:00:00');
	$stop_time = mwtBase::getParam('stop_time', '0000-00-00 00:00:00');
	$id = mwtBase::getParam('id', 0);

	try {
		
		$stmt = $conn->prepare(
		'	UPDATE plantime SET
				start_time = ?,
				stop_time = ?
			WHERE 
				id = ?
			');
		if ($stmt->execute(array($start_time,$stop_time,$id)) == 1);
			$result['result'] = 'ok';
	} catch(PDOException $e) {
		mwtBase::throwError(1012, $e);
	}
}
else
{
	mwtBase::throwError(1013, 'Not found parameters: start_time or/and stop_time or/and id');
}

echo json_encode($result);
