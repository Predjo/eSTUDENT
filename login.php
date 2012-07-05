<?php
include "resource/php/estudentClass.php";
session_start();

if(isset($_SESSION['user']) && ($_SESSION['user'] instanceof TrenutniKorisnik))
  {
     	header('Location: index.php');
	
 }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eLogin</title>
<link href="resource/css/reset.css" rel="stylesheet" type="text/css" />
<link href="modules/login/css/style.css" rel="stylesheet" type="text/css" />
<link href="resource/library/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="resource/js/jquery-1.7.1.min.js"></script>
<script src="//js.live.net/v5.0/wl.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="modules/login/js/functionslib.js"></script>
<script type="text/javascript" src="modules/login/js/eventScript.js"></script>
<script type="text/javascript" src="modules/login/js/liveLogin.js"></script>
</head>

<body>
<div id="content">
<div id="login"> 
    <div id="loginLeft">
    	<!--<h2>Jezgra</h2>-->
        <div id="logo"></div>
    </div>
	<div id="loginRight">
        
        <div id="loginForm">
            <form action="" method="post" name="formLogin" id="login_form">
            
                <label for="username">email:</label>
                <input id="username" name="username" type="text" class="formInput" required/> 
                <label for="password">lozinka:</label> 
                <input id="password" name="password" type="password" class="formInput" required/>
            	<hr />
                <div class="buttondiv">
                 <input id="submit" type="submit" value="Prijavi se" class="btn-core btn-large submit" />
                 <img class="loadingGif" style="display:none;" src="resource/images/loading.gif" />
                 
                 
                </div>
            
            </form>
            <div id="signin"></div>
        </div>
    </div>    
</div>
</div>
</body>
</html>