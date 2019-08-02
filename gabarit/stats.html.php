 <?php
defined( '_VALID_CORE_STATS' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(file_exists($cache) && filemtime($cache) > $expire){
	readfile($cache);
}
else
{
	
	ob_start(); // ouverture du tampon
	?>
	<h1>Statistiques</h1><h4>Des chiffres ??</h4>
	<?php



	echo "<br /><center><b>Statistiques Générales</b><br />(statistiques sur les personnages connectés durant les 60 derniers jours)</center><br /><br />";

	/* -- RACE -- */
	$alliance=0;
	$horde=0;
		echo "<table class='tableau'>	<tr><th colspan='10'>Races : </th><th colspan='2'>Factions : </th></tr><tr>";
		if(!empty($race)){
			foreach($race as $r){
				echo "<td valign='bottom'> <div class='result' style='height:". 4 * round($r->number)."px; border:1px solid; background-color: #4C60AB;'>
				</div>".round($r->number)." %</td>" ;
				
				if($r->race==1||$r->race==3||$r->race==4||$r->race==7||$r->race==11){
					$alliance=$alliance+$r->number;
				}
				if($r->race==2||$r->race==5||$r->race==6||$r->race==8||$r->race==10){
					$horde=$horde+$r->number;
				}
			}	
			echo "<td valign='bottom'> <div class='result' style='height:". 2 * $alliance."px; border:1px solid; background-color: #4C60AB;'>
			</div>".round($alliance)." %</td>
			<td valign='bottom'> <div class='result' style='height:". 2 * $horde."px; border:1px solid; background-color: #4C60AB;'>
			</div>".round($horde)." %</td>" ;
			echo "</tr><tr>";
			foreach($race as $r){
				$title="";
				if($r->race==1){$title="Humain";}
				elseif($r->race==2){$title="Orc";}
				elseif($r->race==3){$title="Nain";}
				elseif($r->race==4){$title="Elfe de la Nuit";}
				elseif($r->race==5){$title="Mort Vivant";}
				elseif($r->race==6){$title="Tauren";}
				elseif($r->race==7){$title="Gnome";}
				elseif($r->race==8){$title="Troll";}
				elseif($r->race==11){$title="Draenei";}
				elseif($r->race==10){$title="Elfe de Sang";}
				echo"<td><img src='./templates/".$link_style."/ico_wow/".$r->race."-0.gif' title='".$title."'></td>" ;
			}
			echo "<td valign='bottom'><img src='./templates/".$link_style."/ico/alliance.gif' title='Alliance'></td>
			<td valign='bottom'><img src='./templates/".$link_style."/ico/horde.gif' title='Horde'></td>";
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td>";}
		echo "</tr></table><br />";

	/* -- CLASSE -- */

		echo '<table class="tableau"><th colspan="9">Classes : </th><tr>';
		if(!empty($class)){
			foreach($class as $c){
				echo "<td valign='bottom'> <div class='result' style='height:". 4 * round($c->number)."px; border:1px solid; background-color: #4C60AB;'>
				</div>".round($c->number)." %<br /><img src='./templates/".$link_style."/ico_wow/".$c->class.".gif'></td>" ;
				echo"" ;
			}	
			echo "</tr><tr>";
			foreach($class as $c){
				
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td>";}
		echo "</tr></table><br />";

	/* --  GENRE -- */

		echo"<table class='tableau' style='width:50%;'><th colspan = 2 >Sexes : </th><tr>";
		if(!empty($gender)){
			foreach($gender as $g){	
				echo "<td valign='bottom' align = center> <div class='result' style='height:". 2 * round($g->number)."px; width:20%; border:1px solid; background-color: #4C60AB;'>
				</div>".round($g->number)." %</td>" ;
			}
			echo "</tr><tr>";
			foreach($gender as $g){
				if($g->gender==0){$sex="masculins";}
				else{$sex="féminins";}
				echo"<td><b>Personnages ".$sex."</b></td>";
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td>";}
		echo "</tr></table><br />";

	/* --  NIVEAU -- 
		echo"<table class='tableau'><th colspan = 70>Niveaux : </th><tr>";
		if(!empty($level)){
			$i=0;
			foreach($level as $l){
				echo "<td valign='bottom'> <div class='result' style='height:". 100 * round($l->number)."px; border:1px solid; background-color: #4C60AB;'>".round($l->level)."</div></td>" ;
			}	
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td>";}
		echo "</tr></table><br />";
	*/

	/* --  PERSONNAGES -- */
	echo"<br /><br /><center><b>Statistiques sur les personnages</b><br />(statistiques sur tous les personages)</center><br /><br />";
	echo"<table><tr><td style='width:50%;'>";

	/* -- TUEURS  -- */
		echo"<table class='tableau'><th colspan = 3>Personnages ayant tué sans honneur en PVP : </th>";
		if(!empty($tueurs)){
			$i=0;
			foreach($tueurs as $t){
				$i++;
				echo"<tr class='tr'><td style='width:5%;'>".$i."</td><td style='width:15%'><a href='http://www.evoxis.info/index.php?comp=bg_show&amp;guid=".$t->guid."'>".$t->name."</a></td><td>".$t->kill." victimes</td></tr>" ;
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td></tr>";}
		echo "</table><br />";
		
	echo"</td><td style='width:50%'>";

	/* -- FRAGS HONORABLES -- */
		echo"<table class='tableau'><th colspan = 3>Personnages ayant tué avec honneur en PVP : </th>";
		if(!empty($honor)){
			$i=0;
			foreach($honor as $h){
				$i++;
				echo"<tr class='tr'><td style='width:5%'>".$i."</td><td style='width:15%'><a href='http://www.evoxis.info/index.php?comp=bg_show&amp;guid=".$h->guid."'>".$h->name."</a></td><td>".$h->honorable_kills." victoires honorables</td></tr>" ;
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td></tr>";}
		echo "</table><br />";
		
	echo"</td></tr><tr><td style='width:50%'>";
		
	/* -- TUéS  -- */	
		echo"<table class='tableau'><th colspan = 3>Personnages étant morts le plus souvent en PVP : </th>";
		if(!empty($tues)){
			$i=0;
			foreach($tues as $t){
				$i++;
				echo"<tr class='tr'><td style='width:5%'>".$i."</td><td style='width:15%'><a href='http://www.evoxis.info/index.php?comp=bg_show&amp;guid=".$t->guid."'>".$t->name."</a></td><td> Mort ".$t->killed." fois</td></tr>" ;
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td></tr>";}
		echo "</table><br />";
		
	echo"</td><td style='width:50%'>";

	/* -- DERNIER FRAG -- */
		echo"<table class='tableau'><th colspan = 3>Personnages ayant le plus récement fait une victime en PVP : </th>";
		if(!empty($lastkill)){
			$i=0;
			foreach($lastkill as $l){
				$i++;
				echo"<tr class='tr'><td style='width:5%'>".$i."</td><td style='width:15%'><a href='http://www.evoxis.info/index.php?comp=bg_show&amp;guid=".$l->guid."'>".$l->name."</a></td><td>".date('j-F-Y H:i:s', $l->last_kill_date)."</td></tr>" ;
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td></tr>";}
		echo "</table><br />";

	echo"</td></tr></table>";
		
	/* -- ARGENT -- */
		echo"<table class='tableau'><th colspan = 3>Personnages ayant le plus d'or : </th>";
		if(!empty($money)){
			$i=0;
			foreach($money as $m){
				$i++;	
				$pc=$m->money;
				$po=floor($pc/10000);
				$pc= $pc-($po*10000);
				$pa=floor($pc/100);
				$pc=$pc-($pa*100);
				echo"<tr class='tr'><td style='width:5%'>".$i."</td><td style='width:15%'><a href='http://www.evoxis.info/index.php?comp=bg_show&amp;guid=".$m->guid."'>".$m->name."</a></td><td>".$po."<img src='./templates/".$link_style."/ico/gold.png' title='Or'> ".$pa."<img src='./templates/".$link_style."/ico/silver.png' title='Argent'> ".$pc."<img src='./templates/".$link_style."/ico/copper.png' title='Cuivre'></td></tr>" ;
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td></tr>";}
		echo "</table><br />";
		
	/* -- TEMPS JOUE -- */
		echo"<table class='tableau'><th colspan = 3>Personnages ayant joué le plus de temps : </th>";
		if(!empty($totaltime)){
			$i=0;
			foreach($totaltime as $t){
				$i++;
				$duree_secondes = $t->totaltime;
				$duree_jours = floor($duree_secondes/86400);
				$duree_secondes = $duree_secondes - ($duree_jours*86400);
				$duree_heures = floor($duree_secondes/3600);
				$duree_secondes = $duree_secondes - ($duree_heures*3600);
				$duree_minutes = floor($duree_secondes/60);
				$duree_secondes = $duree_secondes - ($duree_minutes*60);
				echo"<tr class='tr'><td style='width:5%'>".$i."</td><td style='width:15%'><a href='http://www.evoxis.info/index.php?comp=bg_show&amp;guid=".$t->guid."'>".$t->name."</a></td><td>".$duree_jours."j ".$duree_heures."h ".$duree_minutes."min ".$duree_secondes."s</td></tr>" ;
			}
		}
		else{echo "<tr><td >Statistique manquante pour le moment</td></tr>";}
		echo "</table><br />";

	/* -- GUILDES -- */
	echo "<br /><br /><center><b>Statistiques sur les guildes</b><br />(statistiques sur tous membres actifs de toutes les guildes)</center><br /><br />";
	echo '<table   border="1" ><tr><td  ROWSPAN="3" style="width: 50%;">';

	/* -- DATE DE CREATION -- */
		echo '<table class="tableau"><th colspan="3">Classement d\'ancienneté : </th>';
		if(!empty($create)){
			$i=0;
			foreach($create as $c){
				$i++;
				$pattern[0] = '/:/';
				$pattern[1] = '/-/';
				$datecrea = preg_replace($pattern, ' ', $c->createdate); //createdate au format : annee-mois-jour heure:minute:seconde > annee mois jour heure minute seconde
				$datecrea = explode(' ',$datecrea);
				$datecrea = mktime($datecrea[3],$datecrea[4],$datecrea[5],$datecrea[1],$datecrea[2],$datecrea[0]);//on passe la date en timestamp
				$duree_secondes = time() - $datecrea;
				$duree_jours = floor($duree_secondes/86400);
				$duree_secondes = $duree_secondes - ($duree_jours*86400);
				$duree_heures = floor($duree_secondes/3600);
				$duree_secondes = $duree_secondes - ($duree_heures*3600);
				$duree_minutes = floor($duree_secondes/60);
				$duree_secondes = $duree_secondes - ($duree_minutes*60);
				echo"<tr class='tr'><td style='width:5%'>".$i."</td><td style='width:15%'>".$c->name."</td><td>".$duree_jours."j ".$duree_heures."h ".$duree_minutes."min ".$duree_secondes."s</td></tr>" ;
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td></tr>";}
		echo "</table><br />";

	echo '</td><td style="width:50%;">';

	/* -- TEMPS JOUE -- */
		echo '<table class="tableau"><th colspan="3">Classement du temps joué des membres actifs : </th>';
		if(!empty($gtotaltime)){
			$i=0;
			foreach($gtotaltime as $g){
				$i++;
				$duree_secondes = $g->totaltime;
				$duree_jours = floor($duree_secondes/86400);
				$duree_secondes = $duree_secondes - ($duree_jours*86400);
				$duree_heures = floor($duree_secondes/3600);
				$duree_secondes = $duree_secondes - ($duree_heures*3600);
				$duree_minutes = floor($duree_secondes/60);
				$duree_secondes = $duree_secondes - ($duree_minutes*60);
				echo"<tr class='tr'><td style='width:5%'>".$i."</td><td style='width:15%'>".$g->name."</td><td>".$duree_jours."j ".$duree_heures."h ".$duree_minutes."min ".$duree_secondes."s</td></tr>" ;
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td></tr>";}
		echo "</table><br />";
		
	echo "</td></tr><tr><td style='width:50%'>";

	/* -- MEMBRES -- */
		echo"<table class='tableau'><th colspan = 3>Classement de taille : </th>";
		if(!empty($members)){
			$i=0;
			foreach($members as $m){
				$i++;
				echo"<tr class='tr'><td style='width:5%'>".$i."</td><td style='width:15%'>".$m->name."</td><td>".$m->members." membres actifs</td></tr>" ;
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td></tr>";}
		echo "</table><br />";

	echo "</td></tr><tr><td style='width:50%'>";
	/* -- ARGENT -- */
		echo"<table class='tableau'><th colspan = 3>Classement de richesse des membres actifs : </th>";
		if(!empty($gmoney)){
			$i=0;
			foreach($gmoney as $m){
				$i++;
				$pc=$m->money;
				$po=floor($pc/10000);
				$pc= $pc-($po*10000);
				$pa=floor($pc/100);
				$pc=$pc-($pa*100);
				echo"<tr class='tr'><td style='width:5%'>".$i."</td><td style='width:15%'>".$m->name."</td><td>".$po."<img src='./templates/".$link_style."/ico/gold.png' title='Or'> ".$pa."<img src='./templates/".$link_style."/ico/silver.png' title='Argent'> ".$pc."<img src='./templates/".$link_style."/ico/copper.png' title='Cuivre'></td></tr>" ;
			}
		}
		else{echo "<tr><td>Statistique manquante pour le moment</td></tr>";}
		echo "</table><br />";

	echo '</td></tr></table>';

	
	$page = ob_get_contents(); // copie du contenu du tampon dans une chaîne
	ob_end_clean(); // effacement du contenu du tampon et arrêt de son fonctionnement

	file_put_contents($cache, $page) ; // on écrit la chaîne précédemment récupérée ($page) dans un fichier ($cache) 
	echo $page ; // on affiche notre page :D 

}

	require_once('./templates/'.$link_style.'bottom.php');
	?>