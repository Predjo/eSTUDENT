// JavaScript Document
var $items;
$(document).ready(function(){

//*********************** STARTUP **************************************++ 
idKorisnik_prima = $('#IDKorisnik_prima').val();
osvjeziZid(idKorisnik_prima);


/*$('a[rel*=facebox]').facebox(); //facebox popup
$('#cancelButton').live('click',function(){
jQuery(document).trigger('close.facebox');	
	});	
*/
	
$('#bodyWrapper').fadeIn(1000);	
	
//************************** TABOVI NA PROFILIMA ****************************************************	
	
	$('.tab-content').hide(); // Hide the content divs
	$('.default-tab').addClass('active'); // Add the class "current" to the default tab
	$('.default-tab').show(); // Show the div with class "default-tab"
	
	$('#mainNavigation li a').click( // When a tab is clicked...
		function() { 
			$(this).parent().siblings().removeClass('active'); // Remove "current" class from all tabs
			$(this).parent().addClass('active'); // Add class "current" to clicked tab
			var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
			$(currentTab).siblings().hide(); // Hide all content divs
			$(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
			return false; 
		}
	);	
	

//********************************* POVRATAK NA JEZGRU ***************************	

	$('#coreStatusBarLeft').click(function(){
		window.location="../../";
		});


//******************************** PPRUKE NA ZIDU *********************************
		
	$('#dodajPorukuNaZid').live('submit',function(){
	tekst = $('#wall_input').val();
	$('#wall_input').val('');
	tip = 'zid';
	idKorisnik_salje = $('#IDKorisnik_salje').val();
	idKorisnik_prima = $('#IDKorisnik_prima').val();
	if (tekst){	
		posaljiPoruku(tekst,tip,idKorisnik_salje,idKorisnik_prima);
	
	}
	osvjeziZid(idKorisnik_prima);
	return false;
	
	});//dodaj poruku na zid	
	
	$('.delPoruka').live('click',function(){
		idPoruka=$(this).data('idporuka');
		
		if(confirm('Obrisati poruku?')){
			$(this).parent().parent().parent().css('background-color','#FFC').hide('normal');
			obrisiPoruku(idPoruka);
			}
		return false;
		});	//obrisi poruku

//************************ LOGOUT *********************************************	
	$("#logout_button").click(function(){
		
	type=$(this).data('type');	
	logout(type);	
		
		});				
});		