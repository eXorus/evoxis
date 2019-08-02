<?php

$texec_begin = microtime(true);

//Session
session_start();
session_regenerate_id(TRUE);

header('Cache-Control: private');


// Define _VALID_INDEX
define( '_VALID_INDEX', 1 );

//Require_one
require_once("./inc/config.php");
require_once("./inc/mysql.php");
require_once("./inc/fct_utile.php");
require_once("./inc/spyvo.php");
require_once("./inc/message.class.php");
require_once("./inc/security.class.php");

//Spyvo
$spyvo = new spyvo();

//MySQL
$db = new mysql($db_host,$db_username,$db_password,$db_name, TRUE);
$db->connect($db->host,$db->user,$db->pass,$db->base) or die( 'MySQL Lost: WS' );

//Connexion Auto
if(!empty($_COOKIE['autoU']) && !empty($_COOKIE['autoM']) && $_SESSION['connected']!=TRUE && $_GET['comp']!="login"){
	
	$msg = message::getInstance('SUCCESS','Connexion Automatique en cours', './index.php?comp=login');	
}

//Security
$secureObject = security::getInstance();
$secureObject->loadAuthorizations();
$secureObject->loadAccessLevel();

//Load Config
$config_query = $db->Send_Query('select conf_key as cfgKey, conf_value as cfgValue from exo_config');
while ($config = $db->get_array($config_query)) {
	define($config['cfgKey'], $config['cfgValue']);
}

//Check OFFLINE
if(WEBSITE_OFFLINE == 1){
	if(WEBSITE_OFFLINE_PWD!=NULL && ($_GET['pwd']==WEBSITE_OFFLINE_PWD || $_SESSION['WEBSITE_OFFLINE_PWD']==WEBSITE_OFFLINE_PWD)){
		$_SESSION['WEBSITE_OFFLINE_PWD']=WEBSITE_OFFLINE_PWD;
	}
	else{
		die(WEBSITE_OFFLINE_INFO);
	}
}

//Connexion à WoW Realmd
$db_realmd = new mysql($db_host_realmd,$db_username_realmd,$db_password_realmd,$db_name_realmd);
$db_realmd->connect($db_realmd->host,$db_realmd->user,$db_realmd->pass,$db_realmd->base, TRUE) or die( 'MySQL Lost: Realmd' );

//Connexion à WoW Characters
$db_characters = new mysql($db_host_characters,$db_username_characters,$db_password_characters,$db_name_characters);
$db_characters->connect($db_characters->host,$db_characters->user,$db_characters->pass,$db_characters->base, TRUE) or die( 'MySQL Lost: Characters' );

//Comp WhoIsOnline
require_once('./core/whoisonline.php');

//Comp infobox
require_once('./core/infobox.php');

//Comp events
require_once('./core/events.php');

//Style
if (mobile_device_detect(true,true,true,true,true,true,false,false)==TRUE){
	$link_style = TEMPLATE_LITE_DEFAULT;
}
elseif (ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])){
	if(ereg("MSIE 8", $_SERVER["HTTP_USER_AGENT"])){$link_style = TEMPLATE_DEFAULT;}
	elseif(ereg("MSIE 7", $_SERVER["HTTP_USER_AGENT"])){$link_style = TEMPLATE_DEFAULT;}
	else {$link_style = TEMPLATE_LITE_DEFAULT;}
}
elseif(!empty($_SESSION['link'])){
	$link_style = $_SESSION['link'];
}
else{
	$link_style = TEMPLATE_DEFAULT;
}


//Réinitialise la shoutbox
$_SESSION['last_msg'] = 0;

//Nb d'éléments sur une page
$Nmax = 30;

//Load Components
$secure_comp = array(
'aide' => 'aide',
'ask' => 'ask',
'bestiaire' => 'bestiaire',
'bg' => 'bg',
'bg_show' => 'bg_show',
'bg_write' => 'bg_write',
'bg_list' => 'bg_list',
'bugtracker' => 'bugtracker',
'bugtracker_view' => 'bugtracker_view',
'bugtracker_write' => 'bugtracker_write',
'changelog' => 'changelog',
'charte' => 'charte',
'chronologie' => 'chronologie',
'dl' => 'dl',
'forum_index' => 'forum_index',
'forum_board' => 'forum_board',
'forum_board_moderate' => 'forum_board_moderate',
'forum_post' => 'forum_post',
'forum_topic' => 'forum_topic',
'forum_topic_moderate' => 'forum_topic_moderate',
'galerie' => 'galerie',
'guilds' => 'guilds',
'guilds_bg_write' => 'guilds_bg_write',
'insevo' => 'insevo',
'insevo_attente' => 'insevo_attente',
'live' => 'live',
'login' => 'login',
'logout' => 'logout',
'membres' => 'membres',
'money' => 'money',
'mp' => 'mp',
'mp_write' => 'mp_write',
'mp_view' => 'mp_view',
'mp_moderate' => 'mp_moderate', 
'news' => 'news',
'news_comment' => 'news_comment',
'news_archives' => 'news_archives',
'notifications' => 'notifications',
'presentation' => 'presentation',
'profil' => 'profil',
'profil_account' => 'profil_account',
'profil_pwd' => 'profil_pwd',
'profil_email' => 'profil_email',
'profil_settings' => 'profil_settings',
'profil_settings_pictures' => 'profil_settings_pictures',
'rp_bg' => 'rp_bg',
'rp_bg_view' => 'rp_bg_view',
'search' => 'search',
'stats' => 'stats',
'trombinoscope' => 'trombinoscope',
'team' => 'team');

if(!empty($_GET['comp'])){ 
	if(array_key_exists($_GET['comp'], $secure_comp) 
	&& is_file('./core/'.$secure_comp[$_GET['comp']].'.php') 
	&& is_file('./gabarit/'.$secure_comp[$_GET['comp']].'.html.php')
	&& $secureObject->verifyAuthorization('COMP_ACCES_'.strtoupper($_GET['comp']))==TRUE)
	{	
		require_once('./core/'.$secure_comp[$_GET['comp']].'.php');
		require_once('./gabarit/'.$secure_comp[$_GET['comp']].'.html.php');
	}
	else{
		$msg = message::getInstance('ERROR','Droits Insuffisants pour accéder à ce composant', './index.php?comp=presentation');
	}

}
else
{
	require_once('./core/presentation.php');
	require_once('./gabarit/presentation.html.php');
}

//Spyvo
$spyvo->spyvo_close();

?>
