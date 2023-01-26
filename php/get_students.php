<?php
require_once "_db.php";
session_start();
if(isset($_SESSION['session_id']) && isset($_GET['campus']) && isset($_GET['branch']) && isset($_GET['sec'])){
    if($_SESSION['admin']==1){
        $sql = "SELECT full_name, email FROM user WHERE admin = 0";
        $result = mysqli_query($conn, $sql);
        $names = array();
        $emails = array();
        if(mysqli_num_rows($result)  > 0){
            while($row = mysqli_fetch_assoc($result)){
                // print_r($row);
                array_push($names, $row['full_name']);
                array_push($emails, $row['email']);
            }
            echo json_encode(["result"=>"success", "emails"=>$emails, "names"=>$names]);
            exit();
            // print_r($emails);
            // print_r($names);
            exit();
        }
    }
}
?>