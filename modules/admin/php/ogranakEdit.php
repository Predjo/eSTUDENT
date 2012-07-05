<?php 
if(isset($_GET['id'])){
$id=$_GET['id'];	
	}
else {
	header("Location: ../index.php?n=ogranci");
	}	

$baza = new Estudent;
$result = $baza->dohvatiOgranke($id);
$ogranak = $result->podatci;

?>


<div class="content-box"><!-- Start Content Box -->
    
    <div class="content-box-header">
        
        <h3>Uredi ogranak: <?php echo $ogranak->kratica; ?></h3>
        
 
        <div class="clear"></div>
        
    </div> <!-- End .content-box-header -->
    
    <div class="content-box-content">
        
        <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
		<div clss="formWrap">
            <form class="well" id="urediOgranak">
            <label for="nazivOgranka">Naziv Ogranka</label>
            <input id="nazivOgranka" type="text" name="nazivOgranka" placeholder="naziv ogranka"  class="formInput" required value="<?php echo $ogranak->naziv; ?>" />
            
            <label for="kraticaOgranka">Kratica Ogranka</label>
            <input id="kraticaOgranka" type="text" name="kraticaOgranka" placeholder="Kratica ogranka" class="formInput" required value="<?php echo $ogranak->kratica; ?>" />
            
            <div>
            <input type="submit" name="submit" id="submitButton" value="Spremi" class="btn btn-core btn-large"/>
            <img class="loadingGif" style="display:none" src="images/loading.gif" />
            </div>
            </form>
            </div>
        
            
        </div> <!-- End #tab1 -->
                
        
    </div></div> <!-- End .content-box-content -->

<div class="clear"></div>