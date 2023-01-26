
onload = ()=>{
    let tosubmit = new Date(2022, 10, 11, 11, 02, 30, 0);
    let web = new XMLHttpRequest();
    web.open("GET", "php/table.php", true);
    web.send()
    web.onload = ()=>{
      if (web.readyState === XMLHttpRequest.DONE){
        if(web.status === 200){
          let data = web.response;
          console.log(data);
          let _json_Data = JSON.parse(data)
          if(_json_Data['result'] == 'error'){
            location.href = 'index.html'
          }
          if(_json_Data['result'] == 'warning'){
            // console.log(_json_Data['message'])
            document.getElementById('rtnmsg').innerHTML=_json_Data['message']
            if (_json_Data['message'] == "already ranked"){
              document.getElementById('rtnmsg').innerHTML+= "<br> logging you out..."
              setTimeout(() => {
                console.log("logging out")
                let logout = new XMLHttpRequest();
                logout.open("GET", "php/logout.php", true);
                logout.send();
                location.href="index.html"
              }, 5000);
            }
          }
          if(_json_Data['result'] == 'success' && _json_Data['type']=='S'){
            document.getElementById('teamno').innerHTML=_json_Data['team_no']
            document.getElementById('timetosubmit').innerHTML = tosubmit
            document.getElementById('_user_name').innerHTML = _json_Data['session_data']['user_name']
            document.getElementById('course').innerHTML = _json_Data['session_data']['course_sec']
            document.getElementById('sem').innerHTML = _json_Data['session_data']['sem']
            document.querySelector('tbody').innerHTML = _json_Data['data']
            // console.log(_json_Data['date_limit'])
            document.getElementById('timetosubmit').innerHTML = _json_Data['date_limit']
            // console.log(_json_Data['session_data']['session_id'])
            if(_json_Data['session_data']['admin']=='1'){
              // console.log("admin block active")
              document.getElementById('admin').style.display='inline';
            }
            document.getElementById('_logged_email').innerHTML=_json_Data['session_data']['session_id'];
            // setInterval(() => {
            //   let current = new Date()
            //   console.log(tosubmit.getDate(), current.getDate())
            //   document.getElementById('_remaining').innerHTML = tosubmit.getTime() - current.getTime()
            //   console.log(tosubmit.getDate() - current.getDate())
            // }, 1000);
            // location.href = 'index.html'
          }
      }
    }
  }
}
const _rank_form = document.querySelector('form'),
_submit_button = document.querySelector('form #_submit_button')
_submit_button.onclick =() =>{  
  // console.log('line 35 js')
  let web2 = new XMLHttpRequest();
  web2.open("POST", "php/rank_submit.php", true)
  web2.onload=()=>{
    if(web2.readyState === XMLHttpRequest.DONE){
      if(web2.status === 200){
        // console.log("line 41")
        console.log(web2.response)
        _status_json_data=JSON.parse(web2.response)
        // if(_status_json_data['result']=='success'){
        //   alert(_status_json_data['message'])
        // }else{
          alert(_status_json_data['message'])
        // }
      }
    }
  }
  let formData = new FormData(_rank_form);
  web2.send(formData);

  let _web_rank =  new XMLHttpRequest();
  _web_rank.open("GET", "php/_rank_eq.php", true);
  _web_rank.send();
  _web_rank.onload=()=>{
    if(_web_rank.readyState === XMLHttpRequest.DONE){
      if(_web_rank.status === 200){
        console.log(_web_rank.response)
        _data_json = JSON.parse(_web_rank.response)
        alert(_data_json['message'])
      }
    }
  }
}