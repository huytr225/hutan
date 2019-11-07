<?php 

class BaiViet 
{
	private $con;
	private $id;
	private $noi_dung;
	private $dang_boi;
	private $dang_toi;
	private $ngay_dang;
	private $so_luot_thich;
	
	function __construct($con)
	{
		$this->con = $con;
	}

	public function setId($id)
	{
		$query = mysqli_query($this->con, "SELECT * FROM BaiViet WHERE id = '$id'");
		$row = mysqli_fetch_array($query);
		$this->noi_dung = $row['noi_dung'];
		$this->dang_boi = $row['dang_boi'];
		$this->dang_toi = $row['dang_toi'];
		$this->ngay_dang = $row['ngay_dang'];
		$this->da_xoa = $row['da_xoa'];
		$this->so_luot_thich = $row['so_luot_thich'];
	}
	public function getSoLuotThich()
	{
		return $this->so_luot_thich;
	}
	public function getDangBoi()
	{
		return $this->dang_boi;
	}
	public function getDangToi()
	{
		return $this->dang_toi;
	}

	public function getBaiViet($nguoi_dung_dang_nhap)
	{
		$nguoi_dung_dang_nhap_obj = new NguoiDung($this->con, $nguoi_dung_dang_nhap);
		$dang_toi_obj = new NguoiDung ($this->con, $this->dang_toi);
		$dang_boi_obj = new NguoiDung($this->con, $this->dang_boi);
		$anh_dai_dien = $dang_boi_obj->getAnhDaiDien();
		$ho_ten = $dang_boi_obj->getHoTen();
		$str = "";
		if ($this->da_xoa) {
			$str = "<p>Không có bài viết nào! Bài viết này có thể đã bị xoá hoặc không còn tồn tại.</p>";
		} else {
			if ($this->dang_toi == $this->dang_boi) {
				$dang_toi = "";
				$nut_xoa = "<button class='delete_button btn-danger' id='id$this->id'>X</button>";
			} else {
				$nut_xoa = "";
				$dang_toi_ten = $dang_toi_obj->getHoTen();
				$dang_toi = "<i class='fas fa-chevron-right'></i> <a href='" . $this->dang_toi . "'>" . $dang_toi_ten . "</a>";	
			}



			if ($nguoi_dung_dang_nhap_obj->laBanBe($dang_boi_obj)) {
				
				?>
				<script> 
					function toggle<?php echo $this->id; ?>() {

						var target = $(event.target);
						if (!target.is("a")) {
							var element = document.getElementById("toggleComment<?php echo $this->id; ?>");

							if(element.style.display == "block") 
								element.style.display = "none";
							else 
								element.style.display = "block";
						}
					}

				</script>

				<?php

				$binh_luan = mysqli_query($this->con, "SELECT * FROM BinhLuan WHERE id_bai_viet = '$this->id'");
				$so_binh_luan = mysqli_num_rows($binh_luan);

				$thoi_gian_hien_tai = date("Y-m-d H:i:s");
				$ngay_bat_dau = new DateTime($this->ngay_dang);
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

				$str .= "<div class='status_post' onClick='javascript:toggle$this->id()'>
							<div class='post_profile_pic'>
								<img src='$anh_dai_dien' width='50'>
							</div>

							<div class='posted_by' style='color:#ACACAC;'>
								<a href='$this->dang_boi'> $ho_ten </a> $dang_toi &nbsp;&nbsp;&nbsp;&nbsp;$thoi_gian
										$nut_xoa
							</div>
							<div id='post_body'>
								$this->noi_dung
								<br>
								<br>
								<br>
							</div>
							<div class='newsfeedPostOptions'>
								Bình luận($so_binh_luan)&nbsp;&nbsp;&nbsp;
								<iframe src='thich.php?id_bai_viet=$this->id' scrolling='no'></iframe>
								</div>

								
						</div>
						<div class='post_comment' id='toggleComment$this->id' style='display:block;'>
							<iframe src='binh_luan_bai_viet.php?id_bai_viet=$this->id' id='comment_iframe' style='border:none;'></iframe>
						</div>
						<hr>

				";
			} else {
				$str = "Bạn không thể xem bài viết này vì bạn không phải là bạn bè với <a href='". $dang_boi_obj->getTenTaiKhoan() ."'>" . $dang_boi_obj->getHoTen() . "</a>";
			}
		}

		echo $str;

	}

	public function dangBai($noi_dung, $dang_boi, $dang_toi)
	{
		$noi_dung = strip_tags($noi_dung);
		$noi_dung = mysqli_real_escape_string($this->con, $noi_dung);
		$nguoi_dung = new NguoiDung($this->con, $dang_boi);
		$this->noi_dung = $noi_dung;
		$this->dang_boi = $dang_boi;
		$this->ngay_dang = date("Y-m-d H:i:s");
		$this->da_xoa = 0;
		$this->so_luot_thich = 0;
		$this->dang_toi = $dang_toi;
		//insert bai viet
		$query = "INSERT INTO BaiViet VALUES (NULL, '$noi_dung', '$dang_boi', '$dang_toi', '$this->ngay_dang', '0', '0')";
		$result = mysqli_query($this->con, $query);
		$this->id = mysqli_insert_id($this->con);

		//Thong Bao
		if ($dang_toi != $dang_boi) {
			$thong_bao = new ThongBao($this->con, $dang_toi);
			$thong_bao->themThongBao($this->id, $dang_boi, "dang_bai_viet_ho_so");
		}		

		//cap nhat so bai viet
		$so_bai_viet = $nguoi_dung->getSoBaiViet();
		$so_bai_viet++;
		$sql = mysqli_query($this->con, "UPDATE NguoiDung SET so_bai_viet = '$so_bai_viet' WHERE ten_tai_khoan = '$dang_boi'");
	}


	public function taiBaiVietBanBe($trang, $nguoi_dung_dang_nhap, $limit){
		//Noi bat dau va ket thuc kq tra ve trong bang CSDL

		$start = ($trang - 1) * $limit;
		// echo $start;
		$str = "";

		$sql = "SELECT * FROM BaiViet WHERE da_xoa = 0 ORDER BY id DESC";
		$query = mysqli_query($this->con, $sql);

		if (mysqli_num_rows($query) > 0) {
			//bien dem xem den bai bao nhieu
			$count = 0;

			$so_bai_load = 1;
			

			while ($row = mysqli_fetch_array($query)) {
				$id = $row['id'];
				$noi_dung = $row['noi_dung'];
				$dang_boi = $row['dang_boi'];
				$ngay_dang = $row['ngay_dang'];
				// xâu đăng tới ai
				if ($row['dang_toi'] == $row['dang_boi']) {
					$dang_toi = "";	
				} else {
					$dang_toi_obj = new NguoiDung ($this->con, $row['dang_toi']);
					$dang_toi_ten = $dang_toi_obj->getHoTen();
					$dang_toi = "<i class='fas fa-chevron-right'></i> <a href='" . $row['dang_toi'] . "'>" . $dang_toi_ten . "</a>";
				}


				$dang_boi_obj = new NguoiDung($this->con, $dang_boi);

				$nguoi_dung_dang_nhap_obj = new NguoiDung($this->con, $nguoi_dung_dang_nhap);
				if($nguoi_dung_dang_nhap_obj->laBanBe($dang_boi_obj)){
					// echo "<br>count: " . $count;
					// echo "<br>start: " . $start;
					if($count < $start){
						$count ++;
						continue;
					}


					if ($so_bai_load > $limit) {
						break;
					} else {
						$so_bai_load++;
					}
					if($nguoi_dung_dang_nhap == $dang_boi)
						$nut_xoa = "<button class='delete_button btn-danger' id='id$id'>X</button>";
					else 
						$nut_xoa = "";

					$chi_tiet_nguoi_dung = mysqli_query($this->con, "SELECT ho, ten, anh_dai_dien FROM NguoiDung WHERE ten_tai_khoan='$dang_boi'");

					$row = mysqli_fetch_array($chi_tiet_nguoi_dung);
					$ho = $row['ho'];
					$ten = $row['ten'];
					$anh_dai_dien = $row['anh_dai_dien'];
					?>

					<script>
						function toggle<?php echo $id; ?>() {
							var target = $(event.target);
							if(!target.is('a')){
								var element = document.getElementById('toggleComment<?php echo $id; ?>');

								if (element.style.display == 'block'){
									element.style.display = 'none';
								} else {
									element.style.display = 'block';
								}
							}
						}
					</script>

					<?php
				
					$binh_luan = mysqli_query($this->con, "SELECT * FROM BinhLuan WHERE id_bai_viet = '$id'");
					$so_binh_luan = mysqli_num_rows($binh_luan);

					$thoi_gian_hien_tai = date("Y-m-d H:i:s");
					$ngay_bat_dau = new DateTime($ngay_dang);
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

					$str .= "
					<div class='status_post' onClick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<a href='$dang_boi'>
									<img src='$anh_dai_dien' width='50'>
									<a>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$dang_boi'> $ho $ten </a> $dang_toi &nbsp;&nbsp;&nbsp;&nbsp;$thoi_gian
									$nut_xoa
								</div>

								<div id='post_body'>
									$noi_dung
									<br>
									<br>
									<br>
								</div>

								<div class='newsfeedPostOptions'>
								Bình luận($so_binh_luan)&nbsp;&nbsp;&nbsp;
								<iframe src='thich.php?id_bai_viet=$id' scrolling='no'></iframe>
								</div>

								
							</div>
							<div class='post_comment' id='toggleComment$id' style='display:none;'>
								<iframe src='binh_luan_bai_viet.php?id_bai_viet=$id' id='comment_iframe' style='border:none;'></iframe>
							</div>
							<hr>";
					}

			} // While

			if ($so_bai_load > $limit) {
				$str .= "<input type='hidden' class='nextPage' value ='" . ($trang +1) ."'>
						 <input type='hidden' class='noMorePosts' value='false'>";
			} else {
				$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align:center;'> Không còn bài viết nào nữa! </p>";
			}


		} // If

		echo $str;
	}

	public function taiBaiVietHoSo($trang, $nguoi_dung_dang_nhap, $nguoi_dung, $limit)
	{
		$start = ($trang - 1)*$limit;
		$str = "";
		$query = mysqli_query($this->con, "SELECT * FROM BaiViet WHERE da_xoa = 0 AND ((dang_boi = '$nguoi_dung' AND dang_toi = 'none') OR (dang_toi='$nguoi_dung')) ORDER BY id DESC");
		if (mysqli_num_rows($query) > 0) {
			$count = 0;

			$so_bai_load = 1;

			while ($row = mysqli_fetch_array($query)) {
				$id = $row['id'];
				$noi_dung = $row['noi_dung'];
				$dang_toi = $row['dang_toi'];
				$dang_boi = $row['dang_boi'];
				$ngay_dang = $row['ngay_dang'];

				if ($count < $start){
					$count++;
					continue;
				}

				if($so_bai_load > $limit){
					break;
				} else {
					$so_bai_load++;
				}
				if($nguoi_dung_dang_nhap == $dang_boi)
					$nut_xoa = "<button class='delete_button btn-danger' id='id$id'>X</button>";
				else 
					$nut_xoa = "";

				$chi_tiet_nguoi_dung = mysqli_query($this->con, "SELECT ho, ten, anh_dai_dien FROM NguoiDung WHERE ten_tai_khoan='$dang_boi'");
				$row = mysqli_fetch_array($chi_tiet_nguoi_dung);
				$ho = $row['ho'];
				$ten = $row['ten'];
				$anh_dai_dien = $row['anh_dai_dien'];
				?>
				<script>
					function toggle<?php echo $id; ?>() {
						var target = $(event.target);
						if(!target.is('a')){
							var element = document.getElementById('toggleComment<?php echo $id; ?>');

							if (element.style.display == 'block'){
								element.style.display = 'none';
							} else {
								element.style.display = 'block';
							}
						}
					}
				</script>
				<?php

				$binh_luan = mysqli_query($this->con, "SELECT * FROM BinhLuan WHERE id_bai_viet = '$id'");
				$so_binh_luan = mysqli_num_rows($binh_luan);

				$thoi_gian_hien_tai = date("Y-m-d H:i:s");
				$ngay_bat_dau = new DateTime($ngay_dang);
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

				$str .= "
					<div class='status_post' onClick='javascript:toggle$id()'>
						<div class='post_profile_pic'>
							<a href='$dang_boi'>
							<img src='$anh_dai_dien' width='50'>
							<a>
						</div>

						<div class='posted_by' style='color:#ACACAC;'>
							<a href='$dang_boi'> $ho $ten </a> &nbsp;&nbsp;&nbsp;&nbsp;$thoi_gian
							$nut_xoa
						</div>

						<div id='post_body'>
							$noi_dung
							<br>
							<br>
							<br>
						</div>

						<div class='newsfeedPostOptions'>
						Bình luận($so_binh_luan)&nbsp;&nbsp;&nbsp;
						<iframe src='thich.php?id_bai_viet=$id' scrolling='no'></iframe>
						</div>
								
					</div>
					<div class='post_comment' id='toggleComment$id' style='display:none;'>
						<iframe src='binh_luan_bai_viet.php?id_bai_viet=$id' id='comment_iframe' style='border:none;'></iframe>
					</div>
					<hr>";



			}

			if ($so_bai_load > $limit) {
				$str .= "<input type='hidden' class='nextPage' value ='" . ($trang +1) ."'>
						 <input type='hidden' class='noMorePosts' value='false'>";
			} else {
				$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align:center;'> Không còn bài viết nào nữa! </p>";
			}
		} 
		echo $str;
	}

}

 ?>