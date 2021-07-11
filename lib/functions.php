<?php
function redirect($url, $statusCode = 303)
{
      if (headers_sent() === false){
          header('Location: ' . $url, true, $statusCode);
      }
   die();
}

//    $config['file']="image";
//    $config['old']="old";
//    $config['extensions']="JPG|JPEG|PNG";
//    $config['size']=2097152;
//    $config['path']="../uploads/photo/";
//    $imageArray=fileUpload($config);
//    $file_name=$imageArray['file_name'];
function fileUpload($config){
    $old=$_REQUEST[$config['old']];
    if (isset($_FILES[$config['file']]) && !empty($_FILES[$config['file']]['name'])) {

        if ($old !== "test.jpg") {
            unlink($config['path'] . $old);
        }

        $response["error"] = "";
        $file_size = $_FILES[$config['file']]['size'];
        $file_tmp = $_FILES[$config['file']]['tmp_name'];
        $file_type = $_FILES[$config['file']]['type'];
        $array = explode('.', $_FILES[$config['file']]['name']);
        $file_ext = strtolower(end($array));
        $extensions = explode("|",strtolower($config['extensions']));
        $file_name = time() . "." . $file_ext; //$_FILES[$config['file']]['name'];

        if (in_array(strtolower($file_ext), $extensions) === false) {
            $response["error"] = 'extension not allowed select only '.$config['extensions'];
            $response["file_name"]=$old;
            $response["code"]=0;
        }

        if ($file_size >$config['size']) {
            $response["error"] = 'File size exceeds';
            $response["file_name"]=$old;
            $response["code"]=0;
        }

        if (empty($response["error"]) == true) {
            move_uploaded_file($file_tmp, $config['path'] . $file_name);
            $response["error"] = "";
            $response["file_name"]=$file_name;
            $response["code"]=1;
        } else {

        }
    } else {
        $response["file_name"]=$old;
        $response["error"] = "image not uploaded";
        $response["code"]=2;
    }
    return $response;
}
//convert base64 and save image file
function base64ToImage($base64_string, $output_file) {
    $file = fopen($output_file, "wb");
    $data = explode(',', $base64_string);
    fwrite($file, base64_decode($data[1]));
    fclose($file);    
    return $output_file;
}

?>
