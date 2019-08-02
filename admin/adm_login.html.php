<?php
defined( '_ADM_VALID_CORE_LOGIN' ) or die( 'Restricted access' );


if(!empty($_SESSION['admin_connected']) && $_SESSION['connected']==TRUE){
	echo 'Bonjour '.$_SESSION['username'];
}
else{
	if(!empty($admin_login_content['msg_error'])){
		echo $admin_login_content['msg_error'];
	}
	echo '	
			<form id="boxLogin" action="index.php?comp=login" method="post">
			<fieldset>
			<legend>Login</legend>
				<p>
					<label for="connect_username">Login: </label>
					<input type="text" name="connect_username" maxlength="200" />
				</p>
				<p>
					<label for="connect_pass">Password: </label>
					<input type="password" name="connect_pass" maxlength="50" />
				</p>
				<p>
					<input class="ok" type="submit" name="Submit" value="OK" />
				</p>
			</fieldset>
			 </form>
			
			<p id="boxLoginRules">
	    - CECI EST UN SYSTEM INFORMATIQUE PRIVE -<br />
1 - L\'utilisation non-autorisee de ce systeme informatique peut entrainer des poursuites judiciaires.<br />
2 - L\'acces a ce systeme informatique incluant l\'ensemble des equipements et peripheriques associes, est fourni uniquement pour un usage autorise.<br />
3 - Les acces a ce systeme informatique doivent se faire via votre login personnel associe a votre mot de passe.<br />
4 - Si vous ne disposez pas d\'un login et d\'un mot de passe valide sur ce systeme vous devez adresser votre demande au webmaster.<br />
5 - Ce systeme informatique peut faire l\'objet d\'une surveillance a des fins legales, notamment pour faciliter la protection contre les acces non autorises et verifier l\'application des procedures de securite.<br />
6 - Pendant la surveillance, toute information stockee ou envoyee via ce systeme peut etre examinee, enregistree, copiee et employee a des fins autorisees.<br />
7 - Toutes les informations collectees durant la surveillance peuvent etre utilisees pour des besoins administratifs.<br />
8 - L\'utilisation de ce systeme constitue acceptation des presentes regles.<br />
 </p>

			';
	
}
	
?>