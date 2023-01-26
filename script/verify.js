onload = ()=>{
    let web = new XMLHttpRequest();
    web.open("GET", "php/_admin_check.php", true);
    web.send()
    web.onload = ()=>{
      if (web.readyState === XMLHttpRequest.DONE){
        if(web.status === 200){
          let data = web.response;
          console.log(data);
          let _json_Data = JSON.parse(data)
          if(_json_Data['result'] == 'error'){
            location.href = 'index.html'
          }else
          if(_json_Data['result'] == 'success'){
            location.href = 'dashboard.html'
          }
          send_otp();
        }
      }
    }
}

function send_otp(){
    let otpurl = new XMLHttpRequest();
    otpurl.open("GET", "php/_verify.php", true);
    otpurl.send();
    otpurl.onload=()=>{
        if(otpurl.readyState === XMLHttpRequest.DONE){
            if(otpurl.status === 200){
                let data = otpurl.response;
                console.log(data)
                _json_Data = JSON.parse(data)
                if(_json_Data['result'] == 'success'){
                    document.getElementById("status").style.color="green";
                    document.getElementById("status").innerHTML = "OTP sent successfully";
                    setTimeout(() => {
                        document.getElementById("status").innerHTML='';
                    }, 2000);
                    // verify_otp(document.getElementById("otpvalue").value)
                }
            }
        }
    }
}

function verify_otp(otpvalue){
    let ver = new XMLHttpRequest();
    ver.open("GET", "php/_verify.php?otp="+otpvalue, true);
    ver.send();
    ver.onload=()=>{
        if(ver.readyState === XMLHttpRequest.DONE){
            if(ver.status === 200){
                let data = ver.response
                console.log(data)
                _json_Data = JSON.parse(data)
                if (_json_Data["result"] == "success" && _json_Data["verified"] == 1){
                    document.getElementById("status").style.color="green";
                    document.getElementById("status").innerHTML="Admin Verified";
                    location.href="dashboard.html"
                }
                if(_json_Data["result"] == "error"){
                    document.getElementById("status").style.color="red";
                    document.getElementById("status").innerHTML=_json_Data["message"];
                }
            }
        }
    }

}