<?php
defined( '_VALID_CORE_FORUM_BOARD_MODERATE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>

<div id="blockFormulaire">
<form method="post" action="./index.php?comp=forum_board_moderate&amp;task=process">
<p>
	<fieldset><h1>Sélection des topics</h1>
	<ul>
	<?php
	foreach($topicsToConfirm as $topic){
		echo '<li><input type="checkbox" name="tid_'.$topic->tid.'" checked="checked" /> '.stripslashes(htmlspecialchars($topic->subject)).'</li>';
	}
	?>
	</ul>
	</fieldset>

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
    <input type="submit" value="Valider" /><a href="./index.php?comp=forum_board&amp;select=<?php echo $bid;?>">Annuler</a>
    <?php echo $actionToConfirm;?>
    </fieldset>
</p>
</form>
</div>



<?php
require_once('./templates/'.$link_style.'bottom.php');
?>
