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

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-user-tie"></i> Data Log Sistem</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Data Log Sistem</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="card card-dark">
    <div class="card-header">
      <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-history"></i>&nbsp;&nbsp;Log Sistem |<small> <?php echo $tPeriode ?></small></h3>
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
            <form action="logs" method="POST">
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
                  <!-- <script type="text/javascript">
                    $(document).ready(function() {
                      $('#tableV2').DataTable({
                        "columnDefs": [{
                          "className": "dt-center",
                          "targets": "_all"
                        }],
                        
                        "columns": [{
                            "data": "no"
                          },
                          {
                            "data": "date"
                          },
                          {
                            "data": "time"
                          },
                          {
                            "data": "height"
                          },
                        ]
                      });
                    });
                  </script> -->
                  <table class="table table-striped table-bordered table-sm" id="tableLogSystem">
                    <thead>
                      <tr>
                        <th><center>No</center></th>
                        <th><center>Tanggal</center></th>
                        <th><center>Pukul</center></th>
                        <th><center>Deskripsi</center></th>
                        <th><center>Status</center></th>
                        <th><center>Lokasi</center></th>
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