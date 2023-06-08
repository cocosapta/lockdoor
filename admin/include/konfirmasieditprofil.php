<?php
if (isset($_SESSION['id_user_54'])) {
        
    $id_user = $_SESSION['id_user_54'];
    $name = addslashes($_POST['nama']);
    $email = addslashes($_POST['email']);
    $phone = addslashes($_POST['phone']);
    $address = addslashes($_POST['address']);
    $filee = $_FILES['inputFotoFile01'];

    $valid_extensions = array('jpg','jpeg','png','gif');
    $size = $_FILES['inputFotoFile01']['size'];
    $nama_file = $_FILES['inputFotoFile01']['name'];
    $extensions = strtolower(end(explode('.', $nama_file)));
    $max_size    = 512000;

    if (empty($name)) {
        header("Location:profile-update_notif-empty_type=nama");
    } else if (empty($email)) {
        header("Location:profile-update_notif-empty_type=email");
    } else if (empty($phone)) {
        header("Location:profile-update_notif-empty_type=telepon");
    } else if (empty($address)) {
        header("Location:profile-update_notif-empty_type=alamat");
    } else if (!empty($nama_file) && in_array($extensions, $valid_extensions) == false) {
        header("Location:profile-update_notif-empty_type=notimage");
    } else if (!empty($nama_file) && $size > $max_size) {
        header("Location:profile-update_notif-empty_type=maxsize");
    } else {
        if (!empty($nama_file)) {
            $jsonUpdateProfile = json_decode(_updateProfileWithImg($id_user, $name, $email, $phone, $address, $nama_file), TRUE);
            $isSuc = $jsonUpdateProfile['isSuccess'];
            $msg = $jsonUpdateProfile['message'];
        } else {
            $jsonUpdateProfile = json_decode(_updateProfile($id_user, $name, $email, $phone, $address), TRUE);
            $isSuc = $jsonUpdateProfile['isSuccess'];
            $msg = $jsonUpdateProfile['message'];
        }
        if ($isSuc){
            header("Location:profile_notif-successUpdate");
            $_SESSION['msgNotif'] = $msg;
        } else {
            header("Location:profile-update_notif-errorUpdate");
            $_SESSION['msgNotif'] = $msg;
        }
        
    }
}
?>