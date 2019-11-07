<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
</head>
<body>
	<style type="text/css">
		body {
			background-color: #fff;
		}
		form {
			position: absolute;
			top: 0;
		}
		.comment_like {
			background-color: transparent;
			border: none;
			font-size: 14px;
			color: #3498db;
			padding: 0;
			height: auto;
			width: auto;
			margin: 0;
		}

		.like_value {
			display: inline;
			font-size: 14px;
		}
	</style>

	<?php 
	require 'config/config.php';
	include 'includes/classes/NguoiDung.php';
	include 'includes/classes/BaiViet.php';
	include 'includes/classes/Thich.php';
	require 'includes/classes/ThongBao.php';
	if (isset($_SESSION['ten_tai_khoan'])) {
		$nguoi_dung_dang_nhap = new NguoiDung($con, $_SESSION['ten_tai_khoan']);
		$ten_tai_khoan = $nguoi_dung_dang_nhap->getTenTaiKhoan();
	} else {
		header("Location dang_ki.php");
	}

	if (isset($_GET['id_bai_viet'])) {
		$id_bai_viet = $_GET['id_bai_viet'];
	}



	// $get_likes = mysqli_query($con, "SELECT so_luot_thich, dang_boi FROM BaiViet WHERE id='$id_bai_viet'");
	// $row = mysqli_fetch_array($get_likes);
	// $so_luot_thich = $row['so_luot_thich'];
	// $nguoi_duoc_thich = $row['dang_boi'];

	$bai_viet = new BaiViet($con);
	$bai_viet->setId($id_bai_viet);
	$so_luot_thich = $bai_viet->getSoLuotThich();


	// $query = mysqli_query($con, "SELECT * FROM NguoiDung WHERE ten_tai_khoan = '$nguoi_duoc_thich'");
	// $row = mysqli_fetch_array($query);
	// $so_luot_thich_nguoi_dung = $row['so_luot_thich'];

	if (isset($_POST['nut_thich'])) {

		$thich = new Thich($con);
		$thich->thichBaiViet($ten_tai_khoan, $id_bai_viet);
		$so_luot_thich++;

		// $query = mysqli_query($con, "UPDATE BaiViet SET so_luot_thich='$so_luot_thich' WHERE id='$id_bai_viet'");
		// $so_luot_thich_nguoi_dung++;
		// $query = mysqli_query($con, "UPDATE NguoiDung SET so_luot_thich='$so_luot_thich_nguoi_dung' WHERE ten_tai_khoan='$nguoi_duoc_thich'");
		// $query = mysqli_query($con, "INSERT INTO Thich VALUES ('','$ten_tai_khoan','$id_bai_viet')");
		//Them THong bao
		?>
		<script>
		$(function(){
		 
			var nguoi_dung_dang_nhap = '<?php echo $nguoi_dung_dang_nhap->getTenTaiKhoan(); ?>';
			var dang_boi = '<?php echo $bai_viet->getDangBoi() ?>';
			var dang_toi = '<?php echo $bai_viet->getDangToi() ?>';
	

		   var msg = {
				gui_tu: nguoi_dung_dang_nhap,
				gui_toi: dang_toi,
				type: 'thong_bao'
			};
			if (nguoi_dung_dang_nhap != dang_boi) {
				parent.websocket.send(JSON.stringify(msg));
			}
			
		});
			
			
		</script>
		<?php

	}

	if (isset($_POST['nut_huy_thich'])) {
		$thich = new Thich($con);
		$thich->huyThichBaiViet($ten_tai_khoan, $id_bai_viet);

		$so_luot_thich--;
		// $query = mysqli_query($con, "UPDATE BaiViet SET so_luot_thich='$so_luot_thich' WHERE id='$id_bai_viet'");
		// $so_luot_thich_nguoi_dung--;
		// $query = mysqli_query($con, "UPDATE NguoiDung SET so_luot_thich='$so_luot_thich_nguoi_dung' WHERE ten_tai_khoan='$nguoi_duoc_thich'");
		// $query = mysqli_query($con, "DELETE FROM Thich WHERE ten_tai_khoan='$ten_tai_khoan' AND id_bai_viet='$id_bai_viet'");
		//Them THong bao
	}

	$thich = new Thich($con);
	if($thich->daThich($ten_tai_khoan, $id_bai_viet)){
		echo "<form action='thich.php?id_bai_viet=" . $id_bai_viet . "' method='POST'>
		<input type='submit' class='comment_like' name='nut_huy_thich' value='Bỏ Thích'>
		<div class='like_value'>" . $so_luot_thich. " người</div>
		</form>";
	} else {
		echo "<form action='thich.php?id_bai_viet=" . $id_bai_viet . "' method='POST' id='like_form'>
		<input type='submit'class='comment_like' name='nut_thich' value='Thích'>
		<div class='like_value'>" . $so_luot_thich. " người</div>
		</form>";
	}
	?>

	


	
</body>
</html>