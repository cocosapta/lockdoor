<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if (!empty($_GET['id'])) {
            getPassword($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
        break;
    case 'POST':
        if (!empty($_GET['id'])) {
            updatePassword($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
        break;
    default:
        set_response(false, "Wrong method", []);
        break;
    break;
}


function getPassword($id){
    global $connect;
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
        $sql_up = "SELECT `d`.`account_name` AS `name`, `a`.`account_password` AS `password` 
        FROM `account_login` `a`
        INNER JOIN `account_detail` `d` ON `a`.`account_detail_id` = `d`.`account_detail_id` 
        WHERE `a`.`account_detail_id`='$id'";
        $query_up = mysqli_query($connect, $sql_up);
        $dataExist = array();
        while ($data_up = mysqli_fetch_row($query_up)) {
            $dataExist[] = censorString($data_up[0]);
            $dataExist[] = $data_up[1];
        }
        if (mysqli_num_rows($query_up) > 0) {
            set_response(true, "Account found", $dataExist); //show column data
        } else {
            set_response(false, "Account not found", []);
        }
    } else {
        set_response(false, "Requires parameter id", []);
    }
}

function updatePassword($id){
    global $connect;
    if (!empty($_GET['id']) && !empty($_POST['newPassword'])) {
        $id = $_GET['id'];
        $enPass = md5(md5($_POST['newPassword']));
        $password = mysqli_real_escape_string($connect, $enPass);
        $dateNow = myDateTimeGenerator();
        $sql = "UPDATE `account_login` SET `account_password`='$password', `account_update_at`='$dateNow' WHERE `account_detail_id`='$id'";
        $updatePw = mysqli_query($connect, $sql);
        if ($updatePw){
            set_response(true, "Password has been updated", []);
        } else {
            set_response(false, "Password failed to update", []);
        }
    } else {
        set_response(false, "Body request is not complete", []);
    }
    
}

function censorString($string){
	$pecahStr = explode(" ", $string);
	$final = "";
	for ( $i = 0; $i < count($pecahStr); $i++ ) {
		$countChar = strlen($pecahStr[$i]);
		// $countCensored = $countChar;
		$nonCensor = mb_substr($pecahStr[$i], 0, 3);
		$final .= $nonCensor."xxx ";
	}
	return $final;
}

?>