<?php 
include("includes/header.php");
include 'includes/form_handlers/xu_li_dang_bai.php';

if (isset($_GET['u'])) {
	$nguoi_dung = new NguoiDung($con, $_GET['u']);
	if($nguoi_dung->getTenTaiKhoan() != $_GET['u']){
		header("Location: index.php");
	}
}
include 'includes/form_handlers/xu_li_ket_ban.php';

 ?>

	<style type="text/css">
		.wrapper{
			margin-left: 0px;
			padding-left: 0px;
		}
	</style>	
	<div class="profile_left">
		<img src="<?php echo($nguoi_dung->getAnhDaiDien()) ?>">
		<div class="profile_info">
			<p><?php echo "Số bài viết: " .$nguoi_dung->getSoBaiViet(); ?></p>
			<p><?php echo "Số lượt thích: " .$nguoi_dung->getSoLuotThich(); ?></p>
			<p><?php echo "Số bạn bè: " .$nguoi_dung->getSoBanBe(); ?></p>
		</div>
		<a id="gioi_thieu" class="btn btn-info" href="gioi_thieu.php?u=<?php echo($nguoi_dung->getTenTaiKhoan()) ?>">Giới thiệu</a>
		<?php 
			if ($nguoi_dung != $nguoi_dung_dang_nhap) {
				echo '<a id="nhan_tin" class="btn btn-primary" role="button" href="tin_nhan.php?u='. $nguoi_dung->getTenTaiKhoan().'">Nhắn Tin</a>';
			}

		 ?>
		
		<form action="<?php echo($nguoi_dung->getTenTaiKhoan()) ?>" method="POST">
		<?php 
			if ($nguoi_dung != $nguoi_dung_dang_nhap) {
				if ($nguoi_dung_dang_nhap->laBanBe($nguoi_dung)) {
					echo '<input class="btn btn-danger" type="submit" name="huy_ket_ban" value="Huỷ kết bạn"><br>';
				} else if ($nguoi_dung_dang_nhap->daNhanLoiMoi($nguoi_dung)) {
					echo '<input type="submit" class="btn btn-warning" name="phan_hoi" value="Phản hồi lời mời"><br>';
				} else if ($nguoi_dung_dang_nhap->daGuiLoiMoi($nguoi_dung)) {
					echo '<input type="submit" name="" class="btn btn-secondary" disabled value="Đã gửi lời mời"><br>';
				} else {
					echo '<input id="ket_ban" name="ket_ban" class="btn btn-success" value="Kết bạn"><br>';
				}
 
			}

		 ?>
		</form>
		
	</div>


	<div class="main_column column">
		<form action="<?php echo($nguoi_dung->getTenTaiKhoan()) ?>" method="POST" class="post_form">
			<textarea id="noi_dung" id="post_text" name="noi_dung" placeholder="<?php echo($nguoi_dung_dang_nhap->getTen()) ?> ơi, bạn đang nghĩ gì?"></textarea>
			<input type="hidden" id="dang_boi" name="dang_boi" value="<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()); ?>">
			<input type="hidden" id="dang_toi" name="dang_toi" value="<?php echo($nguoi_dung->getTenTaiKhoan()) ?>">
			<input type="submit" id="dang_bai" class="btn btn-info" name="dang_bai" value="Đăng bài">
			
		</form>

		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">
		
	</div>
	<div>
	
	<script>
	$(function(){
	 
		var nguoi_dung_dang_nhap = '<?php echo $nguoi_dung_dang_nhap->getTenTaiKhoan(); ?>';
		var nguoi_dung = '<?php echo($nguoi_dung->getTenTaiKhoan()) ?>'
		var dangTai = false;
	 
		taiBaiViet(); //Tải bài viết đầu tiên
	 
	    $(window).scroll(function() {
	    	var bottomElement = $(".status_post").last();
	    	var noMorePosts = $('.posts_area').find('.noMorePosts').val();
	 
	        if (isElementInView(bottomElement[0]) && noMorePosts == 'false') {
	            taiBaiViet();
	        }
	    });
	 
	    function taiBaiViet() {
	        if(dangTai) { 
				return;
			}
			
			dangTai = true;
			$('#loading').show();
	 
			var page = $('.posts_area').find('.nextPage').val() || 1; 
	 		
			$.ajax({
				url: "includes/handlers/ajax_tai_bai_viet_ho_so.php",
				type: "POST",
				data: "trang=" + page + "&nguoi_dung_dang_nhap=" + nguoi_dung_dang_nhap +"&nguoi_dung="+ nguoi_dung,
				cache:false,
	 
				success: function(response) {
					$('.posts_area').find('.nextPage').remove(); 
					$('.posts_area').find('.noMorePosts').remove();  
	 
					$('#loading').hide();
					$(".posts_area").append(response);
	 
					dangTai = false;
					console.log(page);
				}
			});
	    }
	 
	    //Check if the element is in view
	    function isElementInView (el) {
	        var rect = el.getBoundingClientRect();
	 
	        return (
	            rect.top >= 0 &&
	            rect.left >= 0 &&
	            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
	            rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
	        );
	    }

	    $('#ket_ban').click(function(){

			$.ajax({
				url: nguoi_dung,
				type: "POST",
				data: "ket_ban=" + true,
				cache: false,
				success: function (res) {

					var msg = {
						gui_tu: nguoi_dung_dang_nhap,
						gui_toi: nguoi_dung,
						type: 'ket_ban'
					};

					//convert and send data to server
					websocket.send(JSON.stringify(msg));

					 location.reload();
				}
			});
		});
		$('#dang_bai').click(function(){
			if ($('#noi_dung').val() == '')
				return;

			if(!confirm('Bạn có chắc chắn muốn đăng bài không?'))
				return;
			
			var bai_viet = {
				noi_dung : $('#noi_dung').val(),
				dang_boi : $('#dang_boi').val(),
				dang_toi : $('#dang_toi').val(),
				dang_bai : true
			}

			// $.ajax({
			// 	url: nguoi_dung,
			// 	type: "POST",
			// 	data: JSON.stringify(bai_viet),
			// 	dataType: 'json',
			// 	contentType: 'application/json',
			// 	cache: false,
			// 	success: function (res) {
			// 		if (nguoi_dung_dang_nhap != nguoi_dung) {
			// 			var msg = {
			// 				gui_tu: nguoi_dung_dang_nhap,
			// 				gui_toi: nguoi_dung,
			// 				type: 'thong_bao'
			// 			};
			// 			websocket.send(JSON.stringify(msg));
			// 		}
			// 	//convert and send data to server
				

			// 		 location.reload();
			// 	}
			// });
		});
	});
		
	</script>
</body>
</html>