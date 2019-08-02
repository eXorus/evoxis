<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_LOGIN', 1 );


if (!empty($_POST['connect_username']) || !empty($_POST['connect_pass'])) {

	//Pas connecté & on demande une connexion
	$connect_username = mysql_real_escape_string($_POST['connect_username']);
	$connect_pass = hash('sha512',$_POST['connect_pass']);

	$rq = $db->Send_Query("
		SELECT u.uid,u.username,u.email
		FROM exo_users u
		WHERE u.password='".$connect_pass."' AND u.username = '".$connect_username."'");
			
				
	if ($db->num_rows($rq)==1){

		$result = $db->get_array($rq);
	
		$_SESSION['admin_uid'] = $result['uid'];
		//Chargement des droits
		$_SESSION['uid'] = $result['uid'];
		$secureObject = security::getInstance();
		$secureObject->loadAuthorizations();
		$secureObject->loadAccessLevel();
		
		if($secureObject->verifyAuthorization('BO_LOGIN')==TRUE){
			$_SESSION['admin_username'] = $result['username'];
			$_SESSION['admin_email'] = $result['email'];
			$_SESSION['admin_timestamp']=time();
			$_SESSION['admin_ip']=realip();
			$_SESSION['admin_connected']=TRUE;
					
			$msg = message::getInstance('SUCCESS','Connexion réussie', 'index.php?comp=main');
		}
		else{
			$msg = message::getInstance('ERROR','Droits insuffisants', 'index.php?comp=login');
		}
	}
	else{
		$msg = message::getInstance('ERROR','Connexion impossible', 'index.php?comp=login');
	}	
}

?>