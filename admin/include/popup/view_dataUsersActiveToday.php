<?php
include "../../../config/config.php";

$jsonPanelDashboard = json_decode(_getDataPanelDashboard(), TRUE);

// if(isset($_POST["employee_id"]))
// {
$output = '';
$output .= '<div class="table-responsive">
<table class="table table-bordered table-hover table-sm" id="tableRecAccess">
<thead class="thead-light">
    <tr>
        <th><center>No</center></th>
        <th><center>NIM</center>
        <th><center>Nama</center>
        <th><center>Kelas</center>
    </tr>
</thead>
<tbody>

';
$no = 1;
foreach ($jsonPanelDashboard['listUsersOnToday'] as $value) {
    $output .= '
    <tr>
        <td>'.$no++.'</td>
        <td>'.$value["nim"].'</td>
        <td>'.$value["name"].'</td>
        <td>'.$value["class"].'</td>
   </tr>
     ';
}
$output .= '</tbody></table></div>';
echo $output;
// }
// echo $baseUrlApi;
?>