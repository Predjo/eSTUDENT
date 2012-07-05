<?php $id=$_GET['id'];
$godina='2012'; 
include "../../../resource/php/estudentClass.php"; 
$baza = new Estudent;
$result = $baza->dohvatiKorisnikeIzTima($id,$godina);
$timljani = $result->podatci;
$result2 = $baza->dohvatiKorisnikeKojiNisuUTimu($id,$godina);
$netimljani = $result2->podatci;
$result3 = $baza->dohvatiFunkcijeKorisnika();
$funkcije = $result3->podatci;

$desno="<ol>";
if (isset($timljani)){
	foreach($timljani as $timljan){
		$desno.="<li data-new=\"0\" class=\"timljanin\">{$timljan->prezime} {$timljan->ime} ({$timljan->ogranak_kratica}) : {$timljan->funkcijaM}</li>";
		}
}
$desno.="</ol>";	

$lijevo="<ol>";
if (isset($netimljani)){
	foreach($netimljani as $netimljan){
		$lijevo.="<li data-id=\"{$netimljan->id}\" class=\"netimljanin\"> 
		<a target=\"_blank\" href=\"index.php?n=urediKorisnika&id={$netimljan->id}\">
		{$netimljan->prezime} {$netimljan->ime} ({$netimljan->ogranak_kratica}) 
		</a>
		</li>";
		}
}
$lijevo.="</ol>";
 ?>
 
<script type="text/javascript" src="js/filter.js"></script>

<div clss="formWrap">
    <div id="eLogoKuT"></div>
    <form class="well" id="dodajUTim">
        <input type="hidden" value="<?php echo $id; ?>" id="timID"/>
        
        <div id="filterDiv">
        	
            <div class="floatLeft">
                <label for="filterTimljani">Pretraživanje</label> 
                <input type="text" name="filterTimljani" id="filterTimljani" autocomplete="off"/>
            </div>
            
            <div class="floatRight">
                <label for="funkcijaTimljani">Funkcija</label> 
                <select name="funkcijaTimljani" id="funkcijaTimljani">
                     <?php 
                        foreach($funkcije as $funkcija){
                            echo "<option value=\"{$funkcija->id}\">{$funkcija->nazivM}</option>";	
                        }
                    ?></select>
            
            </div>
        </div>
        <div id="dodajUTimDD">
            <div id="popisLijevo" class="popisi">
            <h3>Korisnici</h3>
            <div id="popisLijevoInner">
				<?php echo $lijevo; ?>
            </div>
            </div>
            <div id="popisDesno" class="popisi">
            <h3>Korisnici u timu</h3>
            <div id="popisDesnoInner">
				<?php echo $desno; ?></div>
            </div>
        </div>
        
        <div style="clear:both;">
            <hr>
            <input type="submit" name="submit" id="submitButton" value="Spremi" class="btn btn-core btn-large"/>
            <input type="button" name="cancel" id="cancelButton" value="Odustani" class="btn btn-large"/>
            <img class="loadingGif" style="display:none" src="images/loading.gif" />
        </div>
    </form>
</div>
