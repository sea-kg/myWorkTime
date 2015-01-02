
function loadRealTimePanel()
{
	var el = document.getElementById("content");
	var params = {};
	params.start_time = document.getElementById("start_time").value;
	params.stop_time = document.getElementById("stop_time").value;
	
	el.innerHTML = 'Realtime from ' + params.start_time + ' to ' + params.stop_time + ' <br>\n';
	el.innerHTML += '\n<div class="time_table" id="table_time"></div>\n';

	var tt = document.getElementById("table_time");
	tt.innerHTML = 'Please wait... api/time/realtime.php?' + createUrlFromObj(params);
	
 	send_request_post(
		'api/time/realtime.php',
		createUrlFromObj(params),
		function (obj) {
			var tt = document.getElementById("table_time");
			if (obj.result == 'fail')
			{
				tt.innerHTML = obj.error.message;
				return;
			}
			tt.innerHTML = '\n';
			// tt.innerHTML += '<div> Summary time: ' + obj.sum_time + '</div>';
			
			var content = '';
			content += '<div class="time_row_h">\n';
			content += '	<div class="time_cell_h">Date</div>\n';
			content += '	<div class="time_cell_h">Time</div>\n';
			content += '	<div class="time_cell_h">Summary</div>\n';
			content += '	<div class="time_cell_h">Comment</div>\n';
			content += '</div>\n';
			tt.innerHTML += content;

			for (var i = 0; i < obj.data.length; i++) {
				
				var date1 = obj.data[i].start_time.split(' ')[0];
				var time1 = obj.data[i].start_time.split(' ')[1];
				var date2 = obj.data[i].stop_time.split(' ')[0];
				var time2 = obj.data[i].stop_time.split(' ')[1];

				content = '';
				content += '<div class="time_row" onclick="editFormRealtime(' + obj.data[i].id + ');">\n';
				content += '	<div class="time_cell">' + date1 + '</div>\n';
				content += '	<div class="time_cell">' + time1 + '-' + time2 + '</div>\n';
				content += '	<div class="time_cell">' + obj.data[i].sum + '</div>\n';
				content += '	<div class="time_cell"><pre>' + obj.data[i].comment + '</pre></div>\n';
				content += '</div>\n';
				tt.innerHTML += content;
			}
			
			content = '';
			content += '<div class="time_row">\n';
			content += '	<div class="time_cell"></div>\n';
			content += '	<div class="time_cell"></div>\n';
			content += '	<div class="time_cell">' + obj.sum_time + '</div>\n';
			content += '	<div class="time_cell"></div>\n';
			content += '</div>\n';
			tt.innerHTML += content;
		}
 	);
	
	el.innerHTML += '<div class="btn" onclick="insertFormRealtime();">add new</div>';
};

function insertFormRealtime() {
	var content = '';
	var start_time = document.getElementById("start_time").value;
	content += 'Date: <input id="insert_date" type="text" value="' + start_time + '"><br>';
	content += 'Time from <input id="insert_start_time" type="text" value="00:00:00"> <br>';
	content += 'Time to <input id="insert_stop_time" type="text" value="00:00:00"><br>';
	content += 'Comment:<br> <textarea id="insert_comment"></textarea><br>';
	content += '<div class="btn" onclick="insertRealtime();">insert</div>';
	showModalDialog(content);
}

function insertRealtime() {
	var date0 = document.getElementById("insert_date").value;
	var params = {};
	params.start_time = date0 + ' ' + document.getElementById("insert_start_time").value;
	params.stop_time = date0 + ' ' + document.getElementById("insert_stop_time").value;
	params.comment = document.getElementById("insert_comment").value;

	// alert(createUrlFromObj(params));
	send_request_post(
		'api/time/realtime_insert.php',
		createUrlFromObj(params),
		function (obj) {
			if (obj.result == 'fail') {
				alert(obj.error.message);
				return;
			} else {
				loadRealTimePanel();
				closeModalDialog();
			}
		}
	);
}

function editFormRealtime(id) {
	var params = {};
	params.id = id;

	send_request_post(
		'api/time/realtime_get.php',
		createUrlFromObj(params),
		function (obj) {
			if (obj.result == 'fail') {
				alert(obj.error.message);
				return;
			} else {
				var content = '';
				var start_time = obj.data.start_time.split(' ')[1];
				var stop_time = obj.data.stop_time.split(' ')[1];
				var date0 = obj.data.start_time.split(' ')[0];
				content += 'Date: <input id="update_date" type="text" value="' + date0 + '"><br>';
				content += 'Time from <input id="update_start_time" type="text" value="' + start_time + '"> <br>';
				content += 'Time to <input id="update_stop_time" type="text" value="' + stop_time + '"><br>';
				content += 'Comment:<br> <textarea id="update_comment">' + obj.data.comment + '</textarea><br>';
				content += '<div class="btn" onclick="updateRealtime(' + id + ');">update</div>';
				showModalDialog(content);
			}
		}
	);
}

function updateRealtime(id) {
	var date0 = document.getElementById("update_date").value;
	var params = {};
	params.id = id;
	params.start_time = date0 + ' ' + document.getElementById("update_start_time").value;
	params.stop_time = date0 + ' ' + document.getElementById("update_stop_time").value;
	params.comment = document.getElementById("update_comment").value;

	send_request_post(
		'api/time/realtime_update.php',
		createUrlFromObj(params),
		function (obj) {
			if (obj.result == 'fail') {
				alert(obj.error.message);
				return;
			} else {
				loadRealTimePanel();
				closeModalDialog();
			}
		}
	);
}
