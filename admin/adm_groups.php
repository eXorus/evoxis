<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_GROUPS', 1 );




if($_GET['task']=='process'){	
	
	if($secureObject->verifyAuthorization('BO_GROUPS_DELETE')==TRUE && $secureObject->verifyAuthorization('BO_GROUPS_ADD')==TRUE){
		$r1 = $db->Send_Query("TRUNCATE TABLE `exo_security_assign`");	
			
		foreach($_POST as $key => $value){
			
			if(substr_count($key, "ACL_")==1){
				$valeurs = explode('_', $key);
				
				$in = array("(" , ")", "g", "a");
				$out = array("" , "", "", "");
				
				$ValueGrp = str_replace($in, $out, $valeurs[1]);
				$ValueACL = str_replace($in, $out, $valeurs[2]);
				
				$r1 = $db->Send_Query("INSERT INTO exo_security_assign(ass_Type, ass_ACL, ass_cible) VALUES('G','".intval($ValueACL)."','".intval($ValueGrp)."')");
			}
		}
		$msg = message::getInstance('SUCCESS','Droits modifiés', 'index.php?comp=groups');
		
	}
	else{
		$msg = message::getInstance('ERROR','Droits insuffisants pour réattribuer les assignations', 'index.php?comp=groups');
	}	
}
	
$rq = $db->Send_Query("
			SELECT acl.acl_ID, acl.acl_Key, acl.acl_Description, GROUP_CONCAT(DISTINCT g.name ORDER BY g.name SEPARATOR ';') as groupes
			FROM exo_security_ACL acl
			LEFT JOIN exo_security_assign ass ON (ass.ass_Type='G' AND ass_ACL=acl.acl_ID)
			LEFT JOIN exo_groups g ON g.gid = ass.ass_cible
			GROUP BY acl.acl_Key
			ORDER BY acl_Key");
$groups = $db->loadObjectList($rq);

$rq = $db->Send_Query("
			SELECT gid, name
			FROM exo_groups
			ORDER BY access_Level");
$groups2 = $db->loadObjectList($rq);

$result = $db->Send_Query("SELECT COUNT(*) FROM exo_groups");
$ligne = $db->get_row($result);
$Ntotal = $ligne[0];

$_SESSION['BoxStateType'] = "Green";
$_SESSION['BoxStateMsg'] = array ("Listage des $Ntotal groupes OK");

$TitlePage = 'Groupes';
?>
