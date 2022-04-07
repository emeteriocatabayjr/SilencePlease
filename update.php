<?php include ('includes/connection.php');?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<form method="POST" action="uprec.php">
<?php 
//select.php  
if(isset($_POST["employee_id"]))
{
 $output = '';
 $query = "SELECT * FROM tbl_accounts WHERE id = '".$_POST["employee_id"]."'";
 $result = mysqli_query($connect, $query);
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
    while($row = mysqli_fetch_array($result))
    {
     $output .= '
       
            <input type="text" name="emp" id="emp" value="'.$row["id"].'" hidden />

                <div class="input-group mb-3">
                    <span class="input-group-text">First Name</span>
                    <input type="text" name="newfirstname"  id="newfirstname" class="form-control" value="'.$row["firstname"].'" /> 
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Last Name</span>
                    <input type="text" name="newlastname" id="newlastname" class="form-control" value="'.$row["lastname"].'" />
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Username</span>
                    <input type="text" name="newusername" id="newusername" class="form-control" value="'.$row["username"].'" />
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Password</span>
                    <input type="password" name="newpassword" id="newpassword" class="form-control" value="'.$row["password"].'" />
                </div>
   
     ';
    }
   
    echo $output;
}


?>
                <div class="btn-group d-flex " role="group">
                    <input type="submit" name="update" id="update" value="Update" class="btn btn-success" />
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
    
    
</form>
</body>
</html>