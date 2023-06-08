<?php
// require_once '../../config/config.php';

if ($_GET['action'] == "tableData") {
    $columns = array(
        0 => 'users_detail_id',
        1 => 'users_detail_nim',
        2 => 'users_detail_name',
        3 => 'users_detail_class',
        4 => 'users_detail_id',
        5 => 'users_detail_id',
    );

    $querycount = $connect->query("SELECT count(users_detail_id) as jumlah FROM users_detail");
    $datacount = $querycount->fetch_array();

    $totalData = $datacount['jumlah'];
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $search = $_POST['search']['value'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    $baseQ = "SELECT * FROM `users_detail` ";

    if ($limit == -1) {
        if (empty($search)) {
            $query = $connect->query($baseQ." ORDER BY $order $dir");
        } else {
            $query = $connect->query($baseQ." WHERE  `users_detail_name` LIKE '%$search%' OR `users_detail_nim` LIKE '%$search%' ORDER BY $order $dir");

            $querycount = $connect->query("SELECT count(users_detail_id) as jumlah FROM `users_detail` WHERE  `users_detail_name` LIKE '%$search%' OR `users_detail_nim` LIKE '%$search%'");

            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    } else {
        if (empty($search)) {
            $query = $connect->query($baseQ." ORDER BY $order $dir LIMIT $limit OFFSET $start");
        } else {
            $query = $connect->query($baseQ." WHERE  `users_detail_name` LIKE '%$search%' OR `users_detail_nim` LIKE '%$search%' ORDER BY $order $dir LIMIT $limit OFFSET $start");

            $querycount = $connect->query("SELECT count(users_detail_id) as jumlah FROM `users_detail` WHERE  `users_detail_name` LIKE '%$search%' OR `users_detail_nim` LIKE '%$search%'");

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
            $nestedData['nim'] = $r['users_detail_nim'];
            $nestedData['name'] = $r['users_detail_name'];
            $nestedData['class'] = $r['users_detail_class'];
            $nestedData['status'] = getStatusUser($r['users_detail_id']);
            $nestedData['option'] = $r['users_detail_id']."-".$r['users_detail_name'];

            // $nestedData['option'] = "<center>
            // <a href=\"detail-pengguna-id-".$r['users_detail_id']."\" class='btn-info btn-sm'><i class='fas fa-eye'></i> &nbsp; Detail</a> | \n
            // <a href=\"javascript:if(confirm('Anda yakin ingin menghapus data ".$r['users_detail_name']."?')) 
            // window.location.href ='pengguna-id-".$r['users_detail_id']."-mode-hapus_notif-hapusberhasil'\" class='btn-danger btn-sm'><i class='fas fa-trash'></i> &nbsp; Hapus </a>
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
function getStatusUser($id){
    global $connect;
    $qGetDataStat = $connect->query("SELECT `user_status` AS `status` FROM `users_rfid` WHERE `users_detail_id`= '".$id."'");
    $cGetDataStat = $qGetDataStat->fetch_array();
    $data = $cGetDataStat['status'];
    return $data;
}
?>