<?php
defined( '_ADM_VALID_CORE_BGCHECKFOCUS' ) or die( 'Restricted access' );

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
<form class="mainForm"  action="./index.php?comp=bgcheck&task=process_bgcheck" method="post">
			<fieldset>
				<legend><?php echo 'Background de '.htmlspecialchars(stripslashes($name)) ?></legend>
				<p>
					<label for="form_class">Class: </label>
					<input type="text" name="form_class" maxlength="200" disabled="disabled" value="<?php echo $class ?>"/>
				</p>
				<p>
					<label for="form_race">Race: </label>
					<input type="text" name="form_race" maxlength="200" disabled="disabled" value="<?php echo $race ?>"/>
				</p>
				<p>
					<label for="form_creation">Creation: </label>
					<input type="text" name="form_creation" maxlength="200" disabled="disabled" value="<?php echo format_time($creation_time) ?>"/>
				</p>
				<p>
					<label for="form_modification">Dernière modification: </label>
					<input type="text" name="form_modification" maxlength="200" disabled="disabled" value="<?php echo format_time($last_edit_time) ?>"/>
				</p>
				<p>
					<label for="form_statut">Statut: </label>
					<input type="text" name="form_statut" maxlength="200" disabled="disabled" value="<?php echo $statut ?>"/>
				</p>
				<p>
					<label for="form_login">Login: </label>
					<input type="text" name="form_login" maxlength="200" disabled="disabled" value="<?php echo htmlspecialchars(stripslashes($username)) ?>"/>
				</p>
				<p>
					<label for="form_persos">Autres persos: </label>
					<input type="text" name="form_persos" maxlength="200" disabled="disabled" value="<?php echo htmlspecialchars(stripslashes($list_others)) ?>"/>
				</p>
			</fieldset>
			<fieldset>
				<legend>Background</legend>
				<p style="background-color: #CCC;">
					<?php echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($background)))) ?>
				</p>
			</fieldset>	
			<?php if($secureObject->verifyAuthorization('BO_BGCHECK_VALIDATE')==TRUE){?>
			<fieldset>
				<legend>Action</legend>
				<p>			
					<label for="form_favourite">Mon Coup de Coeur</label>
					<input type="checkbox" name="form_favourite" />
				</p>
				<br />
				<p>
					<label for="form_bg">Commentaire:</label>
					<textarea name="comment" id="comment" rows="10" cols="50"></textarea>
				</p>				
				<p>
					<label for="form_valid">Refusé:</label>
					<input type="radio" name="result" value="NON_VALIDE">
				</p>
				<p>
					<label for="form_valid">Accepté:</label>
					<input type="radio" name="result" value="VALIDE">
				</p>
			</fieldset>		
			<?php } ?>
			<input type="hidden" name="guid" value="<?php echo $guid  ?>">
			<input type="hidden" name="wow_id" value="<?php echo $wow_id  ?>">
			<input type="hidden" name="name" value="<?php echo $name  ?>">
			<p>
				<input class="ok" type="submit" name="Submit" value="OK" /><input class="ok" type="button" name="Retour" value="Retour" onclick="history.go(-1)"/>
			</p>
			<fieldset>
				<legend>Historique</legend>
				<?php
				if(!empty($bg_h)){
				foreach($bg_h as $one_bg_h){
					echo '
					<div class="headerwall">
					[<a style="cursor: pointer;" onclick="javascript:affiche(\'w'.$one_bg_h->id.'\');">+</a>
					/<a style="cursor: pointer;" onclick="javascript:cache(\'w'.$one_bg_h->id.'\');">-</a>]
					 - '.htmlspecialchars(stripslashes($one_bg_h->username)).' - '.format_time($one_bg_h->validation_date).' <br /> '.htmlspecialchars(stripslashes($one_bg_h->comment)).'
					 </div>
					 
					 <div id="w'.$one_bg_h->id.'" class="wall">
					 '.stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars($one_bg_h->background)))).'
					 </div>				
					';
				}
			}
			else{
				echo '
				<p>
					<label style="text-align: center;width: 100%;">Aucun historique</label>
				</p>';
			}
				?>				
			</fieldset>		
		</form>
