$(document).ready(function() {
$().framerate({framerate: 60, logframes: false});
var num=$('.wheelelement').size();
eMenu = new eWheel(num,'#element','.wheelelement');

setTimeout("eMenu.eWheelOpen()", 1000); //otvaranje na pocetku

$("#Start").click(
 function(){
		 
	eMenu.eWheelToggle();
			
});

$(".wheelelement").mouseenter(function(){
	$(this).animate({
    
	marginTop: "-10px",
	marginLeft: "-10px",
	width: "70px",
	height: "70px"
	
  }, 200, function() {
    // Animation complete.
  });

	});
$(".wheelelement").mouseleave(function(){
	$(this).animate({
    
	marginTop: "0px",
	marginLeft: "0px",
	width: "50px",
	height: "50px"

  }, 200, function() {
    // Animation complete.
  });

	});
	

});


function eWheel (numElem,elemID,elemClass){
	
	this.num = numElem;
	this.elemID = elemID;
	this.elemClass = elemClass;
	this.openStatus = false;
	this.eWheelOpen = function(){

	$(this.elemClass).css('visibility','visible');
	
	for (x=0;x<this.num;x++){
		$(elemID+x).animate({ 
			path : new $.path.arc({
				center : [280,220],
				radius : 200,
				start : 180,
				end     : -(360/this.num*x), 
				dir : 1
			 }),opacity: 1},1000);

	}//for	
	this.openStatus = true;	
		};
	this.eWheelClose = function(){

	  for (x=0;x<this.num;x++){
	  $(elemID+x).animate({ 
		  path : new $.path.arc({
			  center : [280,220],
			  radius : 200,
			  start : -(360/this.num*x),
			  end     : 180, 
			  dir : 1
		   }),opacity:0},1000);
		   
  }//for
	this.openStatus = false;		
		};	
	
	this.eWheelToggle = function(){
		if(this.openStatus){this.eWheelClose();}
		else {this.eWheelOpen();}
		}

}//eWheeL