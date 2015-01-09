<?php

class mwtBase {
	static function throwError($code, $message) {
	  $result = array(
		  'result' => 'fail',
		'data' => array(),
	  );
		$result['error']['code'] = $code;
		$result['error']['message'] = 'Error('.$code.'): '.$message;
	  echo json_encode($result);
	  exit;
	}
	
	static function issetParam($name) {
		return isset($_GET[$name]) || isset($_POST[$name]);
	}
	
	static function getParam($name, $default) {
		return isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : $default);
	}
	
	static function findOverlapsPeriods_Plantime($conn, $start_time, $stop_time, $id) {
		$count = 0;
		$select_check = 'SELECT count(*) as cnt FROM plantime WHERE ((start_time <= ? AND stop_time > ?) OR (start_time < ? AND stop_time >= ?) OR (start_time = ? AND stop_time = ?)) AND id <> ?';
		$params_select_check = array($start_time,$start_time,$stop_time,$stop_time,$start_time,$stop_time,$id);
		$stmt_check = $conn->prepare($select_check);
		$stmt_check->execute($params_select_check);
		if ($row = $stmt_check->fetch())
		{
			$result['cnt'] = $row['cnt'];
			$count = $row['cnt'];
		}
		return $count;
	}
}
