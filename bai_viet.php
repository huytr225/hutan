<?php  
include("includes/header.php");

if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
else {
	$id = 0;
}
?>

<div class="user_details column">
	<div class="user_details column">
		<a href="<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()); ?>"><img src="<?php echo($nguoi_dung_dang_nhap->getAnhDaiDien()); ?>"></a>
		<div class="user_name">
			<a href="<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()) ?>">
				<?php 
				echo $nguoi_dung_dang_nhap->getHoTen(); ?>
			</a>
			<br>
		</div>
	</div>
</div>

<div class="main_column column" id="main_column">

	<div class="posts_area">

		<?php 
			$bai_viet = new BaiViet($con);
			$bai_viet->setId($id);
			$bai_viet->getBaiViet($nguoi_dung_dang_nhap->getTenTaiKhoan());
		?>

	</div>

</div>