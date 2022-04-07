<script>

  $(document).ready(function() {

    refresh();

  });


  function refresh() {
    setTimeout(function() { 
      fetch(); 
      refresh();
    }, 1000);
  }



  function fetch(){
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "fetch.php", true);
    ajax.send();

    ajax.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var data = JSON.parse(this.responseText);
        

        var html = "";
        for(var a = 0; a < data.length; a++) {
          var id = data[a].id;
          var soundlevel = data[a].soundlevel;
          var battlevel = data[a].battlevel;


          if ((id == 0001) && soundlevel <= 59) {
            document.getElementById("table1_result").innerHTML= "SILENT";
            document.getElementById("table1_result_body").style.backgroundColor = "green";
          }
          else if (soundlevel <= 74) {
            document.getElementById("table1_result").innerHTML= "Moderate";
            document.getElementById("table1_result_body").style.backgroundColor = "orange";
          }
          else if (soundlevel > 75) {
            document.getElementById("table1_result").innerHTML= "Loud";
            document.getElementById("table1_result_body").style.backgroundColor = "red";

          }
        }
        document.getElementById("data").innerHTML = html;
      }
    };
  }


</script>