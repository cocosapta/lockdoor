<?php
require_once '../../../config/config.php';
$jsonPanelDashboard = json_decode(_getDataPanelDashboard(), TRUE);

$no = 1;
foreach ($jsonPanelDashboard['listInRoom'] as $value) {
    if ($value["duration"] == "0"){
        $recOut = "In Room";
        $recDur = diffAccessTemp($value['time_in']);
    }
    ?>
    <tr>
        <td><?php echo $no++;?></td>
        <td><?php echo $value["name"];?></td>
        <td><?php echo $value["room"];?></td>
        <td><?php echo $value["time_in"];?></td>
        <td><?php echo $recDur;?></td>
   </tr>
   <?php } ?>

<?php  
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