function login()
{
	document.getElementById("error_message").innerHTML = "";
	
	var email = document.getElementById('email').value;
	var password = document.getElementById('password').value;
	
	send_request(
		"api/auth/login.php?email="+email + "&password=" + password,
		function(obj) {
			if (obj.result == "fail") {
				document.getElementById("error_message").innerHTML = "<b>" + obj.error.message + "</b>";
			} else {
				window.location.href = "main.php";
			}
		}
	);
}

function logout()
{
	send_request(
		"api/auth/logout.php",
		function(obj) {
			if (obj.result == "fail") {
				document.getElementById("error_message").innerHTML = "<b>" + obj.error.message + "</b>";
			} else {
				window.location.href = "index.php";
			}
		}
	);
}
