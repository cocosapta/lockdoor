<?php
date_default_timezone_set('Asia/Jakarta');

// -------------------FOR OFFLINE DATABASE-------------------//
// $databaseHost = 'localhost';
// $databaseName = 'iot_esp_rfid';
// $databaseUsername = 'root';
// $databasePassword = '';

// $connect = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 

// if (!$connect) {
//     die("<script>alert('Gagal tersambung dengan database !')</script>");
// }else{
//     die("<script>alert('Berhasil tersambung dengan database !')</script>");
// }
//-------------------FOR OFFLINE DATABASE-------------------//

// $baseUrl = "https://geomantic-key.000webhostapp.com/simonturu/";
$baseUrl = "https://sl.sepatukyuu.my.id/ESP-RFID/";
$baseUrlApi = $baseUrl . "api/";
$baseUrlApiGraph = $baseUrlApi . "chart/";
$baseUrlMedia = "https://sl.sepatukyuu.my.id/ESP-RFID/admin/media/";
$baseKeyApi = "bf06e2ae53348e7d0070c43d83aaf997";

// Get Data Panel Dashboard
function _getDataPanelDashboard()
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "dashboard-panel";
    $options = array(
        "http" => array(
            "method" => "GET",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi"
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Get Count Activity by User / Device
function _getCountActivityById($idC)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "activity/" . $idC;
    $options = array(
        "http" => array(
            "method" => "GET",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi"
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Login  Web Dash
function _loginWebAdmin($userN, $passW)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "profil";
    $data = array("username" => $userN, "password" => $passW);
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

//------------------------------------------------  PROFIL  ------------------------------------------------------------
// Get Profil by Id
function _getProfileDetails($id_detail)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "profil/" . $id_detail;
    $options = array(
        "http" => array(
            "method" => "GET",
            // "header" => "Content-Type: application/x-www-form-urlencoded",
            // "header" => "Token: $baseKeyApi"
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Update Profil tanpa Gambar
function _updateProfile($idProfile, $nameP, $emailP, $phoneP, $addressP)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "profil/" . $idProfile;
    $data = array(
        "profilName" => $nameP,
        "profilEmail" => $emailP,
        "profilPhone" => $phoneP,
        "profilAddress" => $addressP
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Update Profil dengan Gambar
function _updateProfileWithImg($idProfile, $nameP, $emailP, $phoneP, $addressP, $imageP)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "profil/" . $idProfile;
    $data = array(
        "profilName" => $nameP,
        "profilEmail" => $emailP,
        "profilPhone" => $phoneP,
        "profilAddress" => $addressP,
        "profilImage" => $imageP
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Get Password Profil
function _getProfilePassword($idProfile)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "password/" . $idProfile;
    $options = array(
        "http" => array(
            "method" => "GET",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Update Password Profil
function _updateProfilePassword($idProfile, $pass)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "password/" . $idProfile;
    $data = array(
        "newPassword" => $pass,
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

//------------------------------------------------  AKUN  ------------------------------------------------------------
// Create Akun
function _addAccountWeb($nm, $em, $ph, $adrs, $lev, $img)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "account";
    $data = array(
        "accountName" => $nm,
        "accountEmail" => $em,
        "accountPhone" => $ph,
        "accountAddress" => $adrs,
        "accountLevel" => $lev,
        "accountImage" => $img
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Get Akun by Id
function _getAccountWebById($idAcc)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "account/" . $idAcc;
    $options = array(
        "http" => array(
            "method" => "GET",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Update Akun tanpa Gambar
function _updateAccountWeb($idU, $nm, $em, $ph, $adrs, $lev, $un, $pw)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "account/" . $idU;
    $data = array(
        "accountName" => $nm,
        "accountEmail" => $em,
        "accountPhone" => $ph,
        "accountAddress" => $adrs,
        "accountLevel" => $lev,
        "accountUsername" => $un,
        "accountPassword" => $pw
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Update Akun dengan Gambar
function _updateAccountWebWithImg($idU, $nm, $em, $ph, $adrs, $lev, $img, $un, $pw)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "account/" . $idU;
    $data = array(
        "accountName" => $nm,
        "accountEmail" => $em,
        "accountPhone" => $ph,
        "accountAddress" => $adrs,
        "accountLevel" => $lev,
        "accountImage" => $img,
        "accountUsername" => $un,
        "accountPassword" => $pw
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Delete Akun
function _deleteAccountWeb($idAcc, $sessId)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "account/" . $idAcc . "SS" . $sessId;
    $options = array(
        "http" => array(
            "method" => "DELETE",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

//------------------------------------------------  PENGGUNA  ------------------------------------------------------------
// Check-in dari alat RFID
function _getExistanceUser($tagCode, $hwCode, $hwType, $kode)
{
    global $baseUrlApi;
    $url = $baseUrlApi . "access";
    $endPoint = $url . "/tag=" . $tagCode . "-hw=" . $hwCode . "-type=" . $hwType;
    $datTest = file_get_contents($endPoint);
    $jsonTest = json_decode($datTest, TRUE);

    $isSuc = $jsonTest['isSuccess'];
    $msg = $jsonTest['message'];
    // $level = $jsonTest['data']['account_level'];
    // return $msg;
    if ($isSuc == true) {
        echo "<script>alert('TRUE | $msg')</script>";
    } else {
        echo "<script>alert('FALSE | $msg')</script>";
    }
    if ($kode == "1") {
        $_SESSION['tabtest'] = "1";
    } else if ($kode == "2") {
        $_SESSION['tabtest'] = "2";
    }
}

// Create Pengguna
function _addUser($nim, $name, $class, $email, $phone, $address, $image)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "user";
    $data = array(
        "userNim" => $nim,
        "userName" => $name,
        "userClass" => $class,
        "userEmail" => $email,
        "userPhone" => $phone,
        "userAddress" => $address,
        "userImage" => $image
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Update Pengguna tanpa Gambar
function _updateUser($idUu, $nim, $name, $class, $email, $phone, $address, $username, $tag, $status)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "user/" . $idUu;
    $data = array(
        "userNim" => $nim,
        "userName" => $name,
        "userClass" => $class,
        "userEmail" => $email,
        "userPhone" => $phone,
        "userAddress" => $address,
        "userNick" => $username,
        "userTag" => $tag,
        "userStatus" => $status
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Update Pengguna by Id with Image
function _updateUserWithImage($idUu, $nim, $name, $class, $email, $phone, $address, $image, $username, $tag, $status)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "user/" . $idUu;
    $data = array(
        "userNim" => $nim,
        "userName" => $name,
        "userClass" => $class,
        "userEmail" => $email,
        "userPhone" => $phone,
        "userAddress" => $address,
        "userImage" => $image,
        "userNick" => $username,
        "userTag" => $tag,
        "userStatus" => $status
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Get Semua Pengguna
function _getAllUsers()
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "user";
    $options = array(
        "http" => array(
            "method" => "GET",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Get Pengguna by Id
function _getUserById($idUser)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "user/" . $idUser;
    $options = array(
        "http" => array(
            "method" => "GET",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Delete Pengguna by Id
function _deleteUser($idUser)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "user/" . $idUser;
    $options = array(
        "http" => array(
            "method" => "DELETE",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

//------------------------------------------------  ALAT  ------------------------------------------------------------
// Create Alat
function _addDevice($name, $desc)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "device";
    $data = array(
        "deviceName" => $name,
        "deviceDesc" => $desc
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Get Alat by Id
function _getDeviceById($idDev)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "device/" . $idDev;
    $options = array(
        "http" => array(
            "method" => "GET",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Update Alat
function _updateDevice($idDev, $name, $desc, $whiteL)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "device/" . $idDev;
    $data = array(
        "deviceName" => $name,
        "deviceDesc" => $desc,
        "deviceWhite" => $whiteL
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Delete Alat
function _deleteDevice($idDev)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "device/" . $idDev;
    $options = array(
        "http" => array(
            "method" => "DELETE",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

function _desDevice($idDev)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "device/" . $idDev;
    $options = array(
        "http" => array(
            "method" => "UNLOCK",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}
//------------------------------------------------  SENSOR ACS  ------------------------------------------------------------

// Get Data Sensor ACS by Id Device
function _getDataCurrentById($idDev)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "acs/" . $idDev;
    $options = array(
        "http" => array(
            "method" => "GET",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi"
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Get Data Sensor ACS by Id Device
// function getDataPowerById($idDev){
//     global $baseUrlApi, $baseKeyApi;
//     $url = $baseUrlApi."acs/power/".$idDev;
//     $options = array(
//         "http" => array(
//             "method" => "GET",
//             "header" => "Content-Type: application/json",
//             "header" => "Token: $baseKeyApi"
//         )
//     );
//     $response = file_get_contents($url, false, stream_context_create($options));
//     return $response;
// }

//------------------------------------------------  CHART  ------------------------------------------------------------

function _getDataChart($data)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "chart/" . $data;
    $options = array(
        "http" => array(
            "method" => "GET",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi"
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

function _getDataChartInOut($stat, $sTime, $fTime)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "chart/usersinout/";
    $data = array(
        "sTime" => $sTime,
        "fTime" => $fTime,
        "status" => $stat,
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            "header" => "Content-Type: application/x-www-form-urlencoded",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

//------------------------------------------------  WHiteList  ------------------------------------------------------------
// Create Whitelist
function _addWhitelist($uId, $dId)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "white-list";
    $data = array(
        "whitelistUserId" => $uId,
        "whitelistDeviceId" => $dId
    );
    $options = array(
        "http" => array(
            "method" => "POST",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}

// Delete Whitelist
function _deleteWhitelistById($idWl)
{
    global $baseUrlApi, $baseKeyApi;
    $url = $baseUrlApi . "white-list/" . $idWl;
    $options = array(
        "http" => array(
            "method" => "DELETE",
            // "header" => "Content-Type: application/json",
            // "header" => "Token: $baseKeyApi",
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    return $response;
}
