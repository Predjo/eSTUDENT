<?php 
$baza = new Estudent;
$rezultat = $baza->dohvatiOgranke();
if (!$rezultat->uspjeh){echo $rezultat->poruka;}
$options=array(
'id' => 'ogranciTablica',
'class' => 'coreTablica table table-striped table-bordered',
'headers' => 'Naziv,Kratica,Opcije',
'showColumns' => 'naziv,kratica',
'deleteBtn' => 'id',
'editBtn' => 'id',
'numField' => 'id'
);
$tablica=createTable2($rezultat->podatci,$options);

?>

<div class="content-box"><!-- Start Content Box -->
    
    <div class="content-box-header">
        
        <h3>Ogranci</h3>
        
 
        <div class="clear"></div>
        
    </div> <!-- End .content-box-header -->
    
    <div class="content-box-content">
        
        <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
		<?php echo $tablica; ?>
        
            
        </div> <!-- End #tab1 -->
                
        
    </div></div> <!-- End .content-box-content -->

<div class="clear"></div>