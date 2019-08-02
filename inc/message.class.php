<?php
class message {
	private static $_instance = null;   
	private $_level = '';	//Level = INFO, SUCCESS, WARNING, ERROR, VALIDATION
	private $_desc = '';
	
	private function __construct($level, $desc, $redirect){
		$this->_level = $level;
		$this->_desc = $desc;
	}

	public static function getInstance($level='', $desc='', $redirect = 0){
		if(is_null(self::$_instance)) {
			self::$_instance = new message($level, $desc, $redirect);
		}
		if(!empty($redirect)){
			$_SESSION['messageLevel'] = $level;
			$_SESSION['messageDesc'] = $desc;
			header ('location: '.$redirect); 
			exit();
		}
		return self::$_instance;
	}
	
	public static function exist(){
		if(!empty($_SESSION['messageLevel']) && !empty($_SESSION['messageDesc'])){
			self::$_instance = new message($_SESSION['messageLevel'], $_SESSION['messageDesc'], 0);
			unset($_SESSION['messageLevel']);
			unset($_SESSION['messageDesc']);
		}
		return (is_null(self::$_instance)) ? FALSE : TRUE;
	}
	
	public function printMessage(){
		echo '<br /><div id="fade_demo" onmouseover="$(\'fade_demo\').fade({ duration: 1.0, from: 1, to: 0 }); return false;" class="'.$this->getLevel().'">'.$this->getDesc().'</div><br />';
	}

	public function getLevel(){
		return $this->_level;
	}
	
	public function getDesc(){
		return $this->_desc;
	}
}
?>
