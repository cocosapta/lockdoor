<?php
// header("Content-Type: application/json");
$dateTime = date("Y-m-d H:i:s");

if (!empty($_GET['var1']) && !empty($_GET['var2'])) {
    $tag = $_GET['var1'];
    $hwCode = $_GET['var2'];
    $hwType = $_GET['var3'];

    // Get Hardware
    $queryHw = "SELECT * FROM hw_rfid WHERE hw_id = '$hwCode' ";
    $getHw = mysqli_query($connect, $queryHw);
    $dataHw = array();
    while ($rowHw = mysqli_fetch_assoc($getHw)) {
        $dataHw[] = $rowHw;
    }

    // Get User RFID
    $query = "SELECT * FROM users_rfid WHERE user_tag = '$tag' "; //AND user_status = 'active' ";
    $get = mysqli_query($connect, $query);
    $data = array();
    while ($row = mysqli_fetch_assoc($get)) {
        $data[] = $row;
    }

    if (mysqli_num_rows($getHw) > 0) {

        if (mysqli_num_rows($get) > 0) {

            if ($dataHw[0]['hw_whitelist_status'] == "active"){
                checkUserInDeviceWhiteList($data[0]['user_id'], $hwCode, $data, $dataHw);
            }

            if ($data[0]['user_status'] == "active") {

                //Get Custom Additional
                $queryGS = "SELECT `r`.`record_access_in`, `r`.`record_access_out`, `r`.`record_access_duration`, `r`.`record_access_device_type`, `h`.`hw_id`, `h`.`hw_name` 
                FROM `record_access` `r` 
                INNER JOIN `hw_rfid` `h` ON `r`.`hw_id` = `h`.`hw_id` 
                WHERE users_detail_id = '" . $data[0]['users_detail_id'] . "' 
                ORDER BY `r`.`record_access_id` DESC LIMIT 1";
                $getGS = mysqli_query($connect, $queryGS);
                $dataGS = array();
                while ($rowGS = mysqli_fetch_assoc($getGS)) {
                    $dataGS[] = $rowGS;
                }

                if (mysqli_num_rows($getGS) > 0) {
                    $rIn = $dataGS[0]['record_access_in'];
                    $rOut = $dataGS[0]['record_access_out'];
                    $rDur =  $dataGS[0]['record_access_duration'];
                    $rHwId = $dataGS[0]['hw_id'];
                    $rHwNm = $dataGS[0]['hw_name'];

                    $lastIn = date('Y-m-d', strtotime($rIn));
                    $accessDateNow = date('Y-m-d', strtotime($dateTime));
                    $newDur = diffAccessDuration($rIn, $dateTime);
                }

                if (mysqli_num_rows($getGS) > 0){

                    if ($rDur == "0" && $hwCode != $rHwId) {
                        set_response(false, "Access denied (Sesi aktif di $rHwNm sejak $rIn )", $data[0]['user_name']);
                        addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_id'], "Access Duplicate ($rHwNm)");
                    } else if ($rDur == "0" && $lastIn != $accessDateNow) {
                        set_response(false, "Clear session success", $data[0]['user_name']); 
                        addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_id'], "Access Denied (Clear Session)");
                        addRecordAccess($rIn, $dateTime, $newDur, $data[0]['users_detail_id'], $dataHw[0]['hw_id'], "0");
                    } else if ($rDur != "0"){
                        set_response(true, "Access granted", $data[0]['user_name']); //show column data
                        addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_id'], "Access Granted");
                        addRecordAccess($dateTime, "0", "0", $data[0]['users_detail_id'], $dataHw[0]['hw_id'], $rDur);
                    } else {
                        set_response(true, "Access granted", $data[0]['user_name']); //show column data
                        addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_id'], "Access Granted");
                        addRecordAccess($rIn, $dateTime, $newDur, $data[0]['users_detail_id'], $dataHw[0]['hw_id'], $rDur);
                    }

                } else {
                    set_response(true, "Access granted", $data[0]['user_name']); //show column data
                    addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_id'], "Access Granted");
                    addRecordAccess($dateTime, "0", "0", $data[0]['users_detail_id'], $dataHw[0]['hw_id'], "1");
                }
            } else {
                set_response(false, "Access blocked", $data[0]['user_name']); //show column data
                addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_id'], "Access Blocked");
            }

        } else {
            set_response(false, "Unregistered Card", $tag);
            addLogSystem($dateTime, $tag, $dataHw[0]['hw_id'], "Unregistered Card");
        }

    } else {
        set_response(false, "Unregistered Hardware", $hwCode);
    }
} else {
    set_response(false, "Card Not Detected", "NONE");
}

// function set_response($isSuccess, $message, $data){
//     $result = array(
//         "isSuccess" => $isSuccess,
//         "message" => $message,
//         "data" => $data
//     );
//     echo json_encode($result);
// }

function addLogSystem($dateTime, $tag, $hw, $prm){
    global $connect;
    $query_log = "INSERT INTO log_system (log_id, log_datetime, log_desc, log_status, hw_id) VALUES (NULL, '".$dateTime."', '".$tag." mencoba akses kartu', '".$prm."', '".$hw."')";
    $get_log = mysqli_query($connect, $query_log);
}

function addRecordAccess($TimeIn, $TimeOut, $rDuration, $uDetailId, $hwId, $lastDur){
    global $connect;

    if ($lastDur == "0"){
        $q_recUpdate = "UPDATE record_access SET record_access_out = '$TimeOut', record_access_duration = '$rDuration' 
        WHERE users_detail_id = '$uDetailId' AND hw_id = '$hwId' ORDER BY record_access_id DESC LIMIT 1";
        $get_reqUpdate = mysqli_query($connect, $q_recUpdate);
    } else {
        $q_recAccess = "INSERT INTO record_access (record_access_id, record_access_in, record_access_out, record_access_duration, users_detail_id, hw_id) 
        VALUES (NULL, '".$TimeIn."', '0', '0', '".$uDetailId."', '".$hwId."')";
        $get_recAccess = mysqli_query($connect, $q_recAccess);
    }

}

function diffAccessDuration($sTime1, $fTime1){
    $sTime = strtotime($sTime1);
    $fTime = strtotime($fTime1);
    $diff = $fTime - $sTime;
    $jam = floor($diff / (60 * 60));
    $menit = $diff - ( $jam * (60 * 60) );
    $detik = $diff % 60;
    $tDiff =  $jam." Jam ".floor($menit/60)." Menit ".$detik." Detik";
    return $tDiff;
}

function checkUserInDeviceWhiteList($usId, $hwId, $data, $dataHw){
    global $connect, $dateTime;
    $query_cul2 = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `whitelist_device_users` WHERE `hw_id`='$hwId' AND `user_id`='$usId'");
    $count_cul2 = $query_cul2->fetch_array();
    $jumlahRow = $count_cul2['jumlah'];

    $showData = array("ID User"=>$usId, "ID Device"=>$hwId);
    if ($jumlahRow < 1){
        set_response(false, "Access for this card is restricted", $showData);
        addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_id'], "Access Restricted");
        exit;
    } else {
        return "OK";
    }
}


?>