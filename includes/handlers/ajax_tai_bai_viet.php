<?php 
include '../../config/config.php';
include '../classes/NguoiDung.php';
include '../classes/BaiViet.php';

$limit = 10;
$bai_viet = new BaiViet($con);
$bai_viet->taiBaiVietBanBe($_REQUEST['trang'], $_REQUEST['nguoi_dung_dang_nhap'], $limit);
// taiBaiVietBanBe($con, $_REQUEST);

// function taiBaiVietBanBe($con, $data){
// 	$limit = 10;
// 	$trang = $data['trang'];
// 	$nguoi_dung_dang_nhap = new NguoiDung($con, $_REQUEST['nguoi_dung_dang_nhap']);
// 	//Noi bat dau va ket thuc kq tra ve trong bang CSDL

// 	$start = ($trang - 1) * $limit;
// 	// echo $start;
// 	$str = "";
// 	$mang_bai_viet = array();
// 	$mangBanBe = $nguoi_dung_dang_nhap->getMangBanBe();

// 	array_push($mangBanBe, $nguoi_dung_dang_nhap->getTenTaiKhoan());


// 	foreach ($mangBanBe as $ten_tai_khoan) {
// 		$nguoi_dung = new NguoiDung($con, $ten_tai_khoan);
// 		foreach ($nguoi_dung->getMangBaiViet() as $bai_viet) {
// 			array_push($mang_bai_viet, $bai_viet);
// 		}
// 	}
// 	print_r($mang_bai_viet);

// 	echo $str;
// }
 ?>