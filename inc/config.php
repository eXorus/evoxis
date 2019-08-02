<?php

//Config MySQL Site
$db_host = 'localhost';
$db_name = 'dev_evoxis';
$db_username = 'devevoxis';
$db_password = 'JHfXMz5QV5MXMyPV';

//Config MySQL WoW Realmd
$db_host_realmd = 'localhost';
$db_name_realmd = 'dev_realmd';
$db_username_realmd = 'devevoxis';
$db_password_realmd = 'JHfXMz5QV5MXMyPV';

//Config MySQL WoW characters
$db_host_characters = 'localhost';
$db_name_characters = 'dev_characters';
$db_username_characters = 'devevoxis';
$db_password_characters = 'JHfXMz5QV5MXMyPV';

//Config MySQL WoW Mangos
$db_host_mangos = 'localhost';
$db_name_mangos = 'dev_mangos';
$db_username_mangos = 'devevoxis';
$db_password_mangos = 'JHfXMz5QV5MXMyPV';

//Config UpdateFields.h
$playerDataFieldGender = 23;
$playerDataFieldMoney = 1547;
$playerDataFieldHonorableKills = 1603;
$playerDataFieldLevel = 54;
// 2.4.3 : UNIT_FIELD_LEVEL=34 | UNIT_FIELD_BYTES_0=36 | PLAYER_FLAGS=236
// 3.0.3 : UNIT_FIELD_LEVEL=53 | UNIT_FIELD_BYTES_0=22 | PLAYER_FLAGS=150
// 3.1.3 : UNIT_FIELD_LEVEL=53 | UNIT_FIELD_BYTES_0=22 | PLAYER_FLAGS=150

//Config WebSite
$ws_name = '.:: Evoxis V4 - DEV - Serveur WoW RP - Communauté Role-Play ::.';
$ws_domain = 'http://dev.evoxis.info/';
$ws_version = '5.0';
$ws_env = 'dev';

//Config TeamSpeak
$ts_host = 'evoxis.info';

//Config Mail
$email_from = 'evoxis@gmail.com';
$email_reply = 'evoxis@gmail.com';

$email_date = date("l j F Y, G:i");

$email_entete = "From: $email_from <$email_from>\n";
$email_entete .= "MIME-Version: 1.0\n";
$email_entete .= "Return-Path: <$email_reply>\n";
$email_entete .= "Content-Type: text/html; charset=iso-8859-1\n";
$email_entete .= "Cc: \n";
$email_entete .= "Bcc: \n";
$email_entete .= "Reply-To: $email_reply \n";
$email_entete .= "X-Mailer: PHP/" . phpversion() . "\n" ;
$email_entete .= "X-Sender: <$ws_domain>\n";
$email_entete .= "X-auth-smtp-user: $email_from\n";
$email_entete .= "X-abuse-contact: $email_from\n";
$email_entete .= "Date: $email_date\n"; 

?>
