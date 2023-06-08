<?php
date_default_timezone_set('Asia/Jakarta');
$dateExport = date("d-m-Y");

if ((isset($_GET['aksi'])) && (isset($_GET['data']))) {
  if ($_GET['aksi'] == 'hapus') {
    $id_user = $_GET['data'];

    $sql_gui = "SELECT `users_detail_image` FROM `users_detail` WHERE `users_detail_id`='$id_user'"; //Get Gambar
    $query_gui = mysqli_query($connect, $sql_gui);
    $jumlah_gui = mysqli_num_rows($query_gui);
    if ($jumlah_gui > 0) {
      while ($data_gui = mysqli_fetch_row($query_gui)) {
        $foto = $data_gui[0];
        unlink("media/foto/$foto"); //Menghapus Gambar
      }
    }

    $sql_durf = "DELETE FROM `users_rfid` WHERE `users_detail_id` = '$id_user'"; //Hapus User RFID
    mysqli_query($connect, $sql_durf);

    $sql_dud = "DELETE FROM `users_detail` WHERE `users_detail_id` = '$id_user'"; //Hapus User RFID
    mysqli_query($connect, $sql_dud);


  }
}

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-user-tie"></i> Data Pengguna</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active"> Data Pengguna</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="card">
    <div class="card-header bg-dark">
      <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-users"></i> &nbsp; Data Pengguna</h3>
      <div class="card-tools">
        <a href="add-user" class="btn btn-sm btn-light bg-light float-right"><i class="fas fa-plus"></i> &nbsp; Tambah Pengguna</a>
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
        <table class="table table-striped table-bordered table-sm" id="tableUsers">
          <thead>
            <tr>
              <th>
                <center>No</center>
              </th>
              <th>
                <center>Nomor Induk</center>
              </th>
              <th>
                <center>Nama</center>
              </th>
              <th>
                <center>Kelas</center>
              </th>
              <th>
                <center>Ijin Akses</center>
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