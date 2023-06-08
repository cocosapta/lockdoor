<?php

if (isset($_GET['data'])) {
  $id_account_detail = $_GET['data'];
  $_SESSION['id_account_detail'] = $id_account_detail;

  $jsonEditAcc = json_decode(_getAccountWebById($id_account_detail), TRUE);
  $isSuc = $jsonEditAcc['isSuccess'];
  // $msg = $jsonEditAcc['message'];

  if ($isSuc) {
    $nm = $jsonEditAcc['data']['name'];
    $em = $jsonEditAcc['data']['email'];
    $ph = $jsonEditAcc['data']['phone'];
    $add = $jsonEditAcc['data']['address'];
    $lev = $jsonEditAcc['data']['level'];
    $img = $jsonEditAcc['data']['image'];
    $uName = $jsonEditAcc['data']['username'];
    $uPass = "";
  } else {
    $nm = "";
    $em = "";
    $ph = "";
    $add = "";
    $lev = "";
    $img = "";
    $uName = "";
    $uPass = "";
  }

}

?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-edit"></i> Edit Akun Web</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="profil"> Akun Web</a></li>
          <li class="breadcrumb-item active"> Edit Akun Web</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <div class="card">
    <div class="card-header bg-dark">
      <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> &nbsp; <?php $id_account_detail ?> Form Edit Akun Web</h3>
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
        <?php if ($_GET['notif'] == "successUpdate") { ?>
          <div class="swalSuccess"></div>
        <?php } else if ($_GET['notif'] == "errorUpdate") { ?>
          <div class="swalError"></div>
        <?php } ?>
      <?php }  ?>
    </div>

    <form class="form-horizontal" method="post" action="konfirmasi-edit-account" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group row">
          <label for="foto" class="col-sm-12 col-form-label">
            <span class="text-info">
              <i class="fas fa-user-circle"></i> &nbsp; DATA AKUN </span></label>
        </div>

        <div class="form-group row">
          <label for="inputFotoFile05" class="col-sm-3 col-form-label">
            Foto Profil Baru (Opsional)</label>
          <div class="col-sm-7">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="inputFotoFile05" name="inputFotoFile05">
              <label class="custom-file-label" for="inputFotoFile05">Choose file</label>
            </div>
          </div><small>(Maks 512Kb)</small>
        </div>

        <div class="form-group row">
          <label for="name" class="col-sm-3 col-form-label">Nama</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $nm; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-7">
            <input type="email" class="form-control" name="email" id="email" value="<?php echo $em; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-sm-3 col-form-label">Nomor Telepon</label>
          <div class="col-sm-7">
            <input type="number" class="form-control" name="phone" id="phone" value="<?php echo $ph; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-sm-3 col-form-label">Alamat</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="address" id="address" value="<?php echo $add; ?>">
          </div>
        </div>
        
        <div class="form-group row">
          <label for="level" class="col-sm-3 col-form-label">Level</label>
          <div class="col-sm-7">
            <select class="form-control" name="level" id="level">
                <option value="Admin" <?php if( $lev == "Admin"){ ?> selected <?php } ?> > admin</option>
                <option value="Superadmin" <?php if( $lev == "Superadmin"){ ?> selected <?php } ?> > superadmin</option>
            </select>
          </div>
        </div>
          
        <div class="form-group row">
          <label for="uNames" class="col-sm-3 col-form-label">Username Login</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="uNames" id="uNames" value="<?php echo $uName; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="uPws" class="col-sm-3 col-form-label">Password Login</label>
          <div class="col-sm-7">
            <input type="password" class="form-control" name="uPws" id="uPws" placeholder="-Kosongi jika tidak ingin merubah-" value="<?php echo $uPass; ?>">
          </div>
        </div>

      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <div class="col-sm-12">
          <button name="simpanEditAkun" id="simpanEditAkun" type="submit" class="btn btn-success float-right">
            <i class="fas fa-save"></i> &nbsp; Simpan</button>
        </div>
      </div>
      <!-- /.card-footer -->
    </form>
  </div>
  <!-- /.card -->

</section>