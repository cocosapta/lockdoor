<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if (!empty($_GET['id'])) {
            getUserById($_GET['id']);
        } else {
            getAllUsers();
        }
        break;
    case 'POST':
        if (!empty($_GET['id'])) {
            updateUserById($_GET['id']);
        } else {
            createUser();
        }
        break;
    case 'DELETE':
        if (!empty($_GET['id'])) {
            deleteUserById($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
        break;
    default:
        set_response(false, "Wrong method", []);
        break;
    break;
}

function createUser(){
    global $connect;
    if (!empty($_POST['userNim']) && !empty($_POST['userName']) && !empty($_POST['userClass']) && !empty($_POST['userEmail']) 
    && !empty($_POST['userPhone']) && !empty($_POST['userAddress']) && !empty($_POST['userImage']) ) {
        
        $idUserGen = myIdGenerator("US");
        $userNim = $_POST['userNim'];
        $userName = $_POST['userName'];
        $userClass = $_POST['userClass'];
        $userEmail = $_POST['userEmail'];
        $userPhone = $_POST['userPhone'];
        $userAddress = $_POST['userAddress'];
        // $userNick = $_POST['userNick'];
        // $userTag = $_POST['userTag'];
        // $userStatus = $_POST['userStatus'];
        $userImage = myImageNameGenerator($_POST['userImage']);
        $dateNow = myDateTimeGenerator();

        checkNimUser($userNim, "");
        checkEmailUser($userEmail, "");
        checkPhoneUser($userPhone, "");

        $sqlCreateUser = "INSERT INTO `users_detail` (`users_detail_id`, `users_detail_nim`, `users_detail_name`, `users_detail_class`, `users_detail_email`, `users_detail_phone`, `users_detail_address`, `users_detail_image`, `users_detail_create_at`, `users_detail_update_at`) 
        VALUES ('".$idUserGen."', '".$userNim."', '".$userName."', '".$userClass."', '".$userEmail."', '".$userPhone."', '".$userAddress."', '".$userImage."', '".$dateNow."', '".$dateNow."')";
        $createUser = mysqli_query($connect, $sqlCreateUser);

        $idRGen = myIdGenerator("RF");
        $sqlCreateRf = "INSERT INTO `users_rfid` (`user_id`, `user_name`, `user_tag`, `user_status`, `user_create_at`, `user_update_at`, `users_detail_id`) 
        VALUES ('".$idRGen."', '', '', 'block', '".$dateNow."', '".$dateNow."', '".$idUserGen."')";
        $createRf = mysqli_query($connect, $sqlCreateRf);

        $showId = array("ID User" => $idUserGen, "ID Akses" => $idRGen);
        if ($createUser && $createRf){
            set_response(true, "Account created successfully", $showId);
        } else {
            set_response(false, "Account failed to create", []);
        }
    } else {
        set_response(false, "Body request is not complete", []);
    }
}

function getAllUsers(){
    global $connect;
    $sql_gus = "SELECT `d`.`users_detail_id` AS `id`, `d`.`users_detail_nim` AS `nim`, `d`.`users_detail_name` AS `name`, `d`.`users_detail_class` AS `class`, `d`.`users_detail_email` AS `email`, 
    `d`.`users_detail_phone` AS `phone`, `d`.`users_detail_address` AS `address`, `d`.`users_detail_image` AS `image`, `d`.`users_detail_create_at` AS `create_at`, `d`.`users_detail_update_at` AS `update_at`, 
    `r`.`user_id` AS `rid`, `r`.`user_name` AS `username`, `r`.`user_tag` AS `card`, `r`.`user_status` AS `status`, `r`.`user_create_at` AS `user_create_at`, `r`.`user_update_at` AS `user_update_at`
    FROM `users_detail` `d` 
    INNER JOIN `users_rfid` `r` ON `d`.`users_detail_id` = `r`.`users_detail_id`";
    
    $query_gus = mysqli_query($connect, $sql_gus);
    $dataUs = array();
    while ($rowUs = mysqli_fetch_assoc($query_gus)) {
        $dataUs[] = $rowUs;
    }

    $jumlah_gusid = mysqli_num_rows($query_gus);
    if ($jumlah_gusid > 0){
        set_response(true, "User found", $dataUs);
    } else {
        set_response(false, "User not found", []);
    }
}

function getUserById($id){
    global $connect;
    $sql_gusid = "SELECT `d`.`users_detail_nim` AS `nim`, `d`.`users_detail_name` AS `name`, `d`.`users_detail_class` AS `class`, `d`.`users_detail_email` AS `email`, 
    `d`.`users_detail_phone` AS `phone`, `d`.`users_detail_address` AS `address`, `d`.`users_detail_image` AS `image`, `d`.`users_detail_create_at` AS `create_at`, `d`.`users_detail_update_at` AS `update_at`, 
    `r`.`user_id` AS `rid`, `r`.`user_name` AS `username`, `r`.`user_tag` AS `card`, `r`.`user_status` AS `status`, `r`.`user_create_at` AS `user_create_at`, `r`.`user_update_at` AS `user_update_at`
    FROM `users_detail` `d` 
    INNER JOIN `users_rfid` `r` ON `d`.`users_detail_id` = `r`.`users_detail_id`
    WHERE `d`.`users_detail_id` = '$id'";
    
    $query_gusid = mysqli_query($connect, $sql_gusid);
    $dataUsid = array();
    while ($rowUsid = mysqli_fetch_assoc($query_gusid)) {
        $dataUsid[] = $rowUsid;
    }

    $jumlah_gusid = mysqli_num_rows($query_gusid);
    if ($jumlah_gusid > 0){
        set_response(true, "User found", $dataUsid[0]);
    } else {
        set_response(false, "User not found", []);
    }
}

function updateUserById($id){
    global $connect;
    $sql_gud = "SELECT * FROM `users_detail` WHERE `users_detail_id`='$id'";
    $query_gud = mysqli_query($connect, $sql_gud);
    $jumlah_gud = mysqli_num_rows($query_gud);

    if ($jumlah_gud > 0) {
        if (
            !empty($_POST['userNim']) && !empty($_POST['userName']) && !empty($_POST['userClass']) && !empty($_POST['userEmail'])
            && !empty($_POST['userPhone']) && !empty($_POST['userAddress'])
        ) {

            $userNim = $_POST['userNim'];
            $userName = $_POST['userName'];
            $userClass = $_POST['userClass'];
            $userEmail = $_POST['userEmail'];
            $userPhone = $_POST['userPhone'];
            $userAddress = $_POST['userAddress'];

            $userNick = "";
            $userTag = "";
            $userStatus = "block";
            
            $dateNow = myDateTimeGenerator();
            if (!empty($_POST['userNick'])){
                $userNick = $_POST['userNick']; 
            }
            if (!empty($_POST['userTag'])){
                $userTag = $_POST['userTag'];
            }
            if (!empty($_POST['userStatus'])){
                $userStatus = $_POST['userStatus'];
            }

            checkNimUser($userNim, $id);
            checkEmailUser($userEmail, $id);
            checkPhoneUser($userPhone, $id);
            checkNickUser($userNick, $id);
            checkTagUser($userTag, $id);

            $dateNow = myDateTimeGenerator();
            $statFile = "";

            if (!empty($_POST['userImage'])) {
                $imageName = $_POST['userImage'];
                $newImageName = myImageNameGenerator($imageName);

                $sql_gui = "SELECT `users_detail_image` FROM `users_detail` WHERE `users_detail_id`='$id'"; //Get Gambar
                $query_gui = mysqli_query($connect, $sql_gui);
                $jumlah_gui = mysqli_num_rows($query_gui);
                if ($jumlah_gui > 0) {
                    while ($data_gui = mysqli_fetch_row($query_gui)) {
                        $foto = $data_gui[0];
                        $statFile = deleteFileFoto($imageName);
                    }
                }

                $sqlU = "UPDATE `users_detail` SET `users_detail_nim`='$userNim', `users_detail_name`='$userName', `users_detail_class`='$userClass', 
                `users_detail_email`='$userEmail', `users_detail_phone`='$userPhone', `users_detail_address`='$userAddress', 
                `users_detail_image`='$newImageName', `users_detail_update_at`='$dateNow'  WHERE `users_detail_id`='$id'";
                $updateUser = mysqli_query($connect, $sqlU);
            } else {
                $sqlU = "UPDATE `users_detail` SET `users_detail_nim`='$userNim', `users_detail_name`='$userName', `users_detail_class`='$userClass', 
                `users_detail_email`='$userEmail', `users_detail_phone`='$userPhone', `users_detail_address`='$userAddress', 
                `users_detail_update_at`='$dateNow'  WHERE `users_detail_id`='$id'";
                $updateUser = mysqli_query($connect, $sqlU);
            }

            $sql_rf = "UPDATE `users_rfid` SET `user_name`='$userNick', `user_tag`='$userTag', `user_status`='$userStatus', `user_update_at`='$dateNow' WHERE `users_detail_id`='$id'";
            $updateURF = mysqli_query($connect, $sql_rf);

            $sql_guser = "SELECT `d`.`users_detail_nim` AS `nim`, `d`.`users_detail_name` AS `name`, `d`.`users_detail_class` AS `class`, `d`.`users_detail_email` AS `email`, 
            `d`.`users_detail_phone` AS `phone`, `d`.`users_detail_address` AS `address`, `d`.`users_detail_image` AS `image`, `d`.`users_detail_create_at` AS `create_at`, `d`.`users_detail_update_at` AS `update_at`, 
            `r`.`user_id` AS `rid`, `r`.`user_name` AS `username`, `r`.`user_tag` AS `card`, `r`.`user_status` AS `status`, `r`.`user_create_at` AS `user_create_at`, `r`.`user_update_at` AS `user_update_at`
            FROM `users_detail` `d` 
            INNER JOIN `users_rfid` `r` ON `d`.`users_detail_id` = `r`.`users_detail_id`
            WHERE `d`.`users_detail_id` = '$id'";

            $query_guser = mysqli_query($connect, $sql_guser);
            $showData = array();
            while ($rowAcc = mysqli_fetch_assoc($query_guser)) {
                $showData[] = $rowAcc;
            }

            $showFinal = array("User" => $showData, "Image Status" => $statFile);
            if ($updateUser) {
                set_response(true, "User updated successfully", $showFinal);
            } else {
                set_response(false, "User failed to update", []);
            }
        } else {
            set_response(false, "Body request is not complete", []);
        }

    } else {
        set_response(false, "User not found", []);
    }
}

function deleteUserById($id){
    global $connect;
    $fotogus = "";
    $sql_gud = "SELECT * FROM `users_detail` WHERE `users_detail_id`='$id'";
    $query_gud = mysqli_query($connect, $sql_gud);
    $jumlah_gud = mysqli_num_rows($query_gud);
    if ($jumlah_gud > 0){

        $sql_gus = "SELECT `users_detail_image` FROM `users_detail` WHERE `users_detail_id`='$id'"; //Get Gambar
        $query_gus = mysqli_query($connect, $sql_gus);
        $jumlah_gus = mysqli_num_rows($query_gus);
        if ($jumlah_gus > 0) {
          while ($data_gus = mysqli_fetch_row($query_gus)) {
            $fotogus = $data_gus[0];
          }
        }
    
        $sql_dus = "DELETE FROM `users_detail` WHERE `users_detail_id` = '$id'"; //Hapus User
        $delUser = mysqli_query($connect, $sql_dus);
    
        if ($delUser){
            $statusFile = deleteFileFoto($fotogus);
            set_response(true, "User deleted successfully", $statusFile);
        } else {
            set_response(false, "User failed to delete", []);
        }

    } else {
        set_response(false, "User not found", []);
    }

}

function checkNimUser($data, $id){
    global $connect;
    $query_cul = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `users_detail` WHERE `users_detail_nim`='$data' AND `users_detail_id` != '$id'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];
    if ($jumlahRow >= 1){
        set_response(false, "NIM already used", $data);
        exit;
    } else {
        return "OK";
    }
}

function checkEmailUser($data, $id){
    global $connect;
    $query_cul = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `users_detail` WHERE `users_detail_email`='$data' AND `users_detail_id` != '$id'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];
    if ($jumlahRow >= 1){
        set_response(false, "Email already used", $data);
        exit;
    } else {
        return "OK";
    }
}

function checkPhoneUser($data, $id){
    global $connect;
    $query_cul = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `users_detail` WHERE `users_detail_phone`='$data' AND `users_detail_id` != '$id'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];
    if ($jumlahRow >= 1){
        set_response(false, "Phone number already used", $data);
        exit;
    } else {
        return "OK";
    }
}

function checkNickUser($data, $id){
    global $connect;
    $query_cul = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `users_rfid` WHERE `user_name`='$data' AND `users_detail_id` != '$id'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];
    if ($jumlahRow >= 1){
        set_response(false, "Nickname already used", $data);
        exit;
    } else {
        return "OK";
    }
}
function checkTagUser($data, $id){
    global $connect;
    $query_cul = $connect->query("SELECT COUNT(*) AS `jumlah` FROM `users_rfid` WHERE `user_tag`='$data' AND `users_detail_id` != '$id'");
    $count_cul = $query_cul->fetch_array();
    $jumlahRow = $count_cul['jumlah'];
    if ($jumlahRow >= 1){
        set_response(false, "Card already used", $data);
        exit;
    } else {
        return "OK";
    }
}
?>