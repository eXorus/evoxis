<?php
defined( '_VALID_CORE_FORUM_TOPIC_MODERATE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>

<div id="blockFormulaire">
<form method="post" action="./index.php?comp=forum_topic_moderate&amp;task=process">
<p>

	<fieldset><h1>Sélection des messages</h1>
	<div class="blockCommentaire">
	<?php
	foreach($messagesToConfirm as $message){
		echo '
		<div class="blockCommentaireHeader">
			<input type="checkbox" name="pid_'.$message->pid.'" checked="checked" /> 
			De '.stripslashes(htmlspecialchars($message->pseudo)).' ('.stripslashes(htmlspecialchars($message->username)).') le '.format_time($message->post_time).' 
		</div>
		<div class="blockCommentaireBody">
			'.stripslashes(htmlspecialchars($message->body)).'
		</div>';
	}
	?>
	</div>
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
    <input type="submit" value="Valider" /><a href="./index.php?comp=forum_topic&amp;select=<?php echo $tid;?>">Annuler</a>
    <?php echo $actionToConfirm;?>
    </fieldset>
</p>
</form>
</div>



<?php
require_once('./templates/'.$link_style.'bottom.php');
?>
