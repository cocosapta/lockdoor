<?php
if (isset($_SESSION['id_hw_detail'])) {

    $id_hw_detail = $_SESSION['id_hw_detail'];

    $name = addslashes($_POST['inputNama']);
    $desc = addslashes($_POST['inputKet']);
    $whiteL = addslashes($_POST['whiteList']);

    $jsonUpdateDevice = json_decode(_updateDevice($id_hw_detail, $name, $desc, $whiteL), TRUE);
    $isSuc = $jsonUpdateDevice['isSuccess'];
    $msg = $jsonUpdateDevice['message'];
    
    if ($isSuc){
        header("Location:device-details-".$id_hw_detail."_notif-successUpdate");
        $_SESSION['msgNotif'] = $msg;
    } else {
        header("Location:device-details-".$id_hw_detail."_notif-errorUpdate");
        $_SESSION['msgNotif'] = $msg;
    }

}
?>