<?php
require_once "_db.php";
if(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['cpass']) && isset($_POST['fullname']) && isset($_POST['usertype'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $c_password = mysqli_real_escape_string($conn, $_POST['cpass']);
    $user_name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $user_type = mysqli_real_escape_string($conn, $_POST['usertype']);
    $contact = mysqli_real_escape_string($conn, $_POST['_contact']);
    
    if($user_type=='S'){
        $admin = 0;
        $college = mysqli_real_escape_string($conn, $_POST['_clg_name']);
        $branch = mysqli_real_escape_string($conn, $_POST['_branch']);
        $semester = mysqli_real_escape_string($conn, $_POST['_sem']);
        $degree = mysqli_real_escape_string($conn, $_POST['_degree']);
        $campus = mysqli_real_escape_string($conn, $_POST['_campus']);
    }else
        $admin = 1;

        
    // $course_name = mysqli_real_escape_string($conn, $_POST['_course_name']);
    $course_name = '';

    // echo $email . $password. $c_password. $user_name. $user_type;
    if(empty($email) || empty($password) || empty($c_password) || empty($user_name)||empty($user_type)){
        echo json_encode(["result"=>"error", "message"=>"empty fields"]);
        exit();
    }
    $check_data = "SELECT * FROM user WHERE email='{$email}'";
    $result = mysqli_query($conn, $check_data);
    if(mysqli_num_rows($result)>0){
        echo json_encode(["result"=>"error", "message"=>"You already have account"]);
        exit();
    }

    $hashpass = password_hash($password, PASSWORD_DEFAULT);
    switch($user_type){
        case 'S':
                $insert_sql = "INSERT INTO user (email, full_name, pass, admin, semester, college, branch, course_name, campus, degree, contact) VALUES('{$email}', '{$user_name}', '{$hashpass}', '{$admin}', '{$semester}', '{$college}', '{$branch}', '{$course_name}', '{$campus}', '{$degree}', '{$contact}')";
                $message = "Account Created .. Admin will Verify Your account!";
                break;
        case 'F': 
                $insert_sql = "INSERT INTO user (email, full_name, pass, admin, contact) VALUES('{$email}', '{$user_name}', '{$hashpass}', '{$admin}', '{$contact}')";
                $message = "Account Created .. Verify Your account. Link sent in Email";
                break;
        default :
                echo json_encode(["result"=>"error", "message"=>"Invalid user type.! Please contact admin"]);
                exit();
    }
    if(mysqli_query($conn, $insert_sql)){
        echo json_encode(["result"=>"success", "message"=>$message]);
        exit();
    }else{
        echo json_encode(["result"=>"error", "message"=>"Failed to create. !Please contact admin"]);
        exit();
    }
}
echo json_encode(["result"=>"error", "message"=>"Empty Fields"]);
exit();
?>