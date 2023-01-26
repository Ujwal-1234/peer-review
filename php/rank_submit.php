<?php
session_start();
require_once '_db.php';

// echo $_SESSION['teamno'];

if(isset($_SESSION['session_id'])){
    // print_r($_SESSION);
    $count=0;
    $_check_status = _check_ranked($_SESSION['session_id']);
    if($_check_status["result"]=="ranked"){
        echo json_encode(["result"=>"success", "message"=>"already ranked"]);
        exit();
    }
    $_rankarray=array();
    for( $i = 1; $i<=$_SESSION['teamno'];$i++){
        $_rank_input = mysqli_real_escape_string($conn, $_POST['input'.$i]);
        $_email_input = mysqli_real_escape_string($conn, $_POST['email'.$i]);
        if($_email_input == $_SESSION['session_id'])
        continue;
        for($j=0;$j<sizeof($_rankarray); $j++)
        {
            if($_rank_input == $_rankarray[$j]){
                echo json_encode(["result"=>"error", "message"=>"Repeated Ranks not allowed"]);
                exit();
            }
        }
        if($_rank_input < 1 || $_rank_input > $_SESSION['teamno']-1){
            echo json_encode(["result"=>"error", "message"=>"Invalid Rank"]);
            exit();
        }
        // echo $_rank_input;
        array_push($_rankarray, $_rank_input);
    }


    // echo json_encode(["result"=>"success", "message"=>"Already Ranked"]);
    // exit();
    for( $i = 1; $i<=$_SESSION['teamno'];$i++){
        $_rank_input = mysqli_real_escape_string($conn, $_POST['input'.$i]);
        $_email_input = mysqli_real_escape_string($conn, $_POST['email'.$i]);
        // echo $_rank_input.$_email_input;
        $result = update_rank($_rank_input, $_email_input, $_SESSION['session_id']);
        if($result['result']=='success')
        $count++;
    }
    if ($count == $_SESSION['teamno']){
        echo json_encode(["result"=>"success", "message"=>"success in updating ALL"]);
        exit();
    }
    echo json_encode(["result"=>"error", "message"=>"unable to update ALL"]);
}

function update_rank($_rank_input, $_email_input, $rank_by){
    global $conn;
    $sql = mysqli_query($conn, "SELECT ranks, rank_by FROM student WHERE email = '{$_email_input}'");   
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
        if(empty($row['ranks']) && empty($row['rank_by'])){
            $_ranks = $_rank_input;
            $_rankby = $rank_by;
        }else{
            $_ranks = $row['ranks'].','.$_rank_input;
            $_rankby = $row['rank_by'].','.$rank_by;
        }
        $_total=0 ;
        $_rank_data = explode(',', $_ranks);
        for($i=0;$i<sizeof($_rank_data);$i++)
        {
            $_total+=$_rank_data[$i];
        }
        // rank marks work updation left
        $_update_sql = mysqli_query($conn, "UPDATE `student` SET `ranks`='{$_ranks}',`rank_by`='{$_rankby}',`total`='{$_total}' WHERE `email`='{$_email_input}'");
        if($_update_sql){
            return ["result"=>"success", "message"=>"success in updating"];
        }else{
            return ["result"=>"error", "message"=>"unable to update"];
        }
    }
    
}

function _check_ranked($_email){
    global $conn;
    $sql = "SELECT * FROM student WHERE teamno = (SELECT teamno FROM student WHERE email = '{$_email}') AND rank_by LIKE '%{$_email}%'";
    $sql_data = mysqli_query($conn, $sql);
    if(mysqli_num_rows($sql_data)  > 0 ){
        // echo mysqli_num_rows($sql_data);
        return ["result"=>"ranked", "message"=>"Already ranked"];
    }
    return ["result"=>"not_ranked", "message"=>"you can rank"];
}

?>