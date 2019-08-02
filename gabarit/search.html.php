<?php
defined( '_VALID_CORE_SEARCH' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if(!empty($_GET['task']) && $_GET['task']=='process'){
?>
<h1><?php echo $nb_results; ?> Résultats</h1>
<h4><a href="index.php?comp=search">Retour au formulaire</a></h4><br />
<ul>
<?php
	if(!empty($results)){
	
		if ($_POST['sections']=='FORUMS'){
		
			foreach($results as $result){
				echo 	'<li><a href="./index.php?comp=forum_topic&amp;select='.$result->tid.'&amp;goto='.$result->pid.'#pid'.$result->pid.'">
						'.stripslashes(htmlspecialchars($result->subject)).'</a></li>';
			}
		}
		else if ($_POST['sections']=='FORUMS_TITRE'){
		
			foreach($results as $result){
				echo 	'<li><a href="./index.php?comp=forum_topic&amp;select='.$result->tid.'">
						'.stripslashes(htmlspecialchars($result->subject)).'</a></li>';
			}
		}
		else if ($_POST['sections']=='NEWS'){
		
			foreach($results as $result){
				echo 	'<li><a href="./index.php?comp=news_comment&amp;nid='.$result->nid.'&amp;start=0">
						'.stripslashes(htmlspecialchars($result->title)).'</a></li>';	
			}
		}
		else if ($_POST['sections']=='AIDES'){
		
			foreach($results as $result){
					echo 	'<li><a href="./index.php?comp=aide&amp;task=tuto&amp;select='.$result->aid.'">
							'.stripslashes(htmlspecialchars($result->titre)).'</a></li>';	
			}
			
		}
		else if ($_POST['sections']=='BACKGROUNDS'){
		
			foreach($results as $result){
					echo 	'<li><a href="./index.php?comp=bg_show&amp;guid='.$result->guid.'">
							'.stripslashes(htmlspecialchars($result->name)).'</a></li>';	
			}
		}
		else if ($_POST['sections']=='MEMBRES'){
		
			foreach($results as $result){
					echo 	'<li><a href="./index.php?comp=profil&amp;select='.$result->uid.'">
							'.stripslashes(htmlspecialchars($result->username)).'</a></li>';	
			}
		}
		else if ($_POST['sections']=='BUGTRACKERS'){
		
			foreach($results as $result){
					echo 	'<li><a href="./index.php?comp=bugtracker_view&amp;select='.$result->btid.'">
							'.stripslashes(htmlspecialchars($result->bt_name)).'</a></li>';	
			}
		}
	}
	else{
		echo 'Aucun résultat';
	}
echo '</ul>';
}
else{
?>
<h1>Recherche</h1>
<div class="topic_top"></div>
<div class="topic_middle">
<div id="newscontenu">
<div id="blockFormulaire">
<form id="post" method="post" name="formulaire" action="index.php?comp=search&amp;task=process">
	
	<fieldset><div id="newstitre"></div>
	
		<label for="keywords">Mots Clés:</label>
			<input type="text" name="keywords" id="keywords" size="80" maxlength="70" value=""/>
			
		<br /><br />
			
		<label for="sections">Sections:</label>
			<select name="sections" id="sections" >
				<option value="FORUMS" selected="selected">Forums (titre, message)</option>
				<option value="FORUMS_TITRE" selected="selected">Forums (titre)</option>
				<option value="NEWS">News</option>
				<option value="AIDES">Aides</option>
				<option value="BACKGROUNDS">Backgrounds</option>
				<option value="MEMBRES">Membres</option>
				<option value="BUGTRACKERS">BugTrackers</option>
			</select><br />	<br />
	</fieldset>
	
	<input type="submit" name="submit" value="Envoyer"/><br />
	
</form>
</div>
</div>
</div><div class="topic_bottom"></div><br /><br />
<?php
}
require_once('./templates/'.$link_style.'bottom.php');
?>