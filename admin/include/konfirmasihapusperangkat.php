<?php

if (!empty($_GET['idDel'])) {
    $id_hw = $_GET['idDel'];

    $jsonDelhw = json_decode(_deleteDevice($id_hw), TRUE);
    $isSuc = $jsonDelhw['isSuccess'];
    $msg = $jsonDelhw['message'];

    if ($isSuc) {
        header("Location:devices_notif-successDelete");
        $_SESSION['msgNotif'] = $msg;
    } else {
        header("Location:devices_notif-errorDelete");
        $_SESSION['msgNotif'] = $msg;
    }
}

?>