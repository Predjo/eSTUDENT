<div id="mainNavigation">
        <h2><?php echo $korisnik->ime.' '.$korisnik->prezime.' ' ;?></h2>

        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1">Zid</a></li>
          <li><a href="#tab2">Info</a></li>
          <li><a href="#tab3">Fakultet</a></li>
          <li><a href="#tab4">CV</a></li>
          <li><a href="#tab5">Timovi</a></li>
        </ul>
</div>

<div id="middleContent"></div>

<div id="mainContent">
    <div class="default-tab tab-content" id="tab1">
         <?php include 'php/wall.php';?>
    </div>
    
    <div id="tab2" class="tab-content"> 
        <?php include 'php/info.php'; ?>
    </div>
    
    <div id="tab3" class="tab-content">
        <?php include 'php/fakultet.php';?>
    </div>
    
    <div id="tab4" class="tab-content">
        <?php include 'php/cv.php';?>
    </div>  
   
    <div id="tab5" class="tab-content">
        <?php include 'php/timovi.php';?>
        
    </div>   
                             
</div>