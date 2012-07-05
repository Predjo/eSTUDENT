<?php 
require_once "../../resource/php/estudentClass.php";
$input=$_POST['input'];
$input = explode(' ',$input,2);
$class_methods = get_class_methods('Estudent');
$command = $input[0];
$specialCommands = array("","list","echo","man","help");

if (!in_array($command,$class_methods) && !in_array($command,$specialCommands)){
	
	echo '<div class="redback">Ne postoji ta naredba!</div>';
	
	}//if
	
else if (in_array($command,$specialCommands)){
	
	switch($command){
		case "":
			echo '';
			break;
		case "echo":
			echo $input[1]."<br>";
			break;
			
		case "list":
			echo '<div class="greenback">Popis funkcija:</div>';
			foreach($class_methods as $method){echo $method."    "; }
			echo '<br><br>';
			break;	
		
		case "man": 
		
			if (isset($input[1]) && in_array($input[1],$class_methods)){
				$reflectionMethod = new ReflectionMethod('Estudent', $input[1]);
				$params = $reflectionMethod->getParameters();
				echo '<div class="greenback">Funkcija koristi ove argumente:</div>';
				foreach ($params as $param) {
   					echo $param->getName();
   					if  ($param->isOptional()) echo ' -opcionalno<br>';
					else echo '<br>';
				}//foreach
				echo '<br>';
			}//if
			else echo '<div class="redback">Ne postoji ta naredba!</div>';
			break;
		
		case "help":
			echo 'Naredbe se unose u obliku: "Naredba Argument1;Argument2;Argument3". <br>
					Za popis svih naredbi koristite naredbu "list".<br>
					Za opis pojedine naredbe koristite "man Naredba".<br>';
			break;
		
		
		}//switch	
	}//elseif
else {
	$reflectionMethod = new ReflectionMethod('Estudent', $command);
	if (isset($input[1])){
		$arguments = explode(';',$input[1]);
		$result = $reflectionMethod->invokeArgs(new Estudent, $arguments);	
	}//if
	
	else {
		$result = $reflectionMethod->invoke(new Estudent);			
	}//else
	
/*	if ($result) {echo "Naredba je uspješno izvedena! <br>";
		if ($result!=1 && is_array($result)){
			createTable($result);
			echo "<br><br>";
			}//if
		else if ($result!=1 && !is_array($result)){
			echo $result;
			echo "<br><br>";
			}
		}//if
	else echo '<div class="redback">Dogodila se greška prilikom izvođenja naredbe! </div>';*/
	
	if ($result->uspjeh) {echo $result->poruka." <br>";
		if ($result->podatci){
			createTable($result->podatci);
			echo "<br><br>";
			}//if
	}//if
	else echo '<div class="redback">'.$result->poruka.'</div>';	
	
	}//else



?>