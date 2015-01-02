<?php

$curdir = dirname(__FILE__);
include ($curdir."/../../config/config.php");
include ($curdir."/../api.lib/base.php");
include ($curdir."/../api.lib/auth.php");

if (!mwtAuth::isLogin())
	mwtBase::throwError(1008, 'Unauthorized request');

$result = array(
	'result' => 'fail',
	'data' => array(),
);

if (mwtBase::issetParam('id'))
{
	$id = mwtBase::getParam('id', '0');
	$userid = mwtAuth::userid();

	try {
		
		$stmt = $conn->prepare('SELECT * FROM plantime WHERE id =?');
		$stmt->execute(array($id));

		if ($row = $stmt->fetch())
		{
			$result['data'] = array(
				'id' => $row['id'],
				'start_time' => $row['start_time'],
				'stop_time' => $row['stop_time'],
			);
			$result['result'] = 'ok';
		}
	} catch(PDOException $e) {
		mwtBase::throwError(1010, $e);
	}
}
else
{
	mwtBase::throwError(1009, 'Not found parameters: id');
}

echo json_encode($result);
