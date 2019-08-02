<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >   
<head>
	<meta name="viewport" content="width=400" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="keywords" content="rp, rôle-play, wow, world of warcraft, serveur, privé, role play, roleplay, background, role playing, fr, " />
	<meta name="description" content="Serveur RP francophone / Hébergement pro 100Mbits / Un RolePlay riche et une aventure unique dans un univers entièrement personnalisé / Incarnez animal et créature de votre choix / Une histoire unique dans laquelle chaque joueur a un rôle / Venez vite !" />
	<meta name="robots" content="index,follow" />
	<meta name="verify-v1" content="vdgzgF3nd+TqTWyCtztkoY0WcX8RM/P1fYUTANH0BNQ=" />
	
	<title><?php echo utf8_decode($ws_name) ?></title>
	
	<link rel="shortcut icon" type="image/png" href="favicon.png" />
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo './templates/'.$link_style.'css/style.css' ?>" />
	
	<script type="text/javascript" src="./inc/js/eXoShout.js"></script>
</head>


<body id="accueil" onload="Reload();">

<div id="header_lite">
	<div id="loginbox_lite"><?php require_once('./gabarit/loginBox.html.php')?><a href="index.php?comp=logout">Déconnexion</a></div>
	<div id="menu_lite">
&#149; <a href="index.php">Accueil</a> - <a href="index.php?comp=forum_index">Forums</a> &#149;
	</div>
</div>
<div id="shoutbox_lite"><?php require_once('./gabarit/shoutbox.html.php')?></div>
<div id="contenu_lite">
