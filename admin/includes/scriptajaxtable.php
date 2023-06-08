<script> //Datatable Rec Access V
  $(function() {
    $("#tableRecAccess").DataTable({
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
          title: 'Report Log Access_<?php echo $tPeriode ?>'
        }, {
          extend: 'excel',
          text: 'Excel',
          className: 'btn-primary',
          title: 'Report Log Access_<?php echo $tPeriode ?>'
        }, {
          extend: 'pdf',
          text: 'PDF',
          className: 'btn-primary',
          title: 'Report Log Access_<?php echo $tPeriode ?>'
        }, {
          extend: 'print',
          text: '<b>Print</b>',
          title: '<center><b><p style="font-size: 34px; color: black">Report Log Access - Smart Key</p></b></center><br>'+
          '<p style="font-size: 14px; float : right">Printed : <b style="color:red"><?php echo $dateExport ?></b></p><br>'+
          '<p style="font-size: 14px; float : left">Tanggal :  <b style="color:green"><?php echo $tPeriode ?></b></p>'
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
        "url": "<?php echo $baseUrlApi ?>record-access/tableData/<?php echo $sTime ?>/<?php echo $fTime ?>",
        "dataType": "json",
        "type": "POST"
      },
      "columns": [{
          "data": "no"
        },
        {
          "data": "in"
        },
        {
          "data": "out"
        },
        {
          "data": "dur"
        },
        {
          "data": "name",
          "mRender": 
          function (data) {
            var pecah = data.split("-");
            return "<a href=\"user-details-"+pecah[0]+"\"> &nbsp; "+pecah[1]+"</a>";
          }
        },
        {
          "data": "door",
          "mRender": 
          function (data) {
            var pecah = data.split("-");
            return "<a href=\"device-details-"+pecah[0]+"\"> &nbsp; "+pecah[1]+"</a>";
          }
        },
      ]
    }).buttons().container().appendTo('#tableRecAccess_wrapper .col-md-6:eq(0)');
  });
</script>

<script> //Datatable Pengguna V
    $(function() {
        $("#tableUsers").DataTable({
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
                    title: 'Pengguna Terdaftar_<?php echo $dateExport ?>',
                    exportOptions: {
                      columns: [ 0, 1, 2, 3 ],
                    },
                }, {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn-primary',
                    title: 'Pengguna Terdaftar_<?php echo $dateExport ?>',
                    exportOptions: {
                      columns: [ 0, 1, 2, 3 ],
                    },
                }, {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn-primary',
                    title: 'Pengguna Terdaftar_<?php echo $dateExport ?>',
                    exportOptions: {
                      columns: [ 0, 1, 2, 3 ],
                    },
                }, {
                    extend: 'print',
                    text: '<b>Print</b>',
                    title: '<center><b><p style="font-size: 34px; color: black">Pengguna Terdaftar - Smart Key</p></b></center><br>'+
                    '<p style="font-size: 14px; float : right">Printed : <b style="color:red"><?php echo $dateExport ?></b></p>',
                    exportOptions: {
                      columns: [ 0, 1, 2, 3 ],
                    },
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
                "url": "<?php echo $baseUrlApi;?>users/tableData",
                "dataType": "json",
                "type": "POST"
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": "nim"
                },
                {
                    "data": "name"
                },
                {
                    "data": "class"
                },
                {
                    "data": "status",
                    "mRender": 
                    function (data) {
                      if (data == 'active'){
                      return "<center>"+
                      "<p style='color:green'><b>AKTIF</b></p>"+
                      "</center>";
                      } else {
                      return "<center>"+
                      "<p style='color:red'><b>NON AKTIF</b></p>"+
                      "</center>";
                      }
                    }
                },
                {
                    "data": "option",
                    "mRender": 
                    function (data) {
                      var pecah = data.split("-");
                      data +="-user";
                      return "<center>"+
                      "<a href=\"user-details-"+pecah[0]+"\" class='btn-info btn-sm'><i class='fas fa-eye'></i> &nbsp; Detail</a> &nbsp;"+
                      // "<a href=\"account-update-"+pecah[0]+"\" class='btn-warning btn-sm'><i class='fas fa-edit'></i> &nbsp; Ubah</a> &nbsp;"+
                      "<a href='#' onclick=\"showConfirmDelete(\'"+data+"\')\" class='btn-danger btn-sm'><i class='fas fa-trash'></i> &nbsp; Hapus </a>"+
                      // "<a href=\"accounts_notif-confirmDelete="+pecah[0]+"\" class='btn-danger btn-sm'>"+
                      "</center>";
                    }
                },
            ]
        }).buttons().container().appendTo('#tableUsers_wrapper .col-md-6:eq(0)');
    });
</script>

<script> //Datatable Detail Pengguna V
  $(function() {
    $("#tableDetailUsersAccess").DataTable({
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
          title: 'Riwayat Akses <?php if(isset($nim)){echo $nim;} ?> - <?php if(isset($nama)){echo $nama;} ?>'
        }, {
          extend: 'excel',
          text: 'Excel',
          className: 'btn-primary',
          title: 'Riwayat Akses <?php if(isset($nim)){echo $nim;} ?> - <?php if(isset($nama)){echo $nama;} ?>'
        }, {
          extend: 'pdf',
          text: 'PDF',
          className: 'btn-primary',
          title: 'Riwayat Akses <?php if(isset($nim)){echo $nim;} ?> - <?php if(isset($nama)){echo $nama;} ?>'
        }, {
          extend: 'print',
          text: '<b>Print</b>',
          title: '<center><b><p style="font-size: 34px; color: black">Riwayat Akses - Smart Key</p></b><small><?php if(isset($nama)){echo $nama;} ?><br><?php if(isset($nim)){echo $nim;} ?></small></center><br>'+
          '<p style="font-size: 14px; float : right">Printed : <b style="color:red"><?php echo $dateExport ?></b></p><br>'+
          '<p style="font-size: 14px; float : left">Tanggal :  <b style="color:green"><?php echo $tPeriode ?></b></p>'
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
        "url": "<?php echo $baseUrlApi ?>record-access/tableData/<?php echo $sTime ?>/<?php echo $fTime ?>/<?php if(isset($id_user_detail)){echo $id_user_detail;} ?>",
        "dataType": "json",
        "type": "POST"
      },
      "columns": [{
          "data": "no"
        },
        {
          "data": "in"
        },
        {
          "data": "out"
        },
        {
          "data": "dur"
        },
        {
          "data": "door",
          "mRender": 
          function (data) {
            var pecah = data.split("-");
            return "<a href=\"device-details-"+pecah[0]+"\"> &nbsp; "+pecah[1]+"</a>";
          }
        },
      ]
    }).buttons().container().appendTo('#tableDetailUsersAccess_wrapper .col-md-6:eq(0)');
  });
</script>

<script> //Datatable Perangkat V
    $(function() {
        $("#tableDevices").DataTable({
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
                    title: 'Perangkat Terdaftar_<?php echo $dateExport ?>',
                    exportOptions: {
                      columns: [ 0, 1, 2 ],
                    },
                }, {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn-primary',
                    title: 'Perangkat Terdaftar_<?php echo $dateExport ?>',
                    exportOptions: {
                      columns: [ 0, 1, 2 ],
                    },
                }, {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn-primary',
                    title: 'Perangkat Terdaftar_<?php echo $dateExport ?>',
                    exportOptions: {
                      columns: [ 0, 1, 2 ],
                    },
                }, {
                    extend: 'print',
                    text: '<b>Print</b>',
                    title: '<center><b><p style="font-size: 34px; color: black">Perangkat Terdaftar - Smart Key</p></b></center><br>'+
                    '<p style="font-size: 14px; float : right">Printed : <b style="color:red"><?php echo $dateExport ?></b></p>',
                    exportOptions: {
                      columns: [ 0, 1, 2 ],
                    },
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
                "url": "<?php echo $baseUrlApi; ?>devices/tableData",
                "dataType": "json",
                "type": "POST"
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": "name"
                },
                {
                    "data": "desc"
                },
                {
                    "data": "stat",
                    "mRender": 
                    function (data) {
                      if (data == 'ONLINE'){
                      return "<center>"+
                      "<p style='color:green'><b>"+data+"</b></p>"+
                      "</center>";
                      } else {
                      return "<center>"+
                      "<p style='color:red'><b>"+data+"</b></p>"+
                      "</center>";
                      }
                    }
                },
                {
                    "data": "option",
                    "mRender": 
                    function (data) {
                      var pecah = data.split("-");
                      data +="-device";
                      return "<center>"+
                      "<a href=\"device-details-"+pecah[0]+"\" class='btn-info btn-sm'><i class='fas fa-eye'></i> &nbsp; Detail</a> &nbsp;"+
                      // "<a href=\"account-update-"+pecah[0]+"\" class='btn-warning btn-sm'><i class='fas fa-edit'></i> &nbsp; Ubah</a> &nbsp;"+
                      "<a href='#' onclick=\"showConfirmDelete(\'"+data+"\')\" class='btn-danger btn-sm'><i class='fas fa-trash'></i> &nbsp; Hapus </a> &nbsp;"+
                      // "<a href='#' onclick=\"showConfirmDes(\'"+data+"\')\" class='btn-warning btn-sm'><i class='fas fa-exclamation-triangle'></i> &nbsp; DES </a>"+
                      // "<a href=\"accounts_notif-confirmDelete="+pecah[0]+"\" class='btn-danger btn-sm'>"+
                      "</center>";
                    }
                },
            ]
        }).buttons().container().appendTo('#tableDevices_wrapper .col-md-6:eq(0)');
    });
</script>

<script> //Datatable Detail Perangkat V
  $(function() {
    $("#tableDetailDevicesA").DataTable({
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
          title: 'Riwayat Akses <?php if(isset($nama)){echo $nama;} ?>'
        }, {
          extend: 'excel',
          text: 'Excel',
          className: 'btn-primary',
          title: 'Riwayat Akses <?php if(isset($nama)){echo $nama;} ?>'
        }, {
          extend: 'pdf',
          text: 'PDF',
          className: 'btn-primary',
          title: 'Riwayat Akses <?php if(isset($nama)){echo $nama;} ?>'
        }, {
          extend: 'print',
          text: '<b>Print</b>',
          title: '<center><b><p style="font-size: 34px; color: black">Riwayat Akses - Smart Key</p></b><small><?php if(isset($nama)){echo $nama;} ?><br><?php if(isset($ket)){echo $ket;} ?></small></center><br>'+
          '<p style="font-size: 14px; float : right">Printed : <b style="color:red"><?php echo $dateExport ?></b></p><br>'+
          '<p style="font-size: 14px; float : left">Tanggal :  <b style="color:green"><?php echo $tPeriode ?></b></p>'
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
        "url": "<?php echo $baseUrlApi; ?>record-access/tableData/<?php echo $sTime; ?>/<?php echo $fTime; ?>/<?php if(isset($id_hw_detail)){echo $id_hw_detail;} ?>",
        "dataType": "json",
        "type": "POST"
      },
      "columns": [{
          "data": "no"
        },
        {
          "data": "in"
        },
        {
          "data": "out"
        },
        {
          "data": "dura"
        },
        {
          "data": "use",
          "mRender": 
          function (data) {
            var pecah = data.split("-");
            return "<a href=\"user-details-"+pecah[0]+"\"> &nbsp; "+pecah[1]+"</a>";
          }
        },
      ]
    }).buttons().container().appendTo('#tableDetailDevicesA_wrapper .col-md-6:eq(0)');
  });
</script>

<script> //Datatable Log System V
  $(function() {
    $("#tableLogSystem").DataTable({
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
          title: 'Report Log System_<?php echo $tPeriode ?>'
        }, {
          extend: 'excel',
          text: 'Excel',
          className: 'btn-primary',
          title: 'Report Log System_<?php echo $tPeriode ?>'
        }, {
          extend: 'pdf',
          text: 'PDF',
          className: 'btn-primary',
          title: 'Report Log System_<?php echo $tPeriode ?>'
        }, {
          extend: 'print',
          text: '<b>Print</b>',
          title: '<center><b><p style="font-size: 34px; color: black">Report Log System - Smart Key</p></b></center><br>'+
          '<p style="font-size: 14px; float : right">Printed : <b style="color:red"><?php echo $dateExport ?></b></p><br>'+
          '<p style="font-size: 14px; float : left">Tanggal :  <b style="color:green"><?php echo $tPeriode ?></b></p>'
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
        "url": "<?php echo $baseUrlApi ?>log-system/tableData/<?php echo $sTime ?>/<?php echo $fTime ?>",
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
          "data": "desc"
        },
        {
          "data": "status"
        },
        {
          "data": "door",
          "mRender": 
          function (data) {
            var pecah = data.split("-");
            return "<a href=\"device-details-"+pecah[0]+"\"> &nbsp; "+pecah[1]+"</a>";
          }
        },
      ]
    }).buttons().container().appendTo('#tableLogSystem_wrapper .col-md-6:eq(0)');
  });
</script>

<script> //Datatable List Account Web V
  $(function() {
    $("#tableAccounts").DataTable({
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
          title: 'List of Web Account_<?php echo $dateExport ?>',
          exportOptions: {
            columns: [ 0, 2, 3, 4 ],
          },
        }, {
          extend: 'excel',
          text: 'Excel',
          className: 'btn-primary',
          title: 'List of Web Account_<?php echo $dateExport ?>',
          exportOptions: {
            columns: [ 0, 2, 3, 4 ],
          },
        }, {
          extend: 'pdf',
          text: 'PDF',
          className: 'btn-primary',
          title: 'List of Web Account_<?php echo $dateExport ?>',
          exportOptions: {
            columns: [ 0, 2, 3, 4 ],
          },
        }, {
          extend: 'print',
          text: '<b>Print</b>',
          title: '<center><b><p style="font-size: 34px; color: black">List of Web Account - Smart Key</p></b></center><br>'+
          '<p style="font-size: 14px; float : right">Printed : <b style="color:red"><?php echo $dateExport ?></b></p>',
          exportOptions: {
            columns: [ 0, 2, 3, 4 ],
          },
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
        "url": "<?php echo $baseUrlApi;?>accounts/tableData",
        "dataType": "json",
        "type": "POST"
      },
      "columns": [{
          "data": "no"
        },
        {
          "data": "image",
          "mRender":
          function (data){
            return "<center>"+
            "<img alt=\"Foto gagal dimuat\" src=\"<?php echo $baseUrlMedia; ?>foto/"+data+"\" id=\"imgcstm\" class=\"img-fluid\" width=\"70%;\">"+
            "</center>"
          }
        },
        {
          "data": "name"
        },
        {
          "data": "email"
        },
        {
          "data": "level"
        },
        {
          "data": "status",
          "mRender": 
          function (data) {
            
            return "<center><b>"+
            data+
            "</b></center>";
          }
        },
        {
          "data": "option",
          "mRender": 
          function (data) {
            var pecah = data.split("-");
            data +="-account";
            return "<center>"+
            // "<a href=\"account-details-"+pecah[0]+"\" class='btn-info btn-sm'><i class='fas fa-eye'></i> &nbsp; Detail</a> &nbsp;"+
            "<a href=\"account-update-"+pecah[0]+"\" class='btn-warning btn-sm'><i class='fas fa-edit'></i> &nbsp; Ubah</a> &nbsp;"+
            "<a href='#' onclick=\"showConfirmDelete(\'"+data+"\')\" class='btn-danger btn-sm'><i class='fas fa-trash'></i> &nbsp; Hapus </a>"+
            // "<a href=\"accounts_notif-confirmDelete="+pecah[0]+"\" class='btn-danger btn-sm'>"+
            "</center>";
          }
        },
      ]
    }).buttons().container().appendTo('#tableAccounts_wrapper .col-md-6:eq(0)');
  });
</script>

<script>
  function showConfirmDelete(dataDel) {
    // var data = "sda3-da3";
    var pecah = dataDel.split("-");
    // document.getElementById("demo").innerHTML = "Hello World";
        Swal.fire({
          title: 'Yakin ingin menghapus \n '+pecah[1]+'?',
          text: "Data yang sudah dihapus tidak dapat dikembalikan!",
          type: 'question',
          showCancelButton: true,
          allowEscapeKey: false,
          allowOutsideClick: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yakin',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.dismiss !== 'cancel') {
            window.location.href="confirm-delete-"+pecah[2]+"="+pecah[0]+"";
          } else {
            // window.location.href="accounts";
          }
        });
    // });
  }
  function showConfirmDes(dataDes) {
    var pecah = dataDes.split("-");
        Swal.fire({
          title: 'Mengaktifkan Door Emergency System pada \n '+pecah[1]+'?',
          text: "DES akan aktif selama 5 detik",
          type: 'warning',
          showCancelButton: true,
          allowEscapeKey: false,
          allowOutsideClick: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Aktifkan',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.dismiss !== 'cancel') {
            window.location.href="confirm-des-"+pecah[2]+"="+pecah[0]+"";
          } else {
            // window.location.href="accounts";
          }
        });
    // });
  }
</script>