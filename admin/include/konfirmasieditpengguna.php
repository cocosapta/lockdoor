<?php
if (isset($_SESSION['id_users_detail'])) {
    $id_u_detail = $_SESSION['id_users_detail'];

    $niim = $_POST['inputNim'];
    $name = addslashes($_POST['inputNama']);
    $class = $_POST['inputKelas'];
    $email = $_POST['inputEmail'];
    $phone = $_POST['inputTelepon'];
    $address = addslashes($_POST['inputAlamat']);
    $uName = $_POST['inputUserName'];
    $uTag = $_POST['inputTag'];
    $uStat = $_POST['inputUserStatus'];

    $valid_extensions = array('jpg','jpeg','png','gif');
    // $lokasi_file = $_FILES['inputFotoFile02']['tmp_name'];
    $nama_file = $_FILES['inputFotoFile02']['name'];
    $size = $_FILES['inputFotoFile02']['size'];
    $max_size    = 512000;
    $extensions = strtolower(end(explode('.', $nama_file)));
    
    if (!empty($nama_file) && in_array($extensions, $valid_extensions) == false) {
        header("Location:user-details-".$id_u_detail."_notif-empty-type=notimage");
    } else if (!empty($nama_file) && $size > $max_size) {
        header("Location:user-details-".$id_u_detail."_notif-empty-type=maxsize");
    } else {

        if (!empty($nama_file)) {
            $jsonUpdateUser = json_decode(_updateUserWithImage($id_u_detail, $niim, $name, $class, $email, $phone, $address, $nama_file, $uName, $uTag, $uStat), TRUE);
            $isSuc = $jsonUpdateUser['isSuccess'];
            $msg = $jsonUpdateUser['message'];
        } else {
            $jsonUpdateUser = json_decode(_updateUser($id_u_detail, $niim, $name, $class, $email, $phone, $address, $uName, $uTag, $uStat), TRUE);
            $isSuc = $jsonUpdateUser['isSuccess'];
            $msg = $jsonUpdateUser['message'];
        }
        if ($isSuc){
            header("Location:user-details-".$id_u_detail."_notif-successUpdate");
            $_SESSION['msgNotif'] = $msg;
        } else {
            header("Location:user-details-".$id_u_detail."_notif-errorUpdate");
            $_SESSION['msgNotif'] = $msg;
        }
    }
}
?>