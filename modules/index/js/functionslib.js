// JavaScript Document

function loginStartupProcedure(){
$("#login").center(); 
$("#login").css('opacity',0.0).animate({ opacity: 1.0  },'slow');
}
	

//jQuery center() function

jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
    this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
    return this;
}

// javascript sleep function
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

// JavaScript Document

function logout(type){
		$.post("modules/login/php/ajax.php",{eventType:"logout"} ,function(data)
        { 
			if (data=='ok') {
				if(type=="live"){
					var client_id = "000000004809C488",
					scope = ["wl.signin", "wl.basic", "wl.offline_access", "wl.emails"],
					redirect_uri = "http://core.estudent.hr/modules/login/php/callback.php";
					WL.init({ client_id: client_id, redirect_uri: redirect_uri, response_type: "code", scope: scope  });
					WL.logout(); //logout Livea 
					sleep(5000);
				}//if
				location.reload(true);

				}
		
		});	
}//function

function nadjiKorisnike(parametar,searchfield){

	$.ajax({
	  type: 'POST',
	  url: 'modules/index/php/ajax.php',
	  data: { eventType: 'nadjiKorisnike',parametar:parametar},
	  beforeSend:function(){
		// this is where we append a loading image
	  },
	  success:function(data){
		// successful request; do something with the data
	$('#search_results ul').html(data);
	  },
	  error:function(){
		// failed request; give feedback to user
	  }
	});	
	
	}//function	
	