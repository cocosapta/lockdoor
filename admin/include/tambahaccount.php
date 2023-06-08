<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-plus"></i> Tambah Akun Web</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="user">Data Akun Web</a></li>
          <li class="breadcrumb-item active">Tambah Akun Web</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <div class="card">
    <div class="card-header bg-dark">
      <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> &nbsp; Form Tambah Akun Web</h3>
      <div class="card-tools">
        <a href="accounts" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
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

    <form class="form-horizontal" method="POST" action="konfirmasi-tambah-account" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group row">
          <label for="inputFotoFile04" class="col-sm-12 col-form-label"><span class="text-info"><i class="fas fa-user-circle"></i> &nbsp; DATA AKUN</span></label>
        </div>
        <div class="form-group row">
          <label for="inputFotoFile04" class="col-sm-3 col-form-label">Foto Profil (Wajib)</label>
          <div class="col-sm-7">
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="inputFotoFile04" id="inputFotoFile04">
              <label class="custom-file-label" for="inputFotoFile04">Choose file</label>
            </div>
          </div><small>(Maks 512Kb)</small>
        </div>
        <div class="form-group row">
          <label for="inputNm" class="col-sm-3 col-form-label">Nama</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="inputNm" id="inputNm" value="" placeholder="Masukan nama akun" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEm" class="col-sm-3 col-form-label">E-mail</label>
          <div class="col-sm-7">
            <input type="email" class="form-control" name="inputEm" id="inputEm" value="" placeholder="Masukan email akun" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputNum" class="col-sm-3 col-form-label">No Telepon</label>
          <div class="col-sm-7">
            <input type="number" class="form-control" name="inputNum" id="inputNum" value="" placeholder="Masukan nomor telepon akun" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputAddrs" class="col-sm-3 col-form-label">Alamat</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="inputAddrs" id="inputAddrs" value="" placeholder="Masukan alamat akun" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputLev" class="col-sm-3 col-form-label">Level</label>
          <div class="col-sm-7">
            <select class="form-control" name="inputLev" id="inputLev">
                <option value="Admin">admin</option>
                <option value="Superadmin">superadmin</option>
            </select>
          </div>
        </div>
        <div class="col-sm-12">
          <button type="submit" name="simpanTambahAkun" id="simpanTambahAkun" class="btn btn-success float-right"><i class="fas fa-plus"></i> &nbsp; Tambah</button>
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