<?php 
include '../../config/config.php';
include '../classes/NguoiDung.php';
include '../classes/BaiViet.php';

$limit = 10;
$bai_viet = new BaiViet($con);
$bai_viet->taiBaiVietHoSo($_REQUEST['trang'], $_REQUEST['nguoi_dung_dang_nhap'], $_REQUEST['nguoi_dung'], $limit);
 ?>