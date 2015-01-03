
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
	var params = {};
	params.start_time = document.getElementById("start_time").value;
	params.stop_time = document.getElementById("stop_time").value;

	el.innerHTML = 'Export from ' + params.start_time + ' to ' + params.stop_time + ' \n';
	el.innerHTML += '<a href="api/time/realtime_export.php?' + createUrlFromObj(params) + '">realtime</a>\n';
	el.innerHTML += '<a href="api/time/plantime_export.php?' + createUrlFromObj(params) + '">plantime</a> <br>\n';

	el.innerHTML += '<br><br><input type="file" id="import_files"/> <div class="btn" onclick="import_time();">Import</div><br>\n';
}

