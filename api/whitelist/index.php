<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET' :
        if (!empty($_GET['id'])) {
            getWhiteLById($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
        break;
    case 'POST':
        createWhiteList();
        break;
    case 'DELETE':
        if (!empty($_GET['id'])) {
            deleteWhiteListById($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
        break;
    default:
        set_response(false, "Wrong method", []);
        break;
    break;
}

function getWhiteLById($id){
    global $connect;
    $sql_gwl = "SELECT `w`.`whitelist_id` AS `id_whitelist`, 
    `h`.`hw_name` AS `device_name`, 
    `r`.`user_name` AS `username`, 
    `d`.`users_detail_id` AS `id_user`, `d`.`users_detail_nim` AS `nim`, `d`.`users_detail_name` AS `name`, `d`.`users_detail_class` AS `class` 
    FROM `whitelist_device_users` `w` 
    INNER JOIN `hw_rfid` `h` ON `w`.`hw_id`=`h`.`hw_id` 
    INNER JOIN `users_rfid` `r` ON `w`.`user_id`=`r`.`user_id` 
    INNER JOIN `users_detail` `d` ON `r`.`users_detail_id`=`d`.`users_detail_id` 
    WHERE `h`.`hw_id` = '$id'";
    
    $query_gwl = mysqli_query($connect, $sql_gwl);
    $dataWl = array();
    while ($rowWl = mysqli_fetch_assoc($query_gwl)) {
        $dataWl[] = $rowWl;
    }
    $jumlah_whw = mysqli_num_rows($query_gwl);
    if ($jumlah_whw > 0){
        set_response(true, "Whitelist in Device is found", $dataWl);
    } else {
        set_response(false, "Whitelist in Device not found", []);
    }
}

function createWhiteList(){
    global $connect;
    if (!empty($_POST['whitelistUserId']) && !empty($_POST['whitelistDeviceId']) ) {
        
        $idWhiteGen = myIdGenerator("WL");
        $userId = getUserIdFromDetail($_POST['whitelistUserId']);
        $hwId = $_POST['whitelistDeviceId'];
        
        $dateNow = myDateTimeGenerator();
        // checkUserExistance($userId);
        checkHwExistance($hwId);
        checkHwWhiteStatus($hwId);
        checkUserInWhiteList($userId, $hwId);

        $sqlCreateWhitelist = "INSERT INTO `whitelist_device_users` (`whitelist_id`, `hw_id`, `user_id`, `whitelist_create_at`, `whitelist_update_at`) 
        VALUES ('".$idWhiteGen."', '".$hwId."', '".$userId."', '".$dateNow."', '".$dateNow."')";
        $createWhitelist = mysqli_query($connect, $sqlCreateWhitelist);
        // $createWhitelist = true;

        $showId = array("ID Whitelist" => $idWhiteGen, "ID User" => $userId, "ID Device" => $hwId);
        if ($createWhitelist){
            set_response(true, "Whitelist created successfully", $showId);
        } else {
            set_response(false, "Whitelist failed to create", []);
        }
    } else {
        set_response(false, "Body request is not complete", []);
    }
}

function deleteWhiteListById($id){
    global $connect;
    
    $sql_gud = "SELECT * FROM `whitelist_device_users` WHERE `whitelist_id`='$id'";
    $query_gud = mysqli_query($connect, $sql_gud);
    $jumlah_gud = mysqli_num_rows($query_gud);
    if ($jumlah_gud > 0){
    
        $sql_dus = "DELETE FROM `whitelist_device_users` WHERE `whitelist_id`='$id'";
        $delUser = mysqli_query($connect, $sql_dus);
    
        if ($delUser){
            set_response(true, "Whitelist deleted successfully", $id);
        } else {
            set_response(false, "Whitelist failed to delete", []);
        }

    } else {
        set_response(false, "Whitelist not found", []);
    }
}

function getUserIdFromDetail($id){
    global $connect;
    $qGetUserId = $connect->query("SELECT `user_id` AS `id` FROM `users_rfid` WHERE `users_detail_id`='$id'");
    $cGetUserId = $qGetUserId->fetch_array();
    $uId = $cGetUserId['id'];
    if ($uId == NULL){
        set_response(false, "User not found", $id);
        exit;
    } else {
        return $uId;
    }
}

function checkHwExistance($id){
    global $connect;
    $query_cul = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `hw_rfid` WHERE `hw_id`='$id'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];
    if ($jumlahRow == 0){
        set_response(false, "Device not found", $id);
        exit;
    } else {
        return "OK";
    }
}

function checkHwWhiteStatus($hwId){
    global $connect;
    $qGetUserId = $connect->query("SELECT `hw_whitelist_status` AS `status` FROM `hw_rfid` WHERE `hw_id`='$hwId'");
    $cGetUserId = $qGetUserId->fetch_array();
    $stat = $cGetUserId['status'];
    if ($stat == "active"){
        return "OK";
    } else {
        set_response(false, "Device whitelist is deactive", $hwId);
        exit;
    }
}

function checkUserInWhiteList($userId, $hwId){
    global $connect;
    $query_cul = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `whitelist_device_users` WHERE `hw_id`='$hwId' AND `user_id`='$userId'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];

    $showData = array("ID User"=>$userId, "ID Device"=>$hwId);
    if ($jumlahRow >= 1){
        set_response(false, "User already in this device whitelist", $showData);
        exit;
    } else {
        return "OK";
    }
}

?>