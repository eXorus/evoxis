<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_PROFIL_PWD
define( '_VALID_CORE_PROFIL_PWD', 1 );

//Formulaire envoyé
if(!empty($_GET['task']) && $_GET['task']=="process"){

	//Génération du fichier d'erreurs
	$msg_error_ws = '';
	$msg_error_wow = '';
	
	
	//Gestion du mot de passe du site
	if(!empty($_POST['old_pwd_ws']) && !empty($_POST['new_pwd_ws']) && !empty($_POST['confirm_pwd_ws'])){
		//Je veux changer le mot de passe du site
		if($_POST['new_pwd_ws'] == $_POST['confirm_pwd_ws']){
		
			//NEVER TRUST USER INPUT !!	
			$old_pwd_ws = hash('sha512',trim($_POST['old_pwd_ws']));
			$new_pwd_ws = hash('sha512',trim($_POST['new_pwd_ws']));
			
			$rq = $db->Send_Query("
			SELECT uid
			FROM exo_users 
			WHERE password='".$old_pwd_ws."' AND uid = '".$_SESSION['uid']."'");
			
			if ($db->num_rows($rq)==1){
			
				$rq_realmd = $db_realmd->Send_Query("
					SELECT id
					FROM account 
					WHERE sha_pass_hash=SHA1(CONCAT(UPPER(`username`),':',UPPER('".$_POST['new_pwd_ws']."'))) AND id = '".$_SESSION['wow_id']."'");
					
			
				if ($db_realmd->num_rows($rq_realmd)==0){
				
					if(
						strlen($_POST['new_pwd_ws'])>7 &&
						ereg("[a-z]+",$_POST['new_pwd_ws']) &&
						ereg("[A-Z]+",$_POST['new_pwd_ws']) &&
						ereg("[1-9]+",$_POST['new_pwd_ws'])
					){
						//Query
						$rq = $db->Send_Query("
						UPDATE exo_users 
						SET 	password='$new_pwd_ws'
						WHERE uid='".$_SESSION['uid']."'");
						
						$msg = message::getInstance('SUCCESS','Mot de passe du site mis à jour', 'index.php?comp=profil');
					}
					else{
						$msg_error_ws .= '<li>Le mot de passe doit respecter les règles ci-dessous</li>';
					}
				
				}
				else{
					$msg_error_ws .= '<li>Le mot de passe de WoW, doit être différent du mot de passe du site</li>';
				}	
			}
			else{
				$msg_error_ws .= '<li>Ancien mot de passe incorrect.</li>';
			}			
		}
		else{
			$msg_error_ws .= '<li>Les mots de passe ne correspondent pas</li>';
		}
	}
	
	//Gestion du mot de passe de wow
	if(!empty($_POST['old_pwd_wow']) && !empty($_POST['new_pwd_wow']) && !empty($_POST['confirm_pwd_wow'])){
		//Je veux changer le mot de passe de wow
		if($_POST['new_pwd_wow'] == $_POST['confirm_pwd_wow']){
		
			//NEVER TRUST USER INPUT !!	
			$old_pwd_wow = mysql_real_escape_string(trim($_POST['old_pwd_wow']));
			$new_pwd_wow = mysql_real_escape_string(trim($_POST['new_pwd_wow']));
			
			$rq_realmd = $db_realmd->Send_Query("
			SELECT id
			FROM account 
			WHERE sha_pass_hash=SHA1(CONCAT(UPPER(`username`),':',UPPER('".$_POST['old_pwd_wow']."'))) AND id = '".$_SESSION['wow_id']."'");
			
			
			if ($db_realmd->num_rows($rq_realmd)==1){				
			
				$rq = $db->Send_Query("
				SELECT uid
				FROM exo_users 
				WHERE password='".hash('sha512',trim($_POST['new_pwd_wow']))."' AND uid = '".$_SESSION['uid']."'");
			
				if ($db->num_rows($rq)==0){
				
					if(
						strlen($_POST['new_pwd_wow'])>7 &&
						strlen($_POST['new_pwd_wow'])<16 &&
						ereg("[a-z]+",$_POST['new_pwd_wow']) &&
						ereg("[A-Z]+",$_POST['new_pwd_wow']) &&
						ereg("[1-9]+",$_POST['new_pwd_wow'])
					){
						//Query
						$rq_realmd = $db_realmd->Send_Query("
						UPDATE account 
						SET 	sha_pass_hash=SHA1(CONCAT(UPPER(`username`),':',UPPER('".$_POST['new_pwd_wow']."')))
						WHERE id='".$_SESSION['wow_id']."'");
						
						$msg = message::getInstance('SUCCESS','Mot de passe de wow mis à jour', 'index.php?comp=profil');
					}
					else{
						$msg_error_wow .= '<li>Le mot de passe doit respecter les règles ci-dessous</li>';
					}
				
				}
				else{
					$msg_error_wow .= '<li>Le mot de passe de WoW, doit être différent du mot de passe du site</li>';
				}	
			}
			else{
				$msg_error_wow .= '<li>Ancien mot de passe incorrect.</li>';
			}			
		}
		else{
			$msg_error_wow .= '<li>Les mots de passe ne correspondent pas</li>';
		}
	}
	
	
}


/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'profil';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Profil' => 'index.php?comp=profil',
'Modifier mon profil' => 'index.php?comp=profil_account',
'Changement des mots de passes' => ''
);
$ws_name_perso = 'Evoxis v5 - Modifier mon profil - Changement des mots de passe';
?>