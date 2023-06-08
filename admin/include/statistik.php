<?php

date_default_timezone_set('Asia/Jakarta');
$dateExport = date("d-m-Y");

$sTime = date('Y-m-d', strtotime($dateExport));
$fTime = date('Y-m-d', strtotime("+1 day", strtotime($dateExport)));
$tPeriode = "Hari ini";
$tDesc = 1;

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
      $tDesc = 1;
    } else {
      $tPeriode = $_POST["tanggalAwal"] . " hingga " . $_POST["tanggalAkhir"];
      $tDesc = 2;
    }
  }
}
$jsonGetIn = json_decode(_getDataChartInOut($tDesc, $sTime, $fTime), TRUE);

?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-user-tie"></i> Data Statistik</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Data Statistik</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <!-- TTempat untuk Panel Dashboard -->

  <!-- <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-chart-line"></i>&nbsp;&nbsp; Data Statistik |<small> <?php echo $tPeriode ?></small></h3>
    </div>
    <div class="card-body">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <div class="clearfix"></div>
            <form action="statistik" method="POST">
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
              </div>
            </form>
          </div>
          <div class="x_content"></div>

        </div>
      </div>
    </div>
  </div> -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-chart-line"></i>&nbsp;&nbsp; Data Statistik Pengguna |<small> <?php echo $tPeriode ?></small></h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" title="unduh grafik masuk" id="btnDownloadChartUAI"><i class="fas fa-download"></i></button>
        <button type="button" class="btn btn-tool" title="unduh grafik keluar" id="btnDownloadChartUAO"><i class="fas fa-download"></i></button>
        <button type="button" class="btn btn-tool" title="minimize" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" title="remove" data-card-widget="remove"><i class="fas fa-times"></i></button>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <div class="clearfix"></div>
            <form action="statistics" method="POST">
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
          <div class="x_content">
            <div class="row">
              <div class="col-sm-6">
                <div class="card-box table-responsive">
                  <div class="card-box table-responsive">
                    <canvas id="chartUsersActivityIn"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="card-box table-responsive">
                  <div class="card-box table-responsive">
                    <canvas id="chartUsersActivityOut"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- /.card-body -->
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">

        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Statistik Jam Sibuk | Hari ini</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" title="unduh" id="btnDownloadChartUIR"><i class="fas fa-download"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="chartUsersInRoom"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col (LEFT) -->
      <div class="col-md-6">
        <!-- LINE CHART -->
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Statistik Kunjungan Harian</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" title="unduh" id="btnDownloadPieDaily"><i class="fas fa-download"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="chartDailyActivity" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <div class="col-md-6">
        <!-- LINE CHART -->
        <!-- <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Statistik Kunjungan Ruang</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="chartRoomActivity" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div> -->
        <!-- /.card -->

      </div>
      <!-- /.col (RIGHT) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  <!-- /.card -->


</section>