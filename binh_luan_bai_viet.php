<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">	
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
</head>
<body>
	<style type="text/css">
	*{
		font-size: 12px;
	}
	a{
		color: #007bff;
		text-decoration: none;
	}
	</style>
	<?php 
	require 'config/config.php';
	include 'includes/classes/NguoiDung.php';
	include 'includes/classes/BaiViet.php';
	include 'includes/classes/BinhLuan.php';
	include 'includes/classes/ThongBao.php';
	if (isset($_SESSION['ten_tai_khoan'])) {
		$nguoi_dung_dang_nhap = new NguoiDung($con, $_SESSION['ten_tai_khoan']);
		$ten_tai_khoan = $nguoi_dung_dang_nhap->getTenTaiKhoan();
	} else {
		header("Location dang_ki.php");
	}
	if (isset($_GET['id_bai_viet']))
		$id_bai_viet = $_GET['id_bai_viet'];

	
	include 'includes/form_handlers/xu_li_binh_luan.php';
	?>

	<script>
		function toggle() {
			var element = document.getElementById("comment_section");

			if (element.style.display == "block") {
				element.style.display = "none";
			} else{
				element.style.display = "block"
			}
		}
	</script>

	<form action="binh_luan_bai_viet.php?id_bai_viet=<?php echo $id_bai_viet; ?>" id="comment_form" method="POST">
	 	<textarea name="noi_dung_binh_luan"></textarea>
	 	<input type="submit" name="dangBinhLuan<?php echo $id_bai_viet; ?>" value="Bình Luận">
	 </form>

	<?php 
	$tai_binh_luan = new BinhLuan($con);
	$tai_binh_luan->taiBinhLuan($id_bai_viet);
	
	?>

	<script>
	$(function(){
	 
		var nguoi_dung_dang_nhap = '<?php echo $nguoi_dung_dang_nhap->getTenTaiKhoan(); ?>';

		

		$(document).on('submit','#comment_form',function(){
		   console.log('hi');
		});
		
	});
		
	</script>

	

</body>

</html>