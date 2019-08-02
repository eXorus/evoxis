<?php
//Pagination
function displayPaginationBar($ObjectTotal, $CurrentPage, $link, $ObjectByPage){
	$CurrentPage = intval($CurrentPage);
	$ObjectTotal = intval($ObjectTotal);
	
	if(empty($CurrentPage)) $CurrentPage=1;
	$LastPage = ceil($ObjectTotal/$ObjectByPage);


	echo '<div class="pagine">';
	echo '<ul class="pagination">';
	echo '<li class="previous-off"> '.$ObjectTotal.' Objects</li>';
	
	//Premier & Précédent
	if($CurrentPage==1){
		echo '<li class="previous-off">« «</li>';
		echo '<li class="previous-off">« Précédent</li>';
	}
	else{
		echo '<li class="previous"><a href="'.$link.'0">« «</a></li>';
		echo '<li class="previous"><a href="'.$link.($CurrentPage-2)*$ObjectByPage.'">« Précédent</a></li>';
	}
		
	//Body
	for ($i=$CurrentPage-5;$i<=$CurrentPage+5;$i++){
		if($i>0 && $i<=$LastPage){
			if($i==$CurrentPage){
				echo '<li class="active">'.$i.'</li>';
			}
			else{
				echo '<li><a href="'.$link.($i-1)*$ObjectByPage.'">'.$i.'</a></li>';
			}
		}
	}
	
	//Suivant & Dernier
	if($CurrentPage==$LastPage){
		echo '<li class="next-off">Suivant »</li>';
		echo '<li class="next-off">» »</li>';
	}
	else{
		echo '<li class="next"><a href="'.$link.$CurrentPage*$ObjectByPage.'">Suivant »</a></li>';
		echo '<li class="next"><a href="'.$link.($LastPage-1)*$ObjectByPage.'">» »</a></li>';
	}
	
	echo '</ul></div>';
	
}


//Genere une chaine de caractère aléatoire
function randomString( $length = 6, $char = 'abcdefghijklmnopqrstuvwxyz0123456789' ) {
    $str = '';
    $max = strlen($char)-1;
    for ($i=1; $i<=$length; $i++) {
        $str .= $char[ rand(0, $max) ];
    }
    return $str;
} 

function date_fr($date_en){
	list($date, $time) = explode(" ", $date_en);
	
	list($year, $month, $day) = explode("-", $date);
	list($hour, $min, $sec) = explode(":", $time);
	
	return "<center>$day/$month/$year<br :>$hour:$min:$sec</center>";
}

function format_time($timestamp, $date_only = false)
{
	if (empty($timestamp))
		return 'Jamais';
		
	$user_timezone = 0;
	$server_timezone = 0;

	$diff = ($user_timezone - $server_timezone) * 3600;
	$timestamp += $diff;
	$now = time();
	
	$date_format = 'Y-m-d';

	$date = date($date_format, $timestamp);
	$today = date($date_format, $now+$diff);
	$yesterday = date($date_format, $now+$diff-86400);

	if ($date == $today)
		$date = 'Aujourd\'hui';
	else if ($date == $yesterday)
		$date = 'Hier';
		
	$time_format = 'H:i:s';

	if (!$date_only)
		return $date.' '.date($time_format, $timestamp);
	else
		return $date;
}


function switchcolor()
 { 
   static $col;
   $couleur1 = "#F7F7F7";
   $couleur2 = "#FFFFFF";

    if ($col == $couleur1)
     {
       $col = $couleur2;
     }
    else
     {
       $col = $couleur1;
     }
    return $col; 
 }
  
 
function parse_bbcode_smiley($texte){
	/*
	##Smiley
	*/
	$in=array(
     " :alien: ",
     " :angel: ",
     " :angry: ",
     " :arrow: ",
     " :axe: ",
	 " :baby: ",
	 " :banana: ",
	 " :beer: ",
	 " :beer2: ",
	 " :beer3: ",
	 " :bigsmile: ",
	 " :birth: ",
	 " :birth2: ",
	 " :blabla: ",
	 " :blink: ",
	 " :blush: ",
	 " :boing: ",
	 " :boing2: ",
	 " :bravo: ",
	 " :bye: ",
	 " :cap: ",
	 " :censored: ",
	 " :cigar: ",
	 " :clap: ",
	 " :clown: ",
	 " :computer: ",
	 " :confused: ",
	 " :construction: ",
	 " :cook: ",
	 " :cool: ",
	 " :cry: ",
	 " :cuthead: ",
	 " :dead: ",
	 " :devil: ",
	 " :dontknow: ",
	 " :down: ",
	 " :erm: ",
	 " :evil: ",
	 " :fear: ",
	 " :fight: ",
	 " :first: ",
	 " :fish: ",
	 " :fishing: ",
	 " :goodorbad: ",
	 " :grrr: ",
	 " :grrr2: ",
	 " :gun: ",
	 " :gun2: ",
	 " :hat: ",
	 " :help: ",
	 " :hit: ",
	 " :hospital: ",
	 " :hourra: ",
	 " :hs: ",
	 " :hug: ",
	 " :hug2: ",
	 " :icecream: ",
	 " :idea: ",
	 " :ike: ",
	 " :king: ",
	 " :kiss: ",
	 " :kiss2: ",
	 " :kiss3: ",
	 " :lol: ",
	 " :love: ",
	 " :love2: ",
	 " :love3: ",
	 " :luck: ",
	 " :money: ",
	 " :pouah: ",
	 " :muted: ",
	 " :muted2: ",
	 " :myhero: ",
	 " :neutral: ",
	 " :ninja: ",
	 " :no: ",
	 " :nocomment: ",
	 " :noway: ",
	 " :ohmy: ",
	 " :oops: ",
	 " :paf2: ",
	 " :paf3: ",
	 " :peanuts: ",
	 " :pinch: ",
	 " :pirate: ",
	 " :pirate2: ",
	 " :please: ",
	 " :pouet: ",
	 " :prisoner: ",
	 " :puke: ",
	 " :punk: ",
	 " :question: ",
	 " :radioactive: ",
	 " :rambo: ",
	 " :read: ",
	 " :rebel: ",
	 " :rip: ",
	 " :rockband: ",
	 " :roll: ",
	 " :roll2: ",
	 " :rules: ",
	 " :sad: ",
	 " :santa: ",
	 " :scooter: ",
	 " :sick: ",
	 " :sleep: ",
	 " :sleep2: ",
     " :smile: ",
     " :sorcerer: ",
     " :sorry: ",
     " :spam: ",
     " :spank: ",
     " :spider: ",
     " :spy: ",
     " :strong: ",
     " :stupid: ",
     " :sucks: ",
     " :sun: ",
     " :sun2: ",
     " :tongue: ",
     " :tongue2: ",
     " :upsidedown: ",
     " :veryangry: ",
     " :byesad: ",
     " :vs: ",
     " :wacko: ",
     " :wall: ",
     " :warning: ",
     " :warrior: ",
     " :wave: ",
     " :welcome: ",
     " :welcome2: ",
     " :what: ",
     " :what2: ",
     " :whistling: ",
     " :wink: ",
     " :yahoo: ",
     " :yes: "
	 );

	$out=array(
     ' <img src="./img/smileys/alien.gif" alt="alien" /> ' ,
     ' <img src="./img/smileys/angel.gif" alt="angel" /> ' ,
     ' <img src="./img/smileys/angry.gif" alt="angry" /> ' ,
     ' <img src="./img/smileys/arrow.gif" alt="arrow" /> ' ,
     ' <img src="./img/smileys/axe.gif" alt="axe" /> ' ,
     ' <img src="./img/smileys/baby.gif" alt="baby" /> ' ,
     ' <img src="./img/smileys/banana.gif" alt="banana" /> ' ,
     ' <img src="./img/smileys/beer.gif" alt="beer" /> ' ,
     ' <img src="./img/smileys/beer2.gif" alt="beer2" /> ' ,
     ' <img src="./img/smileys/beer3.gif" alt="beer3" /> ' ,
     ' <img src="./img/smileys/bigsmile.gif" alt="bigsmile" /> ' ,
     ' <img src="./img/smileys/birth.gif" alt="birth" /> ' ,
     ' <img src="./img/smileys/birth2.gif" alt="birth2" /> ' ,
     ' <img src="./img/smileys/blabla.gif" alt="blabla" /> ' ,
     ' <img src="./img/smileys/blink.gif" alt="blink" /> ' ,
     ' <img src="./img/smileys/blush.gif" alt="blush" /> ' ,
     ' <img src="./img/smileys/boing.gif" alt="boing" /> ' ,
     ' <img src="./img/smileys/boing2.gif" alt="boing2" /> ' ,
     ' <img src="./img/smileys/bravo.gif" alt="bravo" /> ' ,
     ' <img src="./img/smileys/bye.gif" alt="bye" /> ' ,
     ' <img src="./img/smileys/cap.gif" alt="cap" /> ' ,
     ' <img src="./img/smileys/censored.gif" alt="censored" /> ' ,
     ' <img src="./img/smileys/cigar.gif" alt="cigar" /> ' ,
     ' <img src="./img/smileys/clap.gif" alt="clap" /> ' ,
     ' <img src="./img/smileys/clown.gif" alt="clown" /> ' ,
     ' <img src="./img/smileys/computer.gif" alt="computer" /> ' ,
     ' <img src="./img/smileys/confused.gif" alt="confused" /> ' ,
     ' <img src="./img/smileys/construction.gif" alt="construction" /> ' ,
     ' <img src="./img/smileys/cook.gif" alt="cook" /> ' ,
     ' <img src="./img/smileys/cool.gif" alt="cool" /> ' ,
     ' <img src="./img/smileys/cry.gif" alt="cry" /> ' ,
     ' <img src="./img/smileys/cuthead.gif" alt="cuthead" /> ' ,
     ' <img src="./img/smileys/dead.gif" alt="dead" /> ' ,
     ' <img src="./img/smileys/devil.gif" alt="devil" /> ' ,
     ' <img src="./img/smileys/dontknow.gif" alt="dontknow" /> ' ,
     ' <img src="./img/smileys/down.gif" alt="down" /> ' ,
     ' <img src="./img/smileys/erm.gif" alt="erm" /> ' ,
     ' <img src="./img/smileys/evil.gif" alt="evil" /> ' ,
     ' <img src="./img/smileys/fear.gif" alt="fear" /> ' ,
     ' <img src="./img/smileys/fight.gif" alt="fight" /> ' ,
     ' <img src="./img/smileys/first.gif" alt="" /> ' ,
     ' <img src="./img/smileys/fish.gif" alt="" /> ' ,
     ' <img src="./img/smileys/fishing.gif" alt="fishing" /> ' ,
     ' <img src="./img/smileys/goodorbad.gif" alt="goodorbad" /> ' ,
     ' <img src="./img/smileys/grrr.gif" alt="grrr" /> ' ,
     ' <img src="./img/smileys/grrr2.gif" alt="grrr2" /> ' ,
     ' <img src="./img/smileys/gun.gif" alt="gun" /> ' ,
     ' <img src="./img/smileys/gun2.gif" alt="gun2" /> ' ,
     ' <img src="./img/smileys/hat.gif" alt="hat" /> ' ,
     ' <img src="./img/smileys/help.gif" alt="help" /> ' ,
     ' <img src="./img/smileys/hit.gif" alt="hit" /> ' ,
     ' <img src="./img/smileys/hospital.gif" alt="hospital" /> ' ,
     ' <img src="./img/smileys/hourra.gif" alt="hourra" /> ' ,
     ' <img src="./img/smileys/hs.gif" alt="hs" /> ' ,
     ' <img src="./img/smileys/hug.gif" alt="hug" /> ' ,
     ' <img src="./img/smileys/hug2.gif" alt="hug2" /> ' ,
     ' <img src="./img/smileys/icecream.gif" alt="icecream" /> ' ,
     ' <img src="./img/smileys/idea.gif" alt="idea" /> ' ,
     ' <img src="./img/smileys/ike.gif" alt="ike" /> ' ,
     ' <img src="./img/smileys/king.gif" alt="king" /> ' ,
     ' <img src="./img/smileys/kiss.gif" alt="kiss" /> ' ,
     ' <img src="./img/smileys/kiss2.gif" alt="kiss2" /> ' ,
     ' <img src="./img/smileys/kiss3.gif" alt="kiss3" /> ' ,
     ' <img src="./img/smileys/lol.gif" alt="lol" /> ' ,
     ' <img src="./img/smileys/love.gif" alt="love" /> ' ,
     ' <img src="./img/smileys/love2.gif" alt="love2" /> ' ,
     ' <img src="./img/smileys/love3.gif" alt="love3" /> ' ,
     ' <img src="./img/smileys/luck.gif" alt="luck" /> ' ,
     ' <img src="./img/smileys/money.gif" alt="money" /> ' ,
     ' <img src="./img/smileys/pouah.gif" alt="pouah" /> ' ,
     ' <img src="./img/smileys/muted.gif" alt="muted" /> ' ,
     ' <img src="./img/smileys/muted2.gif" alt="muted2" /> ' ,
     ' <img src="./img/smileys/myhero.gif" alt="myhero" /> ' ,
     ' <img src="./img/smileys/neutral.gif" alt="neutral" /> ' ,
     ' <img src="./img/smileys/ninja.gif" alt="ninja" /> ' ,
     ' <img src="./img/smileys/no.gif" alt="no" /> ' ,
     ' <img src="./img/smileys/nocomment.gif" alt="nocomment" /> ' ,
     ' <img src="./img/smileys/noway.gif" alt="noway" /> ' ,
     ' <img src="./img/smileys/ohmy.gif" alt="ohmy" /> ' ,
     ' <img src="./img/smileys/oops.gif" alt="oops" /> ' ,
     ' <img src="./img/smileys/paf2.gif" alt="paf2" /> ' ,
     ' <img src="./img/smileys/paf3.gif" alt="paf3" /> ' ,
     ' <img src="./img/smileys/peanuts.gif" alt="peanuts" /> ' ,
     ' <img src="./img/smileys/pinch.gif" alt="pinch" /> ' ,
     ' <img src="./img/smileys/pirate.gif" alt="pirate" /> ' ,
     ' <img src="./img/smileys/pirate2.gif" alt="pirate2" /> ' ,
     ' <img src="./img/smileys/please.gif" alt="please" /> ' ,
     ' <img src="./img/smileys/pouet.gif" alt="pouet" /> ' ,
     ' <img src="./img/smileys/prisoner.gif" alt="prisoner" /> ' ,
     ' <img src="./img/smileys/puke.gif" alt="puke" /> ' ,
     ' <img src="./img/smileys/punk.gif" alt="punk" /> ' ,
     ' <img src="./img/smileys/question.gif" alt="question" /> ' ,
     ' <img src="./img/smileys/radioactive.gif" alt="radioactive" /> ' ,
     ' <img src="./img/smileys/rambo.gif" alt="rambo" /> ' ,
     ' <img src="./img/smileys/read.gif" alt="read" /> ' ,
     ' <img src="./img/smileys/rebel.gif" alt="rebel" /> ' ,
     ' <img src="./img/smileys/rip.gif" alt="rip" /> ' ,
     ' <img src="./img/smileys/rockband.gif" alt="rockband" /> ' ,
     ' <img src="./img/smileys/roll.gif" alt="roll" /> ' ,
     ' <img src="./img/smileys/roll2.gif" alt="roll2" /> ' ,
     ' <img src="./img/smileys/rules.gif" alt="rules" /> ' ,
     ' <img src="./img/smileys/sad.gif" alt="sad" /> ' ,
     ' <img src="./img/smileys/santa.gif" alt="santa" /> ' ,
     ' <img src="./img/smileys/scooter.gif" alt="scooter" /> ' ,
     ' <img src="./img/smileys/sick.gif" alt="sick" /> ' ,
     ' <img src="./img/smileys/sleep.gif" alt="sleep" /> ' ,
     ' <img src="./img/smileys/sleep2.gif" alt="sleep2" /> ' ,
     ' <img src="./img/smileys/smile.gif" alt="smile" /> ' ,
     ' <img src="./img/smileys/sorcerer.gif" alt="sorcerer" /> ' ,
     ' <img src="./img/smileys/sorry.gif" alt="sorry" /> ' ,
     ' <img src="./img/smileys/spam.gif" alt="spam" /> ' ,
     ' <img src="./img/smileys/spank.gif" alt="spank" /> ' ,
     ' <img src="./img/smileys/spider.gif" alt="spider" /> ' ,
     ' <img src="./img/smileys/spy.gif" alt="spy" /> ' ,
     ' <img src="./img/smileys/strong.gif" alt="strong" /> ' ,
     ' <img src="./img/smileys/stupid.gif" alt="stupid" /> ' ,
     ' <img src="./img/smileys/sucks.gif" alt="sucks" /> ' ,
     ' <img src="./img/smileys/sun.gif" alt="sun" /> ' ,
     ' <img src="./img/smileys/sun2.gif" alt="sun2" /> ' ,
     ' <img src="./img/smileys/tongue.gif" alt="tongue" /> ' ,
     ' <img src="./img/smileys/tongue2.gif" alt="tongue2" /> ' ,
     ' <img src="./img/smileys/upsidedown.gif" alt="upsidedown" /> ' ,
     ' <img src="./img/smileys/veryangry.gif" alt="veryangry" /> ' ,
	 ' <img src="./img/smileys/byesad.gif" alt="byesad" /> ' ,
     ' <img src="./img/smileys/vs.gif" alt="vs" /> ' ,
     ' <img src="./img/smileys/wacko.gif" alt="wacko" /> ' ,
     ' <img src="./img/smileys/wall.gif" alt="wall" /> ' ,
     ' <img src="./img/smileys/warning.gif" alt="warning" /> ' ,
     ' <img src="./img/smileys/warrior.gif" alt="warrior" /> ' ,
     ' <img src="./img/smileys/wave.gif" alt="wave" /> ' ,
     ' <img src="./img/smileys/welcome.gif" alt="welcome" /> ' ,
     ' <img src="./img/smileys/welcome2.gif" alt="welcome2" /> ' ,
     ' <img src="./img/smileys/what.gif" alt="what" /> ' ,
     ' <img src="./img/smileys/what2.gif" alt="what2" /> ' ,
     ' <img src="./img/smileys/whistling.gif" alt="whistling" /> ' ,
     ' <img src="./img/smileys/wink.gif" alt="wink" /> ' ,
     ' <img src="./img/smileys/yahoo.gif" alt="yahoo" /> ' ,
     ' <img src="./img/smileys/yes.gif" alt="yes" /> '
	 );
	 
	$texte = str_replace($in,$out,$texte);
	//##EOF Smiley
	
	/*
	##Mise en forme du texte SIMPLE
	*/
	$in=array(
           "[b]" , // gras
           "[/b]" , 
           "[i]", //italic
           "[/i]", 
           "[u]", // souligné
		   "[/u]", 
		   "[s]", // barré
		   "[/s]", 		   
		   "[hrp]", // hrp
		   "[/hrp]", 
		   "[left]", // position left
		   "[/left]", 
		   "[center]", // position center
		   "[/center]", 
		   "[right]", // position right
		   "[/right]", 
           );

	$out=array(
           '<strong>' , // gras
           '</strong>' , 
           '<em>', //italic
           '</em>', 
           '<span style="text-decoration:underline;">', // souligné
		   '</span>', 
		   '<span style="text-decoration:line-through;">', // barré
		   '</span>', 		
		   '<div class="quote"><table class="hrp"><tr><td width="23px"><img src="./templates/default/ico/hrp.png" alt="Hors Role-Play"/></td><td class="hrp"><strong>Message Hors Role-Play : survolez-le avec votre souris pour l\'afficher.</strong></td></tr><tr><td></td><td><div class="hrp">', // hrp
		   '</div></td></tr></table></div>',    
		   '<div style="text-align: left;">', // position left
		   '</div>', 
		   '<div style="text-align: center;">', // position center
		   '</div>', 
		   '<div style="text-align: right;">', // position right
		   '</div>', 
           );
	$texte = str_replace($in,$out,$texte);
	//##EOF Mise en forme du texte SIMPLE
	
	/*
	##Mise en forme du texte MODERATE
	*/
	$in=array(
           "_MODERATE_POLITESSE_" ,
           "_MODERATE_INSULTE_" , 
           "_MODERATE_ANTI-SMS_", 
           "_MODERATE_ILLEGAL_", 
           "_MODERATE_FLOOD_",
		   "_MODERATE_PUBLICITE_", 
		   "_MODERATE_HORS-SUJET_", 
		   "_MODERATE_DIVERS_"
           );

	$out=array(
           '<span style="color: red;"><strong>Vous devez respecter des règles élémentaires de politesse.</strong></span><br />' ,
		   '<span style="color: red;"><strong>Quel que soit le sujet, vous ne devez pas en venir aux insultes.</strong></span><br />' ,
		   '<span style="color: red;"><strong>Vous devez écrire avec une orthographe convenable.</strong></span><br />' ,
		   '<span style="color: red;"><strong>Les sujets à caractère illégal sont interdits et seront supprimés.</strong></span><br />' ,
		   '<span style="color: red;"><strong>Il est interdit de flooder hors de la section réservée à cette effet.</strong></span><br />' ,
		   '<span style="color: red;"><strong>Toute publicité est interdite.</strong></span><br />' ,
		   '<span style="color: red;"><strong>Hors-Sujet.</strong></span><br />' ,
		   '<span style="color: red;"><strong>Votre message ne correspond pas aux règles de Evoxis.</strong></span><br />' 
           );
	$texte = str_replace($in,$out,$texte);
	//##EOF Mise en forme du texte MODERATE
	
	/*
	##Mise en forme du texte COMPLEXE
	*/		
	//Lien cliquable
	$texte = str_replace(']www.',']http://www.',$texte);
	$texte = str_replace('=www.','=http://www.',$texte);
	//$texte = preg_replace('# http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $texte); //lien cliquable
	$texte = preg_replace('!\[url\](.*)\[/url\]!iU', '<a href="$1" target="_blank">$1</a>', $texte);
	$texte = preg_replace('!\[url=(.*)\](.*)\[/url\]!iU', '<a href="$1" target="_blank">$2</a>', $texte);
	
	$texte = preg_replace('#\[img\](.+)\[/img\]#isU','<div style="overflow: auto; "><img src="$1" alt="$1"/></div>', $texte); //Image
	//$texte = preg_replace('`\[quote\](.+)\[/quote\]`isU', '<div id="quote">$1</div>', $texte); //quote
	$texte = preg_replace("#\[youtube\](.*?)\[/youtube\]#si", "[youtube:$uid]\\1[/youtube:$uid]", $texte);
	// [youtube] et [/youtube]
	$texte = preg_replace("#\[youtube:$uid\](.*?)\[/youtube:$uid\]#si", "<center><object width=\"425\" height=\"350\"><param name=\"movie\" value=\"\\1\"></param><embed src=\"\\1\" type=\"application/x-shockwave-flash\" width=\"425\" height=\"350\"></embed></object></center>"."[/youtube:$uid]", $texte);
	$texte = str_replace("[/youtube:$uid]", "", $texte);
	$texte = str_replace("http://www.youtube.com/watch?v=", "http://www.youtube.com/v/", $texte);
	$texte = str_replace("http://youtube.com/watch?v=", "http://www.youtube.com/v/", $texte);
	$texte = str_replace("http://fr.youtube.com/watch?v=", "http://www.youtube.com/v/", $texte);
	
	$texte=str_replace("[/color]", "</span>", $texte);
	$texte=ereg_replace("\[color= ?(([[:alpha:]]+)|(#[[:digit:][:alpha:]]{6})) ?\]", "<span style=\"color: \\1\">", $texte);
	
	//Quote
    $texte = preg_replace("/\[quote](.*)\[\/quote\]/Uis", "<div class=\"quote\"><table class=\"hrp\"><tr><td width=\"23px\"><img src=\"./templates/default/ico/quote.png\" alt=\"Citation\"/></td><td class=\"hrp\"><strong>Citation :</strong></td></tr><tr><td></td><td><em>\\1</em></td></tr></table></div>", $texte);
    $texte = preg_replace("/\[quote=(.*)](.*)\[\/quote\]/Uis", "<div class=\"quote\"><table class=\"hrp\"><tr><td width=\"23px\"><img src=\"./templates/default/ico/quote.png\" alt=\"Citation\"/></td><td class=\"hrp\"><strong>Citation de: \\1</strong></td></tr><tr><td></td><td><em>\\2</em></td></tr></table></div>", $texte);
	//##EOF Mise en forme du texte COMPLEXE

	return $texte;
}





function update_ivo($what, $uid=0, $value=0){
	global $db;
	
	if(empty($uid)){
		$uid=$_SESSION['uid'];
	}
	
	//Update what
	if($what=='nb_post'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_post=nb_post+1 WHERE uid = '$uid'");	
	}
	else if($what=='nb_topic'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_topic=nb_topic+1 WHERE uid = '$uid'");	
	}
	else if($what=='nb_news_commentaire'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_news_commentaire=nb_news_commentaire+1 WHERE uid = '$uid'");	
	}
	else if($what=='nb_backgrounds_commentaire'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_backgrounds_commentaire=nb_backgrounds_commentaire+1 WHERE uid = '$uid'");	
	}
	else if($what=='nb_bug'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_bug=nb_bug+1 WHERE uid = '$uid'");	
	}
	else if($what=='nb_bug_resolve'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_bug_resolve=nb_bug_resolve+1 WHERE uid = '$uid'");	
	}
	else if($what=='nb_bg_edition'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_bg_edition=nb_bg_edition+1 WHERE uid = '$uid'");	
	}
	else if($what=='nb_bg_create'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_bg_create=nb_bg_create+1 WHERE uid = '$uid'");	
	}
	else if($what=='nb_bg_vote'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_bg_vote=nb_bg_vote+$value WHERE uid = '$uid'");	
	}
	else if($what=='nb_filleul'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_filleul=nb_filleul+1 WHERE uid = '$uid'");	
	}
	else if($what=='nb_news_propose'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET nb_news_propose=nb_news_propose+1 WHERE uid = '$uid'");	
	}
	else if($what=='vote_positif'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET vote_positif=vote_positif+1 WHERE uid = '$uid'");	
	}
	else if($what=='vote_negatif'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET vote_negatif=vote_negatif+1 WHERE uid = '$uid'");	
	}
	else if($what=='avertissements'){
		$ivo = $db->Send_Query("UPDATE exo_indices SET avertissements=avertissements+$value WHERE uid = '$uid'");	
	}
	
	//Prend les valeurs
	$rq_ivo = $db->Send_Query("SELECT nb_post, nb_topic, nb_news_commentaire, nb_backgrounds_commentaire, nb_bug, nb_bug_resolve, nb_bg_edition, nb_bg_create, nb_bg_vote, nb_filleul, nb_news_propose, vote_positif, vote_negatif, extra, avertissements FROM exo_indices WHERE uid = '$uid'");			
	$ivo_values = $db->get_array($rq_ivo);
	
	$nb_post = $ivo_values['nb_post'];
	$nb_topic = $ivo_values['nb_topic'];
	$nb_news_commentaire = $ivo_values['nb_news_commentaire'];
	$nb_backgrounds_commentaire = $ivo_values['nb_backgrounds_commentaire'];
	$nb_bug = $ivo_values['nb_bug'];
	$nb_bug_resolve = $ivo_values['nb_bug_resolve'];
	$nb_bg_edition = $ivo_values['nb_bg_edition'];
	$nb_bg_create = $ivo_values['nb_bg_create'];
	$nb_bg_vote = $ivo_values['nb_bg_vote'];
	$nb_filleul = $ivo_values['nb_filleul'];
	$nb_news_propose = $ivo_values['nb_news_propose'];
	$vote_positif = $ivo_values['vote_positif'];
	$vote_negatif = $ivo_values['vote_negatif'];
	$extra = $ivo_values['extra'];
	$avertissements = $ivo_values['avertissements'];
	
	//Algorithm
	$nb_post = $nb_post*0.5;
	$vote_positif = $vote_positif*1;
	$vote_negatif = $vote_negatif*1;
	$nb_bg_edition = $nb_bg_edition*1;
	$nb_topic = $nb_topic*2;
	$nb_bg_create = $nb_bg_create*2;
	$nb_news_commentaire = $nb_news_commentaire*3;
	$nb_backgrounds_commentaire = $nb_backgrounds_commentaire*4;
	$nb_bug = $nb_bug*3;
	$nb_bg_vote = $nb_bg_vote*3;
	$nb_bug_resolve = $nb_bug_resolve*3;
	$nb_news_propose = $nb_news_propose*4;
	$nb_filleul = $nb_filleul*5;
	$extra = $extra*20;
	$avertissements = $avertissements*20;
	
	$total = $nb_post + $vote_positif + $vote_negatif + $nb_bg_edition + $nb_topic + $nb_bg_create + $nb_news_commentaire + $nb_backgrounds_commentaire + $nb_bug + $nb_bg_vote + $nb_bug_resolve + $nb_news_propose + $nb_filleul + $extra - $avertissements;
	$total = intval($total);
	
	//Update Total
	$ivo_tt = $db->Send_Query("UPDATE exo_indices SET total='$total' WHERE uid = '$uid'");

}

function print_race($id){
	if($id==1){
		$race = 'Humain';
	}
	else if ($id==2){
		$race = 'Orc';
	}
	else if ($id==3){
		$race = 'Nain';
	}
	else if ($id==4){
		$race = 'Elfe de la nuit';
	}
	else if ($id==5){
		$race = 'Undead';
	}
	else if ($id==6){
		$race = 'Tauren';
	}
	else if ($id==7){
		$race = 'Gnome';
	}
	else if ($id==8){
		$race = 'Troll';
	}
	else if ($id==10){
		$race = 'Elfe de Sang';
	}
	else if ($id==11){
		$race = 'Draenei';
	}
	else{
		$race = 'Inconnue';
	}
	return $race;
}

function print_class($id){
	if($id==1){
		$class = 'Guerrier';
	}
	else if ($id==2){
		$class = 'Paladin';
	}
	else if ($id==3){
		$class = 'Chasseur';
	}
	else if ($id==4){
		$class = 'Voleur';
	}
	else if ($id==5){
		$class = 'Pretre';
	}
	else if ($id==7){
		$class = 'Chaman';
	}
	else if ($id==8){
		$class = 'Mage';
	}
	else if ($id==9){
		$class = 'Demoniste';
	}
	else if ($id==11){
		$class = 'Druide';
	}
	else{
		$class = 'Inconnue';
	}
	
	return $class;
}

function realip() {
   //recupere l adresse ip de l ordi de l utilisateur
   if (isSet($_SERVER)) {
    if (isSet($_SERVER["HTTP_X_FORWARDED_FOR"])) {
     $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (isSet($_SERVER["HTTP_CLIENT_IP"])) {
     $realip = $_SERVER["HTTP_CLIENT_IP"];
    } else {
     $realip = $_SERVER["REMOTE_ADDR"];
    }

   } else {
    if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
     $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
    } elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
     $realip = getenv( 'HTTP_CLIENT_IP' );
    } else {
     $realip = getenv( 'REMOTE_ADDR' );
    }
   }
   return $realip;
}


function thumbnail($file, $maxWidth, $maxHeight, $format, $id)
{
    //Créer une image à partir de $file
	if($format=='gif'){
		$img = @imagecreatefromgif($file);
	}
	elseif($format=='png'){
		$img = @imagecreatefrompng($file);
	}
	else{
		$img = @imagecreatefromjpeg($file);
	}

    if (!$img){return FALSE;}
    

    //Dimensions de l'image
    $imgWidth = imagesx($img);
    $imgHeight = imagesy($img);

    //Facteur largeur/hauteur des dimensions max
    $whFact = $maxWidth/$maxHeight;

    //Facteur largeur/hauteur de l'original
    $imgWhFact = $imgWidth/$imgHeight;

    //fixe les dimensions du thumb
    if($whFact < $imgWhFact)
    {
        //Si largeur déterminante
        $thumbWidth  = $maxWidth;
        $thumbHeight = $thumbWidth/$imgWhFact;
    }
    else
    {
        //Si hauteur déterminante
        $thumbHeight = $maxHeight;
        $thumbWidth = $thumbHeight*$imgWhFact;
    }

    //Crée le thumb (image réduite)
    $imgThumb = imagecreatetruecolor($thumbWidth, $thumbHeight);

    //Insère l'image de base redimensionnée
    imagecopyresized($imgThumb, $img, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $imgWidth, $imgHeight);

    //Crée le fichier thumb
    imagejpeg($imgThumb , './img/pictures/'.$id.'_tb.'.$format, 100);
	
	return TRUE;

}

function mobile_device_detect($iphone=true,$android=true,$opera=true,$blackberry=true,$palm=true,$windows=true,$mobileredirect=false,$desktopredirect=false){

  $mobile_browser   = false; // set mobile browser as false till we can prove otherwise
  $user_agent       = $_SERVER['HTTP_USER_AGENT']; // get the user agent value - this should be cleaned to ensure no nefarious input gets executed
  $accept           = $_SERVER['HTTP_ACCEPT']; // get the content accept value - this should be cleaned to ensure no nefarious input gets executed

  switch(true){ // using a switch against the following statements which could return true is more efficient than the previous method of using if statements

    case (eregi('ipod',$user_agent)||eregi('iphone',$user_agent)); // we find the words iphone or ipod in the user agent
      $mobile_browser = $iphone; // mobile browser is either true or false depending on the setting of iphone when calling the function
      if(substr($iphone,0,4)=='http'){ // does the value of iphone resemble a url
        $mobileredirect = $iphone; // set the mobile redirect url to the url value stored in the iphone value
      } // ends the if for iphone being a url
    break; // break out and skip the rest if we've had a match on the iphone or ipod

    case (eregi('android',$user_agent));  // we find android in the user agent
      $mobile_browser = $android; // mobile browser is either true or false depending on the setting of android when calling the function
      if(substr($android,0,4)=='http'){ // does the value of android resemble a url
        $mobileredirect = $android; // set the mobile redirect url to the url value stored in the android value
      } // ends the if for android being a url
    break; // break out and skip the rest if we've had a match on android

    case (eregi('opera mini',$user_agent)); // we find opera mini in the user agent
      $mobile_browser = $opera; // mobile browser is either true or false depending on the setting of opera when calling the function
      if(substr($opera,0,4)=='http'){ // does the value of opera resemble a rul
        $mobileredirect = $opera; // set the mobile redirect url to the url value stored in the opera value
      } // ends the if for opera being a url 
    break; // break out and skip the rest if we've had a match on opera

    case (eregi('blackberry',$user_agent)); // we find blackberry in the user agent
      $mobile_browser = $blackberry; // mobile browser is either true or false depending on the setting of blackberry when calling the function
      if(substr($blackberry,0,4)=='http'){ // does the value of blackberry resemble a rul
        $mobileredirect = $blackberry; // set the mobile redirect url to the url value stored in the blackberry value
      } // ends the if for blackberry being a url 
    break; // break out and skip the rest if we've had a match on blackberry

    case (preg_match('/(palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i',$user_agent)); // we find palm os in the user agent - the i at the end makes it case insensitive
      $mobile_browser = $palm; // mobile browser is either true or false depending on the setting of palm when calling the function
      if(substr($palm,0,4)=='http'){ // does the value of palm resemble a rul
        $mobileredirect = $palm; // set the mobile redirect url to the url value stored in the palm value
      } // ends the if for palm being a url 
    break; // break out and skip the rest if we've had a match on palm os

    case (preg_match('/(windows ce; ppc;|windows ce; smartphone;|windows ce; iemobile)/i',$user_agent)); // we find windows mobile in the user agent - the i at the end makes it case insensitive
      $mobile_browser = $windows; // mobile browser is either true or false depending on the setting of windows when calling the function
      if(substr($windows,0,4)=='http'){ // does the value of windows resemble a rul
        $mobileredirect = $windows; // set the mobile redirect url to the url value stored in the windows value
      } // ends the if for windows being a url 
    break; // break out and skip the rest if we've had a match on windows

    case (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|pda|psp|treo)/i',$user_agent)); // check if any of the values listed create a match on the user agent - these are some of the most common terms used in agents to identify them as being mobile devices - the i at the end makes it case insensitive
      $mobile_browser = true; // set mobile browser to true
    break; // break out and skip the rest if we've preg_match on the user agent returned true 

    case ((strpos($accept,'text/vnd.wap.wml')>0)||(strpos($accept,'application/vnd.wap.xhtml+xml')>0)); // is the device showing signs of support for text/vnd.wap.wml or application/vnd.wap.xhtml+xml
      $mobile_browser = true; // set mobile browser to true
    break; // break out and skip the rest if we've had a match on the content accept headers

    case (isset($_SERVER['HTTP_X_WAP_PROFILE'])||isset($_SERVER['HTTP_PROFILE'])); // is the device giving us a HTTP_X_WAP_PROFILE or HTTP_PROFILE header - only mobile devices would do this
      $mobile_browser = true; // set mobile browser to true
    break; // break out and skip the final step if we've had a return true on the mobile specfic headers

    case (in_array(strtolower(substr($user_agent,0,4)),array('1207'=>'1207','3gso'=>'3gso','4thp'=>'4thp','501i'=>'501i','502i'=>'502i','503i'=>'503i','504i'=>'504i','505i'=>'505i','506i'=>'506i','6310'=>'6310','6590'=>'6590','770s'=>'770s','802s'=>'802s','a wa'=>'a wa','acer'=>'acer','acs-'=>'acs-','airn'=>'airn','alav'=>'alav','asus'=>'asus','attw'=>'attw','au-m'=>'au-m','aur '=>'aur ','aus '=>'aus ','abac'=>'abac','acoo'=>'acoo','aiko'=>'aiko','alco'=>'alco','alca'=>'alca','amoi'=>'amoi','anex'=>'anex','anny'=>'anny','anyw'=>'anyw','aptu'=>'aptu','arch'=>'arch','argo'=>'argo','bell'=>'bell','bird'=>'bird','bw-n'=>'bw-n','bw-u'=>'bw-u','beck'=>'beck','benq'=>'benq','bilb'=>'bilb','blac'=>'blac','c55/'=>'c55/','cdm-'=>'cdm-','chtm'=>'chtm','capi'=>'capi','comp'=>'comp','cond'=>'cond','craw'=>'craw','dall'=>'dall','dbte'=>'dbte','dc-s'=>'dc-s','dica'=>'dica','ds-d'=>'ds-d','ds12'=>'ds12','dait'=>'dait','devi'=>'devi','dmob'=>'dmob','doco'=>'doco','dopo'=>'dopo','el49'=>'el49','erk0'=>'erk0','esl8'=>'esl8','ez40'=>'ez40','ez60'=>'ez60','ez70'=>'ez70','ezos'=>'ezos','ezze'=>'ezze','elai'=>'elai','emul'=>'emul','eric'=>'eric','ezwa'=>'ezwa','fake'=>'fake','fly-'=>'fly-','fly_'=>'fly_','g-mo'=>'g-mo','g1 u'=>'g1 u','g560'=>'g560','gf-5'=>'gf-5','grun'=>'grun','gene'=>'gene','go.w'=>'go.w','good'=>'good','grad'=>'grad','hcit'=>'hcit','hd-m'=>'hd-m','hd-p'=>'hd-p','hd-t'=>'hd-t','hei-'=>'hei-','hp i'=>'hp i','hpip'=>'hpip','hs-c'=>'hs-c','htc '=>'htc ','htc-'=>'htc-','htca'=>'htca','htcg'=>'htcg','htcp'=>'htcp','htcs'=>'htcs','htct'=>'htct','htc_'=>'htc_','haie'=>'haie','hita'=>'hita','huaw'=>'huaw','hutc'=>'hutc','i-20'=>'i-20','i-go'=>'i-go','i-ma'=>'i-ma','i230'=>'i230','iac'=>'iac','iac-'=>'iac-','iac/'=>'iac/','ig01'=>'ig01','im1k'=>'im1k','inno'=>'inno','iris'=>'iris','jata'=>'jata','java'=>'java','kddi'=>'kddi','kgt'=>'kgt','kgt/'=>'kgt/','kpt '=>'kpt ','kwc-'=>'kwc-','klon'=>'klon','lexi'=>'lexi','lg g'=>'lg g','lg-a'=>'lg-a','lg-b'=>'lg-b','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-f'=>'lg-f','lg-g'=>'lg-g','lg-k'=>'lg-k','lg-l'=>'lg-l','lg-m'=>'lg-m','lg-o'=>'lg-o','lg-p'=>'lg-p','lg-s'=>'lg-s','lg-t'=>'lg-t','lg-u'=>'lg-u','lg-w'=>'lg-w','lg/k'=>'lg/k','lg/l'=>'lg/l','lg/u'=>'lg/u','lg50'=>'lg50','lg54'=>'lg54','lge-'=>'lge-','lge/'=>'lge/','lynx'=>'lynx','leno'=>'leno','m1-w'=>'m1-w','m3ga'=>'m3ga','m50/'=>'m50/','maui'=>'maui','mc01'=>'mc01','mc21'=>'mc21','mcca'=>'mcca','medi'=>'medi','meri'=>'meri','mio8'=>'mio8','mioa'=>'mioa','mo01'=>'mo01','mo02'=>'mo02','mode'=>'mode','modo'=>'modo','mot '=>'mot ','mot-'=>'mot-','mt50'=>'mt50','mtp1'=>'mtp1','mtv '=>'mtv ','mate'=>'mate','maxo'=>'maxo','merc'=>'merc','mits'=>'mits','mobi'=>'mobi','motv'=>'motv','mozz'=>'mozz','n100'=>'n100','n101'=>'n101','n102'=>'n102','n202'=>'n202','n203'=>'n203','n300'=>'n300','n302'=>'n302','n500'=>'n500','n502'=>'n502','n505'=>'n505','n700'=>'n700','n701'=>'n701','n710'=>'n710','nec-'=>'nec-','nem-'=>'nem-','newg'=>'newg','neon'=>'neon','netf'=>'netf','noki'=>'noki','nzph'=>'nzph','o2 x'=>'o2 x','o2-x'=>'o2-x','opwv'=>'opwv','owg1'=>'owg1','opti'=>'opti','oran'=>'oran','p800'=>'p800','pand'=>'pand','pg-1'=>'pg-1','pg-2'=>'pg-2','pg-3'=>'pg-3','pg-6'=>'pg-6','pg-8'=>'pg-8','pg-c'=>'pg-c','pg13'=>'pg13','phil'=>'phil','pn-2'=>'pn-2','pt-g'=>'pt-g','palm'=>'palm','pana'=>'pana','pire'=>'pire','pock'=>'pock','pose'=>'pose','psio'=>'psio','qa-a'=>'qa-a','qc-2'=>'qc-2','qc-3'=>'qc-3','qc-5'=>'qc-5','qc-7'=>'qc-7','qc07'=>'qc07','qc12'=>'qc12','qc21'=>'qc21','qc32'=>'qc32','qc60'=>'qc60','qci-'=>'qci-','qwap'=>'qwap','qtek'=>'qtek','r380'=>'r380','r600'=>'r600','raks'=>'raks','rim9'=>'rim9','rove'=>'rove','s55/'=>'s55/','sage'=>'sage','sams'=>'sams','sc01'=>'sc01','sch-'=>'sch-','scp-'=>'scp-','sdk/'=>'sdk/','se47'=>'se47','sec-'=>'sec-','sec0'=>'sec0','sec1'=>'sec1','semc'=>'semc','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','sk-0'=>'sk-0','sl45'=>'sl45','slid'=>'slid','smb3'=>'smb3','smt5'=>'smt5','sp01'=>'sp01','sph-'=>'sph-','spv '=>'spv ','spv-'=>'spv-','sy01'=>'sy01','samm'=>'samm','sany'=>'sany','sava'=>'sava','scoo'=>'scoo','send'=>'send','siem'=>'siem','smar'=>'smar','smit'=>'smit','soft'=>'soft','sony'=>'sony','t-mo'=>'t-mo','t218'=>'t218','t250'=>'t250','t600'=>'t600','t610'=>'t610','t618'=>'t618','tcl-'=>'tcl-','tdg-'=>'tdg-','telm'=>'telm','tim-'=>'tim-','ts70'=>'ts70','tsm-'=>'tsm-','tsm3'=>'tsm3','tsm5'=>'tsm5','tx-9'=>'tx-9','tagt'=>'tagt','talk'=>'talk','teli'=>'teli','topl'=>'topl','tosh'=>'tosh','up.b'=>'up.b','upg1'=>'upg1','utst'=>'utst','v400'=>'v400','v750'=>'v750','veri'=>'veri','vk-v'=>'vk-v','vk40'=>'vk40','vk50'=>'vk50','vk52'=>'vk52','vk53'=>'vk53','vm40'=>'vm40','vx98'=>'vx98','virg'=>'virg','vite'=>'vite','voda'=>'voda','vulc'=>'vulc','w3c '=>'w3c ','w3c-'=>'w3c-','wapj'=>'wapj','wapp'=>'wapp','wapu'=>'wapu','wapm'=>'wapm','wig '=>'wig ','wapi'=>'wapi','wapr'=>'wapr','wapv'=>'wapv','wapy'=>'wapy','wapa'=>'wapa','waps'=>'waps','wapt'=>'wapt','winc'=>'winc','winw'=>'winw','wonu'=>'wonu','x700'=>'x700','xda2'=>'xda2','xdag'=>'xdag','yas-'=>'yas-','your'=>'your','zte-'=>'zte-','zeto'=>'zeto','acs-'=>'acs-','alav'=>'alav','alca'=>'alca','amoi'=>'amoi','aste'=>'aste','audi'=>'audi','avan'=>'avan','benq'=>'benq','bird'=>'bird','blac'=>'blac','blaz'=>'blaz','brew'=>'brew','brvw'=>'brvw','bumb'=>'bumb','ccwa'=>'ccwa','cell'=>'cell','cldc'=>'cldc','cmd-'=>'cmd-','dang'=>'dang','doco'=>'doco','eml2'=>'eml2','eric'=>'eric','fetc'=>'fetc','hipt'=>'hipt','http'=>'http','ibro'=>'ibro','idea'=>'idea','ikom'=>'ikom','inno'=>'inno','ipaq'=>'ipaq','jbro'=>'jbro','jemu'=>'jemu','java'=>'java','jigs'=>'jigs','kddi'=>'kddi','keji'=>'keji','kyoc'=>'kyoc','kyok'=>'kyok','leno'=>'leno','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-g'=>'lg-g','lge-'=>'lge-','libw'=>'libw','m-cr'=>'m-cr','maui'=>'maui','maxo'=>'maxo','midp'=>'midp','mits'=>'mits','mmef'=>'mmef','mobi'=>'mobi','mot-'=>'mot-','moto'=>'moto','mwbp'=>'mwbp','mywa'=>'mywa','nec-'=>'nec-','newt'=>'newt','nok6'=>'nok6','noki'=>'noki','o2im'=>'o2im','opwv'=>'opwv','palm'=>'palm','pana'=>'pana','pant'=>'pant','pdxg'=>'pdxg','phil'=>'phil','play'=>'play','pluc'=>'pluc','port'=>'port','prox'=>'prox','qtek'=>'qtek','qwap'=>'qwap','rozo'=>'rozo','sage'=>'sage','sama'=>'sama','sams'=>'sams','sany'=>'sany','sch-'=>'sch-','sec-'=>'sec-','send'=>'send','seri'=>'seri','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','siem'=>'siem','smal'=>'smal','smar'=>'smar','sony'=>'sony','sph-'=>'sph-','symb'=>'symb','t-mo'=>'t-mo','teli'=>'teli','tim-'=>'tim-','tosh'=>'tosh','treo'=>'treo','tsm-'=>'tsm-','upg1'=>'upg1','upsi'=>'upsi','vk-v'=>'vk-v','voda'=>'voda','vx52'=>'vx52','vx53'=>'vx53','vx60'=>'vx60','vx61'=>'vx61','vx70'=>'vx70','vx80'=>'vx80','vx81'=>'vx81','vx83'=>'vx83','vx85'=>'vx85','wap-'=>'wap-','wapa'=>'wapa','wapi'=>'wapi','wapp'=>'wapp','wapr'=>'wapr','webc'=>'webc','whit'=>'whit','winw'=>'winw','wmlb'=>'wmlb','xda-'=>'xda-',))); // check against a list of trimmed user agents to see if we find a match
      $mobile_browser = true; // set mobile browser to true
    break; // break even though it's the last statement in the switch so there's nothing to break away from but it seems better to include it than exclude it

  } // ends the switch 

  // tell adaptation services (transcoders and proxies) to not alter the content based on user agent as it's already being managed by this script
  header('Cache-Control: no-transform'); // http://mobiforge.com/developing/story/setting-http-headers-advise-transcoding-proxies
  header('Vary: User-Agent, Accept'); // http://mobiforge.com/developing/story/setting-http-headers-advise-transcoding-proxies

  // if redirect (either the value of the mobile or desktop redirect depending on the value of $mobile_browser) is true redirect else we return the status of $mobile_browser
  if($redirect = ($mobile_browser==true) ? $mobileredirect : $desktopredirect){
    header('Location: '.$redirect); // redirect to the right url for this device
    exit;
  }else{ 
    return $mobile_browser; // will return either true or false 
  }

} // ends function mobile_device_detect



function synchronizeForum(){
	global $db;

	//MAJ de la table TOPICS
		//Nb réponses
		$result = $db->Send_Query("CREATE TEMPORARY TABLE tmp
		SELECT tid, COUNT(pid) as nb_msg
		FROM exo_forum_posts
		GROUP BY tid");		

		$result = $db->Send_Query("UPDATE exo_forum_topics T, tmp
		SET T.nb_replies=tmp.nb_msg-1
		WHERE T.tid=tmp.tid;");		

		$result = $db->Send_Query("DROP TABLE tmp");	
		
		//First/Last Post
		$result = $db->Send_Query("CREATE TEMPORARY TABLE tmp
		SELECT tid, MIN(pid) as first, MAX(pid) as last
		FROM exo_forum_posts
		GROUP BY tid");		

		$result = $db->Send_Query("UPDATE exo_forum_topics T, tmp
		SET T.first_post_id=tmp.first, T.last_post_id=tmp.last
		WHERE T.tid=tmp.tid");		

		$result = $db->Send_Query("DROP TABLE tmp");	



	//MAJ de la table BOARDS
		//Nb réponses & topics
		$result = $db->Send_Query("CREATE TEMPORARY TABLE tmp
		SELECT bid, COUNT(tid) as nb_tp, SUM(nb_replies) as nb_msg
		FROM exo_forum_topics
		WHERE type!=9
		GROUP BY bid");		

		$result = $db->Send_Query("UPDATE exo_forum_boards B, tmp
		SET B.nb_topics=tmp.nb_tp, B.nb_posts=tmp.nb_msg
		WHERE B.bid=tmp.bid;");		

		$result = $db->Send_Query("DROP TABLE tmp");	
		
		//Last post ID
		$result = $db->Send_Query("CREATE TEMPORARY TABLE tmp
		SELECT bid, MAX(last_post_id) as last
		FROM exo_forum_topics
		WHERE type!=9
		GROUP BY bid");		

		$result = $db->Send_Query("UPDATE exo_forum_boards B, tmp
		SET B.last_post_id=tmp.last
		WHERE B.bid=tmp.bid");		

		$result = $db->Send_Query("DROP TABLE tmp");	
}


//Envoie automatique d'un MP
// Type = NIVEAU_AVERTISSEMENT
function sendAutoMP($type, $dest, $data, $dpID=0){
	global $db;
	
	$mp = $db->get_array($db->Send_Query("SELECT maTitle, maSTitle, maTxt FROM exo_mp_auto WHERE maID=$type"));
	$maTitle = $mp['maTitle'];
	$maSTitle = $mp['maSTitle'];
	$maTxt = $mp['maTxt'];

	$in=array("{VAR0}","{VAR1}","{VAR2}","{VAR3}","{VAR4}","{VAR5}","{VAR6}","{VAR7}","{VAR8}","{VAR9}");
	$out=array($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7],$data[8],$data[9]);
	$maTitle = mysql_real_escape_string(str_replace($in,$out,$maTitle));	
	$maSTitle = mysql_real_escape_string(str_replace($in,$out,$maSTitle));	
	$maTxt = mysql_real_escape_string(str_replace($in,$out,$maTxt));
	
	if(empty($dpID)){
		//Nouveau MP = Discussions
		$result = $db->Send_Query("INSERT INTO exo_mp_discussions (dpID, dpTitle, dpUnderTitle, dpDate, uid) VALUES (NULL, '$maTitle', '$maSTitle', NOW(), 2)");
		$dpID = $db->last_insert_id();
		$result = $db->Send_Query("INSERT INTO exo_mp_messages (mpID, dpID, uid, mpMessage, mpDateCreation) VALUES (NULL, $dpID, 2, '$maTxt', NOW())");
		$mpID = $db->last_insert_id();
		$result = $db->Send_Query("UPDATE exo_mp_discussions SET last_mpID=$mpID WHERE dpID=$dpID");
		
		$result = $db->Send_Query("INSERT INTO exo_mp_participate (dpID,uid,participe,last_msg_vu) VALUES ($dpID, 2, 0, $mpID)");	
		$result = $db->Send_Query("INSERT INTO exo_mp_participate (dpID,uid,participe,last_msg_vu) VALUES ($dpID, $dest, 1, 0)");
	}
	else{
		//Réponse à une discussion
		$result = $db->Send_Query("INSERT INTO exo_mp_messages (mpID, dpID, uid, mpMessage, mpDateCreation) VALUES (NULL, $dpID, 2, '$maTxt', NOW())");
		$mpID = $db->last_insert_id();
		$result = $db->Send_Query("UPDATE exo_mp_discussions SET last_mpID=$mpID WHERE dpID=$dpID");	
		$result = $db->Send_Query("UPDATE exo_mp_participate SET last_msg_vu=$mpID WHERE dpID=$dpID AND uid=2");	
		
	}
	
	return $dpID;
}

function format_time_to_delta($second){
	
	$second = intval($second);
	
	//En secondes
	if($second < 2){
		return $second.' seconde';
	}
	elseif($second < 60){
		return $second.' secondes';
	}
	
	//En minutes
	elseif($second < 60*2){
		return '1 minute';
	}
	elseif($second < 3600){
		return floor($second/60).' minutes';
	}
	
	//En heures
	elseif($second < 3600*2){
		return '1 heure';
	}
	elseif($second < 86400){
		return floor($second/3600).' heures';
	}
	
	// En jours
	elseif($second == 86400){
		return '1 jour';
	}
	else{
		return floor($second/86400).' jours';
	}
	
}



?>
