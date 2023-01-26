function _filter(college, section, campus, branch){
    document.getElementById("_data").innerHTML=""
    document.getElementById("_createdata").innerHTML=""
    console.log(college, section, campus, branch)
    let filter = new XMLHttpRequest();
    filter.open("GET", "php/filter.php?college="+college+"&section="+section+"&campus="+campus+"&branch="+branch, true);
    filter.send();
    filter.onload=()=>{
        if(filter.readyState === XMLHttpRequest.DONE){
            if(filter.status === 200){
                // console.log(filter.response)
                _json_Data = JSON.parse(filter.response)
                // console.log(_json_Data['email'], _json_Data['name'])
                if(_json_Data["result"] == "success"){
                    localStorage.clear();
                    localStorage.setItem('emails', _json_Data['email']) 
                    localStorage.setItem('names', _json_Data['name'])
                    localStorage.setItem("r-col", 0)
                    localStorage.setItem("l-col", 0)
                    document.getElementById("notify").style.display="block";
                    document.getElementById("notify").innerHTML="Applying filter in 2 seconds .."
                    setTimeout(() => {
                        document.getElementById("notify").innerHTML='';
                        document.getElementById("filter").style.display="unset";
                        document.getElementById("notify").style.display="none";
                        _add_students_list();
                    }, 2000);
                }
            }
        }
    }
}
function _add(id, datavalue, emailvalue){
    document.getElementById("_createdata").innerHTML += '<p class="m-2 p-3 rounded " id="'+id+'">'+
            '<input type="text" id="'+datavalue+'" value="'+document.getElementById(datavalue).value+'" disabled="" class="lg:w-1/2 w-full rounded-lg border-[1.5px] border-form-stroke py-3 px-5 font-medium text-body-color placeholder-body-color outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-[#F5F7FD]">'+
            '<input type="text" id="'+emailvalue+'" value="'+document.getElementById(emailvalue).value+'" disabled="" hidden class="emaildata'+localStorage.getItem("r-col")+' lg:w-1/2 w-full rounded-lg border-[1.5px] border-form-stroke py-3 px-5 font-medium text-body-color placeholder-body-color outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-[#F5F7FD]">'+
            '<input value="remove" onclick="_remove('+"'"+id+"','"+datavalue+"','"+emailvalue+"'"+');" class="lg:w-1/2 w-full inline cursor-pointer text-center shadow-md rounded border border-primary text-primary hover:bg-primary hover:text-white">'+
            '</p>'
    localStorage.setItem("r-col", parseInt(localStorage.getItem("r-col"))+1)
    document.querySelector("#_data #"+id+"").remove();
}
function _remove(id, datavalue, emailvalue){
    localStorage.setItem("r-col", localStorage.getItem("r-col")-1)
    document.getElementById("_data").innerHTML += '<p class="m-2 p-3 rounded " id="'+id+'">'+
            '<input type="text" id="'+datavalue+'" value="'+document.getElementById(datavalue).value+'" disabled="" class="lg:w-1/2 w-full rounded-lg border-[1.5px] border-form-stroke py-3 px-5 font-medium text-body-color placeholder-body-color outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-[#F5F7FD]">'+
            '<input type="text" id="'+emailvalue+'" value="'+document.getElementById(emailvalue).value+'" disabled="" hidden class="lg:w-1/2 w-full rounded-lg border-[1.5px] border-form-stroke py-3 px-5 font-medium text-body-color placeholder-body-color outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-[#F5F7FD]">'+
            '<input value="Add" onclick="_add('+"'"+id+"','"+datavalue+"','"+emailvalue+"'"+');" class="lg:w-1/2 w-full inline cursor-pointer text-center shadow-md rounded border border-primary text-primary hover:bg-primary hover:text-white">'+
            '</p>'
    document.querySelector("#_createdata #"+id+"").remove();
}

function _add_students_list(){
    let local_data_emails = localStorage.getItem("emails").split(',');
    let local_data_names = localStorage.getItem("names").split(',');
    console.log(local_data_emails)
    if (local_data_emails.length == 1 && local_data_emails['0'] == ''){
        document.getElementById("_data").innerHTML="no data found"
    }else{
        for(let i=0; i<local_data_emails.length; i++){
            document.getElementById("_data").innerHTML += '<p class="m-2 p-3 rounded " id="data'+i+'">'+
            '<input type="text" id="datavalue'+i+'" value="'+local_data_names[i]+'" disabled="" class="lg:w-1/2 w-full rounded-lg border-[1.5px] border-form-stroke py-3 px-5 font-medium text-body-color placeholder-body-color outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-[#F5F7FD]">'+
            '<input type="text" id="emailvalue'+i+'" value="'+local_data_emails[i]+'" disabled="" hidden class="lg:w-1/2 w-full rounded-lg border-[1.5px] border-form-stroke py-3 px-5 font-medium text-body-color placeholder-body-color outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-[#F5F7FD]">'+
            '<input value="Add" onclick="_add('+"'data"+i+"','datavalue"+i+"','emailvalue"+i+"'"+');" class="lg:w-1/2 w-full inline cursor-pointer text-center shadow-md rounded border border-primary text-primary hover:bg-primary hover:text-white">'+
            '</p>'
        }
    }
}