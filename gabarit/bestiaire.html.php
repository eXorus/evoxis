<?php
defined( '_VALID_CORE_BESTIAIRE' ) or die( 'Restricted access' );

require_once('./templates/'.$link_style.'top.php');

echo '<h1>Pallier 1</h1><h4>Accessible � tous</h4>';
echo '<h1>Pallier 2</h1><h4>Accessible via une demande</h4>';
echo '<h1>Pallier 3</h1><h4>Accessible via une demande (r�serv� aux R�listes)</h4>';
echo 'Bestiaire � venir';

require_once('./templates/'.$link_style.'bottom.php');
?>