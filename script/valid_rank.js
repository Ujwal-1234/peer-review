function myFunction() {
    // Declare variables
    console.log("search called")
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementsByTagName("input");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
  
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
    //   td1 = tr[i].getElementsByTagName("td")[18];
    //   td2 = tr[i].getElementsByTagName("td")[4];
    //   td3 = tr[i].getElementsByTagName("td")[5];
      if (td) {
        txtValue = td.textContent || td.innerText;
        // txtValue1 = td1.textContent || td1.innerText;
        // txtValue2 = td2.textContent || td2.innerText;
        // txtValue3 = td3.textContent || td3.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          input.style.color='green';
        } else {
          input.style.color = "red";
        }
      }
    }
  }
