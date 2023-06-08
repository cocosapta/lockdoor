<?php
require_once '../../config/config.php';

if (!empty($_GET['var1'])) {
  $id_hw = $_GET['var1'];
  $jsonRealStatus = json_decode(_getDataCurrentById($id_hw), TRUE);
  $valueStatus = $jsonRealStatus['status'];
  if ($valueStatus == "ONLINE"){ ?> 
    <b id="myStts" style="color: green;"></b>
  <?php } else { ?>
    <b id="myStts" style="color: red;"></b>
    <?php }
?>

<script>
  document.getElementById("myStts").innerHTML = "<?php echo $valueStatus; ?>";
</script>

<?php } ?>