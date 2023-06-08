<?php
// date_default_timezone_set('Asia/Jakarta');
if (!empty($_GET['data'])) {
$dateExport = date("d-m-Y");
$thisWeek = date("Y-m-d H:i:s");
$thisMonth = date("n");

$sTime = date('Y-m-d', strtotime($dateExport));
$fTime = date('Y-m-d', strtotime("+1 day", strtotime($dateExport)));
$tPeriode = "Hari ini";

$paneTabStatus1 = "active";
$paneTabStatus2 = "";
$paneTabStatus3 = "";

if (isset($_POST["gofilter"])) {
  $awal = date('Y-m-d', strtotime($_POST["tanggalAwal"]));
  $akhir = date('Y-m-d', strtotime($_POST["tanggalAkhir"]));

  if ($awal > $akhir) {
    // echo "<script>alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir !')</script>";
    ?><div class="swalWarningFilterDate"></div><?php
  } else {
    $sTime = date('Y-m-d', strtotime($_POST["tanggalAwal"]));
    $fTime = date('Y-m-d', strtotime("+1 day", strtotime($_POST["tanggalAkhir"])));
    if ($_POST["tanggalAwal"] == $_POST["tanggalAkhir"]) {
      $tPeriode = $_POST["tanggalAwal"];
    } else {
      $tPeriode = $_POST["tanggalAwal"] . " hingga " . $_POST["tanggalAkhir"];
    }
  }
}

$uName = "-";
$uTag = "-";
$uStat = "blocked";

if (isset($_GET['data'])) {
  $id_user_detail = $_GET['data'];
  $_SESSION['id_users_detail'] = $id_user_detail;

  $jsonDtlUser = json_decode(_getUserById($id_user_detail), TRUE);
  $isSuc = $jsonDtlUser['isSuccess'];
  $msg = $jsonDtlUser['message'];

  if ($isSuc) {
    $nim = $jsonDtlUser['data']['nim'];
    $nama = $jsonDtlUser['data']['name'];
    $email = $jsonDtlUser['data']['email'];
    $kelas = $jsonDtlUser['data']['class'];
    $phone = $jsonDtlUser['data']['phone'];
    $address = $jsonDtlUser['data']['address'];
    $foto = $jsonDtlUser['data']['image'];
    $uRId = $jsonDtlUser['data']['rid'];
    $uName = $jsonDtlUser['data']['username'];
    $uTag = $jsonDtlUser['data']['card'];
    $uStat = $jsonDtlUser['data']['status'];
  } else {
    ?><div class="swalInfoNotFound"></div><?php
    include("includes/script.php");
    exit();
    // $nim = "";
    // $nama = "";
    // $email = "";
    // $kelas = "";
    // $phone = "";
    // $address = "";
    // $foto = "";
    // $uRId = "";
    // $uName = "";
    // $uTag = "";
    // $uStat = "";
  }

  $jsonActUser = json_decode(_getCountActivityById($id_user_detail), TRUE);
  $isSuc = $jsonActUser['isSuccess'];
  // $msg = $jsonActUser['message'];

  if ($isSuc) {
    $actToday = $jsonActUser['data']['today'];
    $actThisWeek = $jsonActUser['data']['week'];
    $actThisMonth = $jsonActUser['data']['month'];
    $actAllTime = $jsonActUser['data']['all'];
  } else {
    $actToday = $jsonActUser['data']['today'];
    $actThisWeek = $jsonActUser['data']['week'];
    $actThisMonth = $jsonActUser['data']['month'];
    $actAllTime = $jsonActUser['data']['all'];
  }

}
?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Detail Data Pengguna</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
          <li class="breadcrumb-item active">Detail Pengguna</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-success card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" src="<?php echo $baseUrlMedia; ?>foto/<?php echo $foto; ?>" alt="foto pengguna">
            </div>
            <h3 class="profile-username text-center"><?php echo $nama; ?></h3>
            <p class="text-muted text-center"><?php echo $nim; ?></p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Aktivitas Hari Ini</b> <a class="float-right"><?php echo $actToday; ?></a>
              </li>
              <li class="list-group-item">
                <b>Aktivitas Minggu Ini</b> <a class="float-right"><?php echo $actThisWeek; ?></a>
              </li>
              <li class="list-group-item">
                <b>Aktivitas Bulan Ini</b> <a class="float-right"><?php echo $actThisMonth; ?></a>
              </li>
              <li class="list-group-item">
                <b>Aktivitas Total</b> <a class="float-right"><?php echo $actAllTime; ?></a>
              </li>
            </ul>
            <?php if (!empty($uStat) && $uStat == "active") {
              $radBtn1 = "dark";
              $radBtn2 = "light";
              $radCh1 = "checked";
              $radCh2 = ""; ?>
              <a href="" class="btn btn-success btn-block" readonly><b>Akses Aktif</b></a>
            <?php } else {
              $radBtn1 = "light";
              $radBtn2 = "dark";
              $radCh1 = "";
              $radCh2 = "checked"; ?>
              <a href="" class="btn btn-danger btn-block" readonly><b>Akses Block</b></a>
            <?php } ?>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Biodata</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <strong><i class="fas fa-key mr-1"></i> Nick Name</strong>
            <p class="text-muted"><?php echo $uName; ?></p>
            <hr>
            <strong><i class="fas fa-envelope mr-1"></i> E-mail</strong>
            <p class="text-muted"><?php echo $email; ?></p>
            <hr>
            <strong><i class="fas fa-phone mr-1"></i> No Telepon</strong>
            <p class="text-muted"><?php echo $phone; ?></p>
            <hr>
            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
            <p class="text-muted"><?php echo $address; ?></p>
            <hr>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      
        <?php if (!empty($_GET['notif']) && !empty($_GET['jenis'])) { ?>
          <?php if ($_GET['notif'] == "empty" && $_GET['jenis'] == "maxsize" || $_GET['jenis'] == "notimage") { 
          $paneTabStatus1 = "";
          $paneTabStatus3 = "active";
          ?>
            <div class="swalInfoImage"></div>
          <?php } else if ($_GET['notif'] == "empty") { 
          $paneTabStatus1 = "";
          $paneTabStatus3 = "active";
          ?>
            <div class="swalWarningKosong"></div>
        <?php }
        } else if (!empty($_GET['notif'])) { ?>
          <?php if ($_GET['notif'] == "successUpdate") { 
          $paneTabStatus1 = "";
          $paneTabStatus3 = "active";
          ?>
            <div class="swalSuccess"></div>
          <?php } else if ($_GET['notif'] == "errorUpdate") { 
          $paneTabStatus1 = "";
          $paneTabStatus3 = "active";
          ?>
            <div class="swalError"></div>
          <?php } ?>
        <?php }  ?>
      
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header bg-dark">
            <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-users"></i> &nbsp; Detail Pengguna</h3>
            <div class="card-tools">
              <a href="users" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> &nbsp; Kembali</a>
            </div>
          </div>
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus1 ?>" href="#activity" data-toggle="tab">Aktivitas</a></li>
              <!-- <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus2 ?>" href="#statistikPengguna" data-toggle="tab">Statistik</a></li> -->
              <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus3 ?>" href="#editDetailPengguna" data-toggle="tab">Edit</a></li>
            </ul>
          </div><!-- /.card-header -->

          <div class="card-body">
            <div class="tab-content">
              <div class="<?php echo $paneTabStatus1 ?> tab-pane" id="activity">
                <form action="user-details-<?php echo $id_user_detail; ?>" method="POST">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input type="text" placeholder="dd-mm-yyyy" class="form-control form-control-sm datepicker" id="tanggal_awal" name="tanggalAwal" value="<?php echo date('d-m-Y', strtotime($sTime)); ?>" autocomplete="off" required />
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="text" placeholder="dd-mm-yyyy" class="form-control form-control-sm datepicker" id="tanggal_akhir" name="tanggalAkhir" value="<?php echo date('d-m-Y', strtotime("-1 day", strtotime($fTime))); ?>" autocomplete="off" required />
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="gofilter" style="color:transparent">:</label><br>
                        <button type="submit" class="btn-sm btn-success" id="gofilter" name="gofilter" title="Go Filter"><i class="fa fa-filter"></i></button>
                      </div>
                    </div>
                  </div><!-- .row -->
                </form>
                <!-- Post -->
                <table class="table table-bordered table-hover table-sm" id="tableDetailUsersAccess">
                  <thead class="thead-light">
                    <tr>
                      <th>
                        <center>No</center>
                      </th>
                      <th>
                        <center>Waktu Masuk</center>
                      </th>
                      <th>
                        <center>Waktu Keluar</center>
                      </th>
                      <th>
                        <center>Durasi</center>
                      </th>
                      <th>
                        <center>Ruang</center>
                      </th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
              <!-- /.tab-pane -->
              <div class="<?php echo $paneTabStatus2 ?> tab-pane" id="statistikPengguna">
                <form action="user-details-<?php echo $id_user_detail; ?>" method="POST">
                  <label>Feature is still under development</label>
                </form>
                <!-- Post -->
                
              </div>
              <!-- /.tab-pane -->

              <div class="<?php echo $paneTabStatus3 ?> tab-pane" id="editDetailPengguna">
                <form method="POST" action="konfirmasi-edit-pengguna" enctype="multipart/form-data" class="form-horizontal">
                  <div class="form-group row">
                    <label for="inputFotoFile02" class="col-sm-2 col-form-label">Foto (Opsional)</label>
                    <div class="col-sm-9">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputFotoFile02" name="inputFotoFile02">
                        <label class="custom-file-label" for="inputFotoFile02">Choose file</label>
                      </div>
                    </div><small>(Maks 512Kb)</small>
                  </div>
                  <div class="form-group row">
                    <label for="inputNim" class="col-sm-2 col-form-label">NIM</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="inputNim" id="inputNim" value="<?php echo $nim; ?>" <?php if ($_SESSION['level_54'] != "Superadmin") { ?>readonly<?php } ?> required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputNama" id="inputNama" value="<?php echo $nama; ?>" <?php if ($_SESSION['level_54'] != "Superadmin") { ?>readonly<?php } ?> required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputKelas" class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputKelas" id="inputKelas" value="<?php echo $kelas; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">E-mail</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="inputEmail" id="inputEmail" value="<?php echo $email; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputTelepon" class="col-sm-2 col-form-label">No Telepon</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="inputTelepon" id="inputTelepon" value="<?php echo $phone; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputAlamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputAlamat" id="inputAlamat" value="<?php echo $address; ?>" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputUserName" class="col-sm-2 col-form-label">User Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputUserName" id="inputUserName" value="<?php echo $uName; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputTag" class="col-sm-2 col-form-label">No Kartu RFID</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputTag" id="inputTag" value="<?php echo $uTag; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputUserStatus" class="col-sm-2 col-form-label">Status Kartu</label>
                    <div class="col-sm-10">
                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn bg-<?php echo $radBtn1; ?>">
                          <input type="radio" name="inputUserStatus" id="option_b1" value="active" autocomplete="off" <?php echo $radCh1; ?>> Active
                        </label>
                        <label class="btn bg-<?php echo $radBtn2; ?>">
                          <input type="radio" name="inputUserStatus" id="option_b2" value="block" autocomplete="off" <?php echo $radCh2; ?>> Block
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button name="simpanEditUser" id="simpanEditUser" type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> &nbsp; Simpan</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
          <?php } ?>