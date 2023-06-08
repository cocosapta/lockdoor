<body id="bdlg" class="hold-transition login-page">
  <div class="login-box">
    <!-- <div class="login-logo"><img src="dist/img/stock.svg" alt="Logo" class="brand-image" style="opacity: .8; width:100px"><br>
      <strong><b>Admin</b> - Katalog Toko</strong>
    </div> -->
    <!-- /.login-logo -->
    <div id="cdbd" class="card" style="opacity: 85%;">
      <div class="card-body login-card-body">
        <center>
          <img src="<?php echo $baseUrlMedia; ?>icon/Logo_VokasiUB.png" alt="Logo" class="brand-image" style="opacity: .8; width:100px"><br>
          <h3>Smart Key System <br><small>Gedung Fakultas Vokasi Dieng</small></h3>
        </center><br>
        <!-- <h5>Gedung Fakuktas Vokasi Dieng</h5></center><br> -->
        <!-- <p class="login-box-msg">Sign In untuk mengakses halaman admin</p> -->

        <?php
        if (!empty($_GET['gagal'])) { ?>
          <span class="swalLogin"></span>
        <?php } ?>

        <form action="konfirmasi-login" method="POST">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="username_54">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password_54">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" name="login" class="btn btn-success btn-block">
                Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <!-- /.social-auth-links -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  <?php include("includes/script.php") ?>
</body>