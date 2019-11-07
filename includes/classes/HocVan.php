<?php
class HocVan {
	private $ten_truong;
	private $chuyen_nganh;
	private $ngay_bat_dau;
	private $ngay_hoan_thanh;
	private $mo_ta;
	private $an;
	
	public function __construct($con, $hoc_van){
		$this->con = $con;
		$this->ten_truong = empty($hoc_van['ten_truong']) ? '' : $hoc_van['ten_truong'];
		$this->chuyen_nganh = empty($hoc_van['chuyen_nganh']) ? '' : $hoc_van['chuyen_nganh'];
		$this->ngay_bat_dau = empty($hoc_van['ngay_bat_dau']) ? '' : $hoc_van['ngay_bat_dau'];
		$this->ngay_hoan_thanh = empty($hoc_van['ngay_hoan_thanh']) ? '' : $hoc_van['ngay_hoan_thanh'];
		$this->mo_ta = empty($hoc_van['mo_ta']) ? '' : $hoc_van['mo_ta'];
		$this->an = $hoc_van['an'];
		
	}

	public static function xoaHocVan($con, $ho_so_id)
	{
		$query = "DELETE FROM HocVan WHERE ho_so_id='$ho_so_id'";
		$result = mysqli_query($con, $query);

	}

	public function themHocVan($ho_so_id)
	{
		$query = "INSERT INTO HocVan VALUES (NULL, '$ho_so_id', '$this->ten_truong', '$this->chuyen_nganh', '$this->ngay_bat_dau', '$this->ngay_hoan_thanh', '$this->mo_ta', '$this->an')";
		$result = mysqli_query($this->con, $query);
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTenTruong()
	{
		return $this->ten_truong;
	}

	public function getChuyenNganh()
	{
		return $this->chuyen_nganh;
	}

	public function getNgayBatDau()
	{
		return $this->ngay_bat_dau;
	}

	public function getNgayHoanThanh()
	{
		return $this->ngay_hoan_thanh;
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