
function body_onload() {
	load_companies('treeview');
}

function load_log() {
  var e = document.getElementById('content');
	e.innerHTML = "loading data...";
	send_request_page("pages/log.php",
		function(obj) {
			e.innerHTML = obj;
		}
	);
}

function load_steps() {
  var e = document.getElementById('content');
	e.innerHTML = "loading data...";
	send_request_page("pages/steps.php",
		function(obj) {
			e.innerHTML = obj;
		}
	);
}

function load_about() {
  var e = document.getElementById('content');
	e.innerHTML = "loading data...";
	send_request_page("pages/about.php",
		function(obj) {
			e.innerHTML = obj;
		}
	);
}

function fixedEncodeURIComponent(str) {
	return encodeURIComponent(str).replace(/[!'()*]/g, function(c) {
		return '%' + c.charCodeAt(0).toString(16);
	});
}
