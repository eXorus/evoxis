<?php
/* 
	POMM  v1.3
	Player Online Map for MangOs

	Show online players position on map. Update without refresh.
	Show tooltip with location, race, class and level of player.
	Show realm status.

	16.09.2006		http://pomm.da.ru/
	
	Created by mirage666 (c) (mailto:mirage666@pisem.net icq# 152263154)
	2006-2009 Modified by killdozer.
*/
require_once("../config.php");

// points located on these maps(do not modify it)
$maps_for_points = "0,1,530,571,609";

// realm name
$realm_name = 'Mon site';

// database coding(do not modify it)
$database_encoding = 'utf8';

// language (en/ru)
$lang = 'fr';

// show GM online (1/0)
$show_gm_online = 1;

// add '{GM}' to name if player is 'gm on' (1/0)
$add_gm_suffix = 1;

// show server status window (1/0)
// time to show uptime string (msec)
// time to show max online (msec)
// (do not set time < 1500)
$show_status = 1;
$time_to_show_uptime = 10000;
$time_to_show_maxonline = 10000;

// Image dir
$img_base = "img/";

// Server adress (for realm status)
$server = $db_host_characters;

// Server port (for realm statust) 8085 or 3724
$port = 8085;

// Update time (seconds), 0 - not update.
$time= "120";

// Show update timer 1 - on, 0 - off
$show_time="1";

// see UpdateFields.h
// 2.4.3 :
// UNIT_FIELD_LEVEL   = 34
// UNIT_FIELD_BYTES_0 = 36
// PLAYER_FLAGS       = 236
// 3.0.3 :
// UNIT_FIELD_BYTES_0 = 22
// UNIT_FIELD_LEVEL   = 53
// PLAYER_FLAGS       = 150
$UNIT_FIELD_BYTES_0 = 22;
$UNIT_FIELD_LEVEL   = 53;
$PLAYER_FLAGS   = 150;

//DB connect options	
$host=$db_host_characters;				// HOST for characters database
$user=$db_username_characters;					// USER for characters database
$password=$db_password_characters;				// PASS for characters database
$db=$db_name_characters;				// NAME of characters database

$hostw=$db_host_mangos;				// HOST for world database
$userw=$db_username_mangos;					// USER for world database
$passwordw=$db_password_mangos;				// PASS for world database
$dbw=$db_name_mangos;					// NAME of world database

$hostr=$db_host_realmd;				// HOST for realm database
$userr=$db_username_realmd;					// USER for realm database
$passwordr=$db_password_realmd;				// PASS for realm database
$dbr=$db_name_realmd;					// NAME of realm database

?>
