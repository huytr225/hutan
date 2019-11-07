<?php 
require 'config/config.php';
require 'includes/handlers/vi_to_en.php';
require 'includes/form_handlers/xu_li_dang_ki.php';
require 'includes/form_handlers/xu_li_dang_nhap.php'; ?>

<html>
<head>
	<title>Chào mừng tới Hutan</title>
	<link rel="stylesheet" type="text/css" href="assets/css/dang_ki_style.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/dang_ki.js"></script>
</head>
<body>
	<?php 
	if (isset($_POST['dki_nut'])) {
	 	echo '
	 	<script>
	 	$(document).ready(function(){
	 		$("#first").hide();
	 		$("#second").show();
	 		})
	 	</script>
	 	';
	 } 
	 ?>
<div class="wrapper">
	<div class="login_box">
		<div class="login_header">
				<h1>Hutan!</h1>
				Mạng xã hội
		</div>
		<div id="first">
			<form action="dang_ki.php" method="POST">
				<input type="email" name="dnhap_email" placeholder="Email" value="<?php 
				if(isset($_SESSION['dnhap_email'])){
					echo($_SESSION['dnhap_email']);
				}
				 ?>" required>
				<br>
				<input type="password" name="dnhap_mat_khau" placeholder="Mật khẩu" value="<?php 
				if(isset($_SESSION['dnhap_mat_khau'])){
					echo($_SESSION['dnhap_mat_khau']);
				} ?>" required>
				<br>
				<?php if(in_array("Email hoặc mật khẩu không đúng<br>", $error_array)) echo "Email hoặc mật khẩu không đúng<br>"; ?>
				<input type="submit" name="dnhap_nut" id="dnhap_nut" value="Đăng nhập">
				<br>
				<a href="#" id="signup" class="signup">Đăng kí tại đây</a>

			</form>
		</div>
		<div id="second">
			<form action="dang_ki.php" method="POST">
				<input type="text" name="dki_ho" placeholder="Họ" value="<?php
				if(isset($_SESSION['dki_ho'])){
					echo($_SESSION['dki_ho']);
				}
				?>" required>
				<br>
				<?php if (in_array("Họ phải có từ 2 đến 25 kí tự<br>", $error_array)) {
					echo "Họ phải có từ 2 đến 25 kí tự<br>";
				} ?>
				<input type="text" name="dki_ten" placeholder="Tên" value="<?php 
				if(isset($_SESSION['dki_ten'])){
					echo($_SESSION['dki_ten']);
				}
				 ?>" required>
				
				<?php if (in_array("Tên phải có từ 2 đến 25 kí tự", $error_array)) {
					echo "Tên phải có từ 2 đến 25 kí tự<br>";
				} ?>
				<br>
				<input type="email" name="dki_email" placeholder="Email" value="<?php 
				if(isset($_SESSION['dki_email'])){
					echo($_SESSION['dki_email']);
				}
				 ?>" required>
				<br>
				<input type="email" name="dki_email2" placeholder="Xác nhận email" value="<?php 
				if(isset($_SESSION['dki_email2'])){
					echo($_SESSION['dki_email2']);
				}
				 ?>" required>
				<br>
				<?php if (in_array("Email đã được sử dụng<br>", $error_array)) {
					echo "Email đã được sử dụng<br>";
				} else if (in_array("Email không hợp lệ<br>", $error_array)) {
					echo "Email không hợp lệ<br>";
				} else if (in_array("Email không khớp nhau<br>", $error_array)) {
					echo "Email không khớp nhau<br>";
				}
				 ?>
				<input type="password" name="dki_mat_khau" placeholder="Mật khẩu" required>
				<br>
				<input type="password" name="dki_mat_khau2" placeholder="Xác nhận mật khẩu" required>
				<br>
				<?php if (in_array("Mật khẩu không khớp nhau<br>", $error_array)) {
					echo "Mật khẩu không khớp nhau<br>";
				} else if (in_array("Mật khẩu chỉ được chứa chữ và số<br>", $error_array)) {
					echo "Mật khẩu chỉ được chứa chữ và số<br>";
				} else if (in_array("Mật khẩu phải có từ 5 đến 30 kí tự<br>", $error_array)) {
					echo "Mật khẩu phải có từ 5 đến 30 kí tự<br>";
				}?>

				<input type="submit" name="dki_nut" value="Đăng kí">
				<br>
				<?php if(in_array("<span style='color: #14C800;'>Đăng kí thành công</span><br>", $error_array))
				 echo "<span style='color: #14C800;'>Đăng kí thành công</span><br>"; 
				 ?>	
				 <a href="#" id="signin" class="signin">Đã có tài khoản? Đăng nhập tại </a>

				</form>
		</div>
		
	</div>
</div>
</form>
</body>
</html>