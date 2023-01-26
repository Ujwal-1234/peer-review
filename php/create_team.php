<?php
session_start();
require_once '_db.php';
require_once '_mail.php';
if(isset($_SESSION['session_id']) && isset($_SESSION['admin']))
{
    $sql = "SELECT * FROM student WHERE email = '{$_POST["email"]}'"; //AND teamno = '{$_POST['teamno']}'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        echo json_encode(["result"=>"warning", "message"=>"Already a member of team"]);
        exit();
    }
    // if(!empty($_POST['teamlead'])){
    //     $_sql = "SELECT * FROM student WHERE email = '{$_POST['teamlead']}' AND teamlead=1";
    //     $_lres = mysqli_query($conn, $_sql);
    //     if(mysqli_num_rows($_lres)>0){
    //         echo json_encode(["resul"])
    //     }
    // }

    $sql = "SELECT full_name FROM user WHERE email = '{$_POST["email"]}'"; //AND teamno = '{$_POST['teamno']}'";
    $result = mysqli_query($conn, $sql);
    // echo mysqli_num_rows($result);
    if(mysqli_num_rows($result)<1){
        $row = mysqli_fetch_assoc($result);
        // print_r($row);
        echo json_encode(["result"=>"error", "message"=>$_POST['name']." is not a Registered member."]);
        exit();
    }
    // print_r($_POST);
    // exit();
    $_insert_sql = "INSERT INTO `student`(`email`, `full_name`, `teamno`, `timelimit`) VALUES ('{$_POST['email']}','{$_POST['name']}','{$_POST['teamno']}','{$_POST['timelimit']}')";
    if(mysqli_query($conn, $_insert_sql)){
        $_body = "You are allocated to team number : ".$_POST['teamno']." and the last date to Rank is ".$_POST['timelimit'].". So, kindly visit the Peer Review website to Rank your team. URL : http://itsujwal.engineer/projects/peer";
        $_notify = _mail($_POST['email'], $_body, "Notification to Rank");
        $email_result = $_notify["message"];
        echo json_encode(["result"=>"success", "message"=>"data successfully uploaded","email"=>$_POST['email'], "mail_data"=>$email_result]);   
        exit();
    }
    // echo $_POST['email']. $_POST['name']. $_POST['teamno'];
}else{

    echo json_encode(["result"=>"error", "message"=>"not loggedin"]);
}

?>