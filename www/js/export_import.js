
function import_time()
{
	var files = document.getElementById("import_files").files;
	send_request_files(
		'api/time/time_import.php',
		files,
		function (obj) {
			if (obj.result == 'fail') {
				alert(obj.error.message);
				return;
			} else {
				// alert(JSON.stringify(obj)); // "imported"
				alert("imported");
			}
		}
	);
}

function export_import()
{
	var el = document.getElementById("content");
	var params_xml = {};
	params_xml.start_time = document.getElementById("start_time").value;
	params_xml.stop_time = document.getElementById("stop_time").value;
	params_xml.format = 'xml';
	
	var params_text = {};
	params_text.start_time = document.getElementById("start_time").value;
	params_text.stop_time = document.getElementById("stop_time").value;
	params_text.format = 'text';

	if (!check_time(params_xml.start_time)) {
		el.innerHTML = '<div class="error">Incorrect format of datetime (got: ' + params_xml.start_time + '), expeted 2015-01-29 00:00:00</div>';
		return;
	}
	
	if (!check_time(params_xml.stop_time)) {
		el.innerHTML = '<div class="error">Incorrect format of datetime (got: ' + params_xml.stop_time + '), expeted 2015-01-29 00:00:00</div>';
		return;
	}

	el.innerHTML = 'Export from ' + params_xml.start_time + ' to ' + params_xml.stop_time + ' <br><ul>';
	el.innerHTML += '<li><a href="api/time/realtime_export.php?' + createUrlFromObj(params_xml) + '">realtime (xml)</a></li>';
	el.innerHTML += '<li><a href="api/time/realtime_export.php?' + createUrlFromObj(params_text) + '">realtime (text)</a></li>';
	el.innerHTML += '<li><a href="api/time/plantime_export.php?' + createUrlFromObj(params_xml) + '">plantime</a></li>';
	el.innerHTML += '<ul>';
	el.innerHTML += '<br><input type="file" id="import_files"/> <div class="btn" onclick="import_time();">Import</div><br>\n';
}


