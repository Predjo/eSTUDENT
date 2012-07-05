<?php 
if (!is_null($korisnik->ogranak_naziv) && ($korisnik->ogranak_naziv!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Fakultet:</span> {$korisnik->ogranak_naziv} </div>";
	}

if (!is_null($korisnik->godinaUpisa) && ($korisnik->godinaUpisa!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Godina upisa:</span>  {$korisnik->godinaUpisa} </div>";
	}

if (isset($korisnik->smjer) && ($korisnik->smjer!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Smjer:</span>  {$korisnik->smjer} </div>";
	}

if (!is_null($korisnik->prosjek) && ($korisnik->prosjek!="")){
	echo "<div class=\"userInfo last\"><span class=\"userInfoTitle\">Prosjek:</span>  {$korisnik->prosjek} </div>";
	}
?>