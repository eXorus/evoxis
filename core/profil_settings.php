<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_PROFIL_SETTINGS', 1 );


//Avatars
$r = $db->Send_Query("SELECT COUNT(*) FROM exo_pictures WHERE uid=".$_SESSION['uid']." AND type=1");
$d = $db->get_row($r);
$count_A = $d[0];

//Photo
$r = $db->Send_Query("SELECT COUNT(*) FROM exo_pictures WHERE uid=".$_SESSION['uid']." AND type=2");
$d = $db->get_row($r);
$count_P = $d[0];

//Créations graphiques
$r = $db->Send_Query("SELECT COUNT(*) FROM exo_pictures WHERE uid=".$_SESSION['uid']." AND type=3");
$d = $db->get_row($r);
$count_CG = $d[0];

//Avatars Persos
$r = $db->Send_Query("SELECT COUNT(*) FROM exo_pictures WHERE uid=".$_SESSION['uid']." AND type=4");
$d = $db->get_row($r);
$count_AP = $d[0];

//Formulaire envoyé
if(!empty($_GET['task']) && $_GET['task']=="process"){

	//NEVER TRUST USER INPUT !!		
	$send_template = intval($_POST['template']);
	
	$send_signature = mysql_real_escape_string(trim($_POST['signature']));	
	$send_presentation = mysql_real_escape_string(trim($_POST['presentation']));	
	$send_avatar = intval($_POST['avatars']);
	
	//Query
	$rq = $db->Send_Query("
			UPDATE exo_users 
			SET 	template='$send_template', 
					signature='$send_signature',
					presentation='$send_presentation'
			WHERE uid='".$_SESSION['uid']."'");	
	
	$rq = $db->Send_Query("
			UPDATE exo_pictures
			SET 	selected='0'
			WHERE uid='".$_SESSION['uid']."' AND type=1");
			
	$rq = $db->Send_Query("
			UPDATE exo_pictures
			SET 	selected='1'
			WHERE uid='".$_SESSION['uid']."' AND type=1 AND id='$send_avatar'");
	
	//Mise à jour de l'avatar des persos
	$rq = $db->Send_Query("
			UPDATE exo_backgrounds
			SET 	imgID=0
			WHERE wow_id='".$_SESSION['wow_id']."'");
			
	foreach($_POST as $key => $value){
		if(substr_count($key, "imgID_")==1){
			
			$rq = $db->Send_Query("
			UPDATE exo_backgrounds
			SET 	imgID='".intval(substr($key,6))."'
			WHERE wow_id='".$_SESSION['wow_id']."' AND guid='$value' AND imgID=0");
		}
	}	
}

//Avatar
$rq = $db->Send_Query("
			SELECT id, image_extension, selected
			FROM exo_pictures
			WHERE uid='".$_SESSION['uid']."'
			AND type=1");
$avatars = $db->loadObjectList($rq);

//Photos
$rq = $db->Send_Query("
			SELECT id, image_extension
			FROM exo_pictures
			WHERE uid='".$_SESSION['uid']."'
			AND type=2");
$profil_photo = $db->get_array($rq);
if(!empty($profil_photo['id']) && !empty($profil_photo['image_extension'])){
	$link_photo = '<img src="./img/pictures/'.$profil_photo['id'].'.'.$profil_photo['image_extension'].'" alt="Photo"/>';
}
else{
	$link_photo = 0;
}


//Envoie des données
$rq = $db->Send_Query("
			SELECT template, signature, presentation
			FROM exo_users 
			WHERE uid='".$_SESSION['uid']."'");
$result = $db->get_array($rq);

$form_avatar = $result['avatar'];
$form_signature = stripslashes(htmlspecialchars($result['signature']));
$form_presentation = stripslashes(htmlspecialchars($result['presentation']));



//Liste d'utilisation pour les avatars
$rq = $db->Send_Query("
			SELECT B.guid, B.name, P.id, P.image_extension
			FROM exo_pictures P
			LEFT JOIN exo_backgrounds B ON P.id=B.imgID
			WHERE P.type=4 AND P.uid='".$_SESSION['uid']."'");
$avatarsPersos = $db->loadObjectList($rq);

$rq = $db->Send_Query("
			SELECT guid, name
			FROM exo_backgrounds
			WHERE wow_id='".$_SESSION['wow_id']."' AND statut='VALIDE'");
$listPersos = $db->loadObjectList($rq);




/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'profil';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Profil' => 'index.php?comp=profil',
'Modifier mes réglages' => ''
);
$ws_name_perso = 'Evoxis v5 - Modifier mes réglages';
?>
