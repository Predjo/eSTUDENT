// JavaScript Document
$(document).ready(function(){
$("#terminal-input").width($("#terminal-head").width());

startMsg = "eSTUDENT base console v0.1 <br> **************************** <br>";
$("#terminal-body-output").append(startMsg);

$("#terminal-input").keypress(function(event){
  if ( event.which == 13 ) {
    input = $(this).val();
	output = "lycan> "+ input + "<br>";
	$(this).val('');
	$("#terminal-body-output").append(output);
	$("#terminal-body").prop({ scrollTop: $("#terminal-body").prop("scrollHeight") });
   
   	runTerminal(input);
   
   }	
	});//#terminal-input

	
	});//document
	
function runTerminal(input){
	$.post("ajax.php", { input:input },function(data){
			$("#terminal-body-output").append(data);
			$("#terminal-body").prop({ scrollTop: $("#terminal-body").prop("scrollHeight") });
		});
	
}//function