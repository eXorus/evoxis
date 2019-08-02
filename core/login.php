<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_LOGIN', 1 );

if ((!empty($_POST['connect_username']) && !empty($_POST['connect_pass'])) || (!empty($_COOKIE['autoU']) && !empty($_COOKIE['autoM']) && $_SESSION['connected']!=TRUE)) {
	
	if(!empty($_POST['connect_username']) && !empty($_POST['connect_pass'])){
		//Pas connecté & on demande une connexion
		$connect_username = mysql_real_escape_string(trim($_POST['connect_username']));
		$connect_pass = hash('sha512',trim($_POST['connect_pass']));
	}
	elseif(!empty($_COOKIE['autoU']) && !empty($_COOKIE['autoM']) && $_SESSION['connected']!=TRUE){
		//Pas connecté & connexion auto
		$connect_username = mysql_real_escape_string(trim($_COOKIE['autoU']));
		$connect_pass = mysql_real_escape_string(trim($_COOKIE['autoM']));
	}
	else{
		$connect_username = 0;
		$connect_pass = 0;
	}

	$rq = $db->Send_Query("
		SELECT u.uid, u.wow_id, u.username, u.email, u.pseudo, t.link, u.lu_date_forum, u.lu_date_bugtracker, ep.id, ep.image_extension
		FROM exo_users u
		LEFT JOIN exo_templates t ON u.template=t.tid
		LEFT JOIN exo_pictures ep ON (ep.uid = u.uid AND ep.type=1 AND ep.selected=1)
		WHERE u.password='".$connect_pass."' AND u.username = '".$connect_username."'");
	
	if ($db->num_rows($rq)==1){

		$result = $db->get_array($rq);
	
		$_SESSION['uid'] = $result['uid'];
		//Chargement des droits
		$secureObject = security::getInstance();
		$secureObject->loadAuthorizations();
		
		if($secureObject->verifyAuthorization('FO_LOGIN')==TRUE){
			$_SESSION['wow_id'] = $result['wow_id'];
			$_SESSION['username'] = $result['username'];
			$_SESSION['email'] = $result['email'];
			$_SESSION['pseudo'] = $result['pseudo'];
			$_SESSION['link'] = $result['link'];
			$_SESSION['lu_date_forum'] = $result['lu_date_forum'];
			$_SESSION['lu_date_bugtracker'] = $result['lu_date_bugtracker'];
			$_SESSION['avatar_path'] = $result['id'].'_tb.'.$result['image_extension'];
			$_SESSION['connected']=TRUE;
			
			
			//update derniere connexion			
			$db->Send_Query("UPDATE exo_users SET last_date_connect='".time()."', last_ip='".realip()."' WHERE uid='".intval($_SESSION['uid'])."'");
			
			//Whoisonline			
			$db->Send_Query("DELETE FROM exo_whoisonline WHERE online_ip = '".ip2long($_SERVER['REMOTE_ADDR'])."'");
			$db->Send_Query("INSERT INTO exo_whoisonline (online_id, online_time, online_ip) 
			VALUES ('".intval($_SESSION['uid'])."', '".time()."', '".ip2long($_SERVER['REMOTE_ADDR'])."')");
			
			//Spyvo
			$spyvo->spyvo_write('INFO', $_SESSION['uid'], 'CONNECT', 'Connexion OK;'.realip().';'.$_SERVER["HTTP_USER_AGENT"]);
			
			//Auto
			if($_POST['auto']=="on"){
				$expire = time() + 365*24*3600;
				setcookie('autoU', $_SESSION['username'], $expire);
				setcookie('autoM', $connect_pass, $expire);
			}
						
			$msg = message::getInstance('SUCCESS','Connexion réussie', 'index.php?comp=notifications');
		}
		else{
			$msg = message::getInstance('ERROR','Connexion impossible: Vous avez été banni', 'index.php');
		}
		


	}
	else{
		
		//Spyvo
		$spyvo->spyvo_write('WARNING', $connect_username, 'CONNECT', 'Connexion KO;'.realip().';'.$_SERVER["HTTP_USER_AGENT"]);
		
		$msg = message::getInstance('ERROR','Connexion impossible: vos identifiants sont incorrects.', 'index.php');
	}	
}
?>
