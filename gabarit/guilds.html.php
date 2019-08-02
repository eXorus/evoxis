<?php
defined( '_VALID_CORE_GUILDS' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

echo '<h1>Guildes valides</h1><h4> &nbsp; </h4><br />';

if(!empty($guilds_valid)){
	foreach($guilds_valid as $one_guild){
		echo '
				<div class="topic_top"></div><div class="topic_middle">
				<h2>'.stripslashes(htmlspecialchars($one_guild->name)).' 
				&nbsp;&nbsp;&nbsp;<img src="./templates/default/ico/plus.png" title="Montrer les détails" onclick="javascript:affiche(\'g'.$one_guild->guildid.'\');" alt="Montrer les détails"/>
				 / <img src="./templates/default/ico/moins.png" title="Cacher les détails" onclick="javascript:cache(\'g'.$one_guild->guildid.'\');" alt="Cacher les détails"/></h2>
				<h4>
				<b>Création :</b> '.$one_guild->creation_time.'</h4>
				<div id="g'.$one_guild->guildid.'" style="margin-left:10px; margin-right: 30px; visibility: hidden; display: none;">
				<div class="newscontenu">
			';
								
								
				if($one_guild->wowid==$_SESSION['wow_id']){
					//Je suis Guild Master
					echo '<center><a href="./index.php?comp=guilds_bg_write&amp;action=edit&amp;select='.$one_guild->guildid.'">
					<img src="./templates/'.$link_style.'/ico/editer_guilde.png" height="17px" width="120px" align="top" alt="Editer les informations de votre guilde"/>
					</a></center>';
				}
				
				if(!empty($one_guild->leader)){
					echo '<b>Leader : </b><i>'.nl2br(stripslashes(htmlspecialchars($one_guild->leader))).'</i><br /><br />';}
				if(!empty($one_guild->background)){
					echo '<b>Histoire : </b><i>'.nl2br(stripslashes(htmlspecialchars($one_guild->background))).'</i><br /><br />';}
				if(!empty($one_guild->goals)){
					echo '<b>Objectifs : </b><i>'.nl2br(stripslashes(htmlspecialchars($one_guild->goals))).'</i><br /><br />';}
				if(!empty($one_guild->rules)){
					echo '<b>Règlement : </b><i>'.nl2br(stripslashes(htmlspecialchars($one_guild->rules))).'</i><br /><br />';}
				if(!empty($one_guild->hall)){
					echo '<b>Quartier Général : </b><i>'.nl2br(stripslashes(htmlspecialchars($one_guild->hall))).'</i><br /><br />';}
				if(!empty($one_guild->hierarchy)){
					echo '<b>Hiérarchie : </b><i>'.nl2br(stripslashes(htmlspecialchars($one_guild->hierarchy))).'</i><br /><br />';}
				if(!empty($one_guild->accepted)){
					echo '<b>Personnages acceptés : </b><i>'.nl2br(stripslashes(htmlspecialchars($one_guild->accepted))).'</i><br /><br />';}
				
				if($one_guild->members_view==1){
					echo '<b>Membres : </b><i>'.$one_guild->membres.'</i><br />';
				}
				echo '<div class="blockPostEdit"><b>Dernière édition :</b> '.$one_guild->last_edit_time.'</div>';
				echo '</div></div></div><div class="topic_bottom"></div>';
	}
}
else{
	echo "Aucune guilde valide pour le moment";
}


?>

<br /><br /><h1>Guildes non valides</h1><h4> &nbsp; </h4><br />
<?php
if(!empty($guilds_invalid)){
	echo '<ul>';
	foreach($guilds_invalid as $one_guild){
		
		if($one_guild->wowid == $_SESSION['wow_id']){
			//Je suis Guild Master
			echo '<li><a href="./index.php?comp=guilds_bg_write&amp;action=edit&amp;select='.$one_guild->guildid.'">'.stripslashes(htmlspecialchars($one_guild->name)).' ('.stripslashes(htmlspecialchars($one_guild->leader)).')</a></li>';
		}
		else{
			echo '<li><b>'.stripslashes(htmlspecialchars($one_guild->name)).'</b> ('.stripslashes(htmlspecialchars($one_guild->leader)).')</li>';
		}	
	}
	echo '</ul>';
}
else{
	echo "Aucune guilde invalide pour le moment";
}


require_once('./templates/'.$link_style.'bottom.php');
?>