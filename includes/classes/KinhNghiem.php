<?php
class KinhNghiem {
	private $ten_cong_ty;
	private $vi_tri;
	private $ngay_bat_dau;
	private $ngay_hoan_thanh;
	private $mo_ta;
	private $an;
	
	public function __construct($con, $kinh_nghiem){
		$this->con = $con;
		$this->ten_cong_ty = empty($kinh_nghiem['ten_cong_ty']) ? '' : $kinh_nghiem['ten_cong_ty'];
		$this->vi_tri = empty($kinh_nghiem['vi_tri']) ? '' : $kinh_nghiem['vi_tri'];
		$this->ngay_bat_dau = empty($kinh_nghiem['ngay_bat_dau']) ? '' : $kinh_nghiem['ngay_bat_dau'];
		$this->ngay_hoan_thanh = empty($kinh_nghiem['ngay_hoan_thanh']) ? '' : $kinh_nghiem['ngay_hoan_thanh'];
		$this->mo_ta = empty($kinh_nghiem['mo_ta']) ? '' : $kinh_nghiem['mo_ta'];
		$this->an = $kinh_nghiem['an'];
	}

	public static function xoaKinhNghiem($con, $ho_so_id)
	{

		$query = "DELETE FROM KinhNghiem WHERE ho_so_id='$ho_so_id'";
		$result = mysqli_query($con, $query);
	}

	public function themKinhNghiem($ho_so_id)
	{
		$query = "INSERT INTO KinhNghiem VALUES (NULL, '$ho_so_id', '$this->ten_cong_ty', '$this->vi_tri', '$this->ngay_bat_dau', '$this->ngay_hoan_thanh', '$this->mo_ta', '$this->an')";
		$result = mysqli_query($this->con, $query);
		$this->id = mysqli_insert_id($this->con);
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTenCongTy()
	{
		return $this->ten_cong_ty;
	}

	public function getViTri()
	{
		return $this->vi_tri;
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