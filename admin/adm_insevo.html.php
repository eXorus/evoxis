<?php
defined( '_ADM_VALID_CORE_INSEVO' ) or die( 'Restricted access' );



echo '<div class="onglet">Onglet: ';
if(!empty($_GET['type']) || $_GET['type']=='OK'){
	echo '<a href="./index.php?comp=insevo">Tous</a> ¤ <span class="active">OK</span> ¤ <a href="./index.php?comp=insevo&type=NOK">NOK</a> ¤ <a href="./index.php?comp=insevo&type=WAIT">WAIT</a>';
}
elseif(!empty($_GET['type']) || $_GET['type']=='NOK'){
	echo '<a href="./index.php?comp=insevo">Tous</a> ¤ <a href="./index.php?comp=insevo&type=OK">OK</a> ¤ <span class="active">NOK</span> ¤ <a href="./index.php?comp=insevo&type=WAIT">WAIT</a>';
}
elseif(!empty($_GET['type']) || $_GET['type']=='WAIT'){
	echo '<a href="./index.php?comp=insevo">Tous</a> ¤ <a href="./index.php?comp=insevo&type=OK">OK</a> ¤ <a href="./index.php?comp=insevo&type=NOK">NOK</a> ¤ <span class="active">WAIT</span>';
}	
else{
	echo '<span class="active">Tous</span> ¤ <a href="./index.php?comp=insevo&type=OK">OK</a> ¤ <a href="./index.php?comp=insevo&type=NOK">NOK</a> ¤ <a href="./index.php?comp=insevo&type=WAIT">WAIT</a>';
}		
echo '</div>';

	
if(!empty($rows)){
	displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=insevo&start=", 30);
		
		
	echo '<table class="mainTab">
	<thead>
		<th>Login</th>
		<th>Date de création</th>
		<th>Date de validation</th>
		<th>Etat</th>
		<th>Commentaires</th>
	</thead>
	<tbody>';
	foreach($rows as $row){
		echo '<tr>
		<td><a href="index.php?comp=insevoFocus&select='.$row->insevo_id.'">'
			.htmlspecialchars(stripslashes($row->login)).'</a></td>
		<td>'.format_time($row->time_creation).'</td>
		<td>'.format_time($row->time_validation).'</td>
		<td>'.$row->state.'</td>
		<td>'.htmlspecialchars(stripslashes(substr($row->comment,0, 25))).'</td>  
		</tr>';
	}
	echo '</tbody></table>';
	
	displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=insevo&start=", 30);
}
else{
	echo "Aucun enregistrements";
}


?>