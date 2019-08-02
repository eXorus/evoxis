<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_BUGTRACKER_VIEW
define( '_VALID_CORE_BUGTRACKER_VIEW', 1 );
require_once("./inc/bugtracker.class.php");
require_once("./inc/bugtrackerComment.class.php");
$select = intval($_GET['select']);


//va chercher les infos du bug
$o = new bugtracker();
$o->id = $select;
$bug = $o->get();


$oc = new bugtrackerComment();
$oc->bug = $select;
$comments = $oc->getComments();

//Commentaires lu
if(!empty($_SESSION['uid'])){
	$nbr_lu = $db->get_result($db->Send_Query('SELECT uid FROM exo_lu_bugtracker WHERE btid = '.$select.' AND uid = '.$_SESSION['uid'].''), 0);
	$last_btcid= $db->get_result($db->Send_Query('SELECT MAX(btcid) AS last_btcid FROM exo_bugtracker_commentaires WHERE btid='.$select),0);
	
	if ($nbr_lu == 0)
	{
		$query_lu = "INSERT INTO exo_lu_bugtracker (uid, btid, last_btcid)
		VALUES ('".$_SESSION['uid']."', '".$select."','".$last_btcid."')";
		$db->Send_Query($query_lu);
	}
	else
	{
		$query_lu = "UPDATE exo_lu_bugtracker SET last_btcid='$last_btcid' WHERE uid='".$_SESSION['uid']."' AND btid='$select'";
		$db->Send_Query($query_lu);
		
	}
}


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'bug';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'BugTracker' => 'index.php?comp=bugtracker',
'Visualisation' => ''
);
$ws_name_perso = 'Evoxis v5 - Détails d\'un bug';
?>