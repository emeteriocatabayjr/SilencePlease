 <?php include ('includes/connection.php');?>
 <?php
 $empid = $_POST["emp"];
 $firstname = $_POST["newfirstname"];
 $lastname = $_POST["newlastname"]; 
 $username = $_POST["newusername"]; 
 $password = $_POST["newpassword"]; 

	

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$sql = "UPDATE tbl_accounts SET firstname='$firstname', lastname='$lastname', username='$username', password='$password' WHERE id='$empid'";
if (mysqli_query($connect, $sql)) {
		echo '<script type="text/javascript">'; 
		echo 'alert("Record updated successfully");'; 
		echo 'window.location.href = "accounts.php";';
		echo '</script>';       

} else {
    echo "Error updating record: " . mysqli_error($connect);
}

mysqli_close($connect);




 ?>