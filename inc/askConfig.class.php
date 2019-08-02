<?php


		
class ci {
	var $id;
	var $name;
	function __construct($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
}

class askConfig {
	var $ID;
	var $Title;
	var $Ask;
	var $Remark;
	var $Cibles;
	var $Link;
	
	function __construct($acID_select) {
		global $db;
		$acID_select = intval($acID_select);
	
		if(empty($acID_select)){
			if(empty($_SESSION['uid'])) $acID_select=4;
			else $acID_select=2;
		}
		
		$query = "SELECT acID, acTitle, acAsk, acRemark, acCible, acLink
			FROM exo_ask_config
			WHERE acID = ".intval($acID_select)."";
		$result = $db->Send_Query($query);
		$o = $db->get_array($result);
		
		$this->ID = $o['acID'];
		$this->Title = $o['acTitle'];
		$this->Ask = $o['acAsk'];
		$this->Remark = $o['acRemark'];    
		$this->Link = $o['acLink']; 


		if ($o['acCible'] == 'PV'){
			$query = "SELECT guid as id, name
			FROM exo_backgrounds
			WHERE wow_id = ".intval($_SESSION['wow_id'])."
			AND statut='VALIDE'";
			$result = $db->Send_Query($query);
			$cibles = $db->loadObjectList($result);
		}
		elseif ($o['acCible'] == 'CT' && !empty($_SESSION['uid']) && !empty($_SESSION['username'])){
			
			$o = new ci($_SESSION['uid'],$_SESSION['username']); 
			$cibles = array();
			$cibles[] = $o;
		}
		elseif ($o['acCible'] == 'CT' && empty($_SESSION['uid']) && empty($_SESSION['username'])){
			
			$query = "SELECT uid as id, username as name
			FROM exo_users
			ORDER BY username";
			$result = $db->Send_Query($query);
			$cibles = $db->loadObjectList($result);
		}
		elseif($o['acCible'] == 'GD'){
			$query = "
			SELECT guildid as id, name
			FROM exo_guilds
			WHERE wowid='".intval($_SESSION['wow_id'])."'";
			$result = $db->Send_Query($query);
			$cibles = $db->loadObjectList($result);
		}
		$this->Cibles = $cibles;    
    }


	function onglets($acID_select){
		global $db, $secureObject;
		$acID_select = intval($acID_select);
		
		$accessLevel = $secureObject->getAccessLevel();
				
		if(empty($accessLevel)){
			if (empty($acID_select)) $acID_select=4;
			$rq = $db->Send_Query("
				SELECT acID, acTitle
				FROM exo_ask_config
				WHERE acActif = 1
				AND acAcces=0
				ORDER BY acTitle");
			$list = $db->loadObjectList($rq);
		}
		else{
			if (empty($acID_select)) $acID_select=2;
			$rq = $db->Send_Query("
				SELECT acID, acTitle
				FROM exo_ask_config
				WHERE acActif = 1
				AND acAcces<= ".$accessLevel."
				AND acAcces!=0
				ORDER BY acTitle");
			$list = $db->loadObjectList($rq);
		}
		
		$out = "";
		foreach ($list as $o){
			if($o->acID == $acID_select){
				$out .= ' | <a href="./index.php?comp=ask&amp;onglet='.intval($o->acID).'"><b>'.stripslashes(htmlspecialchars($o->acTitle)).'</b></a>';
			}
			else{
				$out .= ' | <a href="./index.php?comp=ask&amp;onglet='.intval($o->acID).'">'.stripslashes(htmlspecialchars($o->acTitle)).'</a>';
			}
		}
		$out .= ' |';

		return $out;
		
	}
}


?>
