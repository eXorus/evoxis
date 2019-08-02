<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_PROFIL_ACCOUNT
define( '_VALID_CORE_PROFIL_ACCOUNT', 1 );

//Formulaire envoy�
if(!empty($_GET['task']) && $_GET['task']=="process"){

	//NEVER TRUST USER INPUT !!	
	$send_pseudo = mysql_real_escape_string(trim($_POST['pseudo']));
	$send_prenom = mysql_real_escape_string(trim($_POST['prenom']));
	
	$send_ddnj = intval($_POST['ddnj']);
	$send_ddnm = intval($_POST['ddnm']);
	$send_ddna = intval($_POST['ddna']);
	$send_birthday = $send_ddna.'-'.$send_ddnm.'-'.$send_ddnj;
	
	$send_lieu = mysql_real_escape_string(trim($_POST['lieu']));
	$send_fuseau =intval($_POST['fuseau']);
	$send_sexe = intval($_POST['sexe']);
	
	if(empty($_POST['case_email_view'])){
		$send_case_email_view = 0;
	}
	else{
		$send_case_email_view = 1;
	}
	
	$send_icq = mysql_real_escape_string(trim($_POST['icq']));
	$send_aim = mysql_real_escape_string(trim($_POST['aim']));
	$send_msn = mysql_real_escape_string(trim($_POST['msn']));
	$send_yahoo = mysql_real_escape_string(trim($_POST['yahoo']));
	$send_skype = mysql_real_escape_string(trim($_POST['skype']));
	
	//Check si pseudo existe deja
	if(!empty($send_pseudo)){
		$result = $db->Send_Query("SELECT COUNT(*) FROM exo_users WHERE pseudo='$send_pseudo' OR username='$send_pseudo'");
		$ligne = $db->get_array($result, $mode='NUMERIC');
		if($ligne[0]>0){
			$send_pseudo = $_SESSION['username'];
		}
	}
	else{
		$send_pseudo = $_SESSION['username'];
	}
	
	$_SESSION['pseudo'] = $send_pseudo;

	
	//Query
	$rq = $db->Send_Query("
			UPDATE exo_users 
			SET 	pseudo='$send_pseudo', 
					realname='$send_prenom',
					birthday='$send_birthday',
					lieu='$send_lieu',
					fuseau='$send_fuseau',
					sexe='$send_sexe',
					icq='$send_icq',
					aim='$send_aim',
					msn='$send_msn',
					yahoo='$send_yahoo',
					skype='$send_skype',
					email_view='$send_case_email_view'
			WHERE uid='".$_SESSION['uid']."'");	
			
	$msg = message::getInstance('SUCCESS','Edition du profil r�ussi', 'index.php?comp=profil_account');
}


//Envoie des donn�es
$rq = $db->Send_Query("
			SELECT pseudo, realname, birthday, lieu, fuseau, sexe, icq, aim, msn, yahoo, skype, email, email_view
			FROM exo_users 
			WHERE uid='".$_SESSION['uid']."'");
$result = $db->get_array($rq);

$form_pseudo = stripslashes(htmlspecialchars($result['pseudo']));
$form_realname = stripslashes(htmlspecialchars($result['realname']));

$form_email = $result['email'];
if($result['email_view']==0) $form_email_view=0;
else $form_email_view=1;

$form_fuseau = $result['fuseau'];

list($form_ddna, $form_ddnm, $form_ddnj) = explode("-", $result['birthday']);

$form_lieu = stripslashes(htmlspecialchars($result['lieu']));
$form_fuseau = $result['fuseau'];
$form_sexe = $result['sexe'];

$form_icq = stripslashes(htmlspecialchars($result['icq']));
$form_aim = stripslashes(htmlspecialchars($result['aim']));
$form_msn = stripslashes(htmlspecialchars($result['msn']));
$form_yahoo = stripslashes(htmlspecialchars($result['yahoo']));
$form_skype = stripslashes(htmlspecialchars($result['skype']));

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'profil';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Profil' => 'index.php?comp=profil',
'Modifier mon profil' => ''
);
$ws_name_perso = 'Evoxis v5 - Modifier mon profil';
?>