<?php
defined( '_VALID_CORE_MEMBRES' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');


if(!empty($_GET['task']) && $_GET['task']=='ig'){

	if(!empty($membres)){

		echo'<br /><center><strong>Il y a <font color="#990000">'.$count_players.'</font> joueurs en ligne.</strong></center><br />';
			
		echo '
		<table class="tableau">	
		<thead><tr>
			<th width="5%">Faction</th>
			<th width="15%">Nom<br />
				<a href="./index.php?comp=membres&amp;task=ig&amp;sort=nom;ASC">
					<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC" />
				</a>
				<a href="./index.php?comp=membres&amp;task=ig&amp;sort=nom;DESC">
					<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC" />
				</a></th>			
			<th width="15%">Race<br />	
				<a href="./index.php?comp=membres&amp;task=ig&amp;sort=race;ASC">
					<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC" />
				</a>
				<a href="./index.php?comp=membres&amp;task=ig&amp;sort=race;DESC">
					<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC" />
				</a></th>
			<th width="15%">Classe<br />
				<a href="./index.php?comp=membres&amp;task=ig&amp;sort=class;ASC">
					<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC" />
				</a>
				<a href="./index.php?comp=membres&amp;task=ig&amp;sort=class;DESC">
					<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC" />
				</a></th>
			<th width="10%">Niveau<br />
				<a href="./index.php?comp=membres&amp;task=ig&amp;sort=level;ASC">
					<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC" />
				</a>
				<a href="./index.php?comp=membres&amp;task=ig&amp;sort=level;DESC">
					<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC" />
				</a></th>
			<th width="20%">Localisation<br /></th>
			<th width="20%">Temps de jeu<br />
				<a href="./index.php?comp=membres&amp;task=ig&amp;sort=time;ASC">
					<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC" />
				</a>
				<a href="./index.php?comp=membres&amp;task=ig&amp;sort=time;DESC">
					<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC" />
				</a></th>
		</tr></thead>
		<tbody>
		';
		
		
		
		foreach($membres as $membre){
		
			$duree_secondes = $membre->totaltime;
			$duree_jours = floor($duree_secondes/86400);
			$duree_secondes = $duree_secondes - ($duree_jours*86400);

			$duree_heures = floor($duree_secondes/3600);
			$duree_secondes = $duree_secondes - ($duree_heures*3600);

			$duree_minutes = floor($duree_secondes/60);
			$duree_secondes = $duree_secondes - ($duree_minutes*60);
			
			if($membre->race==1 || $membre->race==3 || $membre->race==4 || $membre->race==7 || $membre->race==11)
				$faction = 'alliance';
			else $faction = 'horde';

			if($membre->race==1 || $membre->race==3 || $membre->race==4 || $membre->race==7 || $membre->race==11)
				$factionimage = '<img src="./templates/'.$link_style.'/ico/alliance.gif" onmouseover="Tip(\'Alliance\')" onmouseout="UnTip()" alt="Alliance" />';
			else $factionimage = '<img src="./templates/'.$link_style.'/ico/horde.gif" onmouseover="Tip(\'Horde\')" onmouseout="UnTip()" alt="Horde" />';
			
			if($membre->extra_flags==1) $gm = '<img src="./templates/'.$link_style.'/ico/stars.png" onmouseover="Tip(\'Maître du jeu\')" onmouseout="UnTip()" alt="Stars" />';
			else $gm = $factionimage;
			
			$map = get_zone_name($membre->map, $membre->position_x, $membre->position_y);

			echo '
			<tr class="tr">
				<td>'.$gm.'</td>
				<td><a href="index.php?comp=bg_show&amp;guid='.$membre->guid.'" onmouseover="Tip(\'Lire&nbsp;le&nbsp;background\')" onmouseout="UnTip()"><span class="'.$faction.'">'.$membre->name.'</span></a></td>
				<td><img src="./templates/'.$link_style.'/ico_wow/'.$membre->race.'-'.$membre->sex.'.gif" onmouseover="Tip(\''.print_race($membre->race).'\')" onmouseout="UnTip()" alt="Sexe" /></td>
				<td><img src="./templates/'.$link_style.'/ico_wow/'.$membre->class.'.gif" onmouseover="Tip(\''.print_class($membre->class).'\')" onmouseout="UnTip()" alt="Classe" /></td>
				<td>'.$membre->level.'</td>
				<td>'.$map.'</td>
				<td>'.$duree_jours.'j '.$duree_heures.'h '.$duree_minutes.'min '.$duree_secondes.'s</td>
			</tr>
			';
		}
		echo '</tbody></table>';
		echo'<br /><center><a href="index.php?comp=membres&amp;task=ig">[ Actualiser ]</a></center>';
		echo $pagination_content;

	}
	else{

echo "<strong><center>Aucun joueur IG</center></strong>";

	}

}
else{




	if(!empty($membres)){

	if($_GET['task']=='actif'){
		echo'<br /><center><strong>Il y a <font color="#990000">'.$count_actifs.'</font> membres actifs sur Evoxis.</strong></center><br />';
		$Ntotal=$count_actifs;
	}
	else{
		echo'<br /><center><strong>Il y a <font color="#990000">'.$Ntotal.'</font> membres inscrits sur Evoxis.</strong></center><br />';
	}
	


displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=membres&amp;sort=".$_GET['sort']."&amp;task=".$_GET['task']."&amp;start=", 30);
echo '<br />';
			
		echo '
		<br /><table class="tableau">	
		<thead>
			<tr>
				<th width="10%">WoW<br /></th>
				<th width="15%">Site<br />
					<a href="./index.php?comp=membres&amp;task='.$_GET['task'].'&amp;sort=site;ASC">
						<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC" />
					</a>
					<a href="./index.php?comp=membres&amp;task='.$_GET['task'].'&amp;sort=site;DESC">
						<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC" />
					</a>
				</th>
				<th width="10%">Login<br />
					<a href="./index.php?comp=membres&amp;task='.$_GET['task'].'&amp;sort=login;ASC">
						<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC" />
					</a>
					<a href="./index.php?comp=membres&amp;task='.$_GET['task'].'&amp;sort=login;DESC">
						<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC" />
					</a>
				</th>
				<th width="10%">Pseudo<br />
					<a href="./index.php?comp=membres&amp;task='.$_GET['task'].'&amp;sort=pseudo;ASC">
						<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC" />
					</a>
					<a href="./index.php?comp=membres&amp;task='.$_GET['task'].'&amp;sort=pseudo;DESC">
						<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC" />
					</a>		
				</th>
				<th width="10%">Ivo<br />
					<a href="./index.php?comp=membres&amp;task='.$_GET['task'].'&amp;sort=ivo;ASC">
						<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC" />
					</a>
					<a href="./index.php?comp=membres&amp;task='.$_GET['task'].'&amp;sort=ivo;DESC">
						<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC" />
					</a>		
				</th>
				<th width="15%">Profil<br /></th>
				<th width="15%">Background<br /></th>
				<th width="15%">MP<br /></th>
			</tr>
		</thead>
		<tbody>
		';
		
		foreach($membres as $membre){	

			//En ligne Site
			if(!empty($membre->online_time)) $online_site = '<img src="./templates/'.$link_style.'/ico/enligne.png" title="En ligne sur le site" alt="En ligne sur le site" />';
			else $online_site = '<img src="./templates/'.$link_style.'/ico/horsligne.png" title="Hors ligne sur le site" alt="Hors ligne sur le site" />';
		
			//En ligne WoW
			if($tab_online_wow[$membre->wow_id]==1) $online_wow = '<img src="./templates/'.$link_style.'/ico/enligne.png" title="En ligne sur WoW" alt="En ligne sur WoW" />';
			else $online_wow = '<img src="./templates/'.$link_style.'/ico/horsligne.png" title="Hors ligne sur WoW" alt="Hors ligne sur WoW" />';

			echo '
			<tr class="tr">
				<td><center>'.$online_wow.'</center></td>
				<td><center>'.$online_site.'</center></td>
				<td>'.stripslashes(htmlspecialchars($membre->username)).'</td>
				<td>'.stripslashes(htmlspecialchars($membre->pseudo)).'</td>
				<td><center>'.intval($membre->total).'Pts</center></td>
				<td><center>
					<a href="index.php?comp=profil&amp;select='.$membre->uid.'">
						<img src="./templates/'.$link_style.'/ico/bt_profil.png" title="Consulter le profil" alt="Consulter le profil" />
					</a>
					</center>
				</td>
				<td><center>
					<a href="index.php?comp=bg&amp;select='.$membre->wow_id.'">
						<img src="./templates/'.$link_style.'/ico/bgs.png" title="Consulter les backgrounds" alt="Consulter les backgrounds" />
					</a>
					</center>
				</td>
				<td><center>
					<a href="index.php?comp=mp_write&amp;to='.$membre->uid.'">
						<img src="./templates/'.$link_style.'/ico/bt_mp.png" title="Ecrire un message privé" alt="Ecrire un message privé" />
					</a>
					</center>
				</td>
			</tr>
			';
		}
		echo '</tbody></table><br />';
		

		
displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=membres&amp;sort=".$_GET['sort']."&amp;task=".$_GET['task']."&amp;start=", 30);
echo '<br />';
		
	}
	else{
		echo 'Aucun membre';
	}
}
	
require_once('./templates/'.$link_style.'bottom.php');
?>