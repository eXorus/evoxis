<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_ASKFOCUS', 1 );

if($_GET['task']=='process'){
	$id = intval($_POST['form_aID']);
	$comment = mysql_real_escape_string($_POST['form_comment']);
	
	//Recherche de son uid:
	$query = "
		SELECT CONCAT_WS('',A.uid, C.uid, D.uid) AS uid, adpID
		FROM exo_ask
		LEFT JOIN exo_ask_config ON aType=acID
		LEFT JOIN exo_users A ON (A.uid=aCible AND acCible='CT')
		LEFT JOIN exo_backgrounds B ON (B.guid=aCible AND acCible='PV')
		LEFT JOIN exo_users C ON C.wow_id=B.wow_id
		LEFT JOIN exo_guilds E ON (E.guildid=aCible AND acCible='GD')
		LEFT JOIN exo_users D ON D.wow_id=E.wowid
		WHERE aID = '$id'";
	$result = $db->Send_Query($query);
	$rs = $db->get_array($result);
	$uid_cible = $rs['uid'];
	$dpID = $rs['adpID'];
	
	//OPEN -> VALIDATE
	if(!empty($_POST['result'])){
		if ($_POST['result']=='VALIDATE'){			
			//Envoie d'un MP
			$data = array();
			$data[0] = "Changement d'état";
			$data[1] = "";
			$data[2] = $comment;
			sendAutoMP(6, $uid_cible, $data, $dpID);
			
			$query = "UPDATE exo_ask SET aDateValidate='".time()."', aState='VALIDATE', aComment=CONCAT_WS('\n\n [OPEN->VALIDATE par ".$_SESSION['admin_username']."] \n',aComment, '$comment') WHERE aID = '$id' AND aState='OPEN'";
			$update = $db->Send_Query($query);
		}
		elseif($_POST['result']=='REFUSED'){
			//Envoie d'un MP
			$data = array();
			$data[0] = "Changement d'état";
			$data[1] = "";
			$data[2] = $comment;
			sendAutoMP(9, $uid_cible, $data, $dpID);
				
			$query = "UPDATE exo_ask SET aDateRefused='".time()."', aState='REFUSED', aComment=CONCAT_WS('\n\n [OPEN->REFUSED par ".$_SESSION['admin_username']."] \n',aComment, '$comment') WHERE aID = '$id' AND aState='OPEN'";
			$update = $db->Send_Query($query);
		}
	}
	//VALIDATE -> ASSIGN
	elseif(!empty($_POST['form_assigntovalue'])){
		$mj = intval($_POST['form_assigntovalue']);
		$r = $db->get_array($db->Send_Query("SELECT username FROM exo_users WHERE uid=$mj"));
		$mj_name = $r['username'];
		
		//Envoie d'un MP
		$data = array();
		$data[0] = "Changement d'état";
		$data[1] = "";
		$data[2] = '[url='.$ws_domain.'index.php?comp=profil&select='.$mj.']'.$mj_name.'[/url]';
		$data[3] = $comment;
		sendAutoMP(7, $uid_cible, $data, $dpID);
		
		$query = "UPDATE exo_ask SET aDateAssign='".time()."', aState='ASSIGN', aAssignTo=$mj, aComment=CONCAT_WS('\n\n [VALIDATE->ASSIGN par ".$_SESSION['admin_username']."] \n',aComment, '$comment') WHERE aID = '$id' AND aState='VALIDATE'";
		$update = $db->Send_Query($query);
	}
	//ASSIGN -> DONE
	elseif(!empty($_POST['result2'])){
		if ($_POST['result2']=='DONE'){
			//Envoie d'un MP
			$data = array();
			$data[0] = "Changement d'état";
			$data[1] = "";
			$data[2] = $comment;
			sendAutoMP(8, $uid_cible, $data, $dpID);
			
			$query = "UPDATE exo_ask SET aDateDone='".time()."', aState='DONE', aComment=CONCAT_WS('\n\n [ASSIGN->DONE par ".$_SESSION['admin_username']."] \n',aComment, '$comment') WHERE aID = '$id' AND aState='ASSIGN' AND aAssignTo=".intval($_SESSION['admin_uid'])."";
			$update = $db->Send_Query($query);
		}
		elseif($_POST['result2']=='REFUSED'){
			//Envoie d'un MP
			$data = array();
			$data[0] = "Changement d'état";
			$data[1] = "";
			$data[2] = $comment;
			sendAutoMP(9, $uid_cible, $data, $dpID);
			
			$query = "UPDATE exo_ask SET aDateRefused='".time()."', aState='REFUSED', aComment=CONCAT_WS('\n\n [ASSIGN->REFUSED par ".$_SESSION['admin_username']."] \n',aComment, '$comment') WHERE aID = '$id' AND aState='ASSIGN' AND aAssignTo=".intval($_SESSION['admin_uid'])."";
			$update = $db->Send_Query($query);
		}
	}
	$msg = message::getInstance('SUCCESS','Etat modifié', 'index.php?comp=askFocus&select='.$id);
}



$select = intval($_GET['select']);

$query = "
		SELECT aID, acTitle, aState, aAsk, CONCAT_WS('',A.username, exo_backgrounds.name, exo_guilds.name) AS cible, aLink, aDateOpen, aDateValidate, aDateAssign, aDateDone, aDateRefused, B.username as assignto, aComment
		FROM exo_ask
		LEFT JOIN exo_ask_config ON aType=acID
		LEFT JOIN exo_users B ON B.uid=aAssignTo
		LEFT JOIN exo_users A ON (A.uid=aCible AND acCible='CT')
		LEFT JOIN exo_backgrounds ON (guid=aCible AND acCible='PV')
		LEFT JOIN exo_guilds ON (guildid=aCible AND acCible='GD')
		WHERE aID = '$select'";
$result = $db->Send_Query($query);
$rs = $db->get_array($result);
	

	


?>
