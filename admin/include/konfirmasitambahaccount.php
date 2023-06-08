<?php

$time = date('dmYHis');

$name = addslashes($_POST['inputNm']);
$email = addslashes($_POST['inputEm']);
$phone = $_POST['inputNum'];
$address = addslashes($_POST['inputAddrs']);
$level = $_POST['inputLev'];

$nama_file = $_FILES['inputFotoFile04']['name'];
// $lokasi_file = $_FILES['inputFotoFile04']['tmp_name'];
$size = $_FILES['inputFotoFile04']['size'];
$max_size    = 512000;
$extensions = strtolower(end(explode('.', $nama_file)));
$valid_extensions = array('jpg','jpeg','png','gif');
// $nama_files = md5($time.$nama_file).".".$extensions;
// $direktori = 'media/foto/' . $nama_files;


if (!empty($nama_file) && in_array($extensions, $valid_extensions) == false) {
    header("Location:add-account_notif-empty_type=notimage");
} else if (!empty($nama_file) && $size > $max_size) {
    header("Location:add-account_notif-empty_type=maxsize");
} else if(empty($nama_file)){
    header("Location:add-account_notif-empty_type=foto");
} else{

    $jsonCreateAccount = json_decode(_addAccountWeb($name, $email, $phone, $address, $level, $nama_file), TRUE); 
    $isSuc = $jsonCreateAccount['isSuccess'];
    $msg = $jsonCreateAccount['message'];

    if ($isSuc){
        header("Location:accounts_notif-successCreate");
        $_SESSION['msgNotif'] = $msg;
    } else {
        header("Location:add-account_notif-errorCreate");
        $_SESSION['msgNotif'] = $msg;
    }

}
?>