<?php
defined( '_VALID_CORE_BG_LIST' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

$start = intval($_GET['start']);


if(!empty($backgrounds)){

	//Favourite
	echo '<h2>Coup de Coeur des MJs</h2><ul>';
		foreach($background_fav as $bgfav){
			echo '<li><a href="./index.php?comp=bg_show&amp;guid='.$bgfav->guid.'">'.stripslashes(htmlspecialchars($bgfav->name)).'</a> 
			par <a href="./index.php?comp=profil&amp;select='.$bgfav->favourite_by.'">'.stripslashes(htmlspecialchars($bgfav->mj)).'</a> 
			le '.format_time($bgfav->favourite_date).'
			</li>';
		}
	echo '</ul>';

displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=bg_list".$link_sort."&amp;start=", 30);
echo '<br />';
		
	echo '
	<table class="tableau">	
	<thead>
		<th width="15%">Nom 	
			<a href="./index.php?comp=bg_list&amp;sort=name;ASC">
				<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC"/>
			</a>
			<a href="./index.php?comp=bg_list&amp;sort=name;DESC">
				<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC"/>
			</a>
		</th>
		<th width="12%">Race 
			<a href="./index.php?comp=bg_list&amp;sort=race;ASC">
				<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC"/>
			</a>
			<a href="./index.php?comp=bg_list&amp;sort=race;DESC">
				<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC"/>
			</a>
		</th>
		<th width="13%">Classe 
			<a href="./index.php?comp=bg_list&amp;sort=class;ASC">
				<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC"/>
			</a>
			<a href="./index.php?comp=bg_list&amp;sort=class;DESC">
				<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC"/>
			</a>		
		</th>
		<th width="15%">Création
			<a href="./index.php?comp=bg_list&amp;sort=creation_time;ASC">
				<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC"/>
			</a>
			<a href="./index.php?comp=bg_list&amp;sort=creation_time;DESC">
				<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC"/>
			</a>		
		</th>
		<th width="15%">Edition
			<a href="./index.php?comp=bg_list&amp;sort=last_edit_time;ASC">
				<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC"/>
			</a>
			<a href="./index.php?comp=bg_list&amp;sort=last_edit_time;DESC">
				<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC"/>
			</a>
		</th>
		<th width="15%">Statut
			<a href="./index.php?comp=bg_list&amp;sort=statut;ASC">
				<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC"/>
			</a>
			<a href="./index.php?comp=bg_list&amp;sort=statut;DESC">
				<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC"/>
			</a>
		</th>
		<th width="25%">Vote
			<a href="./index.php?comp=bg_list&amp;sort=vote;ASC">
				<img src="./templates/'.$link_style.'/ico/uparrow.png" title="Trier ASC" alt="Trier ASC"/>
			</a>
			<a href="./index.php?comp=bg_list&amp;sort=vote;DESC">
				<img src="./templates/'.$link_style.'/ico/downarrow.png" title="Trier DESC" alt="Trier DESC"/>
			</a>
		</th>
	</thead>
	<tbody>
	';
	
	foreach($backgrounds as $bg){	
	
		if($bg->nb_vote==5){
			$img_vote = '
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			';
		}
		else if ($bg->nb_vote>4){
			$img_vote = '
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			';
		}
		else if ($bg->nb_vote>3){
			$img_vote = '
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			';
		}
		else if ($bg->nb_vote>2){
			$img_vote = '
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			';
		}
		else if ($bg->nb_vote>1){
			$img_vote = '
			<img src="./templates/'.$link_style.'/ico/starfull.png" title="Star Full" alt="Star Full"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			';
		}
		else{
			$img_vote = '
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			<img src="./templates/'.$link_style.'/ico/starempty.png" title="Star Empty" alt="Star Empty"/>
			';
		}
		if(empty($bg->vote)){
			$v = '<a href="./index.php?comp=bg_show&amp;guid='.$bg->guid.'">Votez !</a>';
		}
		else{
			$v = '';
		}
		
		if ($bg->statut=='EN_ATTENTE') $statut = "En Attente";
		elseif($bg->statut=='EN_REDACTION') $statut = "En Rédaction";
		elseif($bg->statut=='INDISPONIBLE') $statut = "Indisponible";
		elseif($bg->statut=='NON_VALIDE') $statut = "Non Valide";
		else $statut = "Valide";
		
		echo '
		<tr>
			<td><center><a href="./index.php?comp=bg_show&amp;guid='.$bg->guid.'">'.stripslashes(htmlspecialchars($bg->name)).'</a></center></td>
			<td><center><img src="./templates/'.$link_style.'/ico_wow/'.$bg->race.'-0.gif" title="Race: '.print_race($bg->race).'" alt="Race: '.print_race($bg->race).'"/></center></td>
			<td><img src="./templates/'.$link_style.'/ico_wow/'.$bg->class.'.gif" title="Classe: '.print_class($bg->class).'" alt="Classe: '.print_class($bg->class).'"/></td>
			<td>'.format_time($bg->creation_time).'</td>
			<td>'.format_time($bg->last_edit_time).'</td>
			<td><center>'.$statut.'</center></td>
			<td><center>'.$img_vote.$v.'</center></td>
		</tr>
		';
	}
	echo '</tbody></table><br />';
	
	
displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=bg_list".$link_sort."&amp;start=", 30);

}
else{
	echo "Aucun membre";
}

require_once('./templates/'.$link_style.'bottom.php');
?>