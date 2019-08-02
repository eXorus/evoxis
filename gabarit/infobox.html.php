<?php
defined( '_VALID_CORE_INFOBOX' ) or die( 'Restricted access' );

if(file_exists($cacheInfobox) && filemtime($cacheInfobox) > $expireInfobox){
	readfile($cacheInfobox);
}
else
{
	
	ob_start(); // ouverture du tampon

	if(!empty($connecte_membres)){
		$tableMembres = '';
		foreach($connecte_membres as $object){
		
			$tableMembres .= '<a href="index.php?comp=mp_write&amp;to='.$object->pseudo.'" title="Ecrire un Message privé">';
			$tableMembres .= '<img src="./templates/'.$link_style.'/ico/ico_mp_tooltip.png" alt="MP"/>';
			$tableMembres .= '&nbsp;'.$object->pseudo.'<br /></a>';
		}
		$tableMembres .= '';
	}
		
	//Serveur : '.$state_serveur.'	
		
	echo '
						<a href="../inc/map/index.php" onclick="window.open(this.href, \'Carte des joueurs\', \'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbar=no, resizable=no, width=966, height=732\');return false;">Carte GPS</a><br />
						<a href="index.php?comp=membres">Membres : <b>'.$count_members.'</b></a><br />
						<span class="tooltip"><a href="index.php?comp=membres&amp;task=&amp;sort=site;DESC">En ligne : <b>'.$nb_membres.'</b><em>'.$tableMembres.'</em></a><br /></span>
						<a href="index.php?comp=membres&amp;task=actif">Actifs : <b>'.$count_actifs.'</b></a> (15&nbsp;j.)<br />
						<a href="index.php?comp=stats">Statistiques</a><br />
						
	';

	
	$page = ob_get_contents(); // copie du contenu du tampon dans une chaîne
	ob_end_clean(); // effacement du contenu du tampon et arrêt de son fonctionnement

	file_put_contents($cacheInfobox, $page) ; // on écrit la chaîne précédemment récupérée ($page) dans un fichier ($cache) 
	echo $page ; // on affiche notre page :D 

}	
?>