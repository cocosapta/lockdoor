<?php
// $id_hw = $_POST['inputIdp'];
$name = addslashes($_POST['inputNama']);
$desc = addslashes($_POST['inputKet']);

if (empty($name) && empty($desc)) {
    header("Location:add-device_notif-empty_type=semua");
} else{
    $jsonCreateDevice = json_decode(_addDevice($name, $desc), TRUE); 
    $isSuc = $jsonCreateDevice['isSuccess'];
    $msg = $jsonCreateDevice['message'];

    if ($isSuc){
        header("Location:devices_notif-successCreate");
        $_SESSION['msgNotif'] = $msg;
    } else {
        header("Location:add-device_notif-errorCreate");
        $_SESSION['msgNotif'] = $msg;
    }
}
?>