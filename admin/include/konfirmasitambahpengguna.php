<?php

$nim = $_POST['inputNim'];
$name = addslashes($_POST['inputNama']);
$class = $_POST['inputKelas'];
$email = addslashes($_POST['inputEmail']);
$phone = $_POST['inputTelepon'];
$address = addslashes($_POST['inputAlamat']);
$nama_file = $_FILES['inputFotoFile03']['name'];

$valid_extensions = array('jpg','jpeg','png','gif');
$max_size    = 512000;
$extensions = strtolower(end(explode('.', $nama_file)));
$size = $_FILES['inputFotoFile03']['size'];
// $lokasi_file = $_FILES['inputFotoFile03']['tmp_name'];
// $nama_files = md5($time.$nama_file).".".$extensions;
// $direktori = 'media/foto/' . $nama_files;

if(empty($nama_file)){
    header("Location:add-user_notif-empty_type=foto");
} else if (!empty($nama_file) && in_array($extensions, $valid_extensions) == false) {
    header("Location:add-user_notif-empty_type=notimage");
} else if (!empty($nama_file) && $size > $max_size) {
    header("Location:add-user_notif-empty_type=maxsize");
} else{

    $jsonCreateUser = json_decode(_addUser($nim, $name, $class, $email, $phone, $address, $nama_file), TRUE); 
    $isSuc = $jsonCreateUser['isSuccess'];
    $msg = $jsonCreateUser['message'];

    if ($isSuc){
        header("Location:users_notif-successCreate");
        $_SESSION['msgNotif'] = $msg;
    } else {
        header("Location:add-user_notif-errorCreate");
        $_SESSION['msgNotif'] = $msg;
    }

}
?>