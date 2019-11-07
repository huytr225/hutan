<?php 
include '../../config/config.php';
include '../classes/NguoiDung.php';
include '../classes/TinNhan.php';

$tin_nhan = new TinNhan($con, $_REQUEST['nguoi_dung_dang_nhap']);
$tin_nhan->taiHoiThoai();

 ?>