 <?php 
$ho = ""; // Họ
$ten = ""; // Tên
$email = ""; //Email
$email2 = ""; //Xác nhận Email
$mat_khau = ""; //mk
$mat_khau2 = ""; // xác nhận mk
$date = ""; // ngày đki
$error_array = array(); //Luu tru thong bao loi

if (isset($_POST['dki_nut'])) {

	// Xử lý dữ liệu

	//Ho 
	$ho = strip_tags($_POST['dki_ho']); //Loai bo html tag
	// $ho = str_replace(" ", "", $ho); // Loai bo khoang trong
	$ho = ucwords(strtolower($ho)); // Viet hoa chu cai dau
	$_SESSION['dki_ho'] = $ho;

	//Ten
	$ten = strip_tags($_POST['dki_ten']); //Loai bo html tag
	// $ten = str_replace(" ", "", $ten); // Loai bo khoang trong
	$ten = ucwords(strtolower($ten)); // Viet hoa chu cai dau

	$_SESSION['dki_ten'] = $ten;

	//Email
	$email = strip_tags($_POST['dki_email']); //Loai bo html tag
	$email = str_replace(" ", "", $email); // Loai bo khoang trong
	// $email = ucfirst(strtolower($email)); // Viet hoa chu cai dau
	$_SESSION['dki_email'] = $email;

	//Email2
	$email2 = strip_tags($_POST['dki_email2']); //Loai bo html tag
	$email2 = str_replace(" ", "", $email2); // Loai bo khoang trong
	// $email2 = ucfirst(strtolower($email2)); // Viet hoa chu cai dau
	$_SESSION['dki_email2'] = $email2;

	//Pass
	$mat_khau = strip_tags($_POST['dki_mat_khau']);
	$mat_khau2 = strip_tags($_POST['dki_mat_khau2']);

	$ngay_dang_ki = date("Y-m-d"); //Ngay hom nay



	if($email == $email2){
		//Kiểm tra validate email
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

			$email = filter_var($email, FILTER_VALIDATE_EMAIL);

			//Kiểm tra email trong db
			$e_check = mysqli_query($con, "SELECT email FROM NguoiDung WHERE email='$email'");

			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0) {
				array_push($error_array, "Email đã được sử dụng<br>");
			}

		}
		else {
			array_push($error_array, "Email không hợp lệ<br>");
		}
	} else {
		array_push($error_array, "Email không khớp nhau<br>");
	}

	if (strlen($ho) > 25 || strlen($ho) < 2) {
		array_push($error_array, "Họ phải có từ 2 đến 25 kí tự<br>");
	}

	if (strlen($ten) > 25 || strlen($ten) < 2) {
		array_push($error_array, "Tên phải có từ 2 đến 25 kí tự<br>");
	}

	if ($mat_khau != $mat_khau2) {
		array_push($error_array, "Mật khẩu không khớp nhau<br>");
	} else {
		if(preg_match('/[^A-Za-z0-9]/', $mat_khau)) {
			array_push($error_array, "Mật khẩu chỉ được chứa chữ và số<br>");
		}
	}

	if (strlen($mat_khau) > 30 || strlen($mat_khau) < 5) {
		array_push($error_array, "Mật khẩu phải có từ 5 đến 30 kí tự<br>");
	}

	if(empty($error_array)){
		$ngay_dang_ki = date("Y-m-d"); //Ngay hom nay
		$mat_khau = md5($mat_khau);
		$error_array = array();

		//Tao ten tai khoan

		$ten_tai_khoan = strtolower(convert_vi_to_en($ho) . "_" . convert_vi_to_en($ten));
		$check_tai_khoan_query = mysqli_query($con, "SELECT id FROM NguoiDung WHERE ten_tai_khoan = '$ten_tai_khoan'");

		$i = 0;
		while (mysqli_num_rows($check_tai_khoan_query)) {
			$i++;
			$ten_tai_khoan = $ten_tai_khoan . "_" . $i;
			$check_tai_khoan_query = mysqli_query($con, "SELECT id FROM NguoiDung WHERE ten_tai_khoan = '$ten_tai_khoan'");
		}

		//Tao anh dai dien ngau nhien
		$anh_dai_dien = "assets/images/profile_pics/defaults/no-profile.png";
		
		$query = mysqli_query($con, "INSERT INTO NguoiDung VALUES (NULL, '$ho', '$ten', '$ten_tai_khoan', '$email', '$mat_khau', '$ngay_dang_ki', '$anh_dai_dien', '0', '0', '0', ',')");
		array_push($error_array, "<span style='color: #14C800;'>Đăng kí thành công</span><br>");
		mysqli_error($con);
		// Xoá các biến session
		$_SESSION['dki_ho'] = "";
		$_SESSION['dki_ten'] = "";
		$_SESSION['dki_email'] = "";
		$_SESSION['dki_email2'] ="";
		
	}

}

?>