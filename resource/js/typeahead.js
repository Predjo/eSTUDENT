//**************************** TYPEAHEAD ***********************************************************	
$(document).ready(function(){
	
	$('#userSearch').keyup(function(e){
		if ((e.which <= 90 && e.which >= 48) || e.which == 8)
       {
		   
        par = $(this).val();
		if (par.length>2) {
			$('#search_results').show();
			 nadjiKorisnike(par);
			}
		else {$('#search_results').hide();}
       }

		});
		
		
		$('#userSearch').keydown(function(e) {
				
			if ( e.which == 38 ||  e.which == 40 || e.which == 13){
				var numItems = $('.pretragaKorisnik.selected').length;
				
				if(numItems==0){
					    $items = $('.pretragaKorisnik');
						$items.first().addClass('selected');
					
					}
					
				else {
					var $old = $items.filter('.selected'),
						$new;
					
					switch ( e.which ) {
					case 38:
						$new = $old.prev();
						break;
					case 40:
						$new = $old.next();
						break; 
					case 13:
						 location.href = $old.find('a').attr('href');
						break;
						}
					
					
						if ( $new.is('li') ){
							$old.removeClass('selected');
							$new.addClass('selected');  
							}
					 
				}
			} 
		});
		
		$(document).mouseup(function (e)
		{
			var container = $("#search_results");
		
			if (container.has(e.target).length === 0)
			{
				container.hide();
			}
		});	
});		