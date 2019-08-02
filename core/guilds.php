<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_GUILDS
define( '_VALID_CORE_GUILDS', 1 );

//Insertion des nouvelles guildes InGame dans la table
$rq = $db->Send_Query("
	INSERT INTO exo_guilds (guildid, leaderguid, name, leader, wowid, creation_time)
	SELECT g.guildid, c.guid, g.name, c.name, c.account, g.createdate
	FROM $db_name_characters.guild g, $db_name_characters.characters c
	WHERE g.leaderguid = c.guid
	AND g.guildid NOT IN ( SELECT guildid FROM exo_guilds )");

//liste des membres de chaque guilde
$rq = $db_characters->Send_Query("
			SELECT g.guildid, g.name as name_guild, g.info, gm.guid, c.name as name_perso, gr.rname
			FROM $db_name_characters.guild g
			LEFT JOIN guild_member gm ON g.guildid = gm.guildid
			LEFT JOIN `characters` c ON c.guid = gm.guid
			LEFT JOIN guild_rank gr ON (gr.guildid = g.guildid AND gr.rid = gm.rank+1)");
$members = $db_characters->loadObjectList($rq);

//liste des guildes
$rq = $db->Send_Query("
			SELECT *
			FROM exo_guilds");
$guilds = $db_characters->loadObjectList($rq);

//Liste des guildes valides
$rq = $db->Send_Query("
SELECT g.guildid, g.name, g.leader, g.wowid, g.creation_time, g.last_edit_time, g.background, g.goals, g.rules, g.hall, g.hierarchy, g.accepted, g.members_view,  GROUP_CONCAT(
	DISTINCT c.name ORDER BY c.name SEPARATOR ', ') as membres
FROM exo_guilds g
LEFT JOIN $db_name_characters.guild_member gm ON g.guildid = gm.guildid
LEFT JOIN $db_name_characters.`characters` c ON c.guid = gm.guid
LEFT JOIN $db_name_characters.guild_rank gr ON (gr.guildid = g.guildid AND gr.rid = gm.rank+1)
WHERE statut='VALIDE'
GROUP BY g.name");
$guilds_valid = $db->loadObjectList($rq);

//Liste des guildes invalides
$rq = $db->Send_Query("SELECT guildid, name, leader, wowid FROM exo_guilds WHERE statut!='VALIDE'");
$guilds_invalid = $db->loadObjectList($rq);



/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'guildes';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Guildes' => ''
);
$ws_name_perso = 'Evoxis v5 - Guildes';
?>
