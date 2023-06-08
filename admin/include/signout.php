<?php
// session_start();
$_SESSION['id_user_54'] = '';
$_SESSION['level_54'] = '';
$_SESSION['msgNotif'] = '';
unset($_SESSION['id_user_54']);
unset($_SESSION['level_54']);
unset($_SESSION['msgNotif']);

session_unset();
session_destroy();
header("Location:index");
?>