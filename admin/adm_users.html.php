<?php
defined( '_ADM_VALID_CORE_USERS' ) or die( 'Restricted access' );

if(!empty($users)){
	displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=users&start=", 30);	
	
	echo '
	<form class="mainForm"  action="./index.php?comp=users" method="post">
		<fieldset>
			<legend>Recherche</legend>
			<p>
				<label for="form_login">Login/Pseudo: </label>
				<input type="text" name="form_login" maxlength="200" value=""/>
			</p>			
			<p>
				<label for="form_group">Groupe: </label>
				<input type="text" name="form_group" maxlength="200" value=""/>
			</p>		
			<p>
				<label for="form_gm">GM Level: </label>
				<input type="text" name="form_gm" maxlength="200" value=""/>
			</p>
			<input type="submit" name="submit" value="Envoyer"/>
		</fieldset>
	</form>	
	<table class="mainTab" id="usersTableFilter">
		<thead>
			<th>ID</th>
			<th>WOWID</th>
			<th>Login</th>
			<th>Pseudo</th>
			<th>Groupe</th>
			<th>GM Level</th>
		</thead>
		<tbody>';
	foreach($users as $user){
				
		echo '<tr>
			<td>#'.$user->uid.'</td>
			<td>#'.$user->wow_id.'</td>
			<td><a href="index.php?comp=usersFocus&select='.$user->uid.'">'.htmlspecialchars(stripslashes($user->username)).'</a></td>
			<td>'.htmlspecialchars(stripslashes($user->pseudo)).'</td>
			<td>'.htmlspecialchars(stripslashes($user->groupName)).'</td>
			<td>'.htmlspecialchars(stripslashes($tabGmLevel[$user->gmlevel])).'</td>
			</tr>';
	}
	echo '</tbody></table>';
	displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=users&start=", 30);	
}
else{
	echo "Aucun enregistrement";
}
?>

