<?
include_once "config/config.php";
include_once "engine/auth.php";
$auth = new auth();
if($auth->isLogged())
{
	refreshTo("main.php");
	return;
};
?>

<html>
	<head>
		<title> Мое время </title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="js/send_request.js"></script>
		<script type="text/javascript" src="js/auth.js"></script>
		<!-- link rel="stylesheet" type="text/css" href="styles/body.css" / -->
	</head>
	<body class="eap_body">
		<center>
		<h1> My time </h1>
		<table cellspacing=10px cellpadding=10px>
			<tr>
				<td>Name</td>
				<td><input name="email" id="email" value="" type="text" onkeydown="if (event.keyCode == 13) login();"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input name="password" id="password" value="" type="password"  onkeydown="if (event.keyCode == 13) login();"></td>
			</tr>
			<tr>
				<td colspan=2>
					<center>
						<a class="button" href="javascript:void(0);" onclick="login();">Sign in</a>
					</center>
				</td>
			</tr>
		</table>
		<font id="error_message" color='#ff0000'></font>
		</center>
	</body>
</html>
