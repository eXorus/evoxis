<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_BG_WRITE
define( '_VALID_CORE_GUILDS_BG_WRITE', 1 );

$guildid = intval($_GET['guildid']);

if($_GET['action']=="ask_validation" && !empty($_GET['select'])){
	$rq = $db->Send_Query("
	UPDATE exo_guilds
	SET statut = 'EN_ATTENTE'	
	WHERE wowid = '".intval($_SESSION['wow_id'])."' AND guildid='".intval($_GET['select'])."'");
	
	$msg = message::getInstance('SUCCESS','Demande de validation de guilde réussie', 'index.php?comp=guilds_bg_write&action=edit&select='.intval($_GET['select']));
}
elseif($_GET['action']=="process" && !empty($_GET['select'])){
	//Récupère le texte
	$background = mysql_real_escape_string($_POST['background']);
	$goals = mysql_real_escape_string($_POST['goals']);
	$hall = mysql_real_escape_string($_POST['hall']);
	$hierarchy = mysql_real_escape_string($_POST['hierarchy']);
	$rules = mysql_real_escape_string($_POST['rules']);
	$accepted = mysql_real_escape_string($_POST['accepted']);
	if(empty($_POST['membersview'])){ $members_view = 0; }
	else{ $members_view = 1; }
	$guildid = intval($_GET['select']);

	//Update des nouvelles données
	$rq = $db->Send_Query("
		UPDATE exo_guilds
		SET
		background = '$background',
		goals = '$goals',
		hall = '$hall',
		hierarchy = '$hierarchy',
		rules = '$rules',
		accepted = '$accepted',
		last_edit_time = '".date('Y-m-d H:i:s')."',
		members_view = $members_view
		WHERE guildid = '$guildid' AND wowid='".$_SESSION['wow_id']."'");
	//Spyvo
	$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'GUILD', 'Edit guild;WOW_ID='.$_SESSION['wow_id'].';GUID='.$guid.';GUILDID='.$guildid);
	
	$msg = message::getInstance('SUCCESS','Edition de la guilde réussie', 'index.php?comp=guilds_bg_write&action=edit&select='.$guildid);

	
}
elseif($_GET['action']=="edit" && !empty($_GET['select'])){

	//Recuperation des infos de la DB
	$rq = $db->Send_Query("
		SELECT *
		FROM exo_guilds
		WHERE guildid ='".intval($_GET['select'])."' AND wowid='".$_SESSION['wow_id']."'");
	$guilds = $db->get_array($rq);
}else{
	$msg = message::getInstance('N/A','N/A', './templates/404.html');
}




/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'guildes';

/*
* MANAGE PATHWAY
*/
$pathway = array(
'Guilds' => ''
); 
$ws_name_perso = 'Evoxis v5 - Rédaction du background de la guilde';
?>
