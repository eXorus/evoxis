<?php
defined( '_VALID_CORE_INSEVO_ATTENTE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($insevo_attente)){
	echo '
<h1>Attention</h1><h4> &nbsp; </h4><br />
	<p>
	<i>
		Si votre inscription a été acceptée, et que vous n\'avez pas reçu le mail dans les heures qui suivent en ayant fait attention de regarder dans vos SPAMs, courriers indésirables, alors contactez un MJ qui vous renverra vos mots de passe par e-mail de facon manuelle. Merci.
	</i>
	</p>

<h1>Liste des demandes de compte</h1><h4> &nbsp; </h4><br />
<ul>
	<li>Nombre de demandes d\'inscription: <strong>'.$stats_nb_insevo.'</strong> ('.$stats_p_accept.'% acceptées)</li>
	<li>Temps moyen entre la demande et la validation: <strong>'.$stats_moyenne_time_validation.'</strong></li>
</ul><br />
	<table class="tableau">
	<thead>
		<th>Login</th>
		<th>Demande</th>
		<th>Validation</th>
		<th>Résultat</th>
		<th>Commentaire</th>
	</thead>
	<tbody>
	';

	foreach($insevo_attente as $value){
	
		if($value->state=='NOK') $state = '<font color="red">Refusé</font>';
		elseif($value->state=='OK') $state = '<font color="green">Accepté</font>';
		elseif($value->state=='WAIT') $state = 'En Attente';
		else $state = 'What??';
		
		echo '<tr class="tr">
		<td>'.htmlspecialchars(stripslashes($value->login)).'</td>
		<td>'.format_time($value->time_creation).'</td>
		<td>'.format_time($value->time_validation).'</td>
		<td><center>'.$state.'</center></td>
		<td>'.htmlspecialchars(stripslashes($value->comment)).'</td></tr>';
	}

	echo '</tbody></table>';
}
else{
	echo 'Aucune validation de compte en cours depuis 1 semaine';

}

require_once('./templates/'.$link_style.'bottom.php');

?>