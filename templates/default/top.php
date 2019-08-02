<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >   
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="keywords" content="rp, rôle-play, wow, world of warcraft, serveur, privé, role play, roleplay, background, role playing, fr, " />
	<meta name="description" content="Serveur RP francophone / Hébergement pro 100Mbits / Un RolePlay riche et une aventure unique dans un univers entièrement personnalisé / Incarnez animal et cr?ature de votre choix / Une histoire unique dans laquelle chaque joueur a un r?le / Venez vite !" />
	<meta name="robots" content="index,follow" />
	<meta name="verify-v1" content="vdgzgF3nd+TqTWyCtztkoY0WcX8RM/P1fYUTANH0BNQ=" />
	
	<title>
		<?php 
			if(empty($ws_name_perso))
				echo utf8_decode($ws_name);
			else
				echo $ws_name_perso;
		?>
	</title>
	
	<link rel="shortcut icon" type="image/png" href="favicon.png" />
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo './templates/'.$link_style.'css/style.css' ?>" />
	
	<script type="text/javascript" src="./inc/js/eXoShout.js"></script>
    <script type="text/javascript" src="./inc/js/prototype.js"></script>
	<script type="text/javascript" src="./inc/js/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="./inc/js/lightwindow.js"></script>
	<script type="text/javascript" src="./inc/js/dynMenu.js"></script>
	<script type="text/javascript" src="./inc/js/browserdetect.js"></script>
	<script type="text/javascript" src="./inc/js/menus.js"></script>
	<script type="text/javascript" src="./inc/js/glider.js"></script>
<!--[if lt IE 8]>
     <style type="text/css">
		@import "<?php echo './templates/'.$link_style.'css/correctifs_ie7.css' ?>";
		@import "<?php echo './templates/'.$link_style.'css/menus_ie7.css' ?>";
     </style>
<![endif]-->

</head>


<body id="accueil" onload="Reload();">
	<script type="text/javascript" src="./inc/js/infobulles.js"></script>
<p id="top"></p>

<div id="conteneur">
<?php
if(message::exist()==TRUE){
	$msgE = message::getInstance();
	$msgE->printMessage();
}
?>
    <div id="header">
		<div id="box_info"><?php require_once('./gabarit/infobox.html.php')?></div>
		<div id="box_state"><a href="index.php?comp=membres&amp;task=ig"><?php echo "$state_serveur";?></a></div>
		<div id="box_lastread"><a href="index.php?comp=notifications" onmouseover="Tip('Notifications')" onmouseout="UnTip()"><img src="./templates/default/ico/lastread.gif" alt="Derni?res nouvelles" title="Derni?res nouvelles" /></a></div>
		<div id="box_login"><?php require_once('./gabarit/loginBox.html.php')?></div>
	<div id="menu_haut">&raquo;&nbsp;
	<?php
	if($_SESSION['connected']!=TRUE){
		echo '<a href="index.php?comp=presentation">Présentation</a> &#8226; ';
	}
	?>
<a href="index.php?comp=rp_bg">L'histoire</a> &#8226; 
<a href="index.php?comp=bg_list">Backgrounds</a> &#8226; 
<a href="index.php?comp=forum_index">Forums</a> &#8226; 
<a href="index.php?comp=news">News</a> &#8226; 
<a href="index.php?comp=bugtracker">Bug Tracker</a> &laquo;
	</div>
	</div>

	<div id="sousheader">
<div id="box_news">
<script type="text/javascript">
<!--
document.write("<marquee direction=\"up\" scrollamount=\"2\" scrolldelay=\"1\" onMouseOver=\"stop()\" onMouseOut=\"start()\" id=\"scrolleur\">");
//-->
</script> 
<?php 
echo '<b>Realmlist:</b><br />'.REALMLIST.'<br /><br />';
echo '<b>Rates:</b><br />Drop '.RATES_DROP.'<br />Monstres '.RATES_MONSTRES.'<br />Quêtes '.RATES_QUETES.'<br />Exploration '.RATES_EXPLORATION.'<br /><br />';
echo '<b>Version du serveur:</b><br />'.WOW_VERSION.'<br /><br />';
echo BOX_DEFILANTE; ?>
<script type="text/javascript">
<!--
document.write("<\/marquee>");
//-->
</script>

		</div>
		<div id="box_shoutbox"><?php require_once('./gabarit/shoutbox.html.php')?></div>
		<div id="box_events"><?php require_once('./gabarit/events.html.php')?></div>
		
</div>

	<div id="conteneurgauche">
<ul id="menu">
    <li><img onmouseover="this.src='./templates/default/main_pic/menu_portail2.png'" src="./templates/default/main_pic/menu_portail.png" alt="Portail" onmouseout="this.src='./templates/default/main_pic/menu_portail.png'" />
        <ul>
            <li><a href="index.php?comp=presentation"><img onmouseover="this.src='./templates/default/main_pic/menu_presentation2.png'" src="./templates/default/main_pic/menu_presentation.png" alt="Pr?sentation" onmouseout="this.src='./templates/default/main_pic/menu_presentation.png'" /></a></li>
            <li><a href="index.php?comp=forum_index"><img onmouseover="this.src='./templates/default/main_pic/menu_forums2.png'" src="./templates/default/main_pic/menu_forums.png" alt="Forums" onmouseout="this.src='./templates/default/main_pic/menu_forums.png'" /></a></li>
            <li><a href="index.php?comp=charte"><img onmouseover="this.src='./templates/default/main_pic/menu_charte2.png'" src="./templates/default/main_pic/menu_charte.png" alt="Charte" onmouseout="this.src='./templates/default/main_pic/menu_charte.png'" /></a></li>
            <li><a href="index.php?comp=team"><img onmouseover="this.src='./templates/default/main_pic/menu_equipe2.png'" src="./templates/default/main_pic/menu_equipe.png" alt="Equipe" onmouseout="this.src='./templates/default/main_pic/menu_equipe.png'" /></a></li>
            <li><a href="index.php?comp=insevo"><img onmouseover="this.src='./templates/default/main_pic/menu_inscrire2.png'" src="./templates/default/main_pic/menu_inscrire.png" alt="Inscription" onmouseout="this.src='./templates/default/main_pic/menu_inscrire.png'" /></a></li>
        </ul>
    </li>
    <li><img onmouseover="this.src='./templates/default/main_pic/menu_rp2.png'" src="./templates/default/main_pic/menu_rp.png" alt="Role Play" onmouseout="this.src='./templates/default/main_pic/menu_rp.png'" />	
        <ul>
            <li><a href="index.php?comp=rp_bg"><img onmouseover="this.src='./templates/default/main_pic/menu_histoire2.png'" src="./templates/default/main_pic/menu_histoire.png" alt="Histoire" onmouseout="this.src='./templates/default/main_pic/menu_histoire.png'" /></a></li>
			<li><a href="index.php?comp=chronologie"><img onmouseover="this.src='./templates/default/main_pic/menu_chrono2.png'" src="./templates/default/main_pic/menu_chrono.png" alt="Chronologie" onmouseout="this.src='./templates/default/main_pic/menu_chrono.png'" /></a></li>
			<li><a href="index.php?comp=bestiaire"><img onmouseover="this.src='./templates/default/main_pic/menu_bestiaire2.png'" src="./templates/default/main_pic/menu_bestiaire.png" alt="Bestiaire" onmouseout="this.src='./templates/default/main_pic/menu_bestiaire.png'" /></a></li>
            <li><a href="index.php?comp=bg_list"><img onmouseover="this.src='./templates/default/main_pic/menu_bgs2.png'" src="./templates/default/main_pic/menu_bgs.png" alt="Backgrounds" onmouseout="this.src='./templates/default/main_pic/menu_bgs.png'" /></a></li>
            <li><a href="index.php?comp=guilds"><img onmouseover="this.src='./templates/default/main_pic/menu_guildes2.png'" src="./templates/default/main_pic/menu_guildes.png" alt="Guildes" onmouseout="this.src='./templates/default/main_pic/menu_guildes.png'" /></a></li>
		</ul>
    </li>
    <li><img onmouseover="this.src='./templates/default/main_pic/menu_communaute2.png'" src="./templates/default/main_pic/menu_communaute.png" alt="Communaut?" onmouseout="this.src='./templates/default/main_pic/menu_communaute.png'" />
        <ul>
            <li><a href="index.php?comp=news"><img onmouseover="this.src='./templates/default/main_pic/menu_news2.png'" src="./templates/default/main_pic/menu_news.png" alt="News" onmouseout="this.src='./templates/default/main_pic/menu_news.png'" /></a></li>
        	<li><a href="index.php?comp=live"><img onmouseover="this.src='./templates/default/main_pic/menu_online2.png'" src="./templates/default/main_pic/menu_online.png" alt="Evoxis Live!" onmouseout="this.src='./templates/default/main_pic/menu_online.png'" /></a></li>
            <li><a href="index.php?comp=ask"><img onmouseover="this.src='./templates/default/main_pic/menu_demandes2.png'" src="./templates/default/main_pic/menu_demandes.png" alt="Vos Demandes" onmouseout="this.src='./templates/default/main_pic/menu_demandes.png'" /></a></li>
			<li><a href="index.php?comp=trombinoscope"><img onmouseover="this.src='./templates/default/main_pic/menu_trombi2.png'" src="./templates/default/main_pic/menu_trombi.png" alt="Trombinoscope" onmouseout="this.src='./templates/default/main_pic/menu_trombi.png'" /></a></li>
            <li><a href="index.php?comp=galerie"><img onmouseover="this.src='./templates/default/main_pic/menu_creas2.png'" src="./templates/default/main_pic/menu_creas.png" alt="Cr?ations graphiques" onmouseout="this.src='./templates/default/main_pic/menu_creas.png'" /></a></li>
		</ul>
    </li>
	<li><img onmouseover="this.src='./templates/default/main_pic/menu_infos2.png'" src="./templates/default/main_pic/menu_infos.png" alt="Informations" onmouseout="this.src='./templates/default/main_pic/menu_infos.png'" />	
        <ul>
            <li><a href="index.php?comp=aide"><img onmouseover="this.src='./templates/default/main_pic/menu_aide2.png'" src="./templates/default/main_pic/menu_aide.png" alt="Aide" onmouseout="this.src='./templates/default/main_pic/menu_aide.png'" /></a></li>
            <li><a href="index.php?comp=bugtracker"><img onmouseover="this.src='./templates/default/main_pic/menu_bug2.png'" src="./templates/default/main_pic/menu_bug.png" alt="Bug Tracker" onmouseout="this.src='./templates/default/main_pic/menu_bug.png'" /></a></li>
            <li><a href="index.php?comp=dl"><img onmouseover="this.src='./templates/default/main_pic/menu_download2.png'" src="./templates/default/main_pic/menu_download.png" alt="T?l?chargements" onmouseout="this.src='./templates/default/main_pic/menu_download.png'" /></a></li>
        	<li><a href="index.php?comp=search"><img onmouseover="this.src='./templates/default/main_pic/menu_search2.png'" src="./templates/default/main_pic/menu_search.png" alt="Recherche" onmouseout="this.src='./templates/default/main_pic/menu_search.png'" /></a></li>
            <li><a href="index.php?comp=insevo_attente"><img onmouseover="this.src='./templates/default/main_pic/menu_inscriptions2.png'" src="./templates/default/main_pic/menu_inscriptions.png" alt="Etat des inscriptions" onmouseout="this.src='./templates/default/main_pic/menu_inscriptions.png'" /></a></li>
        </ul>
    </li>
</ul>

<script type="text/javascript">
    initMenu();
</script>
    </div>

	<div class="conteneurdroit_top">
<div id="pathway"><?php include('./gabarit/pathway.html.php')?></div></div>
	<div id="conteneurdroit_center">
		<div id="contenu">
