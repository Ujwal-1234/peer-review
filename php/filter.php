<?php
require_once "_db.php";
session_start();
if(isset($_GET['section']) && isset($_GET['branch']) && isset($_GET['campus']) && isset($_GET['college']) && isset($_SESSION['session_id']) && $_SESSION['admin']==1){
    $sql = "SELECT email, full_name FROM user WHERE section = '{$_GET['section']}' AND campus = '{$_GET['campus']}' AND branch = '{$_GET['branch']}' AND college = '{$_GET['college']}' AND email NOT IN (SELECT email FROM student) ORDER BY full_name ASC";
    $result = mysqli_query($conn, $sql);
    $_email = array();
    $_name = array();
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            // print_r($row);
            array_push($_email, $row["email"]);
            array_push($_name, $row["full_name"]);
        }
    }
    echo json_encode(["result"=>"success","email"=>$_email, "name"=>$_name]);
    exit();
    // print_r($_email);
    // print_r($_name);
}else{
    echo json_encode(["result"=>"error", "message"=>"Invalid Call to API"]);
    exit();
}
?>