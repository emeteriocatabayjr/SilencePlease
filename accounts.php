<?php include ('includes/connection.php');?>
<?php include 'includes/header.php'; ?>
<?php include ('includes/sessionstart.php');?>
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
            <li>
                <a href="monitor.php">
                    <i class="fas fa-tv"></i>  Monitor
                </a>
            </li>
            <li class="active">
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

                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-align-left"></i>
                    <span>Menu</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

            </div>
        </nav>
        <div class="container">  
            <h3 align="center">Librarian Accounts</h3>  
            <br />  
            <div class="table-responsive">
                <div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#add_data_Modal" class="btn btn-warning">Add More Accounts</button>

                </div>
                <br />
                <div id="employee_table">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th>First Name</th>  
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Action</th>

                        </tr>
                        <?php
                        $query = "SELECT * FROM tbl_accounts ORDER BY id DESC";
                        $result = mysqli_query($connect, $query);
                        while($row = mysqli_fetch_array($result))
                        {
                          ?>
                            <tr>
                                <td><?php echo $row["firstname"]; ?></td>
                                <td><?php echo $row["lastname"]; ?></td>
                                <td><?php echo $row["username"]; ?></td>
                                <td type="password"><?php echo $row["password"]; ?></td>
                                <td class="text-center">
                                    <input type="button" name="update" value="update" id="<?php echo $row["id"]; ?>" class="btn mb-1 btn-success update_data" />
                                    <input type="button" name="delete" value="delete" id="<?php echo $row["id"]; ?>" class="btn mb-1 btn-danger delete_data" />
                                </td>
                    
                            </tr>
                        <?php
                            }
                            ?>
                    </table>
                </div>
            </div>  
        </div>

    </div>
</div>


<div id="add_data_Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Librarian Accounts</h4>
           
            </div>
            <div class="modal-body">
                <form method="post" id="insert_form">
                    <div class="input-group mb-3">
                        <span class="input-group-text">First Name</span>
                        <input type="text" name="firstname" id="firstname" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Last Name</span>
                        <input type="text" name="lastname" id="lastname" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Username</span>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Password</span>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    
                    <div class="btn-group d-flex " role="group">
                        <button type="submit" name="insert" id="insert" class="btn btn-success">Add</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>       
        </div>
    </div>
</div>


<div id="dataModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Librarian Details</h4>
            </div>
            <div class="modal-body" id="employee_detail">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        $('#insert_form').on("submit", function(event){ 
            event.preventDefault();  
            if($('#firstname').val() == ""){  
                alert("Name is required");  
            }  
            else if($('#lastname').val() == ''){  
                alert("Address is required");  
            }  
            else if($('#username').val() == ''){  
                alert("Designation is required");  
            }
   
            else{  
                $.ajax({  
                    url:"insert.php",  
                    method:"POST",  
                    data:$('#insert_form').serialize(),  
                    beforeSend:function(){  
                        $('#insert').val("Inserting");  
                    },  
                    success:function(data){  
                        $('#insert_form')[0].reset();  
                        $('#add_data_Modal').modal('hide');  
                        $('#employee_table').html(data);  
                    }  
                });  
            }  
        });


    });
    $(document).on('click', '.delete_data', function(){
        var employee_id = $(this).attr("id");
        $.ajax({
            url:"delete.php",
            method:"POST",
            data:{employee_id:employee_id},
            success:function(data){
                $('#employee_detail').html(data);
                $('#dataModal').modal('show');
            }
        });
    });
    
    $(document).on('click', '.update_data', function(){
            var employee_id = $(this).attr("id");
            $.ajax({
                url:"update.php",
                method:"POST",
                data:{employee_id:employee_id},
                success:function(data){
                    $('#employee_detail').html(data);
                    $('#dataModal').modal('show');
                }
            });
        });

 <?php
 }else echo '<div class="alert alert-danger alert-dismissible fade show">
 <strong>Login Required!</strong> You needed to be login first before you can access the page.
 <a href="index.php"> Go back to login</a>
 </div>';
 ?>
</script>
</body>

</html>