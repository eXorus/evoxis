<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_LOGOUT
define( '_VALID_CORE_LOGOUT', 1 );

//Whoisonline
$db->Send_Query("DELETE FROM exo_whoisonline WHERE online_id = '".intval($_SESSION['uid'])."'");


// D�truit toutes les variables de session
$_SESSION = array();

// Si vous voulez d�truire compl�tement la session, effacez �galement
// le cookie de session.
// Note : cela d�truira la session et pas seulement les donn�es de session !
if(isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

if(isset($_COOKIE['autoU'])){
	setcookie('autoU','',-1);
}
if(isset($_COOKIE['autoM'])){
	setcookie('autoM','',-1);
}

// Finalement, on d�truit la session.
session_destroy();

$msg = message::getInstance('SUCCESS','D�connexion r�ussie', 'index.php');
?>
