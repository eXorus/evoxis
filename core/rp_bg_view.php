<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_RP_BG_VIEW
define( '_VALID_CORE_RP_BG_VIEW', 1 );

$select = intval($_GET['select']);

$rq = $db->Send_Query("
		SELECT t.id, t.title, t.date_create, t.date_edit, t.body, c.name, c.resume
		FROM exo_rp_bg t
		LEFT JOIN exo_rp_bg_chap c ON c.id=t.id_chap
		WHERE t.id_chap='$select'");
$sections = $db->loadObjectList($rq);

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'histoire';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Role-Play' => ''
); 
?>