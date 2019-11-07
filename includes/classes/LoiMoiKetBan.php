<?php 
class LoiMoiKetBan {
	private $con;
	private $gui_tu;
	private $gui_toi;

	public function __construct($con){
		$this->con = $con;
	}
	
	public function taiLoiMoi($trang, $nguoi_dung_dang_nhap, $limit)
	{
		$start = ($trang - 1) * $limit;
		$str = "";
		$sql = "SELECT * FROM LoiMoiKetBan WHERE gui_toi='$nguoi_dung_dang_nhap' ORDER BY id DESC";
		$query = mysqli_query($this->con, $sql);

		if (mysqli_num_rows($query) > 0) {
			$count = 0;
			$so_bai_load = 1;

			while ($row = mysqli_fetch_array($query)) {
				$id = $row['id'];
				$gui_tu = $row['gui_tu'];
				$gui_tu_obj = new NguoiDung($this->con, $gui_tu);
				$anh_dai_dien = $gui_tu_obj->getAnhDaiDien();
				$ho_ten = $gui_tu_obj->getHoTen();
				if($count < $start){
					$count++;
					continue;
				}

				if($so_bai_load > $limit){
					break;
				} else {
					$so_bai_load++;
				}

				$str .= "
				<div class='status_post'>
					<div class='post_profile_pic'>
						<a href='$gui_tu'>
						<img src='$anh_dai_dien' width='80'>
						
						$ho_ten
						</a>
					</div>
					<form action='loi_moi_ket_ban.php' id='friend_form' method='POST'>
						<input type='submit' name='dong_y' class='btn btn-info btn-sm' id='accept_button' value='Đồng Ý'>
						<input type='submit' name='tu_choi' class='btn btn-secondary btn-sm' id='ignore_button' value='Xoá'>
						<input type='hidden' name='gui_tu' value='$gui_tu'>
						<input type='hidden' name='gui_toi' value='$nguoi_dung_dang_nhap'>
					</form>
				</div>
				<hr>
				";
			}

			if ($so_bai_load > $limit) {
				$str .= "<input type='hidden' class='nextPage' value ='" . ($trang +1) ."'>
						 <input type='hidden' class='noMorePosts' value='false'>";
			} else {
				$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align:center;'> Không còn lời mời nào nữa! </p>";
			}
		} else {
			$str .= "Bạn không có lời mời kết bạn nào!";
		}

		echo $str;

	}

	


}
	
 ?>