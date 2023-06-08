<?php
// header("Content-Type: application/json");
// include_once('../config/config.php');
// date_default_timezone_set('Asia/Jakarta');
// $dateTime = date("Y-m-d H:i:s");

if (!empty($_GET['var1']) && !empty($_GET['var2']) && !empty($_GET['var3'])) {

    $hwCode = $_GET['var1'];
    $amps = $_GET['var2'];
    $watt = $_GET['var3'];
    // $volts = $_GET['var4'];

    $queryHw = "SELECT * FROM `hw_rfid` WHERE `hw_id` = '$hwCode' ";
    $getHw = mysqli_query($connect, $queryHw);
    $dataHw = array();
    while ($rowHw = mysqli_fetch_assoc($getHw)) {
        $dataHw[] = $rowHw;
    }

    $showData = array ("code" => $hwCode);
    if (mysqli_num_rows($getHw) > 0){
        addSensorData(myDateTimeGenerator(), $amps, $watt, $hwCode);
    } else {
        set_response(false, "Unregistered Hardware", $showData);
    }
    
} else {
    set_response(false, "Body request is not complete", []);
}

function addSensorData ($dateTime, $valA, $valB, $hwCode){
    global $connect, $databaseHost, $databaseName, $databaseUsername, $databasePassword;
    try {
    $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $databaseUsername, $databasePassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($valA < 0){ // arus Ampere
        $valA = 0;
    }
    if ($valB < 0){ // daya Watt
        $valB = 0;
    }
    // if ($valC < 0){ // tegangan Volt
    //     $valC = 0;
    // }
    $valC = $valB / 1800;

    $q_addSCD = "INSERT INTO `sensor_current_data` (`sensor_current_id`, `sensor_current_datetime`, `sensor_current_value_a`, `sensor_current_value_b`, `sensor_current_value_c`, `hw_id`) 
    VALUES (NULL, '".$dateTime."', '".$valA."', '".$valB."', '".$valC."', '".$hwCode."')";
    // $set_addSCD = mysqli_query($connect, $q_addSCD);

    $qgdes = $connect->query("SELECT `hw_emergency` AS `status` FROM `hw_rfid` WHERE `hw_id` = '".$hwCode."'");
    $ggdes = $qgdes->fetch_array();
    $desStatus = $ggdes['status'];

    $conn->exec($q_addSCD);
    
    $showData = array ("current" => $valA, "power" => $valB, "power/sec" => $valC, "DES"=>$desStatus);
    set_response(true, "Sensor data sent successfully", $showData);
  } catch (PDOException $e) {
    set_response(false, $q_addSCD." ".$e->getMessage(), []);
  }
  
}

?>