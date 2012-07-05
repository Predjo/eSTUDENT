<?php 
//echo getcwd();
$eventType=$_POST['eventType'];
include "../../../resource/php/estudentClass.php";
session_start();

$baza = new Estudent;

switch ($eventType){

	case "login": 
		//$forum = new Forum;
		$forum = new Estudent;
		$username=$_POST['username'];
		$password=$_POST['password'];
		$stayLogIn=$_POST['checkKeepLogedIn'];
		$stayLogIn = ($stayLogIn=="yes") ? "yes" : "no";
		$result = $forum->login($username,$password);
		
		if ($result->uspjeh) {
			    	$_SESSION['user'] = new Trenutni_korisnik;
					$_SESSION['user']->login($result->podatci->id,"forum",$result->podatci->ime,$result->podatci->prezime);		
			echo "ok"; 
			}
		else echo $result->poruka;
		break;
		
	case "loginViaLive":
		$live = new LiveLogin;
		$username=$_POST['username'];
		$result = $live->login($username);
		
		if ($result->uspjeh) {
			    	$_SESSION['user'] = new Trenutni_korisnik;
					$_SESSION['user']->login($result->podatci->id,"live",$result->podatci->ime,$result->podatci->prezime);		
			echo "ok"; 
			}
		else echo $result->poruka;			
		break; 
	
	case "logout":
		$_SESSION['user']->logOut();
		echo "ok";
		break;


}
//switch

?>