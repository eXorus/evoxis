<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );

// Define _VALID_CORE_STAT
define( '_VALID_CORE_STATS', 1 );

/*debut du cache*/
$cache = 'cache/stats.html';
$expire = time() - 5 ; // valable une journée

if(file_exists($cache) && filemtime($cache) > $expire){
}
else
{
	$limit = time() - (60*24*60*60);

	//race
	$rq = $db_characters->Send_Query("
		SELECT race, COUNT(*) /(SELECT COUNT(*) FROM `characters` WHERE extra_flags = 4 AND logout_time > ".$limit.")*100 as `number`
		FROM `characters`
		WHERE extra_flags = 4
		AND logout_time > ".$limit."
		GROUP BY race
		ORDER BY `number` DESC");
	$race = $db_characters->loadObjectList($rq);
		
	//class
	$rq = $db_characters->Send_Query("
		SELECT class, COUNT(*) /(SELECT COUNT(*) FROM `characters` WHERE extra_flags = 4 AND logout_time > ".$limit.")*100 as `number`
		FROM `characters`
		WHERE extra_flags = 4
		AND logout_time > ".$limit."
		GROUP BY class
		ORDER BY `number` DESC");
	$class = $db_characters->loadObjectList($rq);

	//gender
	$rq = $db_characters->Send_Query("
			SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldGender), ' ', -1) AS UNSIGNED) AS `gender`,
			COUNT(*) /(
				SELECT COUNT(*) 
				FROM `characters` 
				WHERE extra_flags = 4
				AND logout_time > ".$limit." 
				AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldGender), ' ', -1) AS UNSIGNED) < 2
				)*100 as `number`
			FROM `characters`
			WHERE extra_flags = 4
			AND logout_time > ".$limit."
			AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldGender), ' ', -1) AS UNSIGNED) < 2
			GROUP BY `gender`");
	$gender = $db_characters->loadObjectList($rq);

	//tueurs
	$rq = $db_characters->Send_Query("
		SELECT sum(ck.count) AS `kill`, c.name, c.guid
		FROM `character_kill` ck, `characters` c
		WHERE c.guid=ck.guid
		AND c.logout_time > ".$limit."
		AND c.extra_flags = 4
		GROUP BY ck.guid
		ORDER BY `kill` DESC
		LIMIT 5");
	$tueurs = $db_characters->loadObjectList($rq);

	//tueurs récents
	$rq = $db_characters->Send_Query("
		SELECT name, last_kill_date, guid
		FROM `characters`
		WHERE extra_flags = 4
		AND logout_time > ".$limit."
		ORDER BY last_kill_date DESC
		LIMIT 5");
	$lastkill = $db_characters->loadObjectList($rq);

	//tués
	$rq = $db_characters->Send_Query("	
		SELECT sum(ck.count) AS `killed`, c.name, c.guid
		FROM `character_kill` ck,  `characters` c
		WHERE c.guid=ck.victim_guid
		AND c.logout_time > ".$limit."
		AND c.extra_flags = 4
		GROUP BY ck.victim_guid
		ORDER BY `killed` DESC
		LIMIT 5");
	$tues = $db_characters->loadObjectList($rq);

	//temps joué
	$rq = $db_characters->Send_Query("
		SELECT name, totaltime, guid
		FROM `characters`
		WHERE extra_flags = 4
		AND logout_time > ".$limit."
		ORDER BY totaltime DESC
		LIMIT 5");
	$totaltime = $db_characters->loadObjectList($rq);

	//argent
	$rq = $db_characters->Send_Query("
		SELECT name, guid,
		CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldMoney), ' ', -1) AS UNSIGNED) AS `money`
		FROM `characters`
		WHERE extra_flags = 4
		AND logout_time > ".$limit."
		ORDER BY `money` DESC
		LIMIT 10");
	$money = $db_characters->loadObjectList($rq);

	//victoires honorables
	$rq = $db_characters->Send_Query("
		SELECT name, guid,
		CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldHonorableKills), ' ', -1) AS UNSIGNED)  AS `honorable_kills`
		FROM `characters`
		WHERE extra_flags = 4
		AND logout_time > ".$limit."
		ORDER BY `honorable_kills` DESC
		LIMIT 5");
	$honor = $db_characters->loadObjectList($rq);

	//date de creation de guilde
	$rq = $db_characters->Send_Query("
		SELECT g.name, g.createdate
		FROM `guild` g
		ORDER BY g.createdate ASC");
	$create = $db_characters->loadObjectList($rq);

	//temps joué des membres de la guilde
	$rq = $db_characters->Send_Query("
		SELECT g.name, SUM(c.totaltime) AS totaltime
		FROM `guild` g, `guild_member` gm, `characters` c
		WHERE g.guildid=gm.guildid
		AND c.guid=gm.guid
		AND c.extra_flags = 4
		AND c.logout_time > ".$limit."
		GROUP BY g.guildid
		ORDER BY totaltime DESC
		LIMIT 10");
	$gtotaltime = $db_characters->loadObjectList($rq);

	//nombre de membres de la guilde
	$rq = $db_characters->Send_Query("
		SELECT g.name, COUNT(*) AS members
		FROM `guild` g, `guild_member` gm, `characters` c
		WHERE g.guildid=gm.guildid
		AND c.guid=gm.guid
		AND c.extra_flags = 4
		AND c.logout_time > ".$limit."
		GROUP BY g.guildid
		ORDER BY members DESC
		LIMIT 10");
	$members = $db_characters->loadObjectList($rq);

	//argent de la guilde
	$rq = $db_characters->Send_Query("
		SELECT g.name, SUM(CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', $playerDataFieldHonorableKills), ' ', -1) AS UNSIGNED))+g.BankMoney AS money
		FROM `guild` g, `guild_member` gm, `characters` c
		WHERE g.guildid=gm.guildid
		AND c.guid=gm.guid
		AND c.extra_flags = 4
		AND c.logout_time > ".$limit."
		GROUP BY g.guildid
		ORDER BY money DESC
		LIMIT 10");
	$gmoney = $db_characters->loadObjectList($rq);

}
	
/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'stats';
         
/*
* MANAGE PATHWAY
 */
$pathway = array(
'Statistiques' => ''
);
$ws_name_perso = 'Evoxis v5 - Statistiques';
?>
