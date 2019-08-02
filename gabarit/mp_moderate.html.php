<?php
defined( '_VALID_CORE_MP_MODERATE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>

<div id="blockFormulaire">
<form method="post" action="./index.php?comp=mp_moderate&amp;task=process">
<p>
	
	<?php
	if(!empty($MPsToConfirm)){
		echo "<fieldset><h1>Sélection des MPs</h1><ul>";
		foreach($MPsToConfirm as $mp){
			echo '<li><input type="checkbox" name="dpID_'.$mp->dpID.'" checked="checked" /> '.stripslashes(htmlspecialchars($mp->dpTitle)).'</li>';
		}
		echo "</ul></fieldset>";
	}
	?>

	<?php
	if (!empty($optionsToConfirm)){
		echo '
		<fieldset><h1>Options</h1>
		'.$optionsToConfirm.'
		</fieldset>';
	}
	?>
	
	
	
	<fieldset><h1>Confirmation</h1>
	<br />
    <?php echo $messageToConfirm;?>
    <br />
    <br />
    <input type="submit" value="Valider" /><a href="./index.php?comp=mp">Annuler</a>
    <?php echo $actionToConfirm;?>
    </fieldset>
</p>
</form>
</div>



<?php
require_once('./templates/'.$link_style.'bottom.php');
?>
