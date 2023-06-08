<?php
if (isset($_SESSION['id_user_54'])) {
    $id_user_54 = $_SESSION['id_user_54'];
    $pass_lama = $_POST['pass_lama'];
    $pass_baru = $_POST['pass_baru'];
    $konfirmasi_pass = $_POST['konfirmasi_pass'];

    $jsonPassLama = json_decode(_getProfilePassword($id_user_54), TRUE);
    $isSuc = $jsonPassLama['isSuccess'];
    $msg = $jsonPassLama['message'];
    $password = $jsonPassLama['data'][1];

    $enpass_lama = md5(md5($_POST['pass_lama']));
    // $enpass_baru = md5(md5($_POST['pass_baru']));
    // $enkonfirmasi_pass = md5($_POST['konfirmasi_pass']);

    
    if (empty($pass_lama)) {
        header("Location:change-password_notif-true");
        $_SESSION['msgNotif'] = "Password lama wajib diisi";
    } else if (empty($pass_baru)) {
        header("Location:change-password_notif-true");
        $_SESSION['msgNotif'] = "Password baru wajib diisi";
    } else if (empty($konfirmasi_pass)) {
        header("Location:change-password_notif-true");
        $_SESSION['msgNotif'] = "Konfirmasi password baru wajib diisi";
    } else if ($pass_baru != $konfirmasi_pass) {
        header("Location:change-password_notif-true");
        $_SESSION['msgNotif'] = "Password baru dan konfirmasi password tidak cocok";
    } else if ($password != $enpass_lama) {
        header("Location:change-password_notif-true");
        $_SESSION['msgNotif'] = "Password lama anda salah";
    } else {
        $jsonUpdatePass = json_decode(_updateProfilePassword($id_user_54, $pass_baru), TRUE);
        $isSuc = $jsonUpdatePass['isSuccess'];
        $msg = $jsonUpdatePass['message'];
        if ($isSuc){ 
            header("Location:profile_notif-successUpdatePassword");
        } else {
            header("Location:profile_notif-errorUpdatePassword");
        }
    }
}
?>