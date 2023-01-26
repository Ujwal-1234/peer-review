<?php
require_once "_db.php";
require_once "_mail.php";
session_start();
if(isset($_SESSION['session_id'])){
    if(isset($_GET['otp'])){
        if($_GET['otp'] == $_SESSION['otp']){
            // sql query to make admin verified
            $sql = "UPDATE user set verified = 1 WHERE email = '{$_SESSION["session_id"]}'";
            if(mysqli_query($conn, $sql)){
                unset($_SESSION['otp']);
                $_SESSION['verified'] = 1;
                echo json_encode(["result"=>"success", "message"=>"Verified", "verified"=>1]);
                exit();
            }
            echo json_encode(["result"=>"error", "message"=>"Internal error. Contact admin"]);
            exit();
        }
        echo json_encode(["result"=>"error", "message"=>"Invalid OTP Entered"]);
        exit();
    }
    $sql = "SELECT verified FROM user WHERE email = '{$_SESSION['session_id']}'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        if($row["verified"]==1)
            {echo json_encode(["result"=>"success", "message"=>"Already a verified user"]); exit();}
    }
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_body = "The Verification OTP for PEER review is : ".$otp;
    $_subject = "Admin Verification Mail From PEER REVIEW";
    $_otpstatus = _mail($_SESSION['session_id'], $_body, $_subject);
    echo json_encode(["result"=>"success", "message"=>"OTP generated Successfully", "otp_mail"=>$_otpstatus["message"]]);
    exit();
}
?>