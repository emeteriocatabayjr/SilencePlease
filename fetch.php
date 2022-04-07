<?php
include 'includes/connection.php';
$result = mysqli_query($connect, "SELECT * FROM units");
 
$data = array();
while ($row = mysqli_fetch_object($result))
{
    array_push($data, $row);
}
 
echo json_encode($data);
exit();