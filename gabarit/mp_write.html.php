<?php
defined( '_VALID_CORE_MP_WRITE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

$onglet =  '
<div id="onglets"><center><table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">
<a href="./index.php?comp=mp_write"><b>Ecrire un message</b></a> | <a href="./index.php?comp=mp">Mes Messages</a></td><td class="onglet_right"></td></tr></table></center></div>';

echo $onglet;

?>

<div id="blockFormulaire">
<form id="post" method="post" name="formulaire" action="index.php?comp=mp_write&amp;task=process">

<h1>Ecrivez votre message</h1><h4> &nbsp;</h4><br />
	
		<?php
		if(empty($dpID)){
			$to = empty($_GET['to']) ? $_POST['to'] : urldecode($_GET['to']);
			
			echo '
				<label for="to">A : (login)</label><input type="text" autocomplete="off" name="to" id="to" size="80" maxlength="70" value="'.$to.'" onkeyup="getPseudo();"/><br />
				<span id="suggest"></span>
				<label>Sujet :</label><input type="text" name="subject" id="subject" size="80" maxlength="70" value="'.$_POST['subject'].'"/>
				<label>Sous-Sujet :</label><input type="text" name="ssubject" id="ssubject" size="80" maxlength="70" value="'.$_POST['ssubject'].'"/>';
		}
		?>
		
<br />
		<?php include('./inc/bbcode.html.php'); ?>
<div class="topic_top"></div>
<div class="topic_middle">
<textarea name="message" id="message" rows="20" cols="95"><?php echo $_POST['message']; ?></textarea>
</div><div class="topic_bottom"></div>

<input type="hidden" name="dpID" value="<?php echo $dpID ?>" />
<br /><input type="submit" name="submit" value="Envoyer"/>
		
</form>
</div>
<br /><br />


<?php


if(!empty($mps)){
echo '<h1>'.stripslashes(htmlspecialchars($mps[0]->dpTitle)).'</h1><h4>'.stripslashes(htmlspecialchars($mps[0]->dpUnderTitle)).'</h4>';
	
	foreach($mps as $mp){
		echo '
			<div id="mpid'.$mp->mpid.'" class="blockCommentaire">
				<div class="blockCommentaireHeader">De '.$mp->pseudo.' le '.$mp->mpDateCreation.'</div>
				<div class="blockCommentaireBody">'.stripslashes(nl2br(htmlspecialchars($mp->mpMessage))).'
					<div align="right">
						<a href="#top"><img src="./templates/'.$link_style.'/ico/topic_up.gif" height="20px" width="20px" align="top" title="Haut de page" alt="Haut de page"/></a>&nbsp;
						<a href="#bot"><img src="./templates/'.$link_style.'/ico/topic_down.gif" height="20px" width="20px" align="top" title="Bas de page" alt="Bas de page"/></a>
					</div>
				</div>
			</div>
			';
	}
}

echo $onglet;

require_once('./templates/'.$link_style.'bottom.php');
?>

<SCRIPT language="Javascript">

function AJAXRequestXML(page,retfonc,methode,data) {
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
			var RetAjax=xhr_object.responseXML;
			eval(retfonc+'(RetAjax);');
                }
	}
	if(methode == "POST")
	   xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_object.send(data);
}

function getPseudo(){
	
	var to = document.getElementById("to").value;
	
	if(to.lastIndexOf(",")!=-1){
		to = to.substr(to.lastIndexOf(",")+1, to.length)
	}
	
	if (to.length > 2){
		to = to.replace(/^\s*|\s*$/,"");
		AJAXRequestXML("./inc/ajax/getPseudos.php","majListPseudo","GET","q="+escape(to));
    }
	else{
		document.getElementById('suggest').innerHTML = "";
    }
}

function majListPseudo(xml){
	document.getElementById('suggest').innerHTML="";
	
	var nbGroups = xml.getElementsByTagName('group').length;
	var nbUsers = xml.getElementsByTagName('user').length;
	var nbGuilds = xml.getElementsByTagName('guild').length;
	
	if(nbGroups!=0){
		for (i=0 ; i<nbGroups ; i++)
		{
			var group = xml.getElementsByTagName('group')[i];
			var name = group.getElementsByTagName('name')[0].firstChild.nodeValue;
			var membres = group.getElementsByTagName('membres')[0].firstChild.nodeValue;
			
			document.getElementById('suggest').innerHTML=
				document.getElementById('suggest').innerHTML
				+"<a href=\"javascript:completion('"+membres+"')\">"
				+name
				+"</a><br />";
		}		
		document.getElementById('suggest').innerHTML=document.getElementById('suggest').innerHTML+"<hr>";
	}
	
	if(nbGuilds!=0){
		for (i=0 ; i<nbGuilds ; i++)
		{
			var guild = xml.getElementsByTagName('guild')[i];
			var name = guild.getElementsByTagName('name')[0].firstChild.nodeValue;
			var membres = guild.getElementsByTagName('membres')[0].firstChild.nodeValue;
			
			document.getElementById('suggest').innerHTML=
				document.getElementById('suggest').innerHTML
				+"<a href=\"javascript:completion('"+membres+"')\">"
				+name
				+"</a><br />";
		}		
		document.getElementById('suggest').innerHTML=document.getElementById('suggest').innerHTML+"<hr>";
	}
	
	for (i=0 ; i<nbUsers ; i++)
	{
		var user = xml.getElementsByTagName('user')[i];
		var username = user.getElementsByTagName('username')[0].firstChild.nodeValue;
		var pseudo = user.getElementsByTagName('pseudo')[0].firstChild.nodeValue;
		var image = user.getElementsByTagName('image')[0].firstChild.nodeValue;
		
		if(image!=0){
			var img = "<img src=\"./img/pictures/"+image+"\" alt=\"Photo de "+username+"\" width=32 height=32 />";
		}
		else{
			var img = "<img src=\"./img/pictures/0.png\" alt=\"Pas de photo\" width=32 height=32 />";
		}
		
		document.getElementById('suggest').innerHTML=
			document.getElementById('suggest').innerHTML
			+"<a href=\"javascript:completion('"+username+"')\">"
			+img
			+username
			+" - "+pseudo
			+"</a><br />";
	}
}

function completion(mot){
		
	if(document.getElementById("to").value.lastIndexOf(",")==-1){
		document.getElementById("to").value = mot + ", "; 
	}
	else{
		var oldWords = document.getElementById("to").value.split(",");
		var nbWords = oldWords.length;
		document.getElementById("to").value = "";	
		
		for(var i=0; i<nbWords; i++){
			
			if(nbWords-1==i){
				document.getElementById("to").value = document.getElementById("to").value + mot + ", ";
			}
			else{				
				document.getElementById("to").value = document.getElementById("to").value + oldWords[i].replace(/^\s*|\s*$/,"") + ", " ;
			}
		}
	}
	
	document.getElementById('suggest').innerHTML='';
	document.getElementById('to').focus();
}

</SCRIPT>
  

