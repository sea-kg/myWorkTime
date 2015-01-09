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

$userid = mwtAuth::userid();

if (count($_FILES) <= 0)
	mwtBase::throwError(1040, 'Files not found');

$keys = array_keys($_FILES);

for($i = 0; $i < count($keys); $i++)
{
	$filename = $keys[$i];
	
	if ($_FILES[$filename]['error'] > 0)
	{
		$result[$filename] = $_FILES[$filename]["error"];
	}
	else
	{
		$dom = new DOMDocument();
		$dom->load($_FILES[$filename]["tmp_name"]);
		
		$node = $dom->getElementsByTagName("realtime");
		
		$result['result'] = 'ok';

		//looping if tag config have more than one
		foreach ($node as $realtime) {
			$start_time = $realtime->getAttribute('start_time');
			$stop_time = $realtime->getAttribute('stop_time');
			$comment = $realtime->nodeValue;
			try {
				if (mwtBase::findOverlapsPeriods_Realtime($conn, $start_time, $stop_time, 0, $userid) > 0) {
					continue;
				}

				$stmt = $conn->prepare('INSERT INTO realtime(start_time, stop_time, comment, userid) VALUES(?,?,?,?)');
				if ($stmt->execute(array($start_time,$stop_time,$comment,$userid)) == 1);
					$result[$filename] = 'ok';
			} catch(PDOException $e) {
				mwtBase::throwError(1006, $e);
			}
		}
		
		//looping if tag config have more than one
		$node = $dom->getElementsByTagName("plantime");
		foreach ($node as $plantime) {
			$start_time = $plantime->getAttribute('start_time');
			$stop_time = $plantime->getAttribute('stop_time');
			try {
				if (mwtBase::findOverlapsPeriods_Plantime($conn, $start_time, $stop_time, 0) > 0) {
					continue;
				}

				$stmt = $conn->prepare('INSERT INTO plantime(start_time, stop_time) VALUES(?,?)');
				if ($stmt->execute(array($start_time,$stop_time)) == 1);
					$result[$filename] = 'ok';
				
			} catch(PDOException $e) {
				mwtBase::throwError(1006, $e);
			}
		}
	}
}

echo json_encode($result);
