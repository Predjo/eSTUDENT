// JavaScript Document
var $items;
//login.php
$(document).ready(function()
{	

//************************ STARTUP *********************************************	

	$('#arc').center();
	$('.wheelelement').tooltip();



//************************ RESIZE WINDOW ***************************************	

	$(window).bind('resize', function() {
	
		$('#arc').center();
	
	});

//************************ LOGOUT *********************************************	

$("#logout_button").click(function(){
	type=$(this).data('type');	
	logout(type);	
	});

});//document