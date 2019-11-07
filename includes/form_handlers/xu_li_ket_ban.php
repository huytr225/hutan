

<?php 
if(isset($_POST['huy_ket_ban'])) {
	$nguoi_dung_dang_nhap->huyKetBan($nguoi_dung);
}

else if(isset($_POST['ket_ban'])) {
	$nguoi_dung_dang_nhap->guiLoiMoi($nguoi_dung);

}
else if(isset($_POST['phan_hoi'])) {
	header("Location: loi_moi_ket_ban.php");
}

else if(isset($_POST['dong_y'])) {
	$gui_tu = $_POST['gui_tu'];
	$nguoi_dung_dang_nhap->chapNhanLoiMoi($gui_tu);
	header("Location: loi_moi_ket_ban.php");
}

else if(isset($_POST['tu_choi'])) {
	$gui_tu = $_POST['gui_tu'];
	$nguoi_dung_dang_nhap->tuChoiLoiMoi($gui_tu);
	header("Location: loi_moi_ket_ban.php");
}



 ?>

