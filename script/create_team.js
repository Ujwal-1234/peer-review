function admin_check(){
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
}


// function create_team_filter(){
  
// }
const _create_team_filter = document.getElementById('create_team_filter');
const _sbmt_button = document.getElementById('_submit_button')

_create_team_filter.onclick=()=>{
  console.log("create team filter applied")
  // console.log(document.getElementById("_createdata").childElementCount);
  // console.log(document.getElementById("_createdata"));
  var child_count = document.getElementById("_createdata").childElementCount;
  
  var teamno = document.getElementById('teamno').value
  var timelimit = document.getElementById('_time_limit').value
  var teamlead = document.getElementById('teamlead').value
  
  if (teamno == '' || timelimit == '')
  {
    console.log("empty field found")
    document.getElementById("notify").style.display="block";
    document.getElementById("notify").style.color="red";
    document.getElementById("notify").innerHTML = "Team Number and Timelimit is MANDATORY";
    setInterval(() => {
      document.getElementById("notify").style.display="none";
    }, 2000);
    return;
  }

  for(var i=0; i<child_count; i++)
  {
    var name = document.getElementById('datavalue'+i).value
    // var email = document.getElementById('emailvalue'+i).value
    var email = document.querySelector('#_createdata .emaildata'+i).value
    // var name = document.getElementById("_createdata").childNodes
    console.log(name, email)
    // return;
    // let Web = new XMLHttpRequest();
    // Web.open("POST", "php/create_team.php", true);
    // Web.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Web.send("email="+email+"&name="+name+"&teamno="+teamno+"&timelimit="+timelimit+"&teamlead="+teamlead);
    // Web.onload = () =>{
    //     if(Web.readyState === XMLHttpRequest.DONE){
    //         if(Web.status === 200){
    //             let data = Web.response;
    //             console.log(data);
    //             _jsondata = JSON.parse(Web.response)
    //             if(_jsondata["result"]=="warning" || _jsondata["result"]=="error"){
    //                 // alert(_jsondata["message"])
    //                 document.getElementById("notify").style.display="block";
    //                 document.getElementById("notify").style.color="red";
    //                 document.getElementById("notify").innerHTML = _jsondata["message"]
    //                 setInterval(() => {
    //                   document.getElementById("notify").innerHTML='';
    //                   document.getElementById("notify").style.display="block";
    //                 }, 5000);
    //             }
    //             if(_jsondata["result"]=="success")
    //             {
    //               if(_jsondata["message"] == "data successfully uploaded" && _jsondata["mail_data"] == "mail sent")
    //               {
    //                 document.getElementById("notify").style.display="block";
    //                 document.getElementById("notify").style.color="green";
    //                 document.getElementById("notify").innerHTML +=" <br> Successfully mailed : --//-- "+_jsondata["email"] + " --//-- received the mail "
    //                 setTimeout(() => {
    //                   document.getElementById("notify").innerHTML='';
    //                   document.getElementById("notify").style.display="block";
    //                 }, 5000);
    //               }
    //             }
    //             // alert(_jsondata["message"])
    //         }
    //     }
    // }
  }

  // console.log(document.querySelector())
}


// _sbmt_button.onclick=()=>{
//     var orows = document.getElementById('table_data').getElementsByTagName('tr')
//     var _rownum = orows.length
    
//     for (var i=0; i<_rownum; i++)
//     {
//         var name = document.getElementById('student'+i).value
//         var email = document.getElementById('email'+i).value
//         var teamno = document.getElementById('teamno').value
//         var timelimit = document.getElementById('_time_limit').value
//         var teamlead = document.getElementById('teamlead').value
//         // console.log(name, email)
//         let Web = new XMLHttpRequest();
//         Web.open("POST", "php/create_team.php", true);
//         Web.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//         Web.send("email="+email+"&name="+name+"&teamno="+teamno+"&timelimit="+timelimit+"&teamlead="+teamlead);
//         Web.onload = () =>{
//             if(Web.readyState === XMLHttpRequest.DONE){
//                 if(Web.status === 200){
//                     let data = Web.response;
//                     console.log(data);
//                     _jsondata = JSON.parse(Web.response)
//                     if(_jsondata["result"]=="warning" || _jsondata["result"]=="error"){
//                         alert(_jsondata["message"])
//                     }
//                     // alert(_jsondata["message"])
//                 }
//             }
//         }
//     }
// }