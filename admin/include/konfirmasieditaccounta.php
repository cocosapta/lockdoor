<?php
if (isset($_SESSION['id_account_detail'])) {
    $id_acc_detail = $_SESSION['id_account_detail'];

    $name = addslashes($_POST['name']);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = addslashes($_POST['address']);
    $level = $_POST['level'];
    $uN = $_POST['uNames'];
    $uP = $_POST['uPws'];
    
    $nama_file = $_FILES['inputFotoFile05']['name'];
    $size = $_FILES['inputFotoFile05']['size'];
    // $lokasi_file = $_FILES['inputFotoFile05']['tmp_name'];
    $valid_extensions = array('jpg','jpeg','png','gif');
    $max_size    = 512000;
    $extensions = strtolower(end(explode('.', $nama_file)));
    
    if (!empty($nama_file) && in_array($extensions, $valid_extensions) == false) {
        header("Location:account-update-".$id_acc_detail."_notif-empty_type=notimage");
    } else if (!empty($nama_file) && $size > $max_size) {
        header("Location:account-update-".$id_acc_detail."_notif-empty_type=maxsize");
    } else if (empty($name)) {
        header("Location:account-update-".$id_acc_detail."_notif-empty_type=nama");
    } else if (empty($email)) {
        header("Location:account-update-".$id_acc_detail."_notif-empty_type=email");
    } else if (empty($phone)) {
        header("Location:account-update-".$id_acc_detail."_notif-empty_type=telepon");
    } else if (empty($address)) {
        header("Location:account-update-".$id_acc_detail."_notif-empty_type=alamat");
    } else if (empty($level)) {
        header("Location:account-update-".$id_acc_detail."_notif-empty_type=level");
    } else if (empty($uN)) {
        header("Location:account-update-".$id_acc_detail."_notif-empty_type=username");
    } 
    // else if (empty($uP)) {
    //     header("Location:account-update-".$id_acc_detail."_notif-empty_type=password");
    // } 
    else {
        if (!empty($nama_file)) {
            $jsonUpdateAccount = json_decode(_updateAccountWebWithImg($id_acc_detail, $name, $email, $phone, $address, $level, $nama_file, $uN, $uP), TRUE);
            $isSuc = $jsonUpdateAccount['isSuccess'];
            $msg = $jsonUpdateAccount['message'];
        } else {
            $jsonUpdateAccount = json_decode(_updateAccountWeb($id_acc_detail, $name, $email, $phone, $address, $level, $uN, $uP), TRUE);
            $isSuc = $jsonUpdateAccount['isSuccess'];
            $msg = $jsonUpdateAccount['message'];
        }
        if ($isSuc){
            header("Location:accounts_notif-successUpdate");
            $_SESSION['msgNotif'] = $msg;
        } else {
            header("Location:account-update-".$id_acc_detail."_notif-errorUpdate");
            $_SESSION['msgNotif'] = $msg;
        }
    }
}
?>