<?php
defined( '_VALID_CORE_RP_BG' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

echo '<h1>L\'Histoire d\'Evoxis</h1><h4>&nbsp;</h4>';
echo '<br /><center><table class="tableau2">';
echo '<tr>';
echo '<td><a href="./story/prologue/index.html" class="lightwindow page-options" params="lightwindow_type=external,lightwindow_width=920,lightwindow_loading_animation=false"><img src="./templates/default/ico/prologue.png" title="Lire le prologue" alt="Prologue"/></a></td>';
echo '<td><a href="./story/tome1/index.html" class="lightwindow page-options" params="lightwindow_type=external,lightwindow_width=920,lightwindow_loading_animation=false"><img src="./templates/default/ico/tome1.png" title="Lire le Tome 1" alt="Tome 1"/></a></td>';
echo '<td><a href="./story/tome2/index.html" class="lightwindow page-options" params="lightwindow_type=external,lightwindow_width=920,lightwindow_loading_animation=false"><img src="./templates/default/ico/tome2.png" title="Lire le Tome 2" alt="Tome 2"/></a></td>';
echo '<td><a href="#"><img src="./templates/default/ico/tome3.png" title="Lire le Tome 3" alt="Tome 3"/></a></td>';
echo '<td><a href="./story/tome4/index.html" class="lightwindow page-options" params="lightwindow_type=external,lightwindow_width=920,lightwindow_loading_animation=false"><img src="./templates/default/ico/tome4.png" title="Lire le Tome 4" alt="Tome 4"/></a></td></tr>';
echo '</table></center>';

require_once('./templates/'.$link_style.'bottom.php');

?>