<div id="wallInput">
	<form id="dodajPorukuNaZid">
    	<label for="wall_input">Napiši nešto!</label>
    	<textarea name="wall_input" type="text" id="wall_input" class="wallInput"></textarea>
        <input type="submit" value="Pošalji" class="btn btn-core btn-large"/>
        <input type="hidden" id="IDKorisnik_salje" value="<?php echo $_SESSION['user']->id; ?>"/>
        <input type="hidden" id="IDKorisnik_prima" value="<?php echo $userID; ?>"/>
        <img class="loadingGif" style="display:none" src="images/loading.gif" />
        
    </form>
    <hr>
</div>
<div id="porukeZid"></div>