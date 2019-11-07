<?php
class HoSo {
	private $con;
	private $id;
	private $ten_ho_so;
	private $dia_chi;
	private $sdt;
	private $ngay_sinh;
	private $ten_tai_khoan;
	private $thoi_gian;
	private $ho_so_chinh;
	private $mang_ky_nang;
	private $mang_hoc_van;
	private $mang_kinh_nghiem;
	private $an;
	
	public function __construct($con, $ten_tai_khoan){
		$this->con = $con;
		$this->ten_tai_khoan = $ten_tai_khoan;
		$this->mang_kinh_nghiem = array();
		$this->mang_hoc_van = array();
		$this->mang_ky_nang = array();
	}

	public function setIdAn($id)
	{
		$this->id = $id;
		$query = mysqli_query($this->con, "SELECT * FROM HoSo WHERE id='$id'");
		$row = mysqli_fetch_array($query);
		$this->ten_ho_so = $row['ten_ho_so'];
		$this->dia_chi = $row['dia_chi'];
		$this->sdt = $row['sdt'];
		$this->ngay_sinh = $row['ngay_sinh'];
		$this->thoi_gian = $row['thoi_gian'];
		$this->ho_so_chinh = $row['ho_so_chinh'];
		$this->mang_kinh_nghiem = array();
		$this->mang_hoc_van = array();
		$this->mang_ky_nang = array();

		$query = mysqli_query($this->con, "SELECT * FROM KinhNghiem WHERE ho_so_id='$id'");
		while ($row = mysqli_fetch_array($query)) {
			$kinh_nghiem = new KinhNghiem($this->con, $row);
			if ($kinh_nghiem->getAn() == '0')
				array_push($this->mang_kinh_nghiem, $kinh_nghiem);
		}

		$query = mysqli_query($this->con, "SELECT * FROM HocVan WHERE ho_so_id='$id'");
		while ($row = mysqli_fetch_array($query)) {
			$hoc_van = new HocVan($this->con, $row);
			if ($hoc_van->getAn() == '0')
				array_push($this->mang_hoc_van, $hoc_van);
			
		}

		$query = mysqli_query($this->con, "SELECT * FROM KyNang WHERE ho_so_id='$id'");
		while ($row = mysqli_fetch_array($query)) {
			$ky_nang = new KyNang($this->con, $row);
			if ($ky_nang->getAn() == '0')
				array_push($this->mang_ky_nang, $ky_nang);
		}
	}

	public function setId($id)
	{
		$this->id = $id;
		$query = mysqli_query($this->con, "SELECT * FROM HoSo WHERE id='$id'");
		$row = mysqli_fetch_array($query);
		$this->ten_ho_so = $row['ten_ho_so'];
		$this->dia_chi = $row['dia_chi'];
		$this->sdt = $row['sdt'];
		$this->ngay_sinh = $row['ngay_sinh'];
		$this->thoi_gian = $row['thoi_gian'];
		$this->ho_so_chinh = $row['ho_so_chinh'];
		$this->mang_kinh_nghiem = array();
		$this->mang_hoc_van = array();
		$this->mang_ky_nang = array();

		$query = mysqli_query($this->con, "SELECT * FROM KinhNghiem WHERE ho_so_id='$id'");
		while ($row = mysqli_fetch_array($query)) {
			$kinh_nghiem = new KinhNghiem($this->con, $row);
			array_push($this->mang_kinh_nghiem, $kinh_nghiem);
		}

		$query = mysqli_query($this->con, "SELECT * FROM HocVan WHERE ho_so_id='$id'");
		while ($row = mysqli_fetch_array($query)) {
			$hoc_van = new HocVan($this->con, $row);
			array_push($this->mang_hoc_van, $hoc_van);
			
		}

		$query = mysqli_query($this->con, "SELECT * FROM KyNang WHERE ho_so_id='$id'");
		while ($row = mysqli_fetch_array($query)) {
			$ky_nang = new KyNang($this->con, $row);
			array_push($this->mang_ky_nang, $ky_nang);
		}
	}

	public function getTenHoSo()
	{
		return $this->ten_ho_so;
	}

	public function getDiaChi()
	{
		return $this->dia_chi;
	}

	public function getSDT()
	{
		return $this->sdt;
	}

	public function getNgaySinh()
	{
		return $this->ngay_sinh;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getHoSoChinh()
	{
		return $this->ho_so_chinh;
	}

	public function getMangKinhNghiem()
	{
		return $this->mang_kinh_nghiem;
	}

	public function getMangHocVan()
	{
		return $this->mang_hoc_van;
	}

	public function getMangKyNang()
	{
		return $this->mang_ky_nang;
	}

	public function taiHoSo()
	{
		
	}

	public function themHoSo($thong_tin_ho_so, $thong_tin_ca_nhan)
	{
		$this->thoi_gian = date("Y-m-d H:i:s");
		$this->ten_ho_so = $thong_tin_ho_so['ten_ho_so'];
		$this->dia_chi = $thong_tin_ca_nhan['dia_chi'];
		$this->sdt = $thong_tin_ca_nhan['sdt'];
		$this->ngay_sinh = $thong_tin_ca_nhan['ngay_sinh'];
		$this->thoi_gian = date("Y-m-d H:i:s");
		$this->ho_so_chinh = 0;
		$this->an = $thong_tin_ca_nhan['an'];

		$query = "INSERT INTO HoSo VALUES (NULL, '$this->ten_ho_so', '$this->ten_tai_khoan', '$this->dia_chi', '$this->sdt', '$this->ngay_sinh', '$this->thoi_gian', '0', '$this->an', '0')";
		$result = mysqli_query($this->con, $query);
		$this->id = mysqli_insert_id($this->con);

		if (!empty($thong_tin_ho_so['kinh_nghiem'])) {
			foreach ($thong_tin_ho_so['kinh_nghiem'] as $kn) {
				$kinh_nghiem = new KinhNghiem($this->con, $kn);
				$kinh_nghiem->themKinhNghiem($this->id);
				array_push($mang_kinh_nghiem, $kinh_nghiem);
			}
		}
		

		if (!empty($thong_tin_ho_so['hoc_van'])) {
			foreach ($thong_tin_ho_so['hoc_van'] as $hv) {
				$hoc_van = new HocVan($this->con, $hv);
				$hoc_van->themHocVan($this->id);
				array_push($mang_hoc_van, $hoc_van);
			}
		}

		

		if (!empty($thong_tin_ho_so['ky_nang'])) {
			foreach ($thong_tin_ho_so['ky_nang'] as $knang) {
				$ky_nang = new KyNang($this->con, $knang);
				$ky_nang->themKyNang($this->id);
				array_push($mang_ky_nang, $ky_nang);
			}
		}

		
	}

	public function capNhatHoSo($id, $thong_tin_ho_so, $thong_tin_ca_nhan)
	{
		$this->id = $id;
		$this->thoi_gian = date("Y-m-d H:i:s");
		$this->ten_ho_so = $thong_tin_ho_so['ten_ho_so'];
		$this->dia_chi = $thong_tin_ca_nhan['dia_chi'];
		$this->sdt = $thong_tin_ca_nhan['sdt'];
		$this->ngay_sinh = $thong_tin_ca_nhan['ngay_sinh'];
		$this->thoi_gian = date("Y-m-d H:i:s");
		$this->an = $thong_tin_ca_nhan['an'];

		$query = "UPDATE HoSo SET ten_ho_so='$this->ten_ho_so', ten_tai_khoan='$this->ten_tai_khoan', dia_chi='$this->dia_chi', sdt='$this->sdt', ngay_sinh='$this->ngay_sinh', an='$this->an' WHERE id='$this->id'";
		$result = mysqli_query($this->con, $query);

		KinhNghiem::xoaKinhNghiem($this->con, $this->id);
		HocVan::xoaHocVan($this->con, $this->id);
		KyNang::xoaKyNang($this->con, $this->id);

		if (!empty($thong_tin_ho_so['kinh_nghiem'])) {
			foreach ($thong_tin_ho_so['kinh_nghiem'] as $kn) {
				$kinh_nghiem = new KinhNghiem($this->con, $kn);
				$kinh_nghiem->themKinhNghiem($this->id);
			}
		}
		

		if (!empty($thong_tin_ho_so['hoc_van'])) {
			foreach ($thong_tin_ho_so['hoc_van'] as $hv) {
				$hoc_van = new HocVan($this->con, $hv);
				$hoc_van->themHocVan($this->id);
				
			}
		}

		

		if (!empty($thong_tin_ho_so['ky_nang'])) {
			foreach ($thong_tin_ho_so['ky_nang'] as $knang) {
				$ky_nang = new KyNang($this->con, $knang);
				$ky_nang->themKyNang($this->id);
			}
		}
	}

	public function xoaHoSo()
	{
		$query = mysqli_query($this->con, "UPDATE HoSo SET da_xoa = 1 WHERE id = '$this->id");
	}

	public function setHoSoChinh()
	{
		$query = mysqli_query($this->con, "UPDATE HoSo SET ho_so_chinh = 0 WHERE ho_so_chinh=1");
		$query = mysqli_query($this->con, "UPDATE HoSo SET ho_so_chinh = 1 WHERE id='$this->id'");	

	}
}

?>