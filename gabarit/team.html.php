<?php
defined( '_VALID_CORE_TEAM' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

$currentGM = 0;
$currentGP = 0;

if(!empty($mjs_actifs)){	
	foreach($mjs_actifs as $one_mj){
		
		if($one_mj->gmID != $currentGM){
			echo '</tbody></table><br /><br />';
			echo '<div id="nav_forum"><center><table class="nav_forum"><tr><td class="nav_forum_left"></td><td class="nav_forum_center"><div class="pagination">'.$one_mj->gmName.'</div></td><td class="nav_forum_right"></td></tr></table></center></div><center>'.$one_mj->gmDesc.'</center>';
			echo '<table class="tableau"><thead><tr class="tr"><th>Avatar</th><th>Pseudo</th><th>Objectif</th><th>Date de la dernière visite</th><th>En ligne<br/>Site / WoW</th></tr></thead><tbody>';
			$currentGM = $one_mj->gmID;
		}
		
	if(empty($one_mj->avatarID) || empty($one_mj->avatarExtID)) $avatar = '<img src="./img/pictures/0.png" alt="Avatar"/>';
	else $avatar = '<img src="./img/pictures/'.$one_mj->avatarID.'.'.$one_mj->avatarExtID.'" alt="Avatar"/>';
	
	if(!empty($one_mj->online_time)) $online_site = '<img src="./templates/'.$link_style.'/ico/enligne.png" title="En ligne sur le site" alt="En ligne sur le site" />';
	else $online_site = '<img src="./templates/'.$link_style.'/ico/horsligne.png" title="Hors ligne sur le site" alt="Hors ligne sur le site" />';

	if($one_mj->online==1) $online_wow = '<img src="./templates/'.$link_style.'/ico/enligne.png" title="En ligne sur WoW" alt="En ligne sur WoW" />';
	else $online_wow = '<img src="./templates/'.$link_style.'/ico/horsligne.png" title="Hors ligne sur WoW" alt="Hors ligne sur WoW" />';
		
		echo '
		   <tr class="tr_announce">
			   <td>
				<div>'.$avatar.'<br>
				<a href="index.php?comp=profil&amp;select='.$one_mj->uid.'" onmouseover="Tip(\'Profil\')" onmouseout="UnTip()"><img class="bt_box" src="./templates/'.$link_style.'main_pic/forum_profil.png" alt=""></a>
				<a href="index.php?comp=mp_write&amp;to='.urlencode($one_mj->username).'" onmouseover="Tip(\'Ecrire un message privé\')" onmouseout="UnTip()"><img class="bt_box" src="./templates/'.$link_style.'main_pic/forum_messagerie.png" alt=""></a> 
				<a href="index.php?comp=bg&amp;select='.$one_mj->wow_id.'" onmouseover="Tip(\'Backgrounds\')" onmouseout="UnTip()"><img class="bt_box" src="./templates/'.$link_style.'main_pic/forum_bgs.png" alt=""></a>
				</div>
			   </td>
			   <td><a href="index.php?comp=profil&amp;select='.$one_mj->uid.'">'.stripslashes(htmlspecialchars($one_mj->username)).' ('.$one_mj->pseudo.')</a> 
			   <td>'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($one_mj->objectif)))).'</td>
			   <td>'.format_time($one_mj->last_date_connect).'</td>
			   <td>'.$online_site.' / '.$online_wow.'</td>
		   </tr>';
		
	}
}
else{

	echo "Aucun MJ";
}
echo '</tbody></table>';
require_once('./templates/'.$link_style.'bottom.php');
?>



<table>
   <tr>
       <th>Nom</th>
       <th>Age</th>
       <th>Pays</th>
   </tr>

   <tr>
       <td>Carmen</td>
       <td>33 ans</td>
       <td>Espagne</td>
   </tr>
   <tr>
       <td>Michelle</td>
       <td>26 ans</td>
       <td>Etats-Unis</td>
   </tr>
</table>
