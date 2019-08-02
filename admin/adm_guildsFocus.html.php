<?php
defined( '_ADM_VALID_CORE_GUILDSFOCUS' ) or die( 'Restricted access' );

?>
<form class="mainForm"  action="./index.php?comp=guilds&task=process_guilds" method="post">
			<fieldset>
				<legend><?php echo htmlspecialchars(stripslashes($name)) ?></legend>
				<p>
					<label for="form_class">Leader: </label>
					<input type="text" name="form_class" maxlength="200" disabled="disabled" value="<?php echo $leader ?>"/>
				</p>				
				<p>
					<label for="form_creation">Creation: </label>
					<input type="text" name="form_creation" maxlength="200" disabled="disabled" value="<?php echo $creation_time ?>"/>
				</p>
				<p>
					<label for="form_modification">Dernière modification: </label>
					<input type="text" name="form_modification" maxlength="200" disabled="disabled" value="<?php echo $last_edit_time ?>"/>
				</p>
				<p>
					<label for="form_statut">Statut: </label>
					<input type="text" name="form_statut" maxlength="200" disabled="disabled" value="<?php echo $statut ?>"/>
				</p>				
				<p>
					<label for="form_persos">Membres: </label>
					<input type="text" name="form_persos" maxlength="200" disabled="disabled" value="<?php echo htmlspecialchars(stripslashes($membres)) ?>"/>
				</p>
			</fieldset>
			<fieldset>
				<legend>Histoire</legend>
				<p style="background-color: #CCC;">
					<?php echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($background)))) ?>
				</p>
			</fieldset>		
			<fieldset>
				<legend>Objectifs</legend>
				<p style="background-color: #CCC;">
					<?php echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($goals)))) ?>
				</p>
			</fieldset>		
			<fieldset>
				<legend>Règlement</legend>
				<p style="background-color: #CCC;">
					<?php echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($rules)))) ?>
				</p>
			</fieldset>		
			<fieldset>
				<legend>Quartier Général</legend>
				<p style="background-color: #CCC;">
					<?php echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($hall)))) ?>
				</p>
			</fieldset>		
			<fieldset>
				<legend>Hiérarchie</legend>
				<p style="background-color: #CCC;">
					<?php echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($hierarchy)))) ?>
				</p>
			</fieldset>		
			<fieldset>
				<legend>Personnages acceptés</legend>
				<p style="background-color: #CCC;">
					<?php echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($accepted)))) ?>
				</p>
			</fieldset>		
			<fieldset>
				<legend>Action</legend>
				<p>
					<label for="form_bg">Commentaire:</label>
					<textarea name="comment" id="comment" rows="10" cols="50"></textarea>
				</p>				
				<p>
					<label for="form_valid">Refusé:</label>
					<input type="radio" name="result" value="NON_VALIDE">
				</p>
				<p>
					<label for="form_valid">Accepté:</label>
					<input type="radio" name="result" value="VALIDE">
				</p>
			</fieldset>		
			<input type="hidden" name="guildid" value="<?php echo $guildid  ?>">
			<p>
				<input class="ok" type="submit" name="Submit" value="OK" /><input class="ok" type="button" name="Retour" value="Retour" onclick="history.go(-1)"/>
			</p>
		</form>
