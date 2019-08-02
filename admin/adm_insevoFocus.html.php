<?php
defined( '_ADM_VALID_CORE_INSEVOFOCUS' ) or die( 'Restricted access' );

	
if($rs['state']=='WAIT' && $secureObject->verifyAuthorization('BO_INSEVO_VALIDATE')==TRUE){
$disabled = "";
}
else{
$disabled = "disabled=disabled";
}

echo '
<form class="mainForm"  action="index.php?comp=insevoFocus&task=process_insevo" method="post">
	<fieldset>
		<legend>Sécurité</legend>
		<p>
			'.$list_secuInsevoIP.'
		</p>		
		<p>
			'.$list_secuUsersIP.'
		</p>			
		
	</fieldset>
	<fieldset>
		<legend>Informations Générales</legend>
		<p>
			<label for="form_insevoID">INSEVO_ID: </label>
			<input type="text" name="form_insevoID" id="form_insevoID" maxlength="15" disabled=disabled value="'.intval($rs['insevo_id']).'"/>
		</p>				
		<p>
			<label for="form_login">Login: </label>
			<input type="text" name="form_login" id="form_login" maxlength="200" disabled=disabled value="'.htmlspecialchars(stripslashes($rs['login'])).'"/>
		</p>
		<p>
			<label for="form_email">E-mail: </label>
			<input type="text" name="form_email" id="form_email" maxlength="200" disabled=disabled value="'.htmlspecialchars(stripslashes($rs['email'])).'"/>
		</p>
		<p>
			<label for="form_parrain">Parrain: </label>
			<input type="text" name="form_parrain" id="form_parrain" maxlength="200" disabled=disabled value="'.htmlspecialchars(stripslashes($rs['parrain'])).'"/>
		</p>
		<p>
			<label for="form_datecrea">Date Création: </label>
			<input type="text" name="form_datecrea" id="form_datecrea" maxlength="200" disabled=disabled value="'.format_time($rs['time_creation']).'"/>
		</p>				
		<p>
			<label for="form_datevalid">Date Validation: </label>
			<input type="text" name="form_datevalid" id="form_datevalid" maxlength="200" disabled=disabled value="'.format_time($rs['time_creation']).'"/>
		</p>			
		<p>
			<label for="form_etat">Etat: </label>
			<input type="text" name="form_etat" id="form_etat" maxlength="200" disabled=disabled value="'.$rs['state'].'"/>
		</p>
	</fieldset>
	<fieldset>
		<legend>Motivation</legend>
		<p>
			<label for="form_motiv">Motivation:</label>
			<textarea name="form_motiv" id="form_motiv" disabled=disabled rows="10" cols="50">'.stripslashes(htmlspecialchars($rs['motivation'])).'</textarea>
		</p>
	</fieldset>
	<fieldset>
		<legend>Validation</legend>
		<p>
			<label for="form_comment">Commentaire de validation:</label>
			<textarea name="form_comment" id="form_comment" '.$disabled.' rows="10" cols="50">'.stripslashes(htmlspecialchars($rs['comment'])).'</textarea>
		</p>
		';
if($rs['state']=='WAIT' && $secureObject->verifyAuthorization('BO_INSEVO_VALIDATE')==TRUE){
	echo '	<p>
				<label for="form_valid">Refusé:</label>
				<input type="radio" name="result" value="NOK">
			</p>
			<p>
				<label for="form_valid">Accepté:</label>
				<input type="radio" name="result" value="OK">
			</p>
		<input type="hidden" name="id_insevo" value="'.intval($rs['insevo_id']).'">';
}


echo '
</fieldset>
	<p>
		<input class="ok" '.$disabled.' type="submit" name="Submit" value="OK" /><input class="ok" type="button" name="Retour" value="Retour" onclick="history.go(-1)"/>
	</p>
</form>';

?>