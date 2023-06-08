<?php
session_start();
include('../config/config.php');
// ob_start();
if (isset($_GET["include"])) {
  $include = $_GET["include"];
  if ($include == "konfirmasi-login") {//Fitur Login
    include("include/konfirmasilogin.php");
  } else if ($include == "konfirmasi-edit-profile") {//Edit Profil
    include("include/konfirmasieditprofil.php");
  } else if ($include == "konfirmasi-ubah-password") {//Ubah Password
    include("include/konfirmasiubahpassword.php");
  } else if ($include == "konfirmasi-tambah-pengguna") {//Tambah Pengguna
    include("include/konfirmasitambahpengguna.php");
  } else if ($include == "konfirmasi-edit-pengguna") {//Edit Pengguna
    include("include/konfirmasieditpengguna.php");
  } else if ($include == "confirm-delete-user") {//Hapus Pengguna
    include("include/konfirmasihapuspengguna.php");
  } else if ($include == "konfirmasi-tambah-perangkat") {//Tambah Perangkat
    include("include/konfirmasitambahdevices.php");
  } else if ($include == "konfirmasi-edit-perangkat") {//Edit Perangkat
    include("include/konfirmasieditdevices.php");
  } else if ($include == "confirm-delete-device") {//Hapus Perangkat
    include("include/konfirmasihapusperangkat.php");
  } else if ($include == "confirm-des-device") {//DES Perangkat
    include("include/konfirmasidesperangkat.php");
  } else if ($include == "konfirmasi-tambah-account") {//Tambah Akun Web
    include("include/konfirmasitambahaccount.php");
  } else if ($include == "konfirmasi-edit-account") {//Edit Akun web
    include("include/konfirmasieditaccounta.php");
  } else if ($include == "confirm-delete-account") {// Hapus Akun web
    include("include/konfirmasihapusaccount.php");
  } else if ($include == "confirm-add-whitelist") {// Tambah Whitelist
    include("include/konfirmasitambahdaftarputih.php");
  } else if ($include == "confirm-delete-whitelist") {// Hapus Whitelist
    include("include/konfirmasihapusdaftarputih.php");
  } else if ($include == "signout") {//Fitur Sign Out
    include("include/signout.php");
  } 
  // else if ($include == "konfirmasi-tambah-kategori-produk") {//Master Kategori Produk
  //   include("include/konfirmasitambahkategoriproduk.php");
  // } 
}
// ob_end_flush();
?>
<!DOCTYPE html>
<html>

<head>
  <?php include("includes/head.php") ?>
</head>

<?php
//cek ada get include
if (isset($_GET["include"])) {
  $include = $_GET["include"];
  //cek apakah ada session id admin
  if (isset($_SESSION['id_user_54'])) {
    //pemanggilan ke halaman-halaman menu admin
?>

    <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
        <?php include("includes/header.php"); ?>
        <?php include("includes/sidebar.php"); ?>
        <div class="content-wrapper">
          <?php
          if ($include == "profile-update") { //Edit Profil
            include("include/editprofil.php");
          } else if ($include == "dashboard") { //Dashboard
            include("include/dashboard.php");
          } else if ($include == "statistics") { //Statistik
            include("include/statistik.php");
          } else if ($include == "users") { //Pengguna
            include("include/pengguna.php");
          } else if ($include == "add-user") { //Tambah Pengguna
            include("include/tambahpengguna.php");
          } else if ($include == "user-details") { //Detail Pengguna
            include("include/detailpengguna.php");
          } else if ($include == "devices") { //Perangkat
            include("include/devices.php");
          } else if ($include == "add-device") { //Tambah Perangkat
            include("include/tambahdevices.php");
          } else if ($include == "device-details") { //Detail Perangkat
            include("include/detaildevices.php");
          } else if ($include == "change-password") { //Ubah Password
            include("include/ubahpassword.php");
          } else if ($include == "logs") { //Log
            include("include/logsistem.php");
          } else if ($include == "accounts") { //Akun Web
            include("include/account.php");
          } else if ($include == "add-account") { //Tambah Akun Web
            include("include/tambahaccount.php");
          } else if ($include == "account-update") { //Edit Akun Web
            include("include/editaccount.php");
          } else if ($include == "account-details") { //Detail Akun Web
            include("include/detailaccount.php");
          } else if ($include == "test-dev") { //Test Developer
            include("include/testdev.php");
          } 
          // else if ($include == "tambah-kategori-produk") {
          //   include("include/tambahkategoriproduk.php");
          // } 
          else {
            include("include/profil.php");
          }
          ?>
        </div>
        <!-- /.content-wrapper -->
        <?php include("includes/footer.php"); ?>
      </div>
      <!-- ./wrapper -->
      <?php include("includes/script.php"); ?>
    </body>
  <?php
  } else {
    //pemanggilan halaman form login
    include("include/login.php");
  }
} else {
  if (isset($_SESSION['id_user_54'])) {
    //pemanggilan ke halaman-halaman profil jika ada session
  ?>

    <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
        <?php include("includes/header.php"); ?>
        <?php include("includes/sidebar.php"); ?>
        <div class="content-wrapper">
          <?php
          //pemanggilan profil
          include("include/profil.php");
          ?>
        </div>
        <!-- /.content-wrapper -->
        <?php include("includes/footer.php"); ?>
      </div>
      <!-- ./wrapper -->
      <?php include("includes/script.php"); ?>
    </body>
<?php
  } else {
    //pemanggilan halaman form login
    include("include/login.php");
  }
}
?>

</html>