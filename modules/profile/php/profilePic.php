<div id="profilePicWrap">

<?php
$pic = $korisnik->profilePic;
$id = $korisnik->id;

$dozvole = array('admin');
$result = $baza->korisnikImaDozvolu($_SESSION['user']->id,$dozvole);
$ima_dozvolu = $result->podatci;

if ($myprofile || $ima_dozvolu){
	echo "<a class=\"profilePicButton\" href=\"php/uploadPic.php?userid={$id}\" rel=\"facebox\"><input type=\"button\" value=\"Nova slika\"/></a>";}
if(!is_null($pic)){
	echo "<img src=\"../../files/userImages/{$id}/{$pic}\" class=\"profilePicPic\" />";
	}
else {
	echo "<img src=\"../../resource/images/e.png\" class=\"profilePicPic\" />";
	}
?>
</div>