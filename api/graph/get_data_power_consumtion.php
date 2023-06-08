<?php
$dateOneWeekAgo = date('Y-m-d', strtotime("-6 day", strtotime(myDateTimeGenerator())));
$sqlPc = mysqli_query($connect, "SELECT DISTINCT DATE(sensor_current_datetime) AS `tanggal` 
    FROM `sensor_current_data` 
    WHERE `sensor_current_datetime` BETWEEN '".$dateOneWeekAgo."' AND '".myDateTimeGenerator()."' 
    ORDER BY `sensor_current_datetime`");

$idHwPc = "";
if (!empty($_GET['id'])) {
    $idHwPc = $_GET['id'];
} else {
    $idHwPc = "0";
}

$showDataDaily = array();
while ($rowPc = mysqli_fetch_assoc($sqlPc)) {
    $xDate = $rowPc['tanggal'];
    $showXDate = date("d-m-Y", strtotime($rowPc['tanggal']));

    $quePo = "SELECT SUM(sensor_current_value_c) AS `nilai`, COUNT(sensor_current_value_c) AS `countDetik` 
    FROM `sensor_current_data` 
    WHERE `sensor_current_datetime` LIKE '%" . $xDate . "%'";
    if ($idHwPc != "0"){
        $quePo .= " AND `hw_id` = '".$idHwPc."'";
    }
    $sumPo = $connect->query($quePo);


    $dataPo = $sumPo->fetch_array();
    $jumlahDaya = round($dataPo['nilai'], 4);
    $jumlahDetik = $dataPo['countDetik'] * 2;
    // $dayaPerJam = $jumlahDetik / 3600;

    $showDataDaily[] = array("date" => $showXDate, "powerUsage(wH)" => $jumlahDaya, "countSecond(s)" => $jumlahDetik);
}

$showDataMonthly = array();
for ($i=1; $i<=12; $i++){
    $xMonthName = mapToMonthSimple($i);
    $xYear = date("Y", strtotime(myDateTimeGenerator()));

    $quePoM = "SELECT SUM(sensor_current_value_c) AS `nilai` 
    FROM `sensor_current_data` 
    WHERE MONTH(sensor_current_datetime) = '".$i."' AND YEAR(sensor_current_datetime) = '".$xYear."'";
    if ($idHwPc != "0"){
        $quePoM .= " AND `hw_id` = '".$idHwPc."'";
    }
    $sumPoM = $connect->query($quePoM);

    $dataPoM = $sumPoM->fetch_array();
    $jumlahDayaPerBulan = round($dataPoM['nilai'], 4);

    $showDataMonthly[] = array("month" => $xMonthName, "year" => $xYear, "powerUsage(wH)" => $jumlahDayaPerBulan);

}

set_responsePowerConsume(true, "Data " . $idHwPc . " found", $dateOneWeekAgo." / ".myDateTimeGenerator(), $showDataDaily, $showDataMonthly);

function set_responsePowerConsume($isSuccess, $message, $dailyRange, $dailyUse, $WeeklyUse)
{
    $result = array(
        "isSuccess" => $isSuccess,
        "message" => $message,
        "dailyRange" => $dailyRange,
        "daily" => $dailyUse,
        "monthly" => $WeeklyUse
    );
    echo json_encode($result);
}

function mapToMonth($angkaBulan){
    $namaBulan = "";
    switch ($angkaBulan) {
        case 1:
            $namaBulan = "Januari";
        break;
        case 2:
            $namaBulan = "Februari";
        break;
        case 3:
            $namaBulan = "Maret";
        break;
        case 4:
            $namaBulan = "April";
        break;
        case 5:
            $namaBulan = "Mei";
        break;
        case 6:
            $namaBulan = "Juni";
        break;
        case 7:
            $namaBulan = "Juli";
        break;
        case 8:
            $namaBulan = "Agustus";
        break;
        case 9:
            $namaBulan = "September";
        break;
        case 10:
            $namaBulan = "Oktober";
        break;
        case 11:
            $namaBulan = "November";
        break;
        case 12:
            $namaBulan = "Desember";
        break;
        default:
            $namaBulan = "";
            break;
        break;
    }
    return $namaBulan;
}

function mapToMonthSimple($angkaBulan){
    $namaBulan = "";
    switch ($angkaBulan) {
        case 1:
            $namaBulan = "Jan";
        break;
        case 2:
            $namaBulan = "Feb";
        break;
        case 3:
            $namaBulan = "Mar";
        break;
        case 4:
            $namaBulan = "Apr";
        break;
        case 5:
            $namaBulan = "Mei";
        break;
        case 6:
            $namaBulan = "Jun";
        break;
        case 7:
            $namaBulan = "Jul";
        break;
        case 8:
            $namaBulan = "Agus";
        break;
        case 9:
            $namaBulan = "Sept";
        break;
        case 10:
            $namaBulan = "Okt";
        break;
        case 11:
            $namaBulan = "Nov";
        break;
        case 12:
            $namaBulan = "Des";
        break;
        default:
            $namaBulan = "";
            break;
        break;
    }
    return $namaBulan;
}
?>