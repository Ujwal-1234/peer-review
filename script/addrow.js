
function remove_row(_row_id){
    document.getElementById(_row_id).style.display='none';
}


function call_api(){
    let Web = new XMLHttpRequest();
    var orows = document.getElementById('table_data').getElementsByTagName('tr')
    // console.log(orows.length)
    Web.open("GET", "php/get_row.php?rownum="+orows.length, true)
    Web.send()
    Web.onload=()=>{
        if(Web.readyState === XMLHttpRequest.DONE){
            if(Web.status === 200){
                // console.log(Web.response)
                _rowdata = JSON.parse(Web.response)
                // console.log(_rowdata)
                document.querySelector('tbody').innerHTML+=_rowdata.data
            }
            return {"return":"error","message":"failed to create row"}
        }
        return {"return":"error","message":"failed to create row"}

    }
    return {"return":"error","message":"failed to create row"}
}


function _report_download(){
    let Web = new XMLHttpRequest();
    Web.open("GET", "php/_report.php", true)
    Web.send()
    Web.onload=()=>{
        if(Web.readyState === XMLHttpRequest.DONE){
            if(Web.status === 200){
                console.log(Web.response)
                _rowdata = JSON.parse(Web.response)
                if(_rowdata['result'] == 'error')
                {
                    // console.log(_rowdata)
                    document.getElementById('notify').style.display='block';
                    document.getElementById('notify').style.color="red";
                    document.getElementById('notify').innerHTML=_rowdata["message"];
                }
                if(_rowdata['result'] == 'success')
                {
                    document.getElementById('notify').style.display='block';
                    document.getElementById('notify').style.display = "green";
                    document.getElementById('notify').innerHTML = _rowdata["message"];
                    location.href = "php/report.csv"
                }
                setTimeout(() => {
                    document.getElementById('notify').innerHTML='';
                    document.getElementById('notify').style.color='unset';
                    document.getElementById('notify').style.display='none';
                }, 5000);
            }
        }
    }
}