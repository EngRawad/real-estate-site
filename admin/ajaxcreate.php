<?
require_once("baza.php");
require_once("include/membersite_config.php");
//$_POST[upload]=true;
//$_POST[id]=114;
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
//$_POST[edit]=48;
//$_POST[dealrent]=2;
function chekdata($mydata){
		$mydata = strip_tags($mydata);
		$mydata = trim($mydata);
		$mydata = htmlspecialchars($mydata);
		$mydata = mysql_escape_string($mydata);
		$mydata = mb_substr($mydata, 0,3400, 'UTF-8');
		return $mydata;
}

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
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
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$thumb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thumb_image_name,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);  
			break; 
    }
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}
function imagerotateEquivalent($srcImg, $angle, $bgcolor = 0 , $ignore_transparent = 0) {
    function rotateX($x, $y, $theta){
        return $x * cos($theta) - $y * sin($theta);
    }
    function rotateY($x, $y, $theta){
        return $x * sin($theta) + $y * cos($theta);
    }

    $srcw = imagesx($srcImg);
    $srch = imagesy($srcImg);

    //Normalize angle
    $angle %= 360;
    //Set rotate to clockwise
    $angle = -$angle;

    if($angle == 0) {
        if ($ignore_transparent == 0) {
            imagesavealpha($srcImg, true);
        }
        return $srcImg;
    }

    // Convert the angle to radians
    $theta = deg2rad ($angle);

    //Standart case of rotate
    if ( (abs($angle) == 90) || (abs($angle) == 270) ) {
        $width = $srch;
        $height = $srcw;
        if ( ($angle == 90) || ($angle == -270) ) {
            $minX = 0;
            $maxX = $width;
            $minY = -$height+1;
            $maxY = 1;
        } else if ( ($angle == -90) || ($angle == 270) ) {
            $minX = -$width+1;
            $maxX = 1;
            $minY = 0;
            $maxY = $height;
        }
    } else if (abs($angle) === 180) {
        $width = $srcw;
        $height = $srch;
        $minX = -$width+1;
        $maxX = 1;
        $minY = -$height+1;
        $maxY = 1;
    } else {
        // Calculate the width of the destination image.
        $temp = array (rotateX(0, 0, 0-$theta),
        rotateX($srcw, 0, 0-$theta),
        rotateX(0, $srch, 0-$theta),
        rotateX($srcw, $srch, 0-$theta)
        );
        $minX = floor(min($temp));
        $maxX = ceil(max($temp));
        $width = $maxX - $minX;

        // Calculate the height of the destination image.
        $temp = array (rotateY(0, 0, 0-$theta),
        rotateY($srcw, 0, 0-$theta),
        rotateY(0, $srch, 0-$theta),
        rotateY($srcw, $srch, 0-$theta)
        );
        $minY = floor(min($temp));
        $maxY = ceil(max($temp));
        $height = $maxY - $minY;
    }

    $destimg = imagecreatetruecolor($width, $height);
        $bg2 = imagecolorallocate($destimg, 255, 0, 255);
        imagecolortransparent($destimg,$bg2);
        
/*    if ($ignore_transparent == 0) {
        imagefill($destimg, 0, 0, imagecolorallocatealpha($destimg, 255,255, 255, 127));
        imagesavealpha($destimg, true);
    }*/

    // sets all pixels in the new image
    for($x=$minX; $x<$maxX; $x++) {
        for($y=$minY; $y<$maxY; $y++) {
            // fetch corresponding pixel from the source image
            $srcX = round(rotateX($x, $y, $theta));
            $srcY = round(rotateY($x, $y, $theta));
            if($srcX >= 0 && $srcX < $srcw && $srcY >= 0 && $srcY < $srch) {
                $color = imagecolorat($srcImg, $srcX, $srcY );
            } else {
                $color = $bgcolor;
            }
            imagesetpixel($destimg, $x-$minX, $y-$minY, $color);
        }
    }
        imagecolortransparent($destimg, imagecolorallocate($destimg, 0, 0, 0));
    return $destimg;
}
function turn($turn_image, $image, $degrees){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	
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
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	
		$newImage = imagerotateEquivalent($source, $degrees, 0);
	//$newImage =$source;
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$turn_image); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$turn_image,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$turn_image);  
			break; 
    }
	chmod($turn_image, 0777);
	return $turn_image;
}

function AutoCropImage($thumb_image_name, $image, $ratio){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
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
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	if($imagewidth/$imageheight<=$ratio){
		$width=$imagewidth;
		$height=$imagewidth/$ratio;
		$xstart=0;
		$ystart=($imageheight-$height)/2;		
	}
	else {
		$width=$imageheight*$ratio;
		$height=$imageheight;
		$xstart=($imagewidth-$width)/2;
		$ystart=0;
	}
	$newImage = imagecreatetruecolor($width,$height);
	imagecopyresampled($newImage,$source,0,0,$xstart,$ystart,$width,$height,$width,$height);
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$thumb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thumb_image_name,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);  
			break; 
    }
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}
function ScaleImage($thumb_image_name, $image, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$width=$imagewidth/$scale;
	$height=$imageheight/$scale;
	$newImage = imagecreatetruecolor($width,$height);
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
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,0,0,$width,$height,$imagewidth,$imageheight);
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$thumb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thumb_image_name,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);  
			break; 
    }
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}

if ($_POST[deal]){
	$_POST[deal]=chekdata($_POST[deal]);
	if($_POST[is_special_offer])$_POST[is_special_offer] = chekdata($_POST[is_special_offer]);
	if($_POST[title_ru])$_POST[title_ru] = chekdata($_POST[title_ru]);
	if($_POST[selactive])$_POST[selactive] = chekdata($_POST[selactive]);
	if($_POST[seltypeobj])$_POST[seltypeobj] = chekdata($_POST[seltypeobj]);
	if($_POST[selcategory])$_POST[selcategory] = chekdata($_POST[selcategory]);
	if($_POST[price])$_POST[price] = chekdata($_POST[price]); 
	if($_POST[price_ot])$_POST[price_ot] = chekdata($_POST[price_ot]);
	if($_POST[selregion])$_POST[selregion] = chekdata($_POST[selregion]);
	if($_POST[selcity])$_POST[selcity] = chekdata($_POST[selcity]);
	if($_POST[latitude])$_POST[latitude] = chekdata($_POST[latitude]);
	if($_POST[longitude])$_POST[longitude] = chekdata($_POST[longitude]);
	if($_POST[address])$_POST[address] = chekdata($_POST[address]);	
	if($_POST[num_of_rooms])$_POST[num_of_rooms] = chekdata($_POST[num_of_rooms]);
	if($_POST[num_of_bathes])$_POST[num_of_bathes] = chekdata($_POST[num_of_bathes]);
	if($_POST[floor])$_POST[floor] = chekdata($_POST[floor]);
	if($_POST[floors])$_POST[floors] = chekdata($_POST[floors]);
	if($_POST[squarehouse])$_POST[squarehouse] = chekdata($_POST[squarehouse]);
	if($_POST[squarearea])$_POST[squarearea] = chekdata($_POST[squarearea]);
	if($_POST[squareterrace])$_POST[squareterrace] = chekdata($_POST[squareterrace]);
	if($_POST[squarsun])$_POST[squarsun] = chekdata($_POST[squarsun]);
	if($_POST[description_ru])$_POST[description_ru] = chekdata($_POST[description_ru]);
	if($_POST[year_built])$_POST[year_built] = chekdata($_POST[year_built]);
	if($_POST[distsea])$_POST[distsea] = chekdata($_POST[distsea]);
	if($_POST[distair])$_POST[distair] = chekdata($_POST[distair]);
	if($_POST[distcity])$_POST[distcity] = chekdata($_POST[distcity]);
	if($_POST[infrastructure])$_POST[infrastructure] = chekdata($_POST[infrastructure]);
	if($_POST[condominimum])$_POST[condominimum] = chekdata($_POST[condominimum]);
	if($_POST[distsea_unit])$_POST[distsea_unit] = chekdata($_POST[distsea_unit]);
	if($_POST[distair_unit])$_POST[distair_unit] = chekdata($_POST[distair_unit]);
	if($_POST[distcity_unit])$_POST[distcity_unit] = chekdata($_POST[distcity_unit]);
	if($_POST[condominimum_unit])$_POST[condominimum_unit] = chekdata($_POST[condominimum_unit]);
	if($_POST[infrastructure_unit])$_POST[infrastructure_unit] = chekdata($_POST[infrastructure_unit]);
	if($_POST[seo_keywords_ru])$_POST[seo_keywords_ru] = chekdata($_POST[seo_keywords_ru]);
	if($_POST[seo_description_ru])$_POST[seo_description_ru] = chekdata($_POST[seo_description_ru]);
	if($_POST[notes])$_POST[notes] = chekdata($_POST[notes]);
	
	if($_POST[May_1m])$_POST[May_1m] = chekdata($_POST[May_1m]);
	if($_POST[May_1w])$_POST[May_1w] = chekdata($_POST[May_1w]);
	if($_POST[May_2w])$_POST[May_2w] = chekdata($_POST[May_2w]);
	if($_POST[June_1m])$_POST[June_1m] = chekdata($_POST[June_1m]);
	if($_POST[June_1w])$_POST[June_1w] = chekdata($_POST[June_1w]);
	if($_POST[June_2w])$_POST[June_2w] = chekdata($_POST[June_2w]);
	if($_POST[August_1m])$_POST[August_1m] = chekdata($_POST[August_1m]);
	if($_POST[August_1w])$_POST[August_1w] = chekdata($_POST[August_1w]);
	if($_POST[August_2w])$_POST[August_2w] = chekdata($_POST[August_2w]);
	if($_POST[month_1m])$_POST[month_1m] = chekdata($_POST[month_1m]);
	if($_POST[month_1w])$_POST[month_1w] = chekdata($_POST[month_1w]);
	if($_POST[month_2w])$_POST[month_2w] = chekdata($_POST[month_2w]);
	
	
	if($_POST[hidden]){	
		$_POST[hidden]=chekdata($_POST[hidden]);
		if($_POST[uveren]){
			$_POST[uveren]=chekdata($_POST[uveren]);	
			if($_POST[check]){
				$selected_checkbox1=implode(',', $_POST[check]);
				$selected_checkbox1=chekdata($selected_checkbox1);	
			}
  			else $selected_checkbox1="";
			if($_POST[checknear]){ 
				$selected_checknear=implode(',', $_POST[checknear]);
				$selected_checknear=chekdata($selected_checknear); 
			}
  			else $selected_checknear=""; 
			
			mysql_query("UPDATE main SET   `is_special_offer`='$_POST[is_special_offer]',`active`='$_POST[selactive]',`title_ru`='$_POST[title_ru]', `deal`='$_POST[deal]',`objtype_id`='$_POST[seltypeobj]',`category_id`='$_POST[selcategory]',`price_ot`='$_POST[price_ot]',`price`='$_POST[price]',`region_id`='$_POST[selregion]',`city_id`='$_POST[selcity]',`address`='$_POST[address]',`lat`='$_POST[latitude]',`lng`='$_POST[longitude]',`properties_id`='$selected_checkbox1',`nearservices_id`='$selected_checknear',`num_of_rooms`='$_POST[num_of_rooms]',`floor`='$_POST[floor]',`floor_total`='$_POST[floors]',`num_of_bath`='$_POST[num_of_bath]', `squarehouse`='$_POST[squarehouse]',`squarearea`='$_POST[squarearea]',`squareterrace`='$_POST[squareterrace]',`squarsun`='$_POST[squarsun]',`year_built`='$_POST[year_built]',`distsea`='$_POST[distsea]',`distair`='$_POST[distair]',`distcity`='$_POST[distcity]',`infrastructure`='$_POST[infrastructure]',`condominimum`='$_POST[condominimum]',`distsea_unit`='$_POST[distsea_unit]',`distair_unit`='$_POST[distair_unit]',`distcity_unit`='$_POST[distcity_unit]',`infrastructure_unit`='$_POST[infrastructure_unit]',`condominimum_unit`='$_POST[condominimum_unit]',`description_ru`='$_POST[description_ru]',`seo_keywords_ru`='$_POST[seo_keywords_ru]',`seo_description_ru`='$_POST[seo_description_ru]',`notes`='$_POST[notes]' WHERE `id`='$_POST[hidden]'") or die(mysql_error());
			if($_POST[deal]==2){
				$resss=mysql_query("SELECT * FROM price_lend WHERE `item_id`='$_POST[hidden]'") or die(mysql_error());
				$res = mysql_num_rows($resss);
				if($res)mysql_query("UPDATE price_lend SET `May_1m`='$_POST[May_1m]',`May_2w`='$_POST[May_2w]',`May_1w`='$_POST[May_1w]',`June_1m`='$_POST[June_1m]',`June_1w`='$_POST[June_1w]',`June_2w`='$_POST[June_2w]',`August_1m`='$_POST[August_1m]',`August_1w`='$_POST[August_1w]',`August_2w`='$_POST[August_2w]',`month_1m`='$_POST[month_1m]',`month_1w`='$_POST[month_1w]',`month_2w`='$_POST[month_2w]' WHERE `item_id`='$_POST[hidden]'") or die(mysql_error());
				else mysql_query("INSERT INTO price_lend (item_id,May_1m,May_1w,May_2w,June_1m,June_1w,June_2w,August_1m,August_1w,August_2w,month_1m,month_1w,month_2w) VALUES('$_POST[hidden]','$_POST[May_1m]', '$_POST[May_1w]', '$_POST[May_2w]', '$_POST[June_1m]', '$_POST[June_1w]', '$_POST[June_2w]', '$_POST[August_1m]', '$_POST[August_1w]', '$_POST[August_2w]', '$_POST[month_1m]', '$_POST[month_1w]', '$_POST[month_2w]')") or die(mysql_error());	
			}
			$id=$_POST[hidden];	
			$_SESSION['id']=$id;
			$q = mysql_query("SELECT * FROM main WHERE `id`='$id' ");			
			$res = mysql_fetch_assoc($q);
		}
		else {
			$id=$_POST[hidden];	
			$_SESSION['id']=$id;
			$q = mysql_query("SELECT * FROM main WHERE `id`='$id' ");
			$qq = mysql_query("SELECT * FROM properties  ");			
			$qq1 = mysql_query("SELECT * FROM nearservices ");
			$res = mysql_fetch_assoc($q);
			while($ress = mysql_fetch_assoc($qq)){
				$properties_full[]=$ress[id];
			};
			while($ressn = mysql_fetch_assoc($qq1)){
				$nearservices_full[]=$ressn[id];
			};
			$nearservices_id= explode(',', $res[nearservices_id] );
			$properties_id= explode(',', $res[properties_id] );
		 	
		 	
			$res[uveren]=true;
			$res[properties]=$properties_id;
			$res[propertiesfull]=$properties_full;
			$res[nearrr]=$nearservices_id;
			$res[nearfull]=$nearservices_full;
		}
	}
	else {
		mysql_query("INSERT INTO main (is_special_offer,title_ru,active,deal,objtype_id, category_id, price_ot,price, region_id,city_id,address,lat,lng) VALUES('$_POST[is_special_offer]','$_POST[title_ru]','$_POST[selactive]','$_POST[deal]','$_POST[seltypeobj]','$_POST[selcategory]', '$_POST[price_ot]','$_POST[price]','$_POST[selregion]','$_POST[selcity]','$_POST[address]','$_POST[latitude]', '$_POST[longitude]')") or die(mysql_error());	 
		$id=mysql_insert_id();	
		if($_POST[deal]==2)mysql_query("INSERT INTO price_lend (item_id,May_1m,May_1w,May_2w,June_1m,June_1w,June_2w,August_1m,August_1w,August_2w,month_1m,month_1w,month_2w) VALUES('$id','$_POST[May_1m]', '$_POST[May_1w]', '$_POST[May_2w]', '$_POST[June_1m]', '$_POST[June_1w]', '$_POST[June_2w]', '$_POST[August_1m]', '$_POST[August_1w]', '$_POST[August_2w]', '$_POST[month_1m]', '$_POST[month_1w]', '$_POST[month_2w]')") or die(mysql_error());		
		$_SESSION['id']=$id;			
		$q =mysql_query("SELECT * FROM main WHERE `id`='$id' ");
		$res = mysql_fetch_assoc($q);
		$dateee=$res['date_updated'];
		if($res['deal']==2) $deal = "аренда";
		else $deal = "продажа";
		$title="лот:".$res['id'].", недвижимость в Испании";
		$keywords="лот,".$res['id'].", недвижимость,Испания,".$deal;
		$description="лот:".$res['id'].",".$deal. " недвижимости в Испании";
		mysql_query("UPDATE main SET `artikul`='$id', `date_created`='$dateee', `seo_keywords_ru`='$keywords', `seo_description_ru`='$description', `title_ru`='$title'   WHERE `id`='$id'")or die(mysql_error());
		$q = mysql_query("SELECT * FROM main WHERE `id`='$id' ");
		$res = mysql_fetch_assoc($q);
		@mkdir("uploads/".$id);
		@mkdir("uploads/".$id."/ready");
		@mkdir("uploads/".$id."/ready/wide");
		@mkdir("uploads/".$id."/ready/high");
		@mkdir("uploads/".$id."/ready/mid");
		@mkdir("uploads/".$id."/ready/low");
		}
echo json_encode($res);
}
if ($_POST[edit]){
		$id=$_POST[edit];
		$maintable = mysql_query("SELECT * FROM main WHERE `id`='$id' ");
		$res = mysql_fetch_assoc($maintable);
		if($res[deal]==2){
			$item_id = mysql_query("SELECT * FROM price_lend WHERE `item_id`='$id' ");
			$resd = mysql_fetch_assoc($item_id); 
			$res[May_1m]=$resd[May_1m];
			$res[May_1w]=$resd[May_1w];
			$res[May_2w]=$resd[May_2w];
			$res[June_1m]=$resd[June_1m];
			$res[June_1w]=$resd[June_1w];
			$res[June_2w]=$resd[June_2w];
			$res[August_1m]=$resd[August_1m];
			$res[August_1w]=$resd[August_1w];
			$res[August_2w]=$resd[August_2w];
			$res[month_1m]=$resd[month_1m];
			$res[month_1w]=$resd[month_1w];
			$res[month_2w]=$resd[month_2w];
		}
			$qq = mysql_query("SELECT * FROM properties  ");			
			$qq1 = mysql_query("SELECT * FROM nearservices ");
			
			while($ress = mysql_fetch_assoc($qq)){
				$properties_full[]=$ress[id];
			};
			while($ressn = mysql_fetch_assoc($qq1)){
				$nearservices_full[]=$ressn[id];
			};
			$nearservices_id= explode(',', $res[nearservices_id] );
			$properties_id= explode(',', $res[properties_id] );
		 	
		 	
			
			$res[properties]=$properties_id;
			$res[propertiesfull]=$properties_full;
			$res[nearrr]=$nearservices_id;
			$res[nearfull]=$nearservices_full;
			
		echo json_encode($res);
}
if($_POST[upload]){
	$_SESSION['id']=$_POST[id];
	$path="uploads/".$_POST[id];
	$dir = $path."/";
	$valid=array("gif","png","jpg","PNG","JPG","JPEG", "GIF","jpeg");
	$filessize=array();
	$filetime=array();
	
 	if (is_dir($dir)) {
  		if ($dh = opendir($dir)) {
	  		while (($file = readdir($dh)) !== false) {
		  		if(filetype($dir . $file)==file){
			 		$exten = substr($file,1 + strrpos($file, "."));
			 		if(in_array($exten, $valid)){
				 		$ft=filectime($dir.$file);
						 $filetime[$file]=$ft;
						 list($imagewidth, $imageheight, $imageType) = getimagesize($dir.$file);
						 if($imagewidth>1001 || $imageheight>1001){
							$scale=$imagewidth/1000;
							ScaleImage($dir.$file, $dir.$file, $scale);
						 }
						if(!file_exists ($dir."ready/".$file)){							
							if(!is_dir($dir."ready/wide/"))@mkdir($dir."/ready/wide");
							if(!is_dir($dir."ready/high/"))@mkdir($dir."/ready/high");
							if(!is_dir($dir."ready/mid/"))@mkdir($dir."/ready/mid");
							if(!is_dir($dir."ready/low/"))@mkdir($dir."/ready/low");
							AutoCropImage($dir."ready/".$file,$dir.$file,1.33);
							AutoCropImage($dir."ready/wide/".$file,$dir.$file,1.81);
							list($imagewidth, $imageheight, $imageType) = getimagesize($dir."ready/wide/".$file);
							$scalethumb=$imagewidth/670;
							ScaleImage($dir."ready/wide/".$file, $dir."ready/wide/".$file, $scalethumb);
							list($imagewidth, $imageheight, $imageType) = getimagesize($dir."ready/".$file);							
							$scalethumb=$imagewidth/534;							
							ScaleImage($dir."ready/high/".$file, $dir."ready/".$file, $scalethumb);
							$scalethumb=$imagewidth/395;
							ScaleImage($dir."ready/mid/".$file, $dir."ready/".$file, $scalethumb);
							$scalethumb=$imagewidth/165;
							ScaleImage($dir."ready/low/".$file, $dir."ready/".$file, $scalethumb);
							}
				  		}
			
					}
 	 		}closedir($dh);
 		 }
	}
	$filename=array();
	arsort($filetime,SORT_NUMERIC);
	foreach($filetime as $file => $value){
		$filename[]=$file;
	}
	$filezzzz=$filename[0];
$q = mysql_query("SELECT `image` FROM main WHERE `id`='$_POST[id]' ");
$res = mysql_fetch_assoc($q);

if($res[image]=="") mysql_query("UPDATE main SET `image`='$filezzzz'  WHERE `id`='$_POST[id]'")or die(mysql_error());
$ress=mysql_query("SELECT `image` FROM main WHERE `id`='$_POST[id]' ");
$res = mysql_fetch_assoc($ress);
$mydata=array();
$mydata[files]=$filename;
$mydata[main]=$res[image];
$mydata[id]=$_POST[id];
header("Content-Type: text/plain");
echo json_encode($mydata);
}
if($_POST[del]){
	$_SESSION['id']=$_POST[itemid];
	$dir = "uploads/".$_POST[itemid]."/";
	if(file_exists($dir.$_POST[del])) $res1=unlink($dir.$_POST[del]);
	if(file_exists($dir."ready/".$_POST[del])) $res1=unlink($dir."ready/".$_POST[del]);
	if(file_exists($dir."ready/high/".$_POST[del])) $res1=unlink($dir."ready/high/".$_POST[del]);
	if(file_exists($dir."ready/mid/".$_POST[del])) $res1=unlink($dir."ready/mid/".$_POST[del]);
	if(file_exists($dir."ready/low/".$_POST[del])) $res1=unlink($dir."ready/low/".$_POST[del]);
	if(file_exists($dir."ready/wide/".$_POST[del])) $res1=unlink($dir."ready/wide/".$_POST[del]);

echo json_encode(true);
}
if($_POST[makemain]){
	$_SESSION['id']=$_POST[id];
	$path="uploads/".$_POST[id];
	$dir = $path."/";
	$valid=array("gif","png","jpg","PNG","JPG","JPEG", "GIF","jpeg");
	$filessize=array();
	$filetime=array();
	
 	if (is_dir($dir)) {
  		if ($dh = opendir($dir)) {
	  		while (($file = readdir($dh)) !== false) {
		  		if(filetype($dir . $file)==file){
			 		$exten = substr($file,1 + strrpos($file, "."));
			 		if(in_array($exten, $valid)){
				 		$ft=filectime($dir.$file);
						 $filetime[$file]=$ft;
				  		}
			
					}
 	 		}closedir($dh);
 		 }
	}
	$filename=array();
	arsort($filetime,SORT_NUMERIC);
	foreach($filetime as $file => $value){
		$filename[]=$file;
	}

mysql_query("UPDATE main SET `image`='$_POST[makemain]'  WHERE `id`='$_POST[id]'")or die(mysql_error());
$ress=mysql_query("SELECT `image` FROM main WHERE `id`='$_POST[id]' ");
$res = mysql_fetch_assoc($ress);
$mydata=array();
$mydata[files]=$filename;
$mydata[main]=$res[image];
$mydata[id]=$_POST[id];
header("Content-Type: text/plain");
echo json_encode($mydata);
}
if ($_POST['rot']){
	if(!is_dir("uploads/".$_POST[id]."ready/wide/"))@mkdir("uploads/".$_POST[id]."/ready/wide");
	if(!is_dir("uploads/".$_POST[id]."ready/high/"))@mkdir("uploads/".$_POST[id]."/ready/high");
	if(!is_dir("uploads/".$_POST[id]."ready/mid/"))@mkdir("uploads/".$_POST[id]."/ready/mid");
	if(!is_dir("uploads/".$_POST[id]."ready/low/"))@mkdir("uploads/".$_POST[id]."/ready/low");
	if($_POST['direction']== 'rigth')
	turn("uploads/".$_POST[id]."/".$_POST[rot],"uploads/".$_POST[id]."/".$_POST[rot], 90);
	if($_POST['direction']== 'left')
	turn("uploads/".$_POST[id]."/".$_POST[rot],"uploads/".$_POST[id]."/".$_POST[rot], 270);
	AutoCropImage("uploads/".$_POST[id]."/ready/".$_POST[rot],"uploads/".$_POST[id]."/".$_POST[rot],1.33);
	AutoCropImage("uploads/".$_POST[id]."/ready/wide/".$_POST[rot],"uploads/".$_POST[id]."/".$_POST[rot],1.81);
	list($imagewidth, $imageheight, $imageType) = getimagesize("uploads/".$_POST[id]."/ready/wide/".$_POST[rot]);
	$scalethumb=$imagewidth/670;
	ScaleImage("uploads/".$_POST[id]."/ready/wide/".$_POST[rot], "uploads/".$_POST[id]."/ready/wide/".$_POST[rot], $scalethumb);
	list($imagewidth, $imageheight, $imageType) = getimagesize("uploads/".$_POST[id]."/ready/".$_POST[rot]);
	$scalethumb=$imagewidth/534;
	ScaleImage("uploads/".$_POST[id]."/ready/high/".$_POST[rot], "uploads/".$_POST[id]."/ready/".$_POST[rot], $scalethumb);
	$scalethumb=$imagewidth/395;
	ScaleImage("uploads/".$_POST[id]."/ready/mid/".$_POST[rot], "uploads/".$_POST[id]."/ready/".$_POST[rot], $scalethumb);
	$scalethumb=$imagewidth/165;
	ScaleImage("uploads/".$_POST[id]."/ready/low/".$_POST[rot], "uploads/".$_POST[id]."/ready/".$_POST[rot], $scalethumb);

	echo json_encode(true);
}
if ($_POST['name']){
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	$id=$_POST["id"];
	$name=$_POST['name'];
	$source="uploads/".$id."/".$name;
	$destination="uploads/".$id."/ready/";
	if(!is_dir($destination."wide/"))@mkdir($destination."wide");
	if(!is_dir($destination."high/"))@mkdir($destination."high");
	if(!is_dir($destination."mid/"))@mkdir($destination."mid");
	if(!is_dir($destination."low/"))@mkdir($destination."low");
	$cropped = resizeThumbnailImage($destination.$name, $source,$w,$h,$x1,$y1,1);
	AutoCropImage($destination."wide/".$name,$destination.$name,1.81);
	list($imagewidth, $imageheight, $imageType) = getimagesize($destination."wide/".$name);
	$scalethumb=$imagewidth/670;
	ScaleImage($destination."wide/".$name, $destination."wide/".$name, $scalethumb);
	list($imagewidth, $imageheight, $imageType) = getimagesize($destination.$name);
	$scalethumb=$imagewidth/534;	
	ScaleImage($destination."high/".$name, $destination.$name, $scalethumb);
	$scalethumb=$imagewidth/395;
	ScaleImage($destination."mid/".$name, $destination.$name, $scalethumb);
	$scalethumb=$imagewidth/165;
	ScaleImage($destination."low/".$name, $destination.$name, $scalethumb);
	
	
	echo json_encode(true);
}