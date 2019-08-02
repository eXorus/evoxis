<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_EVENTS
define( '_VALID_CORE_EVENTS', 1 );


//Selection du mois à afficher
$EventSelection = intval($_GET['EventSelection']);
if(!empty($EventSelection)){
	$annee = substr($EventSelection, 0, 4);
	$mois = substr($EventSelection, 4, 2);
	
	$EventSelectionSup = ($mois=='12') ? ($annee + 1).'01' : ($EventSelection + 1);
	$EventSelectionInf = ($mois=='01') ? ($annee - 1).'12' : ($EventSelection - 1);
}
else{
	$annee = date('Y');
	$mois = date('m');
	
	$EventSelectionSup = ($mois=='12') ? ($annee + 1).'01' : ($annee.$mois + 1);
	$EventSelectionInf = ($mois=='01') ? ($annee - 1).'12' : ($annee.$mois - 1);
}


//Paramètre:
$paramNbDays = intval(date("t", mktime(0, 0, 0, $mois, 1, $annee)));
$paramFirstDay  = intval(date("N", mktime(0, 0, 0, $mois, 1, $annee)));
$NumDay = $annee.$mois."01";
setlocale (LC_TIME, 'fr_FR'); 

//Paramètre Cache
$FicCacheEvents = 'cache/events_'.$annee.$mois.'.html';
$ExpireCacheEvents = time() - 60*15 ; // valable 15 minutes

if(!file_exists($FicCacheEvents) || filemtime($FicCacheEvents) < $ExpireCacheEvents){
	//Base des events
	$query = 'SELECT eid, mini_title,mini_desc, tid, date_begin, date_end, `type`, DATE_FORMAT(date_begin, "%Y%m%d") as DateKeyBegin, DATE_FORMAT(date_end, "%Y%m%d") as DateKeyEnd
				FROM exo_events
				WHERE date_begin
				BETWEEN "'.$annee.'-'.$mois.'-01 00:00:00"
				AND "'.$annee.'-'.$mois.'-'.$paramNbDays.' 23:59:59" OR 
				date_end
				BETWEEN "'.$annee.'-'.$mois.'-01 00:00:00"
				AND "'.$annee.'-'.$mois.'-'.$paramNbDays.' 23:59:59"
				ORDER BY date_begin ASC';
	$temp=$db->Send_Query($query);
	$events = $db->loadObjectList($temp);

	// Initialisation des variables qui contiendront les résultats
	$dataEvents = array();

	// Traitement des résultats de la requête
	foreach ($events as $event)
	{
		$dataEvent = array(
			'eid' 	=> $event->eid,
			'type' 	=> $event->type,
			'titre'	=> stripslashes(htmlspecialchars($event->mini_title)),
			'desc'	=> stripslashes(htmlspecialchars($event->mini_desc)),
			'tid'	=> $event->tid,
			'debut'	=> $event->date_begin,
			'fin'	=> $event->date_end
		);
		
		//Ajouter pour chaque jour
		for($i=$event->DateKeyBegin; $i<=$event->DateKeyEnd; $i++){
			$dataEvents[$i][] = $dataEvent;
		}
	}
}
?>
