<?php

$curdir = dirname(__FILE__);
include ($curdir."/../../config/config.php");
include ($curdir."/../api.lib/base.php");
include ($curdir."/../api.lib/auth.php");

if (!mwtAuth::isLogin())
	mwtBase::throwError(1022, 'Unauthorized request');

$result = array(
	'result' => 'fail',
	'data' => array(),
);

if (mwtBase::issetParam('id'))
{
	$id = mwtBase::getParam('id', 0);
	$userid = mwtAuth::userid();

	try {
		
		$stmt = $conn->prepare('DELETE FROM realtime WHERE id = ? AND userid = ?');
		if ($stmt->execute(array($id,$userid)) == 1)
			$result['result'] = 'ok';
	} catch(PDOException $e) {
		mwtBase::throwError(1020, $e);
	}
}
else
{
	mwtBase::throwError(1021, 'Not found parameters: id');
}

echo json_encode($result);
