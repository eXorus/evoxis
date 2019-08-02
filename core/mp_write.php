<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_MP_WRITE', 1 );

$dpID = (!empty($_GET['dpID'])) ? intval($_GET['dpID']) : intval($_POST['dpID']);

if(!empty($_GET['task']) && $_GET['task']=='process'){
	if(!empty($dpID)){
		//Réponse à un MP		
		$dpID = $db->get_result($db->Send_Query("SELECT dpID FROM exo_mp_discussions WHERE dpID = '$dpID'"),0);
		
		if(empty($dpID)){
			$msg = message::getInstance('ERROR','Aucune discussion', 0);			
		}
		elseif(empty($_POST['message'])){
			$msg = message::getInstance('ERROR','Vous devez indiquer un texte à ce message.', 0);
		}
		else{
			$participe = $db->get_result($db->Send_Query("SELECT COUNT(*) FROM exo_mp_participate WHERE dpID=$dpID AND participe=1 AND uid=".$_SESSION['uid'].""),0);
			
			if(empty($participe)){				
					$msg = message::getInstance('ERROR', 'Vous n\'avez pas le droit de répondre à ce message. ', './index.php?comp=mp');
			}
			else{
				
				$participants = $db->get_result($db->Send_Query("SELECT COUNT(*) FROM exo_mp_participate WHERE dpID=$dpID AND participe=1 AND uid!=".$_SESSION['uid'].""),0);
				
				if(empty($participants)){				
						$msg = message::getInstance('ERROR', 'Vous ne pouvez pas parler tout seul ! ', './index.php?comp=mp');
				}
				else{
				
					$message = mysql_real_escape_string($_POST['message']);
					$result = $db->Send_Query("INSERT INTO exo_mp_messages (mpID, dpID, uid, mpMessage, mpDateCreation) VALUES (NULL, $dpID, ".$_SESSION['uid'].", '$message', NOW())");
					$mpID = $db->last_insert_id();
					$result = $db->Send_Query("UPDATE exo_mp_discussions SET last_mpID=$mpID WHERE dpID=$dpID");	
					$result = $db->Send_Query("UPDATE exo_mp_participate SET last_msg_vu=$mpID WHERE dpID=$dpID AND uid=".$_SESSION['uid']."");					
					
					$msg = message::getInstance('SUCCESS','MP envoyé', 'index.php?comp=mp');
				}
			}
		}
		
	}
	else{
		//Nouveau MP
	
		if(empty($_POST['to'])){
			$msg = message::getInstance('ERROR','Aucun destinataire défini !', 0);
		}
		elseif(empty($_POST['subject'])){
			$msg = message::getInstance('ERROR','Vous devez indiquer un titre au nouveau message privé.', 0);
		}
		elseif(empty($_POST['message'])){
			$msg = message::getInstance('ERROR','Vous devez indiquer un texte à ce message.', 0);
		}
		else{
			$to = mysql_real_escape_string($_POST['to']);
			$subject = mysql_real_escape_string($_POST['subject']);
			$ssubject = mysql_real_escape_string($_POST['ssubject']);
			$message = mysql_real_escape_string($_POST['message']);
			
			//Vérification des logins
			$PartsID = array();
			$tos = explode(',', $to);
			$error= 0;
			
			foreach ($tos as $login){
				$login = trim($login);
				
				if(!empty($login)){
					$id = $db->get_result($db->Send_Query("SELECT uid FROM exo_users WHERE username = '$login'"),0);
					
					if(empty($id)){
						$error++;
						$msg = message::getInstance('ERROR',$login.' n\'existe pas. Avez-vous bien orthographié son pseudo ?  ', 0);
					}
					elseif($id==$_SESSION['uid']){
						$error++;
						$msg = message::getInstance('ERROR','Tu ne peux pas envoyer de message à '.$login.'. Pourquoi ? Parce que c\'est toi !  ', 0);
					}
					else{		
						$PartsID[] = $id;
					}
					
					$id = 0;		
				}	
			}
			
			if(empty($error)){
				if(count($PartsID)==0){
					$msg = message::getInstance('ERROR','Aucun destinataire défini !', 0);
				}
				elseif(count($PartsID)>20){
					$msg = message::getInstance('ERROR','Limite max de destinataires atteint (20) !', 0);
				}
				else{
					$result = $db->Send_Query("INSERT INTO exo_mp_discussions (dpID, dpTitle, dpUnderTitle, dpDate, uid) VALUES (NULL, '$subject', '$ssubject', NOW(), ".$_SESSION['uid'].")");
					$dpID = $db->last_insert_id();
					$result = $db->Send_Query("INSERT INTO exo_mp_messages (mpID, dpID, uid, mpMessage, mpDateCreation) VALUES (NULL, $dpID, ".$_SESSION['uid'].", '$message', NOW())");
					$mpID = $db->last_insert_id();
					$result = $db->Send_Query("UPDATE exo_mp_discussions SET last_mpID=$mpID WHERE dpID=$dpID");	
					
					foreach($PartsID as $Part){
						
						$result = $db->Send_Query("INSERT INTO exo_mp_participate (dpID,uid,participe,last_msg_vu) VALUES ($dpID, $Part, 1, 0)");
					}
					$result = $db->Send_Query("INSERT INTO exo_mp_participate (dpID,uid,participe,last_msg_vu) VALUES ($dpID, ".$_SESSION['uid'].", 1, $mpID)");
					
					$msg = message::getInstance('SUCCESS','MP envoyé', 'index.php?comp=mp');
				}
			}
					
		}
	}
}

$query_mp = "
SELECT D.dpID, D.dpTitle, D.dpUnderTitle, U.pseudo, M.mpDateCreation, M.mpMessage, (SELECT COUNT(*) FROM exo_mp_participate WHERE dpID=$dpID AND participe=1 AND uid!=".$_SESSION['uid'].") as nb_part
FROM exo_mp_messages M
LEFT JOIN exo_mp_discussions D ON M.dpID=D.dpID
LEFT JOIN exo_users U ON U.uid=M.uid
WHERE D.dpID = $dpID AND ".$_SESSION['uid']." IN (SELECT uid FROM exo_mp_participate WHERE dpID=D.dpID AND participe=1)
ORDER BY mpDateCreation  DESC
";
	
$result_mp = $db->Send_Query($query_mp);
$mps = $db->loadObjectList($result_mp);


if(empty($mps) && !empty($dpID)){
	$msg = message::getInstance('ERROR','Vous n\'avez pas le droit de répondre à ce message.  ', './index.php?comp=mp');
}

if(empty($mps[0]->nb_part) && !empty($dpID)){
	$msg = message::getInstance('ERROR', 'Vous ne pouvez pas parler tout seul ! ', './index.php?comp=mp_view&dpid='.$dpID);
}


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'messagerie';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Messagerie' => 'index.php?comp=mp',
'Ecrire un message' => ''
);
$ws_name_perso = 'Evoxis v5 - Ecrire un message privé';
?>
