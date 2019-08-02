<?php
defined( '_ADM_VALID_CORE_GUILDS' ) or die( 'Restricted access' );


echo '<table class="mainTab"><thead><th>GUILDID</th><th>Nom</th><th>Leader</th><th>Date de création</th><th>Dernière édition</th></thead><tbody>';
if(!empty($rows)){
	foreach($rows as $row){
		echo '
		<tr bgcolor="'.switchcolor().'">
			<td>#'.$row->guildid.'</td>
			<td><a href="./index.php?comp=guildsFocus&select='.$row->guildid.'">'.htmlspecialchars(stripslashes($row->name)).'</a></td>
			<td>'.htmlspecialchars(stripslashes($row->leader)).'</td>			
			<td>'.$row->creation_time.'</td>
			<td>'.$row->last_edit_time.'</td>
		</tr>';
	}
}else{
	echo '<tr><td colspan="6"><center>Aucune demande de validation de guilde</center></td></tr>';
}
echo '</tbody></table>';
?>