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
          if(_json_Data['result'] == 'warning'){
            location.href='verify.html'
          }
        }
      }
    }
    get_overall(1)
}

function reset_table(){
    document.getElementById('head').innerHTML = ''
    document.getElementById('sub-head').innerHTML = ''
    document.getElementById('table-data').innerHTML = ''
}


function get_overall(teamno){
    reset_table();
    let web = new XMLHttpRequest();
    web.open("POST", "php/overall.php", true)
    web.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    web.send("teamno="+teamno)
    web.onload=()=>{
        if(web.readyState === XMLHttpRequest.DONE){
            if(web.status === 200){
                console.log(web.response)
                _json_parse_data = JSON.parse(web.response)
                if(_json_parse_data["result"]=='error'){
                    location.href="index.html"
                }
                    document.getElementById('head').innerHTML = _json_parse_data['head']
                    document.getElementById('sub-head').innerHTML = _json_parse_data['sub_head']
                    document.getElementById('table-data').innerHTML = _json_parse_data['table_data']
            }
        }
    }
}

const _resetbutton = document.getElementById('reset_team');
_resetbutton.onclick=()=>{

    if(confirm("Make Sure, latest report is downloaded !!")){
        let reset = new XMLHttpRequest();
        reset.open("POST", "php/_reset.php", true)
        reset.send()
        reset.onload=()=>{
            if(reset.readyState === XMLHttpRequest.DONE){
                if(reset.status === 200){
                    console.log(reset.response)
                    _json_parse_data = JSON.parse(reset.response)
                    if(_json_parse_data["result"]=="success"){
                        get_overall(1);
                        document.getElementById('notify').style.display="block";
                        document.getElementById('notify').style.color="green";
                        document.getElementById('notify').innerHTML=_json_parse_data["message"];
                    }else{
                        document.getElementById('notify').style.color="red";
                        document.getElementById('notify').innerHTML=_json_parse_data["message"];
                    }
                    setTimeout(() => {
                        document.getElementById('notify').innerHTML="";
                        document.getElementById('notify').style.display="none";
                    }, 5000);
                }
            }
        }
    }
    
}