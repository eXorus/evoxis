<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_USERSFOCUS', 1 );
$tabGmLevel = array("Membre (0)", "Rôliste (1)", "MJ (3)", "MJ (4)", "MJ (5)", "MJ (6)");

$select = intval($_GET['select']);
$_SESSION['BoxStateMsg'] = array() ;

if(!empty($select)){

	if(!empty($_GET['task']) && $_GET['task']=='changepwd' && $secureObject->verifyAuthorization('BO_USERS_PWDCHANGE')==TRUE){
		$query = "SELECT uid, wow_id, username, email
				FROM exo_users
				WHERE uid='$select'";
		$result = $db->Send_Query($query);
		$user_view = $db->get_array($result);
		
		//Change PWD Site
		$password_site = randomString( 9, 'abcdefghjkmnpqrstuvwxyz123456789ABCDEFGHJKMNPQRSTUVWXYZ' );
		$password_site_secure = hash('sha512',$password_site);
		$q_mdp1 = "UPDATE exo_users SET password='$password_site_secure' WHERE uid='$select'";
		$r_mdp1 = $db->Send_Query($q_mdp1);
		
		
		//Change PWD Mangos
		$password_mangos = randomString( 9, 'abcdefghjkmnpqrstuvwxyz123456789ABCDEFGHJKMNPQRSTUVWXYZ' );
		$q_mdp2 = "UPDATE account SET sha_pass_hash=SHA1(CONCAT(UPPER(`username`),':',UPPER('$password_mangos'))) WHERE id='".$user_view['wow_id']."'";
		$r_mdp2 = $db_realmd->Send_Query($q_mdp2);
		
		//Mail
		$sujet="[EVOXIS] Nouveaux Mots de passe";
		$contenu=
						"
						<html>
						<p>
						Bonjour,
						</p><p>
						Vous avez fait la demande de nouveaux mots de passe assignée à votre compte sur EVOXIS. Je vous rappel que votre login est ".htmlspecialchars(stripslashes($user_view['username'])).". Les voici:
						</p>
						<p>
						<ul>
							<li>Sur www.evoxis.info: ".$password_site."</li>
							<li>Sur WoW: ".$password_mangos."</li>	
						</ul>
						</p>
						<p>
						Cordialement, l'équipe d'Evoxis.
						</p>
						</html>";
												
		mail($user_view['email'], $sujet ,$contenu, $email_entete); 
		
		$msg = message::getInstance('SUCCESS','Mail envoyé avec les nouveaux mots de passe', 'index.php?comp=usersFocus&select='.$select);
	}
	else if(!empty($_GET['task']) && $_GET['task']=='addWall' && $secureObject->verifyAuthorization('BO_USERS_ADDWALL')==TRUE){
		addWall($_POST['cat'], $select, $_POST['message']);
		$msg = message::getInstance('SUCCESS','Wall mis à jour', 'index.php?comp=usersFocus&select='.$select);
	}
	elseif (!empty($_GET['task']) && $_GET['task']=='ban' && !empty($_GET['wowid']) && !empty($_GET['select']) 
	&& ($_POST['form_time']==0 || $_POST['form_time']==2592000 || $_POST['form_time']==604800 || $_POST['form_time']==259200 ) && !empty($_POST['form_banreason']) && $secureObject->verifyAuthorization('BO_USERS_BAN')==TRUE){
	
		$q = "INSERT INTO `account_banned` ( `id` , `bandate` , `unbandate` , `bannedby` , `banreason` , `active` ) VALUES 
			('".intval($_GET['wowid'])."', '".time()."', '".(time() + intval($_POST['form_time']))."', '".$_SESSION['admin_username']."', '".mysql_real_escape_string($_POST['form_banreason'])."', '1')";
		$r = $db_realmd->Send_Query($q);
		
		$q = "DELETE FROM exo_groups_users WHERE uid='".intval($_GET['select'])."'";
		$r = $db->Send_Query($q);
		
		if($_POST['form_time']==0){
			$q = "INSERT INTO exo_groups_users (gid, uid) VALUES (12,'".intval($_GET['select'])."')";
			$r = $db->Send_Query($q);
		}
		else{

			$q = "INSERT INTO exo_groups_users (gid, uid) VALUES (13,'".intval($_GET['select'])."')";
			$r = $db->Send_Query($q);
		}
		addWall("Auto: Ban", $_GET['select'], $_POST['form_banreason']);
		
		$msg = message::getInstance('SUCCESS','Compte Banni', 'index.php?comp=usersFocus&select='.$select);
	}
	elseif (!empty($_GET['task']) && $_GET['task']=='unban' && !empty($_GET['wowid']) && !empty($_GET['select']) 
				&& !empty($_POST['form_banreason']) && ($_POST['form_type']==1 || $_POST['form_type']==2) && $secureObject->verifyAuthorization('BO_USERS_BAN')==TRUE){
		
		if ($_POST['form_type']==1){
			$q = "DELETE FROM `account_banned` WHERE id='".intval($_GET['wowid'])."'";
			$r = $db_realmd->Send_Query($q);
			
			$q = "DELETE FROM exo_groups_users WHERE uid='".intval($_GET['select'])."'";
			$r = $db->Send_Query($q);
			$q = "INSERT INTO exo_groups_users (gid, uid) VALUES (11,'".intval($_GET['select'])."')";
			$r = $db->Send_Query($q);
		}
		else if ($_POST['form_type']==2){
			$q = "DELETE FROM `account_banned` WHERE id='".intval($_GET['wowid'])."'";
			$r = $db_realmd->Send_Query($q);			
			
			$q = "DELETE FROM exo_groups_users WHERE uid='".intval($_GET['select'])."'";
			$r = $db->Send_Query($q);
			$q = "INSERT INTO exo_groups_users (gid, uid) VALUES (11,'".intval($_GET['select'])."')";
			$r = $db->Send_Query($q);
		}
		
		addWall("Auto: Déban", $_GET['select'], $_POST['form_banreason']);
		
		$msg = message::getInstance('SUCCESS','Compte Débanni', 'index.php?comp=usersFocus&select='.$select);
	}


	$query = "	SELECT u.uid, u.wow_id, u.username, u.pseudo, u.email, g.name as groupName, u.last_ip as ips, a.last_ip as ipw, 
						joindate, last_login, last_date_connect, gmlevel, i.total, i.avertissements, ab.id, gu.gid
				FROM exo_users u 
				LEFT JOIN exo_groups_users gu ON gu.uid=u.uid
				LEFT JOIN exo_groups g ON g.gid=gu.gid
				LEFT JOIN $db_name_realmd.account a ON a.id = u.wow_id
				LEFT JOIN exo_indices i ON i.uid = u.uid
				LEFT JOIN $db_name_realmd.account_banned ab ON ab.id = u.wow_id
				WHERE u.uid='$select'";
		$result = $db->Send_Query($query);
		$user_view = $db->get_array($result);
		
		$_SESSION['BoxStateType'] = "Green";
		array_push ($_SESSION['BoxStateMsg'], "Chargement du compte ".$user_view['username']);
		
		//gmlevel
		$gmlevel = $tabGmLevel[$user_view['gmlevel']];
		
		//WALL
		$rq = $db->Send_Query("
			SELECT wid, wCat, wDate, u.username, wOn, wMessage
			FROM exo_wall
			LEFT JOIN exo_users u ON u.uid = wAuthor
			WHERE wOn = '$select'
			ORDER BY wDate DESC");
		$walls = $db->loadObjectList($rq);
		$_SESSION['BoxStateType'] = "Green";
		array_push ($_SESSION['BoxStateMsg'], "Chargement du wall");
}
else{
	$msg = message::getInstance('ERROR','Impossible de charger le profil', 'index.php?comp=users');
}

$TitlePage = 'Comptes';
?>
