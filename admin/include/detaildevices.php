<?php
date_default_timezone_set('Asia/Jakarta');
$dateExport = date("d-m-Y");
$thisWeek = date("Y-m-d H:i:s");
$thisMonth = date("n");

$sTime = date('Y-m-d', strtotime($dateExport));
$fTime = date('Y-m-d', strtotime("+1 day", strtotime($dateExport)));
$tPeriode = "Hari ini";

$paneTabStatus1 = "active";
$paneTabStatus2 = "";
$paneTabStatus3 = "";
$paneTabStatus4 = "";
$paneTabStatus5 = "";

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

                                        if (isset($_GET['data'])) {
                                          $id_hw_detail = $_GET['data'];
                                          $_SESSION['id_hw_detail'] = $id_hw_detail;

                                          $jsonDtlDevice = json_decode(_getDeviceById($id_hw_detail), TRUE);
                                          $isSuc = $jsonDtlDevice['isSuccess'];
                                          $msg = $jsonDtlDevice['message'];

                                          if ($isSuc) {
                                            $id = $jsonDtlDevice['data']['detail'][0]['id'];
                                            $nama = $jsonDtlDevice['data']['detail'][0]['name'];
                                            $white = $jsonDtlDevice['data']['detail'][0]['whitelist_status'];
                                            $ket = $jsonDtlDevice['data']['detail'][0]['desc'];
                                          } else {
                                            ?><div class="swalInfoNotFound"></div><?php
                                                                                  include("includes/script.php");
                                                                                  exit();
                                                                                  // $id = "";
                                                                                  // $nama = "";
                                                                                  // $white = "";
                                                                                  // $ket = "";
                                                                                }

                                                                                $jsonActUser = json_decode(_getCountActivityById($id_hw_detail), TRUE);
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
        <h1>Detail Data Perangkat</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
          <li class="breadcrumb-item active">Detail Perangkat</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">

      <?php if (!empty($_GET['notif']) && !empty($_GET['jenis'])) { ?>
        <?php if ($_GET['notif'] == "empty" && $_GET['jenis'] == "maxsize" || $_GET['jenis'] == "notimage") {
          $paneTabStatus1 = "";
          $paneTabStatus4 = "active";
        ?>
          <div class="swalInfoImage"></div>
        <?php } else if ($_GET['notif'] == "empty") {
          $paneTabStatus1 = "";
          $paneTabStatus4 = "active";
        ?>
          <div class="swalWarningKosong"></div>
        <?php }
      } else if (!empty($_GET['notif'])) { ?>
        <?php if ($_GET['notif'] == "successUpdate") {
          $paneTabStatus1 = "";
          $paneTabStatus4 = "active";
        ?>
          <div class="swalSuccess"></div>
        <?php } else if ($_GET['notif'] == "errorUpdate") {
          $paneTabStatus1 = "";
          $paneTabStatus4 = "active";
        ?>
          <div class="swalError"></div>
        <?php } else if ($_GET['notif'] == "successDelete") {
          $paneTabStatus1 = "";
          $paneTabStatus5 = "active";
        ?>
          <div class="swalSuccess"></div>
        <?php } else if ($_GET['notif'] == "errorDelete") {
          $paneTabStatus1 = "";
          $paneTabStatus5 = "active";
        ?>
          <div class="swalError"></div>
        <?php } else if ($_GET['notif'] == "successCreate") {
          $paneTabStatus1 = "";
          $paneTabStatus5 = "active";
        ?>
          <div class="swalSuccess"></div>
        <?php } else if ($_GET['notif'] == "errorCreate") {
          $paneTabStatus1 = "";
          $paneTabStatus5 = "active";
        ?>
          <div class="swalError"></div>
        <?php } ?>
      <?php }  ?>

      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header bg-dark">
            <h3 class="card-title" style="margin-top:5px;"><i class="fab fa-usb"></i> &nbsp; Detail Perangkat</h3>
            <div class="card-tools">
              <a href="devices" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> &nbsp; Kembali</a>
            </div>
          </div>
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus1 ?>" href="#activity" data-toggle="tab">Aktivitas</a></li>
              <!-- <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus2 ?>" href="#current" data-toggle="tab">Arus Listrik</a></li> -->
              <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus3 ?>" href="#power" data-toggle="tab">Daya Listrik</a></li>
              <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus6 ?>" href="#powerUsage" data-toggle="tab">Pemakaian Listrik</a></li>
              <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus4 ?>" href="#editDetailPerangkat" data-toggle="tab">Edit</a></li>
              <?php if ($white == "active") { ?>
                <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus5 ?>" href="#whiteListPerangkat" data-toggle="tab">White List</a></li>
              <?php } ?>
            </ul>
          </div><!-- /.card-header -->

          <div class="card-body">
            <div class="tab-content">
              <div class="<?php echo $paneTabStatus1 ?> tab-pane" id="activity">
                <form action="device-details-<?php echo $id_hw_detail ?>" method="POST">
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
                <table class="table table-bordered table-hover table-sm" id="tableDetailDevicesA">
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
                        <center>Pengguna</center>
                      </th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>

              <!-- /.tab-pane -->
              <div class="<?php echo $paneTabStatus2 ?> tab-pane" id="current">
                <div class="col-md-12">
                  <div class="card card-success">
                    <div class="card-header">
                      <h3 class="card-title">Grafik Arus Listrik | <small><?php echo $ket ?></small></h3>

                      <!-- <div class="card-tools">
                        <button type="button" class="btn btn-tool" title="unduh" id="btnDownloadChartUIR"><i class="fas fa-download"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                      </div> -->
                    </div>
                    <div class="card-body">
                      <div class="card-box table-responsive">
                        <!-- <canvas id="chartAirToday"></canvas> -->
                        <div id="responseContCurrent"></div>
                        <script>
                          var refreshId = setInterval(function() {
                            $('#responseContCurrent').load('data/dataRealtimeCurrent.php?var1=<?php echo $id_hw_detail; ?>');
                          }, 1000);
                        </script>

                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>

                  <!-- /.card -->

                </div>
              </div>
              <div class="<?php echo $paneTabStatus3 ?> tab-pane" id="power">
                <div class="col-md-12">
                  <div class="card card-danger">
                    <div class="card-header">
                      <h3 class="card-title">Grafik Daya Listrik | <small><?php echo $ket ?></small></h3>

                      <!-- <div class="card-tools">
                        <button type="button" class="btn btn-tool" title="unduh" id="btnDownloadChartUIR"><i class="fas fa-download"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                      </div> -->
                    </div>
                    <div class="card-body">
                      <div class="card-box table-responsive">
                        <!-- <canvas id="chartAirToday"></canvas> -->
                        <div id="responseContPower"></div>
                        <script>
                          var refreshId = setInterval(function() {
                            $('#responseContPower').load('data/dataRealtimePower.php?var1=<?php echo $id_hw_detail; ?>');
                          }, 1000);
                        </script>

                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>

                  <!-- /.card -->

                </div>
              </div>

              <div class="<?php echo $paneTabStatus6 ?> tab-pane" id="powerUsage">
                <div class="col-md-12">

                  <div class="x_content">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="card card-success">
                          <div class="card-header">
                            <h3 class="card-title">Statistik Konsumsi Daya | 7 Hari Terakhir</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" title="Unduh" id="btnDownloadChartPU"><i class="fas fa-download"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="chart">
                              <canvas id="chartPowerUsage"></canvas>
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="card card-success">
                          <div class="card-header">
                            <h3 class="card-title">Statistik Konsumsi Daya | Bulanan <?php echo date("Y");?></h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" title="Unduh" id="btnDownloadChartPUM"><i class="fas fa-download"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="chart">
                              <canvas id="chartPowerUsageMonthly"></canvas>
                            </div>
                          </div>
                          <!-- /.card-body -->
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="<?php echo $paneTabStatus4 ?> tab-pane" id="editDetailPerangkat">
                <form method="POST" action="konfirmasi-edit-perangkat" enctype="multipart/form-data" class="form-horizontal">
                  <!-- <div class="form-group row">
                    <label for="inputFotoFile02" class="col-sm-2 col-form-label">Foto (Opsional)</label>
                    <div class="col-sm-9">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputFotoFile02" name="inputFotoFile02">
                        <label class="custom-file-label" for="inputFotoFile02">Choose file</label>
                      </div>
                    </div><small>(Maks 512Kb)</small>
                  </div> -->
                  <div class="form-group row">
                    <label for="inputNim" class="col-sm-2 col-form-label">ID Perangkat</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputIdp" id="inputIdp" value="<?php echo $id; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputNama" class="col-sm-2 col-form-label">Nama Perangkat</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputNama" id="inputNama" value="<?php echo $nama; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputKet" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="inputKet" id="inputKet" value="<?php echo $ket; ?>" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="whiteList" class="col-sm-2 col-form-label">White List</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="whiteList" id="whiteList">
                        <option value="active" <?php if ($white == "active") { ?> selected <?php } ?>> Active</option>
                        <option value="deactive" <?php if ($white == "deactive") { ?> selected <?php } ?>> Deactive</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> &nbsp; Simpan</button>
                    </div>
                  </div>
                </form>
              </div>

              <div class="<?php echo $paneTabStatus5 ?> tab-pane" id="whiteListPerangkat">
                <a href="#" id="idAddWhiteList" class="btn btn-sm btn-info float-right view_dataUsersWhite"><i class="fas fa-plus"></i> &nbsp; Tambah </a>
                <br><br>

                <div id="dataUsersWhiteModal" class="modal fade">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Daftar Pengguna</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body" id="dataUsersWhite">

                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" id="dataUsersWhiteModal" class="btn btn-info view_dataUsersWhite"><i class="fas fa-sync-alt"></i>&nbsp; Refresh</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Post -->
                <table class="table table-bordered table-hover table-sm" id="tableDetailDevicesA">
                  <thead class="thead-light">
                    <tr>
                      <th>
                        <center>No</center>
                      </th>
                      <th>
                        <center>NIM</center>
                      </th>
                      <th>
                        <center>Nama</center>
                      </th>
                      <th>
                        <center>Kelas</center>
                      </th>
                      <th>
                        <center>Opsi</center>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $nonums = 1;
                    foreach ($jsonDtlDevice['data']['whitelist'] as $valueWl) {
                    ?>
                      <tr>
                        <td><?php echo $nonums++; ?></td>
                        <td><?php echo $valueWl['nim']; ?></td>
                        <td><a href="user-details-<?php echo $valueWl['id_user']; ?>"><?php echo $valueWl['name']; ?></a></td>
                        <td><?php echo $valueWl['class']; ?></td>
                        <td>
                          <center><a href='confirm-delete-whitelist=<?php echo $valueWl['id_whitelist']; ?>' class='btn-danger btn-sm'> Hapus </a></center>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.tab-pane -->

              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->

      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-success card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <!-- <img class="profile-user-img img-fluid img-circle" src="media/foto/<?php echo $foto; ?>" alt="User profile picture"> -->
            </div>
            <h3 class="profile-username text-center"><?php echo $nama; ?></h3>
            <p class="text-muted text-center"><?php echo $ket; ?></p>

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
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title">Data Sensor</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <strong><i class="fas fa-signal mr-1"></i>
              <h3 id="respStat" class="float-right"> </h3>
            </strong>

            <hr>
            <strong><i class="fas fa-plug mr-1"></i> Daya Listrik (Watt)</strong>
            <h3 id="responsePower2" class="float-right">0</h3>
            <hr>
            <strong><i class="fas fa-bolt mr-1"></i> Arus Listrik (Ampere)</strong>
            <h3 id="responseCurrent2" class="float-right">0</h3>
            <hr>
          </div>
          <script>
            var refreshId = setInterval(function() {
              $('#responseCurrent2').load('data/dataRealtimeCurrent2.php?var1=<?php echo $id_hw_detail; ?>');
              $('#responsePower2').load('data/dataRealtimePower2.php?var1=<?php echo $id_hw_detail; ?>');
              $('#respStat').load('data/dataRealtimeStatus.php?var1=<?php echo $id_hw_detail; ?>');
            }, 2000);
          </script>

          <!-- /.card -->

        </div>

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->