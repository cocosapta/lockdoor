<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if (!empty($_GET['id'])) {
            profDetail($_GET['id']);
        } else {
            set_response(false, "Requires parameter id", []);
        }
        break;
    case 'POST':
        if (!empty($_GET['id'])) {
            profUpdate($_GET['id']);
        } else {
            loginWeb();
        }
        break;
    default:
        set_response(false, "Wrong method", []);
        break;
    break;
}

function loginWeb() {
    global $connect;
    if (!empty($_POST['username']) && !empty($_POST['password'])) {

        $user = $_POST['username'];
        $pass = md5(md5($_POST['password']));

        $username = mysqli_real_escape_string($connect, $user);
        $password = mysqli_real_escape_string($connect, $pass);

        $query = "SELECT `l`.`account_detail_id` AS `id`, `d`.`account_level` AS `level` 
        FROM `account_login` `l` 
        INNER JOIN `account_detail` `d` ON `l`.`account_detail_id` = `d`.`account_detail_id` 
        WHERE `l`.`account_username`='$username' AND `l`.`account_password`='$password'";

        $get = mysqli_query($connect, $query);
        $data = array();
        while ($row = mysqli_fetch_assoc($get)) {
            $data[] = $row;
        }

        if (mysqli_num_rows($get) > 0) {
            set_response(true, "Access granted", $data[0]); //show column data
        } else {
            set_response(false, "Access denied", []);
        }
    } else {
        set_response(false, "Body request is not complete", []);
    }
}

function profDetail($id) {
    global $connect;
    if (!empty($_GET['id'])) {

        $id = $_GET['id'];

        $query = "SELECT `account_name` AS `name`, `account_email` AS `email`, `account_phone` AS `phone`, `account_address` AS `address`, 
        `account_image` AS `image`, `account_level` AS `level` 
        FROM `account_detail` WHERE `account_detail_id`='$id'";

        $get = mysqli_query($connect, $query);
        $data = array();
        while ($row = mysqli_fetch_assoc($get)) {
            $data[] = $row;
        }

        if (mysqli_num_rows($get) > 0) {
            set_response(true, "Account found", $data[0]); //show column data
        } else {
            set_response(false, "Account not found", []);
        }
    } else {
        set_response(false, "Requires parameter id", []);
    }
}

function profUpdate($id) {
    global $connect, $baseUrlMedia;
    $timeUpload = date('dmYHis');

    $sql_gup = "SELECT * FROM `account_detail` WHERE `account_detail_id`='$id'";
    $query_gup = mysqli_query($connect, $sql_gup);
    $jumlah_gup = mysqli_num_rows($query_gup);


    if ($jumlah_gup > 0) {
        if (!empty($_POST['profilName']) && !empty($_POST['profilEmail']) && !empty($_POST['profilPhone']) && !empty($_POST['profilAddress'])) {

            $id_user = $id;
            $nama = $_POST['profilName'];
            $email = $_POST['profilEmail'];
            $telepon = $_POST['profilPhone'];
            $alamat = $_POST['profilAddress'];
            $statFile = "";
            // $fileFoto = $_FILES['profilImage'];
            checkEmailProfile($email, $id);
            checkPhoneProfile($telepon, $id);

            if (!empty($_POST['profilImage'])){
                $imageName = $_POST['profilImage'];
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

                $sql = "UPDATE `account_detail` SET `account_name`='$nama', `account_email`='$email', `account_phone`='$telepon', `account_address`='$alamat', `account_image`='$newImageName' WHERE `account_detail_id`='$id_user'";
                $update = mysqli_query($connect, $sql);
            } else {
                $sql = "UPDATE `account_detail` SET `account_name`='$nama', `account_email`='$email', `account_phone`='$telepon', `account_address`='$alamat' WHERE `account_detail_id`='$id_user'";
                $update = mysqli_query($connect, $sql);
            }

            $query = "SELECT `account_name` AS `name`, `account_email` AS `email`, `account_phone` AS `phone`, `account_address` AS `address`, 
            `account_image` AS `image`, `account_level` AS `level` 
            FROM `account_detail` WHERE `account_detail_id`='$id'";

            $get = mysqli_query($connect, $query);
            $data = array();
            while ($row = mysqli_fetch_assoc($get)) {
                $data[] = $row;
            }


            if ($update) {
                set_response(true, "Profile updated successfully", $statFile);
            } else {
                set_response(false, "Profile failed to update", $statFile);
            }
        } else {
            set_response(false, "Body request is not complete", []);
        }
    } else {
        set_response(false, "Account not found", []);
    }
    
}

function checkEmailProfile($data, $id){
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

function checkPhoneProfile($data, $id){
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

// $data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format

// $fileName  =  $_FILES['profilImage']['name'];
// $tempPath  =  $_FILES['profilImage']['tmp_name'];
// $fileSize  =  $_FILES['profilImage']['size'];

// if (empty($fileName)) {
//     set_response(true, "Foto kosong", $_FILES);
// } else {
//     $upload_path = 'upload/'; // set upload folder path 
//     $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // get image extension
//     // valid image extensions
//     $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
//     // allow valid image file formats
//     if (in_array($fileExt, $valid_extensions)) {
//         //check file not exist our upload folder path
//         if (!file_exists($upload_path . $fileName)) {
//             // check file size '5MB'
//             if ($fileSize < 500000000) {
//                 move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
//             } else {
//                 set_response(true, "Foto terlalu besar", $_FILES);
//             }
//         } else {
//             set_response(true, "Foto sudah ada", $_FILES);
//         }
//     } else {
//         set_response(true, "Tipe file salah", $_FILES);
//     }
// }

?>