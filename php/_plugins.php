<?php
require_once '_db.php'; 
function _checkdata($data, $type)
{
    global $conn;
    switch($type){
        case "login":
            $sql = "SELECT * FROM user WHERE email=:EMAIL limit 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':EMAIL', $data['email']);
            break;
        default: return ["result"=>"error", "message"=>"invalid operation"];
    }
    if($stmt->execute()){
        $result = $stmt->fetchAll();
        print_r($result);
        exit();
    }
}

// function check_ranked($_email){
//     global $conn;
//     $_sql = "SELECT rank_by FROM student WHERE teamno = '{$_SESSION['team_num']}' LIMIT 1";
//     $_res = mysqli_query($conn, $_sql);
//     $_data = mysqli_fetch_assoc($_res);
//     $_r_emails = explode(',',$_data['rank_by']);
//     $count=0;
//     for($i=0; $i<sizeof($_r_emails); $i++)
//     {
//         if($_email == $_r_emails[$i]){
//             $count++;
//         }
//     }
//     if($count==0){
//         return false;
//     }
//     return true;
// }
?>