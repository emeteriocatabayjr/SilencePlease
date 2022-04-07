<?php

session_start();


if(count($_POST)>0) {
    include ('connection.php');
    $result = mysqli_query($connect,"SELECT * FROM tbl_accounts WHERE username='" . $_POST["username"] . "' and password = '". $_POST["password"] ."'");
    $row  = mysqli_fetch_array($result);
        if(is_array($row)) {
            $_SESSION["id"] = $row['id'];
            $_SESSION["password"]=$row['firsname'];
            $_SESSION["password"]=$row['lastname'];
            $_SESSION["username"]=$row['username'];
            $_SESSION["password"]=$row['password'];

           
        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Login Failed!</strong> Try again, put correct username or password.
                </div>';
        }
    }
if(isset($_SESSION["id"])) {
    header("Location:home.php");
}


?>