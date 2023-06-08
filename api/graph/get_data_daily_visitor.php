<?php
$datenowf = date("Y-m-d");
$hourNow = date("H:i");
$showData = array();
$to = $datenowf;
$from = date ("Y-m-d", strtotime("-1 week", strtotime($to)));

while (strtotime($from) < strtotime($to)) {
    $gDay = getDayFromDate($to);

    $qCountD = $connect->query("SELECT COUNT(`record_access_id`) AS `jumlah`FROM `record_access` WHERE `record_access_in` LIKE '%$to%'");
    $countDA = $qCountD->fetch_array();
    if ($countDA['jumlah'] != 0) {
        $contentDA = $countDA['jumlah'];
    } else {
        $contentDA = "0";
    }
    // echo  '"' . $contentDA . '",';
    $showData[] = array("day"=>$gDay, "count"=>$contentDA);
    $to = date("Y-m-d", strtotime("-1 day", strtotime($to)));
}

function getDayFromDate($date){
    $day = date('w', strtotime($date));
    switch ($day) {
        case "1":
            return "Senin";
            break;
        case "2":
            return "Selasa";
            break;
        case "3":
            return "Rabu";
            break;
        case "4":
            return "Kamis";
            break;
        case "5":
            return "Jumat";
            break;
        case "6":
            return "Sabtu";
            break;
        case "0":
            return "Minggu";
            break;
        default:
            return 0;
    }
}

set_response(true, "Data found", $showData);

?>