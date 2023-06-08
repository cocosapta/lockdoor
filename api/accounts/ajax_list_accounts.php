<?php
// require_once '../../config/config.php';

if ($_GET['action'] == "tableData") {
    $columns = array(
        0 => 'account_create_at',
        1 => 'account_name',
        2 => 'account_name',
        3 => 'account_email',
        4 => 'account_level',
        5 => 'account_detail_id',
    );

    $querycount = $connect->query("SELECT count(account_detail_id) as jumlah FROM account_detail");
    $datacount = $querycount->fetch_array();

    $totalData = $datacount['jumlah'];
    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $search = $_POST['search']['value'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    $baseQ = "SELECT * FROM `account_detail` ";

    if ($limit == -1) {
        if (empty($search)) {
            $query = $connect->query($baseQ." ORDER BY $order $dir");
        } else {
            $query = $connect->query($baseQ." WHERE  `account_name` LIKE '%$search%' OR `account_email` LIKE '%$search%' ORDER BY $order $dir");

            $querycount = $connect->query("SELECT count(account_detail_id) as jumlah FROM `account_detail` WHERE  `account_name` LIKE '%$search%' OR `account_email` LIKE '%$search%'");

            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    } else {
        if (empty($search)) {
            $query = $connect->query($baseQ." ORDER BY $order $dir LIMIT $limit OFFSET $start");
        } else {
            $query = $connect->query($baseQ." WHERE  `account_name` LIKE '%$search%' OR `account_email` LIKE '%$search%' ORDER BY $order $dir LIMIT $limit OFFSET $start");

            $querycount = $connect->query("SELECT count(account_detail_id) as jumlah FROM `account_detail` WHERE  `account_name` LIKE '%$search%' OR `account_email` LIKE '%$search%'");

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
            $nestedData['image'] = $r['account_image'];
            $nestedData['name'] = $r['account_name'];
            $nestedData['email'] = $r['account_email'];
            $nestedData['level'] = $r['account_level'];
            $nestedData['status'] = checkActivationAccount($r['account_detail_id']);
            $nestedData['option'] = $r['account_detail_id']."-".$r['account_name'];

            // $nestedData['option'] = "<center>
            // <a href=\"detail-account-id-".$r['account_detail_id']."\" class='btn-info btn-sm'><i class='fas fa-eye'></i> &nbsp; Detail</a> | \n
            // <a href=\"edit-account-id-".$r['account_detail_id']."\" class='btn-warning btn-sm'><i class='fas fa-edit'></i> &nbsp; Edit</a> | \n
            // <a href=\"javascript:if(confirm('Anda yakin ingin menghapus akun ".$r['account_name']."?')) window.location.href ='account-id-".$r['account_detail_id']."-mode-hapus_notif-hapusberhasil'\"
            // class='btn-danger btn-sm'><i class='fas fa-trash'></i> &nbsp; Hapus </a>
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

function checkActivationAccount($id){
    global $connect;
    $sql_caa= "SELECT `account_username`,`account_password` FROM `account_login` WHERE `account_detail_id` = '$id'";
    $query_caa = mysqli_query($connect, $sql_caa);
    while ($data_caa = mysqli_fetch_row($query_caa)) {
        $us = $data_caa[0];
        $pw = $data_caa[1];
    }
    if ($us == "" || $pw == ""){
        $status = "NOT READY";
    } else {
        $status = "READY";
    }
    return $status;
}

?>