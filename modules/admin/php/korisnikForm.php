<?php 
include "../../../resource/php/estudentClass.php"; 
$baza = new Estudent;
$result = $baza->dohvatiOgranke();
$ogranci = $result->podatci;
?>
<div clss="formWrap">
<form class="well" id="dodajKorisnika">

<label for="emailKorisnika" class="control-label">eSTUDENT mail</label>
<div class="input-append">
<input id="emailKorisnika"  name="emailKorisnika" placeholder="email Korisnika"  class="formInput" style="width:200px;" required /><span class="add-on" style="margin-bottom:9px; width:90px; height:25px;">@estudent.hr</span></div>

<label for="lozinkaKorisnika">Lozinka</label>
<input id="lozinkaKorisnika" type="text" name="lozinkaKorisnika" placeholder="Lozinka Korisnika"  class="formInput" required />

<label for="imeKorisnika">Ime</label>
<input id="imeKorisnika" type="text" name="imeKorisnika" placeholder="Ime Korisnika"  class="formInput" required />

<label for="prezimeKorisnika">Prezime</label>
<input id="prezimeKorisnika" type="text" name="prezimeKorisnika" placeholder="Prezime Korisnika"  class="formInput" required />

<label for="jmbagKorisnika">JMBAG</label>
<input id="jmbagKorisnika" type="text" name="jmbagKorisnika" placeholder="JMBAG Korisnika"  class="formInput" required />

<label for="ogranakKorisnika">Ogranak</label>
<select id="ogranakKorisnika" name="ogranakKorisnika" class="formSelect">
<?php 
foreach($ogranci as $ogranak){
echo "<option value=\"{$ogranak->id}\">{$ogranak->kratica}</option>";	
	}
?>
</select>

<div>
<hr>
<input type="submit" name="submit" id="submitButton" value="Dodaj" class="btn btn-core btn-large submit"/>
<input type="button" name="cancel" id="cancelButton" value="Odustani" class="btn btn-large"/>
<img class="loadingGif" style="display:none" src="images/loading.gif" />
</div>

</form>
</div>