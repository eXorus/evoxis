<?php
defined( '_VALID_CORE_NEWS_COMMENT' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($one_news)){
	//AFFICHAGE DES NEWS
	echo '<div class="topic_top"></div>
<div class="topic_middle">';
	echo "<h2>".stripslashes(htmlspecialchars($one_news['title']))."</h2> <h4> par ".$one_news['pseudo']." <br />le ".$one_news['date_create']."</h4>";
	echo '<div id="newscontenu"><p>'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($one_news['intro'])))).'</p><p>'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($one_news['body'])))).'</p>';
	if($one_news['last_modif']!="0000-00-00 00:00:00"){
		echo '<h9>Modifié : '.$one_news['last_modif'].'</h9>';
	}
	echo '</div><div align="right" style="margin-right:40px;"><a href="index.php?comp=news"><img src="./templates/'.$link_style.'/ico/retour.gif" title="Retour aux news" alt="Retour aux news"/></a></div>';
	echo '</div><div class="topic_bottom"></div>';
	
	//AFFICHAGE DES COMMENTAIRES
echo "<h1>Commentaires</h1><h4> &nbsp; </h4><br />";
	echo '<div id="blockCommentaires">';
	if(!empty($comments)){
	
		displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=news_comment&amp;nid=".$nid."&amp;start=", 30);
		echo'<br />';
		foreach($comments as $one_comment){
			echo '
			<div id="cid'.$one_comment->cid.'" class="blockCommentaire">
				<div class="blockCommentaireHeader">De '.$one_comment->pseudo.' le '.$one_comment->date_create.'</div>
				<div class="blockCommentaireBody">'.stripslashes(nl2br(htmlspecialchars($one_comment->body))).'<div align="right"><a href="#top"><img src="./templates/'.$link_style.'/ico/topic_up.gif" height="20px" width="20px" align="top" title="Haut de page" alt="Haut de page"/></a>&nbsp;
	<a href="#bot"><img src="./templates/'.$link_style.'/ico/topic_down.gif" height="20px" width="20px" align="top" title="Bas de page" alt="Bas de page"/></a>
</div></div>
			</div>
			';
		}
		displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=news_comment&amp;nid=".$nid."&amp;start=", 30);
	}
	else{
		echo "<p>Aucun commentaire pour le moment</p>";
	}
	echo '</div>';
	
	//FORMULAIRE COMMENTAIRE
	echo '<div id="blockFormulaire">';
	if($secureObject->verifyAuthorization('FO_NEWS_ADDCOMMENT')==TRUE){
		echo '
		<form action="index.php?comp=news_comment&amp;task=add" method="post">
		<fieldset><legend>Saisissez votre commentaire</legend>	
		<label>Commentaire :</label>
<div class="topic_top"></div>
<div class="topic_middle">
<textarea class="form" cols="96" rows="5" name="comment"></textarea>
</div><div class="topic_bottom"></div>
		</fieldset>
		
		<input type="hidden" name="nid" value="'.$one_news['nid'].'"/>
		
		<input type="submit" value="Valider"/><br /><br />		
		</form>
		';
	}
	else{
		echo '<p class="info">Vous ne pouvez pas commenter cette news car vous n\'êtes pas connecté. </p>';
	}
	echo '</div>';

}
else{
	echo "Aucune news pour le moment";

}

require_once('./templates/'.$link_style.'bottom.php');

?>