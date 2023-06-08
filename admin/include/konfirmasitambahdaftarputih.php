<?php

// if (!empty($_GET['idUser']) && !empty($_GET['idDev'])){
    $idUs = $_GET['idUser'];
    $idDe = $_GET['idDev'];

    $jsonCreateWhiteList = json_decode(_addWhitelist($idUs, $idDe), TRUE); 
    $isSuc = $jsonCreateWhiteList['isSuccess'];
    $msg = $jsonCreateWhiteList['message'];

    if ($isSuc){
        header("Location:device-details-".$idDe."_notif-successCreate");
        $_SESSION['msgNotif'] = $msg;
    } else {
        header("Location:device-details-".$idDe."_notif-errorCreate");
        $_SESSION['msgNotif'] = $msg;
    }

// } else {
//     header("Location:device-details-".$_GET['idDev']."_notif-errorCreate");
// }

?>