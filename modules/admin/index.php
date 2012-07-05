<?php 

include "../../resource/php/estudentClass.php";
session_start();
include "php/navigacija.php";
$baza = new Estudent;

if(!isset($_SESSION['user']) && !($_SESSION['user'] instanceof TrenutniKorisnik))
  {
     	header('Location: ../../login.php?page=admin');
	
 }
 
$potrebneDozvole = array('admin');
$imaDozvolu = $baza->korisnikImaDozvolu($_SESSION['user']->id,$potrebneDozvole)->podatci;
if (!$imaDozvolu){
	
		header('Location: ../../index.php');
	}

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eAdmin</title>
<link rel="stylesheet" type="text/css" href="css/invalid.css"/>
<link href="../../resource/library/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../resource/library/jQuery_UI/css/blitzer/jquery-ui-1.8.20.custom.css"/>
<link rel="stylesheet" type="text/css" href="../../resource/library/Facebox/facebox.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script type="text/javascript" src="../../resource/js/jquery-1.7.2.min.js" ></script>
<script type="text/javascript" src="../../resource/library/Facebox/facebox.js"></script>
<script type="text/javascript" src="../../resource/library/DataTables-1.9.0/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../../resource/library/DataTables-1.9.0/paging.js"></script>
<script type="text/javascript" src="../../resource/library/jQuery_UI/js/jquery-ui-1.8.20.custom.min.js"></script>
<script type="text/javascript" src="js/themeScript.js" ></script>
<script type="text/javascript" src="js/functionLib.js" ></script>
<script type="text/javascript" src="js/eventScript.js" ></script>
</head>
<body>
<div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

		
		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
			<h1 id="sidebar-title"><a href="#">eSTUDENT Admin</a></h1>
		  
			<!-- Logo (221px wide) -->
			<a href="index.php"><img id="logo" src="../../resource/images/e.png" alt="eSTUDENT logo" /></a>
		  
			<!-- Sidebar Profile links -->
			<div id="profile-links">
				Bok <a href="index.php?n=urediKorisnika&id=<?php echo $_SESSION['user']->id; ?>" 
                title="Edit your profile"><?php echo $_SESSION['user']->fullname;  ?></a>, 
                imaš <a href="#messages" rel="modal" title="3 Poruke">3 Poruke</a><br />

				<br />
				<a href="../../index.php" title="View the Site">Povratak na Jezgru</a> | <a href="#" title="Sign Out">Odjavi se</a>
			</div>        
			
			<ul id="main-nav">  <!-- Accordion Menu -->
				
				<li>
					<a href="index.php" class="nav-top-item no-submenu"> <!-- Add the class "no-submenu" to menu items with no sub menu -->

						Home
					</a>       
				</li>
				
				<li>
					<a href="#" class="nav-top-item">
						Korisnici
					</a>

					<ul>
						<li><a class="korisnici" href="index.php?n=korisnici">Pregled korisnika</a></li>
						<li><a href="php/korisnikForm.php" rel="facebox">Dodaj korisnika</a></li>
					</ul>
				</li>
				
				<li>
					<a href="#" class="nav-top-item">
						Ogranci
					</a>

					<ul>
						<li><a class="ogranci" href="index.php?n=ogranci">Pregled ogranaka</a></li>
						<li><a href="php/ogranakForm.php" rel="facebox">Dodaj ogranak</a></li>
					</ul>
				</li>

				
				<li>
					<a href="#" class="nav-top-item">
						Timovi
					</a>
					<ul>
						<li><a class="timovi urediTim" href="index.php?n=timovi">Pregled timova</a></li>
						<li><a href="php/timForm.php" rel="facebox">Dodaj tim</a></li>
                        <li><a class="funkcijeKorisnika" href="index.php?n=funkcijeKorisnika">Pregled funkcija korisnika</a></li>
						<li><a href="php/funkcijeKorisnikaForm.php" rel="facebox">Dodaj funkciju korisnika</a></li>
					</ul>
				</li>
				
				<li>
					<a href="#" class="nav-top-item">
						Postavke
					</a>
					<ul>
						<li><a href="#">Osnovno</a></li>
						<li><a href="#">Godina</a></li>
                        <li><a href="#">Logovi</a></li>
					</ul>
				</li>      
				
			</ul> <!-- End #main-nav -->
			
			
			
		</div></div> <!-- End #sidebar -->
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<!-- Page Head -->
			<h2>Bok <?php echo $_SESSION['user']->name;  ?></h2>
			
			<div class="clear"></div> <!-- End .clear -->
            <?php include $include;?>
			
			<div id="footer">

						 <small>Copyright 2012 Predjo</small>
			</div><!-- End #footer -->
			
		</div> <!-- End #main-content -->
		
	</div>
</body>

<script>
$(document).ready(function(){
	
	$('.content-box').show().effect('slide',{},500).find('.content-box-content').fadeIn(); //prikazuje sav content tek nakon loada	
	});
</script>