<?php
$eventType=$_POST['eventType'];
include "../../../resource/php/estudentClass.php";
session_start();
$godina='2012';

$baza = new Estudent;


switch ($eventType){
	case 'nadjiKorisnike':
		$parametar = $_POST['parametar'];
		$result=$baza->nadjiKorisnike($parametar);
		if($result->uspjeh){
			foreach ($result->podatci as $korisnik){
				$li= "<li data-id={$korisnik->id} class=\"pretragaKorisnik \">
				<a href=\"index.php?id={$korisnik->id}\" >
				<div>";
				if ($korisnik->profilePic){
					$li.="<img class=\"profilePicSmall\" src=\"../../files/userImages/
							{$korisnik->id}/thumbnail/{$korisnik->profilePic}\"/>";
					}
				else {$li.="<img class=\"profilePicSmall\" src=\"../../resource/images/e.png\"/>";
					}
				
				$li.="{$korisnik->ime} {$korisnik->prezime} ({$korisnik->ogranak_kratica})</div></a></li>";
				echo $li;
				}
			  
			}
		else echo $result->poruka;
		break;
		
		case 'posaljiPoruku':
			$poruka = new Poruka;
			$poruka->idKorisnik_prima = $_POST['idKorisnik_prima'];
			$poruka->idKorisnik_salje = $_POST['idKorisnik_salje'];
			$poruka->tekst = $_POST['tekst'];
			$poruka->tip = $_POST['tip'];
			$result=$baza->dodajPoruku($poruka);
		if($result->uspjeh){echo 'ok';}
		else echo $result->poruka;			
		break;
		
		case 'obrisiPoruku':
			$idPoruka= $_POST['idPoruka'];
			$result=$baza->izbrisiPoruku($idPoruka);
			if($result->uspjeh){echo 'ok';}
			else echo $result->poruka;			
		break;
		
		case 'osvjeziZid':
		
			$dozvole = array('admin');
			$result = $baza->korisnikImaDozvolu($_SESSION['user']->id,$dozvole);
			$ima_dozvolu = $result->podatci;
			
			
			$result=$baza->dohvatiPoruke('zid',$_POST['idKorisnik']);
			$poruke = $result->podatci;
			$ispis='';
			
			if($poruke){
			foreach ($poruke as $poruka){
				
				$delete = 0;
				if ($ima_dozvolu || 
					$poruka->idKorisnik_prima==$_SESSION['user']->id || 
					$poruka->idKorisnik_salje==$_SESSION['user']->id)
					{
						$delete = 1;
					}
				
				$ispis.='<div class = "porukaZid"><div class="porukaZidLijevo">';
				
				if ($poruka->profilePic){
					$ispis.="<img class=\"profilePicSmall\" src=\"../../files/userImages/
							{$poruka->idKorisnik_salje}/thumbnail/{$poruka->profilePic}\"/>";
					}
				else {$ispis.="<img class=\"profilePicSmall\" src=\"../../resource/images/e.png\"/>";
					}
				
				$ispis.='</div><div class = "porukaZidDesno">';
				$ispis.="<div class=\"porukaZidIme\"><a href=\"?id={$poruka->idKorisnik_salje}\">{$poruka->ime} {$poruka->prezime}</a></div>";
				$ispis.="<div class=\"porukaZidTekst\">".nl2br($poruka->tekst)."</div>";
				
				if($delete){
					$ispis.="<div class=\"porukaZidDel\"><a href=\"#\" class=\"delPoruka\" data-idporuka=\"{$poruka->id}\">x</a></div>";
					}
				$ispis.='</div></div>';
				$delete = 0;
			}//foreach
			}//if
			if($result->uspjeh){echo $ispis;}
			else echo $result->poruka;
			break;	
			
		case 'urediKorisnika':
			$korisnikID = $_SESSION['user']->id;
			$json = json_decode($_POST['json']);
			if ($json->stupci[0]=='lozinka'){
				$json->vrijednosti[0] = phpbb_hash($json->vrijednosti[0]);
				}
			$result = $baza->urediKorisnika($korisnikID,$json->stupci,$json->vrijednosti);
			if($result->uspjeh){echo 'ok';}
			else echo $result->poruka;
		break;				
		
		case 'dodajJezik':
			$korisnikID = $_SESSION['user']->id;
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
			$korisnikID = $_SESSION['user']->id;
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
			$korisnikID = $_SESSION['user']->id;
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
			$korisnikID = $_SESSION['user']->id;
			$poslodavacID = $_POST['poslodavacID'];
			$result = $baza->dohvatiKorisnika($korisnikID);
			$korisnik = $result->podatci;
			$poslodavci = unserialize($korisnik->poslodavac);
			unset($poslodavci[$poslodavacID]);
			$result2 = $baza->urediKorisnika($korisnikID,'poslodavac',array(serialize(array_values($poslodavci))));
			if($result2->uspjeh){echo 'ok';}
			else echo $result2->poruka;				
		break;
	
	}