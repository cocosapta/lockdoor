<script> //Swal Login
  $('.swalLogin').show(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    <?php 
    if (!empty($_GET['gagal'])) {
    if ($_GET['gagal'] == "emptyUsername") { ?>
      Toast.fire({
        type: 'info',
        title: '  Maaf Username tidak boleh kosong'
      })
    <?php } else if ($_GET['gagal'] == "emptyPassword") { ?>
      Toast.fire({
        type: 'info',
        title: '  Maaf Password tidak boleh kosong'
      })
    <?php } else if ($_GET['gagal'] == "wrongUserPass") { ?>
      Toast.fire({
        type: 'info',
        title: '  Maaf Username atau Password Salah'
      })
    <?php } else { ?>
      Toast.fire({
        type: 'info',
        title: '  Tidak dapat terhubung ke server'
      })
    <?php } } ?>
  });
</script>

<script> //Swal Warning Kosong
  $('.swalWarningKosong').show(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    <?php 
    if (!empty($_GET['jenis'])) { ?>
      Toast.fire({
        type: 'warning',
        title: '  Maaf kolom <?php echo $_GET['jenis']; ?> harus di isi'
      })
    <?php } ?>
  });
</script>

<script> //Swal Info Error Image
  $('.swalInfoImage').show(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    <?php 
    if (!empty($_GET['jenis'])) {
    if ($_GET['jenis'] == "maxsize") { ?>
      Toast.fire({
        type: 'info',
        title: '  Maaf ukuran gambar terlalu besar'
      })
    <?php } else if ($_GET['jenis'] == "notimage") { ?>
      Toast.fire({
        type: 'info',
        title: '  Maaf hanya file jpg, jpeg, png, dan gif yang diperbolehkan'
      })
    <?php } } ?>
  });
</script>

<script> //Swal Success
  $('.swalSuccess').show(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      <?php 
      if (!empty($_GET['notif'])) {
      if ($_GET['notif'] == "successDelete") { ?>
        Toast.fire({
          type: 'success',
          title: '  <?php echo $_SESSION['msgNotif']; ?>'
        })
      <?php } else if ($_GET['notif'] == "successUpdate") { ?>
        Toast.fire({
          type: 'success',
          title: '  <?php echo $_SESSION['msgNotif']; ?>'
        })
      <?php } else if ($_GET['notif'] == "successCreate") { ?>
        Toast.fire({
          type: 'success',
          title: '  <?php echo $_SESSION['msgNotif']; ?>'
        })
      <?php } else if ($_GET['notif'] == "successUpdatePassword") { ?>
        Toast.fire({
          type: 'success',
          title: '  Password login berhasil diubah'
        })
      <?php } } ?>
    });
</script>

<script> //Swall Error
  $('.swalError').show(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      <?php 
      if (!empty($_GET['notif'])) {
      if ($_GET['notif'] == "errorDelete") { ?>
        Toast.fire({
          type: 'error',
          title: '  <?php echo $_SESSION['msgNotif']; ?>'
        })
      <?php } else if ($_GET['notif'] == "errorUpdate") { ?>
        Toast.fire({
          type: 'error',
          title: '  <?php echo $_SESSION['msgNotif']; ?>'
        })
      <?php } else if ($_GET['notif'] == "errorCreate") { ?>
        Toast.fire({
          type: 'error',
          title: '  <?php echo $_SESSION['msgNotif']; ?>'
        })
      <?php } else if ($_GET['notif'] == "errorUpdatePassword") { ?>
        Toast.fire({
          type: 'error',
          title: '  Password login gagal diubah'
        })
      <?php } } ?>
    });
</script>

<script> //Swal Warning Filter Tanggal
  $('.swalWarningFilterDate').show(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
      Toast.fire({
        type: 'warning',
        title: '  Tanggal awal tidak boleh lebih besar dari tanggal akhir'
      })
  });
</script>

<script> //Swal Warning Ubah Password
  $('.swalWarningPass').show(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    <?php 
    if (!empty($_GET['notif']) && !empty($_SESSION['msgNotif'])) { ?>
        Toast.fire({
          type: 'warning',
          title: '  <?php echo $_SESSION['msgNotif']; ?>'
        })
    <?php } ?>
  });
</script>

<!-- <script> //Swall Konfirmasi Hapus
  $('.swalConfirmDelete').show(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });
      <?php 
      if (!empty($_GET['notif'])) {
      if ($_GET['notif'] == "confirmDelete") { ?>
        Swal.fire({
          title: 'Yakin ingin menghapus akun ?',
          text: "Data yang sudah dihapus tidak dapat dikembalikan!",
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yakin',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.dismiss !== 'cancel') {
            window.location.href="confirm-delete-account-id-<?php echo $_GET['data']; ?>";
          } else {
            // window.location.href="accounts";
          }
        });
      <?php } } ?>
    });
</script> -->

<script> //Swall Info Not Found
  $('.swalInfoNotFound').show(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      allowOutsideClick: true,
      width: 400,
      // timer: 3000
    });
      Toast.fire({
        type: 'error',
        title: '  <?php if (isset($msg)){ echo $msg;} ?>'
      })
  });
</script>