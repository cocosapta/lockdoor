<?php
// header("Content-Type: application/json");
// Versi "Jika dari inside yang tidak sama dengan sesi selesai sebelumya maka akan granted"
$dateTime = date("Y-m-d H:i:s");

if (!empty($_GET['var1']) && !empty($_GET['var2']) && !empty($_GET['var3'])) { // Cek Keberadaan Parameter
    $tag = $_GET['var1'];
    $hwCode = $_GET['var2'];
    $hwType = $_GET['var3'];

    $queryHw = "SELECT * FROM hw_rfid WHERE hw_id = '$hwCode' "; // Get Hardware
    $getHw = mysqli_query($connect, $queryHw);
    $dataHw = array();
    while ($rowHw = mysqli_fetch_assoc($getHw)) {
        $dataHw[] = $rowHw;
    }
    $hardwareId = $dataHw[0]['hw_id'];
    $hardwareWs = $dataHw[0]['hw_whitelist_status'];

    $query = "SELECT * FROM users_rfid WHERE user_tag = '$tag' "; // Get User RFID
    $get = mysqli_query($connect, $query);
    $data = array();
    while ($row = mysqli_fetch_assoc($get)) {
        $data[] = $row;
    }
    $userId = $data[0]['user_id'];
    $userName = $data[0]['user_name'];
    $userStatus = $data[0]['user_status'];
    $userDetailId = $data[0]['users_detail_id'];

    if (mysqli_num_rows($getHw) > 0) { // Cek Keberadaan Hardware
        if (mysqli_num_rows($get) > 0) { // Cek Keberadaan Users
            if ($hardwareWs == "active"){ // Cek Keaktifan WL di Hardware
                checkUserInDeviceWhiteList($userId, $hwCode, $userName, $hardwareId); // Cek Keberadaan User di WL
            }
            if ($userStatus == "active") { // Cek Keaktifan Kartu / Users
                
                checkSessionAgo($hwCode, $hardwareId, $userName, $userDetailId, $hwType); // Cek Sesi yg Sudah ada

            } else {
                set_response(false, "Access blocked", $userName); 
                addLogSystem($userName, $hardwareId, "Access Blocked");
            }
        } else {
            set_response(false, "Unregistered Card", $tag);
            addLogSystem($tag, $hardwareId, "Unregistered Card");
        }
    } else {
        set_response(false, "Unregistered Hardware", $hwCode);
    }
} else {
    set_response(false, "Card Not Detected", "NONE");
}

function addLogSystem($tagName, $hwId, $prm){
    global $connect, $dateTime;
    $query_log = "INSERT INTO log_system (log_id, log_datetime, log_desc, log_status, hw_id) VALUES (NULL, '".$dateTime."', '".$tagName." mencoba akses kartu', '".$prm."', '".$hwId."')";
    $get_log = mysqli_query($connect, $query_log);
}

function addRecordAccess($TimeIn, $TimeOut, $rDuration, $uDetailId, $hwId, $lastDur){
    global $connect, $hwType;

    if ($lastDur == "0"){
        $q_recUpdate = "UPDATE `record_access` SET `record_access_out` = '$TimeOut', `record_access_duration` = '$rDuration', `record_access_device_type` = '$hwType' 
        WHERE `users_detail_id` = '$uDetailId' AND `hw_id` = '$hwId' ORDER BY `record_access_id` DESC LIMIT 1";
        $get_reqUpdate = mysqli_query($connect, $q_recUpdate);
    } else {
        $q_recAccess = "INSERT INTO `record_access` (`record_access_id`, `record_access_in`, `record_access_out`, `record_access_duration`, `record_access_device_type`, `users_detail_id`, `hw_id`) 
        VALUES (NULL, '".$TimeIn."', '".$TimeOut."', '".$rDuration."', '".$hwType."', '".$uDetailId."', '".$hwId."')";
        $get_recAccess = mysqli_query($connect, $q_recAccess);
    }

}

function diffAccessDuration($sTime1, $fTime1){ // Fungsi menghitung rentang in to out
    $sTime = strtotime($sTime1);
    $fTime = strtotime($fTime1);
    $diff = $fTime - $sTime;
    $jam = floor($diff / (60 * 60));
    $menit = $diff - ( $jam * (60 * 60) );
    $detik = $diff % 60;
    $tDiff =  $jam." Jam ".floor($menit/60)." Menit ".$detik." Detik";
    return $tDiff;
}

function checkUserInDeviceWhiteList($usId, $hwId, $userName, $hardwareId){ // Fungsi cek WL
    global $connect, $dateTime;
    $query_cul2 = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `whitelist_device_users` WHERE `hw_id`='$hwId' AND `user_id`='$usId'");
    $count_cul2 = $query_cul2->fetch_array();
    $jumlahRow = $count_cul2['jumlah'];

    $showData = array("ID User"=>$usId, "ID Device"=>$hwId);
    if ($jumlahRow < 1){
        set_response(false, "Access for this card is restricted", $showData);
        addLogSystem($userName, $hardwareId, "Access Restricted");
        exit;
    } else {
        return "OK";
    }
}

function checkSessionAgo($hwCode, $hardwareId, $userName, $userDetailId, $hardwareType){
    global $connect, $dateTime;
    //Get Custom Additional
    $queryGS = "SELECT `r`.`record_access_id`, `r`.`record_access_in`, `r`.`record_access_out`, `r`.`record_access_duration`, `r`.`record_access_device_type`, `h`.`hw_id`, `h`.`hw_name` 
                    FROM `record_access` `r` 
                    INNER JOIN `hw_rfid` `h` ON `r`.`hw_id` = `h`.`hw_id` 
                    WHERE `r`.`users_detail_id` = '" . $userDetailId . "' AND `r`.`record_access_duration` = '0' 
                    ORDER BY `r`.`record_access_id` DESC LIMIT 1"; // AND `r`.`record_access_duration` = '0' 
    $getGS = mysqli_query($connect, $queryGS);
    $dataGS = array();
    while ($rowGS = mysqli_fetch_assoc($getGS)) {
        $dataGS[] = $rowGS;
    }

    if (mysqli_num_rows($getGS) > 0) { // Cek Keberadaan Sesi Lama
        
        $rId = $dataGS[0]['record_access_id'];
        $rIn = $dataGS[0]['record_access_in'];
        $rOut = $dataGS[0]['record_access_out'];
        $rDur =  $dataGS[0]['record_access_duration'];
        $rHwT = $dataGS[0]['record_access_device_type'];
        $rHwId = $dataGS[0]['hw_id'];
        $rHwNm = $dataGS[0]['hw_name'];

        $lastIn = date('Y-m-d', strtotime($rIn));
        $accessDateNow = date('Y-m-d', strtotime($dateTime));
        $newDur = diffAccessDuration($rIn, $dateTime);
        // if ($rDur == "0") {}
        if ($hwCode != $rHwId) { // Jika KodeHW tidak sama
            set_response(false, "Access denied (Aktif di $rHwNm sejak $rIn )", $userName);
            addLogSystem($userName, $hardwareId, "Access Duplicate ($rHwNm)");
            exit();
        }
        if ($hardwareType == $rHwT){
            if ($hardwareType == "outside"){
                $q_outRe = "DELETE FROM `record_access` WHERE `record_access_id` = '".$rId."'";
                $get_outRe = mysqli_query($connect, $q_outRe);
                addRecordAccess($dateTime, "0", "0", $userDetailId, $hardwareId, "1");
                set_response(true, "Re-access granted ($hardwareType)", $hardwareType);
                addLogSystem($userName, $hardwareId, "Re-access Granted ($hardwareType)");
            }
            exit();
        }

        if ($lastIn != $accessDateNow) { // Jika Last Dur 0 dan tanggal akses berbeda
            set_response(false, "Clear session success", $userName);
            addLogSystem($userName, $hardwareId, "Access Denied (Clear Session)");
            addRecordAccess($rIn, $dateTime, $newDur, $userDetailId, $hardwareId, $rDur);
        } else {
            set_response(true, "Access granted", $userName); //show column data
            addLogSystem($userName, $hardwareId, "Access Granted");
            addRecordAccess($rIn, $dateTime, $newDur, $userDetailId, $hardwareId, $rDur);
        }
        
    } else {
        if ($hardwareType == "outside"){
            set_response(true, "Access granted", $userName); 
            addLogSystem($userName, $hardwareId, "Access Granted");
            addRecordAccess($dateTime, "0", "0", $userDetailId, $hardwareId, "1");
        } else {
            set_response(true, "Re-access granted ($hardwareType)", $userName); 
            addLogSystem($userName, $hardwareId, "Access Granted ($hardwareType)");
        }
    }
}

?>