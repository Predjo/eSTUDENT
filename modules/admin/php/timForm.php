<?php 
include "../../../resource/php/estudentClass.php"; 
$baza = new Estudent;
$result = $baza->dohvatiOgranke();
$ogranci = $result->podatci;
?>
<script>
$(document).ready(function(){
$('.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
			}
);	
	
	});
</script>
<div clss="formWrap">
<form class="well" id="dodajTim">
<label for="nazivTima">Naziv Tima</label>
<input id="nazivTima" type="text" name="nazivTima" placeholder="Naziv tima"  class="formInput" required />

<label for="kraticaTima">Kratica Tima</label>
<input id="kraticaTima" type="text" name="kraticaTima" placeholder="Kratica tima"  class="formInput" required />

<label for="ogranakTim">Ogranak</label>
<select id="ogranakTim" name="ogranakTim" class="formSelect">
<?php 
foreach($ogranci as $ogranak){
echo "<option value=\"{$ogranak->id}\">{$ogranak->kratica}</option>";	
	}
?>

</select>

<label for="stabniTim">Štabni tim</label>
<select id="stabniTim" name="stabniTim" class="formSelect">
<option value="0">Da</option>
<option value="1">Ne</option>
</select>

<label for="aktivanTim">Ativan tim</label>
<select id="aktivanTim" name="aktivanTim" class="formSelect">
<option value="1">Da</option>
<option value="0">Ne</option>
</select>

<label for="osnovanTim">Osnovan tim</label>
<input id="osnovanTim" type="text" name="osnovanTim" placeholder="2012-12-21"  class="formInput datepicker" required />

<label for="opisTima">Opis Tima</label>
<textarea name="opisTima" cols="80" rows="5" id="opisTima" class="formText" placeholder="Opis tima"></textarea>

<div>
<hr>
<input type="submit" name="submit" id="submitButton" value="Dodaj" class="btn btn-core btn-large"/>
<input type="button" name="cancel" id="cancelButton" value="Odustani" class="btn btn-large"/>
<img class="loadingGif" style="display:none" src="images/loading.gif" />
</div>
</form>
</div>