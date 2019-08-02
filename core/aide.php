<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_AIDE
define( '_VALID_CORE_AIDE', 1 );

if(!empty($_GET['task']) && $_GET['task']=='tuto' && !empty($_GET['select'])){

	$select = intval($_GET['select']);

	$rq = $db->Send_Query("
				SELECT titre, body
				FROM exo_aide
				WHERE aid = '$select'");
	$one_tuto = $db->get_array($rq);
}
else{

	$rq_tuto = $db->Send_Query("
				SELECT aid, titre
				FROM exo_aide");
	$tutos = $db->loadObjectList($rq_tuto);
}

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'aide';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Aide' => ''
);
$ws_name_perso = 'Evoxis v5 - Aide';
?>