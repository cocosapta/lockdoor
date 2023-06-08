<?php

$dateExport = date("d-m-Y");
$sTime = date('Y-m-d', strtotime($dateExport));
$fTime = date('Y-m-d', strtotime("+1 day", strtotime($dateExport)));
$tPeriode = "Hari ini";

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

$jsonPanelDashboard = json_decode(_getDataPanelDashboard(), TRUE);
$isSuc = $jsonPanelDashboard['isSuccess'];

if ($isSuc == true) {
  $usInRoom = $jsonPanelDashboard['inRoom'];
  $usActToday = $jsonPanelDashboard['usersOnToday'];
  $usRegistered = $jsonPanelDashboard['regUsers'];
  $actToday = $jsonPanelDashboard['actToday'];
} else {
  $usInRoom = "Error..";
  $usActToday = "Error..";
  $usRegistered = "Error..";
  $actToday = "Error..";
}

?>
<section class="content-header">
  <div class="container-fluid">

    <div class="row mb-2">
      <div class="col-sm-6">
        <h3></h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Dashboard</li>
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
        <div class="icon"><i class="ion"><ion-icon name="people-circle-outline"></ion-icon></i>
        </div>
        <div class="small-box-footer">
          <!-- <form action="test-dev" method="POST"> -->
            <button type="submit" name="" id="iddataUsersInRoom" class="btn-outline-success btn-sm view_dataUsersInRoom">More info &nbsp; <i class="fas fa-arrow-circle-right"></i></button>
          <!-- </form> -->
        </div>
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
            <ion-icon name="airplane"></ion-icon>
          </i>
        </div>
        <div class="small-box-footer">
          <!-- <form action="test-dev" method="POST"> -->
            <button type="submit" name="" id="iddataUsersActiveToday" class="btn-outline-primary btn-sm view_dataUsersActiveToday">More info &nbsp; <i class="fas fa-arrow-circle-right"></i></button>
          <!-- </form> -->
        </div>
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
            <ion-icon name="person-add"></ion-icon>
          </i>
        </div>
        <div class="small-box-footer">
          <!-- <form action="test-dev" method="POST"> -->
            <a href="users" ><button type="submit" name="" id="" class="btn-outline-danger btn-sm ">More info &nbsp; <i class="fas fa-arrow-circle-right"></i></button></a>
          <!-- </form> -->
        </div>
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
            <ion-icon name="stats-chart"></ion-icon>
          </i>
        </div>
        <div class="small-box-footer">
          <!-- <form action="test-dev" method="POST"> -->
            <a href="statistics"><button type="submit" name="" id="" class="btn-outline-warning btn-sm ">More info &nbsp; <i class="fas fa-arrow-circle-right"></i></button></a>
          <!-- </form> -->
        </div>
        <!-- <a href="#" class="small-box-footer">More info &nbsp; <i class="fas fa-arrow-circle-right"></i></a> -->
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
                  <table class="table table-bordered table-hover table-sm" id="tableRecAccess">
                    <thead class="thead-light">
                      <tr>
                        <th>
                          <center>No</center>
                        </th>
                        <th>
                          <center>Waktu In</center>
                        </th>
                        <th>
                          <center>Waktu Out</center>
                        </th>
                        <th>
                          <center>Durasi</center>
                        </th>
                        <th>
                          <center>Nama Pengguna</center>
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

  <div id="dataUsersInRoomModal" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pengguna di Ruangan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="dataUsersInRoom">

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" id="dataUsersInRoomModal" class="btn btn-info view_dataUsersInRoom"><i class="fas fa-sync-alt"></i>&nbsp; Refresh</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div id="dataUsersActiveTodayModal" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pengguna Aktif Hari Ini</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="dataUsersActiveToday">

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" id="dataUsersActiveTodayModal" class="btn btn-info dataUsersActiveToday"><i class="fas fa-sync-alt"></i>&nbsp; Refresh</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  

</section>