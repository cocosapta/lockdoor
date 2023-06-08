<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if (!empty($_GET['id'])) {
            $stringToSlice = $_GET['id'];
            $afterSlice = substr($stringToSlice, 0, 2);
            switch ($afterSlice) {
                case 'US':
                    getActivityById($_GET['id']);
                break;
                case 'HW':
                    getActivityByIdHw($_GET['id']);
                break;
                default:
                    set_response(false, "Incorrect type id", 404);
            }
        } else {
            set_response(false, "Requires parameter id", []);
        }
    break;
    default:
        set_response(false, "Wrong method", []);
        break;
    break;
}


function getActivityById($id){
    global $connect;
    $baseQueryGetAct = "SELECT * FROM record_access WHERE users_detail_id = '$id'";
    $sTime = date('Y-m-d', strtotime(myDateTimeGenerator()));
    
    $queryGetAct1 = $connect->query("SELECT COUNT(record_access_id) AS `tdy` FROM ($baseQueryGetAct) var WHERE record_access_in LIKE '%$sTime%' OR record_access_out LIKE '%" . $sTime . "%' ");
    $countActUser1 = $queryGetAct1->fetch_array();
    $actToday = $countActUser1['tdy'];

    $queryGetAct2 = $connect->query("SELECT COUNT(record_access_id) AS `tweek` FROM ($baseQueryGetAct) var WHERE YEARWEEK(record_access_in) = YEARWEEK(NOW()) OR YEARWEEK(record_access_out) = YEARWEEK(NOW()) ");
    $countActUser2 = $queryGetAct2->fetch_array();
    $actThisWeek = $countActUser2['tweek'];

    $queryGetAct3 = $connect->query("SELECT COUNT(record_access_id) AS `tmonth` FROM ($baseQueryGetAct) var WHERE MONTH(record_access_in) = MONTH(NOW()) OR MONTH(record_access_out) = MONTH(NOW()) ");
    $countActUser3 = $queryGetAct3->fetch_array();
    $actThisMonth = $countActUser3['tmonth'];

    $queryGetAct4 = $connect->query("SELECT COUNT(record_access_id) AS `tall` FROM ($baseQueryGetAct) var");
    $countActUser4 = $queryGetAct4->fetch_array();
    $actAllTime = $countActUser4['tall'];

    $data = array("today" => $actToday, "week" => $actThisWeek, "month" => $actThisMonth, "all"  => $actAllTime);
    set_response(true, "Data found", $data);

}

function getActivityByIdHw($id){
    global $connect;

    $baseQueryGetAct = "SELECT * FROM record_access WHERE hw_id = '$id'";
    $sTime = date('Y-m-d', strtotime(myDateTimeGenerator()));
  
    $queryGetAct1 = $connect->query("SELECT COUNT(record_access_id) AS `tdy` FROM ($baseQueryGetAct) var WHERE record_access_in LIKE '%$sTime%' OR record_access_out LIKE '%" . $sTime . "%' ");
    $countActUser1 = $queryGetAct1->fetch_array();
    $actToday = $countActUser1['tdy'];
  
    $queryGetAct2 = $connect->query("SELECT COUNT(record_access_id) AS `tweek` FROM ($baseQueryGetAct) var WHERE YEARWEEK(record_access_in) = YEARWEEK(NOW()) OR YEARWEEK(record_access_out) = YEARWEEK(NOW()) ");
    $countActUser2 = $queryGetAct2->fetch_array();
    $actThisWeek = $countActUser2['tweek'];
  
    $queryGetAct3 = $connect->query("SELECT COUNT(record_access_id) AS `tmonth` FROM ($baseQueryGetAct) var WHERE MONTH(record_access_in) = MONTH(NOW()) OR MONTH(record_access_out) = MONTH(NOW()) ");
    $countActUser3 = $queryGetAct3->fetch_array();
    $actThisMonth = $countActUser3['tmonth'];

    $queryGetAct4 = $connect->query("SELECT COUNT(record_access_id) AS `tall` FROM ($baseQueryGetAct) var");
    $countActUser4 = $queryGetAct4->fetch_array();
    $actAllTime = $countActUser4['tall'];

    $data = array("today" => $actToday, "week" => $actThisWeek, "month" => $actThisMonth, "all"  => $actAllTime);
    set_response(true, "Data found", $data);

}

?>