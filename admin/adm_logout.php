<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_LOGOUT', 1 );


// Détruit toutes les variables de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, effacez également
// le cookie de session.
// Note : cela détruira la session et pas seulement les données de session !
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Finalement, on détruit la session.
session_destroy();

$msg = message::getInstance('SUCCESS', 'Déconnexion Réussie', 'index.php?comp=login");');
?>