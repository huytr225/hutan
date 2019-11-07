<?php 
include("includes/header.php");


if(isset($_GET['u'])){
	$gui_toi = $_GET['u'];
} else {
	$gui_toi = $tin_nhan->getNguoiDungGanNhat();
	if($gui_toi == false)
		$gui_toi = 'none';
}

if ($gui_toi != 'none') {
	$gui_toi_obj = new NguoiDung($con, $gui_toi);
}

if(isset($_POST['noi_dung'])) {
	echo "con me may";
	$noi_dung = mysqli_real_escape_string($con, $_POST['noi_dung']);
	$tin_nhan->guiTinNhan($gui_toi, $noi_dung);
}


 ?>




	<div class="main_column column" id="main_column">
		<?php

		if ($gui_toi != 'none') {
			echo "<h4>Bạn và <a href='$gui_toi'>".$gui_toi_obj->getHoTen() . "</a></h4><hr><br>";
			echo "<div class='loaded_messages' id='scroll_messages'>";
			echo $tin_nhan->taiTinNhan($gui_toi);
			echo "</div>";
		} else {
			echo "<h4>Tạo tin nhắn mới</h4>";
		}
		?>



		<div class="message_post">
			
				<?php
				if($gui_toi == "none") {
					echo "Chọn trong danh sách bạn bè của bạn để nhắn tin <br><br>";
					?> 
					Nhắn tin đến: <input type='text' onkeyup='getNguoiDung(this.value, "<?php echo $nguoi_dung_dang_nhap->getTenTaiKhoan(); ?>")' name='q' placeholder='Tên' autocomplete='off' id='seach_text_input'>

					<?php
					echo "<div class='results'></div>";
				}
				else {
					echo "<input type='text' name='noi_dung' id='message_input' placeholder='Nhập tin nhắn'></input>";
					echo "<input type='submit' name='gui_tin_nhan' class='btn btn-info' id='message_submit' value='Gửi tin nhắn'>";
				}

				?>
			

		</div>


	</div>

	<div class="user_details column" id="conversations">
			<h4>Hội thoại</h4>

			<div class="loaded_conversations">
				<?php echo $tin_nhan->taiHoiThoai(); ?>

			</div>
			<br>
			<a href="tin_nhan.php?u=none">Tin nhắn mới</a>


		</div>
		 <script>
		 	var div = document.getElementById("scroll_messages");
		 	div.scrollTop = div.scrollHeight;

			var msgBox = $('.loaded_messages');
		 	var nguoi_dung_dang_nhap = '<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()) ?>';
			var nguoi_dung = '<?php echo($gui_toi) ?>';
			// Message received from server
			websocket.onopen = function(ev) { // connection is open 
				cap_nhat_tin_nhan(nguoi_dung_dang_nhap, nguoi_dung);
			}

			websocket.onmessage = function(ev) {
				var response 		= JSON.parse(ev.data); //PHP sends Json data
				
				var res_type 		= response.type; //message type
				var gui_tu 			= response.gui_tu; //message text
				var gui_toi 		= response.gui_toi; //user name
				var message 		= response.message;
				console.log(response);
				switch(res_type){

					case 'nhan_tin':
						if (nguoi_dung_dang_nhap == gui_toi && nguoi_dung == gui_tu) {
							msgBox.append("<div class='mes'><div class='mes_profile_pic' id='left'><a href='" + nguoi_dung + "'><img src='" + "<?php echo($gui_toi_obj->getAnhDaiDien()) ?>" +"' width='50'></a></div><div class='message' id='green'>" + message + "</div></div><br>");
							//prepare json data

							cap_nhat_tin_nhan(nguoi_dung_dang_nhap, nguoi_dung);
						} 
						// else if (nguoi_dung_dang_nhap == gui_tu && nguoi_dung == gui_toi){
							
						// }
						msgBox[0].scrollTop = msgBox[0].scrollHeight; //scroll message 
						
						break;
					case 'cap_nhat_tin_nhan':
						var so_luong 		= response.so_luong;
						if (gui_tu == nguoi_dung_dang_nhap) {
							var thong_bao_tin_nhan = $("#thong_bao_tin_nhan");
							if (so_luong == 0) {
								thong_bao_tin_nhan.html('<i class="far fa-comment"></i>');
							} else {
								thong_bao_tin_nhan.html("<i class='fas fa-comment'><span class='noti'>" + so_luong + "</span></i>");
							}
						}
						break;
					case 'system':
						console.log(message);
						// msgBox.append('<div style="color:#bbbbbb">' + message + '</div>');
						break;
				}
				
			};
			$('#message_submit').click(function(){
				send_message();
			});

			// User hits enter key 
			$( "#message_input" ).on( "keydown", function( event ) {
			  if(event.which==13){
			  	var message_input = $('#message_input');

				  send_message();
			  }
			});

			// Send message
			function send_message(){
				var message_input = $('#message_input'); //user message text
				if (message_input.val() == '') {
					return;
				}

				
				//prepare json data
				var msg = {
					message: message_input.val(),
					gui_tu: '<?php echo($nguoi_dung_dang_nhap->getTenTaiKhoan()); ?>',
					gui_toi: '<?php echo($gui_toi); ?>',
					type: 'nhan_tin'
				};
				msgBox.append("<div class='mes'><div class='mes_profile_pic' id='right'><a href='" + nguoi_dung_dang_nhap + "'><img src='" + "<?php echo($nguoi_dung_dang_nhap->getAnhDaiDien()) ?>" +"' width='50'></a></div><div class='message' id='blue'>" + message_input.val() + "</div></div><br>");
				msgBox[0].scrollTop = msgBox[0].scrollHeight;
				$.ajax({
					url: 'tin_nhan.php',
					type: "POST",
					data: "noi_dung=" + message_input.val(),
					cache: false,
					success: function (res) {
						
						websocket.send(JSON.stringify(msg));
					}
				});
				//convert and send data to server
				
				message_input.val(''); //reset message input
			}

			function cap_nhat_tin_nhan(gui_tu, gui_toi) {
				var msg = {
					gui_toi: gui_toi,
					gui_tu: gui_tu,
					type: 'cap_nhat_tin_nhan'
				};
				//convert and send data to server
				websocket.send(JSON.stringify(msg));
				
			}
		 </script>
