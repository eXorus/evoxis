<?php
defined( '_VALID_CORE_TROMBINOSCOPE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');
?>
<h1>Trombinoscope</h1><h4> &nbsp; </h4>
<?php

if(!empty($trombi)){
	echo '<table border="0" width="100%"><tr>';
	foreach($trombi as $o){
		if (file_exists("./img/pictures/".$o->id.".".$o->image_extension) && file_exists("./img/pictures/".$o->id."_tb.".$o->image_extension)){
		
			if ($NumImgLigne>=$NbrImgParLigne){echo "</tr><tr>";$NumImgLigne = 0;} 
			 
			echo '<td align="center">
			<a href="./img/pictures/'.$o->id.'.'.$o->image_extension.'" class="lightwindow">
			<img class="trombi" src="./img/pictures/'.$o->id.'_tb.'.$o->image_extension.'"  
			alt="Photo de '.$o->pseudo.'" 
			title="Photo de '.$o->pseudo.'"/>
			</a>
			<br />
			<b><a href="index.php?comp=profil&amp;select='.$o->uid.'" title="Afficher le profil">'.$o->pseudo.'</a></b></td>';
			
			$NumImgLigne++;
		}
	}
	echo '</tr></table>';
}
else{
	echo "Aucune Photo pour le moment";
}

require_once('./templates/'.$link_style.'bottom.php');
?>