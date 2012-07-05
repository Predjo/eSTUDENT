<?php
require "../../resource/php/estudentClass.php";
session_start();

if(!isset($_SESSION['user']) && !($_SESSION['user'] instanceof TrenutniKorisnik))
  {
     	header('Location: ../../login.php');
	
 }
 
include 'php/dohvatiKorisnika.php';

$dozvole = array('admin');
$result = $baza->korisnikImaDozvolu($_SESSION['user']->id,$dozvole);
$ima_dozvolu = $result->podatci;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eProfil <?php echo $korisnik->ime.' '.$korisnik->prezime.' ' ;?></title>

<link href="../../resource/library/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../resource/library/jQuery_UI/css/blitzer/jquery-ui-1.8.20.custom.css"/>
<link rel="stylesheet" type="text/css" href="../../resource/library/Facebox/facebox.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script type="text/javascript" src="../../resource/js/jquery-1.7.2.min.js" ></script>
<script type="text/javascript" src="../../resource/library/Facebox/facebox.js"></script>
<script type="text/javascript" src="../../resource/library/DataTables-1.9.0/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../../resource/library/DataTables-1.9.0/paging.js"></script>
<script type="text/javascript" src="../../resource/library/jQuery_UI/js/jquery-ui-1.8.20.custom.min.js"></script>
<script type="text/javascript" src="../../resource/js/typeahead.js" ></script>
<script type="text/javascript" src="js/functionLib.js" ></script>
<script type="text/javascript" src="js/eventScript.js" ></script>

<script type="text/javascript" src="../admin/js/functionLib.js" ></script>
<script type="text/javascript" src="../admin/js/eventScript.js" ></script>

<script type="text/javascript" src="../../resource/library/imageHost/js/imagehost.js" ></script>

</head>


<body>
<?php include "../../resource/library/statusBar.php"; ?>
    <div id="bodyWrapper"> <!-- Wrapper for the radial gradient background -->
		<div id="sidebarWrap">            
            <div id="profile_pic">
            	<?php include "php/profilePic.php";?>
            </div>
            <hr />
            <?php include "php/kontrole.php";?>
        </div>
        <div id="mainContetWrap">
        	
        	<?php 
			if (isset($_GET['edit']) && $myprofile){
			 include "php/korisnikEdit.php";
			}
			else {
			 include "php/profile.php";	
			}
			?>
        </div>
    
    </div>
    <div id="footer">Copyright 2012 Predjo</div>
</body>
</html>