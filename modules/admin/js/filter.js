 //************************* DRAG & DROP CLANOVA U TIM ****************************************
 
$(document).ready(function() {
  $( "#popisLijevo li" ).draggable({
	  appendTo: "#dodajUTimDD",
	  helper: "clone"
  });
  
  $( "#popisDesno" ).droppable({
	  activeClass: "active-dodaj-u-tim",
	  hoverClass: "hover-dodaj-u-tim",
	  accept: ":not(.ui-sortable-helper)",
	  drop: function( event, ui ) {
		  $( this ).find( ".placeholder" ).remove();
		  var id = ui.draggable.data("id");
		  var funkcijaID = $("#funkcijaTimljani").val();
		  var funkcija = $("#funkcijaTimljani option:selected").text();
		  $( "<li data-new=\"1\" data-id=\"" + id + "\" data-functionID=\"" + funkcijaID + "\"></li>" ).text( ui.draggable.text()+ ' : '+ funkcija).appendTo( '#popisDesno ol' );
		  //alert("Bacio");
		  $("#popisLijevo ol").find("[data-id='" + id + "']").remove();
	  }

		}); 
		
	listFilter("#filterTimljani","#popisLijevo ol");
  					
});

	jQuery.expr[':'].Contains = function(a,i,m){
		return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0; }
		
	  function listFilter(searchBar,list) { // header is any element, list is an unordered list
    // create and add the filter form to the header

    $(searchBar)
      .keyup( function () {
        var filter = $(this).val();
        if(filter) {
		
          // this finds all links in a list that contain the input,
          // and hide the ones not containing the input while showing the ones that do
          $(list).find("a:not(:Contains(" +filter+ "))").parent().hide();
          $(list).find("a:Contains(" +filter+ ")").parent().show();
        } else {
          $(list).find("li").show();
        }
        return false;
      })
  }	