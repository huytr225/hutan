<?php

include("includes/header.php");

if(isset($_GET['q'])) {
	$query = $_GET['q'];
}
else {
	$query = "";
}

if(isset($_GET['type'])) {
	$type = $_GET['type'];
}
else {
	$type = "ten";
}

?>

<div class="main_column column" id="main_column">



	<?php 
	if($query == "")
		echo "Bạn phải điền gì đó.";
	else {

		if($type == "ten_tai_khoan") 
			$usersReturnedQuery = mysqli_query($con, "SELECT * FROM NguoiDung WHERE ten_tai_khoan LIKE '$query%' LIMIT 8");
		else if ($type == "ten") {

			$names = explode(" ", $query);

			if(count($names) == 3)
				$usersReturnedQuery = mysqli_query($con, "SELECT * FROM NguoiDung WHERE (ten LIKE '$names[0]%' AND ho LIKE '$names[2]%')");
			else if(count($names) == 2)
				$usersReturnedQuery = mysqli_query($con, "SELECT * FROM NguoiDung WHERE (ten LIKE '$names[0]%' AND ho LIKE '$names[1]%') OR (ten LIKE '$names[1]%' AND ho LIKE '$names[0]%')");
			else 
				$usersReturnedQuery = mysqli_query($con, "SELECT * FROM NguoiDung WHERE (ten LIKE '$names[0]%' OR ho LIKE '$names[0]%')");
		} else if ($type == "ky_nang"){
				$usersReturnedQuery = mysqli_query($con, "SELECT * FROM NguoiDung WHERE ten_tai_khoan IN (SELECT ten_tai_khoan FROM HoSo WHERE id IN (SELECT ho_so_id FROM KyNang WHERE ten_ky_nang LIKE '$query%'))");
			
		}

		if(mysqli_num_rows($usersReturnedQuery) == 0)
			echo "Không tìm thấy ai có " . $type . " giống như: " .$query;
		else 
			echo mysqli_num_rows($usersReturnedQuery) . " kết quả được tìm thấy có $type là: <br> <br>";


		echo "<p id='grey'>Thử tìm kiếm theo:</p>";
		echo "<a href='tim_kiem.php?q=" . $query ."&type=ten'>Tên</a>, <a href='tim_kiem.php?q=" . $query ."&type=ten_tai_khoan'>Tên tài khoản</a>";
		if ($_SESSION['cao_cap'] != '0') {
			echo ", <a href='tim_kiem.php?q=" . $query ."&type=ky_nang'>Kỹ năng</a>";
		}
		echo "<br><br><hr id='search_hr'>";
		while($row = mysqli_fetch_array($usersReturnedQuery)) {
			$user_obj = new NguoiDung($con, $nguoi_dung_dang_nhap->getTenTaiKhoan());
			$nguoi_dung = new NguoiDung($con, $row['ten_tai_khoan']);
			$button = "";
			$mutual_friends = "";

			if($nguoi_dung_dang_nhap->getTenTaiKhoan() != $row['ten_tai_khoan']) {

				if($user_obj->laBanBe($nguoi_dung))
					$button = "<input type='submit' name='" . $nguoi_dung->getTenTaiKhoan() . "' class='danger' value='Xoá bạn'>";
				else if($user_obj->daNhanLoiMoi($nguoi_dung))
					$button = "<input type='submit' name='" . $nguoi_dung->getTenTaiKhoan() . "' class='warning' value='Phản hồi lời mời'>";
				else if($user_obj->daGuiLoiMoi($nguoi_dung))
					$button = "<input type='submit' class='default' value='Đã gửi lời mời'>";
				else 
					$button = "<input type='submit' name='" . $nguoi_dung->getTenTaiKhoan() . "' class='success' value='Thêm bạn'>";



				// //Button forms
				// if(isset($_POST[$row['ten_tai_khoan']])) {

				// 	if($user_obj->laBanBe($row['ten_tai_khoan'])) {
				// 		$user_obj->removeFriend($row['ten_tai_khoan']);
				// 		header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
				// 	}
				// 	else if($user_obj->huyKetBan($row['ten_tai_khoan'])) {
				// 		header("Location: requests.php");
				// 	}
				// 	else if($user_obj->daGuiLoiMoi($row['ten_tai_khoan'])) {

				// 	}
				// 	else {
				// 		$user_obj->sendRequest($row['ten_tai_khoan']);
				// 		header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
				// 	}

				// }



			}

			echo "<div class='search_result'>
					<div class='searchPageFriendButtons'>
						<form action='' method='POST'>
							" . $button . "
							<br>
						</form>
					</div>


					<div class='result_profile_pic'>
						<a href='" . $row['ten_tai_khoan'] ."'><img src='". $row['anh_dai_dien'] ."' style='height: 100px;'></a>
					</div>

						<a href='" . $row['ten_tai_khoan'] ."'> " .$nguoi_dung->getHoTen() . "
						<p id='grey'> " . $row['ten_tai_khoan'] ."</p>
						</a>
						<br>
						" . $mutual_friends ."<br>

				</div>
				<hr id='search_hr'>";

		} 
	}


	?>



</div>