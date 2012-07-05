<?php
$n="home"; 
if (isset($_GET['n'])){
	$n=$_GET['n'];
	}
	switch($n){
		case "timovi":
			$include="php/timovi.php";
			break;
		case "ogranci":
			$include="php/ogranci.php";
			break;
		case "korisnici":
			$include="php/korisnici.php";
			break;
		case "urediTim":
			$include="php/timEdit.php";
			break;
		case "urediOgranak":
			$include="php/ogranakEdit.php";
			break;
		case "urediKorisnika":
			$include="php/korisnikEdit.php";
			break;	
		case "funkcijeKorisnika":
			$include="php/funkcijeKorisnika.php";
			break;			
									
		default:
			$include="php/home.php";
			break;
		}//switch
	
	
?>