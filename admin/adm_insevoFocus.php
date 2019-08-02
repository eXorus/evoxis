<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_INSEVOFOCUS', 1 );

if(!empty($_GET['task']) && ($_GET['task']=='process_insevo') && !empty($_POST['id_insevo']) && ($_POST['result']=='OK' OR $_POST['result']=='NOK') && !empty($_POST['form_comment']) && $secureObject->verifyAuthorization('BO_INSEVO_VALIDATE')==TRUE){

	$comment = mysql_real_escape_string($_POST['form_comment']." (".$_SESSION['admin_username'].")");
	$result =  $_POST['result'];
	$id_insevo = intval($_POST['id_insevo']);

	//Récupération des infos
	$query = "SELECT login, email, motivation, parrain
			FROM exo_insevo
			WHERE insevo_id = '$id_insevo'";
	$r = $db->Send_Query($query);
	$rs = $db->get_array($r);
	$login = $rs['login'];
	$email = $rs['email'];
	$motivation = $rs['motivation'];
	$parrain = $rs['parrain'];
	
	//Update INSEVO
	$query = "UPDATE exo_insevo SET comment='$comment', state='$result', time_validation='".time()."' WHERE insevo_id = '$id_insevo' AND state='WAIT'";
	$update_insevo = $db->Send_Query($query);
	
	if($update_insevo!=FALSE){						
		//Creation du compte	
		if($result=="OK"){

			//Generation des MDPs
			$password_site = randomString( 9, 'abcdefghjkmnpqrstuvwxyz123456789ABCDEFGHJKMNPQRSTUVWXYZ' );
			$password_mangos = randomString( 9, 'abcdefghijklmnopqrstuvwxyz0123456789' );
			$password_site_secure = hash('sha512',$password_site);
					
			//INSERT WS
			//exo_users
			$query = "INSERT INTO exo_users(uid, username, password, email, pseudo) VALUES(NULL,'$login','$password_site_secure','$email','$login')";
			$r1 = $db->Send_Query($query);
			$id = $db->last_insert_id();
						
			//exo_groups_users
			$query = "INSERT INTO exo_groups_users(gid, uid) VALUES('11','$id')";
			$r2 = $db->Send_Query($query);
								
			//exo_indices:
			$query = "INSERT INTO exo_indices(uid) VALUES('$id')";
			$r3 = $db->Send_Query($query);
			
		
			if($r1!=FALSE && $r2!=FALSE && $r3!=FALSE && !empty($id)){
				//INSERT WOW	
				$query = "	INSERT INTO `account` ( `id` , `username` , `sha_pass_hash` , `gmlevel` , `email` , `joindate`, `expansion`)
										VALUES (NULL , '$login', SHA1(CONCAT(UPPER('$login'),':',UPPER('$password_mangos'))), '0', '$email', CURRENT_TIMESTAMP, '2' )";
				$r4 = $db_realmd->Send_Query($query);
				$wowid = $db_realmd->last_insert_id();
						
				if($r4!=FALSE && !empty($wowid)){
					//INSERT WS
					//exo_users
					$rq = $db->Send_Query("UPDATE exo_users SET wow_id='$wowid' WHERE uid='$id'");
									
					//Indices
					$rq = $db->Send_Query("SELECT uid FROM exo_users WHERE username='$parrain'");
					$ind = $db->get_array($rq);	
					$parrain_uid = $ind['uid'];
					if(!empty($parrain)){
						update_ivo('nb_filleul', $parrain_uid);
					}
											
					//Mail
					$sujet="[EVOXIS] Acceptation de votre compte";
					$contenu=
									"
									<html>
									<p>
									Bonjour,
									</p><p>
									Vous avez fait la demande de création d'un compte sur EVOXIS. Votre demande d'inscription sur EVOXIS vient d'être accepté par un de nos MJs.
									</p>
									<p>
									<ul>
										<li>Date de validation: ".date("d/m/y")."</li>
										<li>Login sur wow et www.evoxis.info: ".$login."</li>
										<li>Mot de passe du site www.evoxis.info: &nbsp;".$password_site."&nbsp;</li>
										<li>Mot de passe sur le serveur WoW: &nbsp;".$password_mangos."&nbsp;</li>
										<li>Commentaire: ".nl2br(stripslashes(htmlspecialchars($comment)))."</li>
										<li>Realmlist: set realmlist wow.evoxis.info</li> 			
									</ul>
									</p>
									<p>
									Si vous le souhaitez, afin de mieux vous imprégner de l'univers d'Evoxis vous pouvez faire la demande d'un mentor qui sera là pour répondre à vos questions et vous guidez. Parcourez le forum suivant: Forum › Echanges Joueurs / MJs  › Dialogues (Tag Mentor)
									</p>
									<p>
									Nous vous rappelons: Tous les personnages de votre compte, d'un level supérieur ou égal à 10 doivent impérativement posséder un background validé par l'équipe MJ RP.
									</p>
									<p>
									Merci de nous avoir fait confiance. Cordialement, l'équipe d'Evoxis.
									</p>
									</html>";
							            
					mail($email, $sujet ,$contenu, $email_entete); 
							
					$msg = message::getInstance('SUCCESS','Inscription acceptée', 'index.php?comp=insevo');
				}
				else{				
					$query = "DELETE FROM `account` WHERE username=".mysql_real_escape_string($login)."";
					$r1 = $db_realmd->Send_Query($query);
										
					$msg = message::getInstance('ERROR','Impossible de valider cette inscription', 'index.php?comp=insevoFocus&select='.$id_insevo);
				}
			}
			else{
			
				$query = "UPDATE exo_insevo SET comment='', state='WAIT', time_validation='' WHERE insevo_id = '$id_insevo'";
				$update_insevo = $db->Send_Query($query);
			
				$query = "DELETE FROM exo_users WHERE username=".mysql_real_escape_string($login)."";
				$r1 = $db->Send_Query($query);
						
				$query = "DELETE FROM exo_groups_users WHERE uid=".intval($id)."";
				$r2 = $db->Send_Query($query);
									
				$query = "DELETE FROM exo_indices WHERE uid=".intval($id)."";
				$r3 = $db->Send_Query($query);
							
				$msg = message::getInstance('ERROR','Impossible de valider cette inscription', 'index.php?comp=insevoFocus&select='.$id_insevo);
			}

		}
		else{
			//Mail
			$sujet="[EVOXIS] Inscription refusé";
			$contenu=
							"
							<html>
							<p>
							Bonjour,
							</p><p>
							Vous avez fait la demande de création d'un compte sur EVOXIS. Votre demande d'inscription sur EVOXIS vient d'être refusé par un de nos MJs.
							</p>
							<p>
							<ul>
								<li>Date de refus: ".date("d/m/y")."</li>
								<li>Login: ".$login."</li>
								<li>Motivation: ".nl2br(stripslashes(htmlspecialchars($motivation)))."</li>
								<li>Commentaire: ".nl2br(stripslashes(htmlspecialchars($comment)))."</li>			
							</ul>
							</p>
							<p>
							Merci de bien vouloir renouveller votre demande en prenant en compte les remarques. Cordialement, l'équipe d'Evoxis.
							</p>
							</html>";
					            
						mail($email, $sujet ,$contenu, $email_entete);  
			
			$msg = message::getInstance('WARNING','Inscription refusée', 'index.php?comp=insevo');	
		}
	}
	else{		
		$msg = message::getInstance('ERROR','Impossible de valider cette inscription', 'index.php?comp=insevoFocus&select='.$id_insevo);
	}
}
else{

	$select = intval($_GET['select']);

	$query = "
			SELECT insevo_id,login, email, motivation, parrain, time_creation, time_validation, state, comment, ip
			FROM exo_insevo
			WHERE insevo_id = '$select'";
	$result = $db->Send_Query($query);
	$rs = $db->get_array($result);
	
	//Sécurité Inscription
	$query = "	SELECT insevo_id, login, email, time_creation, state, ip
			FROM exo_insevo
			WHERE (ip = '".mysql_real_escape_string($rs['ip'])."'
			OR email = '".mysql_real_escape_string($rs['email'])."'
			OR login = '".mysql_real_escape_string($rs['login'])."')
			AND insevo_id != '".intval($rs['insevo_id'])."'
			ORDER BY login";
	$result = $db->Send_Query($query);
	$secuInsevoIP = $db->loadObjectList($result);
	
	$list_secuInsevoIP = '<table class="mainTab"><thead><th>Login</th><th>Email</th><th>Date Création</th><th>Etat</th><th>ip</th></thead><tbody>';
	if(!empty($secuInsevoIP)){
		foreach ($secuInsevoIP as $o){
			$list_secuInsevoIP .= "<tr>";
			if($o->login==$rs['login']){
				$list_secuInsevoIP .= '<td style="background-color: green;"><a href="./index.php?comp=insevoFocus&select='.$o->insevo_id.'">'.htmlspecialchars(stripslashes($o->login)).'</a></td>';
			}
			else{$list_secuInsevoIP .= '<td><a href="./index.php?comp=insevoFocus&select='.$o->insevo_id.'">'.htmlspecialchars(stripslashes($o->login)).'</a></td>';}
			
			if($o->email==$rs['email']){
				$list_secuInsevoIP .= '<td style="background-color: green;">'.htmlspecialchars(stripslashes($o->email)).'</td>';
			}
			else{$list_secuInsevoIP .= '<td>'.htmlspecialchars(stripslashes($o->email)).'</td>';}
						
			$list_secuInsevoIP .= '<td>'.format_time($o->time_creation).'</td>';
			$list_secuInsevoIP .= '<td>'.$o->state.'</td>';
			
			if($o->ip==$rs['ip']){
				$list_secuInsevoIP .= '<td style="background-color: green;">'.htmlspecialchars(stripslashes($o->ip)).'</td>';
			}
			else{$list_secuInsevoIP .= '<td>'.htmlspecialchars(stripslashes($o->ip)).'</td>';}
			$list_secuInsevoIP .= "</tr>";
		}
	}
	else{
		$list_secuInsevoIP .= '<tr><td colspan="5"><center>Aucune occurence trouvée dans les inscriptions</center></td></tr>';
	}
	$list_secuInsevoIP .= '</tbody></table>';
	
	//Sécurité Double Compte
	$query = "	SELECT uid, username, email, pseudo, last_date_connect, last_ip
			FROM exo_users
			WHERE last_ip = '".mysql_real_escape_string($rs['ip'])."'
			OR email = '".mysql_real_escape_string($rs['email'])."'
			OR username = '".mysql_real_escape_string($rs['login'])."'
			OR pseudo = '".mysql_real_escape_string($rs['login'])."'
			ORDER BY username";
	$result = $db->Send_Query($query);
	$secuUsersIP = $db->loadObjectList($result);
	
	$list_secuUsersIP = '<table class="mainTab"><thead><th>Login</th><th>Email</th><th>Pseudo</th><th>Dernière connexion</th><th>Dernière IP</th></thead><tbody>';
	if(!empty($secuUsersIP)){
		foreach ($secuUsersIP as $o){
			$list_secuUsersIP .= "<tr>";
			if($o->username==$rs['login']){
				$list_secuUsersIP .= '<td style="background-color: green;"><a href="./index.php?comp=usersFocus&select='.$o->uid.'">'.htmlspecialchars(stripslashes($o->username)).'</a></td>';
			}
			else{$list_secuUsersIP .= '<td><a href="./index.php?comp=usersFocus&select='.$o->uid.'">'.htmlspecialchars(stripslashes($o->username)).'</a></td>';}
			
			if($o->email==$rs['email']){
				$list_secuUsersIP .= '<td style="background-color: green;">'.htmlspecialchars(stripslashes($o->email)).'</td>';
			}
			else{$list_secuUsersIP .= '<td>'.htmlspecialchars(stripslashes($o->email)).'</td>';}
			
			if($o->pseudo==$rs['login']){
				$list_secuUsersIP .= '<td style="background-color: green;"><a href="./index.php?comp=usersFocus&select='.$o->uid.'">'.htmlspecialchars(stripslashes($o->pseudo)).'</a></td>';
			}
			else{$list_secuUsersIP .= '<td><a href="./index.php?comp=usersFocus&select='.$o->uid.'">'.htmlspecialchars(stripslashes($o->pseudo)).'</a></td>';}
						
			$list_secuUsersIP .= '<td>'.format_time($o->last_date_connect).'</td>';
			
			if($o->last_ip==$rs['ip']){
				$list_secuUsersIP .= '<td style="background-color: green;">'.htmlspecialchars(stripslashes($o->last_ip)).'</td>';
			}
			else{$list_secuUsersIP .= '<td>'.htmlspecialchars(stripslashes($o->last_ip)).'</td>';}
			$list_secuUsersIP .= "</tr>";
		}
	}
	else{
		$list_secuUsersIP .= '<tr><td colspan="5"><center>Aucune occurence trouvée dans les membres</center></td></tr>';
	}
	$list_secuUsersIP .= '</tbody></table>';
}

?>
