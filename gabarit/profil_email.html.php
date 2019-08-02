<?php
defined( '_VALID_CORE_PROFIL_EMAIL' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

?>
<div id="onglets"><center><table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">
<a href="./index.php?comp=profil">Afficher mon profil</a> | <a href="./index.php?comp=profil_account"><b>Modifier mon profil</b></a> | <a href="./index.php?comp=profil_settings">Réglages</a>
</td><td class="onglet_right"></td></tr></table></center></div>
<div id="blockFormulaire">
<div class="topic_top"></div>
<div class="topic_middle"><div class="newscontenu">

	<form method="post" action="index.php?comp=profil_email&amp;task=process">
	
	<?php
		if (!empty($msg_error)){
		 echo '<fieldset id="blockFormulaireError">';
		echo $msg_error;

			echo '</fieldset>';
		}
	?>

<br />
<table class="tableau">
	<thead>
		<tr>
			<th colspan="2">Changement d'e-mail</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
			Nouvel e-mail :
			<input type="text" name="email" id="email" size="70" maxlength="50"/>
			</td>
			<td class="profil">
			Mot de passe :
			<input type="password" name="mdp" id="mdp" size="30" maxlength="50"/>
			</td>
		</tr>
	</tbody>
</table>

<p class="info">Entrez la nouvelle adresse. Un email automatique y sera envoyé avec un lien d'activation. Vous devrez cliquer sur ce lien pour activer l'adresse.</p>
		
<br />	<input type="submit" value="Valider"/><br /><br />
	
	</form>
</div></div></div><div class="topic_bottom"></div>

<?php
require_once('./templates/'.$link_style.'bottom.php');
?>
