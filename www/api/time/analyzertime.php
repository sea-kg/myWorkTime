<?php

$curdir = dirname(__FILE__);
include ($curdir."/../../config/config.php");
include ($curdir."/../api.lib/base.php");
include ($curdir."/../api.lib/auth.php");

if (!mwtAuth::isLogin())
	mwtBase::throwError(1030, 'Unauthorized request');

$result = array(
	'result' => 'fail',
	'data' => array(),
);

if (mwtBase::issetParam('start_time') && mwtBase::issetParam('stop_time'))
{
	$start_time = mwtBase::getParam('start_time', '0000-00-00 00:00:00');
	$stop_time = mwtBase::getParam('stop_time', '0000-00-00 00:00:00');
	$userid = mwtAuth::userid();

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

		$plantime = '';
		if ($row1 = $stmt1->fetch())
		{
			$result['sum_plantime'] = $row1['sum'];
			$plantime = $row1['sum'];
		}
			
		$stmt2 = $conn->prepare(
			'SELECT
				SEC_TO_TIME(SUM(UNIX_TIMESTAMP(stop_time) - UNIX_TIMESTAMP(start_time))) as sum
			FROM
				realtime
			WHERE
				start_time >= ?
				AND stop_time <= ?
				AND userid = ?
		');
		$stmt2->execute(array($start_time,$stop_time,$userid));

		$realtime = '';
		if ($row2 = $stmt2->fetch())
		{
			$result['sum_realtime'] = $row2['sum'];
			$realtime = $row2['sum'];
		}

		$result['result'] = 'ok';
		
		$plantime = explode(':', $plantime);
		$realtime = explode(':', $realtime);
		
		$plantime = intval($plantime[0])*60*60 + intval($plantime[1])*60 + intval($plantime[2]);
		$realtime = intval($realtime[0])*60*60 + intval($realtime[1])*60 + intval($realtime[2]);

		$difftime = $realtime - $plantime;
		
		$minus = $difftime < 0 ? '-' : '+';
		$difftime = $difftime < 0 ? -1*$difftime : $difftime;
	
		$seconds = round($difftime % 60);

		$minutes = (($difftime - $seconds) / 60) % 60; // / (60 * 60);
		$hours = (($difftime - $minutes * 60 - $seconds) / 60 / 60);

		
		
		$seconds = strlen($seconds) < 2 ? '0'.$seconds : $seconds;
		$minutes = strlen($minutes) < 2 ? '0'.$minutes : $minutes;

		$result['sum_difftime'] = $minus.$hours.':'.$minutes.':'.$seconds;

		$result['plantime'] = $plantime;
		$result['realtime'] = $realtime;

	} catch(PDOException $e) {
		mwtBase::throwError(1034, $e);
	}
}
else
{
	mwtBase::throwError(1033, 'Not found parameters: start_time or/and stop_time');
}

echo json_encode($result);
