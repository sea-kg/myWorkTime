<?
include_once "config/config.php";
include_once "api/api.lib/auth.php";

if(mwtAuth::isLogin())
{
	refreshTo("main.php");
	return;
};
?>

<html>
	<head>
		<title>My Work Time</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="js/send_request.js"></script>
		<script type="text/javascript" src="js/auth.js"></script>
		<link rel="stylesheet" type="text/css" href="css/index.css" />
	</head>
	<body class="index_body">
		<table class="index_table">
			<tr>
				<td>
					<center>
		<table cellspacing=10px cellpadding=10px class="index_input_form">
			<tr>
				<td colspan=2><div class="index_caption">My Work Time</div></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input name="email" id="email" placeholder="your@email.com" value="" type="text" onkeydown="if (event.keyCode == 13) login();"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input name="password" id="password" placeholder="****" value="" type="password"  onkeydown="if (event.keyCode == 13) login();"></td>
			</tr>
			<tr>
				<td colspan=2>
					<center>
						<div class="index_button" onclick="login();">Sign in</div>
					</center>
				</td>
			</tr>
		</table>
		<font id="error_message" color='#ff0000'></font>
		</center>
				</td>
			</tr>
			<tr>
				<td height="5px"><center><font color="#000" face="Arial" size="2">Copyright © 2015 sea-kg.</font></center></td>
			</tr>
		</table>
	</body>
</html>
