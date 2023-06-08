<?php
date_default_timezone_set('Asia/Jakarta');

//-------------------Untuk Online-------------------//
$databaseHost = 'localhost';
$databaseName = 'sepk9647_iot_esp_rfid';
$databaseUsername = 'sepk9647_parkeer_admin';
$databasePassword = 'ngakakkenceng';
$serverToken = "bf06e2ae53348e7d0070c43d83aaf997";

$connect = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
// $connect = mysqli_connect("localhost","sepk9647_parkeer_admin","ngakakkenceng","sepk9647_iot_esp_rfid");
// if (!$connect) {
//     echo "Gagal tersambung ke database!";
// }else{
//     echo "Berhasil tersambung ke database!";
// }

function uniqIdGenerator(){
    $final = base_convert(microtime(false), 10, 36);
    return $final;
}

function myIdGenerator($pre){
    date_default_timezone_set('Asia/Jakarta');
    $dateTime = date('ymdHis');
    // $numb = $count + 1;
    $final = $pre.$dateTime;
    return $final;
}

function myImageNameGenerator($imageName){
    $encrypt        = md5(date('dmYHis'));
    $imageExt       = substr($imageName, strrpos($imageName, '.'));
    $imageExt       = str_replace('.', '', $imageExt); // Extension
    $imageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $imageName);
    $newImageName   = str_replace(' ', '', $encrypt . '.' . $imageExt);
    return $newImageName;
}

function myDateTimeGenerator(){
    date_default_timezone_set('Asia/Jakarta');
    $time = date('Y-m-d H:i:s');
    return $time;
}

function deleteFileFoto($fotoName){
    $fileExistDir = "../admin/media/foto/$fotoName";
    if(file_exists($fileExistDir)){
        unlink("../admin/media/foto/$fotoName"); //Menghapus Gambar
        return "File deleted";
    } else {
        return "File not found";
    }
}

//-------------------Untuk Online-------------------//

?>