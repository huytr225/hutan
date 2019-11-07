<?php 
include("includes/header.php");

include("includes/form_handlers/xu_li_cv.php");

$id = $_GET['id'];
$ho_so = new HoSo($con, $nguoi_dung_dang_nhap->getTenTaiKhoan());
if ($id != 'new') {
	$ho_so->setId($id);
}


?>

<div class="main_column column container">

	<h4>Account Settings</h4>
	<?php
	echo "<img src='" . $nguoi_dung_dang_nhap->getAnhDaiDien() ."' class='small_profile_pic'>";
	?>
	<br>
	<a href="upload.php">Upload new profile picture</a> <br><br><br>

	
	<h4>Thông tin hồ sơ</h4>
	<form class="form-horizontal" action="settings.php" method="POST">
		<div id="thong_tin_ca_nhan">
			<div class="form-group row">
				<label for="ten_ho_so" class="control-label col-sm-2">Tên hồ sơ:</label>
				<div class="col-sm-10">
					<input class="form-control" id="ten_ho_so" name="ten_ho_so" value="<?php echo($ho_so->getTenHoSo()); ?>" type="text">
				</div>
			</div>
			<div class="form-group row">
				<label for="ho" class="control-label col-sm-2">Họ</label>
				<div class="col-sm-4">
					<input class="form-control" id="ho" name="ho" type="text" value="<?php echo $nguoi_dung_dang_nhap->getHo() ?>">
				</div>
				<label for="ten" class="control-label col-sm-2">Tên</label>
				<div class="col-sm-4">
					<input class="form-control" id="ten" name="ten" type="text" value="<?php echo $nguoi_dung_dang_nhap->getTen(); ?>">
				</div>
			</div>
			<div class="form-group row">
				<label for="email" class="control-label col-sm-2">Email</label>
				<div class="col-sm-10">
					<input disabled class="form-control" id="email" name="email" type="text" value="<?php echo $nguoi_dung_dang_nhap->getEmail(); ?>" >
				</div>
			</div>
			<div class="form-group row">
				<label for="dia_chi" class="control-label col-sm-2">Địa chỉ</label>
				<div class="col-sm-10">
					<input class="form-control" id="dia_chi" name="dia_chi" value="<?php echo($ho_so->getDiaChi()) ?>" type="text">
				</div>
			</div>
			<div class="form-group row">
				<label for="sdt" class="control-label col-sm-2">Số điện thoại</label>
				<div class="col-sm-4">
					<input class="form-control" id="sdt" name="sdt" value="<?php echo($ho_so->getSDT()) ?>" type="text">
				</div>
				<label for="ngay_sinh" class="control-label col-sm-2">Ngày sinh</label>
				<div class="col-sm-4">
					<input class="form-control" id="ngay_sinh" name="ngay_sinh" value="<?php echo($ho_so->getNgaySinh()) ?>" type="text">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-sm-2">Ẩn mục:</div>
				<div class="col-sm-10"><input type="checkbox" name="an_tt_ca_nhan"></div>
			</div> 
		</div>
		<hr>
		<h4 >Kinh nghiệm làm việc</h4>
			<div id='kinh_nghiem'>
				<?php 
				
				foreach ($ho_so->getMangKinhnghiem() as $kinh_nghiem) {
					$ten_cong_ty = $kinh_nghiem->getTenCongTy();
					$vi_tri = $kinh_nghiem->getViTri();
					$ngay_bat_dau = $kinh_nghiem->getNgayBatDau();
					$ngay_hoan_thanh = $kinh_nghiem->getNgayHoanThanh();
					$mo_ta = $kinh_nghiem->getMoTa();
					$an = $kinh_nghiem->getAn() ? 'checked' : '';

					$str = "<div id='kinh_nghiem0'>
						<div class='row form-group'>
							<label for='ten_cong_ty0' class='control-label col-sm-2'>Tên công ty:</label>
							<div class='col-sm-8'>
								<input class='form-control' id='ten_cong_ty0' name='ten_cong_ty0' type='text' value='$ten_cong_ty'>
							</div>
							<div class='col-sm-2'>
								<span onclick='removeElement(this)' class='close'>x</span>
							</div>
						</div> 
						<div class='row form-group'>
							<label for='vi_tri0' class='control-label col-sm-2'>Vị trí:</label>
							<div class='col-sm-10'>
								<input class='form-control' id='vi_tri0' name='vi_tri0' type='text' value='$vi_tri'>
							</div>
						</div>
						<div class='form-group row'>
							<label for='ngay_bat_dau0' class='control-label col-sm-2'>Ngày bắt đầu:</label>
							<div class='col-sm-4'>
								<input class='form-control' id='ngay_bat_dau0' name='ngay_bat_dau0' type='text' value='$ngay_bat_dau'>
							</div>
							<label for='ngay_hoan_thanh0' class='control-label col-sm-2'>Ngày hoàn thành:</label>
							<div class='col-sm-4'>
								<input class='form-control' id='ngay_hoan_thanh0' name='ngay_hoan_thanh0' type='text' value='$ngay_hoan_thanh'>
							</div>
						</div>
						<div class='row form-group'>
							<label for='mo_ta0' class='control-label col-sm-2'>Mô tả:</label>
							<div class='col-sm-10'>
								<input class='form-control' id='mo_ta0' name='mo_ta0' type='text' value='$mo_ta'>
							</div>
						</div> 
						<div class='row form-group'>
							<div for='an0' class='control-label col-sm-2'>Ẩn mục:</div>
							<div class='col-sm-10'><input type='checkbox' name='an0' $an></div>
						</div> 
					</div>";
					echo($str);
				}

				 ?>
			</div>
			<button type="button" class="btn btn-outline-primary" onclick="themKinhNghiem()" >Thêm kinh nghiệm</button>
		<hr>
		<h4 >Học vấn</h4>
			<div id='hoc_van'>
				<?php 

				foreach ($ho_so->getMangHocVan() as $hoc_van) {
					$ten_truong = $hoc_van->getTenTruong();
					$chuyen_nganh = $hoc_van->getChuyenNganh();
					$ngay_bat_dau = $hoc_van->getNgayBatDau();
					$ngay_hoan_thanh = $hoc_van->getNgayHoanThanh();
					$mo_ta = $hoc_van->getMoTa();
					$an = $hoc_van->getAn() ? 'checked' : '';


					$str = "<div id='hoc_van0'>
						<div class='row form-group'>
							<label for='ten_truong0' class='control-label col-sm-2'>Tên trường:</label>
							<div class='col-sm-8'>
								<input class='form-control' id='ten_truong0' name='ten_truong0' type='text' value='$ten_truong'>
							</div>
							<div class='col-sm-2'>
								<span onclick='removeElement(this)' class='close'>x</span>
							</div>
						</div> 
						<div class='row form-group'>
							<label for='chuyen_nganh0' class='control-label col-sm-2'>Chuyên ngành:</label>
							<div class='col-sm-10'>
								<input class='form-control' id='chuyen_nganh0' name='chuyen_nganh0' type='text' value='$chuyen_nganh'>
							</div>
						</div>
						<div class='form-group row'>
							<label for='ngay_bat_dau0' class='control-label col-sm-2'>Ngày bắt đầu:</label>
							<div class='col-sm-4'>
								<input class='form-control' id='ngay_bat_dau0' name='ngay_bat_dau0' type='text' value='$ngay_bat_dau'>
							</div>
							<label for='ngay_hoan_thanh0' class='control-label col-sm-2'>Ngày hoàn thành:</label>
							<div class='col-sm-4'>
								<input class='form-control' id='ngay_hoan_thanh0' name='ngay_hoan_thanh0' type='text' value='$ngay_hoan_thanh'>
							</div>
						</div>
						<div class='row form-group'>
							<label for='mo_ta0' class='control-label col-sm-2'>Mô tả:</label>
							<div class='col-sm-10'>
								<input class='form-control' id='mo_ta0' name='mo_ta0' type='text' value='$mo_ta'>
							</div>
						</div> 
						<div class='row form-group'>
							<div for='an0' class='control-label col-sm-2'>Ẩn mục:</div>
							<div class='col-sm-10'><input type='checkbox' name='an0' $an></div>
						</div> 
					</div>";
					echo "$str";
				}

				 ?>
			</div>
			<button type="button" class="btn btn-outline-primary" onclick="themHocVan()" >Thêm học vấn</button>
		<hr>
		<h4 >Kỹ năng</h4>
			<div id='ky_nang'>
				<?php 

				foreach ($ho_so->getMangKyNang() as $ky_nang) {
					$ten_ky_nang = $ky_nang->getTenKyNang();
					$mo_ta = $ky_nang->getMoTa();
					$an = $ky_nang->getAn() ? 'checked' : '';


					$str = "<div id='ky_nang0'>
								<div class='row form-group'>
									<label for='ten_ky_nang0' class='control-label col-sm-2'>Tên kỹ năng:</label>
									<div class='col-sm-8'>
										<input class='form-control' id='ten_ky_nang0' name='ten_ky_nang0' type='text' value='$ten_ky_nang'>
									</div>
									<div class='col-sm-2'>
										<span onclick='removeElement(this)' class='close'>x</span>
									</div>
								</div> 
								<div class='row form-group'>
									<label for='mo_ta0' class='control-label col-sm-2'>Mô tả:</label>
									<div class='col-sm-10'>
										<input class='form-control' id='mo_ta0' name='mo_ta0' type='text' value='$mo_ta'>
									</div>
								</div> 
								<div class='row form-group'>
									<div for='an0' class='control-label col-sm-2'>Ẩn mục:</div>
									<div class='col-sm-10'><input type='checkbox' name='an0' $an></div>
								</div> 
							</div>";
					echo "$str";
				}

				 ?>
			</div>
			<button type="button" class="btn btn-outline-primary btn-rounded" onclick="themKyNang()">Thêm kỹ năng</button>
		<hr>
			<input name="luu_ho_so" id="luu_ho_so" value="Lưu hồ sơ" class="btn btn-success"><br>
	</form>


</div>

<script type="text/javascript">

	

	var ky_nang_id = 0;
	var kinh_nghiem_id = 0;
	var hoc_van_id = 0;

	function removeElement(ele, id) {
		var div = ele.parentElement.parentElement.parentElement;
		console.log(ele.parentElement);
	    div.remove();
	}

	function themHocVan() {
		var text = '<div id="hoc_van' + hoc_van_id +'"><br><br><div class="row form-group"> <label for="ten_truong' + hoc_van_id +'" class="control-label col-sm-2">Tên trường:</label> <div class="col-sm-8"> <input class="form-control" id="ten_truong' + hoc_van_id +'" name="ten_truong' + hoc_van_id +'" type="text"> </div> <div class="col-sm-2"> <span onclick="removeElement(this)" class="close">x</span> </div> </div> <div class="row form-group"> <label for="chuyen_nganh' + hoc_van_id +'" class="control-label col-sm-2">Chuyên ngành:</label> <div class="col-sm-10"> <input class="form-control" id="chuyen_nganh' + hoc_van_id +'" name="chuyen_nganh' + hoc_van_id +'" type="text"> </div> </div> <div class="form-group row"> <label for="ngay_bat_dau' + hoc_van_id +'" class="control-label col-sm-2">Ngày bắt đầu:</label> <div class="col-sm-4"> <input class="form-control" id="ngay_bat_dau' + hoc_van_id +'" name="ngay_bat_dau' + hoc_van_id +'" type="text"> </div> <label for="ngay_hoan_thanh' + hoc_van_id +'" class="control-label col-sm-2">Ngày hoàn thành:</label> <div class="col-sm-4"> <input class="form-control" id="ngay_hoan_thanh' + hoc_van_id +'" name="ngay_hoan_thanh' + hoc_van_id +'" type="text"> </div> </div> <div class="row form-group"> <label for="mo_ta' + hoc_van_id +'" class="control-label col-sm-2">Mô tả:</label> <div class="col-sm-10"> <input class="form-control" id="mo_ta' + hoc_van_id +'" name="mo_ta' + hoc_van_id +'" type="text"> </div> </div> <div class="row form-group"> <div for="an' + hoc_van_id +'" class="control-label col-sm-2">Ẩn mục:</div> <div class="col-sm-10"><input type="checkbox" name="an' + hoc_van_id +'"></div> </div> </div> ';

		hoc_van_id++;
		$('#hoc_van').append(text);
	}
	function themKinhNghiem() {
		var text = '<div id="kinh_nghiem' + kinh_nghiem_id +'"><div class="row form-group"><label for="ten_cong_ty' + kinh_nghiem_id +'" class="control-label col-sm-2">Tên công ty:</label><div class="col-sm-8"><input class="form-control" id="ten_cong_ty' + kinh_nghiem_id +'" name="ten_cong_ty' + kinh_nghiem_id +'" type="text"></div><div class="col-sm-2"><span onclick="removeElement(this)" class="close">x</span></div></div><div class="row form-group"><label for="vi_tri' + kinh_nghiem_id +'" class="control-label col-sm-2">Vị trí:</label><div class="col-sm-10"><input class="form-control" id="vi_tri' + kinh_nghiem_id +'" name="vi_tri' + kinh_nghiem_id +'" type="text"></div></div><div class="form-group row"><label for="ngay_bat_dau' + kinh_nghiem_id +'" class="control-label col-sm-2">Ngày bắt đầu:</label><div class="col-sm-4"><input class="form-control" id="ngay_bat_dau' + kinh_nghiem_id +'" name="ngay_bat_dau' + kinh_nghiem_id +'" type="text"></div><label for="ngay_hoan_thanh' + kinh_nghiem_id +'" class="control-label col-sm-2">Ngày hoàn thành:</label><div class="col-sm-4"><input class="form-control" id="ngay_hoan_thanh' + kinh_nghiem_id +'" name="ngay_hoan_thanh' + kinh_nghiem_id +'" type="text"></div></div><div class="row form-group"><label for="mo_ta' + kinh_nghiem_id +'" class="control-label col-sm-2">Mô tả:</label><div class="col-sm-10"><input class="form-control" id="mo_ta' + kinh_nghiem_id +'" name="mo_ta' + kinh_nghiem_id +'" type="text"></div></div><div class="row form-group"><div for="an' + kinh_nghiem_id +'" class="control-label col-sm-2">Ẩn mục:</div><div class="col-sm-10"><input type="checkbox" name="an' + kinh_nghiem_id +'"></div></div></div>';

		kinh_nghiem_id++;
		$('#kinh_nghiem').append(text);
	}
	function themKyNang() {
		var text = '<div id="ky_nang' + ky_nang_id +'"><br><br><div class="row form-group"><label for="ten_ky_nang' + ky_nang_id +'" class="control-label col-sm-2">Tên kỹ năng:</label><div class="col-sm-8"><input class="form-control" id="ten_ky_nang' + ky_nang_id +'" name="ten_ky_nang' + ky_nang_id +'" type="text"></div><div class="col-sm-2"><span onclick="removeElement(this)" class="close">x</span></div></div><div class="row form-group"><label for="mo_ta' + ky_nang_id +'" class="control-label col-sm-2">Mô tả:</label><div class="col-sm-10"><input class="form-control" id="mo_ta' + ky_nang_id +'" name="mo_ta' + ky_nang_id +'" type="text"></div></div><div class="row form-group"><div for="an0" class="control-label col-sm-2">Ẩn mục:</div><div class="col-sm-10"><input type="checkbox" name="an' + ky_nang_id +'"></div></div></div>';
		ky_nang_id++;
		$('#ky_nang').append(text);
	}
	

	$("#luu_ho_so").click(function(){
		var tt = $("#thong_tin_ca_nhan :input");
		var kngh = $("#kinh_nghiem :input");
		var hvan = $("#hoc_van :input");
		var knang = $("#ky_nang :input");
		var id = '<?php echo "$id"; ?>';
		var ho_so = {
			luu_ho_so : true,
			id : id,
			thong_tin_ho_so: {
				ten_ho_so: tt[0].value,
				ky_nang :[],
				kinh_nghiem :[],
				hoc_van: []
			},
			thong_tin_ca_nhan: {
				ho: tt[1].value,
				ten: tt[2].value,
				email: tt[3].value,
				dia_chi: tt[4].value,
				sdt: tt[5].value,
				ngay_sinh: tt[6].value,
				an: tt[7].checked ? '1' : '0',
			},
			
		}

		
		for (var i = 0; i <= kngh.length - 1; i = i + 6) {
			var kinh_nghiem = {
				ten_cong_ty: kngh[i].value,
				vi_tri: kngh[i+1].value,
				ngay_bat_dau: kngh[i+2].value,
				ngay_hoan_thanh: kngh[i+3].value,
				mo_ta: kngh[i+4].value,
				an: kngh[i+5].checked ? '1' : '0'
			}
			ho_so.thong_tin_ho_so.kinh_nghiem.push(kinh_nghiem);
		}

		for (var i = 0; i <= hvan.length - 1; i = i + 6) {
			var hoc_van = {
				ten_truong: hvan[i].value,
				chuyen_nganh: hvan[i+1].value,
				ngay_bat_dau: hvan[i+2].value,
				ngay_hoan_thanh: hvan[i+3].value,
				mo_ta: hvan[i+4].value,
				an: hvan[i+5].checked ? '1' : '0'
			}
			ho_so.thong_tin_ho_so.hoc_van.push(hoc_van);
		}
		
		for (var i = 0; i <= knang.length - 1; i = i + 3) { 
			var ky_nang = {
				ten_ky_nang: knang[i].value,
				mo_ta: knang[i+1].value,
				an: knang[i+2].checked ? '1' : '0'
			}
			ho_so.thong_tin_ho_so.ky_nang.push(ky_nang);
		}

		$.post("settings.php?id=" + id, ho_so, function(res){
			alert("Lưu thành công");
		});
	});
</script>