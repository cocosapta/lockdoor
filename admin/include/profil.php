<?php
$id_user = $_SESSION['id_user_54'];
//get profil

$jsonDetail = json_decode(_getProfileDetails($id_user), TRUE);

$isSuc = $jsonDetail['isSuccess'];
// $msg = $jsonDetail['message'];

if ($isSuc == true) {
  $nama = $jsonDetail['data']['name'];
  $email = $jsonDetail['data']['email'];
  $phone = $jsonDetail['data']['phone'];
  $address = $jsonDetail['data']['address'];
  $foto = $jsonDetail['data']['image'];
  $levProfile = $jsonDetail['data']['level'];
} else {
  $nama = "Loading..";
  $email = "Loading..";
  $phone = "Loading..";
  $address = "Loading..";
  $foto = "avatarLoading.png";
  $levProfile = "Loading..";
}

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-user-tie"></i> Profil</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Profil</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="card">
    <div class="card-header">
      <div class="card-tools">
        <a href="change-password" class="btn btn-tool bg-info"><i class="fas fa-user-lock"></i>&nbsp; Ubah Password</a> &nbsp;
        <a href="profile-update" class="btn btn-tool bg-info"><i class="fas fa-edit"></i>&nbsp; Edit Profil</a>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="col-sm-12">

        <?php if (!empty($_GET['notif'])) {
          if ($_GET['notif'] == "successUpdate") { ?>
              <div class="swalSuccess"></div>
          <?php } else if ($_GET['notif'] == "errorUpdate") { ?>
              <div class="swalError"></div>
          <?php } else if ($_GET['notif'] == "successUpdatePassword") { ?>
              <div class="swalSuccess"></div>
          <?php } else if ($_GET['notif'] == "errorUpdatePassword") { ?>
              <div class="swalError"></div>
          <?php } ?>
        <?php } ?>

      </div>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td colspan="2"><i class="fas fa-user-circle"></i>
              <strong>&nbsp; PROFIL<strong>
            </td>
          </tr>
          <tr>
            <td width="20%"><strong>&nbsp; Foto Profil<strong></td>
            <td width="80%">&nbsp;<img src="<?php echo $baseUrlMedia; ?>foto/<?php echo $foto; ?>" id="imgcstm" class="img-fluid" width="200px;"></td>
          </tr>
          <tr>
            <td width="20%"><strong>&nbsp; Nama<strong></td>
            <td width="80%">&nbsp;<?php echo $nama; ?></td>
          </tr>
          <tr>
            <td width="20%"><strong>&nbsp; E-mail<strong></td>
            <td width="80%">&nbsp;<?php echo $email; ?></td>
          </tr>
          <tr>
            <td width="20%"><strong>&nbsp; No HP<strong></td>
            <td width="80%">&nbsp;<?php echo $phone; ?></td>
          </tr>
          <tr>
            <td width="20%"><strong>&nbsp; Alamat<strong></td>
            <td width="80%">&nbsp;<?php echo $address; ?></td>
          </tr>
          <tr>
            <td width="20%"><strong>&nbsp; Level<strong></td>
            <td width="80%">&nbsp;<?php echo $levProfile; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">&nbsp;</div>
  </div>
  <!-- /.card -->

</section>