<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_INSEVO
define( '_VALID_CORE_INSEVO', 1 );

if (!empty($_GET['task']) && $_GET['task']=="process"){
	
	$msg_error = '';
	
	//NEVER TRUST USER INPUT 
	$create_login = trim($_POST['create_login']);
	$create_mail = trim($_POST['create_mail']);
	$create_motivation = trim($_POST['create_motivation']);
	$create_captcha = trim($_POST['create_captcha']);
	$create_parrain = trim($_POST['create_parrain']);
	$charte = trim($_POST['charte']);
	
	//create_login
	if(empty($create_login)){
		$msg_error .= '<li>Le login est vide</li>';	
	}else{
		if(!preg_match('`^[[:alnum:]]([-_]?[[:alnum:]])*$`',$create_login)){
			$msg_error .= '<li>Le login est incorrect (caractères autorisés: [a-z],[A-Z],[1-9],-,_)</li>';			
		}
		else{
			//Vérification de son existence
			$change = $db->Send_Query("UPDATE exo_users SET pseudo=username WHERE pseudo='".mysql_real_escape_string($create_login)."'");
			$result = $db->Send_Query("SELECT COUNT(*) FROM exo_users WHERE username='".mysql_real_escape_string($create_login)."'");
			$ligne = $db->get_row($result);
			if($ligne[0]>0){
				$msg_error .= '<li>Ce login existe déjà</li>';	
			}
			else{
				$result = $db->Send_Query("SELECT COUNT(*) FROM exo_insevo WHERE login='".mysql_real_escape_string($create_login)."' AND state='WAIT'");
				$ligne = $db->get_array($result, $mode='NUMERIC');
				if($ligne[0]>0){
					$msg_error .= '<li>Ce login existe déjà</li>';	
				}
			}
		}
	}
	
	//create_mail
	if(empty($create_mail)){
		$msg_error .= '<li>Le mail est vide</li>';	
	}else{
		if(!preg_match('`^[[:alnum:]]([-_.]?[[:alnum:]])*@[[:alnum:]]([-_.]?[[:alnum:]])*\.([a-z]{2,4})$`',$create_mail)){
			$msg_error .= '<li>Le mail est incorrect</li>';			
		}
		else{
			//Vérification de son existence
			$result = $db->Send_Query("SELECT COUNT(*) FROM exo_users WHERE email='".mysql_real_escape_string($create_mail)."'");
			$ligne = $db->get_row($result);
			if($ligne[0]>0){
				$msg_error .= '<li>Ce mail existe déjà</li>';	
			}
			else{
				$result = $db->Send_Query("SELECT COUNT(*) FROM exo_insevo WHERE email='".mysql_real_escape_string($create_mail)."' AND state='WAIT'");
				$ligne = $db->get_row($result);
				if($ligne[0]>0){
					$msg_error .= '<li>Ce mail existe déjà</li>';	
				}
			}
		}
	}
	
	//create_motivation
	if(empty($create_motivation)){
		$msg_error .= '<li>Le motivation est vide</li>';
	}
	
	//create_captcha
	if(empty($create_captcha)){
		$msg_error .= '<li>Le captcha est vide</li>';
	
	}else{
		if($create_captcha!=$_SESSION['code']) { 
			$msg_error .= '<li>Le captcha est incorrect</li>';		
		}
	}
	
	//create_parrain
	if(!empty($create_parrain)){
	
		$result = $db->Send_Query("SELECT COUNT(*) FROM exo_users WHERE username='".mysql_real_escape_string($create_parrain)."'");
		$ligne = $db->get_row($result);
		if($ligne[0]!=1){
			$msg_error .= '<li>Votre parrain n\'existe pas</li>';						
		}
	}
	
	//charte
	if(empty($charte) || $charte!="ok"){
		$msg_error .= '<li>Vous devez accepter la charte d\'Evoxis</li>';
	}
	
	if (!empty($msg_error)){
	
		//Mise en cache des data
		$_SESSION['create_login'] = $create_login;
		$_SESSION['create_mail'] = $create_mail;
		$_SESSION['create_motivation'] = $create_motivation;
		$_SESSION['create_parrain'] = $create_parrain;
		$_SESSION['charte'] = $charte;
			
	}
	else{
	
		$create_login = mysql_real_escape_string($create_login);
		$create_mail = mysql_real_escape_string($create_mail);
		$create_motivation = mysql_real_escape_string($create_motivation);
		$create_parrain = mysql_real_escape_string($create_parrain);
	
		$query = "
			INSERT INTO exo_insevo (insevo_id, login, email, motivation, parrain, time_creation, time_validation, state, comment, ip) 
			VALUES (NULL,'".$create_login."','".$create_mail."','".$create_motivation."','".$create_parrain."','".time()."', 0,'WAIT','','".realip()."')";
		$db->Send_Query($query);
		
		//Suppression du cache des data
		unset($_SESSION['create_login']);
		unset($_SESSION['create_mail']);
		unset($_SESSION['create_motivation']);
		unset($_SESSION['create_parrain']);
		unset($_SESSION['charte']);
		
		//Mail
		$sujet="[EVOXIS] Demande de création de compte";
		$contenu=
		"
		<html>
		<p>
		Bonjour,
		</p><p>
		Vous avez effectué une demande de compte sur EVOXIS. Nous vous en remercions. Votre demande va être traitée dans les plus brefs délais. Pour suivre l'avancement de votre inscription, veuillez cliquer sur le lien ci-dessous :
		</p><p>
		<a href=\"".$ws_domain."index.php?comp=insevo_attente\">".$ws_domain."index.php?comp=insevo_attente</a>
		</p><p>
		Cordialement,
		L'équipe d'Evoxis.
		</p>
		</html>";
            
		mail($create_mail, $sujet ,$contenu, $email_entete);   
		
		//Spyvo
		$spyvo->spyvo_write('INFO', 0, 'INSEVO', 'Demande Insevo;'.realip().';'.$_SERVER["HTTP_USER_AGENT"]);
			
		$msg = message::getInstance('SUCCESS','Inscription réussie', 'index.php?comp=insevo&amp;task=message');		
	}
	
	
}
/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'inscription';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Inscription' => ''
);
$ws_name_perso = 'Evoxis v5 - Inscription';
?>