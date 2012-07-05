// JavaScript Document
function login(user,pass,autoLog){
	$("#msgbox").show();
	
	$.post("modules/login/php/ajax.php",{ username:user,password:pass,checkKeepLogedIn:autoLog,eventType:"login"} ,function(data)
        { 	
			$("#msgbox").hide();
			if (data=='ok') {
				document.location='index.php';
				}
			else { alert(data);}
		
		});

	} //function
	
function loginViaLive(user){
	
	$.post("modules/login/php/ajax.php",{ username:user,eventType:"loginViaLive"} ,function(data)
        { 	
			if (data=='ok') {
				document.location='index.php';
				}
			else { alert(data);}
	
	});
	}//function
	

function logout(type){
		$.post("php/ajax.php",{eventType:"logout"} ,function(data)
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

				}//if
		
		});	
}//function

function startupProcedure(){
$("#login").center(); 
$("#login").fadeIn('normal');;
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
