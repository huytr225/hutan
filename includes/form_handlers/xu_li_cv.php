
<?php 

if (isset($_POST['them_ho_so'])) {
	// $ho_so = new HoSo($con, $_POST['ten_ho_so']);	

}

if (isset($_POST['set_cv'])) {
	$ho_so = new HoSo($con, $nguoi_dung_dang_nhap->getTenTaiKhoan());
	$ho_so->setId($_POST['id']);
	$ho_so->setHoSoChinh();
}

if (isset($_POST['xoa_cv'])) {
	$ho_so = new HoSo($con, $nguoi_dung_dang_nhap->getTenTaiKhoan());
	$ho_so->setId($_POST['id']);
	$ho_so->xoaHoSo();
}

if (isset($_POST['luu_ho_so'])) {
	if ($_POST['id'] == 'new') {
		$ho_so = new HoSo($con, $nguoi_dung_dang_nhap->getTenTaiKhoan());
		$ho_so->themHoSo($_POST['thong_tin_ho_so'], $_POST['thong_tin_ca_nhan']);
		var_dump($ho_so);
	} else {
		$ho_so = new HoSo($con, $nguoi_dung_dang_nhap->getTenTaiKhoan());
		$ho_so->capNhatHoSo($_POST['id'], $_POST['thong_tin_ho_so'], $_POST['thong_tin_ca_nhan']);
		
	}
}

 ?>