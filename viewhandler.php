<?php
error_reporting(E_ALL);
$trg ="testfolder";


$dir = glob($trg.'/*');
$a =array();
         foreach($dir as $e){
               $pos =stripos($e,"/")+1;
               array_push($a,substr($e,$pos));       
         }  
         
//print_r($a);
echo json_encode($a);
?>