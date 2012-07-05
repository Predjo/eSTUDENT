<?php 
$result = $baza->dohvatiTimoveKorisnika($korisnik->id);
$timovi = $result->podatci;
if ($timovi){
$options=array(
	'id' => 'timoviTablicaProfile',
	'class' => "coreTablica table table-striped",
	'headers' => 'Funkcija,Naziv,Kratica,Ogranak,Godina',
	'showColumns' => 'funkcijaM,naziv,kratica,ogranak_kratica,godinaUTimu'
);
echo createTable2($timovi,$options);
	}
?>