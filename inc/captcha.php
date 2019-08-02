<?php
session_start();
header('Content-type: image/jpeg');
header('Cache-Control: no-store, no-cache, must-revalidate');
$liste = "abcdefghjkmnpqrstuvwxyz123456789ABCDEFGHJKMNPQRSTUVWXYZ";
$code = '';
while(strlen($code) != 5) {
$code .= $liste[rand(0,63)];
}
$_SESSION['code']=$code;
$img = imageCreate(60, 18);
$fond = imageColorAllocate($img,0,0,0);
$texte = imageColorAllocate($img,255,255,255);
imageString($img, 5, 4, 1, $code,$texte);
imagejpeg($img,'',30);
imageDestroy($img);
?>