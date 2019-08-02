<?php

class mysql {
	var $host = 'localhost';
	var $user = 'root';
	var $pass = '';
	var $base;
	var $connect_id = 0;
	var $cache_path = 'cache';
	var $gc_time=86400;
	var $error;
	var $nbQuery = 0;
	
	// PRIVATE : Constructeur initialise les parametre de la connexion
	function mysql($Host='localhost', $User='root', $Pass='', $Base='') {
		$this->host=$Host;
		$this->user=$User;
		$this->pass=$Pass;
		$this->base=$Base;
		
		//require_once('./inc/gc.php');
		//$gcsql = new GC();
		//srand((double)microtime()*1000000);
		//if (!rand(0,99)) $gcsql->rungc($this->cache_path,$this->gc_time);
	}
		
	// PRIVATE : connection à la DB
	function connect($Host, $User, $Pass, $Base, $new_link=FALSE) {
		$this->connect_id = @mysql_connect($Host, $User, $Pass, $new_link);
		if ($this->connect_id) {
			if(@mysql_select_db($Base, $this->connect_id)){
				return $this->connect_id;
			}
			else return FALSE;
		}
		else return FALSE;
	}
	
	// PUBLIC : Envoi d'une requete a la DB
	function Send_Query($query) {
		$this->nbQuery++;
		if ( !$this->connect_id ) $this->connect($this->host,$this->user,$this->pass,$this->base);
		if ( $this->result_id = mysql_query($query, $this->connect_id) ) {
			$this->query = trim($query);
			$this->error = '';
			return $this->result_id;
		} else {
			$this->error= mysql_error();
			return FALSE;
		}
	}
	
	// PUBLIC : return the last auto increment insert ID, only use on MySQL
	function last_insert_id() {
		return @mysql_insert_id($this->connect_id);
	}
	
	function get_row($result){
		return @mysql_fetch_row($result);
	}
	
	// PUBLIC : renvoi le nombre d'enregistrement affecté
	function num_rows() {
		if ( isset($this->result_id) ) {
			if ( preg_match('`^select`i',$this->query) ) return mysql_num_rows($this->result_id);
			if ( preg_match('`^(insert|update|delete)`i',$this->query) ) return mysql_affected_rows($this->connect_id);
		} else {
			return count($this->records);
		}
	}
	
	function get_object($query) {
		return @mysql_fetch_object($query);
	}
	
	function get_result($query, $row){
		return @mysql_result($query, $row);
	}
	
	function loadObjectList($query ) {
		if (!($query)) {
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_object( $query )) {
			if ($key) {
				$array[$row->$key] = $row;
			} else {
				$array[] = $row;
			}
		}
		return $array;
	}
	
	function get_array($query, $mode='ASSOC') {
		switch($mode) {
			case 'NUMERIC' :
			return @mysql_fetch_array($query, MYSQL_NUM);
			break;
			case 'BOTH' :
			return @mysql_fetch_array($query, MYSQL_BOTH);
			break;
			case 'ASSOC' :
			return @mysql_fetch_assoc($query);
			break;
			default :
			return @mysql_fetch_assoc($query);
		}
	}
	
	// PUBLIC : renvoi le msg d'erreur mysql
	function return_error() {
		return @mysql_error();
	}
	
	// PUBLIC : ferme la connection;
	function close() {
		return mysql_close($this->connect_id) ;
	}
	
	// PUBLIC : vide les resultat des requete
	function free_result() {
		return @mysql_free_result($this->connect_id);
	}
	
	// PUBLIC : execute une requete(SELECT) et renvoi le tableau des resultat via le cache
	function get_cached_data($request,$time=0) {
		$this->cachename=$this->cache_path.'/'.md5($request).'.cachesql';
		if ( file_exists($this->cachename) && filemtime($this->cachename) > (time() - $time)) {
			$records = unserialize(file_get_contents($this->cachename));
		} else {
			if (!($this->result=$this->Send_Query($request))) return FALSE;
			while ($record = mysql_fetch_array($this->result, MYSQL_ASSOC) ) {
				$records[] = $record;
			}
			$OUTPUT = serialize($records);
			$fp = fopen($this->cachename,"wb");
			@flock($fp,2);
			fputs($fp, $OUTPUT);
			@flock($fp,3);
			fclose($fp);
		}
		return $records;
	}
	
	
	// PUBLIC : ajoute les slashe sql et C pour le stockage des BLOB
	function prepare_blob($file) {
		$blob = file_get_contents($file);
		$blob = addslashes($blob);
		$blob = addcslashes($blob, "\0");
		return $blob;
	}
	
	function getNbQuery(){
		return $this->nbQuery;
	}
}
?>