<?php
// require_once '../../config/config.php';

if ($_GET['action'] == "tableData") {
    $columns = array(
        0 => 'hw_id',
        1 => 'hw_name',
        2 => 'hw_desc',
        3 => 'hw_id',
        4 => 'hw_id',
    );

    $querycount = $connect->query("SELECT count(hw_id) as jumlah FROM hw_rfid");
    $datacount = $querycount->fetch_array();

    $totalData = $datacount['jumlah'];
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $search = addslashes($_POST['search']['value']);
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    $baseQ = "SELECT * FROM `hw_rfid` ";

    if ($limit == -1) {
        if (empty($search)) {
            $query = $connect->query($baseQ." ORDER BY $order $dir");
        } else {
            $query = $connect->query($baseQ." WHERE  `hw_name` LIKE '%$search%' OR `hw_desc` LIKE '%$search%' ORDER BY $order $dir");

            $querycount = $connect->query("SELECT count(hw_id) as jumlah FROM `hw_rfid` WHERE  `hw_name` LIKE '%$search%' OR `hw_desc` LIKE '%$search%'");

            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    } else {
        if (empty($search)) {
            $query = $connect->query($baseQ." ORDER BY $order $dir LIMIT $limit OFFSET $start");
        } else {
            $query = $connect->query($baseQ." WHERE  `hw_name` LIKE '%$search%' OR `hw_desc` LIKE '%$search%' ORDER BY $order $dir LIMIT $limit OFFSET $start");

            $querycount = $connect->query("SELECT count(hw_id) as jumlah FROM `hw_rfid` WHERE  `hw_name` LIKE '%$search%' OR `hw_desc` LIKE '%$search%'");

            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    }

    sendData($query, $start, $totalData, $totalFiltered);
}

function sendData($query, $start, $totalData, $totalFiltered)
{
    $data = array();
    if (!empty($query)) {
        $no = $start + 1;
        while ($r = $query->fetch_array()) {
            
            $nestedData['no'] = $no;
            $nestedData['name'] = $r['hw_name'];
            $nestedData['desc'] = $r['hw_desc'];
            $nestedData['stat'] = statusDevice($r['hw_id']);
            $nestedData['option'] = $r['hw_id']."-".$r['hw_name'];
            // $nestedData['option'] = "<center>
            // <a href=\"details-devices-id-".$r['hw_id']."\" class='btn-info btn-sm'><i class='fas fa-eye'></i> &nbsp; Detail</a> | \n
            // <a href=\"javascript:if(confirm('Anda yakin ingin menghapus perangkat ".$r['hw_name']."?')) 
            // window.location.href ='perangkat-id-".$r['hw_id']."-mode-hapus_notif-hapusberhasil'\" class='btn-danger btn-sm'><i class='fas fa-trash'></i> &nbsp; Hapus </a>
            // <center>";
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

function statusDevice($id){
    global $connect;
    date_default_timezone_set('Asia/Jakarta');
    $fTime = myDateTimeGenerator();
    $fTime2 = time();
    $sTime = date("Y-m-d H:i:s", strtotime("-5 seconds", $fTime2));

    $qru = $connect->query("SELECT COUNT(sensor_current_id) AS `jumlah` FROM `sensor_current_data` WHERE `hw_id` = '$id' AND `sensor_current_datetime` BETWEEN '$sTime' AND '$fTime'");
    $cru = $qru->fetch_array();
    $countIdDev = $cru['jumlah'];

    if ($countIdDev > 0){
        return "ONLINE";
    } else {
        return "OFFLINE";
    }

}

?>