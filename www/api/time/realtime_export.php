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
	$userid = mwtAuth::userid();

	try {

		$stmt = $conn->prepare('select *, SEC_TO_TIME(UNIX_TIMESTAMP(stop_time) - UNIX_TIMESTAMP(start_time)) as d  from realtime where start_time >= ? and stop_time <= ? and userid = ? ORDER BY start_time');
		$stmt->execute(array($start_time,$stop_time,$userid));
		
		$result['result'] = 'ok';
		
		$mwt = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><mwt/>');

		while ($row = $stmt->fetch())
		{
			$realtime = $mwt->addChild('realtime',$row['comment']);
			$realtime->addAttribute('start_time', $row['start_time']);
			$realtime->addAttribute('stop_time', $row['stop_time']);
			$realtime->addAttribute('sum', $row['d']);
		}

		$start_time = str_replace(':', '', $start_time);
		$stop_time = str_replace(':', '', $stop_time);
		$start_time = str_replace('-', '', $start_time);
		$stop_time = str_replace('-', '', $stop_time);
		$start_time = str_replace(' ', '_', $start_time);
		$stop_time = str_replace(' ', '_', $stop_time);
		
		Header('Content-type: text/xml');
		header('Content-Disposition:attachment;filename="myworktime_realtime_'.$start_time.'_'.$stop_time.'.xml"');
		
		$dom = new DOMDocument("1.0");
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($mwt->asXML());
		print($dom->saveXML());
		exit;

	} catch(PDOException $e) {
		mwtBase::throwError(1004, $e);
	}
}
else
{
	mwtBase::throwError(1003, 'Not found parameters: start_time or/and stop_time');
}

echo json_encode($result);
