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
			$_SESSION['user_myworktime'] = array();
			$_SESSION['user_myworktime']['id'] = $row['id'];
			$_SESSION['user_myworktime']['email'] = $row['email'];
			$_SESSION['user_myworktime']['role'] = $row['role'];
			return true;
		} catch(PDOException $e) {
			return false;
		}
	}
	
	static function isLogin() {
		return isset($_SESSION['user_myworktime']);
	}
	
	static function userid() {
		return isset($_SESSION['user_myworktime']) && isset($_SESSION['user_myworktime']['id']) ? $_SESSION['user_myworktime']['id'] : 0;
	}
	
	static function tryLogout($conn) {
		unset($_SESSION['user_myworktime']);
	}	
}
