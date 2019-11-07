<?php 
class NguoiDung {
	protected $ho;
	protected $ten;
	protected $ten_tai_khoan;
	protected $email;
	protected $ngay_dang_ki;
	protected $anh_dai_dien;
	protected $so_bai_viet;
	protected $so_luot_thich;
	protected $mang_ban_be;
	protected $con;

	public function __construct($con, $ten_tai_khoan){
		$sql = mysqli_query($con, "SELECT * FROM NguoiDung WHERE ten_tai_khoan = '$ten_tai_khoan'");
		$row = mysqli_fetch_array($sql);
		$this->con = $con;
		$this->ho = $row['ho'];
		$this->ten = $row['ten'];
		$this->ten_tai_khoan = $row['ten_tai_khoan'];
		$this->email = $row['email'];
		$this->ngay_dang_ki = $row['ngay_dang_ki'];
		$this->anh_dai_dien = $row['anh_dai_dien'];
		$this->so_bai_viet = $row['so_bai_viet'];
		$this->so_luot_thich = $row['so_luot_thich'];
		$this->mang_ban_be = $row['mang_ban_be'];
		
	}

	public function getTenTaiKhoan()
	{
		return $this->ten_tai_khoan;
	}

	public function getHoTen()
	{
		return $this->ho . " " . $this->ten;
	}

	public function getHo()
	{
		return $this->ho;
	}

	public function getTen()
	{
		return $this->ten;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getAnhDaiDien()
	{
		return $this->anh_dai_dien;
	}


	public function getSoBaiViet()
	{
		return $this->so_bai_viet;
	}

	public function getSoLuotThich()
	{
		return $this->so_luot_thich;
	}

	public function getSoBanBe()
	{
		return sizeof($this->getMangBanBe());
	}

	public function getMangBanBeStr()
	{
		return $this->mang_ban_be;
	}

	public function getMangBanBe()
	{

		$mang_ban_be = explode(',',$this->mang_ban_be);
		array_pop($mang_ban_be);
		array_shift($mang_ban_be);

		return $mang_ban_be;
	}

	public function getSoBanChung($nguoi_dung_khac)
	{
		$mang_ban_chung = $this->getMangBanChung($nguoi_dung_khac);

		return sizeof($mang_ban_chung);
	}

	public function getMangBanChung($nguoi_dung_khac)
	{
		$ban_nguoi_dung_khac = $nguoi_dung_khac->getMangBanBe();
		$ban_nguoi_dung = $this->mang_ban_be;

		$mang_ban_chung = array_intersect($ban_nguoi_dung_khac, $ban_nguoi_dung);

		return $mang_ban_chung;
	}

	public function laBanBe($nguoi_dung)
	{
		$mang_ban_be = $this->getMangBanBe();
		array_push($mang_ban_be,$this->ten_tai_khoan);
		if (in_array($nguoi_dung->getTenTaiKhoan(), $mang_ban_be)) {
			return true;
		}
		return false;
	}

	public function daNhanLoiMoi($gui_tu)
	{
		$gui_tu = $gui_tu->getTenTaiKhoan();
		$gui_toi = $this->ten_tai_khoan;
		$query = mysqli_query($this->con, "SELECT * FROM LoiMoiKetBan WHERE gui_tu='$gui_tu' AND gui_toi='$gui_toi'");
		if (mysqli_num_rows($query)>0) {
			return true;
		} else {
			return false;
		}
	}

	public function daGuiLoiMoi($gui_toi)
	{
		$gui_toi = $gui_toi->getTenTaiKhoan();
		$gui_tu = $this->ten_tai_khoan;
		$query = mysqli_query($this->con, "SELECT * FROM LoiMoiKetBan WHERE gui_tu='$gui_tu' AND gui_toi='$gui_toi'");
		if (mysqli_num_rows($query)>0) {
			return true;
		} else {
			return false;
		}
	}

	public function huyKetBan($nguoi_dung) {
		$mang_ban_be_moi = str_replace($nguoi_dung->getTenTaiKhoan() . ",", "", $this->mang_ban_be);
		$ten_tai_khoan = $this->ten_tai_khoan;
		$query = mysqli_query($this->con, "UPDATE NguoiDung SET mang_ban_be='$mang_ban_be_moi' WHERE ten_tai_khoan='$ten_tai_khoan'");

		$mang_ban_be_moi = str_replace($this->ten_tai_khoan . ",", "", $nguoi_dung->getMangBanBeStr());
		$ten_tai_khoan = $nguoi_dung->getTenTaiKhoan();
		$query = mysqli_query($this->con, "UPDATE NguoiDung SET mang_ban_be='$mang_ban_be_moi' WHERE  ten_tai_khoan='$ten_tai_khoan'");

		header("Location: ho_so.php?ten_tai_khoan_ho_so=" . $ten_tai_khoan );
	}


	public function guiLoiMoi($gui_toi) {
		$gui_toi = $gui_toi->getTenTaiKhoan();
		$gui_tu = $this->ten_tai_khoan;
		$query = mysqli_query($this->con, "INSERT INTO LoiMoiKetBan VALUES(NULL, '$gui_tu', '$gui_toi')");
	}

	public function chapNhanLoiMoi($gui_tu)
	{
		// $gui_tu = $gui_tu->getTenTaiKhoan();
		$nguoi_dung = $this->ten_tai_khoan;
		// $mang_ban_be_moi = $this->getMangBanBeStr() . $gui_tu . ',';
		// $ket_ban_query = mysqli_query($this->con, "UPDATE NguoiDung SET mang_ban_be='$mang_ban_be_moi' WHERE ten_tai_khoan='$nguoi_dung'");
		$ket_ban_query = mysqli_query($this->con, "UPDATE NguoiDung SET mang_ban_be=CONCAT(mang_ban_be, '$gui_tu,') WHERE ten_tai_khoan='$nguoi_dung'");
		$ket_ban_query = mysqli_query($this->con, "UPDATE NguoiDung SET mang_ban_be=CONCAT(mang_ban_be, '$nguoi_dung,') WHERE ten_tai_khoan='$gui_tu'");
		
		$query = mysqli_query($this->con, "DELETE FROM LoiMoiKetBan WHERE gui_tu='$gui_tu' AND gui_toi='$nguoi_dung'");

		echo "Bạn và <a href='$gui_tu'>$gui_tu</a> đã là bạn bè!";
	}

	public function tuChoiLoiMoi($gui_tu)
	{
		// $gui_tu = $gui_tu->getTenTaiKhoan();
		$nguoi_dung = $this->ten_tai_khoan;
		$query = mysqli_query($this->con, "DELETE FROM LoiMoiKetBan WHERE gui_tu='$gui_tu' AND gui_toi='$nguoi_dung'");
		echo "Từ chối thành công!";
	}

	public function getSoLoiMoi()
	{
		$gui_toi = $this->ten_tai_khoan;
		$query = mysqli_query($this->con, "SELECT * FROM LoiMoiKetBan WHERE gui_toi='$gui_toi'");
		return mysqli_num_rows($query);
	}

	public function getMangHoSo()
	{
		$query = mysqli_query($this->con, "SELECT id FROM HoSo WHERE ten_tai_khoan='$this->ten_tai_khoan' AND da_xoa = 0");
		$mang_ho_so = array();
		while ($row = mysqli_fetch_array($query)) {
			$ho_so = new HoSo($this->con, $this->ten_tai_khoan);
			$ho_so->setId($row['id']);
			array_push($mang_ho_so, $ho_so);
		}
		return $mang_ho_so;
	}

	public function getHoSo($nguoi_dung)
	{
		$ten_tai_khoan = $nguoi_dung->getTenTaiKhoan();
		$query = mysqli_query($this->con, "SELECT id FROM HoSo WHERE ten_tai_khoan='$ten_tai_khoan' AND ho_so_chinh = 1");
		$row = mysqli_fetch_array($query);
		$ho_so = new HoSo($this->con, $ten_tai_khoan);
		$ho_so->setIdAn($row['id']);
		return $ho_so;
	}

	public function timKiem($query, $type)
	{
		
	}





}
	
 ?>