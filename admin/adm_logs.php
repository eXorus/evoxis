<?php
defined( '_ADM_VALID_INDEX' ) or die( 'Restricted access' );
define( '_ADM_VALID_CORE_LOGS', 1 );


$pathLink = 'http://www.evoxis.info/inc/';
$pathDirectory = '../inc/spyvo/';
$pathFile = '*.log';



if(!empty($_POST['form_date'])){
	$date = mysql_real_escape_string($_POST['form_date']);
	
	if(!empty($date)){
		$pathFile = $date.".log";
	}
	
}

$nb_fichier = 0;
$data = '
<fieldset>
	<legend>Listing</legend>
';
foreach(glob($pathDirectory.$pathFile) as $cle){
  $nb_fichier++; 
  $data .= '<a href="'. $pathLink . $cle . '">' . $cle . '</a> (' . filesize($cle) . ' octets)<br />';
}
$data .=  '<br /></p>
	</fieldset>';


$_SESSION['BoxStateType'] = "Green";
$_SESSION['BoxStateMsg'] = array ("Listage des $nb_fichier logs OK");

$TitlePage = 'Logs';
?>