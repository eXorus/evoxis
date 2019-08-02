<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_TROMBINOSCOPE
define( '_VALID_CORE_TROMBINOSCOPE', 1 );

$NbrImgParLigne = 5;
$NumImgLigne = 0;


$rq = $db->Send_Query("
			SELECT U.uid, U.pseudo, P.id, P.image_extension
			FROM exo_users U
			LEFT JOIN exo_pictures P ON P.uid=U.uid
			WHERE P.type=2
			ORDER BY U.pseudo");
$trombi = $db->loadObjectList($rq);


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'trombi';

/*
* MANAGE PATHWAY
*/
$pathway = array(
'Trombinoscope' => 'index.php?comp=trombinoscope'
);
$ws_name_perso = 'Evoxis v5 - Trombinoscope';
?>
