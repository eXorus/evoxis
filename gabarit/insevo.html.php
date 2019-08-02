<?php
defined( '_VALID_CORE_INSEVO' ) or die( 'Restricted access' );
require_once('./templates/'.$link_style.'top.php');

if (!empty($_GET['task']) && $_GET['task']=="message"){
	echo "
	<h1>Inscription Envoyée</h1><h4>Merci !</h4>
	<p>L'équipe d'Evoxis a bien reçu votre demande de création de compte. Nous sommes en train de la vérifier, et une réponse vous sera donnée par e-mail.
	En attendant, nous vous invitons à vérifier où en est votre demande sur cette page :
	<center><a href=\"index.php?comp=insevo_attente\">Inscriptions en attente de validation</a></center>
	</p>
	<p>
	Un email a été envoyé. Veuillez faire attention, il se peut que ce mail soit considéré comme du courrier indésirable. Merci.
	</p>";
}
elseif(INSEVO_ACTIVATE!=1){
	echo "<h1>Inscription Désactivée</h1><h4>Désolé !</h4>
	<p>L'équipe d'Evoxis a désactiver pour le moment les inscriptions.
	Normalement cette désactivation ne dure pas longtemps. Merci de repasser plus tard.
	</p>";
}
else{
?>
<h1>Si j'ai déjà fait ma demande de compte</h1><h4>Bah je fais quoi ici alors ?</h4>
<p>
Je peux accéder directement à <a href="./index.php?comp=insevo_attente">la page des inscriptions en attente de validation</a> pour visualiser les résultats.
</p>

<h1>Inscription</h1><h4>Ca va me servir à quoi ?</h4>
S'inscrire et devenir Evoxien, c'est pouvoir :<br /><br />
	<ul>
		<li>Poster des messages dans les forums,</li>
		<li>Commenter les news,</li>
		<li>Disposer d'un espace priv&eacute;,</li>
		<li>Poster vos propres commentaires,</li>
		<li>Jouer sur le serveur World Of Warcraft,</li>
		<li>Utiliser vos propres avatars et signatures,</li>
		<li>Et bien  plus encore...</li>
	</ul>
<br />
<br />
Si vous le souhaitez, afin de mieux vous imprégner de l'univers d'Evoxis vous pouvez faire la demande d'un mentor qui sera là pour répondre à vos questions et vous guider. Parcourez le forum suivant: <a href="http://www.evoxis.info/index.php?comp=forum_board&amp;select=6&amp;start=0&amp;filter=44">Forum › Echanges Joueurs / MJs  › Dialogues (Tag Mentor)</a>.
<br />

<h1>Formulaire de création de compte</h1><h4>Là c'est sérieux.</h4>
<br />
<div id="blockFormulaire">
<form action="index.php?comp=insevo&amp;task=process" method="post">

	<?php
	if (!empty($msg_error)){
		echo '<fieldset id="blockFormulaireError"><ul>';
		echo $msg_error;
		echo '</ul>';
	}
	?>
	
<div class="topic_top"></div>
<div class="topic_middle"><br />
Login :
	<input name="create_login" id="create_login" type="text"  size="40" maxlength="50" value="<?php echo $_SESSION['create_login'] ?>"/>
Email :
	<input name="create_mail" id='create_mail' type="text"  size="40" maxlength="50" value="<?php echo $_SESSION['create_mail'] ?>"/>
	<br /><br />
</div><div class="topic_bottom"></div>
	<fieldset><legend>Entrez vos motivations pour nous rejoindre :</legend>	
	<p class="info">
	Cette partie est très importante, vous devez expliquer en quelques lignes (10-15) vos raisons, vos motivations qui vous ont amené à vouloir rejoindre la communauté Evoxis. Pensez à vous présenter pour que nous sachions qui vous êtes, votre prénom, votre âge, vos hobbies... Tous ce qui pourra apporter un plus à cette candidature sera le bienvenu. Nous sommes un serveur RP, donc expliquez aussi ce qui vous attire dans cette façon de jouer. Votre inscription repose exclusivement sur cette motivation donc soyez précis et inventif sinon vous serez tout simplement refusé.
	</p>
<div class="topic_top"></div>
<div class="topic_middle">
	<label for="create_motivation">Motivation :</label>
	<textarea name="create_motivation" id="create_motivation" rows="10" cols="5"><?php echo stripslashes($_SESSION['create_motivation']) ?></textarea><br />
</div><div class="topic_bottom"></div>
	</fieldset>

<div class="topic_top"></div>
<div class="topic_middle"><br />
Recopiez le code suivant : <img src="./inc/captcha.php" alt="Captcha"/><br />

	<input id='create_captcha' name="create_captcha" type="text" size="40" maxlength="5" />

<br />	
Si un joueur vous a parainé, merci de préciser son login (facultatif) :<br />
	<input id='create_parrain' name="create_parrain" type="text" size="40" maxlength="40" value="<?php echo $_SESSION['create_parrain'] ?>" />
<br />
Charte d'Evoxis :
	<a href="./index.php?comp=charte" onclick="window.open(this.href); return false;">[ Cliquez ici pour visualiser plus confortablement notre charte ]</a><br /><br />
	<div style="height: 280px; width: 80%; overflow: auto; margin:0 auto; text-align: left;"><?php echo stripslashes(nl2br(parse_bbcode_smiley(htmlspecialchars(CHARTE_EVOXIS)))); ?><br /></div>
	<input type="checkbox" name="charte" value="ok" <?php if($_SESSION['charte']=="ok") echo 'checked="checked"' ?>/> <b>J'ai compris et j'accepte la présente charte.</b><br /><br />

</div><div class="topic_bottom"></div>

	<br /><br /><input type="submit" class='valid' name="Submit" value="Envoyer"/><br /><br />
		
</form>
</div>
<?php
}

require_once('./templates/'.$link_style.'bottom.php');

?>