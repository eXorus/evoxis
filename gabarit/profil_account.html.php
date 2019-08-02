<?php
defined( '_VALID_CORE_PROFIL_ACCOUNT' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>
<div id="onglets"><center><table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">
<a href="./index.php?comp=profil">Afficher mon profil</a> | <a href="./index.php?comp=profil_account"><b>Modifier mon profil</b></a> | <a href="./index.php?comp=profil_settings">Réglages</a>
</td><td class="onglet_right"></td></tr></table></center></div>
<div id="blockFormulaire">
<div class="topic_top"></div>
<div class="topic_middle"><div class="newscontenu">

	<form method="post" action="index.php?comp=profil_account&amp;task=process">
<br />
<table class="tableau">
	<thead>
		<tr>
			<th width="50%">Mots de passe</th>
			<th>Adresse e-mail</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="avatar">
				<a href="index.php?comp=profil_pwd">[ Changer mes mots de passe ]</a><br /><br />
				Identifiant : <?php echo $_SESSION['username'] ?>
			</td>
			<td class="avatar">
				<a href="index.php?comp=profil_email">[ Changer mon adresse email ]</a><br /><br />
				E-mail actuel : <?php echo $form_email ?><br />
				<input type="checkbox" name="case_email_view" id="case_email_view" <?php if($form_email_view==1) echo 'checked="checked"'?> /> Autoriser l'affichage de son email<br /><i>Votre adresse e-mail ne sera pas visible par les autres membres si la case est décochée.</i><br />
			</td>
		</tr>
	</tbody>
</table>

<table class="tableau">
	<thead>
		<tr>
			<th width="50%" colspan="2">Informations personnelles</th>
			<th colspan="2">Contact</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
					Pseudo : 
			</td>
			<td class="profil">
					<input type="text" name="pseudo" id="pseudo" size="40" maxlength="50" value="<?php echo $form_pseudo ?>"/>
			</td>
			<td class="profil">
					ICQ : 
			</td>
			<td class="profil">
					<input type="text" name="icq" id="icq"  size="40" maxlength="50" value="<?php echo $form_icq ?>"/><br />
			</td>
		</tr>
		<tr>
			<td class="profil">
					Prénom : 
			</td>
			<td class="profil">
					<input type="text" name="prenom" id="prenom"  size="40" maxlength="50"value="<?php echo $form_realname ?>"/>
			</td>
			<td class="profil">
					AIM : 
			</td>
			<td class="profil">
					<input type="text" name="aim" id="aim"  size="40" maxlength="50" value="<?php echo $form_aim ?>"/><br />
			</td>
		</tr>
		<tr>
			<td class="profil">
					Date de naissance : 
			</td>
			<td class="profil">
					<input type="text" name="ddnj" id="ddnj" size="1" maxlength="2" value="<?php echo $form_ddnj ?>"/> - 
					<input type="text" name="ddnm" id="ddnm" size="1" maxlength="2" value="<?php echo $form_ddnm ?>"/> - 
					<input type="text" name="ddna" id="ddna" size="2" maxlength="4" value="<?php echo $form_ddna ?>"/><br />
			</td>
			<td class="profil">
					MSN : 
			</td>
			<td class="profil">
					<input type="text" name="msn" id="msn"  size="40" maxlength="50" value="<?php echo $form_msn ?>"/><br />
			</td>
		</tr>
		<tr>
			<td class="profil">
					Lieu d'habitation&nbsp;: 
			</td>
			<td class="profil">
					<input type="text" name="lieu" id="lieu"  size="40" maxlength="50" value="<?php echo $form_lieu ?>"/><br />
			</td>
			<td class="profil">
					Yahoo!&nbsp;:
			</td>
			<td class="profil">
					<input type="text" name="yahoo" id="yahoo"  size="40" maxlength="50" value="<?php echo $form_yahoo ?>"/><br />
			</td>
		</tr>
		<tr>
			<td class="profil">				
					Fuseau horaire : 
	<?php
	$fuseaux = array(
	'(GMT -12:00) International Date Line West',
	'(GMT -11:00) Midway Island, Samoa',
	'(GMT -10:00) Hawaii',
	'(GMT -09:00) Alaska',
	'(GMT -08:00) Pacific Time (US &amp; Canada), Tijuana',
	'(GMT -07:00) Arizona',
	'(GMT -07:00) Chihuahua, La Paz, Mazatlan',
	'(GMT -07:00) Mountain Time (US &amp; Canada)',
	'(GMT -06:00) Central America',
	'(GMT -06:00) Central Time (US &amp; Canada)',
	'(GMT -06:00) Guadalajara, Mexico City; Monterrey',
	'(GMT -06:00) Saskatchewan',
	'(GMT -05:00) Bogota, Lima, Quito',
	'(GMT -05:00) Eastern Time (US &amp; Canada)',
	'(GMT -05:00) Indiana (East)',
	'(GMT -04:00) Atlantic Time (Canada)',
	'(GMT -04:00) Caracas, Le Paz',
	'(GMT -04:00) Santiago',
	'(GMT -03:00) Brazilia',
	'(GMT -03:00) Brazilia',
	'(GMT -03:00) Buenos Aires, Georgetown',
	'(GMT -03:00) Greenland',
	'(GMT -02:00) Mid-Atlantic',
	'(GMT -01:00) Azores',
	'(GMT -01:00) Cap Verde Is.',
	'(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London',
	'(GMT +01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
	'(GMT +01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague',
	'(GMT +01:00) Brussels, Copenhagen, Madrid, Paris',
	'(GMT +01:00) Sarajevo, Skopje, Warsaw, Zagreb',
	'(GMT +01:00) West Central Africa',
	'(GMT +02:00) Athens, Beirut, Istambul, Minsk',
	'(GMT +02:00) Bucharest',
	'(GMT +02:00) Cairo',
	'(GMT +02:00) Harare, Pretoria',
	'(GMT +02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius',
	'(GMT +02:00) Jerusalem',
	'(GMT +03:00) Baghdad',
	'(GMT +03:00) Kuwait, Riyadh',
	'(GMT +03:00) Moscow, St. Petersburg, Volgograd',
	'(GMT +03:00) Nairobi',
	'(GMT +04:00) Abu Dhabi, Muscat',
	'(GMT +04:00) Baku, Tbilisi, Yerevan',
	'(GMT +05:00) Ekaterinburg',
	'(GMT +05:00) Islamabad, Karachi, Tashkent',
	'(GMT +06:00) Almaty, Novosibirsk',
	'(GMT +06:00) Astana, Dhaka',
	'(GMT +06:00) Sri Jayawardenepura',
	'(GMT +07:00) Bangkok, Hanoi, Jakarta',
	'(GMT +07:00) Krasnoyarsk',
	'(GMT +08:00) Beijing, Chongqing, Hong Kong, Urumqi',
	'(GMT +08:00) Irkutsk, Ulaan Bataar',
	'(GMT +08:00) Kuala Lumpur, Singapore',
	'(GMT +08:00) Perth',
	'(GMT +08:00) Taipei',
	'(GMT +09:00) Osaka, Sapporo, Tokyo',
	'(GMT +09:00) Seoul',
	'(GMT +09:00) Yakutsk',
	'(GMT +10:00) Brisbane',
	'(GMT +10:00) Canberra, Melbourne, Sydney',
	'(GMT +10:00) Guam, Port Moresby',
	'(GMT +10:00) Hobart',
	'(GMT +10:00) Vladivostok',
	'(GMT +11:00) Magadan, Solomon Is., Caledonia',
	'(GMT +12:00) Auckland, Wellington',
	'(GMT +12:00) Fiji, Kamchatka, Marshall Is.',
	'(GMT +13:00) Nukualofa'
	);
	echo '			</td>
			<td class="profil"><select name="fuseau" id="fuseau" style="width: 95px;">';
	foreach($fuseaux as $key => $value){
		if($form_fuseau==$key)
			echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
		else
			echo '<option value="'.$key.'">'.$value.'</option>';
	}
	echo '</select>';
	?>
			</td>
			<td class="profil">
					Skype&nbsp;:
			</td>
			<td class="profil">
					<input type="text" name="skype" id="skype"  size="40" maxlength="50" value="<?php echo $form_skype ?>"/><br />

			</td>
		</tr>
		<tr>
			<td class="profil">
					Sexe : 
			</td>
			<td class="profil">
		<input type="radio" name="sexe" id="sexe" value="1" <?php if($form_sexe==1) echo 'checked="checked"' ?>/>Homme 
		<input type="radio" name="sexe"  value="0" <?php if($form_sexe==0) echo 'checked="yes"' ?>/>Femme<br />
			</td>
			<td class="profil">
					  
			</td>
			<td class="profil">
				 
			</td>
		</tr>
	</tbody>
</table>


	<br /><br /><input type="submit" value="Valider"/>
	
	</form>
</div></div></div><div class="topic_bottom"></div>


<?php
require_once('./templates/'.$link_style.'bottom.php');
?>
