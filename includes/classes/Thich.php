<?php 
class Thich {
	private $con;
	private $ten_tai_khoan;
	private $id_bai_viet;
	

	public function __construct($con){
		$this->con = $con;
	}

	public function thichBaiViet($ten_tai_khoan, $id_bai_viet)
	{
		$get_likes = mysqli_query($this->con, "SELECT so_luot_thich, dang_boi FROM BaiViet WHERE id='$id_bai_viet'");
		$row = mysqli_fetch_array($get_likes);
		$so_luot_thich = $row['so_luot_thich'];
		$nguoi_duoc_thich = $row['dang_boi'];

		$query = mysqli_query($this->con, "SELECT * FROM NguoiDung WHERE ten_tai_khoan = '$nguoi_duoc_thich'");
		$row = mysqli_fetch_array($query);
		$so_luot_thich_nguoi_dung = $row['so_luot_thich'];
		$so_luot_thich++;
		$query = mysqli_query($this->con, "UPDATE BaiViet SET so_luot_thich='$so_luot_thich' WHERE id='$id_bai_viet'");
		$so_luot_thich_nguoi_dung++;
		$query = mysqli_query($this->con, "UPDATE NguoiDung SET so_luot_thich='$so_luot_thich_nguoi_dung' WHERE ten_tai_khoan='$nguoi_duoc_thich'");
		$query = mysqli_query($this->con, "INSERT INTO Thich VALUES (NULL,'$ten_tai_khoan','$id_bai_viet')");
	
		//Thong Bao
		if ($nguoi_duoc_thich != $ten_tai_khoan) {
			$thong_bao = new ThongBao($this->con, $nguoi_duoc_thich);
			$thong_bao->themThongBao($id_bai_viet, $ten_tai_khoan, 'thich');
		}		
	}

	public function huyThichBaiViet($ten_tai_khoan, $id_bai_viet)
	{
		$get_likes = mysqli_query($this->con, "SELECT so_luot_thich, dang_boi FROM BaiViet WHERE id='$id_bai_viet'");
		$row = mysqli_fetch_array($get_likes);
		$so_luot_thich = $row['so_luot_thich'];
		$nguoi_duoc_thich = $row['dang_boi'];
		$so_luot_thich_nguoi_dung = $row['so_luot_thich'];
		$so_luot_thich--;
		$query = mysqli_query($this->con, "UPDATE BaiViet SET so_luot_thich='$so_luot_thich' WHERE id='$id_bai_viet'");
		$so_luot_thich_nguoi_dung--;
		$query = mysqli_query($this->con, "UPDATE NguoiDung SET so_luot_thich='$so_luot_thich_nguoi_dung' WHERE ten_tai_khoan='$nguoi_duoc_thich'");
		$query = mysqli_query($this->con, "DELETE FROM Thich WHERE ten_tai_khoan='$ten_tai_khoan' AND id_bai_viet='$id_bai_viet'");
		if ($nguoi_duoc_thich != $ten_tai_khoan) {
			$thong_bao = new ThongBao($this->con, $nguoi_duoc_thich);
			$thong_bao->xoaThongBao($id_bai_viet, $ten_tai_khoan, 'thich');
		}	

	}

	public function daThich($ten_tai_khoan, $id_bai_viet)
	{
		$query = mysqli_query($this->con, "SELECT * FROM Thich WHERE ten_tai_khoan='$ten_tai_khoan' AND id_bai_viet='$id_bai_viet'");
		$num_row = mysqli_num_rows($query);
		if ($num_row>0) {
			return true;
		} else {
			return false;
		}
	}

	


}
	
 ?>