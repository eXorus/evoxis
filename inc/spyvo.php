<?php
class spyvo{

	var $fp;
	var $name_log;
	var $path_log;

	function spyvo(){
	
		//Nom du log
		$this->name_log = date('Ymd').'.log';		
		
		//Path
		$this->path_log = './inc/spyvo/';
	
		//Recherche le log du jour sinon création
		if (file_exists($this->path_log.$this->name_log)!=TRUE){
			touch($this->path_log.$this->name_log);
		}
		
		//Ouverture du flux
		if($this->fp = fopen($this->path_log.$this->name_log, "a+")) {
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	function spyvo_close(){
		fclose($this->fp);
	}
	
	function spyvo_write($level, $author, $type, $data){
		/*
		#LEVEL:
			* DEBUG
			* INFO
			* WARNING
			* CRITICAL
			* FATAL
			
		#AUTHOR: This is the ID of the member, and for visiter is vID
		
		#TYPE:
			* CONNECT
			* ...
			
		#DATA: This is all the data of the type.		
		*/	
	
		//Generate date
		$time = date('Y-m-d H:i:s');
				
		//Log to write
		$line = $time.';'.$level.';'.$author.';'.$data;
	
		fwrite($this->fp, $line."\r\n");
	}
}
?>