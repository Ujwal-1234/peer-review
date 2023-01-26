var college = ["Jayanagar 9th block", "CMS Lalbagh Road", "SGS-JCR","CMS B School", "CMS-D School", "Whitefield -Allied Health Services", "School Of Engineering And Technology Jain University", "Sa Pa academy - BA music"]
var branch = ["CSE" ,"ISE", "ECE & EEE", "CV", "CTIS", "CTMA", "IOT", "ASE", "ANE", "ME", "DS", "AI", "SE", "BSC (honors) -psychology", "BSC - Anaesthesia technology", "BSC-Cancer Biology", "BSC - Cardiac Technology", "BMS - Healthcare Management", "BCA IT for healthcare", "BSC - Medical imaging technology", "BSC-Medical lab technology", "BSC nuclear medicine technology", "BSC-Nutrition and Dietics", "BSC-operation theatre technology", "BSC-optometry", "BSC-Virology and immunology", "BSC-Interior design", "BSC-Design", "BDES", "BMS-digital business", "CCAD-BA(Honors)", "BSC-BCGBT", "BSC-FSP", "BSC-FSH", "BSC-PMCS", "BSC-CMBT", "BSC-RPCS", "BSC-DATA SCIENCE", "BBA-Regular", "BBA L- sports management", "BBA-S.I.I(international students)", "BBA WOW (enterpreneurship)", "BBA-Honors", "BBA-F&A", "BAJ-Journalism and Mass Communication", "B.COM (regular)", "B.COM(honors)", "BMS(JU)", "BMS (inurture)", "BCA", "BSC-animation", "BSC-gaming", "BSC-digital film making", "BSC- graphics and vfx", "BA", "BA-PSE", "BA(honors)-economics"]
var section = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"]
var semester = ["1", "2", "3", "4", "5", "6", "7", "8"]
var campus = ["JGI", "city"]
var degree = []
function registration(){
  dropdown("college", college);
  dropdown("branch", branch);
  dropdown("section", section);
  dropdown("campus", campus);
  dropdown("semester", semester);
  dropdown("degree", degree);
}

function autocomplete(inp, arr) {
    var currentFocus;
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        this.parentNode.appendChild(a);
        for (i = 0; i < arr.length; i++) {
          if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            b = document.createElement("DIV");
            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
            b.innerHTML += arr[i].substr(val.length);
            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
            b.addEventListener("click", function(e) {
                inp.value = this.getElementsByTagName("input")[0].value;
                closeAllLists();
            });
            a.appendChild(b);
          }
        }
    });
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
          currentFocus++;
          addActive(x);
        } else if (e.keyCode == 38) {
          currentFocus--;
          addActive(x);
        } else if (e.keyCode == 13) {
          e.preventDefault();
          if (currentFocus > -1) {
            if (x) x[currentFocus].click();
          }
        }
    });
    function addActive(x) {
      if (!x) return false;
      removeActive(x);
      if (currentFocus >= x.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = (x.length - 1);
      x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
      for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
      }
    }
    function closeAllLists(elmnt) {
      var x = document.getElementsByClassName("autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}
  
function filter(){
  dropdown("campus", campus);
  dropdown("branch", branch);
  dropdown("section", section);
  dropdown("college", college);
}

function dropdown(id, data){
  for(var i=0; i<data.length; i++){
    // console.log(id, data)
    document.getElementById(id).innerHTML+='<option value="'+data[i]+'">'+data[i]+'</option>'
  }
}


  
function _autocomplete(){
    autocomplete(document.getElementById("_clg_name"), college);
    autocomplete(document.getElementById('_branch'), branch);
    autocomplete(document.getElementById('_sem'), semester);
    autocomplete(document.getElementById('_sec'), section);
}


function _admin_autocomplete(_classname){    
    // get_usernames();
    var _emails = localStorage.getItem('emails').split(',')
    var _names = localStorage.getItem('names').split(',')
    console.log(_emails);
    console.log(_names);
    console.log(_classname);
    // let query = '#table_data tr td .'+_classname
    // console.log(query)
    autocomplete(document.getElementById('teamlead'), _emails);
    autocomplete(document.querySelector(_classname), _names);
    // autocomplete(document.querySelector('#table_data tr td .inpu1'), _names);
    autocomplete(document.querySelector(_classname), _emails);
    // autocomplete(document.querySelector('#table_data tr td .einpu1'), _emails);
}

function get_usernames(){
  let Web = new XMLHttpRequest();
  _campus = document.getElementById('_campus').value
  branch = document.getElementById('_branch').value
  _sec = document.getElementById('_section').value
  console.log(_campus, branch, _sec)
  Web.open("GET", "php/get_students.php?campus="+_campus+"&branch="+branch+"&sec="+_sec, true);
  Web.send();
  Web.onload = ()=>{
    if(Web.readyState === XMLHttpRequest.DONE){
      if(Web.status === 200){
        console.log(Web.response);
        _json_data = JSON.parse(Web.response);
        if(_json_data["result"]=="success"){
          localStorage.setItem('emails', _json_data["emails"]);
          localStorage.setItem('names', _json_data["names"]);
        }
      }
    }
  }
}