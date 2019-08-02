<?php
defined( '_ADM_VALID_CORE_ASKFOCUS' ) or die( 'Restricted access' );

	
if($rs['aState']!='WAIT'){
$disabled = "";
}
else{
$disabled = "disabled=disabled";
}

echo '
<form class="mainForm"  action="index.php?comp=askFocus&task=process" method="post">
	<fieldset>
		<legend>Informations Générales</legend>
		<p>
			<label for="form_aID">ID: </label>
			<input type="text" name="form_aID" id="form_aID" maxlength="15" disabled=disabled value="'.intval($rs['aID']).'"/>
		</p>				
		<p>
			<label for="form_type">Type: </label>
			<input type="text" name="form_type" id="form_type" maxlength="200" disabled=disabled value="'.htmlspecialchars(stripslashes($rs['acTitle'])).'"/>
		</p>
		<p>
			<label for="form_cible">Cible: </label>
			<input type="text" name="form_cible" id="form_cible" maxlength="200" disabled=disabled value="'.htmlspecialchars(stripslashes($rs['cible'])).'"/>
		</p>
		<p>
			<label for="form_link">Lien: </label>
			<a href="'.htmlspecialchars(stripslashes($rs['aLink'])).'">'.htmlspecialchars(stripslashes($rs['aLink'])).'</a>
		</p>
		<p>
			<label for="form_state">Etat: </label>
			<input type="text" name="form_state" id="form_state" maxlength="200" disabled=disabled value="'.htmlspecialchars(stripslashes($rs['aState'])).'"/>
		</p>			
		<p>
			<label for="form_dateopen">Date d\'Ouverture: </label>
			<input type="text" name="form_dateopen" id="form_dateopen" maxlength="200" disabled=disabled value="'.format_time($rs['aDateOpen']).'"/>
		</p>
		<p>
			<label for="form_datevalidate">Date de Validation: </label>
			<input type="text" name="form_datevalidate" id="form_datevalidate" maxlength="200" disabled=disabled value="'.format_time($rs['aDateValidate']).'"/>
		</p>				
		<p>
			<label for="form_dateassign">Date d\'Assignation: </label>
			<input type="text" name="form_dateassign" id="form_dateassign" maxlength="200" disabled=disabled value="'.format_time($rs['aDateAssign']).'"/>
		</p>	
		<p>
			<label for="form_datedone">Date de Cloture: </label>
			<input type="text" name="form_datedone" id="form_datedone" maxlength="200" disabled=disabled value="'.format_time($rs['aDateDone']).'"/>
		</p>				
		<p>
			<label for="form_daterefused">Date de Refus: </label>
			<input type="text" name="form_daterefused" id="form_daterefused" maxlength="200" disabled=disabled value="'.format_time($rs['aDateRefused']).'"/>
		</p>
		<p>
			<label for="form_assignto">Assigné à: </label>
			<input type="text" name="form_assignto" id="form_assignto" maxlength="200" disabled=disabled value="'.htmlspecialchars(stripslashes($rs['assignto'])).'"/>
		</p>	
	</fieldset>
	<fieldset>
		<legend>Demande</legend>
		<p>
			<label for="form_ask">Demande:</label>
			<textarea name="form_ask" id="form_ask" disabled=disabled rows="10" cols="50">'.stripslashes(htmlspecialchars($rs['aAsk'])).'</textarea>
		</p>
	</fieldset>
	<fieldset>
		<legend>Validation</legend>
		<p>
			<label for="form_historique">Historique:</label>
			<textarea name="form_historique" id="form_historique" "disabled=disabled" rows="10" cols="50">'.stripslashes(htmlspecialchars($rs['aComment'])).'</textarea>
		</p>
		<p>
			<label for="form_comment">Commentaire de validation:</label>
			<textarea name="form_comment" id="form_comment" '.$disabled.' rows="10" cols="50"></textarea>
		</p>
		<input type="hidden" name="form_aID" value="'.intval($rs['aID']).'">
		';
if($rs['aState']=='OPEN'){
	echo '	<p>
				<label for="form_valid">Refusé:</label>
				<input type="radio" name="result" value="REFUSED">
			</p>
			<p>
				<label for="form_valid">Validé:</label>
				<input type="radio" name="result" value="VALIDATE">
			</p>';
}
elseif($rs['aState']=='VALIDATE'){
	$rq = $db->Send_Query("
			SELECT u.uid, u.username, u.pseudo
			FROM exo_users u
			LEFT JOIN exo_groups_users g ON g.uid = u.uid
			LEFT JOIN exo_security_assign ass ON ((ass.ass_Type='G' AND ass.ass_cible = g.gid) OR (ass.ass_Type='U' AND ass.ass_cible = u.uid) )
			LEFT JOIN exo_security_ACL acl ON acl.acl_ID = ass.ass_ACL
			LEFT JOIN exo_groups gp ON gp.gid = g.gid
			WHERE acl.ac_Key='BO_ASK_ASSIGN'");
	$mjs_rp = $db->loadObjectList($rq);

	echo '<select name="form_assigntovalue" width="200px"><option value="0" selected="selected"> -- Selection --</option>';
	foreach($mjs_rp as $o){
		echo '<option value="'.$o->uid.'">'.$o->username.' ('.$o->pseudo.')</option>';
	}
	echo '</select>';
}
elseif($rs['aState']=='ASSIGN'){
	echo '	<p>
				<label for="form_valid">Refusé:</label>
				<input type="radio" name="result2" value="REFUSED">
			</p>
			<p>
				<label for="form_valid">Terminée:</label>
				<input type="radio" name="result2" value="DONE">
			</p>';
}


echo '
</fieldset>
	<p>
		<input class="ok" '.$disabled.' type="submit" name="Submit" value="OK" /><input class="ok" type="button" name="Retour" value="Retour" onclick="history.go(-1)"/>
	</p>
</form>';

?>