<?php include 'includes/connection.php';?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sessionstart.php';?>
<?php
if(!empty($_SESSION)) {
    ?>
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>STI Library</h3>
        </div>

        <ul class="list-unstyled components">
            

            <li>
                <a href="home.php">
                    <i class="fas fa-home"></i>  Home
                </a>
            </li>
            <li class="active">
                <a href="monitor.php">
                    <i class="fas fa-tv"></i>  Monitor
                </a>
            </li>
            <li>
                <a href="accounts.php">
                    <i class="fas fa-user-circle"></i> Account
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Page Content  -->
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-light ">
                    <i class="fas fa-align-left"></i>
                    <span>Menu</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

            </div>
        </nav>

        <div class="container-fluid mt-3">
            <!-- TABLES  -->
            <div class="row">
                <!-- Tables  1 -->
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-header" id="table_1_batteryLife" name="Table 1"></div>
                        <div class="card-body" id="table_1_result_body">
                            <p class="text-center text-white" id="table_1_result"></p>
                            <p class="text-center text-white" id="data1"></p> 
                        </div> 
                    </div>
                </div>
                <!-- Tables  2 -->
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-header" id="table_2_batteryLife" name="Table 2">Table 2</div>
                        <div class="card-body" id="table_2_result_body">
                            <p class="text-center text-white display-4" id="table_2_result"></p>
                            <p class="text-center text-white" id="data2"></p>
                        </div> 
                    </div>
                </div>
                <!-- Tables  3 -->
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-header">Table 3</div>
                        <div class="card-body">
                            <p class="text-center" id="table2_result"></p>
                            <p class="text-center text-white" id="data">Battery</p>
                        </div> 
                    </div>
                </div>
                <!-- Tables  4 -->
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-header">Table 4</div>
                        <div class="card-body">
                            <p class="text-center" id="table2_result"></p>
                            <p class="text-center text-white" id="data">Battery</p>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        refresh();
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });

    //Notification Table 1
    function showNotificationTable_1(){
        const notification = new Notification("Table 1 is too noisy", {
            body:"Please alert the individuals on the table.",
            icon: "favicon/apple-icon-152x152.png"
        });
    }

    console.log(Notification.permission);

    function showNotificationTable_1_now(){
        if (Notification.permission === "granted") {
            showNotificationTable_1();
        } 
        else if(Notification.permission !== "denied") {
            Notification.requestPermission().then(permission =>{
                if (permission === "granted") {
                    showNotificationTable_1();
                }
            });
        }
    }

    //Notification Table 2
    function showNotificationTable_2(){
        const notification = new Notification("Table 2 is too noisy", {
            body:"Please alert the individuals on the table.",
            icon: "favicon/apple-icon-152x152.png"
        });
    }

    console.log(Notification.permission);

    function showNotificationTable_2_now(){
        if (Notification.permission === "granted") {
            showNotificationTable_2();
        } 
        else if(Notification.permission !== "denied") {
            Notification.requestPermission().then(permission =>{
                if (permission === "granted") {
                    showNotificationTable_2();
                }
            });
        }
    }

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

                
                for(var a = 0; a < 1; a++) {
                    var id = data[0].id;
                    var table_1_soundlevel = data[0].soundlevel;
                    var table_1_battlevel = data[0].battlevel;

                    var table_2_soundlevel = data[1].soundlevel;
                    var table_2_battlevel = data[1].battlevel;                   

                    /*     Table 1 - Result    */   
                    if (table_1_soundlevel <= 59) { 
                        document.getElementById("table_1_result").innerHTML= "<h1>SILENT</h1><small>Action to be Performed: <br> Does not need intervention</small>";
                        document.getElementById("table_1_result_body").style.backgroundColor = "green";
                    }
                    else if (table_1_soundlevel <= 74) {
                        document.getElementById("table_1_result").innerHTML= "<h1>MODERATE</h1><small>Action to be Performed: <br> Observe the table</small>";
                        document.getElementById("table_1_result_body").style.backgroundColor = "orange";
                    }
                    else if (table_1_soundlevel > 75) {
                        document.getElementById("table_1_result").innerHTML= "<h1>LOUD</h1><small>Action to be Performed: <br> Needs to intervene</small>";
                        document.getElementById("table_1_result_body").style.backgroundColor = "red";
                        showNotificationTable_1_now();
                    }

                    /*     Table 1 - Battery    */   
                    if (table_1_battlevel >= 99) {
                        document.getElementById("table_1_batteryLife").innerHTML = "Table 1 <i class='fas fa-battery-full float-end'></i>";
                    }
                    else if (table_1_battlevel >= 75) {
                        document.getElementById("table_1_batteryLife").innerHTML = "Table 1 <i class='fas fa-battery-three-quarters float-end'></i>";
                    }
                    else if (table_1_battlevel >= 50) {
                        document.getElementById("table_1_batteryLife").innerHTML = "Table 1 <i class='fas fa-battery-half float-end'></i>";
                    }
                    else if (table_1_battlevel >= 10) {
                        document.getElementById("table_1_batteryLife").innerHTML = "Table 1 <i class='fas fa-battery-quarter float-end'></i>";
                    }
                    else if (table_1_battlevel >= 5) {
                        document.getElementById("table_1_batteryLife").innerHTML = "Table 1 <i class='fas fa-battery-empty float-end' style='color: red'></i>";
                    }

                   /*     Table 2 - Result       
                    if (table_2_soundlevel <= 59) { 
                        document.getElementById("table_2_result").innerHTML= "SILENT";
                        document.getElementById("table_2_result_body").style.backgroundColor = "green";
                    }
                    else if (table_2_soundlevel <= 74) {
                        document.getElementById("table_2_result").innerHTML= "MODERATE";
                        document.getElementById("table_2_result_body").style.backgroundColor = "orange";
                    }
                    else if (table_2_soundlevel > 75) {
                        document.getElementById("table_2_result").innerHTML= "LOUD";
                        document.getElementById("table_2_result_body").style.backgroundColor = "red";
                        showNotificationTable_2_now();
                    }*/

                    /*     Table 2 - Battery       
                    if (table_2_battlevel >= 99) {
                        document.getElementById("table_2_batteryLife").innerHTML = "Table 2 <i class='fas fa-battery-full float-end'></i>";
                    }
                    else if (table_2_battlevel >= 75) {
                        document.getElementById("table_2_batteryLife").innerHTML = "Table 2 <i class='fas fa-battery-three-quarters float-end'></i>";
                    }
                    else if (table_2_battlevel >= 50) {
                        document.getElementById("table_2_batteryLife").innerHTML = "Table 2 <i class='fas fa-battery-half float-end'></i>";
                    }
                    else if (table_2_battlevel >= 10) {
                        document.getElementById("table_2_batteryLife").innerHTML = "Table 2 <i class='fas fa-battery-quarter float-end'></i>";
                    }
                    else if (table_2_battlevel >= 5) {
                        document.getElementById("table_2_batteryLife").innerHTML = "Table 2 <i class='fas fa-battery-empty float-end' style='color: red'></i>";
                    } */                     


                }
                //document.getElementById("data1").innerHTML = "<td> Sound Level: " + table_1_soundlevel + " dB</td>";

            }
        };
    }

</script>
</body>
 <?php
 }else echo '<div class="alert alert-danger alert-dismissible fade show">
 <strong>Login Required!</strong> You needed to be login first before you can access the page.
 <a href="index.php"> Go back to login</a>
 </div>';
 ?>
</html>