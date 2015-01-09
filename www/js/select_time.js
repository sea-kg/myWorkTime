function select_time_close() {
	var st = document.getElementById('select_time');
	st.style.display = "none";	
}

function set_select_time(idel, time) {
	var el = document.getElementById(idel);
	el.value = time;
	select_time_close();
}
	
function select_time(idel) {
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

	for (var i = 0; i < arr.length; i++) 
		st.innerHTML += '<div class="select_time_btn" onclick="set_select_time(\'' + idel + '\', \'' + arr[i] + '\');">' + arr[i] + '</div>';
	
	st.innerHTML += '<div class="select_time_btn" onclick="select_time_close();">close</div>';
	
	st.style.display = "inline";
	st.style.position = "absolute";
	st.style.left = elRect.left;
	st.style.top = elRect.top + elRect.height;
	
	

//     alert('Element is ' + offset + ' vertical pixels from <body>');

// 	alert(idel);
}
