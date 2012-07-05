// JavaScript Document

$(document).ready(function() {


	$('#uploadPicForm').live('submit',function() {	
	 $(".loadingGif").show();

	});
	
	 $(".profilePicPic").mouseover(function(){
		 $('.profilePicButton').show('fast');
		 
		 });
		 $("#profile_pic").mouseleave(function(){
		 $('.profilePicButton').hide('fast');
		 
		 });
	


});
	
	function stopUpload(success,name,destination,filesize,filetype,error){
      var result = '';
	  if (error != 0) { success = 0;}
	 //alert(error);
	
      if (success == 1){
		 location.reload(true);
		
      	  
	  }
	  
      else {
		  
		alert("Došlo je do pogreške!");
      }
	    
     
      return true;   
}

