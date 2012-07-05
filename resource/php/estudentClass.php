<?php 
include "estudentFunctionLib.php";

class Estudent {
	
	private $dbname = 'estudent';
	private $username = 'root';
	private $password = '';
	//private $password = 'Vp3s7ud3nT';
	public $pdo;
	
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

	

	public function login($email,$lozinka){
			  
		$return = new Rezultat;
		$return->imeFunkcije = __FUNCTION__;
		
		$sql = 'SELECT * FROM korisnik WHERE email = ?';
		
		$query = $this->pdo->prepare($sql);
		$query->execute(array($email));
		
		$user = $query->fetch(PDO::FETCH_OBJ);
		
		if ($user){
				$userPassword = $user->lozinka;
				
				if (phpbb_check_hash($lozinka,$userPassword)){
					
					$return->uspjeh = true;
					$return->poruka = 'Prijava na sustav je uspješno obavljena.';
					$return->podatci = $user;
					return $return;
				}//if
				
				else {
					  $return->uspjeh = false;
					  $return->poruka = 'Login error #2: Korisnik postoji ali je lozinka neispravna!';
					  $return->SQLgreska = $query->errorInfo();
					  return $return;					
				}//else
				
		}//if
		else {
			 $return->uspjeh = false;
			 $return->poruka = 'Login error #1: Nepostoji taj korisnik!';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;		

		}//else
		}//function
		
	  public function dohvatiKorisnika($IDkorisnik){

		$return = new Rezultat;
		$return->imeFunkcije = __FUNCTION__;
		  
		  if (!is_null($IDkorisnik)){
				  if ($this->postojiID('korisnik',$IDkorisnik)){
					  $sql='SELECT korisnik.*,ogranak.naziv as ogranak_naziv,ogranak.kratica 
					  		as ogranak_kratica FROM korisnik JOIN ogranak 
							on korisnik.fakultet = ogranak.id WHERE korisnik.id = ?';
					  $query = $this->pdo->prepare($sql);
					  $query->execute(array($IDkorisnik));
				  }//if
				  else {
					  $return->uspjeh = false;
					  $return->poruka = 'Ne postoji taj korisnik!';
					  return $return;				  
						}//else
			  }//if
		  else{
			 $return->uspjeh = false;
			 $return->poruka = 'Funkcija zahtjeva valjani ID korisnika!';
			 return $return;
			  }//else
		  		  
		 $result = $query->fetchObject();
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnici uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;			 
			 }//if
		 else{
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dohvačanja korisnika.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else		 
		 		  }//function

	  public function nadjiKorisnike($parametar){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		 $sql="SELECT korisnik.*,ogranak.naziv as ogranak_naziv,ogranak.kratica as ogranak_kratica 
			  	FROM korisnik JOIN ogranak on korisnik.fakultet = ogranak.id 
				WHERE CONCAT(upper(korisnik.ime),' ',upper(korisnik.prezime)) LIKE upper(?) ORDER BY korisnik.ime
				LIMIT 6";

		  $parametar = '%'.$parametar.'%';		
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($parametar));
		  
	  
		 $result = $query->fetchAll(PDO::FETCH_CLASS, "Korisnik");
		 
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnici uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;			  
			 }//if
		
		 else {
			 $return->uspjeh = false;
			 $return->poruka = 'Nema takvih korisnika.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else
		  
		  }//function		  		  
		  
		  				  
	  public function dohvatiKorisnike($IDogranak=NULL){
		  
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  if(isset($IDogranak)){
			  $sql='SELECT korisnik.*,ogranak.naziv as ogranak_naziv,ogranak.kratica as ogranak_kratica 
			  	FROM korisnik JOIN ogranak on korisnik.fakultet = ogranak.id WHERE ogranak.id=?';
			  }
		   else {
			  $sql='SELECT korisnik.*,ogranak.naziv as ogranak_naziv,ogranak.kratica as ogranak_kratica 
			  	FROM korisnik JOIN ogranak on korisnik.fakultet = ogranak.id';			   
			   }
		  

		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDogranak));	
		  		  
		 $result = $query->fetchAll(PDO::FETCH_CLASS, "Korisnik");
		 
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnici uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;			  
			 }//if
		
		 else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dohvačanja korisnika.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else
		  
		  }//function
	
	  public function dohvatiKorisnikeIzTima($IDtim=NULL,$godina=NULL){
		  
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  if (!is_null($IDtim) && !is_null($godina)){
				  if ($this->postojiID('tim',$IDtim)){
					  $sql="SELECT DISTINCT `korisnik`.*,
					  		funkcijakorisnika.nazivM AS funkcijaM,
							funkcijakorisnika.nazivZ AS funkcijaZ,
							korisnik_tim.godina as godinaUTimu,
							ogranak.naziv as ogranak_naziv,
					  		ogranak.kratica as ogranak_kratica, 
    							(SELECT group_concat(tim.kratica  separator ',')  
								 FROM korisnik_tim 
								 JOIN tim ON korisnik_tim.idTim=tim.id 
								 WHERE korisnik_tim.idKorisnik=korisnik.id
								 GROUP BY 'all') as timovi_korisnika
							FROM tim 
							JOIN korisnik_tim 
							ON tim.id=korisnik_tim.idTim 
							JOIN korisnik 
							ON korisnik_tim.idKorisnik=korisnik.id 
							JOIN ogranak ON korisnik.fakultet= ogranak.id
							JOIN funkcijakorisnika 
							ON funkcijakorisnika.id = korisnik_tim.idFunkcija
							WHERE tim.id=? AND korisnik_tim.godina=?
							ORDER BY ogranak.kratica,korisnik.prezime";
					  
					  $query = $this->pdo->prepare($sql);
					  $query->execute(array($IDtim,$godina));
				  }//if
				  else {
					  $return->uspjeh = false;
					  $return->poruka = 'Ne postoji taj tim!';
					  return $return;				  
						}//else
			  }//if
		  		else if (!is_null($IDtim) && is_null($godina)){
				  if ($this->postojiID('tim',$IDtim)){
					  $sql="SELECT DISTINCT `korisnik`.*,
					  		korisnik_tim.godina as godinaUTimu,
					  		funkcijakorisnika.nazivM AS funkcijaM,
							funkcijakorisnika.nazivZ AS funkcijaZ,
							ogranak.naziv as ogranak_naziv,
					  		ogranak.kratica as ogranak_kratica,
    							(SELECT group_concat(tim.kratica  separator ',')  
								 FROM korisnik_tim 
								 JOIN tim ON korisnik_tim.idTim=tim.id 
								 WHERE korisnik_tim.idKorisnik=korisnik.id
								 GROUP BY 'all') as timovi_korisnika
							FROM tim 
							JOIN korisnik_tim 
							ON tim.id=korisnik_tim.idTim 
							JOIN korisnik 
							ON korisnik_tim.idKorisnik=korisnik.id 
							JOIN ogranak ON korisnik.fakultet= ogranak.id
							JOIN funkcijakorisnika 
							ON funkcijakorisnika.id = korisnik_tim.idFunkcija
							WHERE tim.id=?
							ORDER BY ogranak.kratica,korisnik.prezime";
					  
					  $query = $this->pdo->prepare($sql);
					  $query->execute(array($IDtim));
				  }//if
				  else {
					  $return->uspjeh = false;
					  $return->poruka = 'Ne postoji taj tim!';
					  return $return;				  
						}//else
			  }//if
		  else{
				$sql="SELECT DISTINCT `korisnik`.* ,korisnik_tim.godina as godinaUTimu,
					  		funkcijakorisnika.nazivM AS funkcijaM,
							funkcijakorisnika.nazivZ AS funkcijaZ,
							ogranak.naziv as ogranak_naziv,
					  		ogranak.kratica as ogranak_kratica,
						  (SELECT group_concat(tim.kratica  separator ',')  
						   FROM korisnik_tim 
						   JOIN tim ON korisnik_tim.idTim=tim.id 
						   WHERE korisnik_tim.idKorisnik=korisnik.id
						   GROUP BY 'all') as timovi_korisnika
					  FROM tim 
					  JOIN korisnik_tim 
					  ON tim.id=korisnik_tim.idTim 
					  JOIN korisnik 
					  ON korisnik_tim.idKorisnik=korisnik.id 
					  JOIN ogranak ON korisnik.fakultet= ogranak.id
					  JOIN funkcijakorisnika 
					  ON funkcijakorisnika.id = korisnik_tim.idFunkcija
					  ORDER BY ogranak.kratica,korisnik.prezime";
					  
					  $query = $this->pdo->prepare($sql);
					  $query->execute();
			  }//else
		  		  
		 $result = $query->fetchAll(PDO::FETCH_CLASS,'Korisnik_tim');
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnici uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;			 
			 }//if
		 else{
			 $return->uspjeh = false;
			 $return->poruka = 'Nijedan korisnik nije bio u tom timu te godine.';
			 $return->podatci = NULL;
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else	
					  
		  }//function
		  
	  public function dohvatiKorisnikeKojiNisuUTimu($IDtim,$godina){
		  
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
				  if ($this->postojiID('tim',$IDtim)){
					  $sql="SELECT korisnik.*,ogranak.naziv as ogranak_naziv,
					  ogranak.kratica as ogranak_kratica 
			  		  FROM korisnik JOIN ogranak on korisnik.fakultet = ogranak.id where korisnik.id NOT IN 
					  (SELECT idKorisnik from korisnik_tim WHERE idTim=? AND godina=?) 
					  ORDER BY ogranak.kratica,korisnik.prezime";
					  
		 			  $query = $this->pdo->prepare($sql);
					  $query->execute(array($IDtim,$godina));
				  }//if
				  else {
					  $return->uspjeh = false;
					  $return->poruka = 'Ne postoji taj tim!';
					  return $return;				  
					}//else	
		  
		 $result = $query->fetchAll(PDO::FETCH_CLASS,'Korisnik_tim');
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnici uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;			 
			 }//if
		 else{
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dohvačanja korisnika.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else	
					  
		  }//function							  	  
		  
	  public function dodajKorisnika($korisnik){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='INSERT INTO korisnik (email,lozinka,ime,prezime,jmbag,fakultet) VALUES (?,?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($korisnik->email,$korisnik->lozinka,$korisnik->ime,$korisnik->prezime,$korisnik->jmbag,$korisnik->fakultet));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnik uspješno dodan.';
			 return $return;				
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja korisnika.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else
		  
		  }//function	 	  
			
	  public function izbrisiKorisnika($IDkorisnik){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='DELETE FROM korisnik WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDkorisnik));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnik uspješno izbrisan.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom brisanja korisnika.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else
		  }//function

	  public function urediKorisnika($IDKorisnik,$stupci,$vrijednosti){
		  

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  		  
		  if($this->postojiID('korisnik',$IDKorisnik)){
			 
			 $sql = napraviUpdateSql('korisnik',$stupci);
			 
			 if(!is_array($vrijednosti)){
			 	$vrijednosti = explode(',',$vrijednosti);
				}//if
			
			array_push($vrijednosti,$IDKorisnik);
			 
			 $query = $this->pdo->prepare($sql);
		 	 $query->execute($vrijednosti);
			 
			 if ($query->rowCount()>0) {
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnik uspješno ažuriran.';	
			 return $return;			 
				 	 
				 }//if
			 else {
				 $return->uspjeh = false;
			 	 $return->poruka = 'Nije ništa izmjenjeno!';
			 	 $return->SQLgreska = $query->errorInfo();
				 return $return;
					}//else
 
			  }//else
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Ne postoji korisnik sa tim ID-em.';
			 return $return;
			  }//else		  
		  }//function

  
	  public function tdodajTim($naziv,$kratica,$IDOgranak,$aktivan,$osnovan,$stabni,$opis = NULL){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='INSERT INTO tim (naziv,kratica,idOgranak,aktivan,osnovan,stabni,opis) VALUES (?,?,?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($naziv,$kratica,$IDOgranak,$aktivan,$osnovan,$stabni,$opis));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Tim uspješno dodan.';
			 return $return;				
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja tima.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else
		  
		  }//function
		  
	  public function dodajTim($tim){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='INSERT INTO tim (naziv,kratica,idOgranak,aktivan,osnovan,stabni,opis) VALUES (?,?,?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($tim->naziv,$tim->kratica,$tim->idOgranak,$tim->aktivan,$tim->osnovan,$tim->stabni,$tim->opis));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Tim uspješno dodan.';
			 return $return;				
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja tima.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else
		  
		  }//function	

	  public function izbrisiTim($IDtim){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='DELETE FROM tim WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDtim));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Tim uspješno izbrisan.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom brisanja tima.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else
			  			  			
		  }//function	

	  public function urediTim($IDTim,$stupci,$vrijednosti){
		  

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  		  
		  if($this->postojiID('tim',$IDTim)){
			 
			 $sql = napraviUpdateSql('tim',$stupci);
			 
			 if(!is_array($vrijednosti)){
			 	$vrijednosti = explode(',',$vrijednosti);
				}//if
			
			array_push($vrijednosti,$IDTim);
			 
			 $query = $this->pdo->prepare($sql);
		 	 $query->execute($vrijednosti);
			 
			 if ($query->rowCount()>0) {
			 $return->uspjeh = true;
			 $return->poruka = 'Tim uspješno ažuriran.';	
			 return $return;			 
				 	 
				 }//if
			 else {
				 $return->uspjeh = false;
			 	 $return->poruka = 'Nije ništa izmjenjeno!';
			 	 $return->SQLgreska = $query->errorInfo();
				 return $return;
					}//else
 
			  }//else
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Ne postoji ogranak sa tim ID-em.';
			 return $return;
			  }//else		  
		  }//function
		  
	  public function dohvatiTimove($IDOgranak = NULL){//vraca objekt klase Tim

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  if (!is_null($IDOgranak)){
				  if ($this->postojiID('ogranak',$IDOgranak)){
					  
					  $sql="SELECT tim.id AS id, tim.naziv as naziv,tim.kratica as kratica,
					        ogranak.kratica as ogranak_kratica, ogranak.naziv
							as Ogranak,tim.idOgranak as idOgranak, tim.aktivan as aktivan,
						    tim.opis as opis, tim.osnovan as osnovan,
							CASE tim.stabni
							WHEN 0 then 'Da'
							WHEN 1 then 'Ne'
							END as stabni
							FROM tim JOIN ogranak on tim.idOgranak=ogranak.id
							WHERE tim.idOgranak = ?";					  
					 
					  $query = $this->pdo->prepare($sql);
					  $query->execute(array($IDOgranak));
				  }//if
				  else {
					  $return->uspjeh = false;
					  $return->poruka = 'Ne postoji ogranak sa tim ID-em!';
					  return $return;
				  }//else
			  }//if
		  else{
			  $sql="SELECT tim.id AS id, tim.naziv as naziv,tim.kratica as kratica,
			        ogranak.kratica as ogranak_kratica, ogranak.naziv
			  		as Ogranak,tim.idOgranak as idOgranak, tim.aktivan as aktivan,
					tim.opis as opis, tim.osnovan as osnovan,
					CASE tim.stabni
					WHEN 0 then 'Da'
					WHEN 1 then 'Ne'
					END as stabni
					FROM tim JOIN ogranak on tim.idOgranak=ogranak.id";
			 
			  $query = $this->pdo->prepare($sql);
		  	  $query->execute(array());	
			  }//else
		  		  
		 $result = $query->fetchAll(PDO::FETCH_CLASS, "Tim");
		 
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Timovi uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;			  
			 }//if
		
		 else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dohvačanja tima.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else		 
	  }//function	
	  
	  public function dohvatiTim($IDtim){
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='SELECT * FROM tim WHERE id=?';	
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDtim));
		  $result=$query->fetchObject();	 
		 
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Tim je uspješno dohvaćen.';
			 $return->podatci = $result;
			 return $return;			  
			 }//if
		
		 else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dohvačanja tima.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else		  
		  
		  }  
	  
	  	public function dohvatiTimoveKorisnika($IDkorisnik){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;


			if ($this->postojiID('korisnik',$IDkorisnik)){
				
				
				$sql='SELECT tim.*,ogranak.naziv as ogranak_naziv,ogranak.kratica as ogranak_kratica,funkcijaKorisnika.nazivM as funkcijaM, funkcijaKorisnika.nazivZ as funkcijaZ, korisnik_tim.godina as godinaUTimu FROM korisnik_tim JOIN tim ON tim.id=korisnik_tim.idTim JOIN ogranak on ogranak.id=tim.idOgranak JOIN funkcijaKorisnika ON korisnik_tim.idFunkcija = funkcijaKorisnika.id WHERE idKorisnik = ? ORDER by korisnik_tim.godina,tim.naziv DESC';
				
				$query = $this->pdo->prepare($sql);
				$query->execute(array($IDkorisnik));
				$result = $query->fetchAll(PDO::FETCH_CLASS,'Tim_korisnik');
			}//if
			
			else {
				$return->uspjeh = false;
				$return->poruka = 'Ne postoji korisnik sa tim ID-em!';
				return $return;
			}//else
			
		 
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Timovi uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;			  
			 }//if
		
		 else {
			 $return->uspjeh = false;
			 $return->poruka = 'Korisnik nije član niti jednog tima.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else
		
		
		}//function
	  
	  public function dodajKorisnikaUTim($IDkorisnik,$IDtim,$godina,$IDfunkcija){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='INSERT INTO korisnik_tim (idKorisnik,idTim,godina,idFunkcija) VALUES (?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDkorisnik,$IDtim,$godina,$IDfunkcija));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnik uspješno dodan u tim.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja korisnika iz tima.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else

		  }//function
	  
	  public function makniKorisnikaIzTima($IDkorisnik,$IDtim){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='DELETE FROM korisnik_tim WHERE idKorisnik = ? AND idTim = ?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDkorisnik,$IDtim));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnik je uspješno maknut iz tima.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom micanja korisnika iz tima.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else
			  			  					  
		  }//function
  
	  public function dodajDogadaj($idTipDogadaja,$naziv,$predavac,$dvorana,$brLjudi,$datum){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
	
		  $sql='INSERT INTO dogadaj (idTipDogadaja,naziv,predavac,dvorana,brLjudi,datum) VALUES (?,?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  if ($this->postojiID('tipdogadaja',$idTipDogadaja)){
			  $query->execute(array($idTipDogadaja,$naziv,$predavac,$dvorana,$brLjudi,$datum));
			  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Događaj uspješno dodan.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja događaja.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else	
		  	}//if
			else {
			 $return->uspjeh = false;
			 $return->poruka = 'Nedozvoljen tip događaja, dodavanje neuspješno.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
				}//else
		  }//function	

	  public function izbrisiDogadaj($IDdogadaj){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='DELETE FROM dogadaj WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDdogadaj));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Događaj uspješno izbrisan.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom brisanja događaja.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else			  						
		  
		  }//function	
		  
	  public function dohvatiDogadaje($idTipDogadaja=NULL){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  if (!is_null($idTipDogadaja)){
				  if ($this->postojiID('tipdogadaja',$idTipDogadaja)){
					  $sql='SELECT * FROM dogadaj WHERE idTipDogadaja = ?';
					  $query = $this->pdo->prepare($sql);
					  $query->execute(array($idTipDogadaja));
				  }//if
				  
				  else {
					  $return->uspjeh = false;
					  $return->poruka = 'Ne postojiID događaj tog tipa!';
					  $return->SQLgreska = $query->errorInfo();
					  return $return;
				  }//else
			  }//if
		  else{
			  $sql='SELECT * FROM dogadaj';
			  $query = $this->pdo->prepare($sql);
		  	  $query->execute(array());	
			  }//else
		  		  
		 $result = $query->fetchAll();
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Događaji uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;			 
			 }//if
		 else{

			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dohvaćanja događaja.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			 			 
			 }//else

		  }//function
		  
	  public function dohvatiTipDogadaja(){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='SELECT * FROM tipdogadaja';
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array());	
		  		  
		 $result = $query->fetchAll();
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Tipovi događaja uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;		 	
			}//if	
		 
		 else{ 
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dohvaćanja tipova događaja.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;			 	 
			 }//else	  
		  
		  }//function	  
	  
	  public function dodajTipDogadaja($naziv){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='INSERT INTO tipdogadaja (naziv) VALUES (?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($naziv));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Tip događaja uspješno dodan.';	
			 return $return;				
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja termina događaja.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else		  
		  
		  }//function	
		  
	  public function izbrisiTipDogadaja($idTipDogadaja){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='DELETE FROM tipdogadaja WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($idTipDogadaja));

		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Tip događaja uspješno izbrisan.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom brisanja termina događaja.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else			  
		  }//function

	  public function dodajTerminZaPristupni($termin){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='INSERT INTO terminzapristupni (idOgranak,datum,vrijeme,prostorija,brojPristupnika,brojPricuvih) VALUES (?,?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($termin->IDOgranak,$termin->datum,$termin->vrijeme,$termin->prostorija,$termin->brojPristupnika,$termin->brojPricuvih));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Termin za pristupni uspješno dodan.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja termina za pristupni.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else		  
		  }//function
		  
	  public function tdodajTerminZaPristupni($IDOgranak,$datum,$vrijeme,$prostorija,$brojPristupnika,$brojPricuvih){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='INSERT INTO terminzapristupni (idOgranak,datum,vrijeme,prostorija,brojPristupnika,brojPricuvih) VALUES (?,?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDOgranak,$datum,$vrijeme,$prostorija,$brojPristupnika,$brojPricuvih));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Termin za pristupni uspješno dodan.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja termina za pristupni.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else		  
		  }//function		  	

	  public function izbrisiTerminZaPristupni($IDtermin){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
			  
		  $sql='DELETE FROM terminzapristupni WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDtermin));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Termin za pristupni uspješno izbrisan.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom brisanja termina za pristupni.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else		  						
		  			  				
		  }//function	

	  public function urediTerminZaPristupni(){
		  
		  }//function
  
	  public function dodajKorisnikuDogadjaj($IDkorisnik,$IDdogadaj){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='INSERT INTO korisnik_dogadaj (idDogadaj,idKorisnik) VALUES (?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDdogadaj,$IDkorisnik));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnik uspješno dodan događaj.';	
			 return $return;				
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja korisnika na događaj.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else		  
		  
		  }//function	

	  public function makniKorisnikuDogadaj($IDkorisnik,$IDdogadaj){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='DELETE FROM korisnik_dogadaj WHERE idDogadaj=? AND idKorisnik=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDdogadaj,$IDkorisnik));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Korisnik uspješno maknut sa događaja.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom micanja korisnika sa događaja.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else	
			  		  
		  }//function	

	  public function dodajKrugOcjena($naziv,$datumPocetak,$datumKraj){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
			  
		  $sql='INSERT INTO krugocjena (naziv,datumPocetak,datumKraj) VALUES (?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($naziv,$datumPocetak,$datumKraj));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Krug ocjena uspješno dodan.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja kruga ocjena.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else				  						
		  		  
		  }//function	

	  public function izbrisiKrugOcjena($IDkrugOcjena){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='DELETE FROM krugocjena WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDkrugOcjena));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Krug ocjena uspješno izbrisan.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom brisanja kruga ocjena.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else			  
			  				
		  }//function	

	  public function ocjeniKorisnika(){
		  
		  }//function	

	  public function dohvatiFunkcijeKorisnika(){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='SELECT * FROM funkcijakorisnika';
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array());	
		  		  
		 $result = $query->fetchAll(PDO::FETCH_CLASS, "FunkcijaKorisnika");
		 if ($result){
			 $return->uspjeh = true;
			 $return->poruka = 'Funkcije korisnika uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;		 	
			}//if	
		 
		 else{ 
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dohvaćanja funkcija korisnika.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;			 	 
			 }//else	  
		  
		  }//function

	  public function tdodajFunkcijuKorisnika($nazivM,$nazivZ,$flag = 0){
		  
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='INSERT INTO funkcijakorisnika (nazivM,nazivZ,flag) VALUES (?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($nazivM,$nazivZ,$flag));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Funkcija korisnika uspješno dodana.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja funkcije korisnika.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else		  
		  }//function
		  
	  public function dodajFunkcijuKorisnika($funkcija){
		  
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='INSERT INTO funkcijakorisnika (nazivM,nazivZ,flag) VALUES (?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($funkcija->nazivM,$funkcija->nazivZ,$funkcija->flag));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Funkcija korisnika uspješno dodana.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja funkcije korisnika.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else		  
		  }//function		  	

	  public function izbrisiFunkcijuKorisnika($IDfunkcija){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='DELETE FROM krugocjena WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDfunkcija));
		  		  			

		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Funkcija korisnika uspješno izbrisana.';
			 return $return;					
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom brisanja funkcije korisnika.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else			  
		}//function
		
	  public function tdodajOgranak($naziv,$kratica){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='INSERT INTO ogranak (naziv,kratica) VALUES (?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($naziv,$kratica));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Ogranak uspješno dodan.';	
			 return $return;				
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja ogranka.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else	
			  	  	
		}//function
		
	 	  public function dodajOgranak($ogranak){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='INSERT INTO ogranak (naziv,kratica) VALUES (?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($ogranak->naziv,$ogranak->kratica));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Ogranak uspješno dodan.';	
			 return $return;				
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom dodavanja ogranka.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else	
			  	  	
		}//function	

	  public function urediOgranak($IDOgranak,$stupci,$vrijednosti){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  if($this->postojiID('ogranak',$IDOgranak)){
			 
			 $sql = napraviUpdateSql('ogranak',$stupci);
			 
			 if(!is_array($vrijednosti)){
			 	$vrijednosti = explode(',',$vrijednosti);
				}//if
			
			array_push($vrijednosti,$IDOgranak);
			 
			 $query = $this->pdo->prepare($sql);
		 	 $query->execute($vrijednosti);
			 
			 if ($query->rowCount()>0) {
			 $return->uspjeh = true;
			 $return->poruka = 'Ogranak uspješno izmjenjen.';	
			 return $return;			 
				 	 
				 }//if
			 else {
				 $return->uspjeh = false;
			 	 $return->poruka = 'Nije ništa izmjenjeno!';
			 	 $return->SQLgreska = $query->errorInfo();
				 return $return;
					}//else
 
			  }//else
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Ne postoji ogranak sa tim ID-em.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else
	  	
		}//function

	  public function izbrisiOgranak($IDOgranak){
		  
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='DELETE FROM ogranak WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDOgranak));
		  
		 if ($query->rowCount()>0) {
			 $return->uspjeh = true;
			 $return->poruka = 'Ogranci uspješno obrisani.';
			 return $return;
			 }//if
		 	
		 else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom brisanja ogranka.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			 
			 }//else; 			  	  	
		}//function
		
	  public function dohvatiOgranke($IDogranak = NULL){ //vraca objekt klase Ogranak
			
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		 
		 if(isset($IDogranak)){
		 $sql='SELECT * FROM ogranak WHERE id=?';
		 $query = $this->pdo->prepare($sql);
		 $query->execute(array($IDogranak));	
					
		 $result = $query->fetchObject();;			 
			 
			  }//if
		 else { 
		 
			 $sql='SELECT * FROM ogranak';
			 $query = $this->pdo->prepare($sql);
			 $query->execute(array());	
						
			 $result = $query->fetchAll(PDO::FETCH_CLASS, "Ogranak");
		 
		 }//else
		 
		 if ($result) {
			 $return->uspjeh = true;
			 $return->poruka = 'Ogranci uspješno dohvaćeni.';
			 $return->podatci = $result;
			 return $return;
			 }//if
		 	
		 else {
			 $return->uspjeh = false;
			 $return->poruka = 'Dogodila se greška prilikom dohvaćanja ogranaka.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			 
			 }//else; 	  	
		
		}//function

	  public function dohvatiPoruke($tip,$idKorisnik_prima){ //vraca objekt klase Poruka
			
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		 
		 $sql='SELECT poruka.*,korisnik.ime,korisnik.prezime,korisnik.profilePic FROM poruka JOIN korisnik ON korisnik.id=poruka.idKorisnik_salje WHERE idKorisnik_prima=? and tip=? ORDER by vrijeme DESC LIMIT 20';
		 $query = $this->pdo->prepare($sql);
		 $query->execute(array($idKorisnik_prima,$tip));
		 if ($tip == 'zid'){
			  $result = $query->fetchAll(PDO::FETCH_CLASS, "Poruka_zid");
			 }	
		 else {	 
	     	$result = $query->fetchAll(PDO::FETCH_CLASS, "Poruka");
		 }
		 
		 if ($result) {
			 $return->uspjeh = true;
			 $return->poruka = 'Poruke uspješno dohvaćene.';
			 $return->podatci = $result;
			 return $return;
			 }//if
		 	
		 else {
			 $return->uspjeh = false;
			 $return->poruka = 'Nema poruka :(';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			 
			 }//else; 	  	
		
		}//function

	 	  public function dodajPoruku($poruka){

		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;
		  
		  $sql='INSERT INTO poruka (id,tip,tekst,idKorisnik_prima,idKorisnik_salje) VALUES (?,?,?,?,?)';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($poruka->id,$poruka->tip,$poruka->tekst,$poruka->idKorisnik_prima,$poruka->idKorisnik_salje));
		  
		  if ($query->rowCount()>0)
		  	{
			 $return->uspjeh = true;
			 $return->poruka = 'Poruka uspješno poslana.';	
			 return $return;				
				}//if 
		  else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom slanja poruke.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			  }//else	
			  	  	
		}//function	

	  public function izbrisiPoruku($IDPoruka){
		  
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;

		  $sql='DELETE FROM poruka WHERE id=?';
		  
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDPoruka));
		  
		 if ($query->rowCount()>0) {
			 $return->uspjeh = true;
			 $return->poruka = 'Poruka uspješno obrisana.';
			 return $return;
			 }//if
		 	
		 else {
			 $return->uspjeh = false;
			 $return->poruka = 'Došlo je do pogreške prilikom brisanja poruke.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			 
			 }//else; 			  	  	
		}//function
		
	 public function korisnikImaDozvolu($IDKorisnik,$nizDozvola){
		  
		  $return = new Rezultat;
		  $return->imeFunkcije = __FUNCTION__;		 
		 
		 $sql = 'SELECT * FROM korisnik_dozvola JOIN dozvola on korisnik_dozvola.idDozvola = dozvola.id where idKorisnik = ?';
		  $query = $this->pdo->prepare($sql);
		  $query->execute(array($IDKorisnik));
		  $result = $query->fetchAll(PDO::FETCH_CLASS, "Dozvola");	
		  
		  $imaDozvolu = false;
		  
		  foreach ($result as $dozvola){
			  if (in_array($dozvola->naziv,$nizDozvola)){
				  $imaDozvolu = true;
				  break;
				  }
			  
			  }	 
		 
		 if ($imaDozvolu) {
			 $return->uspjeh = true;
			 $return->podatci = true;
			 $return->poruka = 'Korisnik ima dozvolu za pristup.';
			 return $return;
			 }//if
		 	
		 else {
			 $return->uspjeh = false;
			 $return->podatci = false;
			 $return->poruka = 'Korisnk nema dozvolu za pristup.';
			 $return->SQLgreska = $query->errorInfo();
			 return $return;
			 
			 }//else; 			 
		 }
		
	 protected function postojiID($table,$ID){ //provjerava dal postojiID odredjeni zapis u određenoj tablici
		
		$sql='SELECT * FROM '.$table.' WHERE id = ?';
		$query = $this->pdo->prepare($sql);
		$query->execute(array($ID));
		
		$result = $query->fetch();
		if($result) return true;
		else return false;
	}
	
	public function test(){
		 
		 $return = new Rezultat;
		 $return->imeFunkcije = __FUNCTION__;
		 $return->uspjeh = true;		
 		 $return->poruka = generirajEmail('Marijan Antuntun Ivan','Karadžić Ivaniščevoćko');
		 return $return;
		}


}//class


class Rezultat {
	public $imeFunkcije;
	public $uspjeh = false;
	public $poruka;
	public $SQLgreska;
	public $podatci;
}//class

class Trenutni_korisnik
{
	
	public $id;
	public $name;
	public $fullname;
	public $valid = false;
	public $lastActivityTime;
	public $loginTime;
	private $baza;
	public $loginType;
	
	public function logLastActivityTime(){
		$this->lastActivityTime = time(); 
		}//function	
	
	public function logIn($id,$loginType,$ime=NULL,$prezime=NULL){
		  //session_start();
		  $this->valid = true;
		  $this->id = $id;
		  $this->name = $ime;
		  $this->fullname = $ime.' '.$prezime;
		  $this->loginTime = time();
		  $this->logLastActivityTime();	
		  $this->loginType = $loginType;	
		}//function
	
	public function logOut(){
		//session_start();
		$_SESSION['user']->valid = false;
		unset($this);
		session_destroy();
		}//function
		
	public function generirajCoreKrug(){}
	
	public function dohvatiPodatkeKorisnika( $id= NULL){
		$baza = new Estudent;
		
		if (!isset($id)) $result = $baza->dohvatiKorisnika($this->id);
		else $result = $baza->dohvatiKorisnika($id);
		
		return $result;
		}
		
}//class

class Forum {

	private $dbname = 'forum';
	private $username = 'root';
	private $password = 'Vp3s7ud3nT';
	protected $pdo;
	
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
	
	  public function login($username,$password){
			
	  $return = new Rezultat;
	  $return->imeFunkcije = __FUNCTION__;
	  
	  //mod logina ovisi o tome da li je uneseno korisnicko ime ili email
	  if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
		 $sql = 'SELECT * FROM phpbb_users WHERE user_email = ?'; 
		 $mod = 'email';
		  
		  }
		else {
		 $sql = 'SELECT * FROM phpbb_users WHERE username = ?'; 
		 $mod = 'username';	
			}
	  
	  
	  
	  $query = $this->pdo->prepare($sql);
	  $query->execute(array($username));
	  
	  $user = $query->fetch(PDO::FETCH_OBJ);
	  
	  if ($user){
			  $userPassword = $user->user_password;
			  
			  if (phpbb_check_hash($password,$userPassword)){
				  
				   //korisnik ima racun na forumu, sada se provjerava dal ima racun u bazi i iako ima vrati podatke
				  $povezi=$this->poveziKorisnikaForumaSaBazom($user->user_email);
				  if($povezi){
					  $return->uspjeh = true;
					  $return->poruka = 'Prijava na sustav je uspješno obavljena.';		  
					  $return->podatci = $povezi;
					  return $return;
				  }
				  else{
					$return->uspjeh = false;
					$return->poruka = 'Login error #3: Korisnik ima račun na forumu ali ne postoje njegovi podatci u bazi!';
					return $return;						  
					  }
			  }//if
			  
			  else {
					$return->uspjeh = false;
					$return->poruka = 'Login error #2: Korisnik postoji ali je lozinka neispravna!';
					$return->SQLgreska = $query->errorInfo();
					return $return;					
			  }//else
			  
	  }//if
	  else {
		   $return->uspjeh = false;
		   $return->poruka = 'Login error #1: Nepostoji taj korisnik!';
		   $return->SQLgreska = $query->errorInfo();
		   return $return;		
	  
	  }//else
	  

	  }//function
	  
	  	  private function poveziKorisnikaForumaSaBazom($email){
			  $baza = new Estudent;
			  $sql = 'SELECT * FROM korisnik WHERE email = ?';
			  $query = $baza->pdo->prepare($sql);
			  $query->execute(array($email));
		  
			  $user = $query->fetchObject();
			  if ($user){
				  return $user;
				  }
			  else return false;
		  
		  }//function
}//class

class LiveLogin{
	public function login($email){
		$return = new Rezultat;
		$return->imeFunkcije = __FUNCTION__;
		
		$baza = new Estudent;
		$sql = 'SELECT * FROM korisnik WHERE email = ?';
		$query = $baza->pdo->prepare($sql);
		$query->execute(array($email));
	
		$user = $query->fetch(PDO::FETCH_OBJ);
		
		 if($user){
			  $return->uspjeh = true;
			  $return->poruka = 'Prijava na sustav je uspješno obavljena.';		  
			  $return->podatci = $user;
			  return $return;
		  }
		  else{
			$return->uspjeh = false;
			$return->poruka = 'Login error #4: Korisnik ima račun na Liveu ali ne postoje njegovi podaci u bazi!';
			return $return;						  
			  }
		
		}
	}//class
	
class FunkcijaKorisnika{
	public $id;
	public $nazivM;
	public $nazivZ;
	public $flag;
	}	

class Tim{
	public $id;
	public $naziv;
	public $kratica;
	public $stabni;
	public $opis;
	public $idOgranak;
	public $aktivan;
	public $osnovan;
	}

class Ogranak{
	public $id;
	public $naziv;
	public $kratica;
	}

class Korisnik{
	public $id;
	public $email;
	public $lozinka;
	public $prosaoPristupni;
	public $ime;
	public $prezime;
	public $JMBAG;
	public $spol;
	public $privatniEmail;
	public $datumRodenja;
	public $telBroj;
	public $ulica;
	public $grad;
	public $pbr;
	public $fakultet;
	public $godinaFakulteta;
	public $godinaUpisa;
	public $smjer;
	public $prosjek;
	public $glazbenaSkola;
	public $radNaRacunalu;
	public $vozackaDozvola;
	public $hobiji;
	public $tecajevi;
	public $volonterskiRad;
	public $podrucjeInteresa;
	public $nagradePriznanja;
	public $ostaleUdruge;
	public $jezik;
	public $poslodavac;
	public $datumIspunjavanjaPristupnog;
	public $prvoUclan;
	public $tipClana;
	public $godinaPrvogClanstva;
	public $certifikat;
	public $ogranak_naziv;
	public $ogranak_kratica;
	public $profilePic;
	
	}

class Korisnik_tim extends Korisnik{
	public $funkcijaM;
	public $funkcijaZ;
	public $godinaUTimu;
	
	}
class Tim_korisnik extends Tim{
	public $funkcijaM;
	public $funkcijaZ;
	public $godinaUTimu;
	public $ogranak_naziv;
	public $ogranak_kratica;
	
	}	
	
class TerminZaPristupni{
	public $id; 
	public $idOgranak; 
	public $datum; 
	public $vrijeme; 
	public $prostorija; 
	public $brojPristupnika; 
	public $brojPricuvnih;
	}	
	
class Poruka{
	public $id; 
	public $tip; 
	public $tekst; 
	public $idKorisnik_prima; 
	public $idKorisnik_salje; 
	public $vrijeme;
	}
	
class Poruka_zid extends Poruka{
	public $ime;
	public $prezime;
	public $profilePic;
	
	}		

class Dozvola{
	public $naziv;
	public $opis;
	}
?>