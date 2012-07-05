<div clss="formWrap">
<form class="well" id="dodajJezik">
<label for="jezik">Jezik</label>
<input id="jezik" type="text" name="jezik" placeholder="jezik"  class="formInput" required />

<label for="stupanjJezik">Stupanj</label>
<select id="stupanjJezik" name="stupanjJezik" class="formSelect">
<option value="Razumijevanje">Razumijevanje</option>
<option value="Čitanje i pisanje">Čitanje i pisanje</option>
<option value="Govornik">Vrsni Govornik</option>
</select>

<div>
<hr>
<input type="submit" name="submit" id="submitButton" value="Dodaj" class="btn btn-core btn-large"/>
<input type="button" name="cancel" id="cancelButton" value="Odustani" class="btn btn-large"/>
<img class="loadingGif" style="display:none" src="images/loading.gif" />
</div>


</form>
</div>