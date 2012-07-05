<?php 
include("../../php/estudentClass.php");
session_start();
include("functionslib.php");
$userID = $_POST['userID'];

?>

<?php
   $permitedfiletypes=array("image/jpg","image/jpeg","image/gif","image/png","image/pjpeg","image/x-png");
   $maxfilesize=2097152;
   $errorcode=0;
   
   $destination_path = "../../../files/userImages/".$userID."/";
   $thumbdestination_path = "../../../files/userImages/".$userID."/thumbnail/";
   
   if(!is_dir($destination_path)){
	   mkdir($destination_path);
	   mkdir($thumbdestination_path);
	   }
   
   $destination_path2 = getcwd().DIRECTORY_SEPARATOR;
   
   $result = 0;
   $filetype = $_FILES["myfile"]["type"];
   $filesize = $_FILES["myfile"]["size"];   
   $imeslike= $_FILES['myfile']['name'];
   $resizelimit = $_POST["sizeradio"];
   $quality = $_POST["qualityradio"];
   $logoposition= $_POST["logolocradio"];
   $logoname = $_POST["logoselect"];
   $imeslike=randomizePicturename($imeslike);
   
   
   // ERRORS
   //1= wrong file type
   //2= wrong file size
   
   if (!in_array($filetype,$permitedfiletypes)) { $errorcode=1; }
   else if (!getimagesize($_FILES['myfile']['tmp_name'])){$errorcode=1;}
   else if ($filesize > $maxfilesize){$errorcode=2;}
   else{
   
   
 
   if ($resizelimit=='custom'){$resizelimit=$_POST["customsize"];}
   if ($resizelimit > 1000){$resizelimit = 1000;}
   
   $target_path = $destination_path . basename( $imeslike);

   if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
      $result = 1;
   
   if ($_POST["resizecheck"]=='Yes'){
	   
	$filesize= imageResize($imeslike, $destination_path, $resizelimit,$quality);
	   
	}
	
  // if (isset($_POST["applyFilter"])){
	   
	
	   
	//}	
   
   if ($_POST["logocheck"]=='Yes'){
	   
	   addLogo($imeslike, $destination_path,$logoposition,$logoname);
   
   }

   //filter($imeslike, $destination_path, 1);   
   createThumbs($imeslike, $destination_path, $thumbdestination_path, 50, $filesize);

   
   }
   
   sleep(1);
   }
 
 
$korisnikID = $userID;
$baza = new Estudent;
$result2 = $baza->urediKorisnika($korisnikID,array('profilePic'),array($imeslike));
if($result2->uspjeh){$bazaUspjeh =1;}
else $bazaUspjeh = 0;
   
?>

<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result; echo",'".$imeslike."'"; echo",'".$destination_path."'"; echo",'".$filesize."'"; echo",'".$filetype."'"; echo",'".$errorcode."'"; ?>);</script>   
