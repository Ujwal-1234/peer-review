<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once "_db.php";
if(isset($_SESSION['session_id']) && isset($_SESSION['admin'])){
    if($_SESSION['admin'] == '1'){
        $sql = "SELECT * FROM `student` ORDER BY `teamno` ASC";
        $result = mysqli_query($conn, $sql);
        // echo mysqli_num_rows($result);
        if(mysqli_num_rows($result)>0){
            $_team_no =array();
            $_full_name =array();
            $_email =array();
            $_timelimit =array();
            $_ranks =array();
            $_rank_by =array();
            $_total =array();
            $_rank =array();
            $_marks =array();
            while($row = mysqli_fetch_assoc($result)){
                // print_r($row['email']);
                // $_team_no[] = $row['teamno'];
                array_push($_team_no, $row['teamno']);
                // $_full_name[] = $row['full_name'];
                array_push($_full_name, $row['full_name']);
                // $_email[] = $row['email'];
                array_push($_email, $row['email']);
                // $_timelimit[] = $row['timelimit'];
                array_push($_timelimit, $row['timelimit']);
                // $_ranks[] = $row['ranks'];
                array_push($_ranks, $row['ranks']);
                // $_rank_by[] = $row['rank_by'];
                array_push($_rank_by, $row['rank_by']);
                // $_total[] = $row['total'];
                array_push($_total, $row['total']);
                // $_rank[] = $row['rank'];
                array_push($_rank, $row['rank']);
                // $_marks[] = $row['marks'];
                array_push($_marks, $row['marks']);
                
            }
            $overall_data = [
                "fullname"=>$_full_name, 
                "teamno"=>$_team_no, 
                "email"=>$_email, 
                "total"=>$_total,
                "marks"=>$_marks,
                "ranks"=>$_ranks,
                "rankby"=>$_rank_by,
                "timelimit"=>$_timelimit 
            ];
            // print_r($_team_no);
            // print_r($_full_name);
            // print_r($_email);
            // print_r($_timelimit);
            // print_r($_total);
            // print_r($overall_data);
            $overall_data_json = json_encode($overall_data);
            $decoded_json_data = json_decode($overall_data_json, true);
            
            $csv = 'report.csv';
            $file_pointer = fopen($csv, 'w');
            foreach($decoded_json_data as $i){
                fputcsv($file_pointer, $i);
            }
            fclose($file_pointer);
            echo json_encode(["result"=>"success", "message"=>"Updated the CSV file"]);exit();
        }
        echo json_encode(["result"=>"error", "message"=>"Database is cleaned by Admin"]);exit();
    }
    echo json_encode(["result"=>"error", "message"=>"Admins allowed only"]);exit();
}
echo json_encode(["result"=>"error", "message"=>"Invalid Entry"]);exit();

?>