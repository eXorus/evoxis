<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_SEARCH
define( '_VALID_CORE_SEARCH', 1 );

$keywords = mysql_real_escape_string($_POST['keywords']);

if(!empty($_GET['task']) && $_GET['task']=='process' && !empty($keywords) ){

	if ($_POST['sections']=='FORUMS'){
				
		$rq = $db->Send_Query("
			 SELECT T.tid, T.subject, MIN(P.pid) as pid
			 FROM exo_forum_posts P
			LEFT JOIN exo_forum_topics T ON P.tid = T.tid
			LEFT JOIN exo_forum_boards B ON B.bid = T.bid
			WHERE (MATCH(P.body) AGAINST('$keywords') OR MATCH(T.subject) AGAINST('$keywords'))
			AND B.ACL_READ <= ".$secureObject->getAccessLevel()."
			GROUP BY T.tid");	

	}
	else if ($_POST['sections']=='FORUMS_TITRE'){

		$rq = $db->Send_Query("
			SELECT T.tid, T.subject
			FROM exo_forum_topics T
			LEFT JOIN exo_forum_boards B ON B.bid = T.bid
			WHERE (MATCH(T.subject) AGAINST('$keywords'))
			AND B.ACL_READ <= ".$secureObject->getAccessLevel()."");	

	}
	else if ($_POST['sections']=='NEWS'){
	
		$tab_search_keywords = explode(" ",$keywords);
		$sql_search = "";
		$nb_items = count($tab_search_keywords);
		$iter = 0;
		foreach($tab_search_keywords as $tab_search_keyword) {
			$sql_search .= "(
				title LIKE '%$tab_search_keyword%' OR 
				intro LIKE '%$tab_search_keyword%' OR 
				body LIKE '%$tab_search_keyword%')";
				
			$iter++;
				
			if(!empty($sql_search) && $iter<$nb_items){
				$sql_search .=' AND ';
			}
		}
	
		$rq = $db->Send_Query("
			SELECT nid, title
			FROM exo_news
			WHERE $sql_search");
	}
	else if ($_POST['sections']=='AIDES'){
		$tab_search_keywords = explode(" ",$keywords);
		$sql_search = "";
		$nb_items = count($tab_search_keywords);
		$iter = 0;
		foreach($tab_search_keywords as $tab_search_keyword) {
			$sql_search .= "(
				titre LIKE '%$tab_search_keyword%' OR 
				body LIKE '%$tab_search_keyword%')";
				
			$iter++;
				
			if(!empty($sql_search) && $iter<$nb_items){
				$sql_search .=' AND ';
			}
		}
	
		$rq = $db->Send_Query("
			SELECT aid, titre
			FROM exo_aide
			WHERE $sql_search");
	}
	else if ($_POST['sections']=='BACKGROUNDS'){
	
		$tab_search_keywords = explode(" ",$keywords);
		$sql_search = "";
		$nb_items = count($tab_search_keywords);
		$iter = 0;
		foreach($tab_search_keywords as $tab_search_keyword) {
			$sql_search .= "(
				name LIKE '%$tab_search_keyword%' OR 
				background LIKE '%$tab_search_keyword%')";
				
			$iter++;
				
			if(!empty($sql_search) && $iter<$nb_items){
				$sql_search .=' AND ';
			}
		}
	
		$rq = $db->Send_Query("
			SELECT guid, name
			FROM exo_backgrounds
			WHERE $sql_search");
	}
	else if ($_POST['sections']=='MEMBRES'){
	
		$tab_search_keywords = explode(" ",$keywords);
		$sql_search = "";
		$nb_items = count($tab_search_keywords);
		$iter = 0;
		foreach($tab_search_keywords as $tab_search_keyword) {
			$sql_search .= "(
				username LIKE '%$tab_search_keyword%' OR 
				pseudo LIKE '%$tab_search_keyword%')";
				
			$iter++;
				
			if(!empty($sql_search) && $iter<$nb_items){
				$sql_search .=' AND ';
			}
		}
	
		$rq = $db->Send_Query("
			SELECT uid, username
			FROM exo_users
			WHERE $sql_search");
	}
	else if ($_POST['sections']=='BUGTRACKERS'){
	
		$tab_search_keywords = explode(" ",$keywords);
		$sql_search = "";
		$nb_items = count($tab_search_keywords);
		$iter = 0;
		foreach($tab_search_keywords as $tab_search_keyword) {
			$sql_search .= "(
				bt_name LIKE '%$tab_search_keyword%' OR 
				bt_description LIKE '%$tab_search_keyword%')";
				
			$iter++;
				
			if(!empty($sql_search) && $iter<$nb_items){
				$sql_search .=' AND ';
			}
		}
	
		$rq = $db->Send_Query("
			SELECT btid, bt_name
			FROM exo_bugtracker
			WHERE $sql_search");
	}
		
	$results = $db->loadObjectList($rq);
}


	
/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'search';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Recherche' => ''
);
$ws_name_perso = 'Evoxis v5 - Recherche';
?>
