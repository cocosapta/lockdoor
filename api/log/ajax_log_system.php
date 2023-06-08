<?php
// require_once '../../config/config.php';

if ($_GET['action'] == "tableData") {
    $sTime = $_GET['sTime'];
    $fTime = $_GET['fTime'];
    $columns = array(
        0 => 'log_id',
        1 => 'log_datetime',
        2 => 'log_datetime',
        3 => 'log_desc',
        4 => 'log_status',
        5 => 'hw_id',
    );

    $querycount = $connect->query("SELECT count(log_id) as jumlah FROM log_system WHERE log_datetime BETWEEN '$sTime' AND '$fTime'");
    $datacount = $querycount->fetch_array();

    $totalData = $datacount['jumlah'];
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $search = $_POST['search']['value'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    $baseQueLogs = "SELECT `l`.`log_id`, `l`.`log_datetime`, `l`.`log_desc`, `l`.`log_status`, `h`.`hw_id`, `h`.`hw_name` 
    FROM `log_system` `l`
    INNER JOIN `hw_rfid` `h`
    ON `l`.`hw_id` = `h`.`hw_id` 
    WHERE `l`.`log_datetime` BETWEEN '$sTime' AND '$fTime'";

    if($limit == -1){
        if (empty($search)) {
            $query = $connect->query($baseQueLogs." ORDER BY $order $dir");
        } else {
            $query = $connect->query("SELECT * FROM ($baseQueLogs) var WHERE `log_datetime` LIKE '%$search%' OR `log_desc` LIKE '%$search%' OR `hw_name` LIKE '%$search%' 
            ORDER BY $order $dir");
            
            $querycount = $connect->query("SELECT count(log_id) as jumlah FROM ($baseQueLogs) var WHERE `log_datetime` LIKE '%$search%' OR `log_desc` LIKE '%$search%' OR `hw_name` LIKE '%$search%' ");
            
            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    } else {
        if (empty($search)) {
            $query = $connect->query($baseQueLogs." ORDER BY $order $dir LIMIT $limit OFFSET $start");
        } else {
            $query = $connect->query("SELECT * FROM ($baseQueLogs) var WHERE `log_datetime` LIKE '%$search%' OR `log_desc` LIKE '%$search%' OR `hw_name` LIKE '%$search%' 
            ORDER BY $order $dir LIMIT $limit OFFSET $start");
            
            $querycount = $connect->query("SELECT count(log_id) as jumlah FROM ($baseQueLogs) var WHERE `log_datetime` LIKE '%$search%' OR `log_desc` LIKE '%$search%' OR `hw_name` LIKE '%$search%' ");
            
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
            $nestedData['no'] = $no;
            $nestedData['date'] = date('d M Y', strtotime($r['log_datetime']));
            $nestedData['time'] = date('H:i:s', strtotime($r['log_datetime']));
            $nestedData['desc'] = $r['log_desc'];
            $nestedData['status'] = $r['log_status'];
            $nestedData['door'] = $r['hw_id']."-".$r['hw_name'];
            // $nestedData['aksi'] = "<a href='#' class='btn-warning btn-sm'>Ubah</a>&nbsp; <a href='#' class='btn-danger btn-sm'>Hapus</a>";
            $data[] = $nestedData;
            $no++;
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
?>