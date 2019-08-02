<?php
class bugtracker{
	var $id;
	var $categorie;
	var $name;
	var $description;
	var $link;
	var $from;
	var $etat;
	var $time_create;
	var $time_end;
	var $sql;

	/*	##########
		Fonction d'ajout d'un nouveau bug
		##########
	*/
	function add(){
		global $db;
		
		//Edit
		if(!empty($this->id)){
			return $this->edit();
		}
	
		$query = "INSERT INTO exo_bugtracker (btid, bt_categorie, bt_name, bt_description, bt_link, bt_from, bt_etat, bt_time_create, bt_time_end, bt_version) 
			VALUES(NULL,'".$this->categorie."','".$this->name."', '".$this->description."', '".$this->link."', '".$this->from."', 0, '".$this->time_create."', 0, '".WOW_VERSION."')";
		$result = $db->Send_Query($query);
		$this->id = $db->last_insert_id();
	
		//Spyvo
		require_once("./inc/spyvo.php");
		$spyvo = new spyvo();
		$spyvo->spyvo_write('INFO', $this->from, 'BugTracker', 'Add Bug;ID Bug='.$this->id);
	
		//Indices
		update_ivo('nb_bug');
		
		return $this->id;
	}
	
	/*	##########
		Fonction d'edit d'un bug
		##########
	*/
	function edit(){
		global $db, $secureObject;
				
		$v = new bugtracker();
		$v->id = $this->id;
		$vData = $v->get();
		
		if($vData['bt_from']==$_SESSION['uid'] || $secureObject->verifyAuthorization('FO_BUGTRACKER_EDIT')==TRUE){
		
			require_once("./inc/bugtrackerComment.class.php");
			$vc = new bugtrackerComment();
			$vc->bug = intval($this->id);
			$vc->from = intval($_SESSION['uid']);
			$vc->time_create = time();
			
			$comment ="Mis à jour:\n\n";
			if($vData['btcid']!=$this->categorie){
				$rq = $db->Send_Query("SELECT name FROM exo_bugtracker_categories WHERE btcid = ".intval($this->categorie)."");
				$cat = $db->get_array($rq);
				$comment .= "¤ [b]Categorie[/b] changée de \"[i]".$vData['bt_categorie']."[/i]\" à \"[i]".$cat['name']."[/i]\"\n\n";
			}
			if(stripslashes($vData['bt_name'])!=stripslashes($this->name)){
				$comment .= "¤ [b]Titre[/b] changé de \"[i]".stripslashes($vData['bt_name'])."[/i]\" à \"[i]".stripslashes($this->name)."[/i]\"\n\n";
			}
			if(stripslashes($vData['bt_description'])!=stripslashes($this->description)){
				$comment .= "¤ [b]Description[/b] changé de:\n\n\"[i]".stripslashes($vData['bt_description'])."[/i]\"\n\n ===== à ===== \n\n\"[i]".stripslashes($this->description)."[/i]\"\n\n";
			}
			if(stripslashes($vData['bt_link'])!=stripslashes($this->link)){
				$comment .= "¤ [b]Lien[/b] changé de \"[i]".stripslashes($vData['bt_link'])."[/i]\" à \"[i]".stripslashes($this->link)."[/i]\"\n\n";
			}
			$vc->comment = mysql_real_escape_string($comment);
			$vc->id = $vc->add();
			$up = new bugtracker();
			$up->id = $vc->bug;
			$up->editForComment($vc->id);
			
			
			$query = "UPDATE exo_bugtracker 
			SET bt_categorie='".$this->categorie."', bt_name='".$this->name."', bt_description='".$this->description."', bt_link='".$this->link."' WHERE btid='".$this->id."'";
			$result = $db->Send_Query($query);
			return $this->id;
		}
		else{
			$msg = message::getInstance('ERROR','Droits insuffisants pour faire cette action', 'index.php');
		}
	}
	
	/*	##########
		Fonction qui récupère les bugs
		param = ALL, CAT
		##########
	*/
	function getBugs($where){
		global $db, $start, $Nmax, $Ntotal;
				
		$rq = $db->Send_Query("
			SELECT B.btid, C.name as bt_categorie, B.bt_name, B.bt_from, U.pseudo, B.bt_etat, B.bt_time_create, B.bt_time_end
			FROM exo_bugtracker B
			LEFT JOIN exo_bugtracker_categories C ON btcid=bt_categorie
			LEFT JOIN exo_users U ON uid = bt_from
			$where
			ORDER BY B.bt_etat, B.bt_time_create DESC
			LIMIT $start,$Nmax");
		$bugs = $db->loadObjectList($rq);

		$result = $db->Send_Query("SELECT COUNT(*) FROM exo_bugtracker B LEFT JOIN exo_bugtracker_categories C ON btcid=bt_categorie
			LEFT JOIN exo_users U ON uid = bt_from $where");
		$ligne = $db->get_row($result);
		$Ntotal = $ligne[0];
		
		return $bugs;
	}
	
	/*	##########
		Fonction d'edit de la date du bug comment
		##########
	*/
	function editForComment($value){
		global $db;
		
		$upb = "UPDATE exo_bugtracker SET last_commentaire_id='$value' WHERE btid = '".$this->id."'";
		$upb = $db->Send_Query($upb);	
	}
	
	/*	##########
		Fonction de changement de statut
		##########
	*/
	function modStatut(){
		global $db;

		$query = "UPDATE exo_bugtracker SET bt_etat=".$this->etat.", bt_time_end='".$this->time_end."', bt_sql='".$this->sql."' WHERE btid = '".$this->id."' AND bt_etat=0";
		$result = $db->Send_Query($query);
	
		//Spyvo
		require_once("./inc/spyvo.php");
		$spyvo = new spyvo();
		$spyvo->spyvo_write('INFO', $this->from, 'BugTracker', 'modStatut à '.$this->etat.' OK;ID Bug='.$this->id);
			
		//Indices
		update_ivo('nb_bug_resolve');
		
		require_once("./inc/bugtrackerComment.class.php");
		$vc = new bugtrackerComment();
		$vc->bug = intval($this->id);
		$vc->from = intval($_SESSION['uid']);
		$vc->time_create = time();
		
		$comment ="Mis à jour:\n\n";
		if($this->etat==1){
			$comment .= "¤ [b]Etat[/b] changé de \"[i]Ouvert[/i]\" à \"[i]Résolu[/i]\"\n\n";
		}
		if($this->etat==2){
			$comment .= "¤ [b]Etat[/b] changé de \"[i]Ouvert[/i]\" à \"[i]Bug du core[/i]\"\n\n";
		}
		if($this->etat==3){
			$comment .= "¤ [b]Etat[/b] changé de \"[i]Ouvert[/i]\" à \"[i]Bug de script[/i]\"\n\n";
		}
		$vc->comment = mysql_real_escape_string($comment);
		$vc->id = $vc->add();
		$up = new bugtracker();
		$up->id = $vc->bug;
		$up->editForComment($vc->id);
	}

	/*	##########
		Fonction de visualisation d"un bug
		##########
	*/
	function get(){
		global $db;
				
		$rq = $db->Send_Query("
			SELECT b.btid, C.btcid, C.name as bt_categorie, b.bt_name, b.bt_description, b.bt_link, b.bt_from, u.pseudo, b.bt_etat, b.bt_time_create, b.bt_time_end, b.bt_version
			FROM exo_bugtracker b
			LEFT JOIN exo_bugtracker_categories C ON btcid=bt_categorie
			LEFT JOIN exo_users u ON u.uid = b.bt_from
			WHERE b.btid = ".$this->id."");
		return $bug = $db->get_array($rq);
	}
	

}
?>