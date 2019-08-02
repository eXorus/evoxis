<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_DL
define( '_VALID_CORE_DL', 1 );

if(!empty($_GET['did'])){
	$select = intval($_GET['did']);
	
	$nbr_fic = $db->get_result($db->Send_Query("SELECT COUNT(*) FROM exo_dl WHERE did = '$select'"), 0);
	
	if($nbr_fic==1){
	
		$rq = $db->Send_Query("
			SELECT did, name, description, file
			FROM exo_dl
			WHERE did = $select");
		$dl = $db->get_array($rq);
	
		header('Content-disposition: attachment; filename="' . $dl['file'] . '"');
		header('Content-Type: application/force-download');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '. filesize('./upload/' . $dl['file']));
		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		readfile('./upload/' . $dl['file']);
	}
}

$rq = $db->Send_Query("
			SELECT did, name, description, file
			FROM exo_dl
			ORDER BY did");
$dls = $db->loadObjectList($rq);

	
/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'download';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Téléchargement' => 'index.php?comp=dl',
'Tous les téléchargements' => ''
);
$ws_name_perso = 'Evoxis v5 - Téléchargements';
?>