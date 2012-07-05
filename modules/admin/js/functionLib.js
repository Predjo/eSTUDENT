function izbrisiKorisnika(IDkorisnk){
	
	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'izbrisiKorisnika', id: IDkorisnk },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
	
	}//function
	

function izbrisiOgranak(IDogranak){

	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'izbrisiOgranak', id: IDogranak },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});		
	}//function
	

function izbrisiTim(IDtim){
	
	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'izbrisiTim', id: IDtim },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});
}//function

function izbrisiJezik(korisnikID,jezikID){

	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'izbrisiJezik', korisnikID:korisnikID , jezikID:jezikID },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		//alert(data);
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
}//function

function izbrisiPoslodavca(korisnikID,poslodavacID){

	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'izbrisiPoslodavca', korisnikID:korisnikID , poslodavacID:poslodavacID},
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		//alert(data);
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
}//function

function dodajKorisnika(email,lozinka,ime,prezime,jmbag,ogranakID){
	
	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'dodajKorisnika', email: email, lozinka: lozinka, 
	  		ime: ime, prezime: prezime, jmbag: jmbag,ogranakID: ogranakID },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
			window.location="index.php?n=korisnici";
		}
		else alert(data);		
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
	
	}//function

function urediKorisnika(id,json){
	
	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'urediKorisnika', id:id, json:json },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
			alert('Spremljeno!');
		}
		else alert(data);	
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
	
	}//function
	
function dodajOgranak(naziv,kratica){
	
	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'dodajOgranak', naziv:naziv, kratica:kratica },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
			window.location="index.php?n=ogranci";
		}
		else alert(data);	
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
	
	}//function
	
function dodajJezik(korisnikID,jezik,stupanj){

	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'dodajJezik',korisnikID:korisnikID, jezik:jezik, stupanj:stupanj },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
			//window.location="index.php?n=urediKorisnika&id="+ korisnikID +"&tab=tab4";
			window.location.href=window.location.href+"&tab=tab4";
		}
		else alert(data);	
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
	
	}//function

function dodajPoslodavca(korisnikID,trajanje,poslodavac,pozicija,vjestine,kontaktIme,kontaktTelBroj,kontaktEmail){

	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'dodajPoslodavca',korisnikID:korisnikID, trajanje:trajanje, poslodavac:poslodavac, pozicija:pozicija, vjestine:vjestine, kontaktIme:kontaktIme, kontaktTelBroj:kontaktTelBroj, kontaktEmail:kontaktEmail },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
			//window.location="index.php?n=urediKorisnika&id="+ korisnikID +"&tab=tab4";
			window.location.href=window.location.href+"&tab=tab4";		
			}
		else alert(data);	
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
	
	}//function
			
function urediOgranak(id, naziv, kratica){
	
	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'urediOgranak',id:id, naziv:naziv, kratica:kratica },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
			alert("Spremljeno!");
		}
		else alert(data);	
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
	
	}//function	
	
function dodajTim(naziv,kratica,ogranakID,stabni,aktivan,osnovan,opis){
	
	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'dodajTim', naziv:naziv, kratica:kratica,ogranakID:ogranakID,stabni:stabni,aktivan:aktivan,osnovan:osnovan,opis:opis },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
			window.location="index.php?n=timovi";
		}
		else alert(data);
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
		
	}//function

function dodajFunkcijuKorisnika(nazivM,nazivZ){
	
	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'dodajFunkcijuKorisnika', nazivM:nazivM, nazivZ:nazivZ},
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
			window.location="index.php?n=funkcijeKorisnika";
		}
		else alert(data);
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
	
}//function

function urediTim(id,naziv,kratica,ogranakID,stabni,aktivan,osnovan,opis){
	
	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'urediTim',id:id, naziv:naziv, kratica:kratica,ogranakID:ogranakID,
	  		stabni:stabni,aktivan:aktivan,osnovan:osnovan,opis:opis },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
			alert("Spremljeno!");			
		}
		else alert(data);
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
}//function

//dodavanje korisnika u timove

function dodajKorisnikeUTim(JSONstring,timID){

	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'dodajKorisnikeUTim', id: JSONstring,timID:timID },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
			window.location = "index.php?n=urediTim&id="+timID+"&tab=tab2";;
		}
		else alert(data);
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});		
	}//function	

function makniKorisnikaIzTima(korisnikID,timID){	

	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'makniKorisnikaIzTima', korisnikID:korisnikID,timID:timID },
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
		$(".loadingGif").hide();
		if (data=="ok"){
		}
		else alert(data);
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});		
	}//function	

//funkcija za dohvacanje atributa iz URL
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function promijeniDefaultTab(){
	url = getUrlVars();
	if(url['tab']){
		$('.tab-content').hide();
		$('#'+url['tab']).show();
		$('.content-box-tabs li a').removeClass();
		$('.content-box-tabs li a[href="#' + url['tab'] + '"]').addClass('current');
		$('.nav.nav-tabs li').removeClass();
		$('.nav.nav-tabs li a[href="#' + url['tab'] + '"]').parent().addClass('active');
		}
	
	}

//sleep funkcija
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

