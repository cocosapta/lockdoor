<?php
include "../../../config/config.php";

$jsonListUsers= json_decode(_getAllUsers(), TRUE);

if(isset($_POST["hw_id"]))
{
$output = '';
$output .= '<div class="table-responsive">
<table class="table table-bordered table-hover table-sm" id="tableRecAccess">
<thead class="thead-light">
    <tr>
        <th><center>No</center></th>
        <th><center>NIM</center>
        <th><center>Nama</center>
        <th><center>Kelas</center>
        <th><center>Opsi</center>
    </tr>
</thead>
<tbody>

';
$no = 1;
foreach ($jsonListUsers['data'] as $value) {
    $output .= '
    <tr>
        <td>'.$no++.'</td>
        <td>'.$value["nim"].'</td>
        <td>'.$value["name"].'</td>
        <td>'.$value["class"].'</td>
        <td><center>
        <a href=\'confirm-add-whitelist='.$value['id'].'-on='.$_POST["hw_id"].'\' class=\'btn-success btn-sm\'> Tambah </a>
        </center></td>
   </tr>
     ';
}
$output .= '</tbody></table></div>';
echo $output;
}
// echo $baseUrlApi;
?>