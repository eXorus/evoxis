<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_INSEVO_ATTENTE
define( '_VALID_CORE_INSEVO_ATTENTE', 1 );

$query = "
		SELECT login, time_creation, time_validation, state, comment
		FROM exo_insevo
		WHERE time_creation > '".(time()-(86400*7))."'
		ORDER BY time_creation DESC";
$result = $db->Send_Query($query);
$insevo_attente = $db->loadObjectList($result);

//Stats: Moyenne Temps Validation
$duree_secondes= $db->get_result($db->Send_Query('SELECT AVG(time_validation - time_creation) FROM exo_insevo WHERE time_validation!=0'),0);
$duree_jours = round($duree_secondes/86400);
$duree_heures = round(($duree_secondes-($duree_jours*86400))/3600);
$duree_minutes = round(($duree_secondes-($duree_jours*86400)-($duree_heures*3600))/60);
$duree_secondes = round(($duree_secondes-($duree_jours*86400)-($duree_heures*3600)-($duree_minutes*60)));

$stats_moyenne_time_validation = abs($duree_jours).' jours '.abs($duree_heures).' heures '.abs($duree_minutes).' minutes '.abs($duree_secondes).' secondes';

$stats_valide= $db->get_result($db->Send_Query('SELECT COUNT(*) FROM exo_insevo WHERE state=\'OK\''),0);
$stats_nb_insevo= $db->get_result($db->Send_Query('SELECT COUNT(*) FROM exo_insevo'),0);
$stats_p_accept= round((100*$stats_valide)/$stats_nb_insevo);

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'inscription';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Inscription' => 'index.php?comp=insevo',
'En attente' => ''
);
$ws_name_perso = 'Evoxis v5 - Inscriptions en attente';
?>