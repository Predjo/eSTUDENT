<?php 

$baza = new Estudent;
$result = $baza->dohvatiOgranke();
$ogranci = $result->podatci;
$result2 = $baza->dohvatiKorisnika($_SESSION['user']->id);

$korisnik = $result2->podatci;
foreach($korisnik as &$val){
	if($val=="null"){$val=NULL;}
	}
$jezici=unserialize($korisnik->jezik);
$poslodavci=unserialize($korisnik->poslodavac);	

?>
      
       <div id="mainNavigation">
       	 <h3>Uredi korisnika: <?php echo $korisnik->ime.' '.$korisnik->prezime; ?></h3> 
         <a href="index.php">← Povratak na profil</a>
         <hr />
            <ul class="nav nav-tabs">
    
                <li  class="active"><a href="#tab1" class="default-tab">Osnovno</a></li> 
                <li><a href="#tab2">Lozinka</a></li>
                <li><a href="#tab3">Fakultet</a></li>
                 <li><a href="#tab4">CV</a></li>
                <li><a href="#tab5">Ostalo</a></li>
            </ul>
        </div>
        <div class="clear"></div>
    
    <div id="mainContent">
        
        <div class="default-tab tab-content" id="tab1"> <!-- Prvi tab Osnovno -->
           <div clss="formWrap">
                <form class="well" id="urediKorisnika1">
                                
                <label class="control-label" for="imeKorisnika" >Ime</label>
                <input id="imeKorisnika" type="text" name="imeKorisnika" placeholder="Ime Korisnika" 
                 class="formInput" required value="<?php echo $korisnik->ime; ?>" />
                
                <label class="control-label" for="prezimeKorisnika">Prezime</label>
                <input id="prezimeKorisnika" type="text" name="prezimeKorisnika" placeholder="Prezime Korisnika"  
                class="formInput" required value="<?php echo $korisnik->prezime; ?>"/>
                
                <label class="control-label" for="jmbagKorisnika">JMBAG</label>
                <input id="jmbagKorisnika" type="text" name="jmbagKorisnika" placeholder="JMBAG Korisnika"  
                class="formInput" required value="<?php echo $korisnik->JMBAG; ?>"/>
                
                <label class="control-label" for="email2">Privatni email</label>
                <input id="email2" name="email2" type="email" class="formInput" placeholder="Privatni email"
                value="<?php echo $korisnik->privatniEmail; ?>"/>  
                
                <label class="control-label" for="spol">Spol </label>
              	<label class="radio inline">
                <input name="spol" type="radio" value="M" <?php if ($korisnik->spol=='M')echo "checked"; ?> />
                M
                </label>
                <label class="radio inline">
                <input name="spol" type="radio" value="Ž" <?php if ($korisnik->spol=='Ž')echo "checked"; ?> />
                Ž
                </label>
                

                
                <label class="control-label" for="datumRodjenja">Datum Rođenja</label>
                <input id="datumRodjenja" name="datumRodjenja" type="text" class="formInput datepicker"  size="30"
                value="<?php echo $korisnik->datumRodenja; ?>"/>
                
                <label class="control-label" for="telBroj">Tel. broj</label>
                <input id="telBroj" name="telBroj" type="text" class="formInput" 
                value="<?php echo $korisnik->telBroj; ?>" />
                
                <label class="control-label" for="ulica">Ulica</label>
                <input id="ulica" name="ulica" type="text" class="formInput" 
                value="<?php echo $korisnik->ulica; ?>" />
                
                <label class="control-label" for="grad">Grad</label>
                <input id="grad" name="grad" type="text" class="formInput"  
                value="<?php echo $korisnik->grad; ?>"/>
                
                <label class="control-label" for="pbr">Pbr.</label>
                <input id="pbr" name="pbr" type="text" class="formInput" 
                value="<?php echo $korisnik->pbr; ?>" />                                             
                
                <div>
                <hr>
                <input type="submit" name="submit" id="submitButton" value="Spremi" class="btn btn-core btn-large submit"/>
                <img class="loadingGif" style="display:none" src="images/loading.gif" />
                </div>
                
                </form>
                </div>

        
            
        </div> <!-- End #tab1 -->
        
        <div id="tab2" class="tab-content"><!-- Drugi tab Lozinka -->
           <div clss="formWrap">
                <form class="well" id="urediKorisnika2">
               
                <label class="control-label" for="lozinkaKorisnika">Lozinka</label>
                <input id="lozinkaKorisnika" type="password" name="lozinkaKorisnika" 
                placeholder="Lozinka"  class="formInput" /> 
               
                <label class="control-label" for="lozinkaKorisnika2">Ponovi lozinku</label>
                <input id="lozinkaKorisnika2" type="password" name="lozinkaKorisnika2" 
                placeholder="Ponovi lozinku"  class="formInput" />
               
                <div>
                <hr>
                <input type="submit" name="submit" id="submitButton" value="Spremi" 
                class="btn btn-core btn-large submit"/>
               
                <img class="loadingGif" style="display:none" src="images/loading.gif" />
               
                </div>                                                
               
                </form>
                </div>            
        </div> <!-- End #tab2 --> 
        
        <div class="tab-content" id="tab3">  <!-- Treci tab Fakultet -->
 
            <div clss="formWrap">
            <form class="well" id="urediKorisnika3">
                       
            <label class="control-label" for="ogranakKorisnika">Ogranak</label>
            <select id="ogranakKorisnika" name="ogranakKorisnika" class="formSelect">
                <?php 
                foreach($ogranci as $ogranak){
		    		if($ogranak->id == $korisnik->fakultet){$selected="selected=\"selected\"";}
					else {$selected="";}
            			echo "<option value=\"{$ogranak->id}\" ".$selected.">{$ogranak->kratica}</option>";	
                	}
                ?>
            </select>                 

            <label class="control-label" for="godina">Godina</label>
            <select name="godina" class="formSelect" id="godina">
                <option <?php if ($korisnik->godinaFakulteta=='1')echo "selected=\"selected\""; ?> value="1.">1.</option>
                <option <?php if ($korisnik->godinaFakulteta=='2')echo "selected=\"selected\""; ?> value="2.">2.</option>
                <option <?php if ($korisnik->godinaFakulteta=='3')echo "selected=\"selected\""; ?> value="3.">3.</option>
                <option <?php if ($korisnik->godinaFakulteta=='4')echo "selected=\"selected\""; ?> value="4.">4.</option>
                <option <?php if ($korisnik->godinaFakulteta=='5')echo "selected=\"selected\""; ?> value="5.">5.</option>
            </select>
            
            <label class="control-label" for="godinaUpisa">Godina Upisa</label>
            <input id="godinaUpisa" name="godinaUpisa" type="text" class="formInput"  
                value="<?php echo $korisnik->godinaUpisa; ?>"/>
            
            <label class="control-label" for="smjer">Smjer</label>
            <input id="smjer" name="smjer" type="text" class="formInput"  
                value="<?php echo $korisnik->smjer; ?>"/>
            
            <label class="control-label" for="prosjek">Prosjek</label>
            <input id="prosjek" name="prosjek" type="text" class="formInput"  
                value="<?php echo $korisnik->prosjek; ?>"/>      

                <div>
                <hr>
                <input type="submit" name="submit" id="submitButton" value="Spremi" class="btn btn-core btn-large submit"/>
                <img class="loadingGif" style="display:none" src="images/loading.gif" />
                </div>                                                
                </form>
                </div> 
                
        </div> <!-- End #tab3 -->                    
 
        <div class="tab-content" id="tab4"><!-- Cetverti tab CV -->
           <div clss="formWrap"> 
           <h3>Jezici</h3>   
           <a href="../admin/php/jezikForm.php" rel="facebox">Dodaj jezik</a>   
        <?php if(isset($jezici)){
			createTable($jezici,"jeziciTable table table-striped table-bordered",true);
			} 
		?>	
        	<hr>
			<h3>Poslodavci</h3>
            <a href="../admin/php/poslodavacForm.php" rel="facebox">Dodaj poslodavca</a> 
        <?php     
			if(isset($poslodavci)){
			createTable($poslodavci,"poslodavciTable table table-striped table-bordered",true);	
				
				}
		?>
       </div>  
        </div> <!-- End #tab4 -->                
        
        <div class="tab-content" id="tab5"><!-- Peti tab Ostalo -->
           <div clss="formWrap">
                <form class="well" id="urediKorisnika5">        
                           <label class="control-label" for="glazbenaSkola">Glazbena škola</label>
                <select name="glazbenaSkola" class="formSelect" id="glazbenaSkola">
                    <option value="Ne" 
					<?php if ($korisnik->glazbenaSkola=='Ne')echo "selected=\"selected\""; ?>>Ne</option>
                    <option value="Srednja" 
                    <?php if ($korisnik->glazbenaSkola=='Srednja')echo "selected=\"selected\""; ?>>Srednja</option>
                    <option value="Akademija"
                    <?php if ($korisnik->glazbenaSkola=='Akademija')echo "selected=\"selected\""; ?>>Akademija</option>
                </select>
                
                <label class="control-label" for="radNaRacunalu">Rad na računalu</label>
                <select name="radNaRacunalu" class="formSelect" id="radNaRacunalu">
                    <option value="Početnik"
                    <?php if ($korisnik->radNaRacunalu=='Početnik')echo "selected=\"selected\""; ?>>Početnik</option>
                    <option value="Znam Office"
                    <?php if ($korisnik->radNaRacunalu=='Znam Office')echo "selected=\"selected\""; ?>>Znam Office</option>
                    <option value="Dobro upoznat"
                    <?php if ($korisnik->radNaRacunalu=='Dobro upoznat')echo "selected=\"selected\""; ?>>Dobro upoznat</option>
                    <option value="Stručnjak" 
					<?php if ($korisnik->radNaRacunalu=='Stručnjak')echo "selected=\"selected\""; ?>>Stručnjak</option>
                </select>
                
                <label class="control-label" for="vozackaDozvola">Vozačka dozvola</label>
                <select name="vozackaDozvola" class="formSelect" id="vozackaDozvola">
                    <option value="Da" 
					<?php if ($korisnik->vozackaDozvola=='Da')echo "selected=\"selected\""; ?>>Da</option>
                    <option value="Ne" 
					<?php if ($korisnik->vozackaDozvola=='Ne')echo "selected=\"selected\""; ?>>Ne</option>
                </select>
                
                
                <label class="control-label" for="hobiji">Hobiji</label>
                <textarea class="formTextarea wysiwyg" name="hobiji" 
                id="hobiji"><?php echo trim ($korisnik->hobiji); ?></textarea>
                
                <label class="control-label" for="tecajevi">Tečajevi</label>
                <textarea class="formTextarea wysiwyg" name="tecajevi" 
                id="tecajevi"><?php echo trim ($korisnik->tecajevi); ?></textarea>
                
                <label class="control-label" for="volonterskiRad">Volonterski rad</label>
                <textarea class="formTextarea wysiwyg" name="volonterskiRad" 
                id="volonterskiRad"><?php echo trim ($korisnik->volonterskiRad); ?></textarea>
                
                <label class="control-label" for="podrucjeInteresa">Područje interesa</label>
                <textarea class="formTextarea wysiwyg" name="podrucjeInteresa" 
                id="podrucjeInteresa"> <?php echo trim ($korisnik->podrucjeInteresa); ?></textarea>
                
                <label class="control-label" for="nagradePriznanja">Nagrade i priznanja</label>
                <textarea class="formTextarea wysiwyg" name="nagradePriznanja" 
                id="nagradePriznanja"><?php echo trim ($korisnik->nagradePriznanja); ?></textarea>
                
                <label class="control-label" for="ostaleUdruge">Ostale udruge</label>
                <textarea class="formTextarea wysiwyg" name="ostaleUdruge" 
                id="ostaleUdruge"><?php echo trim ($korisnik->ostaleUdruge); ?></textarea>
                
                <div>
                <hr>
                <input type="submit" name="submit" id="submitButton" value="Spremi" class="btn btn-core btn-large submit"/>
                <img class="loadingGif" style="display:none" src="images/loading.gif" />
                </div>                                                
                </form>
                </div>             
       
        </div> <!-- End #tab5 -->               
        
    </div>