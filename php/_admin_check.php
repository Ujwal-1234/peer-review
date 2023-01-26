<?php
session_start();
if(isset($_SESSION['session_id']) && $_SESSION['admin']=='1'){
    if($_SESSION['verified'] == 0){
        // session_unset();
        // session_destroy();
        echo json_encode(["result"=>"warning", "message"=>"Admin not Verfied"]);
        exit();
    }
    echo json_encode(["result"=>"success", "message"=>"admin user session"]);
    exit();
}
else{
    session_unset();
    session_destroy();
    echo json_encode(["result"=>"error", "message"=>"relogin with admin credentials"]);
    exit();
}

?>