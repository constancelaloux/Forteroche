<?php

class UploadControler
{
   function upload()
        {

           // Allowed origins to upload images
           //$accepted_origins = array("http://localhost", "http://107.161.82.130", "http://codexworld.com");
           $accepted_origins = array("http://localhost:8888", "http://127.0.0.1:8888");
           // Images upload path
           //$imageFolder = "../Public/../../images/";
           //$imageFolder = "../../../Public/images/";
           $imageFolder = "Public/images/";
           //$imageFolder = "../../blogenalaska/Public/images/";

           reset($_FILES);
           $temp = current($_FILES);
           //print_r($temp);
           if(is_uploaded_file($temp['tmp_name'])){
               if(isset($_SERVER['HTTP_ORIGIN'])){
                   // Same-origin requests won't set an origin. If the origin is set, it must be valid.
                   if(in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)){
                       header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                   }else{
                       header("HTTP/1.1 403 Origin Denied");
                       return;
                   }
               }

               // Sanitize input
               if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
                   header("HTTP/1.1 400 Invalid file name.");
                   return;
               }

               // Verify extension
               if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))){
                   header("HTTP/1.1 400 Invalid extension.");
                   return;
               }
               
               // Accept upload if there was no origin, or if it is an accepted origin
               $filetowrite = $imageFolder . $temp['name'];

               $filetowrite1 = "/blogenalaska/" . $imageFolder . $temp['name'];
               //print_r($filetowrite);
               //$rename = "/blogenalaska/Public/images/"  . $temp['name'];
               //rename($filetowrite, $rename);

               move_uploaded_file($temp['tmp_name'], $filetowrite);
               // Respond to the successful upload with JSON.
               
               //echo json_encode(array('location' => $filetowrite));
               //echo json_encode(array('location' => $filetowrite1));
               //echo $filetowrite1;
               echo "$filetowrite1";
               //echo "<img src='$filetowrite1' />";
           } else {
               // Notify editor that the upload failed
               header("HTTP/1.1 500 Server Error");
           }  
        }
        
    function upload2()
        {
        print_r($_GET['form_data']);
            if (isset($_POST['form_data']))
                {
                    if (!empty($_POST['form_data']))
                        {
                            $filetowrite1 = $_POST['form_data'];
                            //$file = "<img src='$filetowrite1' />";
                            echo "<img src='$filetowrite1' />";
                        }

                }

        }
}



/*******************************************************
   * Only these origins will be allowed to upload images *
   ******************************************************/
  /*$accepted_origins = array("http://localhost", "http://192.168.1.1", "http://example.com");

  /*********************************************
   * Change this line to set the upload folder *
   *********************************************/
  /*$imageFolder = "/images/";

  reset ($_FILES);
  $temp = current($_FILES);
  if (is_uploaded_file($temp['tmp_name'])){
    if (isset($_SERVER['HTTP_ORIGIN'])) {
      // same-origin requests won't set an origin. If the origin is set, it must be valid.
      if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      } else {
        header("HTTP/1.1 403 Origin Denied");
        return;
      }
    }

    /*
      If your script needs to receive cookies, set images_upload_credentials : true in
      the configuration and enable the following two headers.
    */
    // header('Access-Control-Allow-Credentials: true');
    // header('P3P: CP="There is no P3P policy."');

    // Sanitize input
    /*if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }

    // Verify extension
    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }

    // Accept upload if there was no origin, or if it is an accepted origin
    $filetowrite = $imageFolder . $temp['name'];
    move_uploaded_file($temp['tmp_name'], $filetowrite);

    // Respond to the successful upload with JSON.
    // Use a location key to specify the path to the saved image resource.
    // { location : '/your/uploaded/image/file'}
    echo json_encode(array('location' => $filetowrite));
  } else {
    // Notify editor that the upload failed
    header("HTTP/1.1 500 Server Error");
  }
      /*$ds = DIRECTORY_SEPARATOR;

      $storeFolder = '/images';

      if (!empty($_FILES)) 
      {
             $tempFile = $_FILES['file']['tmp_name'];

             $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;

             $file_name = substr(md5(rand(1, 213213212)), 1, 5) . "_" . str_replace(array('\'', '"', ' ', '`'), '_', $_FILES['file']['name']);

             $targetFile =  $targetPath. $file_name;

             if(move_uploaded_file($tempFile,$targetFile)){
                   die( $_SERVER['HTTP_REFERER']. $storeFolder . "/" . $file_name );
              }else{
                   die('Fail');
              }

       }*/
//print_r('jy suis dans lupload');
 // Allowed origins to upload images
/*$accepted_origins = array("http://localhost");

// Images upload path
$imageFolder = "images/";


reset($_FILES);
$temp = current($_FILES);

if(is_uploaded_file($temp['tmp_name'])){
    if(isset($_SERVER['HTTP_ORIGIN'])){
        // Same-origin requests won't set an origin. If the origin is set, it must be valid.
        if(in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)){
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        }else{
            header("HTTP/1.1 403 Origin Denied");
            return;
        }
    }
  
    // Sanitize input
    if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }
  
    // Verify extension
    if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))){
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }
  
    // Accept upload if there was no origin, or if it is an accepted origin
    $filetowrite = $imageFolder . $temp['name'];
    move_uploaded_file($temp['tmp_name'], $filetowrite);
  
    // Respond to the successful upload with JSON.
    echo json_encode(array('location' => $filetowrite));
} else {
    // Notify editor that the upload failed
    header("HTTP/1.1 500 Server Error");
}*/
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*$url = array(
    "http://localhost"
);

reset($_FILES);
$temp = current($_FILES);

if (is_uploaded_file($temp['tmp_name'])) {
    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name,Bad request");
        return;
    }
    
    // Validating File extensions
    if (! in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array(
        "gif",
        "jpg",
        "png"
    ))) {
        header("HTTP/1.1 400 Not an Image");
        return;
    }
    
    $fileName = "/images/" . $temp['name'];
    move_uploaded_file($temp['tmp_name'], $fileName);
    
    // Return JSON response with the uploaded file path.
    echo json_encode(array(
        'file_path' => $fileName
    ));
}*/