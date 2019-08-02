<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_PROFIL_EMAIL
define( '_VALID_CORE_PROFIL_EMAIL', 1 );

//Formulaire envoyé
if(!empty($_GET['task']) && $_GET['task']=="process"){
	
	//NEVER TRUST USER INPUT !!	
	$send_email = trim($_POST['email']);
	$send_mdp = hash('sha512',trim($_POST['mdp']));
		
	$rq = $db->Send_Query("
			SELECT uid
			FROM exo_users 
			WHERE password='".$send_mdp."' AND uid = '".$_SESSION['uid']."'");
			
	if ($db->num_rows($rq)==1){
		$key = randomString( 8, 'abcdefghjkmnpqrstuvwxyz123456789ABCDEFGHJKMNPQRSTUVWXYZ' );
		
		//Query
		$rq = $db->Send_Query("
				UPDATE exo_users 
				SET 	activate_string='$send_email',
						activate_key='$key'
				WHERE uid='".$_SESSION['uid']."'");
				
		//Mail
		$sujet="[EVOXIS] Confirmation de changement d'adresse e-mail";
		$contenu=
		"
		<html>
		<p>
		Bonjour,
		</p><p>
		Vous avez fait la demande d'avoir une nouvelle adresse email assignée à votre compte sur EVOXIS. Si vous n'en avez pas fait la demande ou ne voulez pas en changer, veuillez ignorer ce message. Votre adresse email ne sera changée que si vous visitez la page d'activation ci-dessous. Pour que la page d'activation fonctionne, vous devez être identifié sur le site.
		</p><p>
		Pour activer votre nouvelle adresse de courriel, merci de visiter la page suivante:
		<a href=\"".$ws_domain."index.php?comp=profil_email&amp;task=activate&amp;key=".$key."\">".$ws_domain."index.php?comp=profil_email&amp;task=activate&amp;key=".$key."</a>
		</p><p>
		Cordialement,
		l'équipe d'evoxis.
		</p>
		</html>";
            
		mail($send_email, $sujet ,$contenu, $email_entete);   
			
		$msg_error = 'Un email a été envoyé avec les instructions pour activer la nouvelle adresse email. Veuillez faire attention, il se peut que se mail arrive dans la boite Spam. Merci';
	}
	else{
		$msg_error = 'Ancien mot de passe incorrect.';
	}
	
		
	
}
else if(!empty($_GET['task']) && $_GET['task']=="activate"){
	$key = mysql_real_escape_string($_GET['key']);

	$rq = $db->Send_Query("
			SELECT activate_string
			FROM exo_users 
			WHERE activate_key='".$key."' AND uid = '".$_SESSION['uid']."'");
			
	if ($db->num_rows($rq)==1){
	
		$result = $db->get_array($rq);
		//Query
		$rq = $db->Send_Query("
				UPDATE exo_users 
				SET 	email='".$result['activate_string']."',
						activate_key='',
						activate_string=''
				WHERE uid='".$_SESSION['uid']."'");
		$_SESSION['email'] = $result['activate_string'];
		$msg_error = 'Votre adresse email a été mise à jour.';
	}
	else{
		$msg_error = 'Impossible d\'activer votre nouvelle adresse email.';
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
'Changement d\'adresse email' => ''
);
$ws_name_perso = 'Evoxis v5 - Modifier mon profil - Changement d\'adresse email';
?>