<?php

if (!empty($_GET['idDel'])) {
    $id_userr = $_GET['idDel'];

    $jsonDelUs = json_decode(_deleteUser($id_userr), TRUE);
    $isSuc = $jsonDelUs['isSuccess'];
    $msg = $jsonDelUs['message'];

    if ($isSuc) {
        header("Location:users_notif-successDelete");
        $_SESSION['msgNotif'] = $msg;
    } else {
        header("Location:users_notif-errorDelete");
        $_SESSION['msgNotif'] = $msg;
    }
}

?>