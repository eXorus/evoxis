<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
   
<head>
 <title>Evoxis: Console MJ</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" media="screen" type="text/css" title="Style" href="./tpl/css/admin_style.css" /> 
  <script language="Javascript" src="../js/menu.js"></script>

</head>
<body>

 <div id="topHeader">
	<div id="topHeaderLogo"></div>
	<div id="topHeaderTitle">Console MJ</div>
 </div>
 
 <div id="topMenu">
	<ul id="menu">
		<li><a href="index.php?comp=main">Accueil</a></li>
		<li><a href="index.php?comp=users">Utilisateurs</a>
			<ul>
				<li><a href="index.php?comp=users">Comptes</a></li>
				<li><a href="index.php?comp=groups">Groupes</a></li>
				<li><a href="#">Characters</a></li>
				<li><a href="index.php?comp=guilds">Guilds</a></li>
			</ul>
		</li>
		<li><a href="index.php?comp=bgcheck">BGCheck</a></li>
		<li><a href="index.php?comp=insevo">Insevo</a></li>
		<li><a href="index.php?comp=ask">Ask</a></li>
		<li><a href="#">Config</a>
			<ul>
				<li><a href="index.php?comp=config&mod=wow">WoW</a>
				<li><a href="index.php?comp=config&mod=site">Site</a></li>
				<li><a href="index.php?comp=configMoney">Trésor Public</a></li>
			</ul>
		</li>
		<li><a href="index.php?comp=logs">Logs</a></li>
		<li><a href="index.php?comp=logout">Déconnexion</a></li>
	</ul>
 </div>
  
 <div id="content">
	<?php
	if(message::exist()==TRUE){
		$msgE = message::getInstance();
		$msgE->printMessage();
	}
	?>
	<div id=""></div>
 
	<div id="boxTitlePage"><?php echo $TitlePage ?></div>

	<div id="contenu">
 




