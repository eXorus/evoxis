</div>
<div id="footer_lite">
	<p>
				© Copyright www.evoxis.info 2008<br />
				Code par eXoria - <a href="index.php?comp=changelog">ChangeLog</a> // Design par Bisou<br />
				Toute reproduction totale ou partielle est interdite sans l'accord des auteurs<br />
				<?php 
					$countDB = $db->getNbQuery() + $db_realmd->getNbQuery() + $db_characters->getNbQuery();
					echo 'Page générée en '.round(microtime(true) - $texec_begin, 4).' secondes avec '.$countDB.' requêtes';
				?>
			</p>
<br />
<a href="http://www.mozilla-europe.org/fr/firefox/" target="_blank"><img src="./templates/default/ico/firefox.jpg" alt="Téléchargez Firefox !" title="Téléchargez Firefox !" /></a>
<a href="http://www.google.com/chrome/?hl=fr" target="_blank"><img src="./templates/default/ico/chrome.jpg" alt="Téléchargez Google Chrome !" title="Téléchargez Google Chrome !" /></a>
<a href="http://validator.w3.org/check?uri=http://dev.evoxis.info/" target="_blank"><img src="./templates/default/ico/w3c_xhtml.jpg" alt="Ce site est valide XHTML 1.0 Transitional" title="Ce site est valide XHTML 1.0 Transitional" /></a>
<a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank"><img src="./templates/default/ico/w3c_css.jpg" alt="Ce site est valide CSS 2.1" title="Ce site est valide CSS 2.1" /></a>
</div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1752864-1";
urchinTracker();
</script>

<span id="bot"></span>
</body>
</html>       