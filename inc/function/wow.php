<?php

//Function
function get_zone_name($mapid, $x, $y){


//Define

$maps_a = Array(
0 => 'Azeroth',
1 => 'Kalimdor',
2 => 'UnderMine',
13 => 'Test zone',
17 => 'Kalidar',
30 => 'Vallée d\'Alterac',
33 => 'Donjon d\'Ombrecroc',
34 => 'La Prison',
35 => 'La Prison',
36 => 'Les Mortemines',
37 => 'Plains of Snow',
43 => 'Caverne des Lamentations',
44 => 'Le Monastère',
47 => 'Kraal de Tranchebauge',
48 => 'Profondeurs de Brassenoire',
70 => 'Uldaman',
90 => 'Gnomeregan',
109 => 'Temple d\'Atal\'Hakkar',
129 => 'Souilles de Tranchebauge',
169 => 'Emerald Forest',
189 => 'Le Monastère Ecarlate',
209 => 'ZulFarrak',
229 => 'Pic Rochenoire',
230 => 'Profondeurs de Rochenoire',
249 => 'Le repaire d\'Onyxia',
269 => 'Grottes du Temps',
289 => 'Scholomance',
309 => 'ZulGurub',
329 => 'Stratholme',
349 => 'Maraudon',
369 => 'Tram des profondeurs',
389 => 'Gouffre de Ragefeu',
409 => 'Coeur du Magma',
429 => 'Hache-Tripes',
449 => 'Alliance PVP Barracks',
450 => 'Horde PVP Barracks',
451 => 'Development Land',
469 => 'Repaire de l\'Aile Noire',
489 => 'Goulet des Chanteguerre',
509 => 'Ruines d\'AhnQiraj',
529 => 'Bassin d\'Arathi',
530 => 'Outreterre',
531 => 'Temple d\'AhnQiraj',
533 => 'Naxxramas',
532 => 'Karazahn',
534 => 'Bataille du Mont Hyjal',
540 => 'Les Salles Brisées',
542 => 'La Fournaise de Sang',
543 => 'Remparts des Flammes Infernales',
544 => 'Repaire de Magthéridon',
545 => 'Le Caveau de la Vapeur',
546 => 'La Basse Tourbière',
547 => 'Les Enclos aux Esclaves',
548 => 'Caverne du Sanctuaire du Serpent',
550 => 'Le Donjon de la Tempête',
552 => 'Le Donjon de la Tempête',
553 => 'Le Donjon de la Tempête',
554 => 'Le Donjon de la Tempête',
555 => 'Auchindoun',
556 => 'Auchindoun',
557 => 'Auchindoun',
558 => 'Auchindoun',
559 => 'Arêne de Nagrand',
560 => 'Les Contreforts de Hautebrande d\'Antan',
562 => 'Arêne des Tranchantes',
564 => 'Le Temple Noir',
565 => 'Repaire de Gruul',
566 => 'Arêne de Raz-de-Néant',
568 => 'Zulaman',
);

$zone = Array(
0 => Array(
Array(700,10,1244,1873,'Fossoyeuse',1497),
Array(-840,-1330,-5050,-4560,'Forgefer',1537),
Array(1190,200,-9074,-8280,'Hurlevent',1519),
Array(-2170,-4400,-7348,-6006,'Terres Ingrates',3),
Array(-500,-4400,-4485,-2367,'Les Paluns',11),
Array(2220,-2250,-15422,-11299,'Vallée de Strangleronce',33),
Array(-1724,-3540,-9918,-8667,'Les Carmines',44),
Array(-2480,-4400,-6006,-4485,'Loch Modan',38),
Array(662,-1638,-11299,-9990,'Bois de la Pénombre',10),
Array(-1638,-2344,-11299,-9918,'Défilé de Deuillevent',41),
Array(834,-1724,-9990,-8526,'Forêt d\'Elwynn',12),
Array(-500,-3100,-8667,-7348,'Steppes Ardentes',46),
Array(-608,-2170,-7348,-6285,'Gorge des Vents Brûlants',51),
Array(2000,-2480,-6612,-4485,'Dun Morogh',1),
Array(-1575,-5425,-432,805,'Les Hinterlands',47),
Array(3016,662,-11299,-9400,'Marche de l\'Ouest',40),
Array(600,-1575,-1874,220,'Contreforts de Hautebrande',267),
Array(-2725,-6056,805,3800,'Maleterres de l\'Est',139),
Array(-850,-2725,805,3400,'Maleterres de l\'Ouest',28),
Array(2200,600,-900,1525,'Forêt des Pins Argentés',130),
Array(2200,-850,1525,3400,'Clairières de Tirisfal',85),
Array(-2250,-3520,-12800,-10666,'Terres Foudroyées',4),
Array(-2344,-4516,-11070,-9600,'Marais des Chagrins',8),
Array(-1575,-3900,-2367,-432,'Hautes-Terres d'."'".'Arathi',45),
Array(600,-1575,220,1525,'Montagnes d\'Alterac',36),
),
1 => Array(
Array(2698,2030,9575,10267,'Darnassus',1657),
Array(326,-360,-1490,-910,'Pitons-du-Tonnerre',1638),
Array(-3849,-4809,1387,2222,'Orgrimmar',1637),
Array(-1300,-3250,7142,8500,'Reflet-de-Lune',493),
Array(2021,-400,-9000,-6016,'Silithus',1377),
Array(-2259,-7000,4150,8500,'Winterspring',618),
Array(-400,-2094,-8221,-6016,'Cratère d\'Un\'Goro',490),
Array(-590,-2259,3580,7142,'Gangrebois',361),
Array(-3787,-8000,1370,6000,'Azshara',16),
Array(-1900,-5500,-10475,-6825,'Tanaris',440),
Array(-2478,-5500,-5135,-2330,'Marécage d\'Âprefange',15),
Array(360,-1536,-3474,-412,'Mulgore',215),
Array(4000,-804,-6828,-2477,'Feralas',357),
Array(3500,360,-2477,372,'Desolace',405),
Array(-804,-5500,-6828,-4566,'Mille Pointes',400),
Array(-3758,-5500,-1300,1370,'Durotar',14),
Array(1000,-3787,1370,4150,'Orneval',331),
Array(2500,-1300,4150,8500,'Sombrivage',148),
Array(3814,-1100,8600,11831,'Teldrassil',141),
Array(3500,-804,-412,3580,'Les Serres-Rocheuses',406),
Array(-804,-4200,-4566,1370,'Les Tarides',17),
),
530 => Array(
Array(6135.25,4829,-2344.78,-1473.95,'Shattrath',3703),
Array(-6400.75,-7612.20,9346.93,10153.70,'Lune d\'Argent',3487),
Array(5483.33,-91.66,1739.58,5456.25,'Raz-de-Néant',3523),
Array(7083.33,1683.33,-4600,-999.99,'Forêt de Terokkar',3519),
Array(10295.83,4770.83,-3641.66,41.66,'Nagrand',3518),
Array(-10075,-13337.49,-2933.33,-758.33,'Île de Brume-Sang',3525),
Array(8845.83,3420.83,791.66,4408.33,'Les Tranchantes',3522),
Array(4225,-1275,-5614.58,-1947.91,'Vallée d\'Ombrelune',3520),
Array(-11066.36,-12123.13,-4314.37,-3609.68,'L\'Exodar',3557),
Array(9475,4447.91,-1416.66,1935.41,'Marécage de Zangar',3521),
Array(5539.58,375,-1962.49,1481.25,'Péninsule des Flammes Infernales',3483),
Array(-10500,-14570.83,-5508.33,-2793.75,'Île de Brume-Azur',3524),
Array(-5283.33,-8583.33,6066.66,8266.66,'Les Terres Fantômes',3433),
Array(-4487,-9412,7758,11041,'Bois des chants-éternels',3430)
),
);



if (!empty($maps_a[$mapid]))
  {
  $zmap=$maps_a[$mapid];
  if (($mapid==0) or ($mapid==1) or ($mapid==530))
    {
    $i=0; $c=count($zone[$mapid]);
    while ($i<$c)
      {
  if ($zone[$mapid][$i][2] < $x  AND $zone[$mapid][$i][3] > $x AND $zone[$mapid][$i][1] < $y  AND $zone[$mapid][$i][0] > $y) $zmap=$zone[$mapid][$i][4];
      $i++;
      }
    }
  } else $zmap="Zone Inconnue";
return $zmap;
} 


?>