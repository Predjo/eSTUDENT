
<?php
if($ima_dozvolu){
	echo "<h6>Admin kontrole:</h6>";
	echo "<a href=\"../admin/index.php?n=urediKorisnika&id={$userID}\">Uredi korisnika</a>";
	echo "<hr>";
						}
if($myprofile){
	echo "<h6>Korisničke kontrole:</h6>";
	echo "<a href=\"index.php?edit=edit\">Uredi profil</a>";
						}	
?>