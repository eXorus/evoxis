<?php
//Session
session_start();

//Require_one
include("../inc/config.php");
include("../inc/mysql.php");

//MySQL
$db = new mysql($db_host,$db_username,$db_password,$db_name, TRUE);
$db->connect($db->host,$db->user,$db->pass,$db->base) or die( 'MySQL Lost: WS' );

function parse_bbcode_smiley_shoutbox($texte){
	/*
	##Smiley
	*/
	$in=array(
	 ":(", //normal
	 ":p",
	 ":)",
	 ":D",
	 ":evil:",
	 ":twisted:",
	 ":cry:",
	 ":?",
	 ":|",
	 "8)",
	 ":mrgreen:",
	 ":roll:",
	 ";)",
	 ":shock:",
	 ":O",
	 ":x",
	 ":lol:",
	 ":oops:"
	 );

	$out=array(
	 ' <img src="./img/smileysShout/icon_sad.gif" alt="sad" /> ' , //normal
	 ' <img src="./img/smileysShout/icon_razz.gif" alt="razz" /> ' ,
	 ' <img src="./img/smileysShout/icon_smile.gif" alt="smile" /> ' ,
	 ' <img src="./img/smileysShout/icon_biggrin.gif" alt="biggrin" /> ' ,
	 ' <img src="./img/smileysShout/icon_evil.gif" alt="evil" /> ' ,
	 ' <img src="./img/smileysShout/icon_twisted.gif" alt="twisted" /> ' ,
	 ' <img src="./img/smileysShout/icon_cry.gif" alt="cry" /> ' ,
	 ' <img src="./img/smileysShout/icon_confused.gif" alt="confused" /> ' ,
	 ' <img src="./img/smileysShout/icon_neutral.gif" alt="neutral" /> ' ,
	 ' <img src="./img/smileysShout/icon_cool.gif" alt="cool" /> ' ,
	 ' <img src="./img/smileysShout/icon_mrgreen.gif" alt="mrgreen" /> ' ,
	 ' <img src="./img/smileysShout/icon_rolleyes.gif" alt="rolleyes" /> ' ,
	 ' <img src="./img/smileysShout/icon_wink.gif" alt="wink" /> ' ,
	 ' <img src="./img/smileysShout/icon_eek.gif" alt="eek" /> ' ,
	 ' <img src="./img/smileysShout/icon_surprised.gif" alt="surprised" /> ' ,
	 ' <img src="./img/smileysShout/icon_mad.gif" alt="mad" /> ' ,
	 ' <img src="./img/smileysShout/icon_lol.gif" alt="lol" /> ' ,
	 ' <img src="./img/smileysShout/icon_redface.gif" alt="redface" /> '
	 );
	 
	$texte = str_replace($in,$out,$texte);
	//##EOF Smiley
		
	/*
	##Mise en forme du texte COMPLEXE
	*/		
	//Lien cliquable
	$texte = clicklien($texte)  ;
	//##EOF Mise en forme du texte COMPLEXE

	return $texte;
}

function clicklien($url){ 
$in=array( 
    '`((?:https?|ftp)://\S+[[:alnum:]]/?)`si', 
    '`((?<!//)(www\.\S+[[:alnum:]]/?))`si'
    ); 
$out=array( 
    '<a href="$1" target="_blank">(lien)</a>', 
    '<a href="http://$1" target="_blank">(lien)</a>'
    ); 
return preg_replace($in,$out,$url); 
} 

		//Group
		if($msg->gid==1){$pseudoGroup = 'ADMIN';}
		elseif($msg->gid==2 || $msg->gid==5){$pseudoGroup = 'RP';}
		elseif($msg->gid==3 || $msg->gid==8){$pseudoGroup = 'TECH';}
		elseif($msg->gid==4 || $msg->gid==9){$pseudoGroup = 'WELCOME';}
		else{$pseudoGroup = 'MEMBRE';}

		//Group infobulle
		if($msg->gid==1){$pseudoGroupInfo = 'Administrateur';}
		elseif($msg->gid==2 || $msg->gid==5){$pseudoGroupInfo = 'MJ&nbsp;Role&nbsp;Play';}
		elseif($msg->gid==3 || $msg->gid==8){$pseudoGroupInfo = 'MJ&nbsp;Technique';}
		elseif($msg->gid==4 || $msg->gid==9){$pseudoGroupInfo = 'MJ&nbsp;Welcome';}
		else{$pseudoGroup = 'MEMBRE';}


if(!empty($_POST['action'])){
	if($_POST['action']=="send" && !empty($_POST['text'])){
		
		$uid= (empty($_SESSION['uid'])) ? 0 : intval($_SESSION['uid']);
		$pseudo= (empty($_SESSION['pseudo'])) ? $_SESSION['pseudo']="Feufollet-".rand(0,99) : mysql_real_escape_string($_SESSION['pseudo']);
		
	
		$db->Send_Query("INSERT INTO exo_shoutbox_message(user_id, user_name, message, post_time) 
		VALUES (".$uid.", '".$pseudo."', '".mysql_real_escape_string($_POST['text'])."', NOW())");
	
	}
	elseif($_POST['action']=="get"){
		if(empty($_SESSION['last_msg'])){
			$message_query = $db->Send_Query("
			SELECT * FROM (
				SELECT message_id, user_id, user_name, message, DATE_FORMAT(post_time,'%H:%i') as post_time 
				FROM exo_shoutbox_message 
				ORDER BY message_id DESC 
				LIMIT 20) 
			AS exo_shoutbox_message 
			ORDER BY message_id ASC");
		}
		else{
			$message_query = $db->Send_Query("
			SELECT message_id, user_id, user_name, message, DATE_FORMAT(post_time,'%H:%i') as post_time 
			FROM exo_shoutbox_message WHERE message_id > ".intval($_SESSION['last_msg'])." ORDER BY message_id");
		}
	
		$messages = $db->loadObjectList($message_query);
		
		if(!empty($messages)){
			foreach($messages as $msg){
				$pseudo = (empty($msg->user_id)) ? htmlspecialchars($msg->user_name) : '<a href="./index.php?comp=profil&amp;select='.intval($msg->user_id).'">'.htmlspecialchars($msg->user_name).'</a>';
			
				echo $msg->post_time.'-
				<img src="./templates/default/ico/group_'.$pseudoGroup.'_thumb.png" style="cursor:help;" onmouseover="Tip(\''.$pseudoGroupInfo.'\')" onmouseout="UnTip()"/>
				 '
				.$pseudo
				.' <a onclick="To(\''.htmlspecialchars($msg->user_name).'\'); return false;"  href="#" ><img src="./templates/default/ico/comment.png" alt="comment" /></a>: '
				.parse_bbcode_smiley_shoutbox(htmlspecialchars($msg->message)).'<br />';
			}
			$_SESSION['last_msg'] = $msg->message_id;
		}
	}
}
?>