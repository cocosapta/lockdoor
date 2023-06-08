<?php
if (isset($_SESSION['id_hw_detail']) && !empty($_GET['idDel']) ) {

    $id_hw_detail = $_SESSION['id_hw_detail'];
    $id_whitelist = $_GET['idDel'];

    $jsonDeleteWhiteListById = json_decode(_deleteWhitelistById($id_whitelist), TRUE);
    $isSuc = $jsonDeleteWhiteListById['isSuccess'];
    $msg = $jsonDeleteWhiteListById['message'];
    
    if ($isSuc){
        header("Location:device-details-".$id_hw_detail."_notif-successDelete");
        $_SESSION['msgNotif'] = $msg;
    } else {
        header("Location:device-details-".$id_hw_detail."_notif-errorDelete");
        $_SESSION['msgNotif'] = $msg;
    }

}
?>