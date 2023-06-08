<?php
// header("Content-Type: application/json");
// include_once('../config/config.php');

date_default_timezone_set('Asia/Jakarta');
$dateTime = date("Y-m-d H:i:s");

if (!empty($_GET['var1']) && !empty($_GET['var2'])) {

    $tag = $_GET['var1'];
    $hwCode = $_GET['var2'];

    $queryHw = "SELECT * FROM hw_rfid WHERE hw_id = '$hwCode' ";
    $getHw = mysqli_query($connect, $queryHw);
    $dataHw = array();
    while ($rowHw = mysqli_fetch_assoc($getHw)) {
        $dataHw[] = $rowHw;
    }

    $query = "SELECT * FROM users_rfid WHERE user_tag = '$tag' "; //AND user_status = 'active' ";
    $get = mysqli_query($connect, $query);
    $data = array();
    while ($row = mysqli_fetch_assoc($get)) {
        $data[] = $row;
    }

    $queryGS = "SELECT `a`.`access_datetime`, `a`.`access_session`, `a`.`hw_id`, `h`.`hw_name` 
                FROM `log_access` `a` 
                INNER JOIN `hw_rfid` `h` ON `a`.`hw_id` = `h`.`hw_id`
                WHERE users_detail_id = '".$data[0]['users_detail_id']."'
                ORDER BY `a`.`access_id` DESC LIMIT 1";
    $getGS = mysqli_query($connect, $queryGS);
    $dataGS = array();
    while ($rowGS = mysqli_fetch_assoc($getGS)) {
        $dataGS[] = $rowGS;
    }
    $acDt = $dataGS[0]['access_datetime'];
    $acSes = $dataGS[0]['access_session'];
    $acHwId =  $dataGS[0]['hw_id'];
    $acHwNm = $dataGS[0]['hw_name'];

    $lastTime = date('Y-m-d', strtotime($acDt));
    $accessTimeN = date('Y-m-d', strtotime($dateTime));

    if (mysqli_num_rows($getHw) > 0){
        if (mysqli_num_rows($get) > 0) {
            if ($data[0]['user_status'] == "active"){

                // if($acSes == "ON"){ //Belum Fix
                //     if ($hwCode != $acHwId){
                //         set_response(false, "Access denied (Sesi aktif di $acHwNm sejak $acDt )", $data[0]['user_name']); //show column data
                //         addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_name'], "Access Duplicate");
                //     } else if ($lastTime != $accessTimeN){
                //         set_response(false, "Access denied (clear session success)", $data[0]['user_name']); //show column data
                //         addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_name'], "Access Denied (Clear Session)");
                //         addLogAccess($dateTime, $data[0]['users_detail_id'], $dataHw[0]['hw_id'], $lastTime);
                //     }
                // } else {
                //     set_response(true, "Access granted", $data[0]['user_name']); //show column data
                //     addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_name'], "Access Granted");
                //     addLogAccess($dateTime, $data[0]['users_detail_id'], $dataHw[0]['hw_id'], $lastTime);
                // }

                if ($acSes == "ON" && $hwCode != $acHwId){
                    set_response(false, "Access denied (Sesi aktif di $acHwNm sejak $acDt )", $data[0]['user_name']); //show column data
                    addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_name'], "Access Duplicate");
                } else {
                    if ($acSes == "ON" && $lastTime != $accessTimeN){
                        set_response(false, "Access denied (clear session success)", $data[0]['user_name']); //show column data
                        addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_name'], "Access Denied (Clear Session)");
                        addLogAccess($dateTime, $data[0]['users_detail_id'], $dataHw[0]['hw_id'], $lastTime);
                    } else {
                        set_response(true, "Access granted", $data[0]['user_name']); //show column data
                        addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_name'], "Access Granted");
                        addLogAccess($dateTime, $data[0]['users_detail_id'], $dataHw[0]['hw_id'], $lastTime);
                    }
                }

            } else {
                set_response(false, "Access blocked", $data[0]['user_name']); //show column data
                addLogSystem($dateTime, $data[0]['user_name'], $dataHw[0]['hw_name'], "Access Blocked");
            }
        } else {
            set_response(false, "Unregistered Card", $data);
            addLogSystem($dateTime, $tag, $dataHw[0]['hw_name'], "Unregistered Card");
        }
    } else {
        set_response(false, "Unregistered Hardware", $data);
    }
    
} else {
    set_response(false, "Card Not Detected", "NONE");
}

function set_response($isSuccess, $message, $data){
    $result = array(
        "isSuccess" => $isSuccess,
        "message" => $message,
        // "data" => $data
    );
    echo json_encode($result);
}

function addLogSystem($dateTime, $tag, $hw, $prm){
    global $connect;
    $query_log = "INSERT INTO log_system (log_id, log_datetime, log_desc, log_status) VALUES (NULL, '".$dateTime."', '".$tag." mencoba akses kartu di ".$hw."', '".$prm."')";
    $get_log = mysqli_query($connect, $query_log);
}

function addLogAccess($dateTime, $uDetailId, $hw, $lastTime){
    global $connect;
    $accessTime = date('Y-m-d', strtotime($dateTime));

    $queryGetStat = "SELECT * FROM log_access 
                    WHERE users_detail_id = '$uDetailId' AND hw_id = '$hw' ORDER BY access_id DESC LIMIT 1"; //access_datetime LIKE '%$accessTime%' AND
    $getStat = mysqli_query($connect, $queryGetStat);
    $dataStat = array();
    while ($rowStat = mysqli_fetch_assoc($getStat)) {
        $dataStat[] = $rowStat;
    }

    if (mysqli_num_rows($getStat) > 0){
        if ($dataStat[0]['access_status'] == "In"){

            $sTime = strtotime($dataStat[0]['access_datetime']);
            $fTime = strtotime($dateTime);
            
            if ($lastTime == $accessTime){
                $accStat = "Out";
            } else {
                $accStat = "Out of Session";
            //     $accDur = 0;
            //     $accSession = "ON";
            //     $accDurOver = diffAccessDuration($sTime, $fTime);
            //     offSession($uDetailId, $hw); //Tidak Diperlukan
            //     destroyLastSession($dateTime, $accDurOver, $dataStat[0]['access_datetime'], $uDetailId, $hw);
            }
            $accDur = diffAccessDuration($sTime, $fTime);
            $accSession = "OFF";
            offSession($uDetailId, $hw);

        } else {
            $accStat = "In";
            $accDur = 0;
            $accSession = "ON";
        }
    } else {
        $accStat = "In";
        $accDur = 0;
        $accSession = "ON";
    }
    $query_logAccess = "INSERT INTO log_access (access_id, access_datetime, access_status, access_duration, access_session, users_detail_id, hw_id) 
                        VALUES (NULL, '".$dateTime."', '".$accStat."', '".$accDur."', '".$accSession."', '".$uDetailId."', '".$hw."')";
    $get_logAccess = mysqli_query($connect, $query_logAccess);
}

// function destroyLastSession($dateTime, $accDur, $dateLast, $uDetailId, $hw){
//     global $connect;

//     $query_logAccessD = "INSERT INTO log_access (access_id, access_datetime, access_status, access_duration, access_session, users_detail_id, hw_id) VALUES (NULL, '".$dateTime."', 'Out44', '".$accDur."', 'OFF', '".$uDetailId."', '".$hw."')";
//     $get_logAccessD = mysqli_query($connect, $query_logAccessD);
    
//     $query_offSesD = "UPDATE log_access SET access_session = 'OFF' WHERE access_status = 'In' AND users_detail_id = '$uDetailId' AND hw_id = '$hw' AND access_datetime LIKE '$dateLast'";
//     $get_offSes = mysqli_query($connect, $query_offSesD);

// }

function offSession($uDetailId, $hw){
    global $connect;

    $query_offSes = "UPDATE log_access SET access_session = 'OFF' 
                    WHERE access_status = 'In' AND users_detail_id = '$uDetailId' AND hw_id = '$hw' ORDER BY access_id DESC LIMIT 1";
    $get_offSes = mysqli_query($connect, $query_offSes);
}

function diffAccessDuration($sTime, $fTime){
    $diff = $fTime - $sTime;
    $jam = floor($diff / (60 * 60));
    $menit = $diff - ( $jam * (60 * 60) );
    $detik = $diff % 60;
    // if ($jam > 23){
    //     $tDiff = "Over Time";
    // } else {
        $tDiff =  $jam." Jam ".floor($menit/60)." Menit ".$detik." Detik";
    // }
    return $tDiff;
}

?>