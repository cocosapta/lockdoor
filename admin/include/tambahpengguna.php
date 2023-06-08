<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-plus"></i> Tambah Pengguna</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="users">Data Pengguna</a></li>
          <li class="breadcrumb-item active">Tambah Pengguna</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <div class="card">
    <div class="card-header bg-dark">
      <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> &nbsp; Form Tambah Pengguna</h3>
      <div class="card-tools">
        <a href="users" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
      </div>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    </br>
    
    <div class="col-sm-10">
      <?php if ((!empty($_GET['notif'])) && (!empty($_GET['jenis']))) { ?>
        <?php if ($_GET['notif'] == "empty" && $_GET['jenis'] == "maxsize" || $_GET['jenis'] == "notimage") { ?>
          <div class="swalInfoImage"></div>
        <?php } else if ($_GET['notif'] == "empty") { ?>
          <div class="swalWarningKosong"></div>
        <?php } ?>
      <?php } else if (!empty($_GET['notif'])) { ?>
        <?php if ($_GET['notif'] == "successCreate") { ?>
          <div class="swalSuccess"></div>
        <?php } else if ($_GET['notif'] == "errorCreate") { ?>
          <div class="swalError"></div>
        <?php } ?>
      <?php }  ?>
    </div>
    <form class="form-horizontal" method="POST" action="konfirmasi-tambah-pengguna" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group row">
          <label for="inputFotoFile03" class="col-sm-12 col-form-label"><span class="text-info"><i class="fas fa-user-circle"></i> &nbsp; DATA PENGGUNA</span></label>
        </div>
        <div class="form-group row">
          <label for="inputFotoFile03" class="col-sm-3 col-form-label">Foto &nbsp; (Wajib)</label>
          <div class="col-sm-7">
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="inputFotoFile03" id="inputFotoFile03">
              <label class="custom-file-label" for="inputFotoFile03">Choose file</label>
            </div>
          </div><small>(Maks 512Kb)</small>
        </div>
        <div class="form-group row">
          <label for="inputNim" class="col-sm-3 col-form-label">NIM</label>
          <div class="col-sm-7">
            <input type="number" class="form-control" name="inputNim" id="inputNim" value="" placeholder="Masukan nim / identitas pengguna" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputNama" class="col-sm-3 col-form-label">Nama</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="inputNama" id="inputNama" value="" placeholder="Masukan nama pengguna" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputKelas" class="col-sm-3 col-form-label">Kelas</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="inputKelas" id="inputKelas" value="" placeholder="Masukan kelas pengguna" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEmail" class="col-sm-3 col-form-label">E-mail</label>
          <div class="col-sm-7">
            <input type="email" class="form-control" name="inputEmail" id="inputEmail" value="" placeholder="Masukan email pengguna" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputTelepon" class="col-sm-3 col-form-label">No Telepon</label>
          <div class="col-sm-7">
            <input type="number" class="form-control" name="inputTelepon" id="inputTelepon" value="" placeholder="Masukan nomor telepon pengguna" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputAlamat" class="col-sm-3 col-form-label">Alamat</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="inputAlamat" id="inputAlamat" value="" placeholder="Masukan alamat pengguna" required>
          </div>
        </div>

        <div class="col-sm-12">
          <button name="simpanTambahPengguna" id="simpanTambahPengguna" type="submit" class="btn btn-success float-right"><i class="fas fa-plus"></i> &nbsp; Tambah</button>
        </div>
        <!-- <div class="form-group row">
          <label for="uStatus" class="col-sm-3 col-form-label">Level</label>
          <div class="col-sm-7">
            <select class="form-control" name="uStatus">
                <option value="active" selected>Active</option>
                <option value="block" >Block</option>
            </select>
          </div>
        </div> -->

      </div>
  </div>

  </div>
  <!-- /.card-body -->
  <div class="card-footer">
  </div>
  <!-- /.card-footer -->
  </form>
  </div>
  <!-- /.card -->

</section>