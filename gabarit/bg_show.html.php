<?php
defined( '_VALID_CORE_BG_SHOW' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($_GET['guid'])){
?>
<h1><?php echo $name ?></h1><h4><a href="./index.php?comp=bg&amp;select=<?php echo $wow_id ?>">[ Voir les autres backgrounds de ce joueur ]</a></h4><br />
	<ul>
		<li><strong>Classe :</strong> <?php echo $class ?></li>
		<li><strong>Race :</strong> <?php echo $race ?></li>
		<li><strong>Creation :</strong> <?php echo format_time($creation_time) ?></li>
		<li><strong>Dernière modification :</strong> <?php echo format_time($last_edit_time) ?></li>
		<li><strong>Statut :</strong> <?php echo $statut ?></li>
		<li><strong>Vote :</strong> <?php echo 'Moyenne: '.$vote['avg_vote']. ' | Nombre de votes: '.$vote['nb_vote'] ?></li>
	</ul><br />

<?php
	if($wow_id==$_SESSION['wow_id']){
		//mon perso
		echo '		
		<br /><center><a href="./index.php?comp=bg_write&amp;guid='.$guid.'">
		<img src="./templates/'.$link_style.'/ico/completer_bg.png" height="17px" width="200px" align="top" alt="Complèter ce Background"/>
		</a></center><br />
		';
	}
	
	echo' <div class="topic_top"></div>
<div class="topic_middle">';
	echo '<div class="newscontenu">';
	echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($background))));
	echo '</div></div><div class="topic_bottom"></div>';

	//Vote
	if($secureObject->verifyAuthorization('FO_BG_ADDCOMMENT')==TRUE){
	?>

	<div id="blockFormulaire">
	<h1>Votez pour vos backgrounds préférés</h1><h4> &nbsp; </h4>
	<fieldset>
	<form method="post" action="index.php?comp=bg_list&amp;task=vote&amp;guid=<?php echo intval($_GET['guid']) ?>">
		<?php
		if(!empty($vote_note) && !empty($vote_time)){
			echo '<p class="info">Vous avez déjà voté le <strong>'.format_time($vote_time).'</strong> : 
			votre note était de <strong>'.$vote_note.'/5</strong>
			<br />Voulez-vous modifier votre note ? </p>';
		}
		?>
		<p>
		Veuillez indiquer votre note pour ce background :<br />
<label><input type="radio" name="note" value="1" /> 
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starempty.png" title="Star Empty" alt="Star Empty"/></label>
<label><input type="radio" name="note" value="2" /> 
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starempty.png" title="Star Empty" alt="Star Empty"/></label>
<label><input type="radio" name="note" value="3" /> 
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starempty.png" title="Star Empty" alt="Star Empty"/></label>
<label><input type="radio" name="note" value="4" /> 
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starempty.png" title="Star Empty" alt="Star Empty"/></label>
<label><input type="radio" name="note" value="5" /> 
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/<?php echo $link_style ?>/ico/starfull.png" title="Star Full" alt="Star Full"/></label>

		</p>
		<br />
		<input type="submit" name="submit" value="Votez !!"/>
	</form>
	</fieldset></div>
	<?php
	
	//AFFICHAGE DES COMMENTAIRES
	echo '<div id="blockCommentaires">';
	echo "<h1>Commentaires</h1><h4> &nbsp</h4><br />";
	if(!empty($comments)){
	
		foreach($comments as $one_comment){
			echo '
			<div id="bgcid'.$one_comment->bgcid.'" class="blockCommentaire">
				<div class="blockCommentaireHeader">De '.$one_comment->pseudo.' le '.format_time($one_comment->time_create).'</div>
				<div class="blockCommentaireBody">'.stripslashes(nl2br(htmlspecialchars($one_comment->comment))).'</div>
			</div>
			';
		}
	}
	else{
		echo "Aucun commentaire pour le moment";
	}
	echo '';
	?>
	

	<form action="index.php?comp=bg_show&amp;guid=<?php echo intval($_GET['guid']) ?>" method="post">

			<h1>Saisissez votre commentaire</h1><h4> &nbsp</h4>
	<div class="blockFormulaire">
		<fieldset>	
			<label>Commentaire:</label>
	<div class="topic_top"></div><div class="topic_middle">
				<textarea cols="96" rows="5" name="comment"></textarea>
	</div><div class="topic_bottom"></div>
			<input type="hidden" name="bgid" value="<?php echo intval($_GET['guid']) ?>"/>
			
		</fieldset>
		
		<input type="submit" value="Valider"/><br /><br />
	</form>
	</div>
	</div>
	<?php
	}
}

require_once('./templates/'.$link_style.'bottom.php');
?>