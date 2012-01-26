// JavaScript Document
startMsg = "eSTUDENT base console v0.2 by Predjo <br> ****************************************** <br>";
var inputSaved = new Array();
var inputSavedPos = 0;
var commands = ['clear','exit'];

$(document).ready(function(){
$("#terminal-input").width($("#terminal-head").width()-20);

$("#terminal-body-output").append(startMsg);


$("#terminal-input").keypress(function(event){
  if ( event.keyCode == 13 ) {
    input = $(this).val();
	output = "lycan> "+ input + "<br>";
	$(this).val('');
	$("#terminal-body-output").append(output);
	$("#terminal-body").prop({ scrollTop: $("#terminal-body").prop("scrollHeight") });
   
   	runTerminal(input);
	saveInput(input);
   
   }//if
  
  else if(event.keyCode == 38 || event.keyCode == 40) {	
  	if (inputSaved) {
		direction = event.keyCode - 39;
		if (inputSavedPos+direction>-1 && inputSavedPos+direction<inputSaved.length){
			inputSavedPos = inputSavedPos + direction;
			$(this).val(inputSaved[inputSavedPos]);
			}
	
	}
  }//else

});//#terminal-input

	
	});//document
	
function runTerminal(input){
	if (!commands.inArray(input)){
		$.post("ajax.php", { input:input },function(data){
				$("#terminal-body-output").append(data);
				$("#terminal-body").prop({ scrollTop: $("#terminal-body").prop("scrollHeight") });
			});
	}//if
	else runCommand(input);
	
}//function

function saveInput(input){
	if (input && inputSaved[inputSaved.length-1]!=input){
	inputSavedPos = inputSaved.push(input);
	}
}//function

function runCommand(command){
	switch(command){
		case 'clear':
			$("#terminal-body-output").html('');
			$("#terminal-body-output").append(startMsg);
			break;

		case 'exit':
			$("#terminal-wrap").hide('fast');
			break;
					
		}//switch
	}//function

Array.prototype.inArray = function (value)
{
 var i;
 for (i=0; i < this.length; i++) {

 if (this[i] == value) {
 return true;
 }//if
 }//for
 return false;
 };