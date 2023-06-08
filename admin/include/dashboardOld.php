<?php
date_default_timezone_set('Asia/Jakarta');
$dateExport = date("d-m-Y");
$sTime = date('Y-m-d', strtotime($dateExport));
$fTime = date('Y-m-d', strtotime("+1 day", strtotime($dateExport)));
$tPeriode = "Hari ini";

if (isset($_POST["gofilter"])) {
  $awal = date('Y-m-d', strtotime($_POST["tanggalAwal"]));
  $akhir = date('Y-m-d', strtotime($_POST["tanggalAkhir"]));

  if ($awal > $akhir) {
    echo "<script>alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir !')</script>";
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

  $url = $baseUrlApi."get_data_panel_dashboard.php";
  $dataPanelDashboard = file_get_contents($url);
  $jsonPanelDashboard = json_decode($dataPanelDashboard, TRUE);

  $isSuc = $jsonPanelDashboard['isSuccess'];

  if ($isSuc == true){
    $usInRoom = $jsonPanelDashboard['usersInRoom'];
    $usActToday = $jsonPanelDashboard['usersActToday'];
    $usRegistered = $jsonPanelDashboard['registeredUsers'];
    $actToday = $jsonPanelDashboard['activityToday'];
  } else {
    $usInRoom = "Loading..";
    $usActToday = "Loading..";
    $usRegistered = "Loading..";
    $actToday = "Loading..";
  }

?>
<section class="content-header">
  <div class="container-fluid">

    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-user-tie"></i> Data Riwayat Akses</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Data Riwayat Akses</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <div class="row"> 
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?php echo $usInRoom; ?></h3>
          <p>Users in Room</p>
        </div>
        <div class="icon">
          <i class="ion">
          <ion-icon name="people-circle-outline"></ion-icon></i>
        </div>
        <a href="#" class="small-box-footer">More info &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner">
          <h3><?php echo $usActToday; ?><sup style="font-size: 20px"> </sup></h3>
          <p>Users Active Today</p>
        </div>
        <div class="icon">
          <i class="ion">
          <ion-icon name="airplane"></ion-icon></i>
        </div>
        <a href="#" class="small-box-footer">More info &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?php echo $usRegistered; ?></h3>
          <p>Registered Users</p>
        </div>
        <div class="icon">
          <i class="ion">
          <ion-icon name="person-add"></ion-icon></i>
        </div>
        <a href="#" class="small-box-footer">More info &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?php echo $actToday; ?></h3>
          <p>Activity Today</p>
        </div>
        <div class="icon">
          <i class="ion">
          <ion-icon name="stats-chart"></ion-icon></i>
        </div>
        <a href="#" class="small-box-footer">More info &nbsp; <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-history"></i>&nbsp;&nbsp;Riwayat Akses |<small> <?php echo $tPeriode ?></small></h3>
      <!-- <div class="card-tools">
        <a href="tambah-user" class="btn btn-sm btn-info float-right"><i class="fas fa-plus"></i> Tambah User</a>
      </div> -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <div class="clearfix"></div>
            <form action="dashboard" method="POST">
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
                    <button type="submit" class="btn-sm btn-success" id="gofilter" name="gofilter" title="Go Filter"><i class="fa fa-filter"></i> <small> GO </small></button>
                  </div>
                </div>
              </div><!-- .row -->
            </form>
          </div>
          <div class="x_content"></div>
          <div class="x_content">
            <div class="row">
              <div class="col-sm-12">
                <div class="card-box table-responsive">
                  <table class="table table-bordered table-hover table-sm" id="tableLogAccess">
                    <thead class="thead-light">
                      <tr>
                        <th>
                          <center>No</center>
                        </th>
                        <th>
                          <center>Tanggal</center>
                        </th>
                        <th>
                          <center>Pukul</center>
                        </th>
                        <th>
                          <center>Status Akses</center>
                        </th>
                        <th>
                          <center>Durasi</center>
                        </th>
                        <th>
                          <center>Nama</center>
                        </th>
                        <th>
                          <center>Pintu</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <!-- /.card -->

</section>