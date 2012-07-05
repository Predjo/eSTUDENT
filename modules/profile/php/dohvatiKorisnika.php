<?php 
$baza = new Estudent;
$myprofile=false;

if (isset($_GET['id'])){$userID = $_GET['id']; }
else {
	$userID = $_SESSION['user']->id;
	}

if ($userID == $_SESSION['user']->id){
	$myprofile=true;
	}

$result = $baza->dohvatiKorisnika($userID);

if ($result) {$korisnik = $result->podatci; }
else die($result->poruka);	
?>