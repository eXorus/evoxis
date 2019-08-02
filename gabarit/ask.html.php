<?php
defined( '_VALID_CORE_ASK' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($_SESSION['message'])){
	echo $_SESSION['message'].'<br /><br /><a href="index.php?comp=ask">Retour</a>';
	
	unset($_SESSION['message']);
}
else{

	echo ' <div id="onglets"><center><table class="onglets"><tr><td class="onglet_left"></td><td class="onglet_center">';
	echo $myask->onglets($_GET['onglet']);
	echo ' </td><td class="onglet_right"></td></tr></table></center></div>';

	$selectCible = '<option value="0" selected="selected"> -- Selection --</option>';
	foreach($myask->Cibles as $o){
		$selectCible .= '<option value="'.$o->id.'">'.$o->name.'</option>';
	}


	echo '
	<h1>'.$myask->Title.'</h1>
	<div id="blockFormulaire">
	<form class="mainForm" action="./index.php?comp=ask&amp;task=process" method="post">
	<br />
		<label>Cible concernée:</label>
		<select name="form_cible">
		'.$selectCible.'
		</select>
		<label for="form_ask">Demande :</label>
<div class="topic_top"></div>
<div class="topic_middle">
		<textarea name="form_ask" id="form_ask" rows="10" cols="65">'.$myask->Ask.'</textarea>
</div><div class="topic_bottom"></div>
	';
	if($myask->Link==1){
		echo '
		<p>
			<label for="form_linkJudgeHype">Lien vers JudgeHype:</label>
			<input type="text" name="form_linkJudgeHype" id="form_linkJudgeHype"  size="100" maxlength="100" value="http://worldofwarcraft.judgehype.com/"/>
		</p>';
	}

	echo '
	<p>
		<label>Remarques:</label>
		'.$myask->Remark.'
	</p>
	<input type="hidden" name="form_type" value="'.$myask->ID.'" />
	<p>
		<label for="create_captcha">Code : <img src="./inc/captcha.php" alt="captcha"/></label>
		<input id="create_captcha" name="create_captcha" type="text" size="40" maxlength="5" />
	</p>
	<p>
		<input class="ok" type="submit" name="Submit" value="OK" /><br /><br />
	</p>
	</form>
	</div>';

}

require_once('./templates/'.$link_style.'bottom.php');
?>