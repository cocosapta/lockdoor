<?php
require_once '../../config/config.php';

if (!empty($_GET['var1'])) {
  $id_hw = $_GET['var1'];
  $jsonRealCurrentById = json_decode(_getDataCurrentById($id_hw), TRUE);
  $valueStatus = $jsonRealCurrentById['status'];
  if ($valueStatus == "ONLINE"){ ?> 
    <b id="myCurrent2"></b>
  <?php } else { ?>
    <b> 0 </b>
    <?php }
?>


<script>
  document.getElementById("myCurrent2").innerHTML = "<?php echo $jsonRealCurrentById['data'][14]['current'] ?>";
</script>

<?php } ?>