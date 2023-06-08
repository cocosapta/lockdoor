<?php
$datenowf = date("Y-m-d");
$hourNow = date("H:i");

// while ($timeZero < strtotime($hourNow) - 3600) {
//     $timeZero += 3600;
//     $time = date('H:i', $timeZero);
//     // echo  '"' . $time . '",';
// }

$baseQUIR = "SELECT `record_access_id`, `record_access_in`, `record_access_out`, `record_access_duration`, `users_detail_id` FROM `record_access` WHERE `record_access_in` LIKE '%$datenowf%' OR `record_access_out` LIKE '%$datenowf%'";

$showData = array();
$timeZero = strtotime('00:00');
while ($timeZero < strtotime($hourNow)-3600){
    $timeZero += 3600;
    $time = date('H', $timeZero);
    $dtFull = $datenowf." ".$time.":00:00";
    $dtPiece = $datenowf." ".$time;
    $qUIR = $connect->query("SELECT COUNT(record_access_id) AS jumlah FROM ($baseQUIR) var 
    WHERE `record_access_in` <= '$dtFull' AND `record_access_out` >= '$dtFull' 
    OR `record_access_in` LIKE '%$dtPiece%' AND `record_access_out` LIKE '%$dtPiece%' 
    OR `record_access_in` LIKE '%$dtPiece%' AND `record_access_out` >= '$dtFull' 
    OR `record_access_in` <= '$dtFull' AND `record_access_out` LIKE '%$dtPiece%' 
    OR `record_access_in` <= '$dtFull' AND `record_access_out` = '0000-00-00 00:00:00' 
    OR `record_access_in` LIKE '%$dtPiece%' AND `record_access_out` = '0000-00-00 00:00:00'
    ");
    $countUIR = $qUIR->fetch_array();
    $yContentUIR = $countUIR['jumlah'];
    // echo  '"'.$yContentUIR.'",';
    $timeHour = date('H:i', $timeZero);
    $showData[] = array("time"=>$timeHour, "count"=>$yContentUIR);
}

set_response(true, "Data found", $showData);

?>