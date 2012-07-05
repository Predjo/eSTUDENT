// JavaScript Document

function nadjiKorisnike(parametar,searchfield){

	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'nadjiKorisnike',parametar:parametar},
	  beforeSend:function(){
		// this is where we append a loading image
	  },
	  success:function(data){
		// successful request; do something with the data
		$('#search_results ul').html(data);
		var pos = $('#userSearch').offset();
		$('#search_results').offset({ top: pos.top+26, left: pos.left });
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
	
	}//function	
	
function posaljiPoruku(tekst,tip,idKorisnik_salje,idKorisnik_prima){

	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'posaljiPoruku',tekst:tekst,tip:tip,idKorisnik_salje:idKorisnik_salje,idKorisnik_prima:idKorisnik_prima},
	  beforeSend:function(){
		// this is where we append a loading image
		$(".loadingGif").show();
	  },
	  success:function(data){
		// successful request; do something with the data
	$(".loadingGif").hide();
	  },
	  error:function(){
		  alert('Došlo je do pogreške prilikom slanja poruke!');
		// failed request; give feedback to user
	  }
	});	
}//function

function obrisiPoruku(idPoruka){

	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'obrisiPoruku',idPoruka:idPoruka},
	  beforeSend:function(){
		// this is where we append a loading image
	  },
	  success:function(data){
		// successful request; do something with the data
	
	  },
	  error:function(){
		  alert('Došlo je do pogreške prilikom brisanja poruke!');
		// failed request; give feedback to user
	  }
	});	
}//function

function osvjeziZid(idKorisnik){
	$.ajax({
	  type: 'POST',
	  url: 'php/ajax.php',
	  data: { eventType: 'osvjeziZid',idKorisnik:idKorisnik},
	  beforeSend:function(){
		// this is where we append a loading image
		
	  },
	  success:function(data){
		// successful request; do something with the data
		$('#porukeZid').html(data);
	  },
	  error:function(){
		 
		// failed request; give feedback to user
	  }
	});
	}//function	


function logout(type){
		$.post("../../modules/login/php/ajax.php",{eventType:"logout"} ,function(data)
        { 
			if (data=='ok') {
				if(type=="live"){
					var client_id = "000000004809C488",
					scope = ["wl.signin", "wl.basic", "wl.offline_access", "wl.emails"],
					redirect_uri = "http://core.estudent.hr/modules/login/php/callback.php";
					WL.init({ client_id: client_id, redirect_uri: redirect_uri, response_type: "code", scope: scope  });
					WL.logout(); //logout Livea 
				sleep(5000);
				}
				location.reload(true);

				}
		
		});	
}//function	

