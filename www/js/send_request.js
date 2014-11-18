function send_request(url, callbackf) {
	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	};  
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var obj = JSON.parse(xmlhttp.responseText);
			callbackf(obj);
		}
	}
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

function send_request_page(url, callbackf) {
	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	};  
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			callbackf(xmlhttp.responseText);
		}
	}
	xmlhttp.open("GET",url,true);
	xmlhttp.send();	
}

/*
function send_post_request(page, url, callback_func)
{
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	};  
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			if(xmlhttp.responseText == "")
				alert("error");
			else
			{
				callback_func(xmlhttp.responseText);
			}
		}
	}
	xmlhttp.open("POST",page, true);
	xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhttp.send(url);
};

*/
