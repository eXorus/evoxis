<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

if(!empty($_SESSION['connected']) && $_SESSION['connected']==TRUE){

	echo '
		<div id="date">'.date('d/m/y - H\hi').'</div>
		<div id="petitavatar"><img src="./img/pictures/'.$_SESSION['avatar_path'].'" alt="Avatar Utilisateur" /></div>
		<div id="box_username">'.$_SESSION['username'].'</div>
		<div id="box_menu_utilisateur">
			<table>
				<tr>
					<td><a href="./index.php?comp=profil" onmouseover="Tip(\'Mon&nbsp;profil\')" onmouseout="UnTip()"><img src="./templates/'.$link_style.'/ico/user_profil.png" alt="Profil" /></a></td>
					

					<td><a href="./index.php?comp=mp" onmouseover="Tip(\'Ma&nbsp;messagerie\')" onmouseout="UnTip()"><img src="./templates/'.$link_style.'/ico/user_messagerie.png" alt="Messagerie" /></a></td>
					<td><a href="./index.php?comp=bg" onmouseover="Tip(\'Mes&nbsp;backgrounds\')" onmouseout="UnTip()"><img src="./templates/'.$link_style.'/ico/user_bgs.png" alt="Backgrounds" /></a></td>
				</tr>
			</table>

		</div>
		
		<div id="logout">';
	if($secureObject->verifyAuthorization('BO_LOGIN')==TRUE){
		echo '<a href="http://dev.evoxis.info/admin" onmouseover="Tip(\'Console&nbsp;MJ\')" onmouseout="UnTip()" target="_blank"><img src="./templates/'.$link_style.'/ico/user_mj.png" alt="Console MJ" /></a><br />';
	}
	
	echo '<a href="index.php?comp=logout" onmouseover="Tip(\'Déconnexion\')" onmouseout="UnTip()"><img src="./templates/'.$link_style.'/ico/user_logout.png" alt="Déconnexion" /></a></div>';

}
else{
	echo '
	<div id="box_logged_out">
	<form action="./index.php?comp=login" method="post">
		<img src="./templates/'.$link_style.'/ico/user.png" align="bottom" alt="User" />&nbsp;<input class="inputlogin" type="text" name="connect_username" maxlength="200" tabindex="1" onmouseover="Tip(\'Identifiant\')" onmouseout="UnTip()"/><br />
		<a href="index.php?comp=ask" onmouseover="Tip(\'Mot&nbsp;de&nbsp;passe&nbsp;oublié&nbsp;?\')" onmouseout="UnTip()"><img onmouseover="this.src=\'./templates/default/main_pic/bt_mdp2.png\'"  src="./templates/'.$link_style.'/main_pic/bt_mdp.png" alt="Mot de pass oublié ?" onmouseout="this.src=\'./templates/default/main_pic/bt_mdp.png\'" /></a>&nbsp;<input class="inputlogin" type="password" name="connect_pass" maxlength="50" tabindex="2" onmouseover="Tip(\'Mot&nbsp;de&nbsp;passe\')" onmouseout="UnTip()"/>
		<div style="float: left;"><input type="checkbox" name="auto" id="auto" /> <label for="auto">Auto</label></div>
		<div style="float: right;"><input type="image" src="./templates/default/main_pic/bt_ok.png" onmouseover="this.src=\'./templates/default/main_pic/bt_ok2.png\'" alt="OK" onmouseout="this.src=\'./templates/default/main_pic/bt_ok.png\'" value="&nbsp;"/></div>
		
		<a href="index.php?comp=insevo" onmouseover="Tip(\'Rejoignez-nous&nbsp;!\')" onmouseout="UnTip()"><img onmouseover="this.src=\'./templates/default/main_pic/bt_inscription2.png\'"  src="./templates/'.$link_style.'/main_pic/bt_inscription.png" alt="Inscription" onmouseout="this.src=\'./templates/default/main_pic/bt_inscription.png\'" /></a>
	</form>
	</div>';
}
	
?>
