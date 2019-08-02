<?php
defined( '_VALID_CORE_EVENTS' ) or die( 'Restricted access' );

$tab_link = explode('&EventSelection=', $_SERVER['REQUEST_URI']);
$link = $tab_link[0];

$link = ($link == '/') ? $link.'index.php?comp=presentation' : $link;
$linkInf = $link.'&amp;EventSelection='.$EventSelectionInf;
$linkSup = $link.'&amp;EventSelection='.$EventSelectionSup;

?>
 <div id="cal">
	<center>
	<table class="calendrier">
	<thead>
		<tr>
			<th colspan="7">
				<a href="<?php echo $linkInf ?>"> &lt; </a>
				<?php 
				echo ucfirst(strftime("%B %Y",mktime(0, 0, 0, $mois, 1, ($annee-565))));
				?>
				<a href="<?php echo $linkSup ?>"> &gt; </a>
			</th>
		</tr>
        <tr>
			<th>Lu</th>
			<th>Ma</th>
			<th>Me</th>
			<th>Je</th>
			<th>Ve</th>
			<th>Sa</th>
			<th>Di</th>
		</tr>
	</thead>
    <tbody>
    <tr>
<?php
if(file_exists($FicCacheEvents) && filemtime($FicCacheEvents) > $ExpireCacheEvents){

	readfile($FicCacheEvents);
}
else
{
ob_start(); // ouverture du tampon	
//Boucle parcourant le calendrier
for($iterCal = 1; $iterCal <= 42; $iterCal++){
	
	//Nouvelle Semaine
	if(($iterCal - 1) % 7 == 0){
		echo '</tr><tr>';
	}
	
	//Données du jour
	if($paramFirstDay <= $iterCal && $annee.$mois.$paramNbDays >= $NumDay){
		//Jour dans le mois
		
		//Si Jour J
		$attributTD = ($NumDay==date('Ymd')) ? 'class="today"' : '';
		
		//Gestion des events
		if(!empty($dataEvents[$NumDay])){
			$attributTD = 'class="celluleevenement" onmouseout="javascript:this.childNodes[1].style.visibility = \'hidden\';" onmouseover="javascript:this.childNodes[1].style.visibility = \'visible\';"';
			
			$printDay  = ' <div style="visibility: hidden;" class="evenement">';
			
			foreach($dataEvents[$NumDay] as $oneEvent){				
				if($oneEvent['type']==1){$typeh6='princ';}
				elseif($oneEvent['type']==2){$typeh6='sec';}
				elseif($oneEvent['type']==3){$typeh6='divers';}
				else{$typeh6='sans';}

				if($oneEvent['type']==1){$titreh6='Event principal';}
				elseif($oneEvent['type']==2){$titreh6='Event secondaire';}
				elseif($oneEvent['type']==3){$titreh6='Divers';}
				else{$titreh6='Sans type';}
				
				$printDay .= '<p>
									<a href="./index.php?comp=forum_topic&amp;select='.$oneEvent['tid'].'&amp;start=0" title="'.$titreh6.'">
										<h6 class="'.$typeh6.'">&gt; '.$oneEvent['titre'].'</h6>
									</a>
									<b>&gt; Date:</b> '.$oneEvent['debut'].' à '.$oneEvent['fin'].'
							</p>
							<p>
								<b>&gt; Description:</b> '.$oneEvent['desc'].'
							</p>
							<br />';
			}
			$printDay .= '</div>';
		}		
		
		echo '<td '.$attributTD.'>'.substr($NumDay, -2).$printDay.'</td>';		
		
		$NumDay++;
	}
	else{
		echo '<td>..</td>';
	}
	

}


?> 
	</tr>
	</table>
	</center>
</div>
<?php
$page = ob_get_contents(); // copie du contenu du tampon dans une chaîne
ob_end_clean(); // effacement du contenu du tampon et arrêt de son fonctionnement

file_put_contents($FicCacheEvents, $page) ; // on écrit la chaîne précédemment récupérée ($page) dans un fichier ($cache) 
echo $page ; // on affiche notre page :D 
}
?>
