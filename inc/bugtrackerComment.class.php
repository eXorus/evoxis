<?php
class bugtrackerComment{
	var $id;
	var $bug;
	var $comment;
	var $from;
	var $time_create;

	/*	##########
		Fonction d'ajout d'un nouveau commentaire de bug
		##########
	*/
	function add(){
		global $db;
	
		$query = "INSERT INTO exo_bugtracker_commentaires (btcid, btid, comment, `from`, time_create) 
			VALUES(NULL,'".$this->bug."','".$this->comment."','".$this->from."','".$this->time_create."')";
		$result = $db->Send_Query($query);
		$this->id = $db->last_insert_id();
	
		//Spyvo
		require_once("./inc/spyvo.php");
		$spyvo = new spyvo();
		$spyvo->spyvo_write('INFO', $this->from, 'BugTracker', 'Add Comment;ID Comment='.$this->id.';ID Bug='.$this->bug);
	
		//Indices
		update_ivo('nb_bug');
		
		return $this->id;	
	}
	

	/*	##########
		Fonction qui récupère les commentaires de  bugs
		##########
	*/
	function getComments(){
		global $db;
				
		$rq = $db->Send_Query("
					SELECT btcid, comment, uid, pseudo, time_create
					FROM exo_bugtracker_commentaires, exo_users
					WHERE `from` = uid
					AND btid = ".$this->bug."
					ORDER BY time_create");
		return $comments = $db->loadObjectList($rq);
	}
	
}
?>