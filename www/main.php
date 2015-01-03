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



<?

exit;
if (isset($_GET['about'])) {
	?>
		<center>
			 <br>
			Style for menu got from:
				<a href="http://cssdeck.com/labs/dropdown">http://cssdeck.com/labs/dropdown</a><br>
			
		</center>
	<?
} else {
?>

<center>
Filter: from <input type="text"> to <input type="text"> <br>
List of periods with comments <br>
(with pages and calculte hours)

</center>
<?
	include_once("config/config.php");
	
	$query = "select * from periods";
	foreach ($conn->query($query) as $row) {
		foreach($row as $column_name => $column_value) {
			echo $column_name."   ".$column_value." <br>";
		}
	}
?>



<table>
	<tr>
		<td>Date:</td>
		<td><input type='text' id='date'/></td>
	</tr>
	<tr>
		<td>Start Time:</td>
		<td><input type='text' id='start_time'/></td>
	</tr>
	<tr>
		<td>End Time:</td>
		<td><input type='text' id='end_time'/></td>
	</tr>
	<tr>
		<td></td>
		<td><a href='javascript:void(0);' onclick="
			var sDate = document.getElementById('date').value;
			var sStartTime = document.getElementById('start_time').value;
			var sEndTime = document.getElementById('end_time').value;
		">Send</a></td>
	</tr>
</table>

<?php
	
	$calculate_to = strtotime("2014-09-30 00:00:00");
	$date = strtotime("2011-08-30 00:00:00");
	
	// 0 - sun
	// 6 - sat
	
	while($date <= $calculate_to) {
		$w = date("w",$date);
		
		$holyday = ($w > 0 && $w < 6) ? 0 : 1;
		
		$today = date("Y-m-d H:i:s", $date);
		
		$per1_start = date("Y-m-d H:i:s", 
			mktime(9, 0, 0, 
			date("m", $date) , date("d", $date), date("Y", $date))
		);
		
		$per1_end = date("Y-m-d H:i:s", 
			mktime(13, 0, 0, 
			date("m", $date) , date("d", $date), date("Y", $date))
		);
	
		$query = "select count(*) as cnt from periods_grids where start_time = '$per1_start' and end_time = '$per1_end'";
		$count = 0;
		foreach ($conn->query($query) as $row) {
			$count = $row['cnt'];
		}

		if ($count == 0) {
			$ins = $conn->prepare('INSERT INTO periods_grids(start_time, end_time, wday, holyday) VALUES(?,?,?,?);');
			$ins->execute(Array($per1_start, $per1_end, (int)$w, $holyday));
		}
		

		$per2_start = date("Y-m-d H:i:s", 
			mktime(14, 0, 0, 
			date("m", $date) , date("d", $date), date("Y", $date))
		);

		$per2_end = date("Y-m-d H:i:s", 
			mktime(18, 0, 0, 
			date("m", $date) , date("d", $date), date("Y", $date))
		);
		
		$query = "select count(*) as cnt from periods_grids where start_time = '$per2_start' and end_time = '$per2_end'";
		$count = 0;
		foreach ($conn->query($query) as $row) {
			$count = $row['cnt'];
		}

		if ($count == 0) {
			$ins = $conn->prepare('INSERT INTO periods_grids(start_time, end_time, wday, holyday) VALUES(?,?,?,?);');
			$ins->execute(Array($per2_start, $per2_end, (int)$w, $holyday));
		}

		// echo $w.' '.$per1_start.' - '.$per1_end.'; '.$per2_start.' - '.$per2_end.'; <br>';
		$date = mktime(0, 0, 0, date("m", $date) , date("d", $date)+1, date("Y", $date));
	}
}
?>

<center>
Add:<br>
Date: <input type="text"><br>
Type: <select>
		<option>Work</option>
		<option>Sleep</option>
	</select>
	<br>
From (HH:MM) <input type="text"><br>
To (HH:MM) <input type="text"><br>
Comment: <textarea></textarea><br>

</center>


</body>
</html>
