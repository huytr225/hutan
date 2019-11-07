<?php
class ThongBao {
	private $con;
	private $gui_tu;
	private $gui_toi;
	private $noi_dung;
	private $link;
	private $thoi_gian;
	
	public function __construct($con, $nguoi_dung_dang_nhap){
		$this->con = $con;
		$this->gui_toi = $nguoi_dung_dang_nhap;
	}

	public function getSoThongBao()
	{
		$query = mysqli_query($this->con, "SELECT * FROM ThongBao WHERE da_xem='0' AND gui_toi='$this->gui_toi'");
		return mysqli_num_rows($query);
	}

	public function taiThongBao($trang, $nguoi_dung_dang_nhap, $limit)
	{
		$start = ($trang - 1) * $limit;
		// echo $start;
		$str = "";

		$sql = "UPDATE ThongBao SET da_xem = 1 WHERE gui_toi = '$nguoi_dung_dang_nhap'";
		$query = mysqli_query($this->con, $sql);

		$sql = "SELECT * FROM ThongBao WHERE gui_toi = '$nguoi_dung_dang_nhap' ORDER BY id DESC";
		$query = mysqli_query($this->con, $sql);

		if (mysqli_num_rows($query) == 0) {
			$str =  "Bạn không có thông báo nào!";
			echo ($str);
			return;
		}

		$count = 0;
		$so_bai_load = 1;

		while ($row = mysqli_fetch_array($query)) {
			if($count < $start){
				$count ++;
				continue;
			}


			if ($so_bai_load > $limit) {
				break;
			} else {
				$so_bai_load++;
			}

			$gui_tu = $row['gui_tu'];

			$gui_tu_obj = new NguoiDung($this->con, $gui_tu);
			$anh_dai_dien = $gui_tu_obj->getAnhDaiDien();
			$ho_ten = $gui_tu_obj->getHoTen();
		

			$thoi_gian_hien_tai = date("Y-m-d H:i:s");
			$ngay_bat_dau = new DateTime($row['thoi_gian']);
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

			$da_mo = $row['da_mo'];
			$style = ($da_mo == 'no') ? "background-color: #DDEDFF;" : "";

			$str .= "
			<a href=". $row['link'] .">
			<div class='status_post'>
					<div class='post_profile_pic'>
						<img src='$anh_dai_dien' width='80'>
					</div>
					<div>
					<b>
						$ho_ten
					</b>
					
					<span class='timestamp_smaller' id='grey'>&nbsp;" . $row['noi_dung'] ."</span><p id='grey' style='margin: 0;'>" . $thoi_gian ."
					</div>
					
			</div>
			</a>
				<hr>
			";
				

		} // While

		if ($so_bai_load > $limit) {
			$str .= "<input type='hidden' class='nextPage' value ='" . ($trang +1) ."'>
					 <input type='hidden' class='noMorePosts' value='false'>";
		} else {
			$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align:center;'> Không còn thông báo nào nữa! </p>";
		}

		echo ($str);

	}

	public function themThongBao($id_bai_viet, $gui_tu, $type)
	{
		$nguoi_dung_dang_nhap = new NguoiDung($this->con, $this->gui_toi);
		$ho_ten = $nguoi_dung_dang_nhap->getHoTen();

		$thoi_gian = date("Y-m-d H:i:s");
		$link = "bai_viet.php?id=" . $id_bai_viet;
		switch ($type) {
			case 'binh_luan':
				$noi_dung = "đã bình luận về bài viết của bạn";
				break;
			case 'thich':
				$noi_dung = "đã thích một bài viết của bạn";
				break;
			case 'binh_luan_khong_so_huu':
				$noi_dung = "đã bình luận về bài viết mà bạn bình luận";
				break;
			case 'dang_bai_viet_ho_so':
				$noi_dung = "đã đăng một bài viết lên trang cá nhân của bạn";
				break;
		}

		$query = mysqli_query($this->con, "INSERT INTO ThongBao VALUES(NULL, '$gui_tu', '$this->gui_toi', '$noi_dung', '$link', '$thoi_gian', '0','0')");

	}

	public function xoaThongBao($id_bai_viet, $gui_tu)
	{
		# code...
	}


}

?>