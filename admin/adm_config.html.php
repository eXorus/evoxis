<?php
defined( '_ADM_VALID_CORE_CONFIG' ) or die( 'Restricted access' );


function displayConfigSite(){
?>
	<form class="mainForm"  action="./index.php?comp=config&mod=site&task=process" method="post">
			<fieldset>
				<legend>Site Offline</legend>
				<p>
					<label for="form_offlineAcces">Activer/Désactiver l'accès au site: </label>
					<input type="checkbox" name="form_offlineAcces" <?php if(WEBSITE_OFFLINE==0) echo 'checked="checked"' ?>/> 
				</p>
				<br />
				<p>
					<label for="form_offlinePwd">Mot de passe:</label>
					<input name="form_offlinePwd" id='form_offlinePwd' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(WEBSITE_OFFLINE_PWD)  ?>"/>
				</p>
				<br />
				<p>
					<label for="form_offlineReason">Raison pour la désactivation du site:</label>
					<textarea name="form_offlineReason" id="form_offlineReason" rows="10" cols="50"><?php echo stripslashes(WEBSITE_OFFLINE_INFO) ?></textarea>
				</p>
			</fieldset>		
			<fieldset>
				<legend>Insevo</legend>
				<p>
					<label for="form_insevoActivate">Activer/Désactiver l'inscription au site: </label>
					<input type="checkbox" name="form_insevoActivate" <?php if(INSEVO_ACTIVATE==1) echo 'checked="checked"' ?>/> 
				</p>
				<br />
				<p>
					<label for="form_insevoCharte">Charte:</label>
					<textarea name="form_insevoCharte" id="form_insevoCharte" rows="10" cols="50"><?php echo stripslashes(CHARTE_EVOXIS) ?></textarea>
				</p>
			</fieldset>				
			<fieldset>
				<legend>Shoutbox</legend>
				<p>
					<label for="form_shoutboxMessage">Activer/Désactiver l'envoie de messages pour les visiteurs: </label>
					<input type="checkbox" name="form_shoutboxMessage" <?php if(SHOUTBOX_VISITEUR_ACTIVATE==1) echo 'checked="checked"' ?>/> 
				</p>
				
			</fieldset>
			<fieldset>
			<legend>Realmlist</legend>
			<p>
					<label for="form_realmlist">Realmlist:</label>
					<input name="form_realmlist" id='form_realmlist' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(REALMLIST)  ?>"/>
			</p>
			</fieldset>
			<fieldset>
			<legend>Rates</legend>
			<p>
					<label for="form_rdrop">Drop:</label>
					<input name="form_rdrop" id='form_rdrop' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(RATES_DROP)  ?>"/>
			</p>
			<p>
					<label for="form_rmonstres">Monstres:</label>
					<input name="form_rmonstres" id='form_rmonstres' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(RATES_MONSTRES)  ?>"/>
			</p>
			<p>
					<label for="form_rquetes">Quêtes:</label>
					<input name="form_rquetes" id='form_rquetes' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(RATES_QUETES)  ?>"/>
			</p>
			<p>
					<label for="form_rexploration">Exploration:</label>
					<input name="form_rexploration" id='form_rexploration' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(RATES_EXPLORATION)  ?>"/>
			</p>
			</fieldset>
			<fieldset>
			<legend>Version WoW</legend>
			<p>
					<label for="form_wowversion">Version WoW:</label>
					<input name="form_wowversion" id='form_wowversion' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(WOW_VERSION)  ?>"/>
			</p>
			</fieldset>
			<fieldset>
				<legend>Template</legend>
				<p>
					<label for="form_tplDefaut">Template par défaut:</label>
					<input name="form_tplDefaut" id='form_tplDefaut' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(TEMPLATE_DEFAULT)  ?>"/>
				</p>
			</fieldset>
			
			<fieldset>
				<legend>Box Défilante</legend>
				<p>
					<label for="form_boxdefilante">Info:</label>
					<textarea name="form_boxdefilante" id="form_boxdefilante" rows="10" cols="50"><?php echo stripslashes(BOX_DEFILANTE) ?></textarea>
				</p>
			</fieldset>	
		
			<p>
				<input class="ok" type="submit" name="Submit" value="OK" /><input class="ok" type="submit" name="Retour" value="Retour" />
			</p>
		</form>
<?php
}


function displayConfigWow(){

}







if($_GET['mod']=='wow'){
		displayConfigWow();
		
}
elseif($_GET['mod']=='site'){
		displayConfigSite();
		
}
?>
