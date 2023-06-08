<?php

if ($_GET['action'] == "tableData") {
    $sTime = $_GET['sTime'];
    $fTime = $_GET['fTime'];
    // $sTime = "2022-02-16";
    // $fTime = "2022-02-17";

    $columns = array(
        0 => 'record_access_id',
        1 => 'record_access_in',
        2 => 'record_access_out',
        3 => 'record_access_duration',
        4 => 'users_detail_name',
        5 => 'hw_name',
    );

    $querycount = $connect->query("SELECT count(record_access_id) as jumlah FROM record_access 
                                    WHERE record_access_in BETWEEN '$sTime' AND '$fTime' OR record_access_out BETWEEN '$sTime' AND '$fTime'");
    $datacount = $querycount->fetch_array();

    $totalData = $datacount['jumlah'];
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $search = addslashes($_POST['search']['value']);
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];
    
    
    $baseQ = "SELECT `r`.`record_access_id`, `r`.`record_access_in`, `r`.`record_access_out`, `r`.`record_access_duration`, `d`.`users_detail_id`, `d`.`users_detail_name`, `h`.`hw_id`,`h`.`hw_name` 
    FROM `record_access` `r` 
    INNER JOIN `users_detail` `d` ON `r`.`users_detail_id` = `d`.`users_detail_id` 
    INNER JOIN `hw_rfid` `h` ON `r`.`hw_id` = `h`.`hw_id` 
    WHERE `r`.`record_access_in` BETWEEN '$sTime' AND '$fTime' OR `r`.`record_access_out` BETWEEN '$sTime' AND '$fTime'";

    if($limit == -1){
        if (empty($search)) {
            $query = $connect->query($baseQ." ORDER BY $order $dir");
        } else {
            $query = $connect->query("SELECT * FROM ($baseQ) var 
            WHERE users_detail_name LIKE '%$search%' OR hw_name LIKE '%$search%' 
            ORDER BY $order $dir");
            //Tempat QCount
            $querycount = $connect->query("SELECT count(`record_access_id`) as jumlah FROM ($baseQ) var WHERE users_detail_name LIKE '%$search%' OR hw_name LIKE '%$search%'");   
            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    } else {
        if (empty($search)) {
            $query = $connect->query($baseQ." ORDER BY $order $dir LIMIT $limit OFFSET $start");
        } else {
            $query = $connect->query("SELECT * FROM ($baseQ) var 
            WHERE users_detail_name LIKE '%$search%' OR hw_name LIKE '%$search%' 
            ORDER BY $order $dir 
            LIMIT $limit OFFSET $start");
            //Tempat QCount
            $querycount = $connect->query("SELECT count(`record_access_id`) as jumlah FROM ($baseQ) var WHERE users_detail_name LIKE '%$search%' OR hw_name LIKE '%$search%'");   
            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    }

    sendData($query, $start, $totalData, $totalFiltered);
    
}

function sendData($query, $start, $totalData, $totalFiltered){
    // global $dir, $order;
    $data = array();
    if (!empty($query)) {
        $no = $start + 1;
        while ($r = $query->fetch_array()) {
            $nestedData['no'] = $no;
            $nestedData['in'] = date('d-M-Y H:i:s', strtotime($r['record_access_in']));
            
            if ($r['record_access_duration'] == "0"){
                $nestedData['out'] = "In Room";
                $nestedData['dur'] = diffAccessTemp($r['record_access_in']);
            } else {
                $nestedData['out'] = date('d-M-Y H:i:s', strtotime($r['record_access_out']));
                $nestedData['dur'] = $r['record_access_duration'];
            }
            $nestedData['name'] = $r['users_detail_id']."-".$r['users_detail_name'];
            $nestedData['door'] = $r['hw_id']."-".$r['hw_name'];

            // $nestedData['name'] = "<a href=\"details-users-id-".$r['users_detail_id']."\" title='Buka Detail Pengguna'>".$r['users_detail_name']."</a>";
            // $nestedData['door'] = "<a href=\"details-devices-id-".$r['hw_id']."\" title=\"Buka Detail Pintu\">".$r['hw_name']."</a>";
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
