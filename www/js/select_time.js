function select_datetime_close() {
	var st = document.getElementById('select_time');
	st.style.display = "none";	
}

function set_select_datetime(idel, time) {
	var el = document.getElementById(idel);
	el.value = time;
	select_datetime_close();
}
	
function select_datetime(idel) {
	var el = document.getElementById(idel);
	var st = document.getElementById('select_time');
	var bodyRect = document.body.getBoundingClientRect();
	var elRect = el.getBoundingClientRect();
	offset  = elRect.top - bodyRect.top;
	st.innerHTML = "";
	
	var currentdate = new Date();
	var month = "" + (currentdate.getMonth()+1);
	if (month.length < 2)
		month = "0" + month;
	var datetime = currentdate.getFullYear() + "-" + month + "-" + currentdate.getDate();

	var arr = [];
	arr.push(datetime + ' 00:00:00');
	arr.push(datetime + ' 23:59:00');
	
	arr.push('0000-00-00 00:00:00');
	arr.push('9999-12-31 23:59:00');

	for (var i = 0; i < arr.length; i++) 
		st.innerHTML += '<div class="select_time_btn" onclick="set_select_datetime(\'' + idel + '\', \'' + arr[i] + '\');">' + arr[i] + '</div>';
	
	st.innerHTML += '<div class="select_time_btn" onclick="select_datetime_close();">close</div>';
	
	st.style.display = "inline";
	st.style.position = "absolute";
	st.style.left = elRect.left;
	st.style.top = elRect.top + elRect.height;
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
		st.innerHTML += '<div class="select_time_btn" onclick="set_select_datetime(\'' + idel + '\', \'' + arr[i] + '\');">' + arr[i] + '</div>';
	
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
