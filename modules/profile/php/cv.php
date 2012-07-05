<?php
if (!is_null($korisnik->glazbenaSkola) && ($korisnik->glazbenaSkola!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Glazbena Škola:</span>  {$korisnik->glazbenaSkola} </div>";
	}	

if (!is_null($korisnik->radNaRacunalu) && ($korisnik->radNaRacunalu!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Rad na računalu:</span>  {$korisnik->radNaRacunalu} </div>";
	}

if (!is_null($korisnik->vozackaDozvola) && ($korisnik->vozackaDozvola!="")){
	echo "<div class=\"userInfo\"><span class=\"userInfoTitle\">Vozačka dozvola:</span>  {$korisnik->vozackaDozvola} </div>";
	}
	
if (!is_null($korisnik->jezik)){
		$jezici = unserialize($korisnik->jezik);
		replaceNull($jezici,'-');
		echo '<h3>Jezici koje znam:</h3>';
		createTable($jezici,"jeziciTable table table-striped");
		echo '<hr />';
	}
	
if (!is_null($korisnik->poslodavac)){
	 	$poslodavci = unserialize($korisnik->poslodavac);
		replaceNull($poslodavci,'-');
		echo '<h3>Poslovi koje sam radio:</h3>';
		createTable($poslodavci,"poslodavciTable table table-striped");
		echo '<hr />';
	
	}		
?>