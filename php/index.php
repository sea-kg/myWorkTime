<html>
	<head>
		<title>My Work Time</title>
	</head>
<body>
<?
	include_once("config.php");
	
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
?>

</body>
</html>
