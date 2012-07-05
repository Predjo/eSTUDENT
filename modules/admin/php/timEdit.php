<?php 
if(isset($_GET['id'])){
$id=$_GET['id'];	
	}
else {
	header("Location: ../index.php?n=timovi");
	}	
$baza = new Estudent;
$result = $baza->dohvatiOgranke();
$ogranci = $result->podatci;
$result2 = $baza->dohvatiTim($id);
$tim=$result2->podatci;
$result3 = $baza->dohvatiKorisnikeIzTima($id,"2012");
$timljani = $result3->podatci;

$options=array(
	'id' => 'timljaniTablica',
	'class' => 'coreTablica table table-striped table-bordered',
	'headers' => 'Ime,Prezime,Timovi,Funkcija,Godina,Opcije',
	'showColumns' => 'ime,prezime,timovi_korisnika,funkcijaM,godinaUTimu',
	'deleteBtn' => 'id',
	'numField' => 'id'
);
$tablica=createTable2($timljani,$options);


?>

<div class="content-box"><!-- Start Content Box -->
    
    <div class="content-box-header ">
        
        <h3>Uredi tim: <?php echo $tim->kratica; ?></h3>

        <ul class="content-box-tabs">

            <li><a href="#tab1" class="default-tab">Osnovno</a></li> <!-- href must be unique and match the id of target div -->
            <li><a href="#tab2">Članovi</a></li>

        </ul>        
 
        <div class="clear"></div>
        
    </div> <!-- End .content-box-header -->
    
    <div class="content-box-content">
        
        <div class="tab-content  default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->

		<div clss="formWrap"><!-- Pocetak formulara -->
            <form class="well" id="urediTim">
            <label for="nazivTima">Naziv Tima</label>
            <input id="nazivTima" type="text" name="nazivTima" placeholder="Naziv tima"  class="formInput" required value="<?php echo $tim->naziv; ?>" />
            
            <label for="kraticaTima">Kratica Tima</label>
            <input id="kraticaTima" type="text" name="kraticaTima" placeholder="Kratica tima"  class="formInput" required value="<?php echo $tim->kratica; ?>"/>
            
            <label for="ogranakTim">Ogranak</label>
            <select id="ogranakTim" name="ogranakTim" class="formSelect">
            <?php 
            foreach($ogranci as $ogranak){
		    if($ogranak->id == $tim->idOgranak){$selected="selected=\"selected\"";}
			else {$selected="";}
            echo "<option value=\"{$ogranak->id}\" ".$selected.">{$ogranak->kratica}</option>";	
                }
            ?>
            
            </select>
            
            <label for="stabniTim">Štabni tim</label>
            <select id="stabniTim" name="stabniTim" class="formSelect">
            <option value="0" <?php if ($tim->stabni=='0')echo "selected=\"selected\""; ?>>Da</option>
            <option value="1" <?php if ($tim->stabni=='1')echo "selected=\"selected\""; ?>>Ne</option>
            </select>
            
            <label for="aktivanTim">Ativan tim</label>
            <select id="aktivanTim" name="aktivanTim" class="formSelect">
            <option value="1" <?php if ($tim->aktivan=='1')echo "selected=\"selected\""; ?>>Da</option>
            <option value="0" <?php if ($tim->aktivan=='0' || $tim->aktivan=='')echo "selected=\"selected\""; ?>>Ne</option>
            </select>
            
            <label for="osnovanTim">Osnovan tim</label>
            <input id="osnovanTim" type="text" name="osnovanTim" placeholder="12-12-2012"  class="formInput datepicker" value="<?php echo $tim->osnovan; ?>"/>
            
            <label for="opisTima">Opis Tima</label>
            <textarea name="opisTima" cols="80" rows="5" id="opisTima" class="formText wysiwyg" placeholder="Opis tima" style="margin-bottom:10px;"><?php echo $tim->opis; ?></textarea>
            
            <div>
            <input type="submit" name="submit" id="submitButton" value="Spremi" class="btn btn-core btn-large" style="margin-top:10px;"/>

            <img class="loadingGif" style="display:none" src="images/loading.gif" />
            </div>
            </form>
            </div><!-- End #formular -->
        
            
        </div> <!-- End #tab1 -->
                
       <div class="tab-content" id="tab2">  
       		<div style="margin-bottom:15px;">
            <h3>Korisnici u timu</h3>
            <a href="php/dodajUTimForm.php?id=<?php echo $id; ?>" rel="facebox">Dodaj korisnike u tim</a>
            </div>
			<?php 			
			echo $tablica;
			?>
       </div> <!-- End #tab2 -->              
        
    </div></div> <!-- End .content-box-content -->

<div class="clear"></div>