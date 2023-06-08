<?php

if (!empty($_GET['idDel'])) {
    $id_user = $_GET['idDel'];
    $id_sess = $_SESSION['id_user_54'];
        $jsonDelAccount = json_decode(_deleteAccountWeb($id_user, $id_sess), TRUE);
        $isSuc = $jsonDelAccount['isSuccess'];
        $msg = $jsonDelAccount['message'];

        if ($isSuc) {
            header("Location:accounts_notif-successDelete");
            $_SESSION['msgNotif'] = $msg;
        } else {
            header("Location:accounts_notif-errorDelete");
            $_SESSION['msgNotif'] = $msg;
        }

}

?>