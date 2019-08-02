<?php
defined( '_VALID_CORE_BUGTRACKER' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if($secureObject->verifyAuthorization('FO_BUGTRACKER_ADD')==TRUE)
echo '<div style="float:right;"><a href="./index.php?comp=bugtracker_write">[ Signaler un bug ]</a></div>';
?>
<div id="blockFormulaire">
	<h1>Recherche</h1><h4> &nbsp; </h4>
<div class="topic_top"></div>
<div class="topic_middle">
<div style="margin:0px 40px 0px 50px;">
	<form id="filtre" method="post" action="./index.php?comp=bugtracker&amp;task=search">
Titre ou Description :
			<input type="text" name="form_texte" id="form_texte" size="60" maxlength="50" value="<?php echo $_SESSION['search_texte'] ?>"/>
<br />De :
			<input type="text" name="form_from" id="form_from" size="30" maxlength="25" value="<?php echo $_SESSION['search_from'] ?>"/>
<br />Catégorie :
			<select name="form_cat" onchange="this.form.submit();">
				<option value="0">--------</option>
				<?php
				foreach($listcat as $cat){
					if($cat->btcid==$_SESSION['search_cat']){
						echo '<option value="'.$cat->btcid.'" selected="selected">'.stripslashes(htmlspecialchars($cat->name)).'</option>';
					}
					else{
						echo '<option value="'.$cat->btcid.'">'.stripslashes(htmlspecialchars($cat->name)).'</option>';
					}
				}
				?>
           </select>
<br />Etat :
			<select name="form_etat" onchange="this.form.submit();">
				<option value="0" <?php if(empty($_SESSION['search_etat'])) echo 'selected="selected"' ?>>--------</option>
				<option value="1" <?php if($_SESSION['search_etat']==1) echo 'selected="selected"' ?>>Ouvert</option>
				<option value="2" <?php if($_SESSION['search_etat']==2) echo 'selected="selected"' ?>>Résolu</option>
				<option value="3" <?php if($_SESSION['search_etat']==3) echo 'selected="selected"' ?>>Bug du core</option>
				<option value="4" <?php if($_SESSION['search_etat']==4) echo 'selected="selected"' ?>>Bug de script</option>
           </select>
		<br /><br /><br />
		<input type="submit" name="submit" value="Envoyer"/><br />
		<?php
		unset($_SESSION['search_texte']);
		unset($_SESSION['search_from']);
		unset($_SESSION['search_cat']);
		unset($_SESSION['search_etat']);
		?>
	</form>
</div>
</div>
</div><div class="topic_bottom"></div>
<?php

if(!empty($bugs)){
	displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=bugtracker".$link_select."&amp;start=", 30);
echo '<br />';
	?>

	<?php
	echo '
	<table class="tableau">	
	<thead><tr>
		<th width="15%">Catégorie</th>
		<th width="40%">Titre</th>
		<th width="10%">De</th>
		<th width="15%">Créé le</th>
		<th width="15%">Réglé le</th>
		<th width="5%">Etat</th>
	</tr></thead>
	<tbody>
	';
	
	foreach($bugs as $bug){
		if($bug->bt_etat==0){$img_etat = '<img src="./templates/'.$link_style.'/ico/bt_nok.png" align="top" alt="Non résolu"/>';}
		else {$img_etat = '<img src="./templates/'.$link_style.'/ico/bt_ok.png" align="top" alt="Résolu"/>';}
		
		echo '
		<tr class="tr">
			<td>'.stripslashes(htmlspecialchars($bug->bt_categorie)).'</td>
			<td class="alignleft"><a href="./index.php?comp=bugtracker_view&amp;select='.$bug->btid.'">'.stripslashes(htmlspecialchars($bug->bt_name)).'</a></td>
			<td><a href="index.php?comp=profil&amp;select='.$bug->bt_from.'">'.$bug->pseudo.'</a></td>
			<td>'.format_time($bug->bt_time_create).'</td>
			<td>'.format_time($bug->bt_time_end).'</td>
			<td><center>'.$img_etat.'</center></td>
		</tr>
		';
	}
	echo '</tbody></table><br />';
displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=bugtracker".$link_select."&amp;start=", 30);

}
else{
	echo "Aucun bug pour le moment";
}

require_once('./templates/'.$link_style.'bottom.php');
?>