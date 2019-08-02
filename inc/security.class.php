<?php
class security {
	private static $_instance = null;
	private	$_authorizations = array();
	private	$_accessLevel = 0;
	
	private function __construct(){
		
	}

	public static function getInstance(){
		if(is_null(self::$_instance)) {
			self::$_instance = new security();
		}
		return self::$_instance;
	}
		
	public function loadAuthorizations(){
		global $db;
		$_authorizations = array();
		if(empty($_SESSION['uid'])){
			$query = "
			SELECT acl_Key
			FROM exo_security_assign ass
			LEFT JOIN exo_security_ACL acl ON acl.acl_ID = ass.ass_ACL
			WHERE ass.ass_Type='G' AND ass.ass_cible = 14
			GROUP BY acl_KEY";
		}
		else{
			$query = "
			SELECT acl_Key
			FROM exo_users u
			LEFT JOIN exo_groups_users gu ON gu.uid=u.uid
			LEFT JOIN exo_security_assign ass ON ((ass.ass_Type='G' AND ass.ass_cible = gu.gid) OR (ass.ass_Type='U' AND ass.ass_cible = u.uid) )
			LEFT JOIN exo_security_ACL acl ON acl.acl_ID = ass.ass_ACL
			WHERE u.uid = ".intval($_SESSION['uid'])."
			GROUP BY acl_KEY";
		}
		$q = $db->Send_Query($query);
		while($temp = $db->get_array($q)){
			array_push($this->_authorizations,$temp['acl_Key']); 
		}
				
	}
	
	public function loadAccessLevel(){
		global $db;
		
		$query = "
			SELECT MAX(access_Level) as level
			FROM exo_users u
			LEFT JOIN exo_groups_users gu ON gu.uid=u.uid
			LEFT JOIN exo_groups g ON g.gid = gu.gid
			WHERE u.uid = ".intval($_SESSION['uid']);
		$r = $db->get_array( $db->Send_Query($query));
		$this->_accessLevel = $r['level'];
		
	}
	
	public function verifyAuthorization($key){
		return in_array($key, $this->_authorizations);
	}
	
	public function getAccessLevel(){
		return intval($this->_accessLevel);
	}
	
	
}
?>
