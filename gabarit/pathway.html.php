<?php
reset($pathway);
unset($print_pathway);

$print_pathway .= '&#8226; ';

$print_pathway .= '<a href="'.$ws_domain.'"> Evoxis</a>';

foreach($pathway as $value=>$link){

	if(empty($link)){
		$print_pathway .= ' &#8250; '.stripslashes(htmlspecialchars($value)); 
	}
	else{
		$print_pathway .= ' &#8250; <a href="'.$ws_domain.''.$link.'">'.stripslashes(htmlspecialchars($value)).'</a>'; 
	}
}

echo $print_pathway;

?>
