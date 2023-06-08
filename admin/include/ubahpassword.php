<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-user-lock"></i> Ubah Password</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active"> Ubah Password</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <div class="card">
    <div class="card-header bg-dark">
      <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> &nbsp; Form Ubah Password</h3>

      <div class="card-tools">
        <a href="profile" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> &nbsp; Kembali</a>
      </div>
    </div>
    <!-- /.card-header -->
    <?php if (!empty($_GET['notif'])) { ?>
      <div class="swalWarningPass"></div>
    <?php } ?>
    <!-- form start -->
    <form class="form-horizontal" method="POST" action="konfirmasi-ubah-password">
      <div class="card-body">
        <h6>
          <i class="text-blue"><i class="fas fa-info-circle"></i> &nbsp; Masukkan password lama dan password baru anda untuk mengubah password.</i>
        </h6><br>

        <div class="form-group row">
          <label for="pass_lama" class="col-sm-3 col-form-label">Password Lama</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="pass_lama" name="pass_lama" value="">
          </div>
        </div>
        <div class="form-group row">
          <label for="pass_baru" class="col-sm-3 col-form-label">Password Baru</label>
          <div class="col-sm-7">
            <input type="password" class="form-control" id="pass_baru" name="pass_baru" value="">
          </div>
        </div>
        <div class="form-group row">
          <label for="konfirmasi" class="col-sm-3 col-form-label">Konfirmasi Password Baru</label>
          <div class="col-sm-7">
            <input type="password" class="form-control" id="konfirmasi_pass" name="konfirmasi_pass" value="">
          </div>
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> &nbsp; Simpan</button>
        </div>
      </div>
      <!-- /.card-footer -->
    </form>
  </div>
  <!-- /.card -->

</section>