<?php

if (!empty($_GET['idDes'])) {
    $id_hw = $_GET['idDes'];

    $jsonDeshw = json_decode(_desDevice($id_hw), TRUE);
    $isSuc = $jsonDeshw['isSuccess'];
    $msg = $jsonDeshw['message'];

    if ($isSuc) {
        header("Location:devices_notif-successDes");
        $_SESSION['msgNotif'] = $msg;
    } else {
        header("Location:devices_notif-errorDes");
        $_SESSION['msgNotif'] = $msg;
    }
}

?>