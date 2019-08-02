<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_BUGTRACKER_WRITE
define( '_VALID_CORE_BUGTRACKER_WRITE', 1 );
require_once("./inc/bugtracker.class.php");
$o = new bugtracker();
require_once("./inc/bugtrackerComment.class.php");
$oc = new bugtrackerComment();


if(!empty($_GET['task']) && $_GET['task']=='addcomment' && !empty($_POST['comment'])){
	//NEW COMMENT
	
	$oc->comment = mysql_real_escape_string($_POST['comment']);
	$oc->bug = intval($_POST['btid']);
	$oc->from = intval($_SESSION['uid']);
	$oc->time_create = time();
	
	$oc->id = $oc->add();
	
	
	$o->id = $oc->bug;
	$o->editForComment($oc->id);
		
	$msg = message::getInstance('SUCCESS','Commentaire de bug ajouté', 'index.php?comp=bugtracker_view&amp;select='.$oc->bug);
}
if(!empty($_GET['task']) && $_GET['task']=='autoComment' && !empty($_GET['btid']) && !empty($_GET['param'])){
	//NEW COMMENT AUTO
	
	if($_GET['param']=='A') $comment = "Déclaration de bug en doublon merci de lire avant de poster";
	elseif($_GET['param']=='B') $comment = "Merci de poster un lien vers Judghype (ou autre) illustrant le comportement correct";
	
	$oc->comment = mysql_real_escape_string($comment);
	$oc->bug = intval($_GET['btid']);
	$oc->from = intval($_SESSION['uid']);
	$oc->time_create = time();
	
	$oc->id = $oc->add();
	
	
	$o->id = $oc->bug;
	$o->editForComment($oc->id);
		
	$msg = message::getInstance('SUCCESS','Commentaire auto de bug ajouté', 'index.php?comp=bugtracker_view&amp;select='.$oc->bug);
}
else if (!empty($_GET['task']) && $_GET['task']=='process' && !empty($_POST['categorie']) && !empty($_POST['titre']) &&  !empty($_POST['message'])){

	$o->id = intval($_POST['btid']);
	$o->categorie = intval($_POST['categorie']);
	$o->name = mysql_real_escape_string($_POST['titre']);
	$o->description = mysql_real_escape_string($_POST['message']);
	$o->time_create = time();
	$o->from = intval($_SESSION['uid']);
	$o->link = mysql_real_escape_string($_POST['link']);
	
	$o->id = $o->add();
		
	$msg = message::getInstance('SUCCESS','Bug ajouté', 'index.php?comp=bugtracker_view&amp;select='.$o->id);
}
else if (!empty($_GET['task']) && $_GET['task']=='modStatut' && !empty($_POST['btid'])  && !empty($_POST['state'])){
	$o->id = intval($_POST['btid']);
	$o->from = intval($_SESSION['uid']);
	$o->etat = intval($_POST['state']);
	$o->time_end = time();
	$o->sql = mysql_real_escape_string($_POST['form_sql']);
	
	$o->modStatut();
	
	$msg = message::getInstance('SUCCESS','Statut modifié', ' index.php?comp=bugtracker');
}
else if (!empty($_GET['task']) && $_GET['task']=='edit' && !empty($_GET['select'])){
	$o->id = intval($_GET['select']);	
	$bugToEdit = $o->get();
	
}



//liste des Catégories
$rq = $db->Send_Query("
	SELECT btcid, name
	FROM exo_bugtracker_categories");
$listcat = $db->loadObjectList($rq);
	
/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'bug';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'BugTracker' => 'index.php?comp=bugtracker',
'Rédaction' => ''
);
$ws_name_perso = 'Evoxis v5 - Signaler un bug';
?>