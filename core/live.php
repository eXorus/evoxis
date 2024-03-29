<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_LIVE', 1 );

if($_GET['onglet']=='ts'){

	// The code between the 2 lines below turns on PHPs error handlers.
	// Uncomment it for debugging purposes, but leave commented in live
	// environments. Having your script running in a live environment with the
	// error handlers turned on, decreases your sites security as a warning may
	// reveal information used to exploit security holes in your site.
	//================== BEGIN OF ERROR REPORTING CODE ====================
	//echo("<span style=\"color: #dd0000; font-weight: bold\">Error reporting ");
	//echo("is currently on. Turn it off in live environments !</span><br><br>\n");
	//error_reporting(E_ALL);
	//ini_set("display_errors", "1");
	//ini_set("display_startup_errors", "1");
	//ini_set("ignore_repeated_errors", "0");
	//ini_set("ignore_repeated_source", "0");
	//ini_set("report_memleaks", "1");
	//ini_set("track_errors", "1");
	//ini_set("html_errors", "1");
	//ini_set("warn_plus_overloading", "1");
	//================== END OF ERROR REPORTING CODE ======================
	
	// Load the Teamspeak Display:
	require("./inc/teamspeakdisplay/teamspeakdisplay.php");
	
	// Get the default settings
	$settings = $teamspeakDisplay->getDefaultSettings();
	
	//================== BEGIN OF CONFIGURATION CODE ======================
	
	// Set the teamspeak server IP or Hostname below (DO NOT INCLUDE THE
	// PORT NUMBER):
	$settings["serveraddress"] = $ts_host;
	
	// If your you use another port than 8767 to connect to your teamspeak
	// server using a teamspeak client, then uncomment the line below and
	// set the correct teamspeak port:
	//$settings["serverudpport"] = 8767;
	
	// If your teamspeak server uses another query port than 51234, then
	// uncomment the line below and set the teamspeak query port of your
	// server (look in the server.ini of your teamspeak server for this
	// portnumber):
	//$settings["serverqueryport"] = 51234;
	
	// If you want to limit the display to only one channel including it's
	// players and subchannels, uncomment the following line and set the
	// exact name of the channel. This feature is case-sensitive!
	//$settings["limitchannel"] = "";
	
	// If your teamspeak server uses another set of forbidden nickname
	// characters than "()[]{}" (look in your server.ini for this setting),
	// then uncomment the following line and set the correct set of
	// forbidden nickname characters:
	//$settings["forbiddennicknamechars"] = "()[]{}";
	
	//================== END OF CONFIGURATION CODE ========================
	
	// Is the script improperly configured?
	if ($settings["serveraddress"] == "") { die("You need to configure this script as described inside the CONFIGURATION CODE block in " . $_SERVER["PHP_SELF"] . "<br>\n"); }
	
	
}
elseif($_GET['onglet']='radio'){
}

	
/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'live';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'News' => 'index.php?comp=live',
'Evoxis Live' => ''
);
$ws_name_perso = 'Evoxis v5 - Evoxis Live';
?>