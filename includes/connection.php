<?php
$connect = mysqli_connect("localhost", "root", "", "noisedetector");
if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}
?>