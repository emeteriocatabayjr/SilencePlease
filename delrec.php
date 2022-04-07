
<?php
$id = $_POST["emp"];

include ('includes/connection.php');


if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$sql = "DELETE FROM tbl_accounts WHERE id='$id'";
if (mysqli_query($connect, $sql)) {
		echo '<script type="text/javascript">'; 
		echo 'alert("Record deleted successfully");'; 
		echo 'window.location.href = "accounts.php";';
		echo '</script>';       

} else {
    echo "Error updating record: " . mysqli_error($connect);
}

mysqli_close($connect);


?>