<?php
defined( '_VALID_CORE_CHARTE' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

echo ' <div id="onglets"><center><table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">';
echo '<br /><center>'.$onglet.'</center><br />';
echo ' </td><td class="onglet_right"></td></tr></table></center></div>';
echo '<div class="topic_top"></div>
<div class="topic_middle"><div class="newscontenu">';
echo '
'.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($charte))));
echo '</div></div><div class="topic_bottom"></div>';
require_once('./templates/'.$link_style.'bottom.php');
?>