<?php
$texec_begin = microtime(true);

//Session
session_start();
session_regenerate_id(TRUE);

// Define _ADMIN_VALID_INDEX
define( '_ADM_VALID_INDEX', 1 );

//Require_one
require_once("../inc/config.php");
require_once("../inc/mysql.php");
require_once("../inc/fct_utile.php");
require_once("adm_functions.php");
require_once("../inc/message.class.php");
require_once("../inc/security.class.php");

//MySQL
$db = new mysql($db_host,$db_username,$db_password,$db_name, TRUE);
$db->connect($db->host,$db->user,$db->pass,$db->base) or die( 'MySQL Lost: WS' );

//Security
$secureObject = security::getInstance();
$secureObject->loadAuthorizations();
$secureObject->loadAccessLevel();

//Connexion à WoW Realmd
$db_realmd = new mysql($db_host_realmd,$db_username_realmd,$db_password_realmd,$db_name_realmd);
$db_realmd->connect($db_realmd->host,$db_realmd->user,$db_realmd->pass,$db_realmd->base, TRUE) or die( 'MySQL Lost: Realmd' );

//Connexion à WoW Characters
$db_characters = new mysql($db_host_characters,$db_username_characters,$db_password_characters,$db_name_characters);
$db_characters->connect($db_characters->host,$db_characters->user,$db_characters->pass,$db_characters->base, TRUE) or die( 'MySQL Lost: Characters' );

//Load Config
$config_query = $db->Send_Query('select conf_key as cfgKey, conf_value as cfgValue from exo_config');
while ($config = $db->get_array($config_query)) {
	define($config['cfgKey'], $config['cfgValue']);
}

//checkLogin();
//$_SESSION['admin_timestamp']=time();


//Nb d'éléments sur une page
$Nmax = 30;

#Secure Modules
$secure_comp = array (
"ask",
"askFocus",
"main", 
"login", 
"logout", 
"config", 
"configMoney", 
"users", 
"usersFocus", 
"insevo",
"insevoFocus",
"groups",
"guilds",
"guildsFocus",
"bgcheck",
"bgcheckFocus",
"logs"
);

if(!empty($_GET['comp']) 
&& in_array($_GET['comp'], $secure_comp) 
&& is_file('./adm_'.$_GET['comp'].'.php') 
&& is_file('./adm_'.$_GET['comp'].'.html.php')
&& $secureObject->verifyAuthorization('COMP_ACCES_ADM_'.strtoupper($_GET['comp']))==TRUE)
{	
	#Chargement du Model
	require_once('./adm_'.$_GET['comp'].'.php');
	
	#Chargement de la View
	require_once('./tpl/adm_top.php');	
	require_once('./adm_'.$_GET['comp'].'.html.php');
	require_once('./tpl/adm_bottom.php');			
}
else{
	#Chargement du Model
	require_once('./adm_login.php');
	
	#Chargement de la View
	require_once('./tpl/adm_top.php');	
	require_once('./adm_login.html.php');
	require_once('./tpl/adm_bottom.php');	
}

?>
