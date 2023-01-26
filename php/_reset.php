<?php
require_once "_db.php";
session_start();
if(isset($_SESSION['session_id']))
{
    if($_SESSION['admin']=='1')
    {
        $sql = "TRUNCATE `student`";
        if(mysqli_query($conn, $sql)){
            echo json_encode(["result"=>"success", "message"=>"Successfully cleaned"]);exit();
        }
        echo json_encode(["result"=>"error", "message"=>"Failed to Reset"]);exit();
    }
    echo json_encode(["result"=>"error", "message"=>"Admins only Allowed"]);exit();
}
echo json_encode(["result"=>"error", "message"=>"Invalid Entry"]);exit();
?>