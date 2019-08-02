<?php
defined( '_VALID_CORE_FORUM_POST' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>

<div id="blockFormulaire">
<form id="post" method="post" name="formulaire" action="./index.php?comp=forum_post&amp;task=process">

	
	<?php
	if(!empty($_POST['message'])){
		echo '
		<h1>Prévisualisation</h1><br />
		<div class="blockCommentaire">
				<div class="blockCommentaireBody">'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($_POST['message'])))).'</div>
		</div>	
		';
	}
	?>
		<?php
		echo '<input type="hidden" name="bid" value="'.$bid.'" />';
		echo '<input type="hidden" name="tid" value="'.$tid.'" />';
		echo '<input type="hidden" name="pid" value="'.$pid.'" />';			
		echo '<input type="hidden" name="action" value="'.$action.'" />';
		
		if($printTopic == TRUE){
			echo '<div id="nav_forum"><center><table class="nav_forum"><tr><td class="nav_forum_left"></td><td class="nav_forum_center"><div class="pagination">';			
			echo 'Sujet : <input class="titre_topic" type="text" name="subject" id="subject" size="80" maxlength="70" value="'.$form_subject.'"/><br />';			
			echo '</div></td><td class="nav_forum_right"></td></tr></table></center></div>';
		}	
			
		?>						
		<br /><label for="message">
		<?php include('./inc/bbcode.html.php'); ?></label>
		<div class="topic_top"></div>
		<div class="topic_middle">
		<center><textarea name="message" id="message" rows="20" cols="95"><?php echo $form_body ?></textarea></center><br />
		</div><div class="topic_bottom"></div>
		
		<?php
		if($catRP==1){
		?>
		<p>
			<label for="author_2">Indiquez l'auteur du message: </label>
				<select name="author_2" id="author_2">
				   <option value="0">Anonyme</option>
				   <?php
				   foreach($authors_2 as $one_author_2){
					   $authorSelected = ($one_author_2->guid==$form_author_2) ? ' selected="selected"' : '';
					   echo '<option value="'.$one_author_2->guid.'"'.$authorSelected.'>'.stripslashes(htmlspecialchars($one_author_2->name)).'</option>';
				   }
				   ?>
			</select>
		</p>
		<br />		
		
		<?php
		}
				
		if($printTopic == TRUE){			
echo '
<table class="tableau">
	<thead>
		<tr>
			<th colspan="2">Attribuez un tag</th>';
if($secureObject->verifyAuthorization('FO_FORUM_POST_ANNOUNCE')==TRUE){
			echo'<th>Options</th>';}
echo'	</tr>
	</thead>
	<tbody>
		<tr>
			<td class="avatar" width="10%">';
			echo '<label for="tag">Tag :</label>
			</td>
			<td class="forum_options">';
			foreach($tags as $tag){
				if(in_array($tag->tag_id,$form_tag)) 
					echo '<input type="checkbox" name="tag'.$tag->tag_id.'" checked="checked" /> '.$tag->title.' ('.$tag->description.')<br />';
				else 
					echo '<input type="checkbox" name="tag'.$tag->tag_id.'" /> '.$tag->title.' ('.$tag->description.')<br />';
				
			}
			echo '</td>';
if($secureObject->verifyAuthorization('FO_FORUM_POST_ANNOUNCE')==TRUE){
			echo '<td class="forum_options">
					<label for="announce">Type : </label><input type="checkbox" name="announce" '.$form_announce.' /> Annonce
					<label for="lock">Etat : </label><input type="checkbox" name="lock" '.$form_lock.' /> Verrouiller';}
			
echo '		</td>
		</tr>
	</tbody>
</table>
';
			}	
			
		?>			

		<?php
		if($printTopic == TRUE){
		?>
		
		
		<script language="Javascript">
		function ActiveOption(option, chk) {
			var obj = document.getElementById(option);
			
			if (chk.checked==true){	
				obj.style.display='block';
			}
			else{
				obj.style.display='none';
			}
		}
		
		function addQuestion(i) {
			var i2 = i + 1;

			document.getElementById('leschamps_'+i).innerHTML = '<div class="apoll"><label for="pollQuestion_'+i+'">Question : </label><input type="text" name="pollQuestion_'+i+'" id="pollQuestion_'+i+'" size="40" maxlength="70" value=""/>';
			document.getElementById('leschamps_'+i).innerHTML += '<label for="pollReponses_'+i+'">Réponses (1 réponse par ligne) : </label><textarea class="textarea_forum" name="pollReponses_'+i+'" id="pollReponses_'+i+'" rows="5" cols="60"></textarea>';
			document.getElementById('leschamps_'+i).innerHTML += 'Nombre de réponses à donner par membre : <input type="text" name="pollMaxReponse_'+i+'" id="pollMaxReponse_'+i+'" size="3" maxlength="3" value="1"/><br />';
			document.getElementById('leschamps_'+i).innerHTML += (i <= 10) ? '<br /><span id="leschamps_'+i2+'"><a href="javascript:addQuestion('+i2+')">Ajouter une question</a></span>' : '';
		}
		</script>
		
		
<br />
<table class="tableau">
	<thead>
		<tr>
			<th>Sondage : <input type="checkbox" name="pollActivated" onClick="ActiveOption('poll', this);" <?php echo $form_pollActivated; ?>/>
			<?php 
			if(!empty($form_pollpID)){
				echo '<select name="pollActivatedChoice">';
				$tabpollActivatedChoice = array("NO_EDIT" => "Sans modifier", "EDIT" => "Modifier (Le sondage sera réinitialisé à zéro)", "DELETE" => "A supprimer");
				foreach($tabpollActivatedChoice as $k => $v){
					if($k==$form_pollActivatedChoice){
						echo '<option value="'.$k.'" selected="selected">'.$v.'</option>';
					}
					else{
						echo '<option value="'.$k.'">'.$v.'</option>';
					}
				}
			}
			?>
			</th>
		<?php if($secureObject->verifyAuthorization('FO_FORUM_POST_ANNOUNCE')==TRUE){
			echo '<th>Calendrier : <input type="checkbox" name="calActivated" onClick="ActiveOption(\'calendrier\', this);" '.$form_calActivated.' /></th>';
		} ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil" width="50%">
			<div id="poll" style="display: <?php if(empty($form_pollActivated)) {echo 'none';} else {echo 'block';} ?>;">
			<input type="hidden" name="pollpID" value="<?php echo $form_pollpID; ?>" />
Autoriser les membres à changer leur vote : <input type="checkbox" name="pollAgain" <?php echo $form_pollAgain; ?>/>
<br />Nombre de jours disponible (0=Illimité) : <input type="text" name="pollNbDays" id="pollNbDays" size="3" maxlength="3" value="<?php echo $form_pollNbDays; ?>"/>
					

					<?php
					$item = 1;
					if(!empty($form_polls)){
						foreach($form_polls as $poll){
							echo '<div class="apoll"> <label for="pollQuestion_'.$item.'">Question : </label><input type="text" name="pollQuestion_'.$item.'" id="pollQuestion_'.$item.'" size="40" maxlength="70" value="'.$poll['question'].'"/>';
							echo '<input type="hidden" name="pollpqID_'.$item.'" value="'.$poll['questionid'].'" />';
							echo '<label for="pollReponses_'.$item.'">Réponses (1 réponse par ligne) : </label><textarea class="textarea_forum" name="pollReponses_'.$item.'" id="pollReponses_'.$item.'" rows="5" cols="5">'.$poll['reponses'].'</textarea>';
							echo '<input type="hidden" name="pollpcID_'.$item.'" value="'.$poll['reponsesid'].'" />';
							echo 'Nombre de réponses à donner par membre : <input type="text" name="pollMaxReponse_'.$item.'" id="pollMaxReponse_'.$item.'" size="3" maxlength="3" value="'.$poll['maxreponse'].'"/><br />';
							echo '<input type="hidden" name="pollpqMaxReponse_'.$item.'" value="'.$poll['maxreponseid'].'" />';
							$item++;
							echo '</div>';
						}
					}
					else{
						echo '<div class="apoll"><label for="pollQuestion_'.$item.'">Question : </label><input type="text" name="pollQuestion_'.$item.'" id="pollQuestion_'.$item.'" size="40" maxlength="70" value=""/>';
						echo '<label for="pollReponses_'.$item.'">Réponses (1 réponse par ligne) : </label><textarea class="textarea_forum" name="pollReponses_'.$item.'" id="pollReponses_'.$item.'" rows="5" cols="5"></textarea>';
						echo 'Nombre de réponses à donner par membre : <input type="text" name="pollMaxReponse_'.$item.'" id="pollMaxReponse_'.$item.'" size="3" maxlength="3" value="1"/><br /></div>';
					}
					?>

					<br /><span id="leschamps_<?php echo $item+1; ?>"><a href="javascript:addQuestion(<?php echo $item+1; ?>)">Ajouter une question</a></span>
			</div>	

		
			</td>
			<td class="profil">
			<div id="calendrier" style="display: <?php if(empty($form_calActivated)) {echo 'none';} else {echo 'block';} ?>;">
			<input type="hidden" name="calEid" value="<?php echo $form_calEid; ?>" />
			<label for="calTitle">Titre: </label><input type="text" name="calTitle" id="calTitle" size="40" maxlength="70" value="<?php echo $form_calTitle; ?>"/>
			<label for="calDesc">Description: </label><textarea class="textarea_forum" name="calDesc" id="calDesc" rows="10" cols="95"><?php echo $form_calDesc; ?></textarea>
			<label for="calDateBegin">Date Début (JJ/MM/AAAA): </label><input type="text" name="calDateBegin" id="calDateBegin" size="11" maxlength="10" value="<?php echo $form_calDateBegin; ?>"/>
			<label for="calTimeBegin">Heure Début (HH:MM): </label><input type="text" name="calTimeBegin" id="calTimeBegin" size="6" maxlength="5" value="<?php echo $form_calTimeBegin; ?>"/>
			<label for="calDateEnd">Date de Fin (JJ/MM/AAAA): </label><input type="text" name="calDateEnd" id="calDateEnd" size="11" maxlength="10" value="<?php echo $form_calDateEnd; ?>"/>
			<label for="calTimeEnd">Heure de Fin (HH:MM): </label><input type="text" name="calTimeEnd" id="calTimeEnd" size="6" maxlength="5" value="<?php echo $form_calTimeEnd; ?>"/>
			<label for="calType3">Type: </label>
				<input name="calType" value="1" id="calType1" type="radio" <?php if($form_calType==1) echo 'checked="checked"'; ?>/> Event Principal &nbsp;&nbsp;&nbsp;
				<input name="calType" value="2" id="calType2" type="radio" <?php if($form_calType==2) echo 'checked="checked"'; ?>/> Event Secondaire &nbsp;&nbsp;&nbsp;
				<input name="calType" value="3" id="calType3" type="radio" <?php if($form_calType==3) echo 'checked="checked"'; ?>/> Divers
			</div>
			</td>
		</tr>
	</tbody>
</table>
<?php
}
?>
<table class="tableau">
	<thead>
		<tr><th><input type="submit" name="submit" value="Prévisualiser"/></th>
			<th><input type="submit" name="submit" value="Envoyer"/></th></tr>
	</thead>
<tbody><tr><td></td></tr></tbody>

</table>
		<?php
	
	
		if(!empty($last_msgs)){
			echo '<h1>30 derniers messages</h1>';
			
			foreach($last_msgs as $last_msg){
				
				$pseudoToPrint = ($last_msg->cat_rp==1) ? (empty($last_msg->bg_guid)) ? 'Anonyme' : '<a href="./index.php?comp=bg_show&amp;guid='.$last_msg->bg_guid.'">'.stripslashes(htmlspecialchars($last_msg->bg_name)).'</a>' : '<a href="./index.php?comp=profil&amp;select='.$last_msg->p_uid.'">'.stripslashes(htmlspecialchars($last_msg->p_name)).'</a>';
				
				echo '
				<div class="blockCommentaire">
					<div class="blockCommentaireHeader">De '.$pseudoToPrint.' le '.format_time($last_msg->post_time).'</div>
					<div class="blockCommentaireBody">'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($last_msg->body)))).'</div>
				</div>';
			}
		}

	?>	
	
</form>


<br /><a href="Javascript:history.go(-1)">[ Retour ]</a>

</div>

<?php
require_once('./templates/'.$link_style.'bottom.php');
?>
