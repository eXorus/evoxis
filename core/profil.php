<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_PROFIL
define( '_VALID_CORE_PROFIL', 1 );

if(!empty($_GET['select'])){
	$select = intval($_GET['select']);
}
else{
	$select = intval($_SESSION['uid']);
}

$rq = $db->Send_Query("
			SELECT uid, wow_id, username, email, email_view, pseudo, realname, birthday, lieu, fuseau, sexe, icq, aim, msn, yahoo, skype, template, signature, presentation
			FROM exo_users 
			WHERE uid='$select'");
$profil = $db->get_array($rq);


//Avatar
$rq = $db->Send_Query("
			SELECT id, image_extension
			FROM exo_pictures
			WHERE uid='$select'
			AND type=1
			AND selected=1");
$profil_avatar = $db->get_array($rq);
if(!empty($profil_avatar['id']) && !empty($profil_avatar['image_extension'])){
	$link_avatar = '<img src="./img/pictures/'.$profil_avatar['id'].'.'.$profil_avatar['image_extension'].'" alt="Avatar"/>';
}
else{
	$link_avatar = '<img src="./img/pictures/0.png" alt="Avatar"/>';
}

//Photos
$rq = $db->Send_Query("
			SELECT id, image_extension
			FROM exo_pictures
			WHERE uid='$select'
			AND type=2");
$profil_photo = $db->get_array($rq);
if(!empty($profil_photo['id']) && !empty($profil_photo['image_extension'])){
	$link_photo = '<img src="./img/pictures/'.$profil_photo['id'].'.'.$profil_photo['image_extension'].'" alt="Photo"/>';
}
else{
	$link_photo = '<img src="./img/pictures/0.jpg" alt="Photo"/>';
}

//Sexe
if($profil['sexe']==0){
	$sexe = 'Féminin';
}
else if($profil['sexe']==1){
	$sexe = 'Masculin';
}
else{
	$sexe = '?';
}

//fuseau
$fuseaux = array(
	'(GMT -12:00) International Date Line West',
	'(GMT -11:00) Midway Island, Samoa',
	'(GMT -10:00) Hawaii',
	'(GMT -09:00) Alaska',
	'(GMT -08:00) Pacific Time (US &amp; Canada), Tijuana',
	'(GMT -07:00) Arizona',
	'(GMT -07:00) Chihuahua, La Paz, Mazatlan',
	'(GMT -07:00) Mountain Time (US &amp; Canada)',
	'(GMT -06:00) Central America',
	'(GMT -06:00) Central Time (US &amp; Canada)',
	'(GMT -06:00) Guadalajara, Mexico City; Monterrey',
	'(GMT -06:00) Saskatchewan',
	'(GMT -05:00) Bogota, Lima, Quito',
	'(GMT -05:00) Eastern Time (US &amp; Canada)',
	'(GMT -05:00) Indiana (East)',
	'(GMT -04:00) Atlantic Time (Canada)',
	'(GMT -04:00) Caracas, Le Paz',
	'(GMT -04:00) Santiago',
	'(GMT -03:00) Brazilia',
	'(GMT -03:00) Brazilia',
	'(GMT -03:00) Buenos Aires, Georgetown',
	'(GMT -03:00) Greenland',
	'(GMT -02:00) Mid-Atlantic',
	'(GMT -01:00) Azores',
	'(GMT -01:00) Cap Verde Is.',
	'(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London',
	'(GMT +01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
	'(GMT +01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague',
	'(GMT +01:00) Brussels, Copenhagen, Madrid, Paris',
	'(GMT +01:00) Sarajevo, Skopje, Warsaw, Zagreb',
	'(GMT +01:00) West Central Africa',
	'(GMT +02:00) Athens, Beirut, Istambul, Minsk',
	'(GMT +02:00) Bucharest',
	'(GMT +02:00) Cairo',
	'(GMT +02:00) Harare, Pretoria',
	'(GMT +02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius',
	'(GMT +02:00) Jerusalem',
	'(GMT +03:00) Baghdad',
	'(GMT +03:00) Kuwait, Riyadh',
	'(GMT +03:00) Moscow, St. Petersburg, Volgograd',
	'(GMT +03:00) Nairobi',
	'(GMT +04:00) Abu Dhabi, Muscat',
	'(GMT +04:00) Baku, Tbilisi, Yerevan',
	'(GMT +05:00) Ekaterinburg',
	'(GMT +05:00) Islamabad, Karachi, Tashkent',
	'(GMT +06:00) Almaty, Novosibirsk',
	'(GMT +06:00) Astana, Dhaka',
	'(GMT +06:00) Sri Jayawardenepura',
	'(GMT +07:00) Bangkok, Hanoi, Jakarta',
	'(GMT +07:00) Krasnoyarsk',
	'(GMT +08:00) Beijing, Chongqing, Hong Kong, Urumqi',
	'(GMT +08:00) Irkutsk, Ulaan Bataar',
	'(GMT +08:00) Kuala Lumpur, Singapore',
	'(GMT +08:00) Perth',
	'(GMT +08:00) Taipei',
	'(GMT +09:00) Osaka, Sapporo, Tokyo',
	'(GMT +09:00) Seoul',
	'(GMT +09:00) Yakutsk',
	'(GMT +10:00) Brisbane',
	'(GMT +10:00) Canberra, Melbourne, Sydney',
	'(GMT +10:00) Guam, Port Moresby',
	'(GMT +10:00) Hobart',
	'(GMT +10:00) Vladivostok',
	'(GMT +11:00) Magadan, Solomon Is., Caledonia',
	'(GMT +12:00) Auckland, Wellington',
	'(GMT +12:00) Fiji, Kamchatka, Marshall Is.',
	'(GMT +13:00) Nukualofa'
	);
$form_fuseaux = $fuseaux[$profil['fuseau']]; 


if($profil['email_view']==1) $email_view = $profil['email'];
else $email_view = 'ne souhaite pas la rendre publique';


$rq = $db->Send_Query("
			SELECT G.name
			FROM exo_groups_users GU
			LEFT JOIN exo_groups G ON GU.gid= G.gid
			WHERE uid='$select'");
$groups = $db->loadObjectList($rq);


//Récupération de tous les persos
$query = "	SELECT b.guid, b.name, b.statut, b.race, b.class, b.creation_time, b.last_edit_time, AVG(v.note) as nb_vote, CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(c.`data`, ' ', $playerDataFieldLevel), ' ', -1) AS UNSIGNED) AS `level`
			FROM exo_backgrounds b		
			LEFT JOIN exo_backgrounds_vote v ON v.guid = b.guid
			LEFT JOIN $db_name_characters.`characters` c ON c.guid = b.guid	
			WHERE b.wow_id = '".$profil['wow_id']."'
			GROUP BY b.guid";
$result = $db->Send_Query($query);
$characters = $db->loadObjectList($result);

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'profil';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Profil' => ''
);
$ws_name_perso = 'Evoxis v5 - Profil de '.stripslashes(htmlspecialchars($profil['pseudo'])).'';
?>