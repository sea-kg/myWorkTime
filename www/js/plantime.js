
function loadPlanTimePanel()
{
	var el = document.getElementById("content");
	var params = {};
	params.start_time = document.getElementById("start_time").value;
	params.stop_time = document.getElementById("stop_time").value;
	
	el.innerHTML = 'Plantime from ' + params.start_time + ' to ' + params.stop_time + ' <br>\n';
	el.innerHTML += '\n<div class="time_table" id="table_time"></div>\n';

	var tt = document.getElementById("table_time");
	tt.innerHTML = 'Please wait... ';
	
 	send_request_post(
		'api/time/plantime.php',
		createUrlFromObj(params),
		function (obj) {
			var tt = document.getElementById("table_time");
			if (obj.result == 'fail')
			{
				tt.innerHTML = obj.error.message;
				return;
			}
			tt.innerHTML = '\n';
			
			var content = '';
			content += '<div class="time_row_h">\n';
			content += '	<div class="time_cell_h">Date</div>\n';
			content += '	<div class="time_cell_h">Time</div>\n';
			content += '	<div class="time_cell_h">Summary</div>\n';
			content += '</div>\n';
			tt.innerHTML += content;

			for (var i = 0; i < obj.data.length; i++) {
				
				var date1 = obj.data[i].start_time.split(' ')[0];
				var time1 = obj.data[i].start_time.split(' ')[1];
				var date2 = obj.data[i].stop_time.split(' ')[0];
				var time2 = obj.data[i].stop_time.split(' ')[1];

				content = '';
				content += '<div class="time_row" onclick="editFormPlantime(' + obj.data[i].id + ');">\n';
				content += '	<div class="time_cell">' + date1 + '</div>\n';
				content += '	<div class="time_cell">' + time1 + '-' + time2 + '</div>\n';
				content += '	<div class="time_cell">' + obj.data[i].sum + '</div>\n';
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
	
	el.innerHTML += '<div class="btn" onclick="insertFormPlantime();">add new</div>';
};

function insertFormPlantime() {
	var content = '';
	var start_time = document.getElementById("start_time").value;
	start_time = start_time.split(' ')[0];
	content += 'Date: <input id="insert_date" type="text" value="' + start_time + '"><br>';
	content += 'Time from <input id="insert_start_time" type="text" value="00:00:00"> <br>';
	content += 'Time to <input id="insert_stop_time" type="text" value="00:00:00"><br>';
	content += '<div class="btn" onclick="insertPlantime();">insert</div>';
	showModalDialog(content);
}

function insertPlantime() {
	var date0 = document.getElementById("insert_date").value;
	var params = {};
	params.start_time = date0 + ' ' + document.getElementById("insert_start_time").value;
	params.stop_time = date0 + ' ' + document.getElementById("insert_stop_time").value;

	// alert(createUrlFromObj(params));
	send_request_post(
		'api/time/plantime_insert.php',
		createUrlFromObj(params),
		function (obj) {
			if (obj.result == 'fail') {
				alert(obj.error.message);
				return;
			} else {
				loadPlanTimePanel();
				closeModalDialog();
			}
		}
	);
}

function editFormPlantime(id) {
	var params = {};
	params.id = id;

	send_request_post(
		'api/time/plantime_get.php',
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
				content += '<div class="btn" onclick="updatePlantime(' + id + ');">update</div> ';
				content += '<div class="btn" onclick="deletePlantime(' + id + ');">delete</div>';
				showModalDialog(content);
			}
		}
	);
}

function deletePlantime(id) {
	if (!confirm("Are you sure that wand remove this record?"))
		return;

	var params = {};
	params.id = id;

	send_request_post(
		'api/time/plantime_delete.php',
		createUrlFromObj(params),
		function (obj) {
			if (obj.result == 'fail') {
				alert(obj.error.message);
				return;
			} else {
				loadPlanTimePanel();
				closeModalDialog();
			}
		}
	);
}
		
function updatePlantime(id) {
	var date0 = document.getElementById("update_date").value;
	var params = {};
	params.id = id;
	params.start_time = date0 + ' ' + document.getElementById("update_start_time").value;
	params.stop_time = date0 + ' ' + document.getElementById("update_stop_time").value;

	send_request_post(
		'api/time/plantime_update.php',
		createUrlFromObj(params),
		function (obj) {
			if (obj.result == 'fail') {
				alert(obj.error.message);
				return;
			} else {
				loadPlanTimePanel();
				closeModalDialog();
			}
		}
	);
}
