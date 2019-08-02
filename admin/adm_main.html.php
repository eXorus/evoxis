<?php
defined( '_ADM_VALID_CORE_MAIN' ) or die( 'Restricted access' );

echo '
<form class="mainForm"  action="index.php?comp=main" method="post">
<fieldset>
	<legend>En attente de validation</legend>
	<p>
		<label>Guildes: </label>
		<a href="./index.php?comp=guilds">'.$count_guildes.'</a>
	</p>
	<p>
		<label>Backgrounds: </label>
		<a href="./index.php?comp=bgcheck">'.$count_backgrounds.'</a>
	</p>
	<p>
		<label>Inscriptions: </label>
		<a href="./index.php?comp=insevo&type=WAIT">'.$count_insevos.'</a>
	</p>
	<p>
		<label>Demandes: </label>
		<a href="./index.php?comp=ask&type=OPEN">'.$count_askOPEN.'</a>
	</p>	
	<p>
		<label>Demandes assignées: </label>
		<a href="./index.php?comp=ask&type=ASSIGN">'.$count_askASSIGN.'</a>
	</p>
</fieldset>

<fieldset>
	<legend>Mon objectif</legend>
	<p>
       <label for="objectif">Mon objectif</label><br />
       <textarea name="objectif" id="objectif">'.$objectif.'</textarea>
	</p>

</fieldset>

<input type="submit" />

</form>
';
?>
