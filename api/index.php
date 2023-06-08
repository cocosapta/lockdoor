<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include('config-api/configApi.php');

// if (!empty($_SERVER['HTTP_TOKEN'])) {
//   if ($_SERVER['HTTP_TOKEN'] == $serverToken) {

    if (isset($_GET["reqpg"])) {
      $include = $_GET["reqpg"];
      if ($include == "dashboard-panel") { // Data Panel Dashboard
        include("dashboard/get_data_panel_dashboard.php");
      } 
      else if ($include == "record-access") { // Tabel Riwayat Akses
        include("access/index.php");
      } 
      else if ($include == "accessOld") { // Checkin Alat RFID
        include("users/get_existence_user.php");
      } else if ($include == "access") { // Checkin Alat RFID
        include("users/get_ex_uservtwo.php");
      } 
      else if ($include == "current-sensor") { // Sensor Alat ACS
        include("current/input_sensor_current.php");
      } else if ($include == "acs") { // Sensor Alat ACS
        include("current/index.php");
      } 
      else if ($include == "profil") { // Login Web Admin
        include("profile/account_login.php");
      } else if ($include == "profil-image") { // Upload Foto Profil / Akun
        include("profile/file_upload.php");
      } else if ($include == "password") { // Cek dan Ubah Password
        include("profile/password_profile.php");
      } 
      else if ($include == "log-system") { // Tabel Log System
        include("log/ajax_log_system.php");
      } 
      else if ($include == "accounts") { // Tabel List Akun Web
        include("accounts/ajax_list_accounts.php");
      } else if ($include == "account") { // CRUD Akun
        include("accounts/index.php");
      } 
      else if ($include == "users") { // Tabel List Pengguna
        include("users/ajax_list_users.php");
      } else if ($include == "user") { // CRUD Pengguna
        include("users/index.php");
      } 
      else if ($include == "devices") { // Tabel List Pengguna
        include("devices/ajax_list_devices.php");
      } else if ($include == "device") { // CRUD Pengguna
        include("devices/index.php");
      } 
      else if ($include == "activity") { // Data Panel Aktivitas
        include("activity/index.php");
      } 
      else if ($include == "graph") { // Data Grafik
        include("graph/index.php");
      } 
      else if ($include == "white-list") { // Data Daftar Putih Device
        include("whitelist/index.php");
      } 
      else {
          $result = array(
              "isSuccess" => false,
              "message" => "API Not Found",
              "code" => 404
          );
          echo json_encode($result);
      }
    }

//   } else {
//     set_response(false, "Wrong token", []);
//   }
// } else {
//   set_response(false, "Require tokens", []);
// }

function set_response($isSuccess, $message, $data){
  $result = array(
      "isSuccess" => $isSuccess,
      "message" => $message,
      "data" => $data
  );
  echo json_encode($result);
}
?>