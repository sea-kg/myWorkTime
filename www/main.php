<?php
	include_once "config/config.php";
	include_once "api/api.lib/auth.php";

	if(!mwtAuth::isLogin())
	{
		refreshTo("index.php");
		return;
	};
	
	$date_now = date('Y-m-d');
	$start_date = isset($_SESSION['user_myworktime']['start_date']) ? $_SESSION['user_myworktime']['start_date'] : $date_now.' 00:00:00';
	$end_date = isset($_SESSION['user_myworktime']['end_date']) ? $_SESSION['user_myworktime']['end_date'] : $date_now.' 23:59:00';
?>

<html>
	<head>
		<title>My Work Time</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href='css/menu.css' rel='stylesheet' type='text/css'>
		<link href='css/menu2.css' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="js/send_request.js"></script>
		<script type="text/javascript" src="js/select_time.js"></script>
		<script type="text/javascript" src="js/realtime.js"></script>
		<script type="text/javascript" src="js/plantime.js"></script>
		<script type="text/javascript" src="js/analyzertime.js"></script>
		<script type="text/javascript" src="js/export_import.js"></script>
		<script type="text/javascript" src="js/about.js"></script>
		<script type="text/javascript" src="js/calendar.js"></script>
		<script type="text/javascript" src="js/auth.js"></script>
	</head>
<body class="body">

<div id="modal_dialog" class="overlay">
	<div class="overlay_table">
		<div class="overlay_cell">
			<div class="overlay_content">
				<div id="modal_dialog_content">
					Текст посередине DIV
				</div>
				<div class="overlay_close">
					<div class="menu_btn" href="javascript:void(0);" onclick="closeModalDialog();">
						Close
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="select_time" class="select_time">
	Something;
</div>

<div class="menu_panel">
<!-- http://htmlweb.ru/java/example/calendar.php -->
<!-- div class="menu_item">
	From <input type="text" id="start_time" value="yyyy-mm-dd" onfocus="this.select();lcs(this)"
		onclick="event.cancelBubble=true;this.select();lcs(this)">
</div>
<div class="menu_item">
	To <input type="text" id="stop_time" value="yyyy-mm-dd" onfocus="this.select();lcs(this)"
		onclick="event.cancelBubble=true;this.select();lcs(this)">
</div><br><br -->
<div class="menu_item">
	<input type="text" id="start_time" value="<? echo $start_date; ?>"> - 
	<input type="text" id="stop_time" value="<? echo $end_date; ?>">
</div>
<div class="menu_item">
	<div class="menu_select_time" onclick="select_datetime('start_time', 'stop_time');">Choose periode</div>
</div>
<br><br>
<!-- other menu -->

<div class="menu_btn" onclick="loadRealTimePanel();">Real time</div>
<div class="menu_btn" onclick="loadPlanTimePanel();">Plan time</div>
<div class="menu_btn" onclick="loadAnalyzerTimePanel();">Analyzer time</div>
<div class="menu_btn" onclick="export_import();">Export/Import</div>
<div class="menu_btn" onclick="loadAbout();">About</div>
<div class="menu_btn" onclick="logout();">Logout</div>
</div>
<div class="content_panel" id="content">
</div>

<div class="footer_copyright">
<center><font color="#000" face="Arial" size="2">Copyright © 2015 sea-kg</font></center>
</div>
</body>
</html>
