<?php 
include 'includes/header.php';
 ?>

 <div class="main_column column" id="main_column">

	<h4>Thông báo</h4>


	<div class="posts_area"></div>
	<img id="loading" src="assets/images/icons/loading.gif">

</div>
<script>
	$(function(){
		var nguoi_dung_dang_nhap = '<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()) ?>';
		var dangTai = false;
		cap_nhat_thong_bao();
		taiThongBao();

	    $(window).scroll(function(){
	    	var bottomElement = $(".status_post").last();
	    	var noMorePosts = $('.posts_area').find('.noMorePosts').val();

	    	if (isElementInView(bottomElement[0]) && noMorePosts == 'false') {
	    		taiThongBao();
	    	}
	    });
	   	



		function cap_nhat_thong_bao() {
			var thong_bao = $("#thong_bao");
			thong_bao.html('<i class="far fa-bell"></i>');
			
		}

	    function taiThongBao(){

	    	if (dangTai) {
	    		return;
	    	}
	    	dangTai = true;
	    	$('#loading').show();

	    	var trang = $('.posts_area').find('.nextPage').val() || 1;

	    	$.ajax({
	    		url: 'includes/handlers/ajax_tai_thong_bao.php',
	    		type: 'POST',
	    		data: 'trang=' + trang + '&nguoi_dung_dang_nhap=' + nguoi_dung_dang_nhap,
	    		cache: false,
	    		success: function(res){
	    			$('.posts_area').find('.nextPage').remove();
	    			$('.posts_area').find('.noMorePosts').remove();
	    			$('#loading').hide();
	    			$('.posts_area').append(res);
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
	})
</script>

