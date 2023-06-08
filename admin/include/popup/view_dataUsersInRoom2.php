<?php
?>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-sm" id="tableModalUsersInRoom">
        <thead class="thead-light">
            <tr>
                <th>
                    <center>No</center>
                </th>
                <th>
                    <center>Nama</center>
                <th>
                    <center>Ruang</center>
                <th>
                    <center>Waktu Masuk</center>
                <th>
                    <center>Durasi</center>
            </tr>
        </thead>
        <tbody id="bodyTableModalUsersInRoom">
        </tbody>
    </table>
</div>
<script>
    var refreshId = setInterval(function(){
    $('#bodyTableModalUsersInRoom').load('include/popup/data_usersInRoom.php');
    }, 1000);
</script>