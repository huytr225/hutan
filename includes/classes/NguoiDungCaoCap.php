<?php 

/**
 * 
 */
class NguoiDungCaoCap extends NguoiDung
{

	// public function __construct($con, $ten_tai_khoan)
	// {
	// 	// $cao_cap = true;
	// 	$this->con = $con;
	// }
	

	public function getHoSo($nguoi_dung)
	{
		$ten_tai_khoan = $nguoi_dung->getTenTaiKhoan();
		$query = mysqli_query($this->con, "SELECT id FROM HoSo WHERE ten_tai_khoan='$ten_tai_khoan' AND ho_so_chinh = 1");
		$row = mysqli_fetch_array($query);
		$ho_so = new HoSo($this->con, $ten_tai_khoan);
		$ho_so->setId($row['id']);
		return $ho_so;
	}

	// public function getCaoCap()
	// {
	// 	return $cao_cap;
	// }
}

 ?>