<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'POST':
        uploadImageP();
        break;
    default:
        set_response(false, "Wrong method", []);
        break;
    break;
}


function uploadImageP(){
    if (!empty($_FILES['uploadImage']['tmp_name'])) {

        $temp = "../admin/media/foto/";
        if (!file_exists($temp))
            mkdir($temp);
    
        $imageUpload = $_FILES['uploadImage']['tmp_name'];
        $imageName = $_FILES['uploadImage']['name'];
        // $imageType = $_FILES['uploadImage']['type'];
        $imageSize = $_FILES['uploadImage']['size'];

        checkTypeFile($imageName);
        checkSizeFile($imageSize);
    
        if (!empty($imageUpload)) {
            $file_name = myImageNameGenerator($imageName);
    
            move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $temp . $file_name); // Menyimpan file
    
            set_response(false, "File saved successfully", []);
    
        } else {
            set_response(false, "File failed to save", []);
    
        }
    } else {
        set_response(false, "File does not exist", []);
    }
}

function checkTypeFile($fileName){
    $valid_extensions = array('jpg','jpeg','png','gif');
    $imageExt       = substr($fileName, strrpos($fileName, '.'));
    $imageExt       = str_replace('.', '', $imageExt); // Extension
    if (in_array($imageExt, $valid_extensions) == false){
        $showType = array("type" => $imageExt);
        set_response(false, "Only jpg, jpeg, png and gif files are allowed", $showType);
        exit;
    } else {
        return "OK";
    }
}

function checkSizeFile($size){
    $max_size    = 512000;
    if ($size > $max_size) {
        $sizes = $size / 1024;
        $showSize = array("size" => $sizes);
        set_response(false, "Maximum file size is 500KB", $showSize);
        exit;
    } else {
        return "OK";
    }
}

?>