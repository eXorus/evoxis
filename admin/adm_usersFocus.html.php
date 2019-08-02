<?php
defined( '_ADM_VALID_CORE_USERSFOCUS' ) or die( 'Restricted access' );

?>
<SCRIPT language="Javascript">
<!--
function affiche(balise)
{
if (document.getElementById && document.getElementById(balise) != null)
{
document.getElementById(balise).style.visibility='visible';
document.getElementById(balise).style.display='block';
}
}

function cache(balise)
{
if (document.getElementById && document.getElementById(balise) != null)
{
document.getElementById(balise).style.visibility='hidden';
document.getElementById(balise).style.display='none';
}
}
// -->
</SCRIPT> 
<?php

	echo '
		
		<form class="mainForm" action="#">
			<fieldset>
				<legend>Informations Générales</legend>
				<p>
					<label for="form_login">Login: </label>
					<input type="text" name="form_login" maxlength="200" value="'.htmlspecialchars(stripslashes($user_view['username'])).'"/>
				</p>
				<p>
					<label for="form_pseudo">Pseudo: </label>
					<input type="text" name="form_pseudo" maxlength="200" value="'.htmlspecialchars(stripslashes($user_view['pseudo'])).'"/>
				</p>
				<p>
					<label for="form_ivo">Points Ivo: </label>
					<input type="text" name="form_ivo" maxlength="200" value="'.intval($user_view['total']).' points"/>
				</p>
				<p>
					<label for="form_avert">Avertissements: </label>
					<input type="text" name="form_avert" maxlength="200" value="'.intval($user_view['avertissements']).'%"/>
				</p>
				<p>
					<label for="form_email">E-mail: </label>
					<input type="text" name="form_email" maxlength="200" value="'.htmlspecialchars(stripslashes($user_view['email'])).'"/>
				</p>
				<p>
					<label for="form_ips">IP sur le site: </label>
					<input type="text" name="form_ips" maxlength="200" value="'.htmlspecialchars(stripslashes($user_view['ips'])).'"/>
				</p>
				<p>
					<label for="form_ipw">IP sur WoW: </label>
					<input type="text" name="form_ipw" maxlength="200" value="'.htmlspecialchars(stripslashes($user_view['ipw'])).'"/>
				</p>
			</fieldset>
			<fieldset>
				<legend>Dates</legend>
				<p>
					<label for="form_dateI">Inscription: </label>
					<input type="text" name="form_dateI" maxlength="200" value="'.htmlspecialchars(stripslashes($user_view['joindate'])).'"/>
				</p>
				<p>
					<label for="form_dateS">Dernière Connexion sur le site: </label>
					<input type="text" name="form_dateS" maxlength="200" value="'.htmlspecialchars(stripslashes(format_time($user_view['last_date_connect']))).'"/>
				</p>
				<p>
					<label for="form_dateW">Dernière Connexion sur WoW</label>
					<input type="text" name="form_dateW" maxlength="200" value="'.htmlspecialchars(stripslashes($user_view['last_login'])).'"/>
				</p>
			</fieldset>
			<fieldset>
				<legend>WoW</legend>
				<p>
					<label for="form_wid">WID (WoW ID): </label>
					<input  readonly="readonly" type="text" name="form_wid" maxlength="5" value="'.intval($user_view['wow_id']).'"/>
				</p>
				<p>
					<label for="form_gmlevel">GM Level: </label>
					<input  readonly="readonly" type="text" name="form_gmlevel" maxlength="50" value="'.$gmlevel.'"/>
				</p>		
				<p>
					<label for="form_bg">BGs: </label>
					<a href="http://www.evoxis.info/index.php?comp=bg&select='.intval($user_view['wow_id']).'">Accès aux backgrounds</a>
				</p>		
			</fieldset>
			<fieldset>
				<legend>Site</legend>
				<p>
					<label for="form_sid">SID (Site ID): </label>
					<input  readonly="readonly" type="text" name="form_sid" maxlength="5" value="'.intval($user_view['uid']).'"/>
				</p>				
				<p>
					<label for="form_groupe">Groupe: </label>
					<input type="text" name="form_groupe" maxlength="200" value="'.htmlspecialchars(stripslashes($user_view['groupName'])).'"/>
				</p>
				<p>
					<label for="form_fiche">Fiche Public: </label>
					<a href="http://www.evoxis.info/index.php?comp=profil&select='.intval($user_view['uid']).'">Accès à la fiche public</a>
				</p>
			</fieldset>
			</form>
			';

			if (!empty($user_view['id']) && $user_view['gid']==12 && $secureObject->verifyAuthorization('BO_USERS_BAN')==TRUE){
				//Bannis Total
				echo '
				<form class="mainForm" action="index.php?comp=usersFocus&task=unban&wowid='.intval($user_view['wow_id']).'&select='.intval($user_view['uid']).'" method="post">
				<fieldset>
				<legend>Actions</legend>';
				if($secureObject->verifyAuthorization('BO_USERS_PWDCHANGE')==TRUE){
					echo '<p><a href="index.php?comp=usersFocus&task=changepwd&select='.intval($user_view['uid']).'">Changer le mot de passe du compte</a></p>';
				}
				echo '
				<br />	
				<p>
					<label for="form_type">Débannir de WoW et du site:</label>
					<input type="radio" name="form_type" value="1">
				</p>';
			}
			elseif (!empty($user_view['id']) && $user_view['gid']==13 && $secureObject->verifyAuthorization('BO_USERS_BAN')==TRUE){
				//Bannis WoW
				echo '
				<form class="mainForm" action="index.php?comp=usersFocus&task=unban&wowid='.intval($user_view['wow_id']).'&select='.intval($user_view['uid']).'" method="post">
				<fieldset>
				<legend>Actions</legend>';
				if($secureObject->verifyAuthorization('BO_USERS_PWDCHANGE')==TRUE){
					echo '<p><a href="index.php?comp=usersFocus&task=changepwd&select='.intval($user_view['uid']).'">Changer le mot de passe du compte</a></p>';
				}
				echo '
				<p>
					<label for="form_type">Débannir de WoW:</label>
					<input type="radio" name="form_type" value="2">
				</p>';
			}
			else{
				echo '
				<form class="mainForm" action="index.php?comp=usersFocus&task=ban&wowid='.intval($user_view['wow_id']).'&select='.intval($user_view['uid']).'" method="post">
				<fieldset>
				<legend>Actions</legend>';
				if($secureObject->verifyAuthorization('BO_USERS_PWDCHANGE')==TRUE){
					echo '<p><a href="index.php?comp=usersFocus&task=changepwd&select='.intval($user_view['uid']).'">Changer le mot de passe du compte</a></p>';
				}
				if($secureObject->verifyAuthorization('BO_USERS_BAN')==TRUE){
					echo '
					<br />	
					<p>
						<label for="form_time">Bannir à vie (Site et WoW):</label>
						<input type="radio" name="form_time" value="0">
					</p>		
					<p>
						<label for="form_time">Bannir 1 mois sur WoW:</label>
						<input type="radio" name="form_time" value="2592000">
					</p>						
					<p>
						<label for="form_time">Bannir 1 semaine sur WoW:</label>
						<input type="radio" name="form_time" value="604800">
					</p>				
					<p>
						<label for="form_time">Bannir 3 jours sur WoW:</label>
						<input type="radio" name="form_time" value="259200">
					</p>	';
				}
			}
			if($secureObject->verifyAuthorization('BO_USERS_BAN')==TRUE){
			echo '		
				<p>
					<label for="form_banreason">Raison du Ban:</label>
					<textarea name="form_banreason" id="banreason" rows="3" cols="50"></textarea>
				</p>
				<p>
					<label for="vide">&nbsp;</label>
					<input type="submit" value="Valider"/>
				</p>	';
			}

			echo '			
			</fieldset>	
			</form>
			
			<form class="mainForm" action="index.php?comp=usersFocus&select='.$select.'&task=addWall" method="post">
			<fieldset>
				<legend>Wall</legend>';
				
			$cat = array(
				'Anti-RP',
				'Insultes',
				'Cheat',
				'Auto: Ban',
				'Auto: Déban',
				'Autres'
				);
			if($secureObject->verifyAuthorization('BO_USERS_ADDWALL')==TRUE){
				echo '<p>
						<label for="cat">Catégorie:</label>
						<select name="cat" id="cat"><option value="0">-- Selection --</option>';
						foreach($cat as $o){
							echo '<option value="'.$o.'">'.$o.'</option>';
						}
				echo '</select></p>
				<p>
					<label for="message">Message:</label>
					<textarea name="message" id="message" rows="10" cols="50"></textarea>
				</p>
				<p>
					<label for="vide">&nbsp;</label>
					<input type="submit" value="Valider"/>
				</p>
				<br />
				<br />
				';
			}				

			if(!empty($walls)){
				if($secureObject->verifyAuthorization('BO_USERS_VISUWALL')==TRUE){
					foreach($walls as $wall){
						echo '
						<div class="headerwall">
						[<a style="cursor: pointer;" onclick="javascript:affiche(\'w'.$wall->wid.'\');">+</a>
						/<a style="cursor: pointer;" onclick="javascript:cache(\'w'.$wall->wid.'\');">-</a>]
						 - '.htmlspecialchars(stripslashes($wall->username)).' - '.format_time($wall->wDate).' - '.htmlspecialchars(stripslashes($wall->wCat)).'
						 </div>
						 
						 <div id="w'.$wall->wid.'" class="wall">
						 '.htmlspecialchars(stripslashes($wall->wMessage)).'
						 </div>				
						';
					}
				}
			}
			else{
				echo '
				<p>
					<label style="text-align: center;width: 100%;">Aucun wid</label>
				</p>';
			}


			echo '					
			</fieldset>
		</form>';
?>