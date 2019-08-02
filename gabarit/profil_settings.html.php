<?php
defined( '_VALID_CORE_PROFIL_SETTINGS' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>
<div id="onglets"><center><table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">
<a href="./index.php?comp=profil">Afficher mon profil</a> | <a href="./index.php?comp=profil_account">Modifier mon profil</a> | <a href="./index.php?comp=profil_settings"><b>Réglages</b></a>
</td><td class="onglet_right"></td></tr></table></center></div>
<div id="blockFormulaire">
<div class="topic_top"></div>
<div class="topic_middle"><div class="newscontenu">

	<form method="post" action="index.php?comp=profil_settings&amp;task=process">
	
<br />
<table class="tableau">
	<thead>
		<tr>
			<th width="50%">Avatars: Mon compte</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
	<p class="info">Un avatar est une petite image qui sera affichée avec chacun de vos messages.
					<br />La case 'Utiliser l'avatar' doit être cochée pour que l'avatar soit visible dans vos messages non RP.</p>	
	<?php
	if(!empty($avatars)){
		echo '<center><table>';
		foreach($avatars as $one_avatar){
			if($one_avatar->selected==0) $form_checked = '';
			elseif($one_avatar->selected==1) $form_checked = 'checked="checked"';
			echo '<tr><td class="avatar"><img src="./img/pictures/'.$one_avatar->id.'.'.$one_avatar->image_extension.'" alt="Avatar"/><br />
						</td>';
			echo '<td class="profil">
			<input type="radio" name="avatars" id="avatars" value="'.$one_avatar->id.'" '.$form_checked.'/>Utiliser l\'avatar<br />
			
					</td>
					<td class="avatar">
			<a href="index.php?comp=profil_settings_pictures&amp;action=delete&amp;select='.$one_avatar->id.'">[ Supprimer ]</a>
			</td></tr>';		
		}
		echo '</table></center>';	
	}
	else{
		echo "<center>Aucun avatar pour le moment</center>";
	}
	echo '<div align="right">Espace utilisé : '.$count_A*20 .'%<br />
	<p><a href="index.php?comp=profil_settings_pictures&amp;select=1">[ Télécharger une image ]</a></p>
	</div>';
	?>	
			</td>
		</tr>
	</tbody>
</table>

<table class="tableau">
	<thead>
		<tr>
			<th width="50%">Avatars: Mes persos</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
	<p class="info">Un avatar est une petite image qui sera affichée avec chacun de vos messages.
					<br />Vous pouvez choisir un avatar différent pour chacun de vos personnages.
					<br />La case 'Utiliser l'avatar' doit être cochée pour que l'avatar soit visible dans vos messages RP.</p>	
	<?php
	if(!empty($avatarsPersos)){
		echo '<center><table>';
		
		foreach($avatarsPersos as $one_ap){
			
			echo '<tr><td class="avatar"><img src="./img/pictures/'.$one_ap->id.'.'.$one_ap->image_extension.'" alt="Avatar"/><br />
						</td>';
			
			
			echo '<td class="profil"><select name="imgID_'.$one_ap->id.'"><option value="0">Ne pas utiliser</option>';
			
			foreach($listPersos as $lp){
				$checkP = ($one_ap->guid == $lp->guid) ? ' selected="selected"' : '' ;
				echo '<option value="'.$lp->guid.'"'.$checkP.'>'.$lp->name.'</option>';
			}
			echo '
					</select></td>
					<td class="avatar">
			<a href="index.php?comp=profil_settings_pictures&amp;action=delete&amp;select='.$one_ap->imgID.'">[ Supprimer ]</a>
			</td></tr>';		
		}
		echo '</table></center>';	
	}
	else{
		echo "<center>Aucun avatar pour le moment</center>";
	}
	echo '<div align="right">Espace utilisé : '.$count_AP*10 .'%<br />
	<p><a href="index.php?comp=profil_settings_pictures&amp;select=4">[ Télécharger une image ]</a></p>
	</div>';
	?>	
			</td>
		</tr>
	</tbody>
</table>

<table class="tableau">
	<thead>
		<tr>
			<th width="50%">Photos</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
<p class="info">Une photo de vous, tout simplement. Elle sera ensuite visible par les autres utilisateurs via le trombinoscope.</p><br />
	<?php
	if(!empty($link_photo)){
		echo '<center>'.$link_photo.'<br />
		<a href="index.php?comp=profil_settings_pictures&amp;action=delete&amp;select='.$profil_photo['id'].'">[ Supprimer ]</a></center>';		
	}
	else{
		echo "<center>Aucune photo pour le moment</center>";
	}
	echo '<div align="right">Espace utilisé : '.$count_P*100 .'%<br /><a href="index.php?comp=profil_settings_pictures&amp;select=2">[ Télécharger une image ]</a></div>';
	?>	
	
			</td>
		</tr>
	</tbody>
</table>

<table class="tableau">
	<thead>
		<tr>
			<th width="50%">Créations graphiques</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
	<p class="info">Vous pouvez télécharger autant de dessins que vous le souhaitez en cliquant sur le lien ci-dessous. Vos dessins et creations graphiques seront ensuite visibles par les autres utilisateurs via la galerie.</p>	
	<?php echo '<div align="right">Nombres de Créations Graphiques : '.$count_CG .'<br /><a href="index.php?comp=profil_settings_pictures&amp;select=3">[ Télécharger une image ]</a></div>'; ?>
			</td>
		</tr>
	</tbody>
</table>

<table class="tableau">
	<thead>
		<tr>
			<th width="50%">Signature</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
	<p class="info">Une signature est un petit texte ajouté à la suite de vos messages. Vous pouvez y mettre ce que vous voulez. </p>
	<textarea class="profiltext" name="signature" id="signature" rows="2" cols="50"><?php echo $form_signature ?></textarea>

			</td>
		</tr>
	</tbody>
</table>

<table class="tableau">
	<thead>
		<tr>
			<th width="50%">Présentation</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
	<p class="info">Dans une communauté il est bon de se présenter, donc venez le faire ici.</p>
	<textarea class="profiltext" name="presentation" id="presentation" rows="10" cols="50"><?php echo $form_presentation; ?></textarea>

			</td>
		</tr>
	</tbody>
</table>


<input type="submit" value="Valider"/><br /><br />
	
	</form>
</div></div></div><div class="topic_bottom"></div>

<?php
require_once('./templates/'.$link_style.'bottom.php');
?>
