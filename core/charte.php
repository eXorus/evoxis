<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_CHARTE', 1 );

if(!empty($_GET['option']) && $_GET['option']=="RP"){
	$charte = CHARTE_EVOXIS_RP;
	$onglet = '<a href="./index.php?comp=charte&amp;option=charte">[Charte d\'Evoxis]</a> | <b>[R�glement R�le-Play]</b>';
}
else if(!empty($_GET['option']) && $_GET['option']=="charte"){
	$charte = CHARTE_EVOXIS;
	$onglet = '<b>[Charte d\'Evoxis]</b> | <a href="./index.php?comp=charte&amp;option=RP">[R�glement R�le-Play]</a>';
}
else{
	$charte = '
	
	
	[center][url='.$ws_domain.'index.php?comp=charte&option=charte]Charte d\'Evoxis[/url]: R�glement g�n�ral du serveur[/center]
	[center][url='.$ws_domain.'index.php?comp=charte&option=RP]R�glement R�le-Play[/url]: R�gles sp�cifiques concernant le R�le-Play[/center]
	';
	$onglet = '<a href="./index.php?comp=charte&amp;option=charte">[Charte d\'Evoxis]</a> | <a href="./index.php?comp=charte&amp;option=RP">[R�glement R�le-Play]</a>';
}


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'charte';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Charte' => ''
);
$ws_name_perso = 'Evoxis v5 - La Charte d\'Evoxis';
?>
