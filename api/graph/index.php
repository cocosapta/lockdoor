<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if (!empty($_GET['kind'])) {
            switch ($_GET['kind']) {
                case 'busy':
                    include("get_data_busy_time_today.php");
                break;
                case 'dailyvisit':
                    include("get_data_daily_visitor.php");
                break;
                case 'powerconsum':
                    include("get_data_power_consumtion.php");
                break;
                default:
                    set_response(false, "Wrong kind", []);
                    break;
                break;
            }
        } else {
            set_response(false, "Requires parameter kind", []);
        }
        break;
    case 'POST':
        if (!empty($_GET['kind'])) {
            switch ($_GET['kind']) {
                case 'usersinout':
                    if (!empty($_POST['sTime']) && !empty($_POST['fTime']) && !empty($_POST['status'])) {
                        include("get_data_users_in_out.php");
                    } else {
                        set_response(false, "Requires status, sTime and fTime", []);
                    }
                break;
                default:
                    set_response(false, "Wrong kind", []);
                    break;
                break;
            }
        } else {
            set_response(false, "Requires parameter kind", []);
        }
    break;
    default:
        set_response(false, "Wrong method", []);
        break;
    break;
    }

?>