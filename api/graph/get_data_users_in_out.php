<?php
$datenowf = date("Y-m-d");

$sTime = $_POST['sTime'];
$fTime = $_POST['fTime'];
$tDesc = $_POST['status'];
$showDataA = array();
$showDataB = array();
$label = "";

if ($tDesc == 1){
    // $xCstmIn = mysqli_query($connect, "SELECT DISTINCT DATE_FORMAT(record_access_in, '%H') AS waktu FROM record_access WHERE record_access_in BETWEEN '$sTime' AND '$fTime' ORDER BY record_access_in ASC");
    $yCstmIn = mysqli_query($connect, "SELECT DISTINCT DATE_FORMAT(record_access_in, '%H') AS waktu, DATE(record_access_in) AS tanggal FROM record_access WHERE record_access_in BETWEEN '$sTime' AND '$fTime' ORDER BY record_access_in ASC");
    // $xCstmOut = mysqli_query($connect, "SELECT DISTINCT DATE_FORMAT(record_access_out, '%H') AS waktu FROM record_access WHERE record_access_out BETWEEN '$sTime' AND '$fTime' ORDER BY record_access_out ASC");
    $yCstmOut = mysqli_query($connect, "SELECT DISTINCT DATE_FORMAT(record_access_out, '%H') AS waktu, DATE(record_access_out) AS tanggal FROM record_access WHERE record_access_out BETWEEN '$sTime' AND '$fTime' ORDER BY record_access_out ASC");

    while ($row = mysqli_fetch_assoc($yCstmIn)) {
        // $dtime = substr($rowX['waktu'], 11);
        // $showDataX[] = $dtime;
        $xContent = $row['waktu'].":00";
        $dateHour = $row['tanggal'] . " " . $row['waktu'];

        $sumUAI = $connect->query("SELECT COUNT(record_access_in) AS nilai FROM record_access  WHERE record_access_in LIKE '%$dateHour%'");
        $datasumuai = $sumUAI->fetch_array();
        $yContent = $datasumuai['nilai'];

        // $ = mysqli_query($connect, "");
        // while ($ = mysqli_fetch_array($sumUAI)) {
        //     $ = $datasumuai['nilai'];
        //     echo  '"' . $yContent . '",';
        // }
        $showDataA[] = array("time_in" => $xContent, "date_in" => $row['tanggal'], "count"=>$yContent);
        // $showData[] = array("day"=>$gDay, "count"=>$contentDA);
    }
    while ($row2 = mysqli_fetch_assoc($yCstmOut)) {
        // $dtime = substr($rowX['waktu'], 11);
        // $showDataX[] = $dtime;
        $xContentO = $row2['waktu'].":00";
        $dateHourO = $row2['tanggal'] . " " . $row2['waktu'];

        $sumUAO = $connect->query("SELECT COUNT(record_access_out) AS nilai FROM record_access  WHERE record_access_out LIKE '%$dateHourO%'");
        $datasumuao = $sumUAO->fetch_array();
        $yContentO = $datasumuao['nilai'];
        
        $showDataB[] = array("time_out" => $xContentO, "date_out" => $row2['tanggal'], "count"=>$yContentO);
    }
    $label = "Waktu Akses (Pukul)";
    
} else {
    // $xCstmIn = mysqli_query($connect, "SELECT DISTINCT DATE(record_access_in) AS waktu FROM record_access WHERE record_access_in BETWEEN '$sTime' AND '$fTime' ORDER BY record_access_id");
    $yCstmIn = mysqli_query($connect, "SELECT DISTINCT DATE(record_access_in) AS waktu FROM record_access WHERE record_access_in BETWEEN '$sTime' AND '$fTime' ORDER BY record_access_id");
    // $xCstmOut = mysqli_query($connect, "SELECT DISTINCT DATE(record_access_out) AS waktu FROM record_access WHERE record_access_out BETWEEN '$sTime' AND '$fTime' ORDER BY record_access_id");
    $yCstmOut = mysqli_query($connect, "SELECT DISTINCT DATE(record_access_out) AS waktu FROM record_access WHERE record_access_out BETWEEN '$sTime' AND '$fTime' ORDER BY record_access_id");

    while ($row = mysqli_fetch_assoc($yCstmIn)) {
        $xContent = date("d-m-Y", strtotime($row['waktu']));
        $dateN = $row['waktu'];

        $sumUAI2 = $connect->query("SELECT COUNT(record_access_in) AS nilai FROM record_access  WHERE record_access_in LIKE '%$dateN%'");
        $datasumuai2 = $sumUAI2->fetch_array();
        $yContent = $datasumuai2['nilai'];

        $showDataA[] = array("time_in" => $xContent, "count" => $yContent);
    }
    while ($row2 = mysqli_fetch_assoc($yCstmOut)) {
        
        $xContentO = date("d-m-Y", strtotime($row2['waktu']));
        $dateNO = $row2['waktu'];
        $sumUAO2 = $connect->query("SELECT COUNT(record_access_out) AS nilai FROM record_access  WHERE record_access_out LIKE '%$dateNO%'");
        $datasumuao2 = $sumUAO2->fetch_array();
        $yContentO = $datasumuao2['nilai'];

        $showDataB[] = array("time_out" => $xContentO, "count" => $yContentO);
    }
    $label = "Tanggal Akses";
}

set_responseInOut(true, "Data found", $label, $showDataA, $showDataB);

function set_responseInOut($isSuccess, $message, $label, $dataA, $dataB){
    $result = array(
        "isSuccess" => $isSuccess,
        "message" => $message,
        "label" => $label,
        "data_in" => $dataA,
        "data_out" => $dataB
    );
    echo json_encode($result);
}

?>