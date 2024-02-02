<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 10000);
include "resize.php";
function resizeThumbnailImage($thb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	imagealphablending($newImage, false);
 	imagesavealpha($newImage,true);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
		case "image/png":
			$source=imagecreatefrompng($image); 
			break;
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$thb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thb_image_name,90); 
			break;
		case "image/png":
		imagepng($newImage,$thb_image_name);  
		break;
		case "image/x-png":
			imagepng($newImage,$thb_image_name);  
			break;
    }
	chmod($thb_image_name, 0777);
	return $thb_image_name;
}



if($_GET['action']=="single")
{
	
	$filename  = basename($_FILES['images']['name']);
	
	$tmp = explode('.', $filename);
	$extension = end($tmp);
	
	//$extension=end(explode(".", $filename));
	$imagefilename=uniqid().".".$extension;
	
	move_uploaded_file( $_FILES["images"]["tmp_name"], "tempimage/" . $imagefilename);
	
	$simpimage = new SimpleImage();
	$simpimage->load("tempimage/".$imagefilename);
	if($simpimage->getWidth() > 900)
	{
		 $simpimage->resizeToWidth(900);
	 	 $simpimage->save("tempimage/".$imagefilename);
		 $simpimage = new SimpleImage();
		 $simpimage->load("tempimage/".$imagefilename);
		 if($simpimage->getHeight() >700)
		 {
			$simpimage->resizeToHeight(700);
	 	 	$simpimage->save("tempimage/".$imagefilename);
		 }
		 
	}
	copy("tempimage/".$imagefilename,"tempimage/crop/".$imagefilename);
	echo $imagefilename;
	die;
}	
if($_GET['action']=="multiple")
{
	
	$filename  = basename($_FILES['mulimages']['name']);
	
	$tmp = explode('.', $filename);
	$extension = end($tmp);
	$imagefilename=uniqid().".".$extension;
	
	move_uploaded_file($_FILES["mulimages"]["tmp_name"], "tempimage/".$imagefilename);
	$simpimage = new SimpleImage();
	$simpimage->load("tempimage/".$imagefilename);
	if($simpimage->getWidth() > 900)
	{
		 $simpimage->resizeToWidth(900);
	 	 $simpimage->save("tempimage/".$imagefilename);
		 $simpimage = new SimpleImage();
		 $simpimage->load("tempimage/".$imagefilename);
		 if($simpimage->getHeight() >700)
		 {
			$simpimage->resizeToHeight(700);
	 	 	$simpimage->save("tempimage/".$imagefilename);
		 }
	}
	
	copy("tempimage/".$imagefilename,"tempimage/crop/".$imagefilename);
	echo $imagefilename;
	die;
}

if($_GET['action']=="crop")
{
	
	$upload_directory = "tempimage"; 			
	$upload_directory_path = $upload_directory."/";
	$l_img_prefix =  	'';		
	$thb_image_prefix = "";	
	$l_img_name = $l_img_prefix.$_GET['imagename']; 
	$thb_image_name = $thb_image_prefix.$_GET['imagename'];    
	$thb_width = "156";						
	$thb_height = "156";						
	$l_img_location = $upload_directory_path.$l_img_name;
	$thb_img_location = $upload_directory_path.'/crop/'.$thb_image_name;
		
	$x = (int)$_GET['x'];
	$y = (int)$_GET['y'];
	$w = (int)$_GET['w'];
	$h = (int)$_GET['h'];
	$imagefilename = $_GET['imagename'];
	if($w)
	{
			
		$scale = $thb_width/$w;
		$cropped = resizeThumbnailImage($thb_img_location, $l_img_location,$w,$h,$x,$y,$scale);
			/*
			$targ_w = $targ_h = 150;
			$jpeg_quality = 90;
			$src = "tempimage/$imagefilename";
			$img_r = imagecreatefromjpeg($src);
			$dst_r = imagecreatetruecolor( $targ_w, $targ_h );
			imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$w,$h);
 			imagejpeg($dst_r,$src,$jpeg_quality);
			echo "ok";
			*/
	}
	else
	{
		echo "not crop";
	}	
	die;
}



