<?php
$id_user_side = $_SESSION['id_user_54'];
$levside = $_SESSION['level_54'];

// $isSuc = $jsonDetail['isSuccess'];
// $msg = $jsonDetail['message'];
// $foto = $jsonDetail['data']['account_image'];

?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light bg-white elevation-4">
  <!-- Brand Logo -->
  <a id="lgsdcstm" href="profile" class="brand-link">
    <img src="<?php echo $baseUrlMedia; ?>icon/Logo_VokasiUB.png" title="Logo Vokasi UB" class="image center" style="height: 40px; margin:auto; padding: 5px;">
    
    <!-- <img src="media/foto/<?php echo $foto; ?>" alt="User" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
    <span id="txtcstmblack" class="brand-text font-weight"> &nbsp; <b><?php echo $levside; ?></b></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- <li class="nav-item">
          <a href="profil" class="nav-link <?php if ($include == "profile") { echo "active"; }?>">
            <i class="nav-icon fas fa-user"></i>
            <p>Profil</p>
          </a>
        </li> -->
        <li class="nav-item">
          <a href="dashboard" class="nav-link <?php if ($include == "dashboard") { echo "active"; }?>">
            <i class="nav-icon fas fa-desktop"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a href="dashboard-v" class="nav-link <?php if ($include == "dashboard-v") { echo "active"; }?>">
            <i class="nav-icon fas fa-desktop"></i>
            <p>Dashboard</p>
          </a>
        </li> -->
        <li class="nav-item">
          <a href="statistics" class="nav-link <?php if ($include == "statistics") { echo "active"; }?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Statistik</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="users" class="nav-link <?php if ($include == "users") { echo "active"; }?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Pengguna</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="devices" class="nav-link <?php if ($include == "devices") { echo "active"; }?>">
            <i class="nav-icon fab fa-usb"></i>
            <p>Perangkat</p>
          </a>
        </li>
        <li class="nav-item has-treeview <?php if ($include == "logs" || $include == "change-password_" || $include == "accounts" || $include == "test-dev") { echo "menu-open"; }?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Sistem<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="logs" class="nav-link <?php if ($include == "logs") { echo "active"; }?>"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <i class="nav-icon fas fa-history"></i>
                <p>Log</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="change-password" class="nav-link <?php if ($include == "change-password") { echo "active"; }?>"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <i class="nav-icon fas fa-user-lock"></i>
                <p>Ubah Password</p>
              </a>
            </li> -->
            
            <?php
            if ($_SESSION['level_54']=="Superadmin"){
            ?>
            <li class="nav-item">
              <a href="accounts" class="nav-link <?php if ($include == "accounts") { echo "active"; }?>"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <i class="nav-icon fas fa-user-cog"></i>
                <p>Pengaturan Akun</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="test-dev" class="nav-link <?php if ($include == "test-dev") { echo "active"; }?>"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <i class="nav-icon fas fa-code"></i>
                <p>Tester</p>
              </a>
            </li>
            <?php }
            ?>
            
          </ul>
        </li>
        <li class="nav-item">
          <a href="signout" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Sign Out</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>