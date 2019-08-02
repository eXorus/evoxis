<?php
defined( '_VALID_CORE_PROFIL_PWD' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

?>
<div id="onglets"><center><table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">
<a href="./index.php?comp=profil">Afficher mon profil</a> | <a href="./index.php?comp=profil_account"><b>Modifier mon profil</b></a> | <a href="./index.php?comp=profil_settings">Réglages</a>
</td><td class="onglet_right"></td></tr></table></center></div>
<div class="topic_top"></div>
<div class="topic_middle"><div class="newscontenu">

<div id="blockFormulaire">
	<form method="post" action="index.php?comp=profil_pwd&amp;task=process">
<br />
<table class="tableau">
	<thead>
		<tr>
			<th>Changement de mot de passe : informations</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
	<p class="info">La sécurité du site et du serveur se faisant essentiellement sur ces deux mots de passe, nous vous recommandons de les garder secrets et de respecter les règles ci-dessous :	</p>
	<ul>
		<li>Le mot de passe Wow et le mot de passe du site doivent être différent.</li>
		<li>Un mot de passe doit comporter au moins 8 caractères.</li>
		<li>Un mot de passe doit comporter au moins une lettre en minuscule (a-z).</li>
		<li>Un mot de passe doit comporter au moins une lettre en majuscule (A-Z).</li>
		<li>Un mot de passe doit comporter au moins un chiffre (1-9).</li>
	</ul>
			</td>
		</tr>
	</tbody>
</table>
	<?php
	if (!empty($msg_error_ws) || !empty($msg_error_wow)){
		echo '<fieldset id="blockFormulaireError">';
		if(!empty($msg_error_ws)){
		echo '<strong>Site web www.evoxis.info:</strong> <br /><ul>'.$msg_error_ws.'</ul>';
		}
		if(!empty($msg_error_wow)){
			echo '<strong>World Of Warcraft:</strong> <br /><ul>'.$msg_error_wow.'</ul>';
		}
		echo '</fieldset>';
	}
	?>
<table class="tableau">
	<thead>
		<tr>
			<th width="50%" colspan="2">Site Web</th>
			<th colspan="2">World of Warcraft</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
					Ancien : 
			</td>
			<td class="profil">
<input type="password" name="old_pwd_ws" id="old_pwd_ws" size="30" maxlength="50"/>
			</td>
			<td class="profil">
					Ancien : 
			</td>
			<td class="profil">
<input type="password" name="old_pwd_wow" id="old_pwd_wow" size="30" maxlength="50"/>
			</td>
		</tr>
		<tr>
			<td class="profil">
					Nouveau : 
			</td>
			<td class="profil">
<input type="password" name="new_pwd_ws" id="new_pwd_ws" size="30" maxlength="50"/>
			</td>
			<td class="profil">
					Nouveau : 
			</td>
			<td class="profil">
<input type="password" name="new_pwd_wow" id="new_pwd_wow" size="30" maxlength="50"/>
			</td>
		</tr>
		<tr>
			<td class="profil">
					Confirmation&nbsp;: 
			</td>
			<td class="profil">
<input type="password" name="confirm_pwd_ws" id="new_pwd_ws" size="30" maxlength="50"/>
			</td>
			<td class="profil">
					Confirmation&nbsp;: 
			</td>
			<td class="profil">
<input type="password" name="confirm_pwd_wow" id="confirm_pwd_wow" size="30" maxlength="50"/>
			</td>
		</tr>
	</tbody>
</table>

<br /><input type="submit" value="Valider"/><br /><br />
	
	</form>
</div></div></div><div class="topic_bottom"></div>

<?php
require_once('./templates/'.$link_style.'bottom.php');
?>
