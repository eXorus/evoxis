#!/usr/bin/php5-cgi

<?php
//#################################################################
//Require_one
require_once("../config.php");
require_once("../mysql.php");
require_once("../fct_utile.php");

//MySQL
$db = new mysql($db_host,$db_username,$db_password,$db_name);
$db->connect($db->host,$db->user,$db->pass,$db->base) or die( 'MySQL Lost: WS' );
//#################################################################

$whoisonline_time_max = time() - (60 * 3);
$db->Send_Query('DELETE FROM exo_whoisonline WHERE online_time < '.$whoisonline_time_max);

?>
