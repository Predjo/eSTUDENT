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
			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,  PDO::FETCH_NAMED);
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
  
	  public function dodajTim($naziv,$kratica,$IDOgranak,$aktivan,$osnovan,$stabni,$opis = NULL){

		  $sql='INSERT INTO tim (naziv,kratica,idOgranak,aktivan,osnovan,stabni,opis) VALUES (?,?,?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($naziv,$kratica,$IDOgranak,$aktivan,$osnovan,$stabni,$opis));
		  
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
		  
	  public function dohvatiTimove($IDOgranak = NULL){

		  if (!is_null($IDOgranak)){
				  if ($this->postoji('ogranak',$IDOgranak)){
					  $sql='SELECT * FROM tim WHERE idOgranak = ?';
					  $query = $this->pdo->prepare($sql);
					  $query->execute(array($IDOgranak));
				  }//if
				  else {
					  $this->lastError = "Ne postoji ogranak sa tim ID-em!";
					  return false;
				  }//else
			  }//if
		  else{
			  $sql='SELECT * FROM tim';
			  $query = $this->pdo->prepare($sql);
		  	  $query->execute(array());	
			  }//else
		  		  
		 $result = $query->fetchAll();
		 if ($result) return $result;
		 else return false; 
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
		  
	  public function dohvatiDogadaje(){

		  }//function	

	  public function dodajTerminZaPristupni($IDOgranak,$datum,$vrijeme,$prostorija,$brojPristupnika,$brojPricuvih){
		  
		  $sql='INSERT INTO terminzapristupni (idOgranak,datum,vrijeme,prostorija,brojPristupnika,brojPricuvih) VALUES (?,?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDOgranak,$datum,$vrijeme,$prostorija,$brojPristupnika,$brojPricuvih));
		  
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
		
	  public function dodajOgranak($naziv,$kratica){

		  $sql='INSERT INTO ogranak (naziv,kratica) VALUES (?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($naziv,$kratica));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom dodavanja funkcije ogranka, Error: ".$query->errorInfo(); 
			  return false;
			  }//else	
			  	  	
		}//function

	  public function urediOgranak($IDOgranak,$stupci,$vrijednosti){
		  if($this->postoji('ogranak',$IDOgranak)){
			 
			 $sql = napraviUpdateSql('ogranak',$stupci);
			 
			 if(!is_array($vrijednosti)){
			 	$vrijednosti = explode(',',$vrijednosti);
				}//if
			
			array_push($vrijednosti,$IDOgranak);
			 
			 $query = $this->pdo->prepare($sql);
		 	 $query->execute($vrijednosti);
			 
			 if ($query->rowCount()>0) return true;
			 else {$this->lastError = "Došlo je do pogreške prilikom uređivanja ogranka, Error: ".$query->errorInfo(); 
				  return false;}
 
			  }//else
		  else {
			  $this->lastError = "Ne postoji taj ogranak";
			  return false;
			  }//else
	  	
		}//function

	  public function izbrisiOgranak($IDOgranak){

		  $sql='DELETE FROM ogranak WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDOgranak));
		  
		  if ($query->rowCount()>0) return true;
		  else {$this->lastError = "Došlo je do pogreške prilikom brisanja ogranka, Error: ".$query->errorInfo(); 
			  return false;
			  }//else	
			  	  	
		}//function
		
	  public function dohvatiOgranke(){

		 $sql='SELECT * FROM ogranak';
		 $query = $this->pdo->prepare($sql);
		 $query->execute(array());	
					
		 $result = $query->fetchAll();
		 if ($result) return $result;
		 else return false; 	  	
		
		}//function

	 private function postoji($table,$ID){ //provjerava dal postoji odredjeni zapis u određenoj tablici
		
		$sql='SELECT * FROM '.$table.' WHERE id = ?';
		$query = $this->pdo->prepare($sql);
		$query->execute(array($ID));
		
		$result = $query->fetch();
		if($result) return true;
		else return false;
	}


}//class

class functionReturn {
	public $function;
	public $success = false;
	public $error = false;
	public $message = false;
	public $data = false;
}//class

?>