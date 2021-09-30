<?php
error_reporting(E_ALL);

function is_animated($file)
{
    $fp = null;
    if (is_string($file)) {
        $fp = fopen($file, "rb");
    } else {
        $fp = $file;
        fseek($fp, 0);
    }
    if (fread($fp, 3) !== "GIF") {
        fclose($fp);

        return false;
    }
    $frames = 0;

    while (!feof($fp) && $frames < 2) {
        if (fread($fp, 1) === "\x00") {
            if (fread($fp, 1) === "\x2c" || fread($fp, 2) === "\x21\xf9") {
                $frames++;
            }
        }
    }
    fclose($fp);
    return $frames > 1;
}
print_r($_FILES);
print_r($_POST);
if(file_exists('tempfolder')){}else{
      mkdir('tempfolder',0777, true);
}
$source = $_FILES['file']['tmp_name'];
$fileName = $_FILES['file']['name'];
$ext =strrchr($_FILES['file']['name'],".");
 //move_uploaded_file($source,'tempfolder/'.$fileName) ; 

$file =  $_FILES['file']['tmp_name'];
$newName= "img_".$_POST['random'].$ext;
$rotation=$_POST['rotation'];


$exts = array(".png",".gif",".jpg",".jpeg",".JPEG","PNG");
if(in_array($ext,$exts) AND is_animated($file) ==""){
      if(in_array($ext,$exts)){
               if($ext ==$exts[0]){
                                       $createfrom = imagecreatefrompng($file);}
                        elseif($ext ==$exts[1]){
                                       $createfrom = imagecreatefromgif($file);}
                        elseif($ext ==$exts[2]){
                                       $createfrom = imagecreatefromjpeg($file);}
                        elseif($ext ==$exts[3]){
                                       $createfrom = imagecreatefromjpeg($file);}
                        elseif($ext ==$exts[4]){
                                       $createfrom = imagecreatefromjpeg($file);}
 }else{}

$out= "testfolder/".$newName.$ext;
$percent = .25;

list($width, $height) = getimagesize($file);
$new_width = $width * $percent;
$new_height = $height * $percent;

$image_p = imagecreatetruecolor($new_width, $new_height);

if($ext ==".png"){
            imagealphablending($image_p, FALSE);
            imagesavealpha($image_p, TRUE);
            imagecopyresampled($image_p, $createfrom, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            $background = imagecolorallocate($image_p, 0, 0, 0);
            imagecolortransparent($createfrom, $background);
            imagepng($image_p,$out);
}elseif($ext ==".gif"){
            imagecopyresampled($image_p, $createfrom, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            $background = imagecolorallocate($image_p, 0, 0, 0);
            imagecolortransparent($image_p, $background);
            imagegif($image_p,$out);
}else{
           imagecopyresampled($image_p, $createfrom, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            $image_p=imagerotate ( $image_p , (int)$rotation,0 );         
            imagejpeg($image_p, $out,100);
}
unlink($file);
}else {
            rename($file,'testfolder/'.$fileName);
}

?>