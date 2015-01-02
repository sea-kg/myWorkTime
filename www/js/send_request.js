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

function createUrlFromObj(obj) {
	var str = "";
	for (k in obj) {
		if (str.length > 0)
		str += "&";
		str += encodeURIComponent(k) + "=" + encodeURIComponent(obj[k]);
	}
	return str;
}

function send_request_post(page, url, callbackf)
{
	var tmpXMLhttp = null;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		tmpXMLhttp=new XMLHttpRequest();
	};
	tmpXMLhttp.onreadystatechange=function() {
		if (tmpXMLhttp.readyState==4 && tmpXMLhttp.status==200) {
			if(tmpXMLhttp.responseText == "")
				alert("error");
			else
			{
				var obj = JSON.parse(tmpXMLhttp.responseText);
				callbackf(obj);
				tmpXMLhttp = null;
			}
		}
	}
	tmpXMLhttp.open("POST", page, true);
	tmpXMLhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	tmpXMLhttp.send(url);
};

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

function showModalDialog(content)
{
	// document.getElementById('modal_dialog').style.top = document.body.
	document.getElementById('modal_dialog').style.visibility = 'visible';
	document.getElementById('modal_dialog_content').innerHTML = content;
	document.documentElement.style.overflow = 'hidden';  // firefox, chrome
    document.body.scroll = "no"; // ie only
    document.onkeydown = function(evt) {
		if (evt.keyCode == 27)
			closeModalDialog();
	}
}

function closeModalDialog()
{
	document.getElementById('modal_dialog').style.visibility = 'hidden';
	document.documentElement.style.overflow = 'auto';  // firefox, chrome
    document.body.scroll = "yes"; // ie only
    document.onkeydown = null;
}

