<?php
if (isset($_POST['login'])) {
    $user = $_POST['username_54'];
    $pass = $_POST['password_54'];
    $enpass = $_POST['password_54'];

    $jsonAccLogin = json_decode(_loginWebAdmin($user, $enpass), TRUE);

    $isSuc = $jsonAccLogin['isSuccess'];
    // $msg = $jsonAccLogin['message'];
    $id_user54 = $jsonAccLogin['data']['id'];
    $level_user54 = $jsonAccLogin['data']['level'];

    if (empty($user)) {
        header("Location:login-failed=emptyUsername");
    } else if (empty($pass)) {
        header("Location:login-failed=emptyPassword");
    } else if ($isSuc == false) {
        header("Location:login-failed=wrongUserPass");
    } else if ($isSuc == true) {
        $_SESSION['id_user_54'] = $id_user54;
        $_SESSION['level_54'] = $level_user54;
        header("Location:profile");
    } else {
        header("Location:login-failed=connectionLost");
    }
}
?>