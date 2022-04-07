<?php

session_start();
include ('connection.php');

if(count($_POST)>0) {
    
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']); 
    $result = mysqli_query($connect,"SELECT * FROM tbl_accounts WHERE username='$username' and password = '$password'");
    $row  = mysqli_fetch_array($result);
        if(is_array($row)) {
            $_SESSION["id"] = $row['id'];
            $_SESSION["username"]=$row['username'];
            $_SESSION["password"]=$row['password'];

           
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show">
           
            <strong>Login Failed!</strong> You put incorrect Username or Password.
            </div>';
        }
    }
if(isset($_SESSION["id"])) {
    header("Location:home.php");
}


?>