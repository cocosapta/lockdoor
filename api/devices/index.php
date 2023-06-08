<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if (!empty($_GET['id'])) {
            getDeviceById($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
    break;
    case 'POST':
        if (!empty($_GET['id'])) {
            updateDeviceById($_GET['id']);
        } else {
            createDevice();
        }
    break;
    case 'DELETE':
        if (!empty($_GET['id'])) {
            deleteDeviceById($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
    break;
    case 'UNLOCK':
        if (!empty($_GET['id'])) {
            updateDoorEmergencySystem($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
    break;
    default:
        set_response(false, "Wrong method", []);
        break;
    break;
}


function createDevice(){
    global $connect;
    if (!empty($_POST['deviceName']) && !empty($_POST['deviceDesc']) ) {
        
        $idHwGen = myIdGenerator("HW");
        $devName = $_POST['deviceName'];
        $devDesc = $_POST['deviceDesc'];
        $dateNow = myDateTimeGenerator();

        $sqlCreateHw = "INSERT INTO `hw_rfid` (`hw_id`, `hw_name`, `hw_whitelist_status`, `hw_desc`, `hw_create_at`, `hw_update_at`) VALUES ('".$idHwGen."', '".$devName."', 'deactive', '".$devDesc."',  '".$dateNow."',  '".$dateNow."')";
        $createHardware = mysqli_query($connect, $sqlCreateHw);

        $showId = array("ID Device" => $idHwGen);
        if ($createHardware){
            set_response(true, "Device created successfully", $showId);
        } else {
            set_response(false, "Device failed to create", []);
        }
    } else {
        set_response(false, "Body request is not complete", []);
    }
}

function getDeviceById($id){
    global $connect;
    $sql_ghw = "SELECT `hw_id` AS `id`, `hw_name` AS `name`, `hw_desc` AS `desc`, `hw_create_at` AS `create_at`, `hw_update_at` AS `update_at`,
    `hw_whitelist_status` AS `whitelist_status` 
    FROM `hw_rfid` WHERE `hw_id` = '$id'";
    
    $query_ghw = mysqli_query($connect, $sql_ghw);
    $dataHw = array();
    while ($rowHw = mysqli_fetch_assoc($query_ghw)) {
        $dataHw[] = $rowHw;
    }

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

    $showData = array("detail"=>$dataHw, "whitelist"=>$dataWl);

    $jumlah_ghw = mysqli_num_rows($query_ghw);
    if ($jumlah_ghw > 0){
        set_response(true, "Device found", $showData);
    } else {
        set_response(false, "Device not found", []);
    }
}

function updateDeviceById($id){
    global $connect;
    $sql_gud = "SELECT * FROM `hw_rfid` WHERE `hw_id`='$id'";
    $query_gud = mysqli_query($connect, $sql_gud);
    $jumlah_gud = mysqli_num_rows($query_gud);

    if ($jumlah_gud > 0) {
        if (!empty($_POST['deviceName']) && !empty($_POST['deviceDesc']) ) {

            $devName = $_POST['deviceName'];
            $devDesc = $_POST['deviceDesc'];
            $whiteL = $_POST['deviceWhite'];
            $dateNow = myDateTimeGenerator();
            checkUsersInDevice($id, $whiteL);

            $sql_uhw = "UPDATE `hw_rfid` SET `hw_name`='$devName', `hw_whitelist_status`='$whiteL', `hw_desc`='$devDesc', `hw_update_at`='$dateNow' WHERE `hw_id`='$id'";
            $updateDevice = mysqli_query($connect, $sql_uhw);

            $sql_ghw = "SELECT `hw_id` AS `id`, `hw_name` AS `name`, `hw_whitelist_status` AS `whitelist_status`, `hw_desc` AS `desc`, `hw_create_at` AS `create_at`, `hw_update_at` AS `update_at` FROM `hw_rfid` WHERE `hw_id` = '$id'";
            
            $query_gacc = mysqli_query($connect, $sql_ghw);
            $showData = array();
            while ($rowAcc = mysqli_fetch_assoc($query_gacc)) {
                $showData[] = $rowAcc;
            }

            $showFinal = array("Device" => $showData);
            if ($updateDevice) {
                set_response(true, "Device updated successfully", $showFinal);
            } else {
                set_response(false, "Device failed to update", []);
            }
        } else {
            set_response(false, "Body request is not complete", []);
        }

    } else {
        set_response(false, "Device not found", []);
    }
}

function deleteDeviceById($id){
    global $connect;
    
    $sql_ghw = "SELECT * FROM `hw_rfid` WHERE `hw_id`='$id'";
    $query_ghw = mysqli_query($connect, $sql_ghw);
    $jumlah_ghw = mysqli_num_rows($query_ghw);
    if ($jumlah_ghw > 0){
    
        $sql_dhw = "DELETE FROM `hw_rfid` WHERE `hw_id` = '$id'"; //Hapus User
        $delHw = mysqli_query($connect, $sql_dhw);
    
        $showData = array("ID" => $id);
        if ($delHw){
            set_response(true, "Device deleted successfully", $showData);
        } else {
            set_response(false, "Device failed to delete", []);
        }

    } else {
        set_response(false, "Device not found", []);
    }

}

function checkUsersInDevice($id, $whiteL){
    global $connect;

    $sql_ghw = "SELECT `hw_whitelist_status` AS `whitelist_status` FROM `hw_rfid` WHERE `hw_id` = '$id'";
    
    $query_ghw = mysqli_query($connect, $sql_ghw);
    $dataHw = array();
    while ($rowHw = mysqli_fetch_assoc($query_ghw)) {
        $dataHw[] = $rowHw;
    }

    $query_cul = $connect->query("SELECT COUNT(record_access_id) AS `jumlah` FROM `record_access` WHERE `hw_id`='$id' AND `record_access_out`='0000-00-00 00:00:00'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];
    if ($jumlahRow >= 1 && $dataHw[0]['whitelist_status'] != $whiteL){
        set_response(false, "Unable to change whitelist, there are users in room", $dataHw[0]['whitelist_status']);
        exit;
    } else {
        return "OK";
    }
}

function updateDoorEmergencySystem($id){
    global $connect;
    $sql_updateDES = "UPDATE `hw_rfid` SET `hw_emergency` = 'true' WHERE `hw_id`= '".$id."'";
    $updateDES = mysqli_query($connect, $sql_updateDES);
    
    if ($updateDES) {
        set_response(true, "DES activated successfully", $id);
    } else {
        set_response(false, "DES failed to activated", []);
    }
    // flush();
    sleep(5);
    $sql_updateDESf = "UPDATE `hw_rfid` SET `hw_emergency` = 'false' WHERE `hw_id`= '".$id."'";
    $updateDESf= mysqli_query($connect, $sql_updateDESf);
}
?>