<?php
defined( '_VALID_CORE_GUILDS_BG_WRITE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>

<div id="blockFormulaire">
	<form method="post" action="index.php?comp=guilds_bg_write&amp;action=process&amp;select=<?php echo $guilds['guildid']?>">
	
	<?php
		if ($background_erreur!='' || $hierarchy_erreur!='' || $goals_erreur!=''){
			echo '<fieldset id="blockFormulaireError"><ul>';
			echo $background_erreur;
			echo $hierarchy_erreur;
			echo $goals_erreur;
			echo '</ul></fieldset>';
		}
	?>
	<fieldset>
	<h1>Informations</h1><h4> &nbsp</h4><br />

	<label>Nom :</label><?php echo $guilds['leader'] ?><br />
	<label>Nom de la Guilde :</label><?php echo $guilds['name'] ?><br />
	<label>Date de création :</label><?php echo $guilds['creation_time'] ?><br />
	<label>Dernière modification :</label><?php if($guilds['last_edit_time']!=NULL){echo $guilds['last_edit_time'];} else{echo "-";} ?><br />
	<label for="statut">Statut :</label><?php echo $guilds['statut'] ?><br />		

	
	<h1>Modifiez votre Guilde</h1><h4> &nbsp</h4><br />

	<label for="background">Histoire (obligatoire):</label>
	<textarea name="background" id="background" rows="10" cols="100"><?php echo stripslashes(htmlspecialchars($guilds['background'])); ?></textarea><br />

	<label for="goals">Objectifs RP de votre guilde (obligatoire):</label>
	<textarea name="goals" id="goals" rows="7" cols="100"><?php echo stripslashes(htmlspecialchars($guilds['goals'])); ?></textarea><br />

	<label for="hierarchy">Hiérarchie de votre guilde (obligatoire):</label>
	<textarea name="hierarchy" id="hierarchy" rows="5" cols="100"><?php echo stripslashes(htmlspecialchars($guilds['hierarchy'])); ?></textarea><br />
	
	<label for="rules">Règlement RP de votre guilde (facultatif):</label>
	<textarea name="rules" id="rules" rows="5" cols="100"><?php echo stripslashes(htmlspecialchars($guilds['rules'])); ?></textarea><br />
	
	<label for="hall">Quartier Général de votre guilde (facultatif):</label>
	<textarea name="hall" id="hall" rows="0" cols="100"><?php echo stripslashes(htmlspecialchars($guilds['hall'])); ?></textarea><br />
	
	<label for="accepted">Races et classes acceptées dans votre guilde (facultatif):</label>
	<textarea name="accepted" id="accepted" rows="1" cols="100"><?php echo stripslashes(htmlspecialchars($guilds['accepted'])); ?></textarea><br />
	
	<label for="membersview">Autoriser l'affichage de la liste des membres : </label>
	<input type="checkbox" name="membersview" id="membersview" <?php if($guilds['members_view']==1) echo 'checked="checked"'?> /><br />
	<i>La liste des membres de la guilde ne sera pas visible si la case est décochée.</i><br /><br />

	</fieldset>

	<br /><br /><input type="submit" value="Valider"/>
	<br />
	<a href="./index.php?comp=guilds_bg_write&amp;action=ask_validation&amp;select=<?php echo intval($guilds['guildid']) ?>">Demander la validation de la guilde (Après avoir sauvegarder en validant vos modifications)</a>
	<br />

	</form>
</div>

<?php

require_once('./templates/'.$link_style.'bottom.php');
?>