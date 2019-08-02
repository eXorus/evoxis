<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_FORUM_POST
define( '_VALID_CORE_FORUM_POST', 1 );


//Variables
$cid = (empty($_POST['cid'])) ? ((empty($_GET['cid'])) ? 0 : intval($_GET['cid'])) : intval($_POST['cid']);
$bid = (empty($_POST['bid'])) ? ((empty($_GET['bid'])) ? 0 : intval($_GET['bid'])) : intval($_POST['bid']);
$tid = (empty($_POST['tid'])) ? ((empty($_GET['tid'])) ? 0 : intval($_GET['tid'])) : intval($_POST['tid']);
$pid = (empty($_POST['pid'])) ? ((empty($_GET['pid'])) ? 0 : intval($_GET['pid'])) : intval($_POST['pid']);

$action = (empty($_POST['action'])) ? ((empty($_GET['action'])) ? 0 : $_GET['action']) : $_POST['action'];



$form_tag = array();
function getTagsFromForm(){
	$tab = array();
	
	foreach($_POST as $key => $value){
		if(substr_count($key, "tag")==1 && $value=="on"){
			array_push($tab, intval(substr($key,3)));
		}
	}
	
	return $tab;
}

function returnItemFromID($id, $pattern){
		
	foreach($_POST as $key => $value){
		if(substr_count($key, $pattern)==1 && $value==$id){
			return intval(substr($key,9));
		}
	}
	
}






/*********************
* Traitement du Formulaire
*********************/
if(!empty($_GET['task']) && $_GET['task']=="process" && $_POST["submit"]=="Envoyer"){
	
	if($action=='editTopic'){
		//EDITION TOPIC
		$tmpTags = getTagsFromForm();
		if(!empty($_POST['subject']) && !empty($_POST['message']) && !empty($tmpTags) && 
			($_POST['calActivated']!="on"
			|| 
			($_POST['calActivated']=="on" && !empty($_POST['calTitle']) && !empty($_POST['calDesc']) && 
				ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$_POST['calDateBegin']) &&
				ereg("^[0-9]{2}:[0-9]{2}$",$_POST['calTimeBegin']) &&
				ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$_POST['calDateEnd']) &&
				ereg("^[0-9]{2}:[0-9]{2}$",$_POST['calTimeEnd']) &&
				!empty($_POST['calType']) &&
				!empty($_POST['calEid'])
				
			))
			&&
			($_POST['pollActivated']!="on"
			||
			($_POST['pollActivated']=="on" &&
				!empty($_POST['pollQuestion_1']) &&
				!empty($_POST['pollReponses_1']) &&
				!empty($_POST['pollMaxReponse_1']) 
			))){
				
			//Security
			$sec = $db->get_array($db->Send_Query("SELECT bid, author FROM exo_forum_posts P LEFT JOIN exo_forum_topics T ON T.tid=P.tid WHERE pid = $pid"));
			
			if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$sec['bid'].'_MODERATE')!=TRUE && $sec['author']!=$_SESSION['uid']){
				$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
			}
						
			$subject = mysql_real_escape_string($_POST['subject']);
			$message = mysql_real_escape_string($_POST['message']);
			$author_2 = intval($_POST['author_2']);
			
			$announce = (!empty($_POST['announce']) && $_POST['announce']=='on') ? 1 : 0;
			$lock = (!empty($_POST['lock']) && $_POST['lock']=='on') ? 1 : 0;
			
			$time = time();
			
			//Update POST
			$query = "	UPDATE exo_forum_posts 
						SET 	body='$message', 
								post_last_edit_time='$time', 
								post_last_edit_uid='".$_SESSION['uid']."', 
								author_2='$author_2'
						WHERE pid = $pid";
			$result = $db->Send_Query($query);
			
			//Update TOPIC
			$query = "	UPDATE exo_forum_topics 
						SET 	subject='$subject', 
								type='$announce',
								locked=$lock
						WHERE tid = $tid";
			$result = $db->Send_Query($query);		
			
			//Update TAGS
			$result = $db->Send_Query("DELETE FROM exo_forum_tag_assoc WHERE topic=$tid");	
			foreach($tmpTags as $key){				
				$query = "INSERT INTO exo_forum_tag_assoc(tag, topic) VALUES($key, $tid)";
				$result = $db->Send_Query($query);
			}
			
			//Update Calendrier
				$calTitle = mysql_real_escape_string($_POST['calTitle']);
				$calDesc = mysql_real_escape_string($_POST['calDesc']);
				$calDateBegin = mysql_real_escape_string($_POST['calDateBegin']);
				$calTimeBegin = mysql_real_escape_string($_POST['calTimeBegin']);
				$calDateEnd = mysql_real_escape_string($_POST['calDateEnd']);
				$calTimeEnd = mysql_real_escape_string($_POST['calTimeEnd']);
				$calType = intval($_POST['calType']);
				$calEid = intval($_POST['calEid']);
				
				$query_write = "
				UPDATE exo_events 
				SET date_begin=STR_TO_DATE('$calDateBegin $calTimeBegin', '%d/%m/%Y %H:%i'), date_end=STR_TO_DATE('$calDateEnd $calTimeEnd', '%d/%m/%Y %H:%i'), mini_title='$calTitle', mini_desc='$calDesc', `type`='$calType', tid='$tid' 
				WHERE `eid`='$calEid'";
				$result = $db->Send_Query($query_write);
				//Spyvo
				$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'Forum', 'Update Calendar;ID Topic='.$tid);
			
			//Update Sondages
			$pollpID = intval($_POST['pollpID']);
			
			if(($_POST['pollActivatedChoice']=='EDIT' || $_POST['pollActivatedChoice']=='DELETE') && !empty($pollpID)){
				
				//On supprime le sondage
				$r = $db->Send_Query("UPDATE exo_poll SET pLink=0 WHERE pID=$pollpID");	
				//Spyvo
				$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'Forum', 'Delete Sondage;ID Topic='.$tid.' | pID='.$pollpID);
			}
				
			if(($_POST['pollActivatedChoice']=='EDIT' && !empty($pollpID)) || ($_POST['pollActivated']=="on" && empty($pollpID))){
	
				$again = ($_POST['pollAgain']=="on") ? 1 : 0;
				$nbdays = intval($_POST['pollNbDays']);
				
				$r = $db->Send_Query("INSERT INTO exo_poll(pID, pLink, pAgain, pNbDays) VALUES(NULL, $tid, $again, $nbdays)");
				$pID = $db->last_insert_id();
				
				foreach($_POST as $key => $value){
					$value = mysql_real_escape_string($value);
					
					if(
						substr_count($key, "pollQuestion_")==1 && 
						!empty($value) && 
						!empty($_POST['pollReponses_'.intval(substr($key,13)).'']) &&
						!empty($_POST['pollMaxReponse_'.intval(substr($key,13)).''])
					){
						
						$r = $db->Send_Query("INSERT INTO exo_poll_questions(pqID, pqLink, pqTitle, pqMaxReponse) VALUES(NULL, $pID, '$value', ".intval($_POST['pollMaxReponse_'.intval(substr($key,13))]).")");
						$pqID = $db->last_insert_id();
						
						$tabReponses = explode("\n", $_POST['pollReponses_'.intval(substr($key,13))]);
						foreach($tabReponses as $reponseValue){
							$reponseValue = mysql_real_escape_string(preg_replace("(\r\n|\n|\r)",'',$reponseValue));
							$r = $db->Send_Query("INSERT INTO exo_poll_choice(pcID, pcLink, pcTitle) VALUES(NULL, $pqID, '$reponseValue')");
						}
					}
				}
				//Spyvo
				$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'Forum', 'Edit Sondage;ID Topic='.$tid.' | pID='.$pID);
				}
			
					
			
			$msg = message::getInstance('SUCCESS','Edition du sujet réussie', 'index.php?comp=forum_topic&select='.$tid.'&start=0');
		}
		else{
			if(empty($_POST['subject'])) $msg = message::getInstance('ERROR','Le titre est vide', 0);
			if(empty($_POST['message'])) $msg = message::getInstance('ERROR','Le message est vide', 0);
			if(empty($tmpTags)) $msg = message::getInstance('ERROR','Aucun tag sélectionné', 0);
			
			if($_POST['calActivated']=="on"){
				if(empty($_POST['calTitle'])) $msg = message::getInstance('ERROR','Le titre du calendrier est vide', 0);
				if(empty($_POST['calDesc'])) $msg = message::getInstance('ERROR','La description du calendrier est vide', 0);
				if(!ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$_POST['calDateBegin'])) $msg = message::getInstance('ERROR','Le format de la date de début du calendrier est non conforme (JJ/MM/AAAA)', 0);
				if(!ereg("^[0-9]{2}:[0-9]{2}$",$_POST['calTimeBegin'])) $msg = message::getInstance('ERROR','Le format de l\'heure de début du calendrier est non conforme (HH:MM)', 0);
				if(!ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$_POST['calDateEnd'])) $msg = message::getInstance('ERROR','Le format de la date de fin du calendrier est non conforme (JJ/MM/AAAA)', 0);
				if(!ereg("^[0-9]{2}:[0-9]{2}$",$_POST['calTimeEnd'])) $msg = message::getInstance('ERROR','Le format de l\'heure de début du calendrier est non conforme (HH:MM)', 0);
				if(empty($_POST['calType'])) $msg = message::getInstance('ERROR','Le type du calendrier est vide', 0);
				if(empty($_POST['calEid'])) $msg = message::getInstance('ERROR','Impossible d\'éditer le calendrier', 0);
			}
				
			if($_POST['pollActivated']=="on"){
				if(empty($_POST['pollQuestion_1'])) $msg = message::getInstance('ERROR','La première question du sondage est obligatoire', 0);
				if(empty($_POST['pollReponses_1'])) $msg = message::getInstance('ERROR','La première réponse du sondage est obligatoire', 0);
				if(empty($_POST['pollMaxReponse_1'])) $msg = message::getInstance('ERROR','Le nombre de réponses de la première question du sondage est obligatoire et non vide', 0);
			}
		}
		
	}	
	else if($action=='editPost'){
		//EDITION REPONSE
		if(!empty($_POST['message'])){
			//Security
			$sec = $db->get_array($db->Send_Query("SELECT bid, author FROM exo_forum_posts P LEFT JOIN exo_forum_topics T ON T.tid=P.tid WHERE pid = $pid"));
			
			if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$sec['bid'].'_MODERATE')!=TRUE && $sec['author']!=$_SESSION['uid']){
				$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
			}
			
			$message = mysql_real_escape_string($_POST['message']);
			$author_2 = intval($_POST['author_2']);
			
			$time = time();
			
			//Update POST
			$query = "	UPDATE exo_forum_posts 
						SET 	body='$message', 
								post_last_edit_time='$time', 
								post_last_edit_uid='".$_SESSION['uid']."',
								author_2='$author_2' 
						WHERE pid = $pid";
			$result = $db->Send_Query($query);	

			//Recherche le tid de ce message
			$query = "SELECT tid FROM exo_forum_posts WHERE pid = $pid";
			$result = $db->Send_Query($query);
			$array = $db->get_array($result);
			$tid = $array['tid'];		
			
			$msg = message::getInstance('SUCCESS','Edition de la réponse réussie', 'index.php?comp=forum_topic&select='.$tid.'&goto='.$pid.'#pid'.$pid);
		}
		else{
			if(empty($_POST['message'])) $msg = message::getInstance('ERROR','Le message est vide', 0);			
		}
		
	}	
	else if($action=='newPost'){
		//NOUVELLE REPONSE
		
		if(!empty($_POST['message'])){
			
			//Recherche le bid de ce message
			$query = "SELECT bid FROM exo_forum_topics WHERE tid = $tid";
			$result = $db->Send_Query($query);
			$array = $db->get_array($result);
			$bid = $array['bid'];
			
			//Security
			if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$bid.'_REPLY')!=TRUE){
				$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
			}
			
			$message = mysql_real_escape_string($_POST['message']);
			$author_2 = intval($_POST['author_2']);
			
			$time = time();
			
			//Requete POST
			$query = "INSERT INTO 
				exo_forum_posts (pid, tid, body, author, author_2, post_time, post_last_edit_time, post_last_edit_uid) 
				VALUES(NULL,$tid,'$message','".intval($_SESSION['uid'])."', '$author_2', '$time', 0, 0)";
			$result = $db->Send_Query($query);
			$pid = $db->last_insert_id();
			
			//Mise à jour de TOPIC
			$query = "UPDATE exo_forum_topics SET nb_replies=nb_replies+1, last_post_id=$pid WHERE tid = $tid";
			$result = $db->Send_Query($query);				
			
			//Mise à jour de BOARD
			$query = "UPDATE exo_forum_boards SET nb_posts=nb_posts+1, last_post_id=$pid WHERE bid = $bid";
			$result = $db->Send_Query($query);
			
			//Mise à jour de lu
			$db->Send_Query("UPDATE exo_lu_forum SET last_pid =$pid WHERE tid = $tid AND uid = ".intval($_SESSION['uid']));
			
			//Indices
			update_ivo('nb_post');	
			
			$msg = message::getInstance('SUCCESS','Reponse ajoutée', 'index.php?comp=forum_topic&select='.$tid.'&goto='.$pid.'#pid'.$pid);
		}
		else{
			if(empty($_POST['message'])) $msg = message::getInstance('ERROR','Le message est vide', 0);	
		}
		
		
	}
	else if ($action=='newTopic'){
		//NOUVEAU TOPIC			
		
		$tmpTags = getTagsFromForm();
		
		if(!empty($_POST['subject']) && !empty($_POST['message']) && !empty($tmpTags) && 
			($_POST['calActivated']!="on"
			|| 
			($_POST['calActivated']=="on" &&
				!empty($_POST['calTitle']) && !empty($_POST['calDesc']) && 
				ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$_POST['calDateBegin']) &&
				ereg("^[0-9]{2}:[0-9]{2}$",$_POST['calTimeBegin']) &&
				ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$_POST['calDateEnd']) &&
				ereg("^[0-9]{2}:[0-9]{2}$",$_POST['calTimeEnd']) &&
				!empty($_POST['calType'])
			))
			&&
			($_POST['pollActivated']!="on"
			||
			($_POST['pollActivated']=="on" &&
				!empty($_POST['pollQuestion_1']) &&
				!empty($_POST['pollReponses_1']) &&
				!empty($_POST['pollMaxReponse_1'])
			)
			)
			){
				
			//Security	
			if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$bid.'_CREATE')!=TRUE){
				$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
			}
			
			$subject = mysql_real_escape_string($_POST['subject']);
			$message = mysql_real_escape_string($_POST['message']);
			$author_2 = intval($_POST['author_2']);
						
			$announce = (!empty($_POST['announce']) && $_POST['announce']=='on') ? 1 : 0;
			$lock = (!empty($_POST['lock']) && $_POST['lock']=='on') ? 1 : 0;
					
			$time = time();
			
			//Requete TOPIC
			$query = "INSERT INTO 
				exo_forum_topics(tid, bid, type, subject, nb_replies, nb_views, first_post_id, last_post_id, locked) 
				VALUES(NULL,$bid,'$announce','$subject', 0, 0, 0, 0, $lock)";
			$result = $db->Send_Query($query);
			$tid = $db->last_insert_id();
			
			//Requete: TAG
			foreach($tmpTags as $key){				
				$query = "INSERT INTO exo_forum_tag_assoc(tag, topic) VALUES($key, $tid)";
				$result = $db->Send_Query($query);
			}
			
			//Requete POST
			$query = "INSERT INTO 
				exo_forum_posts (pid, tid, body, author, author_2, post_time, post_last_edit_time, post_last_edit_uid) 
				VALUES(NULL,$tid,'$message','".intval($_SESSION['uid'])."', '$author_2', '$time', 0, 0)";
			$result = $db->Send_Query($query);
			$pid = $db->last_insert_id();
			
			//Mise à jour de TOPIC
			$query = "UPDATE exo_forum_topics SET first_post_id=$pid, last_post_id=$pid WHERE tid = $tid";
			$result = $db->Send_Query($query);	
			
			//Mise à jour de BOARD
			$query = "UPDATE exo_forum_boards SET nb_topics=nb_topics+1, last_post_id=$pid WHERE bid = $bid";
			$result = $db->Send_Query($query);
			
			//Mise à jour de lu
			$db->Send_Query("INSERT INTO exo_lu_forum (uid, tid, last_pid) VALUES ('".$_SESSION['uid']."', $tid,$pid)");
			
			//Calendrier
			if ($_POST['calActivated']=="on"){
				$calTitle = mysql_real_escape_string($_POST['calTitle']);
				$calDesc = mysql_real_escape_string($_POST['calDesc']);
				$calDateBegin = mysql_real_escape_string($_POST['calDateBegin']);
				$calTimeBegin = mysql_real_escape_string($_POST['calTimeBegin']);
				$calDateEnd = mysql_real_escape_string($_POST['calDateEnd']);
				$calTimeEnd = mysql_real_escape_string($_POST['calTimeEnd']);
				$calType = intval($_POST['calType']);
				
				$query_write = "
				INSERT INTO exo_events(eid, `date_begin`, `date_end`, mini_title, mini_desc, `type`, tid) 
				VALUES(NULL, STR_TO_DATE('$calDateBegin $calTimeBegin', '%d/%m/%Y %H:%i'), STR_TO_DATE('$calDateEnd $calTimeEnd', '%d/%m/%Y %H:%i'), '$calTitle', '$calDesc', $calType, $tid) ";
				$result = $db->Send_Query($query_write);
				//Spyvo
				$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'Forum', 'Add Calendar;ID Topic='.$tid);
			}
			
			//Sondages
			if ($_POST['pollActivated']=="on"){				
				$again = ($_POST['pollAgain']=="on") ? 1 : 0;
				$nbdays = intval($_POST['pollNbDays']);
				
				$r = $db->Send_Query("INSERT INTO exo_poll(pID, pLink, pAgain, pNbDays) VALUES(NULL, $tid, $again, $nbdays)");
				$pID = $db->last_insert_id();
				
				foreach($_POST as $key => $value){
					$value = mysql_real_escape_string($value);
					
					if(
						substr_count($key, "pollQuestion_")==1 && 
						!empty($value) && 
						!empty($_POST['pollReponses_'.intval(substr($key,13)).'']) &&
						!empty($_POST['pollMaxReponse_'.intval(substr($key,13)).''])
					){
						
						$r = $db->Send_Query("INSERT INTO exo_poll_questions(pqID, pqLink, pqTitle, pqMaxReponse) VALUES(NULL, $pID, '$value', ".intval($_POST['pollMaxReponse_'.intval(substr($key,13))]).")");
						$pqID = $db->last_insert_id();
						
						$tabReponses = explode("\n", $_POST['pollReponses_'.intval(substr($key,13))]);
						foreach($tabReponses as $reponseValue){
							$reponseValue = mysql_real_escape_string(preg_replace("(\r\n|\n|\r)",'',$reponseValue));
							$r = $db->Send_Query("INSERT INTO exo_poll_choice(pcID, pcLink, pcTitle) VALUES(NULL, $pqID, '$reponseValue')");
						}
					}
				}
				//Spyvo
				$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'Forum', 'Add Sondage;ID Topic='.$tid);
				
			}
			
			//Indices
			update_ivo('nb_topic');
			
			$msg = message::getInstance('SUCCESS','Sujet ajouté', 'index.php?comp=forum_topic&select='.$tid.'&start=0');
		}
		else{
			if(empty($_POST['subject'])) $msg = message::getInstance('ERROR','Le titre est vide', 0);
			if(empty($_POST['message'])) $msg = message::getInstance('ERROR','Le message est vide', 0);
			if(empty($tmpTags)) $msg = message::getInstance('ERROR','Aucun tag sélectionné', 0);
						
			if($_POST['calActivated']=="on"){
				if(empty($_POST['calTitle'])) $msg = message::getInstance('ERROR','Le titre du calendrier est vide', 0);
				if(empty($_POST['calDesc'])) $msg = message::getInstance('ERROR','La description du calendrier est vide', 0);
				if(!ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$_POST['calDateBegin'])) $msg = message::getInstance('ERROR','Le format de la date de début du calendrier est non conforme (JJ/MM/AAAA)', 0);
				if(!ereg("^[0-9]{2}:[0-9]{2}$",$_POST['calTimeBegin'])) $msg = message::getInstance('ERROR','Le format de l\'heure de début du calendrier est non conforme (HH:MM)', 0);
				if(!ereg("^[0-9]{2}/[0-9]{2}/[0-9]{4}$",$_POST['calDateEnd'])) $msg = message::getInstance('ERROR','Le format de la date de fin du calendrier est non conforme (JJ/MM/AAAA)', 0);
				if(!ereg("^[0-9]{2}:[0-9]{2}$",$_POST['calTimeEnd'])) $msg = message::getInstance('ERROR','Le format de l\'heure de début du calendrier est non conforme (HH:MM)', 0);
				if(empty($_POST['calType'])) $msg = message::getInstance('ERROR','Le type du calendrier est vide', 0);
			}	
				
			if($_POST['pollActivated']=="on"){
				if(empty($_POST['pollQuestion_1'])) $msg = message::getInstance('ERROR','La première question du sondage est obligatoire', 0);
				if(empty($_POST['pollReponses_1'])) $msg = message::getInstance('ERROR','La première réponse du sondage est obligatoire', 0);
				if(empty($_POST['pollMaxReponse_1'])) $msg = message::getInstance('ERROR','Le nombre de réponses de la première question du sondage est obligatoire et non vide', 0);
			}
		}
		
		
	}
	else{
		
		$msg = message::getInstance('ERROR','Action inconnu', 0);
	}
	
}
/*********************
* Affichage du formulaire pour l'édition
*********************/

if($action=="editTopic"){
	//EDITION TOPIC
	$printTopic = TRUE;
	$text = "Modifier un topic";
	
	$requete = "
		SELECT author, body, subject, T.type, T.locked, GROUP_CONCAT(TA.tag SEPARATOR ';') as myTags, author_2
		FROM exo_forum_posts P 
		LEFT JOIN exo_forum_topics T ON T.tid=P.tid  
		LEFT JOIN exo_forum_tag_assoc TA on TA.topic=T.tid
		WHERE pid=$pid and T.tid=$tid
		GROUP BY pid";
	$rq = $db->Send_Query($requete);
	$result = $db->get_array($rq);
	
	$form_body = (empty($_POST['message'])) ? stripslashes(htmlspecialchars($result['body'])) :  $_POST['message'];
	$form_subject = (empty($_POST['subject'])) ? stripslashes(htmlspecialchars($result['subject'])) : $_POST['subject'];
	$tmpTags = getTagsFromForm();
	$form_tag = (empty($tmpTags)) ? explode(";",$result['myTags']) : $tmpTags;
	$form_announce = ($result['type']==1) ? 'checked="checked"' : '';
	$form_lock = ($result['locked']==1) ? 'checked="checked"' : '';
	$author=$result['author'];
	$form_author_2 = (!isset($_POST['author_2'])) ? $result['author_2'] : $_POST['author_2'];
	
	
	//Recherche le bid de ce message
	$query = "SELECT bid FROM exo_forum_topics WHERE tid = $tid";
	$result = $db->Send_Query($query);
	$array = $db->get_array($result);
	$bid = $array['bid'];
	
	if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$bid.'_MODERATE')!=TRUE && $author!=$_SESSION['uid']){
		$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
	}

	
	$rq = $db->Send_Query("SELECT tag_id, title, description FROM exo_forum_tags WHERE link_bid=$bid ORDER BY title");
	$tags = $db->loadObjectList($rq);
	
	//Calendrier
	$requete = "
		SELECT eid, DATE_FORMAT(date_begin, '%d/%m/%Y') as date_begin, DATE_FORMAT(date_begin, '%H:%i') as time_begin, DATE_FORMAT(date_end, '%d/%m/%Y') as date_end, DATE_FORMAT(date_end, '%H:%i') as time_end, mini_title, mini_desc, type
		FROM exo_events
		WHERE tid=$tid";
	$rq = $db->Send_Query($requete);
	$result = $db->get_array($rq);
	
	$form_calTitle = (empty($_POST['calTitle'])) ? stripslashes(htmlspecialchars($result['mini_title'])) :  $_POST['calTitle'];
	$form_calDesc = (empty($_POST['calDesc'])) ? stripslashes(htmlspecialchars($result['mini_desc'])) :  $_POST['calDesc'];
	$form_calDateBegin = (empty($_POST['calDateBegin'])) ? stripslashes(htmlspecialchars($result['date_begin'])) : $_POST['calDateBegin'];
	$form_calTimeBegin = (empty($_POST['calTimeBegin'])) ? stripslashes(htmlspecialchars($result['time_begin'])) : $_POST['calTimeBegin'];
	$form_calDateEnd = (empty($_POST['calDateEnd'])) ? stripslashes(htmlspecialchars($result['date_end'])) : $_POST['calDateEnd'];
	$form_calTimeEnd = (empty($_POST['calTimeEnd'])) ? stripslashes(htmlspecialchars($result['time_end'])) : $_POST['calTimeEnd'];
	$form_calType = (empty($_POST['calType'])) ? intval($result['type']) : $_POST['calType'];
	$form_calEid = (empty($_POST['calEid'])) ? intval($result['eid']) : $_POST['calEid'];
	$form_calActivated = (!empty($form_calEid)) ? 'checked="checked"' : '';
	
	//Sondage	
	$requete = "
		SELECT pID, pAgain, pNbDays, pqID, pqTitle, pqMaxReponse, GROUP_CONCAT( DISTINCT pcID SEPARATOR '|' ) as choiceid, GROUP_CONCAT( DISTINCT pcTitle SEPARATOR '|' ) as choice
		FROM exo_poll
		LEFT JOIN exo_poll_questions ON pqLink = pID
		LEFT JOIN exo_poll_choice ON pcLink = pqID
		WHERE pLink=$tid
		GROUP BY pqID";
	$rq = $db->Send_Query($requete);
	$polls = $db->loadObjectList($rq);
	
	$form_pollpID = $polls[0]->pID;
	$bddpollpAgain = $polls[0]->pAgain;
	$bddpollpNbDays = $polls[0]->pNbDays;
	
	$form_pollAgain = ($_POST['pollAgain']=="on" || $bddpollpAgain==1) ? 'checked="checked"' : '';
	$form_pollNbDays = (empty($_POST['pollNbDays'])) ? intval($bddpollpNbDays) :  $_POST['pollNbDays'];
	$form_pollActivated = (!empty($form_pollpID)) ? 'checked="checked" disabled' : '';
	$form_pollActivatedChoice = $_POST['pollActivatedChoice'];
	
	$form_polls = array();
	foreach($polls as $poll){
		$item =returnItemFromID($poll->pqID, 'pollpqID');
		$form_pqTitle = (empty($_POST['pollQuestion_'.$item])) ? $poll->pqTitle : $_POST['pollQuestion_'.$item];
		
		$item =returnItemFromID($poll->choiceid, 'pollpcID_');		
		$form_pcTitle = (empty($_POST['pollReponses_'.$item])) ? str_replace("|", "\n", $poll->choice) : $_POST['pollReponses_'.$item];
		
		$item = returnItemFromID($poll->pqMaxReponse, 'pollpqMaxResponse_');
		$form_pqMaxReponse = (empty($_POST['pollMaxResponse_'.$item])) ? $poll->pqMaxReponse : $_POST['pollMaxReponse_'.$item];
		
		$pollToAdd = array(
		'question' => $form_pqTitle,
		'questionid' => $poll->pqID,
		'reponses' => $form_pcTitle,
		'reponsesid' => $poll->choiceid,
		'maxreponse' => $form_pqMaxReponse,
		'maxreponseid' => $poll->pqMaxReponse
		);	
	
		
		
		array_push($form_polls, $pollToAdd);
	}
	foreach($_POST as $key => $value){
		if(substr_count($key, "pollQuestion_")==1 && !empty($value) && empty($_POST['pollpqID_'.intval(substr($key,13))])){
			$pollToAdd = array(
			'question' => $value,
			'reponses' => $_POST['pollReponses_'.intval(substr($key,13))],
			'maxreponse' => $_POST['pollMaxReponse_'.intval(substr($key,13))]
			);
			
			array_push($form_polls, $pollToAdd);
		}
	}
	
	
	
}
else if($action=="editPost"){
//EDITION POST
	$printTopic = FALSE;
	$text = "Modifier une réponse";
		
	$rq = $db->Send_Query("
			SELECT author, bid, subject, body, author_2
			FROM exo_forum_posts P
			LEFT JOIN exo_forum_topics T ON P.tid = T.tid
			WHERE pid=$pid");
			
	$result = $db->get_array($rq);
	
	if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$result['bid'].'_MODERATE')!=TRUE && $result['author']!=$_SESSION['uid']){
		$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
	}
	
	$form_author_2 = (!isset($_POST['author_2'])) ? $result['author_2'] : $_POST['author_2'];

	$form_body = (empty($_POST['message'])) ? stripslashes(htmlspecialchars($result['body'])) :  $_POST['message'];
	$form_subject = stripslashes(htmlspecialchars($result['subject']));
}
else if($action=="newTopic"){
	//New: topic
	$printTopic = TRUE;
	$text = "Création d'un nouveau sujet";
		
	$rq = $db->Send_Query("SELECT tag_id, title, description FROM exo_forum_tags WHERE link_bid=$bid ORDER BY title");
	$tags = $db->loadObjectList($rq);			
	
	if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$bid.'_CREATE')!=TRUE){
		$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
	}
	
	$form_body = $_POST['message'];
	$form_subject = $_POST['subject'];		
	$form_announce = ($_POST['announce']=="on") ? 'checked="checked"' : '';
	$form_lock = ($_POST['lock']=="on") ? 'checked="checked"' : '';
	$form_author_2 = $_POST['author_2'];
	
	//calendrier
	$form_calActivated = ($_POST['calActivated']=="on") ? 'checked="checked"' : '';
	$form_calTitle = $_POST['calTitle'];
	$form_calDesc = $_POST['calDesc'];
	$form_calDateBegin = $_POST['calDateBegin'];
	$form_calTimeBegin = $_POST['calTimeBegin'];
	$form_calDateEnd = $_POST['calDateEnd'];
	$form_calTimeEnd = $_POST['calTimeEnd'];
	$form_calType = $_POST['calType'];
	
	//sondage
	$form_pollActivated = ($_POST['pollActivated']=="on") ? 'checked="checked"' : '';
	$form_pollAgain = ($_POST['pollAgain']=="on") ? 'checked="checked"' : '';
	$form_pollNbDays = intval($_POST['pollNbDays']);
	$form_pollActivatedChoice = $_POST['pollActivatedChoice'];
	
	
	$form_polls = array();
	foreach($_POST as $key => $value){
		if(substr_count($key, "pollQuestion_")==1 && !empty($value)){
			$pollToAdd = array(
			'question' => $value,
			'reponses' => $_POST['pollReponses_'.intval(substr($key,13))],
			'maxreponse' => $_POST['pollMaxReponse_'.intval(substr($key,13))]
			);
			
			array_push($form_polls, $pollToAdd);
		}
	}
	
		
	$form_tag = getTagsFromForm();
	
	
}
else{
	//Repondre
	$rq = $db->Send_Query("
			SELECT bid, subject
			FROM exo_forum_topics
			WHERE tid=$tid");
			
	$result = $db->get_array($rq);	
	
	if($secureObject->verifyAuthorization('FO_FORUM_BOARD_'.$result['bid'].'_REPLY')!=TRUE){
		$msg = message::getInstance('ERROR', 'Droits insuffisants pour accéder à ce forum.', './index.php?comp=forum_index');
	}
	
	if(empty($_POST['message']) && !empty($pid)){
		$rq = $db->Send_Query("
			SELECT pseudo, body
			FROM exo_forum_posts
			LEFT JOIN exo_users ON uid=author
			WHERE pid=$pid");
			
		$r = $db->get_array($rq);
		$form_body = '[quote='.$r['pseudo'].']'.$r['body'].'[/quote]';
	}
	else{
		$form_body = $_POST['message'];
	}
	$form_subject = stripslashes(htmlspecialchars($result['subject']));
	$form_author_2 = $_POST['author_2'];
	$text = "Ajout d'une réponse au sujet";
}

//Liste des autheurs possible
if(!empty($pid)){
	$requete = "
		SELECT B.guid, B.name
		FROM exo_forum_posts P
		LEFT JOIN exo_users U ON U.uid=P.author
		LEFT JOIN exo_backgrounds B ON B.wow_id=U.wow_id
		WHERE B.statut='VALIDE' and P.pid=$pid
		GROUP BY B.name";
}
else{
	$requete = "
	SELECT B.guid, B.name
	FROM exo_backgrounds B
	WHERE B.statut='VALIDE' and B.wow_id='".$_SESSION['wow_id']."'
	GROUP BY B.name";
}
$rq = $db->Send_Query($requete);
$authors_2 = $db->loadObjectList($rq);



//Derniers messages: Si on post et si on edit un post.
if ($printTopic==FALSE){

	if(empty($tid)){		
		$rq = $db->Send_Query("
			SELECT tid
			FROM exo_forum_posts 
			WHERE pid=$pid");
			
		$result = $db->get_array($rq);
		
		$tid = $result['tid'];
	}

	$rq = $db->Send_Query("
	SELECT 
		fp.body,
		up.pseudo as p_name,
		up.uid as p_uid,
		fp.post_time,
		fc.cat_rp,
		b.guid as bg_guid,
		b.name as bg_name
			
	FROM exo_forum_posts fp
	LEFT JOIN exo_users up ON up.uid = fp.author
	LEFT JOIN exo_backgrounds b ON b.guid=fp.author_2
	LEFT JOIN exo_forum_topics ft ON ft.tid = fp.tid
	LEFT JOIN exo_forum_boards fb ON fb.bid = ft.bid
	LEFT JOIN exo_forum_categories fc ON fc.catid = fb.catid
	WHERE fp.tid = $tid
	ORDER BY fp.post_time DESC
	LIMIT 30");

	$last_msgs = $db->loadObjectList($rq);
	
	$cat_name = $last_msgs[0]->cat_name;
	$catid = $last_msgs[0]->catid;	
	$board_name = $last_msgs[0]->board_name;
	$bid = $last_msgs[0]->board_id;
	$catRP = $last_msgs[0]->cat_rp;
}
else{
	
	$rq = $db->Send_Query("
				SELECT fb.board_name, fb.bid, fc.cat_name, fc.catid, fc.cat_rp
				FROM exo_forum_boards fb
				LEFT JOIN exo_forum_categories fc ON fc.catid = fb.catid
				WHERE fb.bid = $bid");
	$temp = $db->get_array($rq);
	
	$cat_name = $temp['cat_name'];
	$catid = $temp['catid'];
	$board_name = $temp['board_name'];
	$bid = $temp['bid'];
	$catRP = $temp['cat_rp'];
}


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'forum';


 
/*
* MANAGE PATHWAY
*/
if($action=="newTopic"){
	$pathway = array(
	'Forum' => 'index.php?comp=forum_index',
	$cat_name => 'index.php?comp=forum_index#cat'.intval($catid),
	$board_name => 'index.php?comp=forum_board&amp;select='.$bid.'&amp;start=0',
	$text => ''
	); 
	$ws_name_perso = 'Evoxis v5 - Forum - '.$board_name.' - Ecrire un nouveau message';
}
else{
	$pathway = array(
	'Forum' => 'index.php?comp=forum_index',
	$cat_name => 'index.php?comp=forum_index#cat'.$catid,
	$board_name => 'index.php?comp=forum_board&amp;select='.$bid.'&amp;start=0',
	$form_subject => 'index.php?comp=forum_topic&amp;select='.$tid.'&amp;start=0',
	$text => ''
	); 
	$ws_name_perso = 'Evoxis v5 - Forum - '.$form_subject.' - Répondre';
}
?>
