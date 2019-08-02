<?php
defined( '_VALID_CORE_PROFIL_SETTINGS_PICTURES' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>
<div id="onglets"><center><table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">
<a href="./index.php?comp=profil">Afficher mon profil</a> | <a href="./index.php?comp=profil_account">Modifier mon profil</a> | <a href="./index.php?comp=profil_settings"><b>Réglages</b></a>
</td><td class="onglet_right"></td></tr></table></center></div>
<div id="blockFormulaire">
<div class="topic_top"></div>
<div class="topic_middle"><div class="newscontenu">

	<form method="post" enctype="multipart/form-data" action="index.php?comp=profil_settings_pictures&amp;task=process">
	<?php
		if (!empty($pictures_erreur)){
			echo '<fieldset id="blockFormulaireError"><ul>';
			echo $pictures_erreur;
			echo '</ul></fieldset>';
		}
	?>
<br />
<table class="tableau">
	<thead>
		<tr>
			<th width="50%">Sélectionnez une image</th>
			<th>Choisissez le type d'image</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="avatar">
				<input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
				<input name="pictures" id="pictures" type="file" size="30" />
			</td>
			<td class="profil">
				<p class="info">Selectionnez le type d'image que vous voulez uploader. Attention aux indications !!</p>	
	<?php
	
	echo '<input type="radio" name="directory" id="directory" value="1" '.$form_A.'/> 
			Avatars<br /><i>5 images Max - 100Ko Max - 100 x 150 pixels Max</i><br />';
			
	
	echo '<input type="radio" name="directory" id="directory" value="2" '.$form_P.'/>
			Photo<br /><i>1 image Max - 300Ko Max - 300 x 400 pixels Max</i><br />';
			
	echo '<input type="radio" name="directory" id="directory" value="3" '.$form_CG.'/>
			Créations Graphiques<br /><i>Illimitées - 1Mo Max - 800 x 600 pixels Max</i><br />';
			
	echo '<input type="radio" name="directory" id="directory" value="4" '.$form_AP.'/>
			Avatars Persos<br /><i>Illimitées - 100Ko Max - 100 x 150 pixels Max</i>';
	?>
			</td>
		</tr>
	</tbody>
</table>

<br /><input type="submit" value="Valider"/>
	
	</form>
</div></div></div><div class="topic_bottom"></div>

<?php
require_once('./templates/'.$link_style.'bottom.php');
?>
