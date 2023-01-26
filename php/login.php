<?php
    session_start();
    if(isset($_SESSION['session_id'])){
        echo json_encode(["result"=>"error", "message"=>"Already logged in", "admin"=>$_SESSION['admin']]);exit();
    }
    include_once "_db.php";
    if(isset($_POST['email']) && isset($_POST['pass'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);
        if(!empty($email) && !empty($password)){
            $sql = mysqli_query($conn, "SELECT * FROM user WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
                $_verify_pass = password_verify($password, $row['pass']);
                if($_verify_pass){
                    session_destroy();
                    session_start();
                    if($row['admin']=='0')
                    {
                        $_sql_team = mysqli_query($conn, "SELECT teamno FROM student WHERE email = '{$email}'");
                        $_teamno = mysqli_fetch_assoc($_sql_team);
                        if(mysqli_num_rows($_sql_team) > 0)
                            $_SESSION['team_num'] = $_teamno['teamno'];
                        else{
                            session_destroy();
                            echo json_encode(["result"=>"error", "message"=>"Not a part of any team"]);exit();
                        }
                    }
                    $_SESSION['verified'] = $row['verified'];
                    $_SESSION['sem'] = $row['semester'];
                    $_SESSION['course_sec'] = $row['branch'].' '.$row['section'];
                    $_SESSION['admin'] = $row['admin'];
                    $_SESSION['session_id'] =$email;
                    $_SESSION['user_name']=$row['full_name'];
                    echo json_encode(["result"=>"success", "message"=>"logged in", "session_id"=>$_SESSION]);exit();
                }else{
                    echo json_encode(["result"=>"error", "message"=>"password not matched"]);exit();
                }
            }else{
                echo json_encode(["result"=>"error", "message"=>"Email or password is incorrect!"]);exit();
            }
        }else{
            echo json_encode(["result"=>"error", "message"=>"All input field are required"]);exit();
        }
    }
    echo json_encode(["result"=>"error", "message"=>"NOT LOGGED IN"]);exit();
?>