<?

function showerror($code, $message) {
  $result = array(
	  'result' => 'fail',
  	'data' => array(),
  );
 	$result['error']['code'] = $code;
	$result['error']['message'] = $message;
  echo json_encode($result);
  exit;
}