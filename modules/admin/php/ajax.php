<?php
$eventType=$_POST['eventType'];
include "../../../resource/php/estudentClass.php";
session_start();
$godina='2012';

$baza = new Estudent;

$dozvole = array('admin');
$ima_dozvolu = $baza->korisnikImaDozvolu($_SESSION['user']->id,$dozvole)->podatci;
if(!$ima_dozvolu){
	exit('Nemaš potrebne ovlasti za ovo!');
	}



switch ($eventType){
	case 'izbrisiKorisnika':
		$id=$_POST['id'];
		$result=$baza->izbrisiKorisnika($id);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka;
	break;
	
	case 'izbrisiTim':
		$id=$_POST['id'];
		$result=$baza->izbrisiTim($id);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka;
	break;
	
	case 'izbrisiOgranak':
		$id=$_POST['id'];
		$result=$baza->izbrisiOgranak($id);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka;
	break;
	
	case 'dodajKorisnika':
		$korisnik = new Korisnik;
		$korisnik->email=$_POST['email'];
		$korisnik->lozinka=phpbb_hash($_POST['lozinka']);
		$korisnik->ime=$_POST['ime'];
		$korisnik->prezime=$_POST['prezime'];
		$korisnik->jmbag=$_POST['jmbag'];
		$korisnik->fakultet=$_POST['ogranakID'];
		$result=$baza->dodajKorisnika($korisnik);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka;
	break;
	
	case 'urediKorisnika':
		$korisnikID = $_POST['id'];
		$json = json_decode($_POST['json']);
		if ($json->stupci[0]=='lozinka'){
			$json->vrijednosti[0] = phpbb_hash($json->vrijednosti[0]);
			}
		$result = $baza->urediKorisnika($korisnikID,$json->stupci,$json->vrijednosti);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka;
	break;
	
					
	case 'dodajTim':
		$tim= new Tim;
		$tim->naziv = $_POST['naziv'];
		$tim->kratica = $_POST['kratica'];
		$tim->idOgranak = $_POST['ogranakID'];
		$tim->stabni = $_POST['stabni'];
		$tim->osnovan = $_POST['osnovan'];
		$tim->aktivan = $_POST['aktivan'];
		$tim->opis = $_POST['opis'];
		$result=$baza->dodajTim($tim);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka;
	break;

	case 'urediTim':
		$tim= new Tim;
		$tim->id = $_POST['id'];
		$tim->naziv = $_POST['naziv'];
		$tim->kratica = $_POST['kratica'];
		$tim->idOgranak = $_POST['ogranakID'];
		$tim->stabni = $_POST['stabni'];
		$tim->osnovan = $_POST['osnovan'];
		$tim->aktivan = $_POST['aktivan'];
		$tim->opis = $_POST['opis'];
		$stupci=array('naziv','kratica','idOgranak','stabni','osnovan','aktivan','opis');
		$vrijednosti=array($tim->naziv,$tim->kratica,$tim->idOgranak,
					$tim->stabni,$tim->osnovan,$tim->aktivan,$tim->opis);
		$result=$baza->urediTim($tim->id,$stupci,$vrijednosti);			
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka;

	break;	
	
	case 'dodajOgranak':
		$ogranak= new Ogranak;
		$ogranak->naziv = $_POST['naziv'];
		$ogranak->kratica = $_POST['kratica'];
		$result=$baza->dodajOgranak($ogranak);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka;
	break;
	
	case 'urediOgranak':
		$ogranak = new Ogranak;
		$ogranak->id = $_POST['id'];
		$ogranak->naziv = $_POST['naziv'];
		$ogranak->kratica = $_POST['kratica'];
		$stupci = array('naziv','kratica');
		$vrijednosti = array($ogranak->naziv,$ogranak->kratica);
		$result=$baza->urediOgranak($ogranak->id,$stupci,$vrijednosti);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka;
	break;	
	
	case 'dodajKorisnikeUTim':
					
			$json=json_decode($_POST['id']);
			$timID=$_POST['timID'];
			if (!empty($json->id)){


			foreach($json->id as $korisnik){
				if(is_null($korisnik)){continue;}
				$korisnik = explode('/',$korisnik);
				$korisnikID = $korisnik[0];
				$funkcijaID = $korisnik[1];
				$result = $baza->dodajKorisnikaUTim($korisnikID,$timID,$godina,$funkcijaID);
				}
			if($result->uspjeh){echo 'ok';}
			else echo $result->poruka.": ".$result->SQLgreska;
			}
		else echo 'ok';
	break;
	
	case 'makniKorisnikaIzTima':
		$korisnikID = $_POST['korisnikID'];
		$timID = $_POST['timID'];
		$result = $baza->makniKorisnikaIzTima($korisnikID,$timID);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka.": ".$result->SQLgreska;
	break;
	
	case 'dodajFunkcijuKorisnika':
		$funkcija = new FunkcijaKorisnika;
		$funkcija->nazivM = $_POST['nazivM'];
		$funkcija->nazivZ = $_POST['nazivZ'];
		$funkcija->flag = 0;
		$result = $baza->dodajFunkcijuKorisnika($funkcija);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka.": ".$result->SQLgreska;
	break;
	
	case 'dodajJezik':
		$korisnikID = $_POST['korisnikID']; 
		$jezik = $_POST['jezik']; 
		$stupanj = $_POST['stupanj'];
		$result = $baza->dohvatiKorisnika($korisnikID);
		$korisnik = $result->podatci;
		$jezici = unserialize($korisnik->jezik);
		if(!is_array($jezici)){$jezici = array();}
		$noviJezik = array('jezik' => $jezik, 'stupanj' => $stupanj);
		array_push($jezici,$noviJezik);
		$result2 = $baza->urediKorisnika($korisnikID,'jezik',array(serialize($jezici)));
		if($result2->uspjeh){echo 'ok';}
		else echo $result2->poruka;
		
	break;

	case 'dodajPoslodavca':
		$korisnikID = $_POST['korisnikID'];
		$trajanje = $_POST['trajanje'];  
		$poslodavac = $_POST['poslodavac'];  
		$pozicija = $_POST['pozicija']; 
		$vjestine = $_POST['vjestine']; 
		$kontaktIme = $_POST['kontaktIme'];  
		$kontaktTelBroj = $_POST['kontaktTelBroj'];  
		$kontaktEmail = $_POST['kontaktEmail']; 
		$result = $baza->dohvatiKorisnika($korisnikID);
		$korisnik = $result->podatci;
		$poslodavci = unserialize($korisnik->poslodavac);
		if(!is_array($poslodavci)){$poslodavci = array();}
		$noviPoslodavac = array('trajanje' => $trajanje,
								 'poslodavac' => $poslodavac, 
								 'pozicija' => $pozicija, 
								 'kontaktIme' => $kontaktIme,
								 'kontaktTelBroj' => $kontaktTelBroj,
								 'kontaktEmail' => $kontaktEmail );
		array_push($poslodavci,$noviPoslodavac);
		$result2 = $baza->urediKorisnika($korisnikID,'poslodavac',array(serialize($poslodavci)));
		if($result2->uspjeh){echo 'ok';}
		else echo $result2->poruka;
		
	break;
			
	
	case 'izbrisiJezik':
		$korisnikID = $_POST['korisnikID'];
		$jezikID = $_POST['jezikID'];
		$result = $baza->dohvatiKorisnika($korisnikID);
		$korisnik = $result->podatci;
		$jezici = unserialize($korisnik->jezik);
		unset($jezici[$jezikID]);
		$result2 = $baza->urediKorisnika($korisnikID,'jezik',array(serialize(array_values($jezici))));
		if($result2->uspjeh){echo 'ok';}
		else echo $result2->poruka;			
	break;
	
	case 'izbrisiPoslodavca':
		$korisnikID = $_POST['korisnikID'];
		$poslodavacID = $_POST['poslodavacID'];
		$result = $baza->dohvatiKorisnika($korisnikID);
		$korisnik = $result->podatci;
		$poslodavci = unserialize($korisnik->poslodavac);
		unset($poslodavci[$poslodavacID]);
		$result2 = $baza->urediKorisnika($korisnikID,'poslodavac',array(serialize(array_values($poslodavci))));
		if($result2->uspjeh){echo 'ok';}
		else echo $result2->poruka;				
	break;
		
	}//switch

?>