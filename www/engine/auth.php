<?php

class auth
{
	function login($email, $password)
	{
		$curdir = dirname(__FILE__);
		include($curdir."/../config/config.php");
		
		$this->logout();

		if(!$this->isLogged())
		{
			
			$password = md5($password);

			$stmt = $conn->prepare("select * from users where email = ? and password = ? LIMIT 0,1;");
			
			//Не именованные метки
			try {
				$stmt->execute(array($email,$password));
				
				if ($stmt->rowCount() != 1)
					return false;
				$row = $stmt->fetch();
				$_SESSION['user'] = array();
				$_SESSION['user']['id'] = $row['id'];
				$_SESSION['user']['email'] = $row['email'];
				$_SESSION['user']['role'] = $row['role'];
				return true;
			} catch(PDOException $e) {
				echo 'Error : '.$e->getMessage();
				return false;
			}
		}
		return false;
	}

	function logout() { 
		if($this->isLogged()) { unset($_SESSION['user']); } 
	}
	function isLogged() { 
		return (isset($_SESSION['user'])); 
	}
	
	function role() { 
		return ($this->isLogged() ? $_SESSION['user']['role'] : '');
	}
	function isAdmin() {
		return ($this->role() == 'admin');
	}
	function isUser() { 
		return ($this->role() == 'user');
	}
	
	function email() { 
		return ($this->isLogged()) ? strtolower(base64_decode($_SESSION['user']['email'])) : ''; 
	}

	function iduser() { 
		return ($this->isLogged() && is_numeric($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : ''; 
	}
};

function checkAuth($auth)
{
  if(!$auth->isLogged()) {
    $result = array(
  	  'result' => 'fail',
    	'data' => array(),
    );
   	$result['error']['code'] = "200";
    $result['error']['message'] = 'Error 200: not authorized request';
    echo json_encode($result);
    exit;
  }
}
