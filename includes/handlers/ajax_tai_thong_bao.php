<?php 
include '../../config/config.php';
include '../classes/NguoiDung.php';
include '../classes/ThongBao.php';

$limit = 5;
$thong_bao = new ThongBao($con, $_REQUEST['nguoi_dung_dang_nhap']);
echo($thong_bao->taiThongBao($_REQUEST['trang'], $_REQUEST['nguoi_dung_dang_nhap'], $limit));


 ?>