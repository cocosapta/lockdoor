<?php
if (isset($_SESSION['id_user_54'])) {
  $id_user = $_SESSION['id_user_54'];

  $jsonEditProfil = json_decode(_getProfileDetails($id_user), TRUE);
  $isSuc = $jsonEditProfil['isSuccess'];
  // $msg = $jsonEditProfil['message'];

  if ($isSuc == true) {
    $nm = $jsonEditProfil['data']['name'];
    $em = $jsonEditProfil['data']['email'];
    $ph = $jsonEditProfil['data']['phone'];
    $adrs = $jsonEditProfil['data']['address'];
    $lev3 = $jsonEditProfil['data']['level'];
  } else {
    $nm = "Loading..";
    $em = "Loading..";
    $ph = "Loading..";
    $adrs = "Loading..";
    $lev3 = "Loading..";
  }

}

?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-edit"></i> Edit Profil</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="profile"> Profil</a></li>
          <li class="breadcrumb-item active"> Edit Profil</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <div class="card">
    <div class="card-header bg-dark">
      <h3 class="card-title" style="margin-top:5px;"><i class="far fa-list-alt"></i> &nbsp; Form Edit Profil</h3>
      <div class="card-tools">
        <a href="profile" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
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

    <form class="form-horizontal" method="post" action="konfirmasi-edit-profile" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group row">
          <label for="foto" class="col-sm-12 col-form-label">
            <span class="text-info">
              <i class="fas fa-user-circle"></i> &nbsp; DATA PROFIL LOGIN </span></label>
        </div>

        <div class="form-group row">
          <label for="inputFotoFile01" class="col-sm-3 col-form-label">
            Foto Profil Baru (Opsional)</label>
          <div class="col-sm-7">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="inputFotoFile01" name="inputFotoFile01">
              <label class="custom-file-label" for="inputFotoFile01">Choose file</label>
            </div>
          </div><small>(Maks 512Kb)</small>
        </div>

        <!-- <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
          </div>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose a file</label>
          </div>
        </div> -->

        <div class="form-group row">
          <label for="nama" class="col-sm-3 col-form-label">Nama</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $nm; ?>">
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
            <input type="text" class="form-control" name="address" id="address" value="<?php echo $adrs; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-sm-3 col-form-label">Level</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="level" id="level" readonly value="<?php echo $lev3; ?>">
          </div>
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <div class="col-sm-12">
          <button type="submit" name="simpanEditProfile" id="simpanEditProfile" class="btn btn-success float-right">
            <i class="fas fa-save"></i> &nbsp; Simpan</button>
        </div>
      </div>
      <!-- /.card-footer -->
    </form>
  </div>
  <!-- /.card -->

</section>