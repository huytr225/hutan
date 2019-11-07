<?php 
include("includes/header.php");

if (isset($_GET['u'])) {
	$nguoi_dung = new NguoiDung($con, $_GET['u']);
	if($nguoi_dung->getTenTaiKhoan() != $_GET['u']){
		header("Location: index.php");
	}
	$ho_so = $nguoi_dung_dang_nhap->getHoSo($nguoi_dung);
}
 ?>

	<style type="text/css">
		.wrapper{
			margin-left: 0px;
			padding-left: 0px;
		}
	</style>	
	<link rel="stylesheet" type="text/css" href="assets/css/gioi_thieu.css">
	<div class="profile_left">
		<img src="<?php echo($nguoi_dung->getAnhDaiDien()) ?>">
		<div class="profile_info">
			<p><?php echo "Số bài viết: " .$nguoi_dung->getSoBaiViet(); ?></p>
			<p><?php echo "Số lượt thích: " .$nguoi_dung->getSoLuotThich(); ?></p>
			<p><?php echo "Số bạn bè: " .$nguoi_dung->getSoBanBe(); ?></p>
		</div>
		<a id="gioi_thieu" class="btn btn-info" href="gioi_thieu.php?u=<?php echo($nguoi_dung->getTenTaiKhoan()) ?>">Giới thiệu</a>
		<?php 
			if ($nguoi_dung != $nguoi_dung_dang_nhap) {
				echo '<a id="nhan_tin" class="btn btn-primary" role="button" href="tin_nhan.php?u='. $nguoi_dung->getTenTaiKhoan().'">Nhắn Tin</a>';
			}

		 ?>
		
		<form action="<?php echo($nguoi_dung->getTenTaiKhoan()) ?>" method="POST">
		<?php 
			if ($nguoi_dung != $nguoi_dung_dang_nhap) {
				if ($nguoi_dung_dang_nhap->laBanBe($nguoi_dung)) {
					echo '<input class="btn btn-danger" type="submit" name="huy_ket_ban" value="Huỷ kết bạn"><br>';
				} else if ($nguoi_dung_dang_nhap->daNhanLoiMoi($nguoi_dung)) {
					echo '<input type="submit" class="btn btn-warning" name="phan_hoi" value="Phản hồi lời mời"><br>';
				} else if ($nguoi_dung_dang_nhap->daGuiLoiMoi($nguoi_dung)) {
					echo '<input type="submit" name="" class="btn btn-secondary" disabled value="Đã gửi lời mời"><br>';
				} else {
					echo '<input id="ket_ban" name="ket_ban" class="btn btn-success" value="Kết bạn"><br>';
				}
			}
		 ?>
		</form>
		
	</div>


	<div class="main_column column">
		<body id="top">
<div id="cv" class="instaFade">
	<div class="mainDetails">
		<div id="headshot" class="quickFade">
			<img src="<?php echo($nguoi_dung->getAnhDaiDien()) ?>" alt="Alan Smith" />
		</div>
		
		<div id="name">
			<h1 class="quickFade delayTwo"><?php echo($nguoi_dung->getHoTen()); ?></h1>
			<h2 class="quickFade delayThree"><?php echo($ho_so->getTenHoSo()) ?></h2>
		</div>
		
		<div id="contactDetails" class="quickFade delayFour">
			<ul>
				<li>Địa chỉ: <?php echo($ho_so->getDiaChi()) ?></li>
				<li>Điện thoại: <?php echo $ho_so->getSDT() ?></li>
				<li>Email: <a href="mailto:joe@bloggs.com" target="_blank"><?php echo($nguoi_dung->getEmail()) ?></a></li>
				
				<!-- <li>Giới tính: Nam</li> -->
				<li>Ngày sinh: <?php echo($ho_so->getNgaySinh()) ?></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	
	<div id="mainArea" class="quickFade delayFive">
		<!-- <section>
			<article>
				<div class="sectionTitle">
					<h1>Thông tin cá nhân</h1>
				</div>
				
				<div class="sectionContent">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dolor metus, interdum at scelerisque in, porta at lacus. Maecenas dapibus luctus cursus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ultricies massa et erat luctus hendrerit. Curabitur non consequat enim. Vestibulum bibendum mattis dignissim. Proin id sapien quis libero interdum porttitor.</p>
				</div>
			</article>
			<div class="clear"></div>
		</section>
		 -->
		
		

			<?php 
			$str = "";

			$mang_kinh_nghiem = $ho_so->getMangKinhNghiem();
			if (sizeof($mang_kinh_nghiem) != 0) {
				$str .= "<section>
								<div class='sectionTitle'>
									<h1>Kinh nghiệm làm việc</h1>
								</div>
								<div class='sectionContent'>";
			}
			foreach ($mang_kinh_nghiem as $kinh_nghiem) {
					$ten_cong_ty = $kinh_nghiem->getTenCongTy();
					$vi_tri = $kinh_nghiem->getViTri();
					$ngay_bat_dau = $kinh_nghiem->getNgayBatDau();
					$ngay_hoan_thanh = $kinh_nghiem->getNgayHoanThanh();
					$mo_ta = $kinh_nghiem->getMoTa();
					$an = $kinh_nghiem->getAn() ? 'checked' : '';


					$str .= "
								<article>
									<h2>$vi_tri tại $ten_cong_ty</h2>
									<p class='subDetails'>$ngay_bat_dau - $ngay_hoan_thanh</p>
									<p>$mo_ta</p>
								</article>
							";
				}
			if (sizeof($mang_kinh_nghiem) != 0) {
				$str .= "</div>
							<div class='clear'></div>
						</section>";
			}
			echo $str;
			

			$str = "";

			$mang_hoc_van = $ho_so->getMangHocVan();
			if (sizeof($mang_hoc_van) != 0) {
				$str .= "<section>
								<div class='sectionTitle'>
									<h1>Học vấn</h1>
								</div>
								<div class='sectionContent'>";
			}
			foreach ($mang_hoc_van as $hoc_van) {
					$ten_truong = $hoc_van->getTenTruong();
					$chuyen_nganh = $hoc_van->getChuyenNganh();
					$ngay_bat_dau = $hoc_van->getNgayBatDau();
					$ngay_hoan_thanh = $hoc_van->getNgayHoanThanh();
					$mo_ta = $hoc_van->getMoTa();
					$an = $hoc_van->getAn() ? 'checked' : '';


					$str .= "
								<article>
									<h2>$ten_truong</h2>
									<p class='subDetails'>$ngay_bat_dau - $ngay_hoan_thanh</p>

									<p>$mo_ta</p>
								</article>
							";
				}
			if (sizeof($mang_hoc_van) != 0) {
				$str .= "</div>
							<div class='clear'></div>
						</section>";
			}
			echo $str;
			

			$str = "";

			$mang_ky_nang = $ho_so->getMangKyNang();
			if (sizeof($mang_ky_nang) != 0) {
				$str .= "<section>
								<div class='sectionTitle'>
									<h1>Kỹ năng</h1>
								</div>
								<div class='sectionContent'>";
			}
			foreach ($mang_ky_nang as $ky_nang) {
					$ten_ky_nang = $ky_nang->getTenKyNang();
					$mo_ta = $ky_nang->getMoTa();
					$an = $ky_nang->getAn() ? 'checked' : '';


					$str .= "
								<article>
									<h2>$ten_ky_nang</h2>
									<p>$mo_ta</p>
								</article>
							";
				}
			if (sizeof($mang_ky_nang) != 0) {
				$str .= "</div>
							<div class='clear'></div>
						</section>";
			}
			echo $str;


			 ?>
		
	</div>
</div>
	</div>
	<div>
	
	<script>

		
	</script>
</body>
</html>