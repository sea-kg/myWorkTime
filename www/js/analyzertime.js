
function loadAnalyzerTimePanel()
{
	var el = document.getElementById("content");
	var params = {};
	params.start_time = document.getElementById("start_time").value;
	params.stop_time = document.getElementById("stop_time").value;

	if (!check_time(params.start_time)) {
		el.innerHTML = '<div class="error">Incorrect format of datetime (got: ' + params.start_time + '), expeted 2015-01-29 00:00:00</div>';
		return;
	}
	
	if (!check_time(params.stop_time)) {
		el.innerHTML = '<div class="error">Incorrect format of datetime (got: ' + params.stop_time + '), expeted 2015-01-29 00:00:00</div>';
		return;
	}
	
	el.innerHTML = 'Analyzertime from ' + params.start_time + ' to ' + params.stop_time + ' <br>\n';
	el.innerHTML += '\n<div id="analyzer_time"></div>\n';

	var tt = document.getElementById("analyzer_time");
	tt.innerHTML = 'Please wait...';
	
	// alert(createUrlFromObj(params));
 	send_request_post(
		'api/time/analyzertime.php',
		createUrlFromObj(params),
		function (obj) {
			var tt = document.getElementById("analyzer_time");
			if (obj.result == 'fail')
			{
				tt.innerHTML = obj.error.message;
				return;
			}
			tt.innerHTML = '\n';

			var content = '';
			content += 'Plantime: ' + obj.sum_plantime + '<br>\n';
			content += 'Realtime: ' + obj.sum_realtime + '<br>\n';
			content += 'Difftime: ' + obj.sum_difftime + '<br>\n';
			tt.innerHTML += content;
		}
 	);
};
