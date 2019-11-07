<?php 

//Post dữ liệu
if (isset($_POST['dnhap_nut'])) {

	//Xử lý dữ liệu
	$email = filter_var($_POST['dnhap_email'], FILTER_SANITIZE_EMAIL); //sanitize email Sanitizing is to clean the bad characters out of the email.
	$_SESSION['dnhap_email'] = $email; // Lưu email 
	$mat_khau = md5($_POST['dnhap_mat_khau']); //Mã hoá mat_khau

	//Đăng nhập
	$error_array = dangNhap($con, $email, $mat_khau);

	if(in_array("Đăng nhập thành công", $error_array)){
		header("Location: index.php");
	} 
}

function dangNhap($con, $email, $mat_khau){
	$error_array = array();

	$check_database_query = mysqli_query($con, "SELECT * FROM NguoiDung WHERE email='$email' AND mat_khau='$mat_khau'");
	$kiem_tra_dnhap_query = mysqli_num_rows($check_database_query);
	if($kiem_tra_dnhap_query == 1) {
		array_push($error_array, "Đăng nhập thành công");
		$row = mysqli_fetch_array($check_database_query);
		$ten_tai_khoan = $row['ten_tai_khoan'];

		$_SESSION['ten_tai_khoan'] = $ten_tai_khoan;
		$_SESSION['cao_cap'] = $row['cao_cap'];
	}
	else {
		array_push($error_array, "Email hoặc mật khẩu không đúng<br>");
	}

	return $error_array;
}

 ?>