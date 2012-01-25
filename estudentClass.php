<?php 

include "estudentFunctionLib.php";

class Estudent {
	
	private $dbname = 'estudent';
	private $username = 'root';
	private $password = '';
	private $pdo;
	
	public $lastError;
	
	function __construct(){
		try {
			$this->pdo = new PDO('mysql:dbname='.$this->dbname, $this->username, $this->password);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE);
			$this->pdo->exec('SET NAMES utf8');
		}//try 
		catch (PDOException $e) {
			header('Content-Type: text/plain');
			die('Problem s bazom: '.$e);
		}//catch
	}//function
	

	public function login($email,$password,$stayLoggedIn=NULL,$loginType=NULL){
	
		
		$sql = 'SELECT * FROM korisnik WHERE email = ?';
		
		$query = $this->pdo->prepare($sql);
		$query->execute(array($email));
		
		$user = $query->fetch(PDO::FETCH_OBJ);
		
		if ($user){
				$userPassword = $user->lozinka;
				
				if (phpbb_check_hash($password,$userPassword)){
					session_start();
    				$_SESSION['valid'] = 1;
   					$_SESSION['userid'] = $user->id;
					
					return true;
				}//if
				
				else {$this->lastError = "Login error #2: Korisnik postoji ali je lozinka neispravna!";
						return false;
				}//else
				
		}//if
		else {$this->lastError = "Login error #1: Nepostoji taj korisnik!";
				return false;
		}//else
		}//function
		
		
	  public function dodajKorisnika(){
		  
		  }//function
			
	  public function izbrisiKorisnika($IDkorisnik){
		  
		  $sql='DELETE FROM korisnik WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDkorisnik));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom brisanja korisnika, Error: ".$query->errorInfo(); 
			  return false;
			  }//else
		  }//function

	  public function urediKorisnika(){
		  
		  }//function
  
	  public function dodajTim($naziv,$kratica,$idOgranak,$aktivan,$osnovan,$stabni,$opis = NULL){

		  $sql='INSERT INTO tim (naziv,kratica,idOgranak,aktivan,osnovan,stabni,opis) VALUES (?,?,?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($naziv,$kratica,$idOgranak,$aktivan,$osnovan,$stabni,$opis));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom dodavanja funkcije korisnika, Error: ".$query->errorInfo(); 
			  return false;
			  }//else	
		  
		  }//function	

	  public function izbrisiTim($IDtim){
		  
		  $sql='DELETE FROM tim WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDtim));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom brisanja tima, Error: ".$query->errorInfo(); 
			  return false;
			  }//else
			  			  			
		  }//function	

	  public function urediTim(){
		  
		  }//function
	  
	  public function dodajKorisnikaUTim($IDkorisnik,$IDtim,$IDfunkcija){
		  
		  $sql='INSERT INTO korisnik_tim (idKorisnik,idTim,idFunkcija) VALUES (?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDkorisnik,$IDtim,$IDfunkcija));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom dodavanja korisnika u tim, Error: ".$query->errorInfo(); 
			  return false;
			  }//else

		  }//function
	  
	  public function makniKorisnikaIzTima($IDkorisnik,$IDtim){

		  $sql='DELETE FROM korisnik_tim WHERE idKorisnik = ? AND idTim = ?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDkorisnik,$IDtim));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom brisanja korisnika iz tima, Error: ".$query->errorInfo(); 
			  return false;
			  }//else
			  			  					  
		  }//function
  
	  public function dodajDogadaj(){

	
		  $sql='INSERT INTO dogadaj (idKorisnik,idTim,idFunkcija) VALUES (?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDkorisnik,$IDtim,$IDfunkcija));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom dodavanja korisnika u tim, Error: ".$query->errorInfo(); 
			  return false;
			  }//else		  
		  }//function	

	  public function izbrisiDogadaj($IDdogadaj){

		  $sql='DELETE FROM dogadaj WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDdogadaj));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom brisanja događaja, Error: ".$query->errorInfo(); 
			  return false;
			  }//else			  						
		  
		  }//function	

	  public function dodajTerminZaPristupni($IDogranak,$datum,$vrijeme,$prostorija,$brojPristupnika,$brojPricuvih){
		  
		  $sql='INSERT INTO terminzapristupni (idOgranak,datum,vrijeme,prostorija,brojPristupnika,brojPricuvih) VALUES (?,?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDogranak,$datum,$vrijeme,$prostorija,$brojPristupnika,$brojPricuvih));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom dodavanja termina, Error: ".$query->errorInfo(); 
			  return false;
			  }//else		  
		  }//function	

	  public function izbrisiTerminZaPristupni($IDtermin){
			  
		  $sql='DELETE FROM terminzapristupni WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDtermin));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom brisanja termina, Error: ".$query->errorInfo(); 
			  return false;
			  }//else			  						
		  			  				
		  }//function	

	  public function urediTerminZaPristupni(){
		  
		  }//function
  
	  public function dodajKorisnikuDogadjaj($IDkorisnik,$IDdogadaj){
		  
		  
		  }//function	

	  public function makniKorisnikuDogadaj(){
		  
		  }//function	

	  public function dodajKrugOcjena($naziv,$datumPocetak,$datumKraj){
			  
		  $sql='INSERT INTO krugocjena (naziv,datumPocetak,datumKraj) VALUES (?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($naziv,$datumPocetak,$datumKraj));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom dodavanja kruga ocjena, Error: ".$query->errorInfo(); 
			  return false;
			  }//else			  						
		  		  
		  }//function	

	  public function izbrisiKrugOcjena($IDkrugOcjena){

		  $sql='DELETE FROM krugocjena WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDkrugOcjena));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom brisanja kruga ocjena, Error: ".$query->errorInfo(); 
			  return false;
			  }//else				  
			  				
		  }//function	

	  public function ocjeniKorisnika(){
		  
		  }//function	

	  public function dodajFunkcijuKorisnika($nazivM,$nazivZ,$flag = 0){
		  
		  $sql='INSERT INTO funkcijakorisnika (nazivM,nazivZ,flag) VALUES (?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($nazivM,$nazivZ,$flag));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom dodavanja funkcije korisnika, Error: ".$query->errorInfo(); 
			  return false;
			  }//else			  
		  }//function	

	  public function izbrisiFunkcijuKorisnika($IDfunkcija){
		  
		  $sql='DELETE FROM krugocjena WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDfunkcija));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom brisanja funkcije korisnika, Error: ".$query->errorInfo(); 
			  return false;
			  }//else			  			
		  
		}//function	




}//class


?>