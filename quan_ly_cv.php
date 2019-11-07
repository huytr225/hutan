<?php 
include("includes/header.php");
include("includes/form_handlers/xu_li_cv.php");
$mang_ho_so = $nguoi_dung_dang_nhap->getMangHoSo();

?>

<style type="text/css">
	ul {
	  margin: 0;
	  padding: 0;
	  list-style-type: none; 
	}

	/* Style the list items */
	ul li {
	  cursor: pointer;
	  position: relative;
	  padding: 12px 8px 12px 40px;
	  background: #eee;
	  font-size: 18px;
	  transition: 0.2s;

	  /* make the list items unselectable */
	  -webkit-user-select: none;
	  -moz-user-select: none;
	  -ms-user-select: none;
	  user-select: none;
	}

	/* Set all odd list items to a different color (zebra-stripes) */
	ul li:nth-child(odd) {
	  background: #f9f9f9;
	}

	/* Darker background-color on hover */
	ul li:hover {
	  background: #ddd;
	}


	/* Style the close button */
	.close {
	  position: absolute;
	  right: 0;
	  top: 0;
	  padding: 12px 16px 12px 16px !important;

	}

	.close:hover {
	  background-color: #f44336;
	  color: white;
	}

	/* Style the header */
	.header {
	  background-color: #05668d;
	  padding: 30px 40px;
	  color: white;
	  text-align: center;
	}

	/* Clear floats after the header */
	.header:after {
	  content: "";
	  display: table;
	  clear: both;
	}

	/* Style the input */
	input {
	  margin: 0;
	  border: none;
	  border-radius: 0;
	  width: 75%;
	  padding: 10px;
	  float: left;
	  font-size: 16px;
	}

	/* Style the "Add" button */
	.addBtn {
	  padding: 10px;
	  width: 25%;
	  background: #d9d9d9;
	  color: #555;
	  float: left;
	  text-align: center;
	  font-size: 16px;
	  cursor: pointer;
	  transition: 0.3s;
	  border-radius: 0;
	}

	.addBtn:hover {
	  background-color: #bbb;
	}
	/* When clicked on, add a background color and strike out text */
	ul li.checked {
	  background: #888;
	  color: #fff;
	}

	/* Add a "checked" mark when clicked on */
	ul li.checked::before {
	  content: '';
	  position: absolute;
	  border-color: #fff;
	  border-style: solid;
	  border-width: 0 2px 2px 0;
	  top: 10px;
	  left: 16px;
	  transform: rotate(45deg);
	  height: 15px;
	  width: 7px;
	}
	a { color: inherit; } 
</style>

<div class="main_column column">

<div id="myDIV" class="header">
  <h2>Quản lý Hồ Sơ</h2>
  <input type="text" id="myInput" placeholder="Tên hồ sơ">
  <a onclick="newElement()" href="settings.php?id=new"><span class="addBtn">Thêm</span></a>
</div>
<ul id="myUL">
<?php 
	foreach ($mang_ho_so as $ho_so) {
		$str = "";
		$class = "";
		$close = "";
		$main = "";
		$id = $ho_so->getId();
		$ten_ho_so = $ho_so->getTenHoSo();
		$ho_so_chinh = $ho_so->getHoSoChinh();
		if ($ho_so_chinh == '1') { 
			$class = "class='checked'";
		} else {
			$close = "<button value='$id' class='close'>×</button>";
			$main = "<button class='set_cv' value='$id' type='button'>Đặt CV chính</button>";
		}
		$str.= "<li " . $class ." ><a href='settings.php?id=$id'>$ten_ho_so</a>" . $main . $close . "</li>";
		echo($str);
	}
 ?>
</ul>





</div>
<script type="text/javascript">
	function newElement() {
	  var li = document.createElement("li");
	  var inputValue = document.getElementById("myInput").value;
	  var t = document.createTextNode(inputValue);
	  var myUL = document.getElementById("myUL");
	  li.appendChild(t);
	  if (inputValue === '') {
	    alert("Bạn phải điền tên CV!");
	  } else {
	 //    $.post("quan_ly_cv.php", {ten_ho_so: inputValue, them_ho_so: true}, function(result){
		// 	myUL.insertBefore(li, myUL.childNodes[0]);
		// });
	  }
	  // myNodelist.insertBefore(span, myNodelist.childNodes[0]);
	  // console.log(myNodelist);
	  // console.log(myNodelist.childNodes);

	  for (i = 0; i < close.length; i++) {
	    close[i].onclick = function() {
	      var div = this.parentElement;
	      div.style.display = "none";
	    }
	  }
	}

	$(".set_cv").click(function(){
		$.post("quan_ly_cv.php", {set_cv: true, id: $(this).val()}, function(res){
			location.reload();
		});
	});

	$(".close").click(function(){
		this.parentElement.style.display = "none";
		
		$.post("quan_ly_cv.php", {xoa_cv: true, id: $(this).val()}, function(res){

		});
	});
</script>