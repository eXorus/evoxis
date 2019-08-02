<?php
defined( '_ADM_VALID_CORE_ASK' ) or die( 'Restricted access' );

$onglet = '<div><strong>Onglet:</strong> <a href="./index.php?comp=insevo&type=OK">OK</a> | <a href="./index.php?comp=insevo&type=NOK">NOK</a> | <a href="./index.php?comp=insevo&type=WAIT">WAIT</a></div>';


	
if(!empty($rows)){
	displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=ask&start=", 30);
		
		
	echo '
	
	
	<form class="mainForm"  action="./index.php?comp=ask" method="post">
	<fieldset>
		<legend>Recherche</legend>
		<p>
			<label for="form_type">Type: </label>
			<input type="text" name="form_type" maxlength="200" value=""/>
		</p>			
		<p>
			<label for="form_etat">Etat: </label>
			<input type="text" name="form_etat" maxlength="200" value=""/>
		</p>		
		<p>
			<label for="form_assign">Assigné à: </label>
			<input type="text" name="form_assign" maxlength="200" value=""/>
		</p>
		<input type="submit" name="submit" value="Envoyer"/>
	</fieldset>
	</form>	
	
	
	<table class="mainTab">
	<thead>
		<th>Type</th>
		<th>Cible</th>
		<th>Etat</th>
		<th>Date d\'ouverture</th>
		<th>Date de validation</th>
		<th>Date d\'assignation</th>
		<th>Date de cloture</th>
		<th>Date de refus</th>
		<th>Assigné à</th>
	</thead>
	<tbody>';
	foreach($rows as $row){
		if (empty($row->cible)) {$cible = "?";}
		else {$cible = htmlspecialchars(stripslashes($row->cible));}
		
		echo '<tr>
		<td>'.htmlspecialchars(stripslashes($row->acTitle)).'</td>
		<td><a href="index.php?comp=askFocus&select='.$row->aID.'">'
			.$cible.'</a></td>
		<td>'.$row->aState.'</td>
		<td>'.format_time($row->aDateOpen).'</td>
		<td>'.format_time($row->aDateValidate).'</td>
		<td>'.format_time($row->aDateAssign).'</td>
		<td>'.format_time($row->aDateDone).'</td>
		<td>'.format_time($row->aDateRefused).'</td>
		<td>'.$row->aAssignTo.'</td>
		</tr>';
	}
	echo '</tbody></table>';
	
	displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=ask&start=", 30);
}
else{
	echo "Aucun enregistrements";
}


?>