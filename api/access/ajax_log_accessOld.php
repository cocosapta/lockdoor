<?php
// require_once '../../config/config.php';

if ($_GET['action'] == "table_data") {
    $sTime = $_GET['sTime'];
    $fTime = $_GET['fTime'];
    $columns = array(
        0 => 'access_id',
        1 => 'access_datetime',
        2 => 'access_datetime',
        3 => 'access_status',
        4 => 'access_duration',
        5 => 'users_detail_id',
        6 => 'hw_id',
    );

    $querycount = $connect->query("SELECT count(access_id) as jumlah FROM log_access WHERE access_datetime BETWEEN '$sTime' AND '$fTime'");
    $datacount = $querycount->fetch_array();

    $totalData = $datacount['jumlah'];
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $search = addslashes($_POST['search']['value']);
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    if($limit == -1){
        if (empty($search)) {
            $query = $connect->query("SELECT `a`.`access_id`, `a`.`access_datetime`, `a`.`access_status`, `a`.`access_duration`, `a`.`access_session`, `a`.`users_detail_id`, `a`.`hw_id`, `d`.`users_detail_name`, `h`.`hw_name`
             FROM `log_access` `a`
             INNER JOIN `users_detail` `d` ON `a`.`users_detail_id` = `d`.`users_detail_id`
             INNER JOIN `hw_rfid` `h` ON `a`.`hw_id` = `h`.`hw_id`
             WHERE `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime' ORDER BY $order $dir");
        } else {
            $query = $connect->query("SELECT `a`.`access_id`, `a`.`access_datetime`, `a`.`access_status`, `a`.`access_duration`, `a`.`access_session`, `a`.`users_detail_id`, `a`.`hw_id`, `d`.`users_detail_name`, `h`.`hw_name` 
            FROM `log_access` `a`
            INNER JOIN `users_detail` `d` ON `a`.`users_detail_id` = `d`.`users_detail_id`
            INNER JOIN `hw_rfid` `h` ON `a`.`hw_id` = `h`.`hw_id`
            WHERE `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime' AND `a`.`access_datetime` LIKE '%$search%' 
            or `a`.`access_status` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime' 
            or `d`.`users_detail_name` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime'
            or `h`.`hw_name` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime'
            order by $order $dir");
            
            $querycount = $connect->query("SELECT count(`a`.`access_id`) as jumlah 
            FROM `log_access` `a`
            INNER JOIN `users_detail` `d` ON `a`.`users_detail_id` = `d`.`users_detail_id`
            INNER JOIN `hw_rfid` `h` ON `a`.`hw_id` = `h`.`hw_id`
            WHERE `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime' AND `a`.`access_datetime` LIKE '%$search%' 
            or `a`.`access_status` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime' 
            or `d`.`users_detail_name` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime'
            or `h`.`hw_name` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime'
            ");
            
            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    } else {
        if (empty($search)) {
            $query = $connect->query("SELECT `a`.`access_id`, `a`.`access_datetime`, `a`.`access_status`, `a`.`access_duration`, `a`.`access_session`, `a`.`users_detail_id`, `a`.`hw_id`, `d`.`users_detail_name`, `h`.`hw_name`
            FROM `log_access` `a` 
            INNER JOIN `users_detail` `d` ON `a`.`users_detail_id` = `d`.`users_detail_id`
            INNER JOIN `hw_rfid` `h` ON `a`.`hw_id` = `h`.`hw_id`
            WHERE `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime' ORDER BY $order $dir LIMIT $limit OFFSET $start");
        } else {
            $query = $connect->query("SELECT `a`.`access_id`, `a`.`access_datetime`, `a`.`access_status`, `a`.`access_duration`, `a`.`access_session`, `a`.`users_detail_id`, `a`.`hw_id`, `d`.`users_detail_name`, `h`.`hw_name` 
            FROM `log_access` `a` 
            INNER JOIN `users_detail` `d` ON `a`.`users_detail_id` = `d`.`users_detail_id`
            INNER JOIN `hw_rfid` `h` ON `a`.`hw_id` = `h`.`hw_id`
            WHERE `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime' AND `a`.`access_datetime` LIKE '%$search%' 
            or `a`.`access_status` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime' 
            or `d`.`users_detail_name` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime'
            or `h`.`hw_name` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime'
            order by $order $dir LIMIT $limit OFFSET $start");
            
            $querycount = $connect->query("SELECT count(`a`.`access_id`) as jumlah 
            FROM `log_access` `a` 
            INNER JOIN `users_detail` `d` ON `a`.`users_detail_id` = `d`.`users_detail_id`
            INNER JOIN `hw_rfid` `h` ON `a`.`hw_id` = `h`.`hw_id`
            WHERE `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime' AND `a`.`access_datetime` LIKE '%$search%' 
            or `a`.`access_status` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime' 
            or `d`.`users_detail_name` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime'
            or `h`.`hw_name` LIKE '%$search%' AND `a`.`access_datetime` BETWEEN '$sTime' AND '$fTime'
            ");
            
            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    }

    sendData($query, $start, $totalData, $totalFiltered);
    
}

function sendData($query, $start, $totalData, $totalFiltered){
    global $fTime, $sTime;
    $data = array();
    if (!empty($query)) {
        $no = $start + 1;
        while ($r = $query->fetch_array()) {
            // if ($r['access_status'] == "Out"){
            $nestedData['no'] = $no;
            $nestedData['date'] = date('d M Y', strtotime($r['access_datetime']));
            $nestedData['time'] = date('H:i:s', strtotime($r['access_datetime']));
            $nestedData['stat'] = $r['access_status'];
            if ($r['access_duration'] == "0" && $r['access_session'] == "ON"){
                $nestedData['dura'] = diffAccessTemp($r['access_datetime']);
            } else if ($r['access_duration'] == "0" && $r['access_session'] != "ON"){
                $nestedData['dura'] = "Sesi Selesai";
            } else {
                $nestedData['dura'] = $r['access_duration'];
            }
            
            $nestedData['name'] = "<a href='#' title='Buka Detail Pengguna'>".$r['users_detail_name']."</a>";
            $nestedData['door'] = "<a href='#' title='Buka Detail Pintu'>".$r['hw_name']."</a>";
            // $nestedData['aksi'] = "<a href='#' class='btn-warning btn-sm'>Ubah</a>&nbsp; <a href='#' class='btn-danger btn-sm'>Hapus</a>";
            $data[] = $nestedData;
            $no++;
            // }
        }
    }

    $json_data = array(
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
    );

    echo json_encode($json_data);
}
function diffAccessTemp($startTime){
    date_default_timezone_set('Asia/Jakarta');
    $tempTimeNow = strtotime(date("Y-m-d H:i:s"));
    $tempTimeStart = strtotime($startTime);

    $diffTemp = $tempTimeNow - $tempTimeStart;
    $jam = floor($diffTemp / (60 * 60));
    $menit = $diffTemp - ( $jam * (60 * 60) );
    $detik = $diffTemp % 60;
    $timeDiff =  $jam." Jam ".floor($menit/60)." Menit ".$detik." Detik";
    return $timeDiff;
}
?>