<?php
global $conn;
$conn = mysqli_connect("localhost", "root", "", "peer");
if(!$conn){
    echo "database not connected ".mysqli_connect_error();
}
?>