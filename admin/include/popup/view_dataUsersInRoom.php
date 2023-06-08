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
        <th><center>Nama</center>
        <th><center>Ruang</center>
        <th><center>Waktu Masuk</center>
        <th><center>Durasi</center>
    </tr>
</thead>
<tbody>

';
$no = 1;
foreach ($jsonPanelDashboard['listInRoom'] as $value) {
    if ($value["duration"] == "0"){
        $recOut = "In Room";
        $recDur = diffAccessTemp($value['time_in']);
    }
    $output .= '
    <tr>
        <td>'.$no++.'</td>
        <td>'.$value["name"].'</td>
        <td>'.$value["room"].'</td>
        <td>'.$value["time_in"].'</td>
        <td class="recDur">'.$recDur.'</td>
   </tr>
     ';
}
$output .= '</tbody></table></div>';
echo $output;
// }
// echo $baseUrlApi;
function diffAccessTemp($startTime){
    date_default_timezone_set('Asia/Jakarta');
    $tempTimeNow = strtotime(date("Y-m-d H:i:s"));
    $tempTimeStart = strtotime($startTime);

    $diffTemp = $tempTimeNow - $tempTimeStart;
    $jam = floor($diffTemp / (60 * 60));
    $menit = $diffTemp - ( $jam * (60 * 60) );
    $detik = $diffTemp % 60;
    $timeDiff =  $jam." Jam ".floor($menit/60)." Menit ".$detik." Detik";
    return $timeDiff;
}
?>
<!-- <script>
$(document).ready(function() {
 		setInterval(function(){
 			$("td.recDur").load("diffAccessTemp.php?startTime"), 1000
 		})
});
</script> -->