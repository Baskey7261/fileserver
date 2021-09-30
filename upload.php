<?php

$file = $_FILES['file'];
print_r($_POST);
$ext = strtolower(strrchr($file['name'],'.'));
$img = ["img" => $_POST['postID'].$ext];
$newData = array_merge($_POST,$img);


$jsonData= json_encode($newData);

echo "\n".$jsonData."\n"; 

if(!file_exists("posts")){
  mkdir("posts", 0777, true);
}
if(!file_exists("posts/posts.js")){
  fopen("posts/posts.js","w");
  file_put_contents("posts/posts.js","var postData =[\n".$jsonData.",\n];");
}else{

  $handle = fopen("posts/posts.js", "r+") or die("Unable to open file!");
  fseek($handle,-4,SEEK_END);
  fwrite($handle,",\r\n".$jsonData."\r\n];");
  rewind($handle);
  fclose($handle);
}





$imgFiles = array(".bmp",".webp",".jpg",".png",".svg",".eps",".jpeg");
$webFiles = array(".php",".css",".html",".js");
$other = array(".ps",".ai",".pdf");

if(in_array($ext,$webFiles)){
  if(!file_exists("webfiles")){
    mkdir("webfiles", 0777, true);
  }
  move_uploaded_file($file['tmp_name'], "webfiles/".$file['name']);

}elseif(in_array($ext, $other)){
    if(!file_exists("other")){
      mkdir("other", 0777, true);
    }
    move_uploaded_file($file['tmp_name'], "other/".$file['name']);

}elseif(in_array($ext, $imgFiles)){
  if(!file_exists("posts/images")){
    mkdir("posts/images", 0777, true);
  }
  if(!file_exists("posts/images/uploads")){
    mkdir("posts/images/uploads", 0777, true);
  }
  if(!file_exists("posts/images/thumbs")){
    mkdir("posts/images/thumbs", 0777, true);
  }
  if(!file_exists("posts/images/mediumres")){
    mkdir("posts/images/mediumres", 0777, true);
  }  
  move_uploaded_file($file['tmp_name'], "posts/images/uploads/".$file['name']);
  $src ="posts/images/uploads/".$file['name'];
  $newName= $_POST['postID'];
  function calcsize ($newWidth, $newHeight ,$oldWidth, $oldHeight) {  
    $ratio = $oldWidth / $oldHeight;
    if (($newWidth / $newHeight) > $ratio) {
      $newWidth = $newHeight * $ratio;
    } else {
      $newHeight = $newWidth / $ratio;
    }
      $a= array($newHeight,$newWidth);
    return $a;
  }

function resize($src, $out, $newWidth, $newHeight ,$oldWidth, $oldHeight, $ext){

  $preservedTypes = array(".png",".gif",".svg",".eps");
    if(in_array($ext, $preservedTypes)){
      copy($src, $out) or die("Unable to copy $src to $out.");
    }  
    elseif($ext ==".jpg" || $ext ==".jpeg") { 
      $tci = imagecreatetruecolor($newWidth, $newHeight);
      $newImg = imagecreatefromjpeg($src); 
      imagecopyresampled($tci, $newImg, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);         
      imagejpeg($tci,$out,100);
    } 
    elseif($ext ==".webp"){
      $tci = imagecreatetruecolor($newWidth, $newHeight);
      $newImg = imagecreatefromwebp($src); 
      imagecopyresampled($tci, $newImg, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);          
      imagewebp($tci,$out,100);
    }
    elseif($ext==".bmp"){
      $tci = imagecreatetruecolor($newWidth, $newHeight);
      $newImg = imagecreatefrombmp($src); 
      imagecopyresampled($tci, $newImg, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);       
      imagebmp($tci,$out,0);
    }   
}


list($oldWidth, $oldHeight) = getimagesize($src);


$fileOut = "posts/images/thumbs/tn_". $newName.$ext;
$a= calcsize(300, 200, $oldWidth, $oldHeight);
$newHeight = $a[0];$newWidth = $a[1];
resize($src, $fileOut, $newWidth, $newHeight, $oldWidth, $oldHeight, $ext);

$fileOut = "posts/images/mediumres/med_". $newName.$ext;
$a = calcsize(800, 600, $oldWidth, $oldHeight);
$newHeight = $a[0];$newWidth = $a[1];
resize($src, $fileOut, $newWidth, $newHeight, $oldWidth, $oldHeight, $ext);
}else{
   echo "Sorry, files of this type are not allowed on this server.";
   exit;
}
echo "Successful";
?>


