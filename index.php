<?php
include 'includes/header.php';
include 'includes/form_handlers/xu_li_dang_bai.php'

?>
	<div class="user_details column">
		<a href="<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()); ?>"><img src="<?php echo($nguoi_dung_dang_nhap->getAnhDaiDien()); ?>"></a>
		<div class="user_name">
			<a href="<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()) ?>">
				<?php 
				echo $nguoi_dung_dang_nhap->getHoTen(); ?>
			</a>
			<br>
		</div>
	</div>

	<div class="main_column column">
		<form class="post_form" action="index.php" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn đăng bài không?');">
			<textarea name="noi_dung" id="post_text" placeholder="<?php echo($nguoi_dung_dang_nhap->getTen()) ?> ơi, bạn đang nghĩ gì?"></textarea>
			<input  type="hidden" name="dang_boi" value="<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()); ?>">
			<input type="hidden" name="dang_toi" value="<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()) ?>">
			<input class="btn btn-info" type="submit" name="dang_bai" id="post_button" value="Đăng bài">
		</form>

		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">
		
	</div>
	<script>
	$(function(){
	 
		var nguoi_dung_dang_nhap = '<?php echo $nguoi_dung_dang_nhap->getTenTaiKhoan(); ?>';
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
				url: "includes/handlers/ajax_tai_bai_viet.php",
				type: "POST",
				data: "trang=" + page + "&nguoi_dung_dang_nhap=" + nguoi_dung_dang_nhap,
				cache:false,
	 
				success: function(response) {
					$('.posts_area').find('.nextPage').remove(); 
					$('.posts_area').find('.noMorePosts').remove();  
	 
					$('#loading').hide();
					$(".posts_area").append(response);
	 
					dangTai = false;
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
	});
	 
	</script>
	</div>
</body>
</html>