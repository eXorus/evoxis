<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_LOGOUT', 1 );


// D�truit toutes les variables de session
$_SESSION = array();

// Si vous voulez d�truire compl�tement la session, effacez �galement
// le cookie de session.
// Note : cela d�truira la session et pas seulement les donn�es de session !
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Finalement, on d�truit la session.
session_destroy();

$msg = message::getInstance('SUCCESS', 'D�connexion R�ussie', 'index.php?comp=login");');
?>