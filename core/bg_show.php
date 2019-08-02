<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_BG_SHOW
define( '_VALID_CORE_BG_SHOW', 1 );


if(!empty($_POST['comment']) && !empty($_POST['bgid']) && !empty($_SESSION['uid'])){
	$comment = $_POST['comment'];
	$bgid = intval($_POST['bgid']);
	$time = time();
	$query = "INSERT INTO exo_backgrounds_commentaires(bgcid, bgid, comment, `from`, time_create) VALUES(NULL,'$bgid','$comment','".$_SESSION['uid']."','$time')";
	$result = $db->Send_Query($query);
		
	//Indices
	update_ivo('nb_backgrounds_commentaire');	
	
	$msg = message::getInstance('SUCCESS','Commentaire de background ajouté', 'index.php?comp=bg_show&amp;guid='.$bgid);
}

if(!empty($_GET['guid'])){

	$guid = intval($_GET['guid']);
	
	$query = "	SELECT b.guid, b.wow_id, b.statut, b.name, b.race, b.class, b.background, b.creation_time, b.last_edit_time, v.note, v.time
				FROM exo_backgrounds b
				LEFT JOIN exo_backgrounds_vote v ON v.guid= b.guid AND v.uid='".intval($_SESSION['uid'])."'
				WHERE b.guid = $guid ";
	$result = $db->Send_Query($query);
	$bg = $db->get_array($result);
	
	$rq = $db->Send_Query("
			SELECT bgcid, comment, pseudo, time_create
			FROM exo_backgrounds_commentaires, exo_users
			WHERE `from` = uid
			AND bgid = $guid
			ORDER BY time_create");
	$comments = $db->loadObjectList($rq);
	
	
	$name = $bg['name'];
	$wow_id = $bg['wow_id'];
	
	$vote_note = $bg['note'];
	$vote_time = $bg['time'];
	
	$query = "	SELECT AVG(note) as avg_vote, COUNT(*) as nb_vote
				FROM exo_backgrounds_vote
				WHERE guid = '$guid' ";
	$result = $db->Send_Query($query);
	$vote = $db->get_array($result);
	
	if($bg['statut']=='EN_REDACTION' && $_SESSION['wow_id']==$bg['wow_id']){
		$statut = 'En Rédaction <a href="index.php?comp=bg_write&amp;task=ask_valid&amp;guid='.$guid.'">Demander la validation de ce background</a>';
	}
	else{
		if ($bg['statut']=='EN_ATTENTE') $statut = "En Attente";
		elseif($bg['statut']=='EN_REDACTION') $statut = "En Rédaction";
		elseif($bg['statut']=='INDISPONIBLE') $statut = "Indisponible";
		elseif($bg['statut']=='NON_VALIDE') $statut = "Non Valide";
		else $statut = "Valide";
	}
	
	$race = print_race($bg['race']);
	$class = print_class($bg['class']);
	
	$background = $bg['background'];
	
	if(empty($bg['creation_time'])){
		$creation_time = 'Non disponible pour le moment';
	}
	else{
		$creation_time = $bg['creation_time'];
	}
	
	if(empty($bg['last_edit_time'])){
		$last_edit_time = 'Non disponible pour le moment';
	}
	else{
		$last_edit_time = $bg['last_edit_time'];
	}
}
else{
	$msg = message::getInstance('N/A','N/A', './templates/404.html');
}


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'backgrounds';

/*
* MANAGE PATHWAY
*/
$pathway = array(
'Backgrounds' => 'index.php?comp=bg',
'Visualisation' => ''
);
$ws_name_perso = 'Evoxis v5 - Background de '.$name.'';

?>