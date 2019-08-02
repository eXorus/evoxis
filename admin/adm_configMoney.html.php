<?php
defined( '_ADM_VALID_CORE_CONFIGMONEY' ) or die( 'Restricted access' );

?>
<form class="mainForm"  action="./index.php?comp=configMoney&task=process" method="post">
		<fieldset>
			<legend>Alliance</legend>
			<p>
				<label for="form_aFonction">Fonction:</label>
				<input name="form_aFonction" id='form_aFonction' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(MONEY_ALLIANCE_FONCTION)  ?>"/>
			</p>
			<p>
				<label for="form_aNom">Nom:</label>
				<input name="form_aNom" id='form_aNom' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(MONEY_ALLIANCE_NOM)  ?>"/>
			</p>
		</fieldset>		
		<fieldset>
			<legend>Horde</legend>
			<p>
				<label for="form_hFonction">Fonction:</label>
				<input name="form_hFonction" id='form_hFonction' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(MONEY_HORDE_FONCTION)  ?>"/>
			</p>
			<p>
				<label for="form_hNom">Nom:</label>
				<input name="form_hNom" id='form_hNom' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(MONEY_HORDE_NOM)  ?>"/>
			</p>
		</fieldset>				
		
	
		<p>
			<input class="ok" type="submit" name="Submit" value="OK" /><input class="ok" type="submit" name="Retour" value="Retour" />
		</p>
	</form>
