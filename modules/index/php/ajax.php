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
				<a  href=\"modules/profile/index.php?id={$korisnik->id}\" >
				<div>";
				if ($korisnik->profilePic){
					$li.="<img class=\"profilePicSmall\" src=\"files/userImages/
							{$korisnik->id}/thumbnail/{$korisnik->profilePic}\"/>";
					}
				else {$li.="<img class=\"profilePicSmall\" src=\"resource/images/e.png\"/>";
					}
				
				$li.="{$korisnik->ime} {$korisnik->prezime} ({$korisnik->ogranak_kratica})</div></a></li>";
				echo $li;
				}
			  
							
			}
		else echo $result->poruka;
		break;
	
	}