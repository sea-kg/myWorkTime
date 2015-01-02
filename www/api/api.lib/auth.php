<?php

class mwtAuth {
	static function tryLogin($conn, $email, $password) {
		$password = md5($password);
		$stmt = $conn->prepare('select * from users where email = ? and password = ? LIMIT 0,1;');
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
			return false;
		}		
	}
	
	static function isLogin() {
		return isset($_SESSION['user']);
	}
	
	static function tryLogout($conn) {
		unset($_SESSION['user']);
	}	
}
