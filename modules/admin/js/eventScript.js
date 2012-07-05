$(document).ready(function()
{
//************************ POCETNE INICIJALIZACIJE ***********************

promijeniDefaultTab();	
	
//$(".wysiwyg").htmlarea('dispose'); //wysiwyg editod
$('a[rel*=facebox]').facebox(); //facebox popup
$('#cancelButton').live('click',function(){
jQuery(document).trigger('close.facebox');	
	});
	
$('.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
			}
);


//************************* TIPKE ZA BRISANJE******************************
$('#ogranciTablica .delete_btn').live('click',function(){
	id=$(this).data('delete');
	tr=$(this).parent().parent().parent();
	name=tr.find('.naziv').text();
	message="Jeste li sigurni da želite obrisati ogranak: "+name+"?";
	ok=confirm(message);
	if(ok){ izbrisiOgranak(id); tr.hide('fast');}
}); // delete ogranci btn

$('#timoviTablica .delete_btn').live('click',function(){
	id=$(this).data('delete');
	tr=$(this).parent().parent().parent();
	name=tr.find('.naziv').text();
	message="Jeste li sigurni da želite obrisati tim: "+name+"?";
	ok=confirm(message);
	if(ok){ izbrisiTim(id); tr.hide('fast');}	
}); //delete timovi btn

$('#korisniciTablica .delete_btn').live('click',function(){
	id=$(this).data('delete');
	tr=$(this).parent().parent().parent();
	name=tr.find('.ime').text()+" "+tr.find('.prezime').text();
	message="Jeste li sigurni da želite obrisati korisnika: "+name+"?";
	ok=confirm(message);
	if(ok){ izbrisiKorisnika(id); tr.hide('fast');}	
}); //delete korisnik btn

$('#timljaniTablica .delete_btn').live('click',function(){
	korisnikID = $(this).data('delete');
	timID = getUrlVars();
	timID = timID['id'];
	tr=$(this).parent().parent().parent();
	name=tr.find('.ime').text()+" "+tr.find('.prezime').text();
	message="Jeste li sigurni da želite izbaciti korisnika iz tima: "+name+"?";
	ok=confirm(message);
	if(ok){ makniKorisnikaIzTima(korisnikID,timID); tr.hide('fast');}	
}); //delete korisnik btn

$('.jeziciTable .delete_btn').live('click',function(){
	var row = $(this).parent().parent().parent().children().index($(this).parent().parent())-1;
	korisnikID = getUrlVars();
	korisnikID = korisnikID['id'];
	$(this).parent().parent().remove();
	izbrisiJezik(korisnikID,row);
	}); //delete jezik
	
$('.poslodavciTable .delete_btn').live('click',function(){
	var row = $(this).parent().parent().parent().children().index($(this).parent().parent())-1;
	korisnikID = getUrlVars();
	korisnikID = korisnikID['id'];	
	$(this).parent().parent().remove();
	izbrisiPoslodavca(korisnikID,row);
	});	//delete poslodavac

$('#funkcijeKorisnika .delete_btn').live('click',function(){
	alert("Trenutno nije moguce obrisati!");
	});	//delete poslodavac	
	
//************************* TIPKE ZA EDITIRANJE ***************************

$('#ogranciTablica .edit_btn').live('click',function(){
	id=$(this).data('edit');
	window.location="index.php?n=urediOgranak&id="+id;
});

$('#timoviTablica .edit_btn').live('click',function(){
	id=$(this).data('edit');
	window.location="index.php?n=urediTim&id="+id;
});

$('#korisniciTablica .edit_btn').live('click',function(){
	id=$(this).data('edit');
	window.location="index.php?n=urediKorisnika&id="+id;
});

$('#urediTim').submit(function(){
	naziv = $('#nazivTima').val();
	kratica = $('#kraticaTima').val();
	ogranakID = $('#ogranakTim').val();
	stabni = $('#stabniTim').val();
	aktivan = $('#aktivanTim').val();
	osnovan = $('#osnovanTim').val();
	opis = $('#opisTima').val();
	id = getUrlVars();
	id = id['id'];
	urediTim(id,naziv,kratica,ogranakID,stabni,aktivan,osnovan,opis);
	return false;	
	});//uredi tim

$('#urediOgranak').submit(function(){
	naziv = $('#nazivOgranka').val();
	kratica = $('#kraticaOgranka').val();
	id = getUrlVars();
	id = id['id'];	
	urediOgranak(id,naziv,kratica);
	return false;
	});//uredi ogranak
	
$('#urediKorisnika1').submit(function(){
	ime = $('#imeKorisnika').val();
	prezime = $('#prezimeKorisnika').val();
	jmbag = $('#jmbagKorisnika').val();
	privatniEmail = $('#email2').val();
	datumRodjenja = $('#datumRodjenja').val();
	spol = $('[name="spol"]:checked').val();
	telBroj = $('#telBroj').val();
	grad = $('#grad').val();
	ulica = $('#ulica').val();
	pbr = $('#pbr').val();
	
	vrijednosti = new Array(ime,prezime,jmbag,privatniEmail,spol,telBroj,datumRodjenja,grad,ulica,pbr);	
	stupci = new Array('ime','prezime','JMBAG','privatniEmail','spol','telBroj','datumRodenja','grad','ulica','pbr');
	
	//quick fix remove later
	if ($('#emailKorisnika')){
		email = $('#emailKorisnika').val()+'@estudent.hr';
		vrijednosti.unshift(email);
		stupci.unshift('email');
		
	}
	
	var myJSON = JSON.stringify({vrijednosti : vrijednosti, stupci : stupci});
	id = getUrlVars();
	id = id['id'];		
	urediKorisnika(id,myJSON);
	return false;
	});//uredi korisnika Osnovno	
	
$('#urediKorisnika2').submit(function(){
	lozinka = $('#lozinkaKorisnika').val();
	lozinka2 = $('#lozinkaKorisnika2').val();
	
	if (lozinka==lozinka2){

		vrijednosti = new Array(lozinka);	
		stupci = new Array('lozinka');
		var myJSON = JSON.stringify({vrijednosti : vrijednosti, stupci : stupci});
		id = getUrlVars();
		id = id['id'];		
		urediKorisnika(id,myJSON);
	
	}
	
	else {alert("Lozinke nisu jednake!");}
	return false;
	});//uredi korisnika Lozinka
	
$('#urediKorisnika3').submit(function(){
	ogranakKorisnika = $('#ogranakKorisnika').val();
	godinaFakulteta = $('#godina').val();
	godinaUpisa = $('#godinaUpisa').val();
	smjer = $('#smjer').val();
	prosjek = $('#prosjek').val();

	vrijednosti = new Array(ogranakKorisnika,godinaFakulteta,godinaUpisa,smjer,prosjek);	
	stupci = new Array('fakultet','godinaFakulteta','godinaUpisa','smjer','prosjek');
	var myJSON = JSON.stringify({vrijednosti : vrijednosti, stupci : stupci});
	id = getUrlVars();
	id = id['id'];		
	urediKorisnika(id,myJSON);
	return false;
	});//uredi korisnika Ostalo			
	
$('#urediKorisnika5').submit(function(){
	glazbenaSkola = $('#glazbenaSkola').val();
	radNaRacunalu = $('#radNaRacunalu').val();
	vozackaDozvola = $('#vozackaDozvola').val();
	hobiji = $('#hobiji').val();
	tecajevi = $('#tecajevi').val();
	volonterskiRad = $('#volonterskiRad').val();
	podrucjeInteresa = $('#podrucjeInteresa').val();
	nagradePriznanja = $('#nagradePriznanja').val();
	ostaleUdruge = $('#ostaleUdruge').val();

	vrijednosti = new Array(glazbenaSkola,radNaRacunalu ,vozackaDozvola,hobiji,tecajevi,volonterskiRad,podrucjeInteresa,nagradePriznanja,ostaleUdruge);	
	stupci = new Array('glazbenaSkola','radNaRacunalu' ,'vozackaDozvola','hobiji','tecajevi','volonterskiRad','podrucjeInteresa','nagradePriznanja','ostaleUdruge');
	var myJSON = JSON.stringify({vrijednosti : vrijednosti, stupci : stupci});
	id = getUrlVars();
	id = id['id'];		
	urediKorisnika(id,myJSON);
	return false;
	});//uredi korisnika Ostalo
	

//************************* FORMULARI ZA SPREMANJE ****************************
$('#dodajUTim').live('submit',function(){
	
	var id = new Array;
	$('#popisDesno li').each(function(index) {
	if($(this).data('new')=='1'){
	id.push($(this).data('id')+'/'+$(this).data('functionid'));}
	
	});
	var timID = $('#timID').val();
	var myJSON = JSON.stringify({id: id});
	dodajKorisnikeUTim(myJSON,timID);
	return false;
});
 
//************************* FORMULARI ZA DODAVANJE ************************

$('#dodajKorisnika').live('submit',function(){
	email = $('#emailKorisnika').val()+'@estudent.hr';
	lozinka = $('#lozinkaKorisnika').val();
	ime = $('#imeKorisnika').val();
	prezime = $('#prezimeKorisnika').val();
	jmbag = $('#jmbagKorisnika').val();
	ogranakID = $('#ogranakKorisnika').val();
	dodajKorisnika(email,lozinka,ime,prezime,jmbag,ogranakID);	
	return false;
	
	});//dodaj Korisnika 

$('#dodajOgranak').live('submit',function(){
	naziv = $('#nazivOgranka').val();
	kratica = $('#kraticaOgranka').val();
	dodajOgranak(naziv,kratica);
	return false;
	});//dodaj ogranak
	
$('#dodajJezik').live('submit',function(){
	jezik = $('#jezik').val();
	stupanjJezik = $('#stupanjJezik').val();
	id = getUrlVars();
	id = id['id'];
	dodajJezik(id,jezik,stupanjJezik);
	return false;	
	});//dodaj jezik
	
$('#dodajPoslodavca').live('submit',function(){
	var trajanje = $("#trajanjePosla option:selected").text();
	var poslodavac = $("#imePoslodavca").val();
	var pozicija = $("#nazivPozicije").val();
	var vjestine =  $("textarea#zahtjevaneVjestine").val();
	var kontaktIme =  $("#imeKontakta").val();
	var kontaktTelBroj = $("#telBrojKontakta").val();
	var kontaktEmail =  $("#emailKontakta").val();
	id = getUrlVars();
	id = id['id'];	
	dodajPoslodavca(id,trajanje,poslodavac,pozicija,vjestine,kontaktIme,kontaktTelBroj,kontaktEmail);
	return false;	
	});//dodaj poslodavca	
	
$('#dodajFunkcijuKorisnika').live('submit',function(){
	var nazivM = $("#nazivM").val();
	var nazivZ = $("#nazivZ").val();
	dodajFunkcijuKorisnika(nazivM,nazivZ);
	return false;
	});	

$('#dodajTim').live('submit',function(){
	var naziv = $('#nazivTima').val();
	var kratica = $('#kraticaTima').val();
	var ogranakID = $('#ogranakTim').val();
	var stabni = $('#stabniTim').val();
	var aktivan = $('#aktivanTim').val();
	var osnovan = $('#osnovanTim').val();
	var opis = $('#opisTima').val();
	dodajTim(naziv,kratica,ogranakID,stabni,aktivan,osnovan,opis);
	return false;	
	});//uredi tim	

//************************* TABLICE ****************************************
$.extend( $.fn.dataTableExt.oStdClasses, {

	"sWrapper": "dataTables_wrapper form-inline"
} ); 

$('#ogranciTablica').dataTable({
	"sDom": "<'row'<'span6'l><'span6 floatRight'f>r>t<'row'<'span6'i><'span6 floatRight'p>>",
	"sPaginationType": "bootstrap",
		"fnDrawCallback": function ( oSettings ) {
		/* Need to redo the counters if filtered or sorted */
		if ( oSettings.bSorted || oSettings.bFiltered )
		{
			for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
			{
				$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
			}
		}
	},
	"aoColumnDefs": [
		{ "bSortable": false, "aTargets": [ 0 ] }
	],
	
	"aoColumns": [ 
      { "sWidth": "40px" },null,null,null
    ],	
	
	"aaSorting": [[ 1, 'asc' ]],
	
	"oLanguage": {
		"sSearch": "Pretraživanje",
		"sLengthMenu": "Prikaži _MENU_",
		"oPaginate": {
		"sFirst": "Prva",
		"sLast": "Zadnja",
		"sPrevious": "Prethodna",
		"sNext": "Sljedeća"
		},
		"sEmptyTable": "Nema ništa.",
		"sInfoEmpty": "0 ogranaka.",
		"sInfo": "Ogranci _START_ do _END_ od ukupno _TOTAL_ ogranaka",
		"sInfoFiltered": " - filtrirani iz _MAX_ ogranaka",
		"sZeroRecords": "Nema ogranaka koji zadovoljavaju dani kriterij."
		} 
	});
	
	
	
	$('#timoviTablica').dataTable({
	"sDom": "<'row'<'span6'l><'span6 floatRight'f>r>t<'row'<'span6'i><'span6 floatRight'p>>",
	"sPaginationType": "bootstrap",
		"fnDrawCallback": function ( oSettings ) {
		/* Need to redo the counters if filtered or sorted */
		if ( oSettings.bSorted || oSettings.bFiltered )
		{
			for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
			{
				$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
			}
		}
	},
	"aoColumnDefs": [
		{ "bSortable": false, "aTargets": [ 0 ] }
	],
	"aaSorting": [[ 1, 'asc' ]],
	
	"aoColumns": [ 
      { "sWidth": "40px" },null,null,null,null,null
    ],
	
	"oLanguage": {
		"sSearch": "Pretraživanje",
		"sLengthMenu": "Prikaži _MENU_",
		"oPaginate": {
		"sFirst": "Prva",
		"sLast": "Zadnja",
		"sPrevious": "Prethodna",
		"sNext": "Sljedeća"
		},
		"sEmptyTable": "Nema ništa.",
		"sInfoEmpty": "0 timova.",
		"sInfo": "Timovi _START_ do _END_ od ukupno _TOTAL_ timova",
		"sInfoFiltered": " - filtrirani iz _MAX_ timova",
		"sZeroRecords": "Nema timova koji zadovoljavaju dani kriterij."
		} 
	});


$('#korisniciTablica').dataTable({
	"sDom": "<'row'<'span6'l><'span6 floatRight'f>r>t<'row'<'span6'i><'span6 floatRight'p>>",
	"sPaginationType": "bootstrap",
		"fnDrawCallback": function ( oSettings ) {
		/* Need to redo the counters if filtered or sorted */
		if ( oSettings.bSorted || oSettings.bFiltered )
		{
			for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
			{
				$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
			}
		}
	},
	"aoColumnDefs": [
		{ "bSortable": false, "aTargets": [ 0 ] }
	],
	
	"aoColumns": [ 
      { "sWidth": "40px" },null,null,null,null,null
    ],
	
	"aaSorting": [[ 1, 'asc' ]],
	
	"oLanguage": {
		"sSearch": "Pretraživanje",
		"sLengthMenu": "Prikaži _MENU_",
		"oPaginate": {
		"sFirst": "Prva",
		"sLast": "Zadnja",
		"sPrevious": "Prethodna",
		"sNext": "Sljedeća"
		},
		"sEmptyTable": "Nema ništa.",
		"sInfoEmpty": "0 korisnika.",
		"sInfo": "Korisnici _START_ do _END_ od ukupno _TOTAL_ korisnika",
		"sInfoFiltered": " - filtrirani iz _MAX_ korisnika",
		"sZeroRecords": "Nema korisnika koji zadovoljavaju dani kriterij."
		} 
	});


$('#timljaniTablica').dataTable({
	"sDom": "<'row'<'span6'l><'span6 floatRight'f>r>t<'row'<'span6'i><'span6 floatRight'p>>",
	"sPaginationType": "bootstrap",
		"fnDrawCallback": function ( oSettings ) {
		/* Need to redo the counters if filtered or sorted */
		if ( oSettings.bSorted || oSettings.bFiltered )
		{
			for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
			{
				$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
			}
		}
	},
	"aoColumnDefs": [
		{ "bSortable": false, "aTargets": [ 0 ] }
	],
	"aaSorting": [[ 1, 'asc' ]],
	
	"oLanguage": {
		"sSearch": "Pretraživanje",
		"sLengthMenu": "Prikaži _MENU_",
		"oPaginate": {
		"sFirst": "Prva",
		"sLast": "Zadnja",
		"sPrevious": "Prethodna",
		"sNext": "Sljedeća"
		},
		"sEmptyTable": "Nema ništa.",
		"sInfoEmpty": "0 timljana.",
		"sInfo": "Timljani _START_ do _END_ od ukupno _TOTAL_ timljana",
		"sInfoFiltered": " - filtrirani iz _MAX_ timljani",
		"sZeroRecords": "Nema timljana koji zadovoljavaju dani kriterij."
		} 
	});	

});//document 