<?php

$curdir = dirname(__FILE__);
include ($curdir."/../../config/config.php");
include ($curdir."/../api.lib/base.php");
include ($curdir."/../api.lib/auth.php");

if (!mwtAuth::isLogin())
	mwtBase::throwError(1003, 'Unauthorized request');

$result = array(
	'result' => 'fail',
	'data' => array(),
);

if (mwtBase::issetParam('start_time') && mwtBase::issetParam('stop_time'))
{
	$start_time = mwtBase::getParam('start_time', '0000-00-00 00:00:00');
	$stop_time = mwtBase::getParam('stop_time', '0000-00-00 00:00:00');

	try {
		
		$stmt1 = $conn->prepare(
			'SELECT
				SEC_TO_TIME(SUM(UNIX_TIMESTAMP(stop_time) - UNIX_TIMESTAMP(start_time))) as sum
			FROM
				plantime
			WHERE
				start_time >= ?
				AND stop_time <= ?');
		$stmt1->execute(array($start_time,$stop_time));

		if ($row1 = $stmt1->fetch())
			$result['sum_time'] = $row1['sum'];

		$stmt = $conn->prepare('select *, SEC_TO_TIME(UNIX_TIMESTAMP(stop_time) - UNIX_TIMESTAMP(start_time)) as d  from plantime where start_time >= ? and stop_time <= ? ORDER BY start_time');
		$stmt->execute(array($start_time,$stop_time));
		
		$result['result'] = 'ok';
		while ($row = $stmt->fetch())
		{
			$result['data'][] = array(
				'id' => $row['id'],
				'start_time' => $row['start_time'],
				'stop_time' => $row['stop_time'],
				'sum' => $row['d'],
			);
		}
	} catch(PDOException $e) {
		mwtBase::throwError(1004, $e);
	}
}
else
{
	mwtBase::throwError(1003, 'Not found parameters: start_time or/and stop_time');
}

echo json_encode($result);
