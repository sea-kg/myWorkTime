<html>
	<head>
		<title>My Work Time</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href='css/menu.css' rel='stylesheet' type='text/css'>
		<link href='css/menu2.css' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="js/send_request.js"></script>
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
					<div class="btn" href="javascript:void(0);" onclick="closeModalDialog();">
						Close
					</div>
				</div>
			</div>
		</div>
	</div>
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
	From <input type="text" id="start_time" value="yyyy-mm-dd 00:00:00">
</div>
<div class="menu_item">
	To <input type="text" id="stop_time" value="yyyy-mm-dd 23:00:00">
</div><br><br>
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
