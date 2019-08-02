<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_MP_VIEW
define( '_VALID_CORE_MP_VIEW', 1 );

$dpid = intval($_GET['dpid']);

$query_mp = "
SELECT D.dpID, D.dpTitle, D.dpUnderTitle, U.pseudo, M.mpID, M.mpDateCreation, M.mpMessage, 
		CAST(GROUP_CONCAT(DISTINCT CONCAT_WS('|', U2.uid, U2.pseudo, P.participe) SEPARATOR ';') AS CHAR) As participants
FROM exo_mp_messages M
LEFT JOIN exo_mp_discussions D ON M.dpID=D.dpID
LEFT JOIN exo_users U ON U.uid=M.uid	
LEFT JOIN exo_mp_participate P ON P.dpID = D.dpID
LEFT JOIN exo_users U2 ON U2.uid = P.uid
WHERE D.dpID = $dpid AND ".$_SESSION['uid']." IN (SELECT uid FROM exo_mp_participate WHERE dpID=D.dpID AND participe=1)
GROUP BY mpID
";

$result_mp = $db->Send_Query($query_mp);
$mps = $db->loadObjectList($result_mp);


if(empty($mps)){
	$msg = message::getInstance('ERROR','Vous n\'avez pas le droit de lire ce message.  ', './index.php?comp=mp');
}

$result = $db->Send_Query("UPDATE exo_mp_participate SET last_msg_vu=(SELECT MAX(mpID) FROM exo_mp_messages WHERE dpID=$dpid) WHERE dpID=$dpid AND uid=".$_SESSION['uid']."");	

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'messagerie';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Messagerie' => 'index.php?comp=mp',
$mps[0]->dpTitle => ''
); 
$ws_name_perso = 'Evoxis v5 - Message privé - '.$view['subject'].' ';
?>
