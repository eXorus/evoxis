<?php
defined( '_VALID_CORE_BG_WRITE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

?>
<div id="blockFormulaire">
	<form method="post" name="formulaire" action="index.php?comp=bg_write&amp;task=process">
	
<h1>Informations</h1><h4> &nbsp</h4>
<ul>
	<li><b>WOWID :</b> <?php echo $bg['wow_id'] ?></li>
	<li><b>Nom :</b> <?php echo $bg['name'] ?></li>
	<li><b>Date de création :</b> <?php echo date('d/m à H\hi',$bg['creation_time']) ?></li>
	<li><b>Dernière modification :</b> <?php echo date('d/m à H\hi',$bg['last_edit_time']) ?></li>
	<li><label>Statut : <?php echo $bg['statut'] ?></label></li>
</ul>	
	<?php
	if ($bg['statut']=='EN_REDACTION') echo '<a href="index.php?comp=bg_write&amp;task=ask_valid&amp;guid='.$bg['guid'].'">Demander la validation de ce background</a>';
	?>

	

	
<h1>Rédigez votre background</h1><h4> &nbsp</h4><br />
		<?php include('./inc/bbcode.html.php'); ?>	
	<label for="message">Background :</label>
	<div class="topic_top"></div>
<div class="topic_middle">
	<textarea name="message" id="message" rows="100" cols="100"><?php echo stripslashes(htmlspecialchars($bg['background'])) ?></textarea><br />
</div><div class="topic_bottom"></div>	
	<input type="hidden" name="guid" value="<?php echo $bg['guid'] ?>" />
	<br />
	<p>
		Pour que votre background ait plus de chance d'être validé, vous feriez mieux d'aller corriger toutes vos fautes sur <a href="http://bonpatron.com" onclick="window.open(this.href); return false;">http://bonpatron.com</a>.
	</p>
	<br /><input type="submit" value="Valider"/><br /><br />
	
	</form>
</div>
<?php
require_once('./templates/'.$link_style.'bottom.php');
?>