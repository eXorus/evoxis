<?php
defined( '_ADM_VALID_CORE_GROUPS' ) or die( 'Restricted access' );


function displayGroups(){
	global $groups, $groups2;	
	
	if(!empty($groups)){	
		
		echo '<div class="onglet">Mode: ';
		if(empty($_GET['mode']) || $_GET['mode']!='edit'){
			echo '<span class="active">Visualisation</span> ¤ <a href="./index.php?comp=groups&mode=edit">Modification</a>';
		}
		else{
			echo '<a href="./index.php?comp=groups">Visualisation</a> ¤ <span class="active">Modification</span>';
		}
		
		echo '</div>		
	<form method="post" action="./index.php?comp=groups&amp;task=process">
		<table class="mainTab">
			<thead>
				<th>ACL</th>';
		foreach($groups2 as $g){
			echo '<th>'.$g->name.' <input type="checkbox" name="g('.$g->gid.')" onclick="cocheTous(this.checked, this.name);" /></th>';
		}
		echo '</thead>
			<tbody style="width: 200px;height: 500px;overflow: scroll;">';
		foreach($groups as $group){
		
			$tab_group = explode(";", $group->groupes);
			
					
			echo '<tr><td><input type="checkbox" name="a('.$group->acl_ID.')" onclick="cocheTous(this.checked, this.name);" /> <span title="'.$group->acl_Description.'">'.$group->acl_Key.'</span></td>';
			
			
			
			foreach($groups2 as $g){
				if($_GET['mode']=="edit"){
					if(in_array($g->name,$tab_group)==TRUE) echo '<td><input type="checkbox" name="ACL_g('.$g->gid.')_a('.$group->acl_ID.')" checked="checked" /></td>';
					else echo '<td><input type="checkbox" name="ACL_g('.$g->gid.')_a('.$group->acl_ID.')" /></td>';
				}
				else{				
					if(in_array($g->name,$tab_group)==TRUE) echo "<td>OK</td>";
					else echo '<td>-</td>';
				}
			}
			
			echo "</tr>";
		}
		echo '</tbody></table><input type="submit" value="Sauvegarder" /><a href="./index.php?comp=groups">Annuler</a></form>';
	}
	else{
		echo "Aucun enregistrement";
	}
}
displayGroups();


?>
<script language="javascript">
function cocheTous(valeur, cible)
{
	var cases = document.getElementsByTagName('input');
	for(var i=1; i<cases.length; i++){
		if(cases[i].type == 'checkbox' && cases[i].name.lastIndexOf(cible) != -1){
				cases[i].checked = valeur;
		}
	}
}

</script>
