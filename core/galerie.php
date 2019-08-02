<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_TROMBINOSCOPE
define( '_VALID_CORE_GALERIE', 1 );

$NbrImgParLigne = 5;
$NumImgLigne = 0;

$rq = $db->Send_Query("
			SELECT U.pseudo, P.id, P.image_extension
			FROM exo_users U
			LEFT JOIN exo_pictures P ON P.uid=U.uid
			WHERE P.type=3
			ORDER BY U.pseudo");
$galeries = $db->loadObjectList($rq);


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'creas';

/*
* MANAGE PATHWAY
*/
$pathway = array(
'Galerie' => 'index.php?comp=galerie'
);
$ws_name_perso = 'Evoxis v5 - Galerie';
?>