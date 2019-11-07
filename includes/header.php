<?php 
require 'config/config.php';
require 'includes/classes/NguoiDung.php';
require 'includes/classes/NguoiDungCaoCap.php';
require 'includes/classes/BaiViet.php';
require 'includes/classes/TinNhan.php';
require 'includes/classes/LoiMoiKetBan.php';
require 'includes/classes/ThongBao.php';
require 'includes/classes/HoSo.php';
require 'includes/classes/KinhNghiem.php';
require 'includes/classes/HocVan.php';
require 'includes/classes/KyNang.php';

if (isset($_SESSION['ten_tai_khoan'])) {
	if ($_SESSION['cao_cap'] == '0') {
		$nguoi_dung_dang_nhap = new NguoiDung($con, $_SESSION['ten_tai_khoan']);
	} else {
		$nguoi_dung_dang_nhap = new NguoiDungCaoCap($con, $_SESSION['ten_tai_khoan']);
	}
	
	$tin_nhan = new TinNhan($con, $_SESSION['ten_tai_khoan']);
	$thong_bao = new ThongBao($con, $_SESSION['ten_tai_khoan']);
} else {
	header("Location: dang_ki.php");
 }

$output = shell_exec('');
echo $output;
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title> Chào mừng tới Hutan</title>
 	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
 	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
 	<script type="text/javascript" src="assets/js/client.js"></script>
 	<link href="assets/css/fontawesome.min.css"rel="stylesheet">
    <link href="assets/css/brands.min.css">
    <link href="assets/css/solid.min.css" rel="stylesheet">
    <link href="assets/css/regular.min.css" rel="stylesheet">
 	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
 	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
 </head>
 <body>
 	<div class="top_bar">
 		<div class="logo">
 			<a href="index.php">Hutan</a>
 		</div>
 		<div class="search">

			<form action="tim_kiem.php" method="GET" name="search_form">
				<input type="text" name="q" placeholder="Search..." id="search_text_input">

				<div class="button_holder">
					<i class="fas fa-search"></i>
				</div>

			</form>

			<div class="search_results">
			</div>

			<div class="search_results_footer_empty">
			</div>



		</div>
 		<nav>
	 		<a href="<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()); ?>">
	 			<?php echo $nguoi_dung_dang_nhap->getTen(); ?>
	 		</a>
	 		<a href="index.php">
	 			<i class="fas fa-home"></i>
	 		</a>

			<a id="thong_bao_ket_ban" style="border-left: 1.5px solid;" href="loi_moi_ket_ban.php">
			<?php 
				$so_luong = $nguoi_dung_dang_nhap->getSoLoiMoi();
				if ($so_luong == 0) {
					echo '<i class="far fa-user"></i>';
				} else {
					echo "<i class='fas fa-user'><span class='noti'>" . $so_luong . "</span></i>";
				}
				?> 
			</a>
	 		<a id="thong_bao_tin_nhan" href="tin_nhan.php">
	 			<?php 
				$so_luong = $tin_nhan->getSoTinNhanChuaXem();
				if ($so_luong == 0) {
					echo '<i class="far fa-comment"></i>';
				} else {
					echo "<i class='fas fa-comment'><span class='noti'>" . $so_luong . "</span></i>";
				}
				?> 
			</a>
			<a id="thong_bao" style="border-right: 1.5px solid;" href="thong_bao.php">
				<?php 
				$so_luong = $thong_bao->getSoThongBao();
				if ($so_luong == 0) {
					echo '<i class="far fa-bell"></i>';
				} else {
					echo "<i class='fas fa-bell'><span class='noti'>" . $so_luong . "</span></i>";
				}
				?> 
			</a>
			<a href="quan_ly_cv.php">
				<i class="fas fa-cog"></i>
			</a>
			<a href="includes/handlers/logout.php">
				<i class="fas fa-sign-out-alt"></i>
			</a>
	 	</nav>
 	</div>
 	<script>
 		var nguoi_dung_dang_nhap = '<?php echo $nguoi_dung_dang_nhap->getTenTaiKhoan() ?>';

 		websocket.onmessage = function(ev) {
			var response 		= JSON.parse(ev.data); //PHP sends Json data
			
			var res_type 		= response.type; //message type
			var gui_tu 			= response.gui_tu; //message text
			var gui_toi 		= response.gui_toi; //user name
			var so_luong 		= response.so_luong;
			var message 		= response.message;
			console.log(response);
			switch(res_type){
				
				case 'nhan_tin':
					if (gui_toi == nguoi_dung_dang_nhap) {
						var thong_bao_tin_nhan = $("#thong_bao_tin_nhan");

						if (so_luong == 0) {
							thong_bao_tin_nhan.html('<i class="far fa-comment"></i>');
						} else {
							thong_bao_tin_nhan.html("<i class='fas fa-comment'><span class='noti'>" + so_luong + "</span></i>");
						}
					}
					break;
				
				case 'ket_ban':
					console.log('ket_ban');
					if (gui_toi == nguoi_dung_dang_nhap) {
						var thong_bao_ket_ban = $("#thong_bao_ket_ban");

						if (so_luong == 0) {
							thong_bao_ket_ban.html('<i class="far fa-user"></i>');
						} else {
							thong_bao_ket_ban.html("<i class='fas fa-user'><span class='noti'>" + so_luong + "</span></i>");
						}
					}
					break;
				case 'thong_bao':
					if (gui_toi == nguoi_dung_dang_nhap) {
						var thong_bao = $("#thong_bao");

						if (so_luong == 0) {
							thong_bao.html('<i class="far fa-bell"></i>');
						} else {
							thong_bao.html("<i class='fas fa-bell'><span class='noti'>" + so_luong + "</span></i>");
						}
					}
					break;
				case 'system':
					console.log(message);
					// msgBox.append('<div style="color:#bbbbbb">' + message + '</div>');
					break;
			}
			
		};


 	</script>

 	<div class="wrapper">
