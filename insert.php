<?php
//insert.php  
include ('includes/connection.php');
if(!empty($_POST))
{
    $output = '';
    $firstname = mysqli_real_escape_string($connect, $_POST["firstname"]);  
    $lastname = mysqli_real_escape_string($connect, $_POST["lastname"]);  
    $username = mysqli_real_escape_string($connect, $_POST["username"]);  
    $password  = mysqli_real_escape_string($connect, $_POST["password"]);
 
    $query = "INSERT INTO tbl_accounts(firstname, lastname, username, password) VALUES('$firstname', '$lastname', '$username', '$password')";

    if(mysqli_query($connect, $query))
    {
        $output .= '<label class="text-success">Successfully Created an Account!</label>';
        $select_query = "SELECT * FROM tbl_accounts ORDER BY id DESC";
        $result = mysqli_query($connect, $select_query);
        $output .= '
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th>First Name</th>  
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Action</th>

                        </tr>
        ';
        while($row = mysqli_fetch_array($result))
        {
            $output .= '
<tr>
                                <td>'.$row["firstname"] .'</td>
                                <td>'.$row["lastname"] .'</td>
                                <td>'.$row["username"] .'</td>
                                <td>'.$row["password"] .'</td>
                                <td>
                                    <input type="button" name="update" value="update" id="' . $row["id"] . '" class="btn btn-success update_data" />
                                    <input type="button" name="delete" value="delete" id="' . $row["id"] . '" class="btn btn-danger delete_data" />
                                </td>
                    
                            </tr>
        ';
        }
        $output .= '</table>';
    }
    echo $output;
}
?>
