var position = 0;
function AJAXRequest(page,retfonc,methode,data) {
	var xhr_object = null;
	if(window.XMLHttpRequest)
	   xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject)
	   xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else {
	   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
	   return;
	}
	if (data=="")
		data=null;
	if(methode == "GET" && data != null) { 
	   page += "?"+data; 
	   data = null; 
	}
	xhr_object.open(methode, page, true);
	xhr_object.onreadystatechange = function() {
		if(xhr_object.readyState == 4) {
			var RetAjax=xhr_object.responseText;
			eval(retfonc+'(RetAjax);');
                }
	}
	if(methode == "POST")
	   xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_object.send(data);
}

function Send() {
	AJAXRequest("./core/shoutbox.php","Reload","POST","action=send&text="+encodeURIComponent(document.getElementById('ShoutText').value));
	document.getElementById('ShoutText').value='';
}

function Reload() {
	AJAXRequest("./core/shoutbox.php","Show","POST","action=get");
	shoutbox_refresh=setTimeout("Reload()",20000);
}

function Show(v) {
	if(v!=''){
		if(position==0 || position==document.getElementById('ShoutContent').scrollTop){
			document.getElementById('ShoutContent').innerHTML=document.getElementById('ShoutContent').innerHTML+v;
			document.getElementById('ShoutContent').scrollTop = document.getElementById('ShoutContent').scrollHeight;
			position = document.getElementById('ShoutContent').scrollTop;
		}
		else{
			document.getElementById('ShoutContent').innerHTML=document.getElementById('ShoutContent').innerHTML+v;
		}
	}
}

function To(name) {	
	document.getElementById('ShoutText').value=name+'> ';
}