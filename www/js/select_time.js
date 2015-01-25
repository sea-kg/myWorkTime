function select_datetime_close() {
	var st = document.getElementById('select_time');
	st.style.display = "none";	
}

function set_select_datetime(idel1, idel2, time1, time2) {
	var el1 = document.getElementById(idel1);
	var el2 = document.getElementById(idel2);
	el1.value = time1;
	el2.value = time2;
	select_datetime_close();
}

function set_select_time(idel, time) {
	var el = document.getElementById(idel);
	el.value = time;
	select_datetime_close();
}

function daysInMonth(date) {
	return 32 - new Date(date.getFullYear(), date.getMonth(), 32).getDate();
};

function getWeekDay(date) {
    date = date || new Date();
    var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sut'];
    var day = date.getDay();
    return days[day];
}

function getFormattedMonth(date) {
	var month = "" + (date.getMonth()+1);
	if (month.length < 2)
		month = "0" + month;
	return month;
}

function getFormattedDay(date) {
	var day = "" + date.getDate();
	if (day.length < 2)
		day = "0" + day;
	return day;
}

function getFirstDayInMonth(date) {
	return date.getFullYear() + "-" + getFormattedMonth(date) + "-01";
}

function getLastDayInMonth(date) {
	var month = "" + (date.getMonth()+1);
	if (month.length < 2)
		month = "0" + month;
	return date.getFullYear() + "-" + getFormattedMonth(date) + "-" + daysInMonth(date);
}

function getFormattedDate(date) {
	return date.getFullYear() + "-" + getFormattedMonth(date) + "-" + getFormattedDay(date);
}

function getFirstDayInThisWeek(date)
{
	var tmpDate = new Date();
	tmpDate.setYear(date.getFullYear());
	tmpDate.setMonth(date.getMonth());
	tmpDate.setDate(date.getDate());
	while (tmpDate.getDay() != 1) {
		tmpDate.setDate(tmpDate.getDate() - 1);
	}
	return tmpDate;
}

function getLastDayInThisWeek(date)
{
	var tmpDate = new Date();
	tmpDate.setYear(date.getFullYear());
	tmpDate.setMonth(date.getMonth());
	tmpDate.setDate(date.getDate());
	while (tmpDate.getDay() != 0) {
		tmpDate.setDate(tmpDate.getDate() + 1);
	}
	return tmpDate;
}

function select_datetime(idel1, idel2) {
	var el1 = document.getElementById(idel1);
	var el2 = document.getElementById(idel2);
	var st = document.getElementById('select_time');	
	if (st.style.display == 'inline') {
		st.style.display = 'none';
		return;
	}
	
	var bodyRect = document.body.getBoundingClientRect();
	var el1Rect = el1.getBoundingClientRect();
	var el2Rect = el2.getBoundingClientRect();
	offset  = el1Rect.top - bodyRect.top;
	st.innerHTML = "";
	
	var currentdate = new Date();
	var prevweek = getFirstDayInThisWeek(currentdate);
	prevweek.setDate(prevweek.getDate() - 1);

	var arr = [];

	arr.push({
		'name': 'Previous week',
		'start_date' : getFormattedDate(getFirstDayInThisWeek(prevweek)),
		'stop_date' : getFormattedDate(getLastDayInThisWeek(prevweek))
	});

	arr.push({
		'name': 'This week',
		'start_date' : getFormattedDate(getFirstDayInThisWeek(currentdate)),
		'stop_date' : getFormattedDate(getLastDayInThisWeek(currentdate))
	});

	arr.push({
		'name': 'Today [' + getWeekDay(currentdate) + ']',
		'start_date' : getFormattedDate(currentdate),
		'stop_date' : getFormattedDate(currentdate)
	});

	arr.push({
		'name': 'This month',
		'start_date' : '' + getFirstDayInMonth(currentdate),
		'stop_date' : getLastDayInMonth(currentdate)
	});
	
	arr.push({
		'name': 'All time',
		'start_date' : '0000-00-00',
		'stop_date' : '9999-12-31'
	});


	for (var i = 0; i < arr.length; i++)
	{
		arr[i].start_date = arr[i].start_date + ' 00:00:00';
		arr[i].stop_date = arr[i].stop_date + ' 23:59:00';
	}

	for (var i = 0; i < arr.length; i++)
	{
		var content = '<div class="select_time_btn" ';
		content += 'onclick="set_select_datetime(';
		content += "'" + idel1 + "',";
		content += "'" + idel2 + "',";
		content += "'" + arr[i].start_date + "',";
		content += "'" + arr[i].stop_date + "'";
		content += ');">' + arr[i].start_date + ' - ' + arr[i].stop_date + ' (' + arr[i].name + ')';
		content += '</div>';
		st.innerHTML += content;
	}

	st.innerHTML += '<div class="select_time_btn" onclick="select_datetime_close();">close</div>';
	st.style.display = "inline";
	st.style.position = "absolute";
	st.style.left = el1Rect.left;
	st.style.top = el1Rect.top + el1Rect.height;
}

function select_time(idel) {
	var el = document.getElementById(idel);
	var st = document.getElementById('select_time');
	var bodyRect = document.body.getBoundingClientRect();
	var elRect = el.getBoundingClientRect();
	offset  = elRect.top - bodyRect.top;
	st.innerHTML = "";

	var arr = [];
	arr.push('00:00:00');
	arr.push('09:00:00');
	arr.push('13:00:00');
	arr.push('14:00:00');
	arr.push('18:00:00');
	arr.push('23:59:00');

	for (var i = 0; i < arr.length; i++) 
		st.innerHTML += '<div class="select_time_btn" onclick="set_select_time(\'' + idel + '\', \'' + arr[i] + '\');">' + arr[i] + '</div>';
	
	st.innerHTML += '<div class="select_time_btn" onclick="select_datetime_close();">close</div>';

	st.style.display = "inline";
	st.style.position = "absolute";
	st.style.left = elRect.left;
	st.style.top = elRect.top + elRect.height;
}

function create_elem_select_time(idelem)
{
	return '<div class="menu_select_time" onclick="select_time(\'' + idelem + '\');"><img src="img/select_time.png"/></div>';
}

function check_time(time)
{
	var reg = new RegExp("^[0-9]{4,4}-[0-9]{2,2}-[0-9]{2,2} [0-9]{2,2}:[0-9]{2,2}:[0-9]{2,2}$", "i");
	return reg.test(time);
	// return false;
}
