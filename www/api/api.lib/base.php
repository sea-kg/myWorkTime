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
}
