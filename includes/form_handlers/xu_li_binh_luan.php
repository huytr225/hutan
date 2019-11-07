<?php 

// $query = mysqli_query($con, "SELECT dang_boi, dang_toi FROM BaiViet WHERE id='$id_bai_viet'");
// $row = mysqli_fetch_array($query);
// $error_array = array();
// $binh_luan_toi = $row['dang_boi'];
if (isset($_POST['dangBinhLuan' . $id_bai_viet])) {

	$noi_dung_binh_luan = $_POST['noi_dung_binh_luan'];
	$noi_dung_binh_luan = mysqli_escape_string($con, $noi_dung_binh_luan);
	$binh_luan = new BinhLuan($con);
	$binh_luan->dangBinhLuan($noi_dung_binh_luan, $ten_tai_khoan, $id_bai_viet);
	$bai_viet = new BaiViet($con);
	$bai_viet->setId($id_bai_viet);
	?>
		<script>
		$(function(){
		 
			var nguoi_dung_dang_nhap = '<?php echo $nguoi_dung_dang_nhap->getTenTaiKhoan(); ?>';
			var dang_boi = '<?php echo $bai_viet->getDangBoi() ?>';
			var dang_toi = '<?php echo $bai_viet->getDangToi() ?>';
	

		   var msg = {
				gui_tu: nguoi_dung_dang_nhap,
				gui_toi: dang_toi,
				type: 'thong_bao'
			};
			if (nguoi_dung_dang_nhap != dang_boi) {
				parent.websocket.send(JSON.stringify(msg));
			}
			
		});
			
			
		</script>
		<?php
	
	// $thoi_gian_hien_tai = date("Y-m-d H:i:s");
	// $query = mysqli_query($con, "INSERT INTO BinhLuan VALUES ('','$noi_dung_binh_luan', '$ten_tai_khoan', '$binh_luan_toi', '$thoi_gian_hien_tai', '0', '$id_bai_viet')");
	// array_push($error_array, "<p> Bình luận thành công </p>");
	
}



 

 ?>