<!-- Page specific script -->
<!-- <script> //Datatable Log Access
  $(function() {
    $("#tableLogAccess").DataTable({
      "columnDefs": [{
        "className": "dt-center",
        "targets": "_all"
      }],
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "dom": 'Bfrtip',
      "buttons": ['pageLength',
        {
          extend: 'csv',
          text: 'CSV',
          className: 'btn-primary',
          title: 'Report Log Access_<?php echo $dateExport ?>'
        }, {
          extend: 'excel',
          text: 'Excel',
          className: 'btn-primary',
          title: 'Report Log Access_<?php echo $dateExport ?>'
        }, {
          extend: 'pdf',
          text: 'PDF',
          className: 'btn-primary',
          title: 'Report Log Access_<?php echo $dateExport ?>'
        }, {
          extend: 'print',
          text: '<b>Print</b>',
          title: '<center><h3 style="color: black">Report Log Access - Smart Key</h3></center><br><small style="color:red; float : right"><?php echo $dateExport ?></small>'
        },
      ],
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "pagingType": "first_last_numbers",
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "api/ajax_log_access.php?action=table_data&sTime=<?php echo $sTime ?>&fTime=<?php echo $fTime ?>",
        "dataType": "json",
        "type": "POST"
      },
      "columns": [{
          "data": "no"
        },
        {
          "data": "date"
        },
        {
          "data": "time"
        },
        {
          "data": "stat"
        },
        {
          "data": "dura"
        },
        {
          "data": "name"
        },
        {
          "data": "door"
        },
      ]
    }).buttons().container().appendTo('#tableLogAccess_wrapper .col-md-6:eq(0)');
  });
</script> -->

<script> //Data Panel Dashboard Popup
  $(document).ready(function() {
    $(document).on('click', '.view_dataUsersInRoom', function() {
      // var employee_id = $(this).attr("iddataUsersInRoom");
      $.ajax({
        url: "include/popup/view_dataUsersInRoom2.php",
        method: "POST",
        //  data:{employee_id:employee_id},
        success: function(data) {
          $('#dataUsersInRoom').html(data);
          $('#dataUsersInRoomModal').modal('show');
        }
      });
    });
    $(document).on('click', '.view_dataUsersActiveToday', function() {
      // var employee_id = $(this).attr("iddataUsersInRoom");
      $.ajax({
        url: "include/popup/view_dataUsersActiveToday.php",
        method: "POST",
        //  data:{employee_id:employee_id},
        success: function(data) {
          $('#dataUsersActiveToday').html(data);
          $('#dataUsersActiveTodayModal').modal('show');
        }
      });
    });

    $(document).on('click', '.view_dataUsersWhite', function() {
      var hw_id = document.getElementById("inputIdp").value;
      $.ajax({
        url: "include/popup/view_dataUsersWhite.php",
        method: "POST",
         data:{hw_id:hw_id},
        success: function(data) {
          $('#dataUsersWhite').html(data);
          $('#dataUsersWhiteModal').modal('show');
        }
      });
    });
  });
</script>

<script type="application/javascript"> //Form Upload Foto Edit Profil
  $('#inputFotoFile01').on('change', function() {
    let fileName = $(this).val().split('\\').pop(); // Ambil nama file 
    $(this).next('.custom-file-label').addClass("selected").html(fileName+"( "+getSizeMega("inputFotoFile01")+" MB)"); // Ubah "Choose a file" label sesuai dengan nama file yag akan diupload
  });
</script>

<script type="application/javascript"> //Form Upload Foto Tambah Pengguna
  $('#inputFotoFile03').on('change', function() {
    let fileName = $(this).val().split('\\').pop(); // Ambil nama file 
    $(this).next('.custom-file-label').addClass("selected").html(fileName+"( "+getSizeMega("inputFotoFile03")+" MB)"); // Ubah "Choose a file" label sesuai dengan nama file yag akan diupload
  });
</script>

<script type="application/javascript"> //Form Upload Foto Edit Pengguna
  $('#inputFotoFile02').on('change', function() {
    let fileName = $(this).val().split('\\').pop(); // Ambil nama file 
    $(this).next('.custom-file-label').addClass("selected").html(fileName+"( "+getSizeMega("inputFotoFile02")+" MB)"); // Ubah "Choose a file" label sesuai dengan nama file yag akan diupload
  });
</script>

<script type="application/javascript"> //Form Upload Foto Tambah Akun Web
  $('#inputFotoFile04').on('change', function() {
    let fileName = $(this).val().split('\\').pop(); // Ambil nama file 
    $(this).next('.custom-file-label').addClass("selected").html(fileName+"( "+getSizeMega("inputFotoFile04")+" MB)"); // Ubah "Choose a file" label sesuai dengan nama file yag akan diupload
  });
</script>

<script type="application/javascript"> //Form Upload Foto Edit Akun Web
  $('#inputFotoFile05').on('change', function() {
    let fileName = $(this).val().split('\\').pop(); // Ambil nama file 
    // let fileSize = document.getElementById("inputFotoFile05").files[0].size;
    $(this).next('.custom-file-label').addClass("selected").html(fileName+"( "+getSizeMega("inputFotoFile05")+" MB)"); // Ubah "Choose a file" label sesuai dengan nama file yag akan diupload
  });
</script>

<script>
  function getSizeMega(cName){
    let sizeF = document.getElementById(""+cName+"").files[0].size;
    var sizeInMega = (sizeF / (1024*1024)).toFixed(2);
    return sizeInMega;
  }
</script>