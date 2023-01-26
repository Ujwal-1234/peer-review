<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once '_db.php';
if(isset($_SESSION['session_id']) && isset($_SESSION['team_num'])){

    $data = array();
    $_query = "SELECT email, total FROM student WHERE teamno = '{$_SESSION['team_num']}'";
    $result = mysqli_query($conn, $_query);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            // print_r($row);
            array_push($data, $row);
        }
    }

    usort($data, function($a, $b) {
        return $a['total'] < $b['total'] ? -1 : 1; 
    });                                                                                                                                                                                                        
    
    // print_r($data);
    $count=0;
    $_marks_const = 6/sizeof($data);
    $_round_const = round($_marks_const, 2);
    // echo $_round_const;
    $_counter=sizeof($data);
    for($i = 0; $i<sizeof($data); $i++)
    {
        // $_marks = $_round_const*($i+1);
        $_isranked = check_ranked($data[$i]['email']);
        $_marks = $_isranked ? $_round_const*$_counter:0;
        $_in_sql = "UPDATE `student` SET `rank` = '{$i}'+1, `marks`='{$_marks}' WHERE `email`='{$data[$i]['email']}'";
        if(mysqli_query($conn, $_in_sql)){
            $count++;
            $_counter--;
        }
    }
    if($count == sizeof($data)){
        // echo $count.sizeof($data);
        echo json_encode(["result"=>"success", "message"=>"Final Ranked Given"]);
        exit();
    }
    // echo $count.sizeof($data);
    echo json_encode(["result"=>"error", "message"=>"Some Final Ranks Pending"]);
    exit();

}
// echo 'session not set';
// print_r($_SESSION);

function check_ranked($_email){
    global $conn;
    $_sql = "SELECT rank_by FROM student WHERE teamno = '{$_SESSION['team_num']}' LIMIT 1";
    $_res = mysqli_query($conn, $_sql);
    $_data = mysqli_fetch_assoc($_res);
    $_r_emails = explode(',',$_data['rank_by']);
    $count=0;
    for($i=0; $i<sizeof($_r_emails); $i++)
    {
        if($_email == $_r_emails[$i]){
            $count++;
        }
    }
    if($count==0){
        return false;
    }
    return true;
}

?>