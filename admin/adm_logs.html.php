<?php
defined( '_ADM_VALID_CORE_LOGS' ) or die( 'Restricted access' );

?>
<form class="mainForm"  action="./index.php?comp=logs" method="post">
<fieldset>
	<legend>Recherche</legend>
	<p>
		<label for="form_date">Date (AAAAMMJJ): </label>
		<input type="text" name="form_date" maxlength="8" value=""/>
	</p>	
	<input type="submit" name="submit" value="Envoyer"/>
</fieldset>


<?php
echo $data;
?>

</form>