<?php 

class Ewheel{
	private $base;
	private $elements = array();
	private $class = 'wheelelement';
	private $elementCounter = 0;
	private $userID;
	
	function __construct($base){
		$this->base = $base;
		$this->userID = $_SESSION['user']->id;
		}
	
	function addElement($element){
		array_push($this->elements,$element);
		}//function
		
	function echoWheel(){
		echo "<div id=\"arc\">\n
			  <div id=\"Start\"> </div>\n";
		
		foreach($this->elements as $element){
			$permission = true;
			
			if(!empty($element->permissions)){
				$permission = $this->base->korisnikImaDozvolu($this->userID,$element->permissions)->podatci;
				}//if
			
			if($permission){
				$id = 'element'.$this->elementCounter;
				$element->setIdClass($id,$this->class);
				$this->elementCounter++;				
				$element->echoElement();
				}	
			}//foreach
		
		echo "</div>";
		}//function	
}//class
	
class EwheelElement{
	public $id;
	public $class;
	protected $title;
	protected $show = true;
	protected $background_image;
	protected $location;
	public $permissions = array();
	
	function __construct($title,$img,$location,$permissons = array()){
		$this->title = $title;
		$this->background_image = $img;
		$this->location = $location;
		$this->permissions = $permissons;
		}//construct
	
	
	function setIdClass($id,$class){
		$this->id = $id;
		$this->class = $class;
		}//function
	
	function echoElement(){
		$element = "<div id=\"{$this->id}\" 
						 class=\"{$this->class}\" 
						 title=\"{$this->title}\" 
						 style=\"background-image:url({$this->background_image});
						 background-size:contain;\" 
						 onclick=\"window.location='{$this->location}'\"> 
					</div>\n";
		echo $element;
		}//function	
}//class
?>


<?php
$el1 = new EwheelElement('Administrator','resource/images/icons/admin_icon.jpg','modules/admin/index.php',array('admin'));
$el2 = new EwheelElement('Moj eSTUDENT profil','resource/images/icons/SocialProfileIcon.png','modules/profile/index.php');
$el3 = new EwheelElement('eSTUDENT na facebooku','resource/images/icons/facebook.jpg','http://www.facebook.com/groups/2383384191/?ref=ts');
$el4 = new EwheelElement('eSTUDENT na youtubeu','resource/images/icons/youtube.jpg','http://www.youtube.com/channel/UCdlKM64v3FYEbOWpC9WMvhg');
$el5 = new EwheelElement('eSTUDENT forum','resource/images/icons/forum.jpg','http://forum.estudent.hr');
$el6 = new EwheelElement('eSTUDENT web','resource/images/icons/web.jpg','http://www.estudent.hr');
$el7 = new EwheelElement('eSTUDENT mail','resource/images/icons/mail.jpg','http://www.estudent.hr/owa/');

$eWheel = new Ewheel($baza);
$eWheel->addElement($el1);
$eWheel->addElement($el2);
$eWheel->addElement($el3);
$eWheel->addElement($el4);
$eWheel->addElement($el5);
$eWheel->addElement($el6);
$eWheel->addElement($el7);

$eWheel->echoWheel();
?>

