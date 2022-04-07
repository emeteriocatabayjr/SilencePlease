<?php include ('includes/connection.php');?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<form method="POST" action="delrec.php">
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

        
        
     ';
    }
    $output .= '</table></div>';
    echo $output;
}


?>
                <div class="btn-group d-flex " role="group">
                    <input type="submit" name="delete" id="delete" value="DELETE this Record" class="btn btn-success" />
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
   
</form>
</body>
</html>