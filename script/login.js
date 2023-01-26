data_onload=()=>{
    let get = new XMLHttpRequest();
    get.open("POST", "php/login.php", true);    
    get.onload = ()=>{
        if(get.readyState === XMLHttpRequest.DONE){
            if(get.status === 200){
                console.log(get.response)
                _getdata = JSON.parse(get.response)
                if(_getdata['result']=='error' && _getdata['message']=='Already logged in'){
                    if(_getdata['admin']==1)
                        location.href="dashboard.html"
                    else
                        location.href="table.html"
                }
            }
        }
    }
    get.send();
}

document.getElementById('idsignup').style.display='none';
function _signup(){
    document.getElementById('idlogin').style.display='none';
    document.getElementById('idsignup').style.display='block';
}
function _login(){
    document.getElementById('idsignup').style.display='none';
    document.getElementById('idlogin').style.display='block';
}
// let _signbtn = document.getElementById('_buttonsignin')
let _email = document.getElementById('_emailinput').textContent
// let _pass = document.getElementById('_passinput').textContent

const form = document.querySelector("form"),
_signbtn = form.querySelector("form #_buttonsignin");

form.onsubmit = (e)=>{
    e.preventDefault();
}

_signbtn.onclick = () =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
                let json_data = JSON.parse(data);
                console.log(json_data);
                if( json_data["result"]== "success" && json_data["session_id"]["admin"]==1){
                    location.href="dashboard.html"
                }
                if( json_data["result"]== "success" && json_data["session_id"]["admin"]==0){
                    location.href="table.html"
                    // localStorage.setItem("email", _email)
                    // if(json_data['session_id']['admin'] == '1'){
                    //     location.href="dashboard.html"
                    // }else{
                    // }
                }else{
                    document.getElementById('error').innerHTML=json_data['message']
                    document.getElementById('error').style.display='block';
                }                 
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

document.getElementById('_sem').style.display='none';
document.getElementById('_clg_name').style.display='none';
document.getElementById('_branch').style.display='none';
document.getElementById('_sec').style.display='none';
document.getElementById('_degree').style.display='none';
document.getElementById('_campus').style.display='none';

const form2 = document.querySelector("#idsignup form"),
_regbtn = document.querySelector("#idsignup form #_buttonreg");

let admin=false;
function selection(choice){
    if(choice == '0'){
        registration();
        document.getElementById('_sem').style.display='block';
        document.getElementById('_clg_name').style.display='block';
        document.getElementById('_sec').style.display='block';
        document.getElementById('_branch').style.display='block';
        document.getElementById('_degree').style.display='block';
        document.getElementById('_campus').style.display='block';
        // const _sem = form2.querySelector("#idsignup form #_sem"),
        // _branch = form2.querySelector("#idsignup form #_branch"),
        // _college = form2.querySelector("#idsignup form #_clg_name");
    }else{
        document.getElementById('_sem').style.display='none';
        document.getElementById('_clg_name').style.display='none';
        document.getElementById('_branch').style.display='none';
        document.getElementById('_sec').style.display='none';
        document.getElementById('_degree').style.display='none';
        document.getElementById('_campus').style.display='none';
        admin=true
    }
}

form2.onsubmit=(e)=>{
    e.preventDefault();
}

_regbtn.onclick = () =>{
    let reg = new XMLHttpRequest();
    reg.open("POST", "php/register_user.php", true);
    reg.onload = ()=>{
        if(reg.readyState === XMLHttpRequest.DONE){
            if(reg.status === 200){
                let data = reg.response;
                console.log(data);
                let json_data = JSON.parse(data);
                if(json_data["result"]=="error"){
                    document.getElementById('error').style.display='block'
                    document.getElementById('error').innerHTML=json_data["message"]
                }
                if(json_data["result"]=="success"){
                    document.getElementById('error').style.display='block'
                    document.getElementById('error').style.color='green'
                    document.getElementById('error').innerHTML=json_data["message"]+" Redirecting to login in .. "
                    setTimeout(() => {
                        location.href="index.html"
                    }, 5000);
                }                 
            }
        }
    }
    let formData = new FormData(form2);
    reg.send(formData);
}