<?php
defined( '_VALID_CORE_BUGTRACKER_VIEW' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($bug)){
	if($bug['bt_etat']==0){$img_etat = '<img src="./templates/'.$link_style.'/ico/bt_nok.png" height="20px" width="20px" align="top" alt="Non résolu"/>';}
	elseif($bug['bt_etat']==1){$img_etat = '<img src="./templates/'.$link_style.'/ico/bt_ok.png" height="20px" width="20px" align="top" alt="Résolu"/>';}
	elseif($bug['bt_etat']==2){$img_etat = '<img src="./templates/'.$link_style.'/ico/bt_ok.png" height="20px" width="20px" align="top" alt="Résolu"/> (Bug Core)';}
	elseif($bug['bt_etat']==3){$img_etat = '<img src="./templates/'.$link_style.'/ico/bt_ok.png" height="20px" width="20px" align="top" alt="Résolu"/> (Bug Script)';}
	else {$img_etat = '<img src="./templates/'.$link_style.'/ico/bt_ok.png" height="20px" width="20px" align="top" alt="Résolu"/>';}

	//AFFICHAGE DU BUG
	
	echo "<h1>".stripslashes(htmlspecialchars($bug['bt_name']))." </h1><h4>Catégorie : [".stripslashes(htmlspecialchars($bug['bt_categorie']))."]</h4>";
	
	if(!empty($bug['bt_link'])) $echo_link = '<li><strong>Lien:</strong> <a href="'.stripslashes(htmlspecialchars($bug['bt_link'])).'" onclick="window.open(this.href); return false;">(lien)</a></li>';
	if(!empty($bug['bt_version'])) $echo_version = '<li><strong>Version:</strong> '.stripslashes(htmlspecialchars($bug['bt_version'])).'</li>';
	
	echo '
	<ul>
		<li><strong>De:</strong> <a href="./index.php?comp=profil&amp;select='.$bug['bt_from'].'">'.$bug['pseudo'].'</a></li>
		<li><strong>Date de création:</strong> '.format_time($bug['bt_time_create']).'</li>
		<li><strong>Date de fin:</strong> '.format_time($bug['bt_time_end']).'</li>
		<li><strong>Etat:</strong> '.$img_etat.'</li>
		'.$echo_link.'
		'.$echo_version.'
	</ul>
	';
	echo '<div class="topic_top"></div>
<div class="topic_middle"><div id="blockBodyBug">'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($bug['bt_description'])))).'</div></div><div class="topic_bottom"></div>';
	if($bug['bt_from']==$_SESSION['uid'] || $secureObject->verifyAuthorization('FO_BUGTRACKER_EDIT')==TRUE){
		echo '<div align="right" style="margin-right: 30px;"><a href="index.php?comp=bugtracker_write&amp;task=edit&amp;select='.$bug['btid'].'">[ Editer ]</a></div>';
	}
	
	//AFFICHAGE DES COMMENTAIRES
	echo '<div id="blockCommentairesBug">';
	echo "<h2>Commentaires</h2><h4> &nbsp; </h4>";
	if(!empty($comments)){
		foreach($comments as $one_comment){
			echo '
			<div id="btcid'.$one_comment->btcid.'" class="blockCommentaireBug">
				<div class="blockCommentaireHeaderBug">De <a href="./index.php?comp=profil&amp;select='.$one_comment->uid.'">'.$one_comment->pseudo.'</a> le '.format_time($one_comment->time_create).'</div>
				<div class="blockCommentaireBodyBug">'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($one_comment->comment)))).'</div>
			</div>
			';
		}
	}
	else{
		echo "<br />Aucun commentaire pour le moment";
	}
	echo '</div>';
	
	//FORMULAIRE COMMENTAIRE
	echo '<div id="blockFormulaire">';
	if($secureObject->verifyAuthorization('FO_BUGTRACKER_ADDCOMMENT')==TRUE){
		echo '
		<form action="index.php?comp=bugtracker_write&amp;task=addcomment" method="post">
		<h2>Saisissez votre commentaire</h2><h4> &nbsp; </h4><fieldset>	
<div class="topic_top"></div>
<div class="topic_middle">
		<textarea class="form" cols="96" rows="5" name="comment"></textarea>
</div><div class="topic_bottom"></div>
		</fieldset>
		<input type="hidden" name="btid" value="'.$bug['btid'].'"/>
		<input type="submit" value="Valider"/>		
		</form>
		';
		
	}
	else{
		echo '<p class="info">Vous ne pouvez pas commenter ce bug car vous n\'êtes pas connecté. </p>';
	}
	echo '</div>';
}
else{
	echo "Aucun bug pour le moment";
}

if($bug['bt_etat']==0 && $secureObject->verifyAuthorization('FO_BUGTRACKER_MODERATE')==TRUE){
	echo '
	<div id="blockFormulaire">
	<h2>Modération</h2><h4> &nbsp; </h4><br />
	<h3>Etat</h3><br />
	<form action="index.php?comp=bugtracker_write&amp;task=modStatut" method="post">
	<input type="hidden" name="btid" value="'.$bug['btid'].'"/>
	<p>
	<input type="radio" name="state" value="1"/> Résolu<br />
	<input type="radio" name="state" value="2"/> Bug du core<br />
	<input type="radio" name="state" value="3"/> Bug de script<br />
	<input type="radio" name="state" value="0" checked="checked" /> Pas de changement de statut<br />
	</p><br />
	<h3>Zone SQL</h3>
	<textarea style="border: 1px solid green;" cols="96" rows="5" name="form_sql"></textarea><br />
	<input type="submit" value="Valider"/>		
	</form>
	<h3>Réponse automatique</h3><br />
	<ul>
	<li><a href="index.php?comp=bugtracker_write&amp;task=autoComment&amp;btid='.$bug['btid'].'&amp;param=A">
		Déclaration de bug en doublon merci de lire avant de poster</a></li>
	<li><a href="index.php?comp=bugtracker_write&amp;task=autoComment&amp;btid='.$bug['btid'].'&amp;param=B">
		Merci de poster un lien vers Judghype (ou autre) illustrant le comportement correct</a></li>
	</ul>
	</div>';
}

echo '<br /><a href="./index.php?comp=bugtracker">[ Retour ]</a>';
require_once('./templates/'.$link_style.'bottom.php');
?>