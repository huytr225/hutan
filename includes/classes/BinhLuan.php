<?php 
class BinhLuan {
	private $con;
	private $noi_dung;
	private $binh_luan_boi;
	private $binh_luan_toi;
	private $ngay_dang;
	private $da_xoa;
	private $so_luot_thich;
	

	public function __construct($con){
		$this->con = $con;
	}

	public function dangBinhLuan($noi_dung, $binh_luan_boi, $id_bai_viet)
	{
		$error_array = array();
		$query = mysqli_query($this->con, "SELECT dang_boi, dang_toi FROM BaiViet WHERE id='$id_bai_viet'");
		$row = mysqli_fetch_array($query);
		$binh_luan_toi = $row['dang_boi'];
		$nguoi_dung = new NguoiDung($this->con, $binh_luan_boi);

		$this->noi_dung = $noi_dung;
		$this->binh_luan_boi = $binh_luan_boi;
		$this->ngay_dang = date("Y-m-d H:i:s");
		$this->da_xoa = 0;
		$this->so_luot_thich = 0;
		$this->binh_luan_toi = $binh_luan_toi;

		//insert bai viet
		$query = "INSERT INTO BinhLuan VALUES (NULL, '$noi_dung', '$binh_luan_boi', '$binh_luan_toi', '$this->ngay_dang', '0', '$id_bai_viet')";
		$result = mysqli_query($this->con, $query);
		
		// $this->id = mysqli_insert_id($this->con);

		//ThongBao

		if ($binh_luan_boi != $binh_luan_toi) {
			$thong_bao = new ThongBao($this->con, $binh_luan_toi);
			$thong_bao->themThongBao($id_bai_viet, $binh_luan_boi, 'binh_luan');
		}	
	}
	
	public function taiBinhLuan($id_bai_viet)
	{
		$query = mysqli_query($this->con, "SELECT * FROM BinhLuan WHERE id_bai_viet='$id_bai_viet' ORDER BY id DESC" );
		 $count = mysqli_num_rows($query);

		if ($count != 0) {
			while ($binh_luan = mysqli_fetch_array($query)) {
		 		$noi_dung = $binh_luan['noi_dung'];
		 		$binh_luan_toi = $binh_luan['binh_luan_toi'];
		 		$binh_luan_boi = $binh_luan['binh_luan_boi'];
		 		$ngay_binh_luan = $binh_luan['ngay_binh_luan'];
		 		$da_xoa = $binh_luan['da_xoa'];


		 		$thoi_gian_hien_tai = date("Y-m-d H:i:s");
				$ngay_bat_dau = new DateTime($ngay_binh_luan);
				$ngay_hien_tai = new DateTime($thoi_gian_hien_tai);
				$interval = $ngay_bat_dau->diff($ngay_hien_tai);

				if ($interval->y >= 1) {
					$thoi_gian = $interval->y . " năm trước";
				} else if ($interval->m >= 1){
					$thoi_gian = $interval->m . " tháng trước";
				} else if ($interval->d >= 1){
					if($interval->d == 1){
						$thoi_gian = "Hôm qua";
					} else {
						$thoi_gian = $interval->d . " ngày trước";
					} 
				} else if ($interval->h >= 1){
					$thoi_gian = $interval->h . " giờ trước";
				} else if ($interval->i >= 1){
					$thoi_gian = $interval->i . " phút trước";
				} else {
					if($interval->s < 40){
						$thoi_gian = "Vừa xong";
					} else {
						$thoi_gian = $interval->s . " giây trước";
					}
				}

				$nguoi_binh_luan = new NguoiDung($this->con, $binh_luan_boi);
				?>
				<div class="comment_section">
					<a href="<?php echo($binh_luan_boi) ?>" target="_top"><img src="<?php echo($nguoi_binh_luan->getAnhDaiDien()); ?>" title="<?php echo($binh_luan_boi) ?>" style="float: left" height="30"></a>
					<a href="<?php echo($binh_luan_boi); ?>" target="_top"><b><?php echo $nguoi_binh_luan->getHoTen(); ?></b></a> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $thoi_gian . "<br>" . $noi_dung;  ?>


				</div>
				<?php

			}
		} else {
	 		echo "<center><br><br>Không có comment nào!</center>";
		}
	}



}
	
 ?>