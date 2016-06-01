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

	$format = 'xml';
	if(mwtBase::issetParam('format')){
		$format = mwtBase::getParam('format');
	}
	if($format == 'text'){
		
	}else if($format == 'xml'){

	}else{
		$format = 'xml';
	}

	try {

		$stmt = $conn->prepare('select *, SEC_TO_TIME(UNIX_TIMESTAMP(stop_time) - UNIX_TIMESTAMP(start_time)) as d  from realtime where start_time >= ? and stop_time <= ? and userid = ? ORDER BY start_time');
		$stmt->execute(array($start_time,$stop_time,$userid));
		
		$result['result'] = 'ok';
		
		if($format == 'xml'){
			$mwt = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><mwt/>');
		}else if($format == 'text'){
			$mwt = '';
		}

		$minutes = 0;
		while ($row = $stmt->fetch())
		{
			if($format == 'xml'){
				$realtime = $mwt->addChild('realtime',htmlspecialchars($row['comment']));
				$realtime->addAttribute('start_time', $row['start_time']);
				$realtime->addAttribute('stop_time', $row['stop_time']);
				$realtime->addAttribute('sum', $row['d']);
			}else if($format == 'text'){
				$mwt .= split(' ',$row['start_time'])[0]."\n";
				$mwt .= "\tTime: ".split(' ',$row['start_time'])[1]." - ".split(' ',$row['stop_time'])[1]." (".$row['d'].")\n";
				$comment = split("\n",$row['comment']);
				$comment = "\tComment: ".implode("\n\t", $comment);
				$mwt .= $comment."\n\n";
				$minutes += intval(split(':',$row['d'])[0], 10)*60;
				$minutes += intval(split(':',$row['d'])[1], 10);
			}
		}
	
		if($format == 'text'){
			$min = ($minutes % 60);
			$hours = ($minutes - $min) / 60;
			$mwt .= 'Summery time: '.$hours.':'.$min." min \n\n";
		}
	
		$start_time = str_replace(':', '', $start_time);
		$stop_time = str_replace(':', '', $stop_time);
		$start_time = str_replace('-', '', $start_time);
		$stop_time = str_replace('-', '', $stop_time);
		$start_time = str_replace(' ', '_', $start_time);
		$stop_time = str_replace(' ', '_', $stop_time);
		
		if($format == 'xml'){
			Header('Content-type: text/xml');
			header('Content-Disposition:attachment;filename="myworktime_realtime_'.$start_time.'_'.$stop_time.'.xml"');
		}else if($format == 'text'){
			Header('Content-type: text/plain');
			header('Content-Disposition:attachment;filename="myworktime_realtime_'.$start_time.'_'.$stop_time.'.txt"');
		}
		
		if($format == 'xml'){
			$dom = new DOMDocument("1.0");
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML($mwt->asXML());
			print($dom->saveXML());
		}else if($format == 'text'){
			print($mwt);
		}
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
