<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_LOGOUT
define( '_VALID_CORE_LOGOUT', 1 );

//Whoisonline
$db->Send_Query("DELETE FROM exo_whoisonline WHERE online_id = '".intval($_SESSION['uid'])."'");


// Détruit toutes les variables de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, effacez également
// le cookie de session.
// Note : cela détruira la session et pas seulement les données de session !
if(isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

if(isset($_COOKIE['autoU'])){
	setcookie('autoU','',-1);
}
if(isset($_COOKIE['autoM'])){
	setcookie('autoM','',-1);
}

// Finalement, on détruit la session.
session_destroy();

$msg = message::getInstance('SUCCESS','Déconnexion réussie', 'index.php');
?>
