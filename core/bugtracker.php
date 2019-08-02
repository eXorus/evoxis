<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_BUGTRACKER
define( '_VALID_CORE_BUGTRACKER', 1 );
require_once("./inc/bugtracker.class.php");
$o = new bugtracker();

$start = intval($_GET['start']);

if(!empty($_GET['task']) && $_GET['task']=='filtre' && (!empty($_POST['categorie']) || !empty($_GET['categorie']))){
	if (!empty($_POST['categorie'])) $value = intval($_POST['categorie']);
	else $value = intval($_GET['categorie']);
	$param = 'CAT';
	$link_select = "&amp;task=filtre&amp;categorie=$value";
}
else{
	$param = 'ALL';
	$value = 0;
}




if(!empty($_GET['task']) && $_GET['task']=='search'){
	$link_select = "&amp;task=search";
	
	if(!empty($_POST['form_texte'])) $form_texte = $_POST['form_texte'];
	elseif(!empty($_GET['form_texte'])) $form_texte = $_GET['form_texte'];
	
	if(!empty($_POST['form_from'])) $form_from = $_POST['form_from'];
	elseif(!empty($_GET['form_from'])) $form_from = $_GET['form_from'];	
	
	if(!empty($_POST['form_cat'])) $form_cat = $_POST['form_cat'];
	elseif(!empty($_GET['form_cat'])) $form_cat = $_GET['form_cat'];
	
	if(!empty($_POST['form_etat'])) $form_etat = $_POST['form_etat'];
	elseif(!empty($_GET['form_etat'])) $form_etat = $_GET['form_etat'];
	
	if(!empty($form_texte ) || !empty($form_from) || !empty($form_cat)  || !empty($form_etat)){
		$texte = mysql_real_escape_string($form_texte);
		$from = mysql_real_escape_string($form_from);
		$cat = intval($form_cat);
		$etat = intval($form_etat);
		
		if(!empty($texte)){		
			$clausewhereT = "(bt_name LIKE '%$texte%' OR bt_description LIKE '%$texte%')";
			$link_select .= "&amp;form_texte=$texte";
			$_SESSION['search_texte'] = stripslashes($texte);
		}
		else {$clausewhereT = "1=1";}
		
		if(!empty($from)){
			$clausewhereF = "pseudo LIKE '%$from%'";
			$link_select .= "&amp;form_from=$from";
			$_SESSION['search_from'] = stripslashes($from);
		}
		else {$clausewhereF = "1=1";}
		
		if(!empty($cat)){
			$clausewhereC = "btcid = '$cat'";
			$link_select .= "&amp;form_cat=$cat";
			$_SESSION['search_cat'] = $cat;
		}
		else {$clausewhereC = "1=1";}
		
		if(!empty($etat)){
			$clausewhereE = "bt_etat = $etat-1";
			$link_select .= "&amp;form_etat=$etat";
			$_SESSION['search_etat'] = $etat;
		}
		else {$clausewhereE = "1=1";}
		
		$clausewhere = "WHERE $clausewhereT AND $clausewhereF AND $clausewhereC AND $clausewhereE";
	
	}else{
		$clausewhere = '';
	}
}



$bugs = $o->getBugs($clausewhere);

//liste des Catégories
$rq = $db->Send_Query("
	SELECT btcid, name
	FROM exo_bugtracker_categories");
$listcat = $db->loadObjectList($rq);

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'bug';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'BugTracker' => ''
);
$ws_name_perso = 'Evoxis v5 - BugTracker';
?>