<?php 
include '../../config/config.php';
include '../classes/NguoiDung.php';
include '../classes/LoiMoiKetBan.php';

$limit = 5;
$loi_moi = new LoiMoiKetBan($con);
$loi_moi->taiLoiMoi($_REQUEST['trang'], $_REQUEST['nguoi_dung_dang_nhap'], $limit);

 ?>