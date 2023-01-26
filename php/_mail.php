<?php
function _mail($_email, $_body, $_subject){
    $url = "https://script.google.com/macros/s/AKfycbwmZow_6TgwnynvUJ2IjvODbQ8sRApLxaKCcTZ3puwZemiV87JsfYU_b0B-YSDS-BDOjw/exec";
    $ch = curl_init($url);
    // $headers = 'Content-type: text/html; charset=iso-8859-1';
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER=>true,
        CURLOPT_POSTFIELDS=>http_build_query([
            "recipient"=>$_email,
            "subject"=>$_subject,
            "body"=>$_body
        ])
        ]);
        
        $email_result = curl_exec($ch);
        if($email_result===false){
            return ["result"=>"error", "message"=>"mail not sent"];
        }
        return ["result"=>"success", "message"=>"mail sent"];
}

?>