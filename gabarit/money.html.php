<?php
defined( '_VALID_CORE_MONEY' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

echo "<h2>Trésor Public</h2>";
echo '
<table class="tableau">	
	<thead>
		<th>Faction</th>
		<th>Hiérarchie</th>			
		<th>Nom</th>
		<th>Bourse</th>
		<th>Impôts</th>
		<th>Niveau</th>
	</thead>
	<tbody>		
		<tr>
			<td><img src="./templates/'.$link_style.'/ico/alliance.gif" title="Alliance"></td>
			<td>'.MONEY_ALLIANCE_FONCTION.'</td>
			<td>'.MONEY_ALLIANCE_NOM.'</td>
			<td>'.
			$aBoursePO.'<img src="./templates/'.$link_style.'/ico/gold.png" title="Or">'.
			$aBoursePA.'<img src="./templates/'.$link_style.'/ico/silver.png" title="Argent">'.
			$aBoursePC.'<img src="./templates/'.$link_style.'/ico/copper.png" title="Cuivre">
			</td>
			<td>'.MONEY_ALLIANCE_POURCENTAGE.'%</td>
			<td>'.MONEY_ALLIANCE_LVL_MIN.' à '.MONEY_ALLIANCE_LVL_MAX.'</td>
		</tr>	
		<tr>
			<td><img src="./templates/'.$link_style.'/ico/horde.gif" title="Horde"></td>
			<td>'.MONEY_HORDE_FONCTION.'</td>
			<td>'.MONEY_HORDE_NOM.'</td>
			<td>'.
			$hBoursePO.'<img src="./templates/'.$link_style.'/ico/gold.png" title="Or">'.
			$hBoursePA.'<img src="./templates/'.$link_style.'/ico/silver.png" title="Argent">'.
			$hBoursePC.'<img src="./templates/'.$link_style.'/ico/copper.png" title="Cuivre">
			</td>
			<td>'.MONEY_HORDE_POURCENTAGE.'%</td>
			<td>'.MONEY_HORDE_LVL_MIN.' à '.MONEY_HORDE_LVL_MAX.'</td>
		</tr>
	</tbody>
</table>
<b>Bourse:</b> <i>Trésorerie actuel de la faction, permet d\'acheter des bâtiments, construire, rémunérer ...</i><br />
<b>Impôts:</b>  <i>Pourcentage prélevé tous les mois sur la bourse de chaque citoyen</i><br />
<b>Niveau:</b> <i>Tranche de niveau qui seront prélevé de l\'impôt</i><br />
<br /><br />
';

if($aAcces==1 || $hAcces==1){
	echo '
	<h2>Privé</h2>
	<form class="mainForm"  action="./index.php?comp=money&amp;task=process" method="post">';
	
	if($aAcces==1){
		?>		
		<fieldset>
			<legend>Alliance</legend>
			<p>
				<label for="form_aPourcentage">Pourcentage:</label>
				<input name="form_aPourcentage" id='form_aPourcentage' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(MONEY_ALLIANCE_POURCENTAGE)  ?>"/>
			</p>
			<p>
				<label for="form_aNiveauMin">Niveau Minimum:</label>
				<input name="form_aNiveauMin" id='form_aNiveauMin' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(MONEY_ALLIANCE_LVL_MIN)  ?>"/>
			</p>
			<p>
				<label for="form_aNiveauMax">Niveau Maximum:</label>
				<input name="form_aNiveauMax" id='form_aNiveauMax' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(MONEY_ALLIANCE_LVL_MAX)  ?>"/>
			</p>
		</fieldset>			
		<?php
	}
	if($hAcces==1){
		?>	
		<fieldset>
			<legend>Horde</legend>
			<p>
				<label for="form_hPourcentage">Pourcentage:</label>
				<input name="form_hPourcentage" id='form_hPourcentage' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(MONEY_HORDE_POURCENTAGE)  ?>"/>
			</p>
			<p>
				<label for="form_hNiveauMin">Niveau Minimum:</label>
				<input name="form_hNiveauMin" id='form_hNiveauMin' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(MONEY_HORDE_LVL_MIN)  ?>"/>
			</p>
			
			<p>
				<label for="form_hNiveauMax">Niveau Maximum:</label>
				<input name="form_hNiveauMax" id='form_hNiveauMax' type="text"  size="40" maxlength="50" value="<?php echo stripslashes(MONEY_HORDE_LVL_MAX)  ?>"/>
			</p>
		</fieldset>			
		<?php
	}
	echo '
	<p>
			<input class="ok" type="submit" name="Submit" value="OK" /><input class="ok" type="submit" name="Retour" value="Retour" />
		</p>
	</form>';
}

require_once('./templates/'.$link_style.'bottom.php');
?>