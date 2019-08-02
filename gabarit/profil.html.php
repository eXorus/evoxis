<?php
defined( '_VALID_CORE_PROFIL' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>
<div id="onglets"><center>
<table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">
<a href="./index.php?comp=profil"><b>Afficher mon profil</b></a> | <a href="./index.php?comp=profil_account">Modifier mon profil</a> | <a href="./index.php?comp=profil_settings">Réglages</a>
</td><td class="onglet_right"></td></tr></table>
</center>
</div>
<h1><?php echo stripslashes(htmlspecialchars($profil['pseudo'])) ?></h1>

<div id="blockFormulaire">
<br />
<div class="topic_top"></div>
<div class="topic_middle"><div class="newscontenu">
<br />
<table class="tableau">
	<thead>
		<tr>
			<th>Avatar</th>
			<th>Informations sur le compte</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="avatar">
				<?php echo $link_avatar;?>
			</td>
			<td class="profil">
				<label><i><font color="#990000">Identifiant :</font></i> <?php echo stripslashes(htmlspecialchars($profil['username'])) ?></label>
				<label><i><font color="#990000">Groupe : </font></i><?php foreach($groups as $group){echo ''.$group->name.'';} ?></label>
				<label><i><font color="#990000">User-ID :</font></i> <?php echo $profil['uid'] ?></label>
				<label><i><font color="#990000">WoW-ID :</font></i> <?php echo $profil['wow_id'] ?></label>
				<label><i><font color="#990000">Template :</font></i> <?php echo $profil['template'] ?></label>
				<label><i><font color="#990000">Signature :</font></i></label><?php echo stripslashes(htmlspecialchars($profil['signature'])) ?><br /><br />
			</td>
		</tr>
	</tbody>
</table>

<table class="tableau">
	<thead>
		<tr>
			<th>Informations personnelles</th>
			<th>Contact</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
				<label><i><font color="#990000">Pseudo :</font></i> <?php echo stripslashes(htmlspecialchars($profil['pseudo'])) ?></label>
				<label><i><font color="#990000">Prénom :</font></i> <?php echo stripslashes(htmlspecialchars($profil['realname'])) ?></label>
				<label><i><font color="#990000">Date de naissance :</font></i> <?php echo $profil['birthday'] ?></label>
				<label><i><font color="#990000">Lieu d'habitation :</font></i> <?php echo stripslashes(htmlspecialchars($profil['lieu'])) ?></label>
				<label><i><font color="#990000">Fuseau :</font></i> <?php echo $form_fuseaux ?></label>
				<label><i><font color="#990000">Sexe :</font></i> <?php echo $sexe ?></label>
			</td>
			<td class="profil">
				<label><i><font color="#990000">E-mail :</font></i> <?php echo $email_view ?></label>
				<label><i><font color="#990000">ICQ :</font></i> <?php echo $profil['icq'] ?></label>
				<label><i><font color="#990000">AIM :</font></i> <?php echo $profil['aim'] ?></label>
				<label><i><font color="#990000">MSN :</font></i> <?php echo $profil['msn'] ?></label>
				<label><i><font color="#990000">Yahoo :</font></i> <?php echo $profil['yahoo'] ?></label>
				<label><i><font color="#990000">Skype :</font></i> <?php echo $profil['skype'] ?></label>

			</td>
		</tr>
	</tbody>
</table>

<table class="tableau">
	<thead>
		<tr>
			<th>Portrait</th>
			<th>Présentation</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="profil">
				<label><?php echo $link_photo;?></label>
			</td>
			<td class="profil">
				<?php echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($profil['presentation'])))) ?>
			</td>
		</tr>
	</tbody>
</table>


<h1>Backgrounds</h1><h4> &nbsp; </h4><br />	
<?php
if(!empty($characters)){
	echo '
	<table class="tableau">	
		<thead><tr>
			<th>Nom</th>
			<th>Race</th>
			<th>Classe</th>
			<th>Création</th>
			<th>Edition</th>
			<th>Statut</th>
			<th>Level</th>
			<th>Note</th>
		</tr></thead>
		<tbody>';
		
	foreach($characters as $character){
	
		if($character->statut=='EN_REDACTION' && $_SESSION['wow_id']==$select){			
			$statut = $character->statut.': 
			<a href="index.php?comp=bg_write&amp;task=ask_valid&amp;guid='.$character->guid.'">Demander la validation de ce background</a>';			
		}
		else{
			$statut = $character->statut;
		}
		
		$img_vote ='';		
		if($character->nb_vote>4){$img_vote .= '<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>';}
		else{$img_vote .='<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>';}
		
		if($character->nb_vote>3){$img_vote .= '<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>';}
		else{$img_vote .='<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>';}
		
		if($character->nb_vote>2){$img_vote .= '<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>';}
		else{$img_vote .='<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>';}
		
		if($character->nb_vote>1){$img_vote .= '<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>';}
		else{$img_vote .='<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>';}
		
		if($character->nb_vote>0){$img_vote .= '<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>';}
		else{$img_vote .='<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>';}
		
		
		if ($character->statut=='EN_ATTENTE') $statut = "En Attente de validation";
		elseif($character->statut=='EN_REDACTION' && $_SESSION['wow_id']==$select) $statut = 'En Rédaction (<a href="index.php?comp=bg_write&amp;task=ask_valid&amp;guid='.$character->guid.'">Demander la validation de ce background</a>)';
		elseif($character->statut=='EN_REDACTION') $statut = "En Rédaction";
		elseif($character->statut=='INDISPONIBLE') $statut = "Vide";
		elseif($character->statut=='NON_VALIDE') $statut = "Non Valide";
		else $statut = "Valide";

		echo '
		<tr class="tr">
			<td><a href="index.php?comp=bg_show&amp;guid='.$character->guid.'">'.$character->name. '</a></td>
			<td><img src="./templates/'.$link_style.'/ico_wow/'.$character->race.'-0.gif" title="Race: '.print_race($character->race).'" alt="'.print_race($character->race).'"/></td>
			<td><img src="./templates/'.$link_style.'/ico_wow/'.$character->class.'.gif" title="Classe: '.print_class($character->class).'" alt="'.print_class($character->class).'"/></td>
			<td>'.format_time($character->creation_time).'</td>
			<td>'.format_time($character->last_edit_time).'</td>
			<td>'.$statut.'</td>
			<td>'.$character->level. '</td>
			<td>'.$img_vote.$v.'</td>
		</tr>
		';
	
	}
	echo '</tbody></table><br />';

}
else{
	echo 'Aucun background de perso sur ce compte.';
}
?>
</div></div><div class="topic_bottom"></div>		
</div>

<?php
require_once('./templates/'.$link_style.'bottom.php');
?>
