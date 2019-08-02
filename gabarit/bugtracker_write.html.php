<?php
defined( '_VALID_CORE_BUGTRACKER_WRITE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

?>
<div id="blockFormulaire">
<form id="post" method="post" name="formulaire" action="index.php?comp=bugtracker_write&amp;task=process">

	<fieldset><h1>Signaler un bug</h1><h4> &nbsp; </h4><br />
		<?php include('./inc/bbcode.html.php');?>

	<label>Categorie :</label><select name="categorie">
             <option value="">--------</option>
				<?php
			
				foreach($listcat as $cat){
					if($cat->btcid==$bugToEdit['btcid']){
						echo '<option value="'.$cat->btcid.'" SELECTED>'.stripslashes(htmlspecialchars($cat->name)).'</option>';
					}
					else{
						echo '<option value="'.$cat->btcid.'">'.stripslashes(htmlspecialchars($cat->name)).'</option>';
					}
				}
				?>
           </select>
	<label for="titre">Titre :</label>
		<input type="text" name="titre" id="titre" size="80" maxlength="70" value="<?php echo stripslashes($bugToEdit['bt_name']); ?>"/><br />	
	<label for="message">Message : </label>
<div class="topic_top"></div>
<div class="topic_middle">
	<textarea name="message" id="message" rows="20" cols="95"><?php echo stripslashes($bugToEdit['bt_description']); ?></textarea><br />	
</div><div class="topic_bottom"></div>	
	<label for="link">Lien vers JudgeHype :</label>
		<input type="text" name="link" id="link" size="80" maxlength="200" value="<?php echo stripslashes($bugToEdit['bt_link']); ?>"/><br />	
		<i>Merci de poster un lien vers le site <a href="http://worldofwarcraft.judgehype.com/" onclick="window.open(this.href); return false;">http://worldofwarcraft.judgehype.com/</a> pour identifier plus rapidement la quête, l'objet ou le NPC concerné par le bug.</i><br /><br />		
		
	</fieldset>
	<input type="hidden" name="btid" value="<?php echo $bugToEdit['btid']; ?>"/>	
	
	<input type="submit" name="submit" value="Envoyer"/>
		
</form>
</div>
<br /><a href="./index.php?comp=bugtracker">[ Retour ]</a>
<?php
require_once('./templates/'.$link_style.'bottom.php');
?>