<?php 
class TinNhan {
	private $con;
	private $gui_tu;
	private $gui_toi;
	private $noi_dung;
	private $ngay_gui;
	private $da_xem;
	private $da_xoa;

	public function __construct($con, $gui_tu){
		$this->con = $con;
		$this->gui_tu = $gui_tu;

	}

	public function getNguoiDungGanNhat()
	{
		$nguoi_dung_dang_nhap = new NguoiDung($this->con, $this->gui_tu);
		$ten_tai_khoan = $this->gui_tu;
		$query = mysqli_query($this->con, "SELECT * FROM TinNhan WHERE (gui_tu ='$ten_tai_khoan') OR (gui_toi='$ten_tai_khoan') ORDER BY id DESC LIMIT 1");
		if (mysqli_num_rows($query) == 0) {
			return false;
		} else {
			$row = mysqli_fetch_array($query);
			$gui_tu = $row['gui_tu'];
			$gui_toi = $row['gui_toi'];
			if ($nguoi_dung_dang_nhap->getTenTaiKhoan() != $gui_tu) {
				return $gui_tu;
			} else {
				return $gui_toi;
			}
		}

	}

	public function getTinNhanGanNhat($nguoi_dung_dang_nhap, $nguoi_dung2)
	{
		$return_array = array();
		$query = mysqli_query($this->con, "SELECT noi_dung, gui_toi, ngay_gui FROM TinNhan WHERE (gui_toi='$nguoi_dung_dang_nhap' AND gui_tu='$nguoi_dung2') OR (gui_toi='$nguoi_dung2' AND gui_tu='$nguoi_dung_dang_nhap') ORDER BY id DESC LIMIT 1");
		$row = mysqli_fetch_array($query);
		$gui_boi = ($row['gui_toi'] == $nguoi_dung_dang_nhap) ? "Họ: " : "Bạn: ";
		$thoi_gian_hien_tai = date("Y-m-d H:i:s");
		$ngay_bat_dau = new DateTime($row['ngay_gui']);
		$ngay_hien_tai = new DateTime($thoi_gian_hien_tai);
		$interval = $ngay_bat_dau->diff($ngay_hien_tai);

		if ($interval->y >= 1) {
			$thoi_gian = $interval->t . " năm trước";
		} else if ($interval->m >= 1){
			$thoi_gian = $interval->t . " tháng trước";
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
		array_push($return_array, $gui_boi);
		array_push($return_array, $row['noi_dung']);
		array_push($return_array, $thoi_gian);

		return $return_array;
	}

	public function guiTinNhan($gui_toi, $noi_dung)
	{
		$ngay_gui = date("Y-m-d H:i:s");
		$gui_tu = $this->gui_tu;
		$query = mysqli_query($this->con, "INSERT INTO TinNhan VALUES (NULL, '$gui_tu', '$gui_toi', '$noi_dung', '$ngay_gui','0', '0')");

	}
	
	public function taiTinNhan($nguoi_dung)
	{
		$nguoi_dung_dang_nhap = $this->gui_tu;
		$str = '';
		$this->setDaXem($nguoi_dung);

		$query = mysqli_query($this->con, "SELECT * FROM TinNhan WHERE (gui_tu='$nguoi_dung_dang_nhap' AND gui_toi= '$nguoi_dung') OR (gui_tu='$nguoi_dung' AND gui_toi= '$nguoi_dung_dang_nhap')");

		while ($row = mysqli_fetch_array($query)) {
			$gui_tu = $row['gui_tu'];
			$gui_toi = $row['gui_toi'];
			$noi_dung = $row['noi_dung'];
			if ($gui_tu != $nguoi_dung_dang_nhap) {
				$nguoi_dung_obj = new NguoiDung($this->con, $nguoi_dung);
				$anh_dai_dien = $nguoi_dung_obj->getAnhDaiDien();
				$anh = "<div class='mes'><div class='mes_profile_pic' id='left'>
							<a href='$nguoi_dung'>
							<img src='$anh_dai_dien' width='50'>
							</a>
						</div>";
			} else {
				$nguoi_dung_dang_nhap_obj = new NguoiDung($this->con, $nguoi_dung_dang_nhap);
				$anh_dai_dien = $nguoi_dung_dang_nhap_obj->getAnhDaiDien();
				$anh = "<div class='mes'><div class='mes_profile_pic' id='right'>
							<a href='$nguoi_dung_dang_nhap'>
							<img src='$anh_dai_dien' width='50'>
							</a>
						</div>";
			}
			$mes = ($gui_tu != $nguoi_dung_dang_nhap) ? "<div class='message' id='green'>" : "<div class='message' id='blue'>";
			$str = $str . $anh . $mes . $noi_dung . "</div></div><br>";
		}
		echo($str);
	}

	public function taiHoiThoai()
	{
		$nguoi_dung_dang_nhap = $this->gui_tu;
		$str = '';
		$hoi_thoai = array();

		$query = mysqli_query($this->con, "SELECT * FROM TinNhan WHERE gui_tu='$nguoi_dung_dang_nhap' OR gui_toi='$nguoi_dung_dang_nhap' ORDER BY id DESC");

		while ($row = mysqli_fetch_array($query)) {
			$nguoi_dung = ($row['gui_tu'] != $nguoi_dung_dang_nhap) ? $row['gui_tu'] : $row['gui_toi'];

			if (!in_array($nguoi_dung, $hoi_thoai)) {
				array_push($hoi_thoai, $nguoi_dung);
			}
		}

		foreach ($hoi_thoai as $ten_tai_khoan) {
			$nguoi_dung = new NguoiDung($this->con, $ten_tai_khoan);
			$tin_nhan_chi_tiet = $this->getTinNhanGanNhat($nguoi_dung_dang_nhap, $ten_tai_khoan);


			$str .= "<a href='tin_nhan.php?u=$ten_tai_khoan'> <div class='user_found_messages'>
			<img src='" . $nguoi_dung->getAnhDaiDien() . "' style='border-radius: 5px; margin-right: 5px;'>"
			. $nguoi_dung->getHoTen() .
			"<span class='timestamp_smaller' id='grey'>&nbsp;" . $tin_nhan_chi_tiet[2]."</span><p id='grey' style='margin: 0;'>" . $tin_nhan_chi_tiet[0] . $tin_nhan_chi_tiet[1] ."
			</div>
			</a>
			";
		}
		echo($str);
	}

	public function setDaXem($nguoi_dung)
	{
		$nguoi_dung_dang_nhap = $this->gui_tu;
		$query = mysqli_query($this->con, "UPDATE TinNhan SET da_xem='1' WHERE gui_tu='$nguoi_dung' AND gui_toi= '$nguoi_dung_dang_nhap'");
	}

	public function getSoTinNhanChuaXem()
	{
		$nguoi_dung_dang_nhap = $this->gui_tu;
		$query = mysqli_query($this->con, "SELECT * FROM TinNhan WHERE da_xem='0' AND gui_toi='$nguoi_dung_dang_nhap'");
		return mysqli_num_rows($query);
	}

}
	
 ?>