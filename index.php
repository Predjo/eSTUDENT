<?php
require "resource\php\estudentClass.php";
session_start();

if(!isset($_SESSION['user']) && !($_SESSION['user'] instanceof TrenutniKorisnik))
  {
     	header('Location: login.php');
	
 }
 $baza = new Estudent;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eHome</title>
<link href="resource/css/reset.css" rel="stylesheet" type="text/css" />
<link href="modules/index/css/style.css" rel="stylesheet" type="text/css" />
<link href="resource/library/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="resource/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="modules/index/js/functionslib.js"></script>
<script type="text/javascript" src="modules/index/js/eventScript.js"></script>
<script type="text/javascript" src="modules/index/js/eWheel.js"></script>
<script type="text/javascript" src="modules/index/js/jquery.path.js"></script>
<script type="text/javascript" src="modules/index/js/jquery.framerate.js"></script>
<script type="text/javascript" src="resource/js/typeahead.js" ></script>
<script type="text/javascript" src="resource/js/tooltip.js" ></script>
</head>

<body>
<?php include "resource/library/statusBar.php"; ?>
<div id="content">

<?php include "modules/index/php/eWheel.php"; ?>


</div>
</body>
</html>