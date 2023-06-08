<?php
// date_default_timezone_set('Asia/Jakarta');
$dateExport = date("d-m-Y");

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-user-tie"></i> Data Alat</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active"> Data Alat</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="card">
    <div class="card-header bg-dark">
      <h3 class="card-title" style="margin-top:5px;"><i class="fab fa-usb"></i> &nbsp; Data Perangkat</h3>
      <div class="card-tools">
        <a href="add-device" class="btn btn-sm btn-light bg-light float-right"><i class="fas fa-plus"></i> &nbsp; Tambah Perangkat</a>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="col-md-12">
        <div class="col-sm-12">

          <?php if (!empty($_GET['notif'])) {
            if ($_GET['notif'] == "successCreate") { ?>
                <div class="swalSuccess"></div>
            <?php } else if ($_GET['notif'] == "errorCreate") { ?>
                <div class="swalError"></div>
            <?php } else if ($_GET['notif'] == "successDelete") { ?>
                <div class="swalSuccess"></div>
            <?php } else if ($_GET['notif'] == "errorDelete") { ?>
                <div class="swalError"></div>
            <?php } else if ($_GET['notif'] == "successUpdate") { ?>
                <!-- <div class="swalSuccess"></div> -->
            <?php } else if ($_GET['notif'] == "errorUpdate") { ?>
                <!-- <div class="swalError"></div> -->
            <?php } else if ($_GET['notif'] == "confirmDelete") { ?>
                <div class="swalConfirmDelete"></div>
            <?php } ?>
          <?php } ?>

        </div>
        <br>
        <table class="table table-striped table-bordered table-sm" id="tableDevices">
          <thead>
            <tr>
              <th>
                <center>No</center>
              </th>
              <th>
                <center>Nama</center>
              </th>
              <th>
                <center>Keterangan</center>
              </th>
              <th>
                <center>Status</center>
              </th>
              <th width="25%">
                <center>Opsi</center>
              </th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>