<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_BG
define( '_VALID_CORE_BG', 1 );

if(!empty($_GET['select'])){
	$select = intval($_GET['select']);
}
else{
	$select = intval($_SESSION['wow_id']);
}



//Récupération de tous les persos
$query = "	SELECT b.guid, b.name, b.statut, b.race, b.class, b.creation_time, b.last_edit_time, AVG(v.note) as nb_vote, CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(c.`data`, ' ', $playerDataFieldLevel), ' ', -1) AS UNSIGNED) AS `level`
			FROM exo_backgrounds b		
			LEFT JOIN exo_backgrounds_vote v ON v.guid = b.guid
			LEFT JOIN $db_name_characters.`characters` c ON c.guid = b.guid	
			WHERE b.wow_id = '$select'
			GROUP BY b.guid";
$result = $db->Send_Query($query);
$characters = $db->loadObjectList($result);

//Stats: Moyenne Temps Validation
$duree_secondes= $db->get_result($db->Send_Query('SELECT AVG(first_validation_time - ask_validation) FROM exo_backgrounds WHERE first_validation_time!=0'),0);
$duree_jours = round($duree_secondes/86400);
$duree_heures = round(($duree_secondes-($duree_jours*86400))/3600);
$duree_minutes = round(($duree_secondes-($duree_jours*86400)-($duree_heures*3600))/60);
$duree_secondes = round(($duree_secondes-($duree_jours*86400)-($duree_heures*3600)-($duree_minutes*60)));

$stats_moyenne_time_validation = abs($duree_jours).' jours '.abs($duree_heures).' heures '.abs($duree_minutes).' minutes '.abs($duree_secondes).' secondes';


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'backgrounds';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Backgrounds' => ''
);
$ws_name_perso = 'Evoxis v5 - Mes Backgrounds';
?>