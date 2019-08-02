<?php
defined( '_VALID_CORE_LOGIN' ) or die( 'Restricted access' );

if(!empty($_SESSION['connected']) && $_SESSION['connected']==TRUE){

	echo '
		<div id="date">'.date('d/m/y - H\hi').'</div>
		<div id="petitavatar"><img src="./img/pictures/'.$_SESSION['avatar_path'].'"></div>
		<div id="box_menu_utilisateur">
			<table>
				<tr>
					<td><a href="./index.php?comp=profil" onmouseover="Tip(\'Profil\')" onmouseout="UnTip()"><img src="./templates/'.$link_style.'/ico/user_profil.png"></a></td>
					<td><a href="./index.php?comp=profil_print" onmouseover="Tip(\'Réglages\')" onmouseout="UnTip()"><img src="./templates/'.$link_style.'/ico/user_options.png"></a></td>
				</tr>
				<tr>
					<td><a href="./index.php?comp=mp_inbox" onmouseover="Tip(\'Messagerie\')" onmouseout="UnTip()"><img src="./templates/'.$link_style.'/ico/user_messagerie.png"></a></td>
					<td><a href="./index.php?comp=bg" onmouseover="Tip(\'Mes&nbsp;Backgrounds\')" onmouseout="UnTip()"><img src="./templates/'.$link_style.'/ico/user_bgs.png"></a></td>
				</tr>
			</table>

		</div>
		<div id="box_username">›&nbsp;'.$_SESSION['username'].'</div>
		<div id="logout">';
	if($secureObject->verifyAuthorization('BO_LOGIN')==TRUE){
		echo '<a href="http://admin.evoxis.info" onmouseover="Tip(\'Console&nbsp;MJ\')" onmouseout="UnTip()" target="_blank"><img src="./templates/'.$link_style.'/ico/user_mj.png"></a>';
	}
	
	echo '<a href="index.php?comp=logout" onmouseover="Tip(\'Déconnexion\')" onmouseout="UnTip()"><img src="./templates/'.$link_style.'/ico/user_logout.png"></a></div>';

}
else{
	echo '
	<form action="index.php" method="post" style="float:left;">
		<img src="./templates/'.$link_style.'/ico/user.png" height="16px" width="16px" align="bottom">&nbsp;<input type="text" name="connect_username" maxlength="200"/><br />
		<img src="./templates/'.$link_style.'/ico/lock.png" height="16px" width="16px" align="bottom">&nbsp;<input type="password" name="connect_pass" maxlength="50"/>
		<input type="image" src="./templates/default/main_pic/bt_ok.png" value="&nbsp;"/>
		<br /><a href="index.php?comp=insevo"><img src="./templates/'.$link_style.'/main_pic/bt_inscription.gif"></a>
	</form>';
}
	
?>
