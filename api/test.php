<?php
date_default_timezone_set('Asia/Jakarta'); // set zona waktu di indo untuk php

// $konRelay1 = "MATI"; // misal untuk lampu
// $konRelay2 = "MATI"; // misal untuk kipas

function loop(){

        $getSuhu = getSuhuDariSensor(); // ambil suhu dari fungsi
        $getJam = getJamDariRTC(); // ambil jam dari fungsi

        if ($getJam >= 17 && $getJam <= 24 || $getJam >= 0 && $getJam <= 5){
            $konRelay1 = "HIDUP";
        } else {
            $konRelay1 = "MATI";
        }
        //-----------------------------------------------------------------------------
        if ($getSuhu > 24){
            $konRelay2 = "HIDUP";
        } else {
            $konRelay2 = "MATI";
        }
        sendHttpToApi($getJam, $getSuhu, $konRelay1, $konRelay2); //panggil fungsi untuk mengirim ke api
        sleep(1); // ini sama dengan delay 1 detik

}

function sendHttpToApi($jam, $suhu, $konRelay1, $konRelay2){ // anggap ini kodingan untuk ngirim ke api
    echo "Jam : ".$jam." | Kondisi Lampu : ".$konRelay1." /// Suhu : ".$suhu." | Kondisi Kipas : ".$konRelay2."\n"; // ini println di arduinoIDE
}

function getSuhuDariSensor(){ // anggap ini get suhu dari sensor
    $suhu = rand(21, 27); //contoh saja ini random
    return $suhu;
}

function getJamDariRTC(){ // anggap ini get jam dari RTC
    $jam = date("H"); // ambil jam dari rtc
    // $jam = rand(0, 24); //ini kalau misal mau ambil jam random
    return $jam;
}

//kode dibawah ini hanya untuk php
while (1 < 2){
    loop();
}
?>