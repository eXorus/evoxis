<?php
defined( '_VALID_CORE_MP' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');


$onglet =  '
<div id="onglets"><center><table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">
<a href="./index.php?comp=mp_write">Ecrire un message</a> | <a href="./index.php?comp=mp"><b>Mes Messages</b></a></td><td class="onglet_right"></td></tr></table></center></div>';

echo $onglet;


if(empty($_GET['folder'])){
	echo '<h1>Mes Dossiers</h1><ul><li><a href="./index.php?comp=mp"><b>Tous</b> ('.$Ntotal.')</a></li>';
}
else{
	echo '<h1>Mes Dossiers</h1><ul><li><a href="./index.php?comp=mp">Tous ('.$Ntotal.')</a></li>';
}

if(!empty($folders)){
	foreach($folders as $folder){
		
		if($folder->mfID==$_GET['folder']){
			$Ntotal = $folder->nbMP;
			$curFold = '<b>'.stripslashes(htmlspecialchars($folder->mfLibelle)).'</b>';
		}
		else{
			$curFold = stripslashes(htmlspecialchars($folder->mfLibelle));
		}
		
		$currentFolder = ($folder->mfID==$_GET['folder']) ? 'class="new"' : '' ;
				
		echo '
		<li>
			<a href="./index.php?comp=mp&amp;folder='.$folder->mfID.'">'.$curFold.' ('.$folder->nbMP.')</a>
			<a href="./index.php?comp=mp_moderate&amp;action=editFolder&amp;mfID='.$folder->mfID.'"><img src="./templates/'.$link_style.'/ico/modifier.png" alt="Modifier le dossier" /></a>
			<a href="./index.php?comp=mp_moderate&amp;action=deleteFolder&amp;mfID='.$folder->mfID.'"><img src="./templates/'.$link_style.'/ico/delete.gif" alt="Supprimer le dossier" /></a>
		</li>';
		
	}
}
echo '
</ul>
<a href="./index.php?comp=mp_moderate&amp;action=addFolder"><i>Ajouter un dossier</i></a>
';

displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=mp&amp;folder=".$_GET['folder']."&amp;start=", 30);

echo '	
<h1>Mes Messages</h1>

<form id="formod" method="post" action="./index.php?comp=mp_moderate">
<div id="moderate_forum">
<select name="action">
	<option value="0" selected="selected"> &#150; Action &#150; </option>
	<option value="moveFolder">Déplacer dans un dossier</option>
	<option value="delete">Supprimer</option>
	<option value="notread">Marquer Non-Lu</option>
	<option value="read">Marquer Lu</option>
</select>
<input type="submit" value="Valider" />
</div>
	
<table class="tableau">	
<thead><tr>
	<th>Titre du message</th>
	<th>Participants</th>
	<th>Rép.</th>
	<th>Dernier Message</th>
	<th><input type="checkbox" name="all" onclick="cocheTous(this.checked);" /></th>
</tr></thead>
<tbody>
';

if(!empty($mps)){

	foreach($mps as $object){
		
		$new = ($object->last_msg_vu < $object->mpID) ? 'class="new"' : '' ;
		
		//Mef: Participants
		$printPart = '';
		$participants = explode(";",$object->participants);
		foreach ($participants as $participant){
			$part = explode('|', $participant);
			$printPart .= '<a href="./index.php?comp=profil&amp;select='.$part[0].'">';
			$printPart .= ($part[2]==0) ? '<span class="barre">' : '';
			$printPart .= stripslashes(htmlspecialchars($part[1])); 
			$printPart .= ($part[2]==0) ? '</span></a> ' : '</a> ';
		}
		
		echo '
		<tr '.$new.'>
			<td><a href="./index.php?comp=mp_view&amp;dpid='.$object->dpID.'">'.stripslashes(htmlspecialchars($object->dpTitle)).'</a><br />'.stripslashes(htmlspecialchars($object->dpUnderTitle)).'</td>
			<td>'.$printPart.'</td>
			<td>'.$object->nb_rep.'</td>
			<td><a href="./index.php?comp=mp_view&amp;dpid='.$object->dpID.'#mpid'.$object->mpID.'">'.$object->mpDateCreation.'</a><br /><a href="./index.php?comp=profil&select='.$object->mpUid.'">'.stripslashes(htmlspecialchars($object->mpPseudo)).'</a></td>
			<td><input type="checkbox" name="dpID_'.$object->dpID.'" /></td>
		</tr>
		';	
		
	}
}
else{
	echo '
	<tr >
		<td colspan="5">Aucun message pour le moment</td>
	</tr>
	';	
}
echo '</tbody></table></form><br/>';
displayPaginationBar($Ntotal, ($start/$Nmax)+1, "./index.php?comp=mp&amp;folder=".$_GET['folder']."&amp;start=", 30);

echo $onglet;

require_once('./templates/'.$link_style.'bottom.php');
?>


<script language="javascript">
function cocheTous(valeur)
{
var cases = document.getElementsByTagName('input');

	for(var i=1; i<cases.length; i++){
		if(cases[i].type == 'checkbox'){
				cases[i].checked = valeur;
		}
	}
}
</script>
