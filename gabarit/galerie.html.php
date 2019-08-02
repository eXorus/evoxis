<?php
defined( '_VALID_CORE_GALERIE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>
<h1>Fan Art</h1><h4> &nbsp; </h4>
<?php

if(!empty($galeries)){
	foreach($galeries as $o){
		if (file_exists("./img/pictures/".$o->id.".".$o->image_extension) && file_exists("./img/pictures/".$o->id."_tb.".$o->image_extension)){
		
			if(empty($pseudoActuel) || $o->pseudo != $pseudoActuel){
				echo "<table class='tableau'><tr><th>".$o->pseudo."</th></tr></table>";
				$pseudoActuel = $o->pseudo;
			}
			
			echo '<a href="./img/pictures/'.$o->id.'.'.$o->image_extension.'" class="lightwindow">
					<img class="fanart" src="./img/pictures/'.$o->id.'_tb.'.$o->image_extension.'" alt="Création Graphique par '.$o->pseudo.'"	title="Création Graphique par '.$o->pseudo.'"/>
					</a>&nbsp;<a href="#" title="Supprimer" onclick="confirm(&quot;Supprimer l\'image ?&quot;)">[x]</a>
									
			';
				
		}
	}
}
else{
	echo "Aucune Création Graphique pour le moment";
}
require_once('./templates/'.$link_style.'bottom.php');
?>