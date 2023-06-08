<?php
$koneksi = mysqli_connect("localhost","sepk9647_parkeer_admin","ngakakkenceng","sepk9647_iot_esp_rfid");
// cek koneksi
if (!$koneksi){
    die("Error koneksi: " . mysqli_connect_errno());
} else {
    die("Koneksi Sukses");
}
