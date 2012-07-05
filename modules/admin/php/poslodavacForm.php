<div clss="formWrap">
<form class="well" id="dodajPoslodavca">
	
    <fieldset><legend>Posao</legend>
    <label for="trajanjePosla">Trajanje</label>
    <select name="trajanjePosla" class="formSelect" id="trajanjePosla">
    <option value="manje od mjesec dana">manje od mjesec dana</option>
    <option value="1 do do 3 mjeseca">1 do do 3 mjeseca</option>
    <option value="3 do 6 mjeseci">3 do 6 mjeseci</option>
    <option value="6 mjeseci do 1 godine">6 mjeseci do 1 godine</option>
    <option value="1 godina do 5 godina">1 godina do 5 godina</option>
    <option value="više od 5 godina">više od 5 godina</option>
    </select>
    
    <label for="imePoslodavca">Poslodavac</label>
    <input id="imePoslodavca" name="imePoslodavca" type="text" class="formInput" required/>
    
    <label for="nazivPozicije" >Naziv Pozicije</label>
    <input id="nazivPozicije" name="nazivPozicije" type="text" class="formInput" required />
    
    <label for="zahtjevaneVjestine" >Zahtjevane vještine</label>
    <textarea class="formTextareaBox" name="zahtjevaneVjestine" id="zahtjevaneVjestine" ></textarea>
    </fieldset>
    
    <fieldset><legend>Kontakt osoba</legend>
    <label for="imeKontakta" >Ime i prezime</label>
    <input id="imeKontakta" name="imeKontakta" type="text" class="formInput" />
    
    <label for="telBrojKontakta" >Tel. broj</label>
    <input id="telBrojKontakta" name="telBrojKontakta" type="text" class="formInput" />
    
    <label for="emailKontakta">email</label>
    <input id="emailKontakta" name="emailKontakta" type="email" class="formInput" />
    </fieldset>


<div>
<hr>
<input type="submit" name="submit" id="submitButton" value="Dodaj" class="btn btn-core btn-large"/>
<input type="button" name="cancel" id="cancelButton" value="Odustani" class="btn btn-large"/>
<img class="loadingGif" style="display:none" src="images/loading.gif" />
</div>


</form>
</div>