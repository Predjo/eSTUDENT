<?php 
if (!is_null($korisnik->email) && ($korisnik->email!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">eSTUDENT email:</span> {$korisnik->email} </div>";
	}

if (!is_null($korisnik->privatniEmail) && ($korisnik->privatniEmail!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Privatni email:</span>  {$korisnik->privatniEmail} </div>";
	}

if (isset($korisnik->spol) && ($korisnik->spol!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Spol:</span>  {$korisnik->spol} </div>";
	}	

if (isset($korisnik->datumRodenja) && ($korisnik->datumRodenja!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Datum rođenja:</span>  {$korisnik->datumRodenja} </div>";
	}

if (isset($korisnik->ulica) && ($korisnik->ulica!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Ulica:</span>  {$korisnik->ulica} </div>";
	}

if (!is_null($korisnik->grad) && ($korisnik->grad!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Grad:</span>  {$korisnik->grad} </div>";
	}
	
if (!is_null($korisnik->pbr) && ($korisnik->pbr!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Pbr:</span>  {$korisnik->pbr} </div>";
	}	

if (!is_null($korisnik->hobiji) && (trim($korisnik->hobiji) != "") && ($korisnik->hobiji!="null")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Hobiji:</span>  {$korisnik->hobiji} </div>";
	}	
	
if (!is_null($korisnik->tecajevi) && (trim($korisnik->tecajevi) != "") && ($korisnik->tecajevi!="null")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Tečajevi:</span>  {$korisnik->tecajevi} </div>";
	}	
	
if (!is_null($korisnik->volonterskiRad) && (trim($korisnik->volonterskiRad) != "") && ($korisnik->volonterskiRad!="null")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Volonterski rad:</span>  {$korisnik->volonterskiRad} </div>";
	}	
	
if (!is_null($korisnik->podrucjeInteresa) && (trim($korisnik->podrucjeInteresa) != "") && ($korisnik->podrucjeInteresa!="null")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Podrucje interesa:</span>  {$korisnik->podrucjeInteresa} </div>";
	}	
	
if (!is_null($korisnik->ostaleUdruge) && (trim($korisnik->ostaleUdruge) != "") && ($korisnik->ostaleUdruge!="null")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Ostale udruge:</span>  {$korisnik->ostaleUdruge} </div>";
	}						
?>