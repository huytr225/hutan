<?php 
// ob_start();

session_start();

$timezone = date_default_timezone_set("Asia/Ho_Chi_Minh");

$con = mysqli_connect("localhost:3306", "root", "", "hutan");

if (mysqli_connect_errno()) {
	echo "Kết nối thất bại" . mysqli_connect_errno();
}

$host    = "localhost";
$port    = 8090;


 ?>