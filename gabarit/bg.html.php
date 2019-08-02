<?php
defined( '_VALID_CORE_BG' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
echo '
<div class="topic_top"></div>
<div class="topic_middle"><div class="newscontenu">
';
echo '<h1>Backgrounds de ce compte :</h1><h4>(Mise à jour : '.format_time(CRON_SYNCHRO_BG).')</h4><br />';

echo '<i>Le temps moyen pour une validation de background est de: '.$stats_moyenne_time_validation.'</i><br /><br />';
	

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
			<td><img src="./templates/'.$link_style.'/ico_wow/'.$character->race.'-0.gif" title="Race: '.print_race($character->race).'" alt="Race: '.print_race($character->race).'"/></td>
			<td><img src="./templates/'.$link_style.'/ico_wow/'.$character->class.'.gif" title="Classe: '.print_class($character->class).'" alt="Race: '.print_class($character->class).'"/></td>
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
	echo 'Aucun background de perso sur ce compte. <br />
	La liste des personnages de votre compte se met à jour toutes les 15 minutes<br />
	';
}
echo '</div></div><div class="topic_bottom"></div>';
require_once('./templates/'.$link_style.'bottom.php');
?>