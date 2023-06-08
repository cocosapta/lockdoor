<?php
// require_once '../../config/config.php';

if ($_GET['action'] == "table_data") {
    $columns = array(
        0 => 'account_detail_id',
        1 => 'account_name',
        2 => 'account_email',
        3 => 'account_level',
        4 => 'account_level',
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

    if($limit == -1){
        if (empty($search)) {
            $query = $connect->query("SELECT `l`.`account_id`, `l`.`account_username`, `l`.`account_level`, `d`.`account_detail_id`, `d`.`account_name`, `d`.`account_email` 
            FROM `account_login` `l` 
            INNER JOIN `account_detail` `d` ON `l`.`account_detail_id` = `d`.`account_detail_id` 
            ORDER BY $order $dir");
        } else {
            $query = $connect->query("SELECT `l`.`account_id`, `l`.`account_username`, `l`.`account_level`, `d`.`account_detail_id`, `d`.`account_name`, `d`.`account_email` 
            FROM `account_login` `l` 
            INNER JOIN `account_detail` `d` ON `l`.`account_detail_id` = `d`.`account_detail_id` 
            WHERE  `d`.`account_name` LIKE '%$search%' OR `d`.`account_email` LIKE '%$search%' OR `l`.`account_level` LIKE '%$search%'
            ORDER BY $order $dir");
            
            $querycount = $connect->query("SELECT count(`d`.`account_detail_id`) as jumlah 
            FROM `account_login` `l` 
            INNER JOIN `account_detail` `d` ON `l`.`account_detail_id` = `d`.`account_detail_id` 
            WHERE  `d`.`account_name` LIKE '%$search%' OR `d`.`account_email` LIKE '%$search%' OR `l`.`account_level` LIKE '%$search%'
            ");
            
            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    } else {
        if (empty($search)) {
            $query = $connect->query("SELECT `l`.`account_id`, `l`.`account_username`, `l`.`account_level`, `d`.`account_detail_id`, `d`.`account_name`, `d`.`account_email` 
            FROM `account_login` `l` 
            INNER JOIN `account_detail` `d` ON `l`.`account_detail_id` = `d`.`account_detail_id` 
            ORDER BY $order $dir 
            LIMIT $limit OFFSET $start");
        } else {
            $query = $connect->query("SELECT `l`.`account_id`, `l`.`account_username`, `l`.`account_level`, `d`.`account_detail_id`, `d`.`account_name`, `d`.`account_email` 
            FROM `account_login` `l` 
            INNER JOIN `account_detail` `d` ON `l`.`account_detail_id` = `d`.`account_detail_id` 
            WHERE  `d`.`account_name` LIKE '%$search%' OR `d`.`account_email` LIKE '%$search%' OR `l`.`account_level` LIKE '%$search%'
            ORDER BY $order $dir 
            LIMIT $limit OFFSET $start");
            
            $querycount = $connect->query("SELECT count(`d`.`account_detail_id`) as jumlah 
            FROM `account_login` `l` 
            INNER JOIN `account_detail` `d` ON `l`.`account_detail_id` = `d`.`account_detail_id` 
            WHERE  `d`.`account_name` LIKE '%$search%' OR `d`.`account_email` LIKE '%$search%' OR `l`.`account_level` LIKE '%$search%'
            ");
            
            $datacount = $querycount->fetch_array();
            $totalFiltered = $datacount['jumlah'];
        }
    }    

    sendData($query, $start, $totalData, $totalFiltered);
    
}

function sendData($query, $start, $totalData, $totalFiltered){
    $data = array();
    if (!empty($query)) {
        $no = $start + 1;
        while ($r = $query->fetch_array()) {
            $nestedData['no'] = $no;
            $nestedData['name'] = $r['account_name'];
            $nestedData['email'] = $r['account_email'];
            $nestedData['level'] = $r['account_level'];
            $nestedData['option'] = "<center>
            <a href='#' class='btn-info btn-sm'><i class='fas fa-eye'>&nbsp;</i> Detail</a>
            <a href='#' class='btn-warning btn-sm'><i class='fas fa-edit'>&nbsp;</i> Ubah </a>&nbsp; 
            <a href='#' class='btn-danger btn-sm'><i class='fas fa-trash-alt'>&nbsp;</i> Hapus</a>
            </center>
            ";
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