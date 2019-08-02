<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_MP', 1 );

$start = intval($_GET['start']);

if(!empty($_GET['folder'])){
	$qFolder1 = "
	LEFT JOIN exo_mp_appartient A ON A.dpID = D.dpID
	LEFT JOIN exo_mp_folders F ON F.mfID=A.mfID AND F.mfOwner=".$_SESSION['uid'];
	$qFolder2 = " AND A.mfID=".intval($_GET['folder']);
}

$query_mp = "
	SELECT D.dpID, D.dpTitle, D.dpUnderTitle, 
		CAST(GROUP_CONCAT(DISTINCT CONCAT_WS('|', U.uid, U.pseudo, P.participe) SEPARATOR ';') AS CHAR) As participants, 
		M.mpID, M.mpDateCreation, MU.uid as mpUid, MU.pseudo as mpPseudo, VP.last_msg_vu, 
		(SELECT COUNT(*)-1 FROM exo_mp_messages WHERE exo_mp_messages.dpID=D.dpID) As nb_rep, 
		(SELECT COUNT(*) FROM exo_mp_participate WHERE uid=".$_SESSION['uid']." AND participe=1) As nb_dis		
	FROM exo_mp_discussions D
	$qFolder1
	INNER JOIN exo_mp_participate P ON P.dpID=D.dpID
	INNER JOIN exo_users U ON U.uid=P.uid
	INNER JOIN exo_mp_messages M ON M.mpID=D.last_mpID
	INNER JOIN exo_users MU ON MU.uid=M.uid
	INNER JOIN exo_mp_participate VP ON VP.dpID=D.dpID AND VP.uid=".$_SESSION['uid']."
	WHERE ".$_SESSION['uid']." IN (SELECT uid FROM exo_mp_participate WHERE dpID=D.dpID AND participe=1) $qFolder2
	GROUP BY D.dpID
	ORDER BY M.mpID DESC
	LIMIT $start,$Nmax";
			
$result_mp = $db->Send_Query($query_mp);
$mps = $db->loadObjectList($result_mp);



$rq = $db->Send_Query("
				SELECT F.mfID, F.mfLibelle, COUNT(P.dpID) as nbMP
				FROM exo_mp_folders F
				LEFT JOIN exo_mp_appartient A ON A.mfID=F.mfID
				LEFT JOIN exo_mp_participate P ON P.dpID=A.dpID AND participe=1 AND uid=".$_SESSION['uid']."
				WHERE F.mfOwner=".$_SESSION['uid']."
				GROUP BY F.mfID");
$folders = $db->loadObjectList($rq);

$Ntotal = $mps[0]->nb_dis;

if(empty($Ntotal)){
	$row = $db->get_array($db->Send_Query("SELECT COUNT(*) as nb_dis FROM exo_mp_participate WHERE uid=".$_SESSION['uid']." AND participe=1"));
	$Ntotal = $row['nb_dis'];
}

/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'messagerie';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Messagerie' => 'index.php?comp=mp',
'Mes messages' => ''
);
$ws_name_perso = 'Evoxis v5 - Mes messages';
?>
