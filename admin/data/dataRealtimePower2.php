<?php
require_once '../../config/config.php';

if (!empty($_GET['var1'])) {
  $id_hw = $_GET['var1'];
  $jsonRealPowerId = json_decode(_getDataCurrentById($id_hw), TRUE);
  $valueStatus = $jsonRealPowerId['status'];
  if ($valueStatus == "ONLINE"){ ?> 
    <b id="myPower2"></b>
  <?php } else { ?>
    <b> 0 </b>
    <?php }
?>


<script>
  document.getElementById("myPower2").innerHTML = "<?php echo $jsonRealPowerId['data'][14]['power'] ?>";
</script>

<?php } ?>