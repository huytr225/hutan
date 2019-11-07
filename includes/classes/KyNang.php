<?php
class KyNang {
	private $ten_ky_nang;
	private $mo_ta;
	private $an;
	
	public function __construct($con, $ky_nang){
		$this->con = $con;
		$this->id = empty($ky_nang['id']) ? '' : $ky_nang['id'];
		$this->ten_ky_nang = empty($ky_nang['ten_ky_nang']) ? '' : $ky_nang['ten_ky_nang'];
		$this->mo_ta = empty($ky_nang['mo_ta']) ? '' : $ky_nang['mo_ta'];
		$this->an = $ky_nang['an'];
	}

	public static function xoaKyNang($con, $ho_so_id)
	{

		$query = "DELETE FROM KyNang WHERE ho_so_id='$ho_so_id'";
		$result = mysqli_query($con, $query);
	}


	public function themKyNang($ho_so_id)
	{
		$query = "INSERT INTO KyNang VALUES (NULL, '$ho_so_id', '$this->ten_ky_nang', '$this->mo_ta', '$this->an')";
		$result = mysqli_query($this->con, $query);
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTenKyNang()
	{
		return $this->ten_ky_nang;
	}

	public function getMoTa()
	{
		return $this->mo_ta;
	}

	public function getAn()
	{
		return $this->an;
	}
}

?>