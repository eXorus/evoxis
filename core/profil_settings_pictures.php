<?php
defined( '_VALID_INDEX' ) or die( 'Restricted access' );
define( '_VALID_CORE_PROFIL_SETTINGS_PICTURES', 1 );

//Avatars
$r = $db->Send_Query("SELECT COUNT(*) FROM exo_pictures WHERE uid=".$_SESSION['uid']." AND type=1");
$d = $db->get_row($r);
$count_A = $d[0];
if($_GET['select']==1) $form_A='checked="checked"';

//Photo
$r = $db->Send_Query("SELECT COUNT(*) FROM exo_pictures WHERE uid=".$_SESSION['uid']." AND type=2");
$d = $db->get_row($r);
$count_P = $d[0];
if($_GET['select']==2) $form_P='checked="checked"';

//Créations graphiques
$r = $db->Send_Query("SELECT COUNT(*) FROM exo_pictures WHERE uid=".$_SESSION['uid']." AND type=3");
$d = $db->get_row($r);
$count_CG = $d[0];
if($_GET['select']==3) $form_CG='checked="checked"';

//Avatars Persos
$r = $db->Send_Query("SELECT COUNT(*) FROM exo_pictures WHERE uid=".$_SESSION['uid']." AND type=4");
$d = $db->get_row($r);
$count_AP = $d[0];
if($_GET['select']==4) $form_AP='checked="checked"';


//Formulaire envoyé
if(!empty($_GET['task']) && $_GET['task']=="process"){

		$pictures_erreur = '';
		
		if($_POST['directory']==1){
	        $maxsize = 102400;
	        $maxwidth = 100;
	        $maxheight = 150;
			$type=1;
			
			if($count_A>=5) $pictures_erreur .= "<li>Vous ne pouvez télécharger que 5 Avatars maximum</li>";
		}
		elseif($_POST['directory']==2){
	        $maxsize = 307200;
	        $maxwidth = 300;
	        $maxheight = 400;
			$type=2;
			
			if($count_P>=1) $pictures_erreur .= "<li>Vous ne pouvez télécharger qu'une Photo</li>";
		}
		elseif($_POST['directory']==3){
	        $maxsize = 1024000;
	        $maxwidth = 800;
	        $maxheight = 600;
			$type=3;
		}		
		elseif($_POST['directory']==4){
	        $maxsize = 102400;
	        $maxwidth = 100;
	        $maxheight = 150;
			$type=4;
		}
        //Liste des extensions valides
        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png'); 
		
		
		if (empty($_POST['directory']))
        {
			$pictures_erreur .= "<li>Vous devez sélectionner un répertoire</li>";
        }
		
        if ($_FILES['pictures']['size'] > $maxsize)
        {
			$pictures_erreur .= "<li>Le fichier est trop gros : (<strong>".$_FILES['pictures']['size']." Octets</strong> contre <strong>".$maxsize." Octets</strong>)</li>";
        }

        $image_sizes = getimagesize($_FILES['pictures']['tmp_name']);
			
        if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight)
        {
			$pictures_erreur .= "<li>Image trop large ou trop longue :
        (<strong>".$image_sizes[0]."x".$image_sizes[1]."</strong> contre
        <strong>".$maxwidth."x".$maxheight."</strong>)</li>";
        }

        $extension_upload = strtolower(substr(  strrchr($_FILES['pictures']['name'], '.')  ,1));
		
        if (!in_array($extension_upload,$extensions_valides) )
        {
            $pictures_erreur .= "<li>Extension de l'avatar incorrecte</li>";
        }
		
		if (empty($pictures_erreur)){
			//Aucune erreur
			$rq = $db->Send_Query("
				INSERT INTO `exo_pictures` ( `id` , `uid` , `image_extension` , `type` , `selected` )
				VALUES (NULL , '".$_SESSION['uid']."', '$extension_upload', '$type', '0')");	
			$id = $db->last_insert_id();
			move_uploaded_file($_FILES['pictures']['tmp_name'],"./img/pictures/".$id.".".$extension_upload);
			
			if($_POST['directory']==1){
			
				//Query
				$rq = $db->Send_Query("
				UPDATE exo_pictures
				SET selected='0' 
				WHERE uid='".$_SESSION['uid']."' AND type=1");	
				
				//Query
				$rq = $db->Send_Query("
				UPDATE exo_pictures
				SET selected='1' 
				WHERE uid='".$_SESSION['uid']."' AND id=$id");	

				thumbnail("./img/pictures/".$id.".".$extension_upload, '60', '60',$extension_upload, $id);
			}
			elseif($_POST['directory']==4){
				thumbnail("./img/pictures/".$id.".".$extension_upload, '60', '60',$extension_upload, $id);
			}
			else{
				thumbnail("./img/pictures/".$id.".".$extension_upload, '100', '100',$extension_upload, $id);
			}			
			
			
			$msg = message::getInstance('SUCCESS','Image ajoutée', ' index.php?comp=profil_settings');
			
		}  
 } 
 
 if(!empty($_GET['action']) && $_GET['action']=="delete" && !empty($_GET['select'])){
	$select= intval($_GET['select']);
	$r = $db->Send_Query("SELECT image_extension FROM exo_pictures WHERE uid=".$_SESSION['uid']." AND id=$select");
	$d = $db->get_row($r);
	$ext = $d[0];
	$name = "./img/pictures/".$select.".".$ext;
	if (file_exists($name)==true) unlink($name);
	$rq = $db->Send_Query("
			DELETE FROM exo_pictures
			WHERE  uid=".$_SESSION['uid']." AND id=$select");	
			
	$msg = message::getInstance('SUCCESS','Image supprimée', ' index.php?comp=profil_settings');
 }
  
/*
* MANAGE TITLE CATEGORIE
*/
$titleCat = 'profil';
 
/*
* MANAGE PATHWAY
*/
$pathway = array(
'Profil' => 'index.php?comp=profil',
'Modifier mes réglages' => 'index.php?comp=profil_settings',
'Uploader une image' => ''
);
$ws_name_perso = 'Evoxis v5 - Modifier mes réglages - Uploader une image';
?>
