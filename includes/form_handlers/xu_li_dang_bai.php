<?php 

if (isset($_POST['dang_bai'])) {
	$dang_boi = $_POST['dang_boi'];
	$dang_toi = $_POST['dang_toi'];
	$noi_dung = $_POST['noi_dung'];
	$bai_viet = new BaiViet($con);
	$bai_viet->dangBai($noi_dung, $dang_boi, $dang_toi);
}

 ?>