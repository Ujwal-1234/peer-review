<?php
require_once '_db.php';
// require_once '_plugins.php';

$sql  = "SELECT timelimit, email, total FROM student";
$_date = date("Y-m-d");
// echo $_date;
$data = array();
$count=0;
$_result = mysqli_query($conn, $sql);
// echo mysqli_num_rows($_result);
if(mysqli_num_rows($_result) > 0){
    while($row = mysqli_fetch_assoc($_result)){
        // print_r($row['timelimit']);
        if($_date > $row['timelimit']){
            
            array_push($data, $row);
            
        }else{
            echo json_encode(["result"=>"success", "message"=>"UPDATED...Still time remaining"]);
            exit();
        }       
    }
    usort($data, function($a, $b) {
        return $a['total'] > $b['total'] ? -1 : 1; 
    });                                                                                                                                                                                                        
    
    // print_r($data);
    
    $_marks_const = 6/sizeof($data);
    $_round_const = round($_marks_const, 2);
    // echo $_round_const;
    for($i = 0; $i<sizeof($data); $i++)
    {
        // $_marks = $_round_const*($i+1);
        $_isranked = check_ranked($data[$i]['email']);
        $_marks = $_isranked ? $_round_const*($i+1):0;
        $_in_sql = "UPDATE `student` SET `rank` = '{$i}'+1, `marks`='{$_marks}' WHERE `email`='{$data[$i]['email']}'";
        if(mysqli_query($conn, $_in_sql)){
            $count++;
        }
    }
    // echo $count;
    if($count == sizeof($data)){
        // echo $count.sizeof($data);
        echo json_encode(["result"=>"success", "message"=>"Final Ranked Given"]);
        exit();
    }
    // echo $count.sizeof($data);
    echo json_encode(["result"=>"error", "message"=>"Some Final Ranks Pending"]);
    exit();
}


function check_ranked($_email){
    global $conn;
    $_sql = "SELECT rank_by FROM student WHERE email='{$_email}' LIMIT 1";
    $_res = mysqli_query($conn, $_sql);
    $_data = mysqli_fetch_assoc($_res);
    $_r_emails = explode(',',$_data['rank_by']);
    // print_r($_r_emails);
    $count=0;
    for($i=0; $i<sizeof($_r_emails); $i++)
    {
        // echo $_email.' : '. $_r_emails[$i]. '  ----->';
        if(strcmp($_email, $_r_emails[$i])===1){
            echo 'data found ...........    ';
            $count++;
        }
    }
    // echo $count;
    if($count==0){
        return false;
    }
    return true;
}
// $data = array();
//     $_query = "SELECT email, total FROM student WHERE teamno = '{$_SESSION['team_num']}'";
//     $result = mysqli_query($conn, $_query);
//     if(mysqli_num_rows($result) > 0){
//         while($row = mysqli_fetch_assoc($result)){
//             // print_r($row);
//             array_push($data, $row);
//         }
//     }

//     usort($data, function($a, $b) {
//         return $a['total'] > $b['total'] ? -1 : 1; 
//     });                                                                                                                                                                                                        
    
//     // print_r($data);
//     $count=0;
//     $_marks_const = 6/sizeof($data);
//     $_round_const = round($_marks_const, 2);
//     // echo $_round_const;
//     for($i = 0; $i<sizeof($data); $i++)
//     {
//         // $_marks = $_round_const*($i+1);
//         $_isranked = check_ranked($data[$i]['email']);
//         $_marks = $_isranked ? $_round_const*($i+1):0;
//         $_in_sql = "UPDATE `student` SET `rank` = '{$i}'+1, `marks`='{$_marks}' WHERE `email`='{$data[$i]['email']}'";
//         if(mysqli_query($conn, $_in_sql)){
//             $count++;
//         }
//     }
//     if($count == sizeof($data)){
//         // echo $count.sizeof($data);
//         echo json_encode(["result"=>"success", "message"=>"Final Ranked Given"]);
//         exit();
//     }
//     // echo $count.sizeof($data);
//     echo json_encode(["result"=>"error", "message"=>"Some Final Ranks Pending"]);
//     exit();

?>