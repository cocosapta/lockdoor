<?php
date_default_timezone_set('Asia/Jakarta');

for ($x = 0; $x <= 10000; $x++) {
    $ampS = rand(1, 5);
    $wattS = rand(150, 250);

    // $ampS = 3;
    // $wattS = 20;
    $url = "http://localhost/ESP-RFID/api/current-sensor/hw=HW0101/a=".$ampS."/w=".$wattS;
    // $url2 = "http://localhost/ESP-RFID/api/current-sensor/hw=HW220316222257/a=".$a."/w=".$b."";
    $dataResponseLoop = file_get_contents($url);
    // $dataAccLogin2 = file_get_contents($url2);
    $jsonResponseLoop = json_decode($dataResponseLoop, TRUE);
    // $jsonAccLogin2 = json_decode($dataAccLogin2, TRUE);

    $isSuc = $jsonResponseLoop['isSuccess'];
    $msg = $jsonResponseLoop['message'];

    echo $ampS."/".$wattS."/$msg\n";
    echo "$url\n";
    sleep(2);
}

?>