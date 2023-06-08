<?php
// header("Content-Type: application/json");
$datenow = date('Y-m-d');
    
        // Jumlah pengguna di ruangan saat ini
        $qir = $connect->query("SELECT COUNT(users_detail_id) AS `jumlah` FROM record_access WHERE record_access_duration = '0' "); //WHERE hw_status LIKE 'active'";
        $cir = $qir->fetch_array();
        $usersInRoom = $cir['jumlah'];

        // List pengguna di ruangan saat ini
        $qlir = "SELECT 
        -- `r`.`record_access_id` AS `no`, 
        `r`.`record_access_in` AS `time_in`, `r`.`record_access_out` AS `time_out`, `r`.`record_access_duration` AS `duration`, 
        `d`.`users_detail_name` AS `name`, `h`.`hw_desc` AS `room` 
        FROM `record_access` `r` 
        INNER JOIN `users_detail` `d` ON `r`.`users_detail_id` = `d`.`users_detail_id` 
        INNER JOIN `hw_rfid` `h` ON `r`.`hw_id` = `h`.`hw_id` 
        WHERE record_access_duration = '0'  ";
        $glir = mysqli_query($connect, $qlir);
        $listUsersInRoom = array();
        while ($rlir = mysqli_fetch_assoc($glir)) {
            $listUsersInRoom[] = $rlir;
        }

        // Jumlah pengguna aktif hari ini
        $quat = $connect->query("SELECT COUNT(DISTINCT(users_detail_id)) AS `jumlah` FROM record_access WHERE record_access_in LIKE '%$datenow%' OR record_access_out LIKE '%$datenow%'");
        $cuat = $quat->fetch_array();
        $usersOnToday = $cuat['jumlah'];

        // List pengguna aktif hari ini
        $qluat = "SELECT DISTINCT(`r`.`users_detail_id`) AS `no`, `d`.`users_detail_name` AS `name`, `d`.`users_detail_nim` AS `nim`, `d`.`users_detail_class` AS `class` 
        FROM `record_access` `r` 
        INNER JOIN `users_detail` `d` ON `r`.`users_detail_id` = `d`.`users_detail_id` 
        WHERE record_access_in LIKE '%$datenow%' OR record_access_out LIKE '%$datenow%' 
        ORDER BY `d`.`users_detail_name` ASC";
        $gluat = mysqli_query($connect, $qluat);
        $listUsersOnToday = array();
        while ($rluat = mysqli_fetch_assoc($gluat)) {
            $listUsersOnToday[] = $rluat;
        }

        // Jumlah pengguna terdaftar
        $qru = $connect->query("SELECT COUNT(users_detail_id) AS `jumlah` FROM users_detail");
        $cru = $qru->fetch_array();
        $registeredUsers = $cru['jumlah'];

        // Jumlah aktivitas hari ini
        $qat1 = $connect->query("SELECT COUNT(record_access_id) AS `jumlah` FROM record_access WHERE record_access_in LIKE '%$datenow%'");
        $cat1 = $qat1->fetch_array();
        $at1  = $cat1['jumlah'];
        $qat2 = $connect->query("SELECT COUNT(record_access_id) AS `jumlah` FROM record_access WHERE record_access_out LIKE '%$datenow%'");
        $cat2 = $qat2->fetch_array();
        $at2  = $cat2['jumlah'];
        $activityToday = $at1 + $at2;
    
        set_responseDash(true, "Data ditemukan", $usersInRoom, $listUsersInRoom, $usersOnToday, $listUsersOnToday, $registeredUsers, $activityToday);

function set_responseDash($isSuc, $msg, $ir, $lir, $uot, $luot, $ru, $at){
    $result = array(
        'isSuccess' => $isSuc,
        'message' => $msg,
        'inRoom' => $ir,
        'listInRoom' => $lir,
        'usersOnToday' => $uot,
        'listUsersOnToday' => $luot,
        'regUsers' => $ru,
        'actToday' => $at,
    );

    echo json_encode($result);
}

?>