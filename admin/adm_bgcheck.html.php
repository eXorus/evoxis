<?php
defined( '_ADM_VALID_CORE_BGCHECK' ) or die( 'Restricted access' );


echo '<table class="mainTab"><thead><th>GUID</th><th>Nom</th><th>Race</th><th>Class</th><th>Date de création</th><th>Dernière édition</th></thead><tbody>';
if(!empty($rows)){
	foreach($rows as $row){
		echo '
		<tr bgcolor="'.switchcolor().'">
			<td>#'.$row->guid.'</td>
			<td><a href="./index.php?comp=bgcheckFocus&select='.$row->guid.'">'.htmlspecialchars(stripslashes($row->name)).'</a></td>
			<td>'.print_race($row->race).'</td>
			<td>'.print_class($row->class).'</td>
			<td>'.format_time($row->creation_time).'</td>
			<td>'.format_time($row->last_edit_time).'</td>
		</tr>';
	}
}else{
	echo '<tr><td colspan="6"><center>Aucune demande de validation</center></td></tr>';
}
echo '</tbody></table>';
?>