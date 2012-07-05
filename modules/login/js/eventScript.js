// JavaScript Document

//login.php
$(document).ready(function()
{	
	startupProcedure();
	
	$(window).resize(function() {$("#login").center();}); // center login screen on window resize
	
	$("#login_form").submit(function(){	
		if ($('#username').val()=="" || $('#password').val()=="" ) 
			{ alert("Upišite korisničko ime i lozinku!"); 
			  return false;
			 }
		else {	
		
			//provjerava dal je Keep log in opcija ukljucena
			if ($('#checkKeepLogedIn').attr('checked')) autolog="yes";
			else autolog="no";
			
			login($('#username').val(),$('#password').val(),autolog);
			return false;
		
		}//else
		});//login_form  


//************************ LOGOUT *********************************************	

		$("#logout_button").click(function(){
		type=$(this).data('type');	
		logout(type);
		});//logout_button

});//document