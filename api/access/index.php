<?php 
if (!empty($_GET['id'])){
    $stringToSlice = $_GET['id'];
    $afterSlice = substr($stringToSlice, 0, 2);
    switch ($afterSlice) {
        case 'US':
            include("ajax_rec_access_users.php");
          break;
        case 'HW':
            include("ajax_rec_access_hardware.php");
          break;
        default:
            $result = array(
                "isSuccess" => false,
                "message" => "Incorrect type id",
                "code" => 404
            );
            echo json_encode($result);
      }
      
} else {
    include("ajax_rec_access.php");
}
?>