<?php


class ask {
	var $ID;
	var $Type;
	var $Cible;
	var $Ask;
	var $Link;
	var $State;
	var $DateWait;
	var $DateOpen;
	var $DateValidate;
	var $DateAssign;
	var $DateDone;
	var $DateRefused;
	var $DateAssignTo;
	
	function __construct() {	
	}
	
	function insert(){
		global $db;
		
		$query = "SELECT acStartState, acTitle
			FROM exo_ask_config
			WHERE acID = ".intval($this->Type)."";
		$result = $db->Send_Query($query);
		$o = $db->get_array($result);
		
		$StartState = $o['acStartState'];
		$Title = $o['acTitle'];
		

		if($StartState=='OPEN'){
			$DateWait = 0;
			$DateOpen = time();
			$_SESSION['message'] = "Votre demande est en attente de validation par l'équipe MJ, vous recevrez un MP lors de son traitement ";
		}elseif($StartState=='WAIT'){
			$DateWait = time();
			$DateOpen = 0;
		}
		
		//Cible	
		$qs = $db->get_array($db->Send_Query("SELECT acCible FROM exo_ask_config WHERE acID=".$this->Type.""));
		$TypeCible = $qs['acCible'];
			
		if ($TypeCible == 'PV'){
			$qs = $db->get_array($db->Send_Query("SELECT name FROM exo_backgrounds WHERE guid=".$this->Cible.""));
			$stitle = $qs['name'];
		}
		elseif ($TypeCible == 'CT'){
			$qs = $db->get_array($db->Send_Query("SELECT username FROM exo_users WHERE uid=".$this->Cible.""));
			$stitle = $qs['username'];
		}
		elseif($TypeCible == 'GD'){
			$qs = $db->get_array($db->Send_Query("SELECT name FROM exo_guilds WHERE guildid=".$this->Cible.""));
			$stitle = $qs['name'];
		}
				
		//Envoie d'un MP
		$data = array();
		$data[0] = $Title;
		$data[1] = $stitle;
		$data[2] = $this->Ask;
		$dpID = sendAutoMP(5, $_SESSION['uid'], $data);
						
		$query = "INSERT INTO exo_ask
		(aID, aType, aCible, aAsk, aLink, aState, aDateWait, aDateOpen, aDateValidate, aDateAssign, aDateDone, aDateRefused, aAssignTo, adpID) 
		VALUES('".$this->ID."', '".$this->Type."', '".$this->Cible."', '".$this->Ask."', '".$this->Link."', '$StartState', $DateWait, $DateOpen, 0, 0, 0, 0, 0, $dpID)";
		$result = $db->Send_Query($query);
		$askid = $db->last_insert_id();
		
			
		if($StartState=='WAIT'){
			global $ws_domain;
			global $email_entete;
			
			$key = randomString( 8, 'abcdefghjkmnpqrstuvwxyz123456789ABCDEFGHJKMNPQRSTUVWXYZ' );
		
			//Query
			$rq = $db->Send_Query("
				UPDATE exo_users 
				SET 	activate_string='".$askid."',
						activate_key='$key'
				WHERE uid='".$this->Cible."' AND email='".$this->Ask."'");
			
			if ($db->num_rows($rq)==1){
				// Envoyer Mail pour validation
				$sujet="[EVOXIS] Confirmation de votre demande";
				$contenu=
				"
				<html>
				<p>
				Bonjour,
				</p><p>
				Vous avez fait une demande de $Title sur le site Evoxis.
				</p><p>
				Si vous avez bien fait une demande alors confirmez-la en visitant la page suivante:
				<a href=\"".$ws_domain."index.php?comp=ask&task=activate&key=".$key."&askid=".$askid."\">".$ws_domain."index.php?comp=ask&task=activate&key=".$key."&askid=".$askid."</a>
				</p><p>
				Cordialement,
				l'équipe d'evoxis.
				</p>
				</html>";
					
				mail($this->Ask, $sujet ,$contenu, $email_entete);  
				$_SESSION['message'] = "Votre demande est en attente de votre confirmation par mail "; 
			}
			else{
				$_SESSION['message'] = "Votre demande n'a pas pu être traitée car le mail ne correspond pas à l'utilisateur ";
			}
		}
	}
}


?>
