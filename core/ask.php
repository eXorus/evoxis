<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_ASK', 1 );

require_once("./inc/askConfig.class.php");
require_once("./inc/ask.class.php");

$myask = new askConfig($_GET['onglet']);


$create_captcha = trim($_POST['create_captcha']);

if(!empty($_GET['task']) && $_GET['task']=="process"){
	
	if(!empty($_POST['form_type']) && !empty($_POST['form_cible']) && !empty($_POST['form_ask']) && $create_captcha==$_SESSION['code']){
	
		$oi = new ask();
		$oi->ID = "NULL";
		$oi->Type = intval($_POST['form_type']);
		$oi->Cible = intval($_POST['form_cible']);
		$oi->Ask = mysql_real_escape_string($_POST['form_ask']);
		$oi->Link = mysql_real_escape_string($_POST['form_linkJudgeHype']);
		
		$oi->insert();
		
		//Spyvo
		$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'ASK', 'Demande;'.realip().';'.$_SERVER["HTTP_USER_AGENT"]);
		
		$msg = message::getInstance('SUCCESS','Demande ajoutée', 'index.php?comp=ask&amp;action=message');
	}
	else{
		$_SESSION['message'] = "Erreur (captchat incorrect, demande vide, cible non valide)";
	}

}
elseif(!empty($_GET['task']) && $_GET['task']=="activate"){
	$key = mysql_real_escape_string($_GET['key']);
	$askid = intval($_GET['askid']);

	$rq = $db->Send_Query("
			SELECT activate_string
			FROM exo_users 
			WHERE activate_key='$key' AND activate_string=$askid");
			
	if ($db->num_rows($rq)==1){
	
		$result = $db->get_array($rq);
		//Query
		$rq = $db->Send_Query("
				UPDATE exo_ask
				SET 	aDateOpen='".time()."',
						aState='OPEN'
				WHERE aID=$askid");
				
		$msg = message::getInstance('SUCCESS','Votre demande est en attente de validation par l\'équipe MJ, vous recevrez un MP lors de son traitement', 'index.php');
	}
	else{
		$msg = message::getInstance('ERROR','Votre demande est incorrecte', 'index.php');
	}
}


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'charte';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Demandes' => ''
);
$ws_name_perso = 'Evoxis v5 - Demandes';
?>