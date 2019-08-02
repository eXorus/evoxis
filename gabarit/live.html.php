<?php
defined( '_VALID_CORE_LIVE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

echo '
<div id="onglets"><center><table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">
<a href="./index.php?comp=live&amp;onglet=ts">Team Speak</a> | <a href="./index.php?comp=live&amp;onglet=radio">Radio</a>
</td><td class="onglet_right"></td></tr></table></center></div>';


if($_GET['onglet']=='ts'){

	// Display the Teamspeak server
	$teamspeakDisplay->displayTeamspeakEx($settings);
}
elseif($_GET['onglet']='radio'){
 echo "Info sur la radio Evoxis";
}


require_once('./templates/'.$link_style.'bottom.php');
?>