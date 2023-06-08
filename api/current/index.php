<?php

// if (!empty($_GET['kind']) && !empty($_GET['id'])) {

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if (!empty($_GET['id'])) {
            getCurrentById($_GET['id']);
        }
        // else if ($_GET['kind'] == "power"){
        //     getPowerById($_GET['id']);
        // } 
        else {
            set_response(false, "Requires parameter id", []);
        }
    break;
    case 'DELETE':
        if (!empty($_GET['id'])) {
            deleteCurrentDataByKind($_GET['id']);
        }
        // else if ($_GET['kind'] == "power"){
        //     getPowerById($_GET['id']);
        // } 
        else {
            set_response(false, "Requires parameter kind", []);
        }
    break;
    default:
        set_response(false, "Wrong method", []);
        break;
    break;
}

        // } else {
        //     set_response(false, "Requires parameter kind and id", []);
        // }



function getCurrentById($id){
    global $connect;
    $sql_gud = "SELECT * FROM `hw_rfid` WHERE `hw_id`='$id'";
    $query_gud = mysqli_query($connect, $sql_gud);
    $jumlah_gud = mysqli_num_rows($query_gud);

    if ($jumlah_gud > 0) {
        $baseQueryCurrent = "SELECT * FROM `sensor_current_data` WHERE `hw_id`='$id'  ORDER BY `sensor_current_id` DESC LIMIT 15";
        $queX = mysqli_query($connect, "SELECT `sensor_current_datetime` AS `datetime`, `sensor_current_value_a` AS `current`, `sensor_current_value_b` AS `power` FROM (".$baseQueryCurrent.") var1 ORDER BY `sensor_current_id` ASC");
        // $queY = mysqli_query($connect, "SELECT `sensor_current_value_a` AS `nilai` FROM (".$baseQueryCurrent.") var1 ORDER BY `sensor_current_id` ASC");

        $showDataX = array();
        while ($rowX = mysqli_fetch_assoc($queX)) {
            // $dtime = substr($rowX['waktu'], 11);
            // $showDataX[] = $dtime;
            $showDataX[] = $rowX;
        }
        // $showDataY = array();
        // while ($rowY = mysqli_fetch_assoc($queY)) {
        //     // $valY = round($rowY['nilai'], 1);
        //     // $showDataY[] = $valY;
        //     $showDataY[] = $rowY;
        // }

        // <?php while ($b = mysqli_fetch_array($x_waktu)) {
        //     
        //     echo '"' . $dtime . '",';
        //   } 
        //    while ($b = mysqli_fetch_array($y_nilai)) {
        //     echo   . ',';
        //   } 
        $stts = statusDevice($id);
        set_responseCurrent(true, "Data found", $id, $stts, $showDataX);
    } else {
        set_responseCurrent(false, "Device not found", $id, "", []);
    }

}

// function getPowerById($id){
//     global $connect;
//     $sql_gud = "SELECT * FROM `hw_rfid` WHERE `hw_id`='$id'";
//     $query_gud = mysqli_query($connect, $sql_gud);
//     $jumlah_gud = mysqli_num_rows($query_gud);

//     if ($jumlah_gud > 0) {
//         $baseQueryCurrent = "SELECT * FROM `sensor_current_data` WHERE `hw_id`='$id'  ORDER BY `sensor_current_id` DESC LIMIT 15";
//         $queX = mysqli_query($connect, "SELECT `sensor_current_datetime` AS `datetime`, `sensor_current_value_a` AS `current` FROM (".$baseQueryCurrent.") var1 ORDER BY `sensor_current_id` ASC");
//         // $queY = mysqli_query($connect, "SELECT `sensor_current_value_a` AS `nilai` FROM (".$baseQueryCurrent.") var1 ORDER BY `sensor_current_id` ASC");

//         $showDataX = array();
//         while ($rowX = mysqli_fetch_assoc($queX)) {
//             // $dtime = substr($rowX['waktu'], 11);
//             // $showDataX[] = $dtime;
//             $showDataX[] = $rowX;
//         }
//         // $showDataY = array();
//         // while ($rowY = mysqli_fetch_assoc($queY)) {
//         //     // $valY = round($rowY['nilai'], 1);
//         //     // $showDataY[] = $valY;
//         //     $showDataY[] = $rowY;
//         // }

//         // <?php while ($b = mysqli_fetch_array($x_waktu)) {
//         //     
//         //     echo '"' . $dtime . '",';
//         //   } 
//         //    while ($b = mysqli_fetch_array($y_nilai)) {
//         //     echo   . ',';
//         //   } 
//         set_responseCurrent(true, "Data found", $id, $showDataX, $showDataY = "");
//     } else {
//         set_responseCurrent(false, "Device not found", $id, []);
//     }
// }

function deleteCurrentDataByKind($id){
    switch ($id) {
        case 'daily':
            set_responseCurrent(false, "Daily delete is still under development", $id, NULL, []);
        break;
        case 'weekly':
            deleteCurrentDataWeekly();
            break;
        case 'monthly':
            set_responseCurrent(false, "Monthly delete is still under development", $id, NULL, []);
            break;
        default:
            set_response(false, "Wrong kind", $id);
            break;
        break;
    }
}

function deleteCurrentDataWeekly(){
    global $connect;
    $dateOnWeekAgo = getDateOneWeekAgo();

    $qGetDataBef = $connect->query("SELECT COUNT(*) AS `total` FROM `sensor_current_data`");
    $cGetDataBef = $qGetDataBef->fetch_array();
    $dataBefore = $cGetDataBef['total'];

    // $qGetDataDel = $connect->query("SELECT COUNT(*) AS `total` FROM `sensor_current_data` WHERE `sensor_current_datetime` < '$dateOnWeekAgo'");
    // $cGetDataDel = $qGetDataDel->fetch_array();
    // $dataDelete = $cGetDataDel['total'];

    $sql_del = "DELETE FROM `sensor_current_data` WHERE `sensor_current_datetime` < '$dateOnWeekAgo'"; //Hapus User
    $delData = mysqli_query($connect, $sql_del);
    // $delData = true;

    $qGetDataAf = $connect->query("SELECT COUNT(*) AS `total` FROM `sensor_current_data`");
    $cGetDataAf = $qGetDataAf->fetch_array();
    $dataAfter = $cGetDataAf['total'];

    $dataDelete = $dataBefore - $dataAfter;

    $showData = array("data_total" => $dataBefore, "data_deleted" => $dataDelete, "data_left" => $dataAfter);
    if ($delData){
        set_responseCurrent(true, "Data weekly deleted successfully", "weekly", NULL, $showData);
    } else {
        set_responseCurrent(false, "Data weekly failed to delete", "weekly", NULL, $showData);
    }

}

function set_responseCurrent($isSuccess, $message, $id, $stat, $data)
{
    $result = array(
        "isSuccess" => $isSuccess,
        "message" => $message,
        "id" => $id,
        "status" => $stat,
        "data" => $data
    );
    echo json_encode($result);
}

function statusDevice($id){
    global $connect;
    date_default_timezone_set('Asia/Jakarta');
    $fTime = myDateTimeGenerator();
    $fTime2 = time();
    $sTime = date("Y-m-d H:i:s", strtotime("-10 seconds", $fTime2));

    $qru = $connect->query("SELECT COUNT(sensor_current_id) AS `jumlah` FROM `sensor_current_data` WHERE `hw_id` = '$id' AND `sensor_current_datetime` BETWEEN '$sTime' AND '$fTime'");
    $cru = $qru->fetch_array();
    $countIdDev = $cru['jumlah'];

    if ($countIdDev > 0){
        return "ONLINE";
    } else {
        return "OFFLINE";
    }

}

function getDateOneWeekAgo(){
    $dateToday = myDateTimeGenerator();
    $dateOneWeekAgo = date ( 'Y-m-d' , strtotime('-6 day', strtotime($dateToday)));
    return $dateOneWeekAgo;
}
?>