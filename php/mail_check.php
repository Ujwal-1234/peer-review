<?php
$url = "https://script.google.com/macros/s/AKfycby73aUuIPV99a8FQKyhyfGh1flcY019KGO7UO_hpmidbVTXBzOgYJT1XQBsmNNHmKHuxA/exec";
$ch = curl_init($url);

// curl_setopt($ch, CURLOPT_URL, "https://script.google.com/macros/s/AKfycby73aUuIPV99a8FQKyhyfGh1flcY019KGO7UO_hpmidbVTXBzOgYJT1XQBsmNNHmKHuxA/exec");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{
    \"cc\":[\"19btrse035@jainuniversity.ac.in\":\"cc whom!\"],
    \"text\":\"This is the text\",
    \"bcc\":[\"ujwal.ediify@gmail.com\":\"bcc whom!\"],
    \"replyto\":[\"ujwalkumarmahatohcs41@gmail.com\",\"reply to!\"],
    \"html\":\"This is the <h1>HTML</h1>
            This is inline image 1.<br/>
            <br/>Some text<br/>This is inline image 2.<br/>
            <br/>Some more text<br/>
            Re-used inline image 1.<br/>
            
    \"to\":{\"kujwal147@gmail.com\":\"to whom!\"},
    \"from\":[\"ujwalkumarmahatohcs41@gmail.com\",\"from email!\"],
    \"subject\":\"My subject\",
    \"headers\":{\"Content-Type\":\"text/html; charset=iso-8859-1\", \"X-param1\":\"value1\",\"X-param2\":\"value2\", \"X-Mailin-custom\":\"my custom value\",\"X-Mailin-IP\":\"102.102.1.2\", \"X-Mailin-Tag\":\"My tag\"}");
// curl_setopt($ch, CURLOPT_POST, 1);

// $headers = array();
// $headers[] = "Api-Key: your_access_key";
// $headers[] = "Content-Type: application/x-www-form-urlencoded";
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    echo json_encode(["result"=>"error", "message"=>"mail not sent"]);
    exit();
    // return ["result"=>"error", "message"=>"mail not sent"];
}
curl_close ($ch);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/html"));
    // $email_result = curl_exec($ch);
    // if($email_result===false){
    // }
    echo $result;
    // echo json_encode(["result"=>"success", "message"=>"mail sent"]);
// return ["result"=>"success", "message"=>"mail sent"];
?>