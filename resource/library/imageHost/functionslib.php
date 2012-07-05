<?php 

function createThumbs($imagename, $pathToImages, $pathToThumbs, $thumbSize ,$filesize){

$info = pathinfo($pathToImages . $imagename);
$imgextension = strtolower($info['extension']);


if (($imgextension == 'jpg')||($imgextension == 'jpeg')){ $img = imagecreatefromjpeg( "{$pathToImages}{$imagename}" );}

else if ($imgextension == 'png') {  $img = imagecreatefrompng( "{$pathToImages}{$imagename}" );  }

else if ($imgextension == 'gif') {  $img = imagecreatefromgif( "{$pathToImages}{$imagename}" );  }

// odredi omjer slike

$width = imagesx( $img );
$height = imagesy( $img );
$filesizeKB = round($filesize * .0009765625, 0);
$filesizeMB = round(($filesize * .0009765625) * .0009765625, 0);


if (($thumbSize > $height)&&($thumbSize > $widt)){ 

$new_width = $width;
$new_height = $height;



$blackoffset = floor(($thumbSize-$new_height)/2);
$blackoffset2 = floor(($thumbSize-$new_width)/2);


$tmp_img = imagecreatetruecolor( $thumbSize, $thumbSize);

imageantialias($tmp_img, true);

imagecopyresampled( $tmp_img, $img,$blackoffset2, $blackoffset, 0, 0, $new_width, $new_height, $width, $height );


}


else if($width > $height){                      


$new_width = $thumbSize;
$new_height = floor( $height * ( $thumbSize / $width ) );



$blackoffset = floor(($thumbSize-$new_height)/2);



$tmp_img = imagecreatetruecolor( $new_width, $new_width);

imageantialias($tmp_img, true);

imagecopyresampled( $tmp_img, $img, 0, $blackoffset, 0, 0, $new_width, $new_height, $width, $height );


}


else {

$new_width = $thumbSize;
$new_height = floor( $height * ($thumbSize  / $width ) );



$blackoffset = floor(($thumbSize-$new_width)/2);



$tmp_img = imagecreatetruecolor( $thumbSize, $thumbSize);

imageantialias($tmp_img, true);

imagecopyresampled( $tmp_img, $img,0, 0, 0, 0, $new_width, $new_height, $width, $height );	
	
	
}


/*//crna linija za text

$black_bar = imagecreatetruecolor( $thumbSize, 20);

imagecopyresampled( $tmp_img,$black_bar,0,$thumbSize-20, 0, 0, $new_width, $new_height, $width, $height );	

//text na thumbu

$imageproperties=$width.'x'.$height.' '.$filesizeKB.'kb';

$imagepropertiesoffset= floor(($thumbSize-8*strlen($imageproperties))/2);

$text_color = imagecolorallocate($tmp_img, 255, 255, 255);

imagestring($tmp_img, 4, $imagepropertiesoffset, 132,  $imageproperties, $text_color);*/


//spremi sliku


imagejpeg( $tmp_img, "{$pathToThumbs}{$imagename}",100 );

imagedestroy($tmp_img);

}


function imageResize($imagename, $pathToImages, $resizelimit,$quality){
	
$info = pathinfo($pathToImages . $imagename);
$imgextension = strtolower($info['extension']);	

if (($imgextension == 'jpg')||($imgextension == 'jpeg')){ $img = imagecreatefromjpeg( "{$pathToImages}{$imagename}" );}

else if ($imgextension == 'png') {  $img = imagecreatefrompng( "{$pathToImages}{$imagename}" );  }

else if ($imgextension == 'gif') {$img = imagecreatefromgif( "{$pathToImages}{$imagename}" );}

$width = imagesx( $img );
$height = imagesy( $img );

if ( $resizelimit <= 1 ){

$new_width = $width*$resizelimit;
$new_height = $height*$resizelimit;

}
else if (( $resizelimit > 1 )&&($width > $height)) {

$new_width = $resizelimit;
$new_height = floor( $height * ( $resizelimit / $width ) );

}

else if (( $resizelimit > 1 )&&($width < $height)){

$new_width = floor( $width * ( $resizelimit / $height ) );
$new_height = $resizelimit;

}

switch ($quality){
	
	case 100: {$qualitypng=0; break;}
	
	case 75: {$qualitypng=3; break;}
	
	case 50: {$qualitypng=6;  break;}
	
		
}




$tmp_img = imagecreatetruecolor( $new_width, $new_height);

imagecopyresampled( $tmp_img, $img,0, 0, 0, 0, $new_width, $new_height, $width, $height );	

if (($imgextension == 'jpg')||($imgextension == 'jpeg')){$img = imagejpeg( $tmp_img, "{$pathToImages}{$imagename}",$quality );}

else if ($imgextension == 'png') {  imagepng( $tmp_img, "{$pathToImages}{$imagename}",$qualitypng );  }

else {$img = imagegif( $tmp_img, "{$pathToImages}{$imagename}",$quality ); }

$file = $pathToImages.$imagename;

$filesize = filesize($file);

imagedestroy($tmp_img);


return $filesize;

}

function genRandomString() {
    $length = 15;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = "";    


    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;
}

function randomizePicturename($name){
	
	$n=explode('.',$name);
	$newn=genRandomString().'.'.$n[count($n)-1];
	
	
	return $newn;
	
	}

function addLogo($imagename, $pathToImages, $logoposition, $logoname){

$pathtologo = "images/logo/";

$info = pathinfo($pathToImages . $imagename);
$imgextension = strtolower($info['extension']);


if (($imgextension == 'jpg')||($imgextension == 'jpeg')){ $img = imagecreatefromjpeg( "{$pathToImages}{$imagename}" );}

else if ($imgextension == 'png') {  $img = imagecreatefrompng( "{$pathToImages}{$imagename}" );  }

else if ($imgextension == 'gif') {$img = imagecreatefromgif( "{$pathToImages}{$imagename}" );}

$width = imagesx( $img );
$height = imagesy( $img );

$logo = imagecreatefrompng( "{$pathtologo}{$logoname}" );

$widthlo = imagesx( $logo );
$heightlo = imagesy( $logo );

$tmp_img = imagecreatetruecolor( $width, $height);

imagecopyresampled( $tmp_img, $img,0, 0, 0, 0, $width, $height, $width, $height );

switch ($logoposition){
	case 1:
		{imagecopy( $tmp_img, $logo,10, 10, 0, 0, $widthlo, $heightlo); break;}
	case 2:
		 {imagecopy( $tmp_img, $logo,$width-$widthlo-10, 10, 0, 0, $widthlo, $heightlo); break;}
	case 3:
		{imagecopy( $tmp_img, $logo,10, $height-$heightlo-10, 0, 0, $widthlo, $heightlo); break;}
	case 4:	
		{imagecopy( $tmp_img, $logo,$width-$widthlo-10, $height-$heightlo-10, 0, 0, $widthlo, $heightlo); break;}
}

$destimg = $pathToImages.$imagename;

if (($imgextension == 'jpg')||($imgextension == 'jpeg')){$img = imagejpeg( $tmp_img, "{$pathToImages}{$imagename}",100);}

else if ($imgextension == 'png') {  imagepng( $tmp_img,"{$pathToImages}{$imagename}",9);  }

else {$img = imagegif( $tmp_img, "{$pathToImages}{$imagename}",100 ); }

imagedestroy($tmp_img);

}


function filter($imagename, $pathToImages, $filter){
	
	$info = pathinfo($pathToImages . $imagename);
	$imgextension = strtolower($info['extension']);
	
	if (($imgextension == 'jpg')||($imgextension == 'jpeg')){ $img = imagecreatefromjpeg( "{$pathToImages}{$imagename}" );}
	
	else if ($imgextension == 'png') {  $img = imagecreatefrompng( "{$pathToImages}{$imagename}" );  }
	
	else if ($imgextension == 'gif') {  $img = imagecreatefromgif( "{$pathToImages}{$imagename}" );  }
	
	// dodaj filter
	imagefilter($img, IMG_FILTER_GRAYSCALE);	
	imagefilter($img, IMG_FILTER_CONTRAST, -30);
	imagefilter($img, IMG_FILTER_COLORIZE, 50, 40, 0);
	
	imagejpeg($img, "{$pathToImages}{$imagename}",100);
	imagedestroy($img);
	
}//filter

?>