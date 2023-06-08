<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if (!empty($_GET['id'])) {
            getAccountById($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
    break;
    case 'POST':
        if (!empty($_GET['id'])) {
            updateAccountById($_GET['id']);
        } else {
            createAccount();
        }
    break;
    case 'DELETE':
        if (!empty($_GET['id'])) {
            deleteAccountById($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
    break;
    default:
        set_response(false, "Wrong method", []);
        break;
    break;
}


function createAccount(){
    global $connect;
    if (!empty($_POST['accountName']) && !empty($_POST['accountEmail']) && !empty($_POST['accountPhone']) && 
    !empty($_POST['accountAddress']) && !empty($_POST['accountLevel']) && !empty($_POST['accountImage']) ) {
        
        $idGen = myIdGenerator("AW");
        $name = $_POST['accountName'];
        $email = $_POST['accountEmail'];
        $phone = $_POST['accountPhone'];
        $address = $_POST['accountAddress'];
        $level = $_POST['accountLevel'];
        $file_name = myImageNameGenerator($_POST['accountImage']);
        $dateNow = myDateTimeGenerator();

        checkEmailAccount($email, "");
        checkPhoneAccount($phone, "");

        $sqlCreate = "INSERT INTO `account_detail` (`account_detail_id`, `account_name`, `account_email`, `account_phone`, `account_address`, `account_level`, `account_image`, `account_create_at`, `account_update_at`) 
        VALUES ('$idGen', '$name', '$email', '$phone', '$address', '$level', '$file_name', '$dateNow', '$dateNow')";
        $createAcc = mysqli_query($connect, $sqlCreate);

        $idLGen = myIdGenerator("AL");
        $sqlCreateLogin = "INSERT INTO `account_login` (`account_id`, `account_username`, `account_password`, `account_create_at`, `account_update_at`, `account_detail_id`) 
        VALUES ('$idLGen', '', '', '$dateNow', '$dateNow', '$idGen')";
        $createAccLogin = mysqli_query($connect, $sqlCreateLogin);

        $showId = array("ID Account"=>$idGen, "ID Login"=>$idLGen);
        if ($createAcc && $createAccLogin){
            set_response(true, "Account created successfully", $showId);
        } else {
            set_response(false, "Account failed to create", []);
        }
    } else {
        set_response(false, "Body request is not complete", []);
    }
}

function getAccountById($id){
    global $connect;
    $sql_gacc = "SELECT `d`.`account_name` AS `name`, `d`.`account_email` AS `email`, `d`.`account_phone` AS `phone`, `d`.`account_address` AS `address`, 
    `d`.`account_level` AS `level`, `d`.`account_image` AS `image`, `l`.`account_username` AS `username`, `l`.`account_password` AS `password`
    FROM `account_login` `l` 
    INNER JOIN `account_detail` `d` ON `l`.`account_detail_id` = `d`.`account_detail_id`
    WHERE `d`.`account_detail_id` = '$id'";

    $query_gacc = mysqli_query($connect, $sql_gacc);
    $dataAcc = array();
    while ($rowAcc = mysqli_fetch_assoc($query_gacc)) {
        $dataAcc[] = $rowAcc;
    }

    $jumlah_gacc = mysqli_num_rows($query_gacc);
    if ($jumlah_gacc > 0){
        set_response(true, "Account found", $dataAcc[0]);
    } else {
        set_response(false, "Account not found", []);
    }
  
}

function updateAccountById($id){
    global $connect;
    $sql_gid = "SELECT * FROM `account_detail` WHERE `account_detail_id`='$id'";
    $query_gid = mysqli_query($connect, $sql_gid);
    $jumlah_gid = mysqli_num_rows($query_gid);

    if ($jumlah_gid > 0){

        if (
            !empty($_POST['accountName']) && !empty($_POST['accountEmail']) && !empty($_POST['accountPhone']) &&
            !empty($_POST['accountAddress']) && !empty($_POST['accountLevel']) && !empty($_POST['accountUsername'])
        ) {

            $name = $_POST['accountName'];
            $email = $_POST['accountEmail'];
            $phone = $_POST['accountPhone'];
            $address = $_POST['accountAddress'];
            $level = $_POST['accountLevel'];
            $uP = "";
            $dateNow = myDateTimeGenerator();
            $statFile = "";

            checkEmailAccount($email, $id);
            checkPhoneAccount($phone, $id);
            checkUsernameLogin($_POST['accountUsername'], $id);

            if (!empty($_POST['accountImage'])){
                $imageName = $_POST['accountImage'];
                $newImageName = myImageNameGenerator($imageName);

                $sql_gu = "SELECT `account_image` FROM `account_detail` WHERE `account_detail_id`='$id'"; //Get Gambar
                $query_gu = mysqli_query($connect, $sql_gu);
                $jumlah_gu = mysqli_num_rows($query_gu);
                if ($jumlah_gu > 0) {
                    while ($data_gu = mysqli_fetch_row($query_gu)) {
                        $foto = $data_gu[0];
                
                        $fileExistDir = "../admin/media/foto/$foto";
                        if(file_exists($fileExistDir)){
                            unlink("../admin/media/foto/$foto"); //Menghapus Gambar
                            $statFile = "File deleted";
                        } else {
                            $statFile = "File not found";
                        }
                    }
                }

                $sqlU = "UPDATE `account_detail` SET `account_name`='$name', `account_email`='$email', `account_phone`='$phone', `account_address`='$address', 
                `account_level`='$level', `account_image`='$newImageName', `account_update_at`='$dateNow'  WHERE `account_detail_id`='$id'";
                $updateAcc = mysqli_query($connect, $sqlU);
            } else {
                $sqlU = "UPDATE `account_detail` SET `account_name`='$name', `account_email`='$email', `account_phone`='$phone', `account_address`='$address', 
                `account_level`='$level', `account_update_at`='$dateNow'  WHERE `account_detail_id`='$id'";
                $updateAcc = mysqli_query($connect, $sqlU);
            }

            // if (!empty($_POST['accountUsername'])){
                $uName = $_POST['accountUsername'];
                $uN = mysqli_real_escape_string($connect, $uName);
            // }
            if (!empty($_POST['accountPassword'])){
                $uPass = md5(md5($_POST['accountPassword']));
                $uP = mysqli_real_escape_string($connect, $uPass);
                $sql_rf = "UPDATE `account_login` SET `account_username`='$uN', `account_password`='$uP' WHERE `account_detail_id`='$id'";
            } else {
                $sql_rf = "UPDATE `account_login` SET `account_username`='$uN' WHERE `account_detail_id`='$id'";
            }

            $updateAccLogin = mysqli_query($connect, $sql_rf);

            $sql_gacc = "SELECT `d`.`account_name` AS `name`, `d`.`account_email` AS `email`, `d`.`account_phone` AS `phone`, 
            `d`.`account_address` AS `address`, `d`.`account_level` AS `level`, `d`.`account_image` AS `image`, `l`.`account_username` AS `username`
            FROM `account_login` `l` 
            INNER JOIN `account_detail` `d` ON `l`.`account_detail_id` = `d`.`account_detail_id`
            WHERE `d`.`account_detail_id` = '$id'";
            
            $query_gacc = mysqli_query($connect, $sql_gacc);
            $showData = array();
            while ($rowAcc = mysqli_fetch_assoc($query_gacc)) {
                $showData[] = $rowAcc;
            }

            $showFinal = array("Account"=>$showData, "Image Status"=>$statFile);
            if ($updateAcc) {
                set_response(true, "Account updated successfully", $showFinal);
            } else {
                set_response(false, "Account failed to update", []);
            }

        } else {
            set_response(false, "Body request is not complete", []);
        }

    } else {
        set_response(false, "Account not found", []);
    }

}

function deleteAccountById($id) {
    global $connect;
    
    $splitId = explode("SS",$id);
    $id = $splitId[0];
    $sessId = $splitId[1];

    if (!empty($sessId) && $sessId != "") {
        checkSessionAccount($sessId, $id);

        $sql_gid = "SELECT * FROM `account_detail` WHERE `account_detail_id`='$id'";
        $query_gid = mysqli_query($connect, $sql_gid);
        $jumlah_gid = mysqli_num_rows($query_gid);
        if ($jumlah_gid > 0) {

            $sql_gu = "SELECT `account_image` FROM `account_detail` WHERE `account_detail_id`='$id'"; //Get Gambar
            $query_gu = mysqli_query($connect, $sql_gu);
            $jumlah_gu = mysqli_num_rows($query_gu);
            if ($jumlah_gu > 0) {
                while ($data_gu = mysqli_fetch_row($query_gu)) {
                    $foto = $data_gu[0];

                    $fileExistDir = "../admin/media/foto/$foto";
                    if (file_exists($fileExistDir)) {
                        unlink("../admin/media/foto/$foto"); //Menghapus Gambar
                        $statFile = "File deleted";
                    } else {
                        $statFile = "File not found";
                    }
                }
            }

            $sql_dh = "DELETE FROM `account_detail` WHERE `account_detail_id` = '$id'"; //Hapus User
            $delAcc = mysqli_query($connect, $sql_dh);

            if ($delAcc) {
                set_response(true, "Account deleted successfully", $statFile);
            } else {
                set_response(false, "Account failed to delete", []);
            }
        } else {
            set_response(false, "Account not found", []);
        }
    } else {
        set_response(false, "Requires body session id", $splitId[1]);
    }

}

function checkUsernameLogin($data, $id){
    global $connect;
    $query_cul = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `account_login` WHERE `account_username`='$data' AND `account_detail_id` != '$id'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];
    if ($jumlahRow >= 1){
        set_response(false, "Username already used", $data);
        exit;
    } else {
        return "OK";
    }
}

function checkEmailAccount($data, $id){
    global $connect;
    $query_cul = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `account_detail` WHERE `account_email`='$data' AND `account_detail_id` != '$id'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];
    if ($jumlahRow >= 1){
        set_response(false, "Email already used", $data);
        exit;
    } else {
        return "OK";
    }
}

function checkPhoneAccount($data, $id){
    global $connect;
    $query_cul = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `account_detail` WHERE `account_phone`='$data' AND `account_detail_id` != '$id'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];
    if ($jumlahRow >= 1){
        set_response(false, "Phone number already used", $data);
        exit;
    } else {
        return "OK";
    }
}

function checkSessionAccount($data, $id){
    if ($data == $id){
        set_response(false, "Can not delete the current account", $data);
        exit;
    } else {
        return "OK";
    }
}

?>