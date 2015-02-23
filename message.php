<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>message</title>
<link rel="stylesheet" type="text/css" media="all" 		href="modal/css/style.css">
<script type='text/javascript' src="js/jquery-1.9.1.min.js"></script>
</head>

<body>
<?php
//session_start();
?>
<h2>Отправка сообщения</h2>

	<form id="contact" name="contact" action="#" method="post">
    	<label for="yourname">Ваше имя&nbsp&nbsp</label>
		<input type="text" id="yourname" name="yourname" class="txt">
        <br />
		<label for="email">Ваш E-mail</label>
		<input type="email" id="email" name="email" class="txt">
		<br />
		<label for="msg">Введите сообщение</label>
		<textarea id="msg" name="msg" class="txtarea">
        <? if($_GET[lot]){ ?>Лот <?=$_GET[lot]?>. Здравствуйте, пожалуйста, свяжитесь со мной для предоставления
большей информации. <? } ?>
        </textarea><br />
		<p>Введите текст:</p>
        <a href="javascript:void(0)" onclick="runupdate()">обновить</a>
		<div id="errormsg"></div>
        <div id="messagebox" style="visibility:visible">
        <p><img src="kcaptcha/?<?php echo session_name()?>=<?php echo session_id()?>"></p> </div>
		<p><input type="text" name="keystring" id="keystring"></p>
		<button id="send" value="Check">Отправить E-mail</button>
       
        
	</form>
    <?php
if(count($_POST)>0){
	if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['keystring']){
		echo "Correct";
	}else{
		echo "Wrong";
	}
}
unset($_SESSION['captcha_keystring']);
?>
<script type="text/javascript">
	function validateEmail(email) { 
		var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return reg.test(email);
	}
	function runupdate(){
		$("#messagebox").html("<p><img src='kcaptcha/?<?php echo session_name()?>=<?php echo session_id()?>'></p>");
		}
	$(document).ready(function() {
		
		$("#contact").submit(function() { return false; });

		
		$("#send").on("click", function(){
			var yourname  = $("#yourname").val();
			var yournamelen    = yourname.length;
			var emailval  = $("#email").val();
			var msgval    = $("#msg").val();
			var msglen    = msgval.length;			
			var mailvalid = validateEmail(emailval);
			var keystring  = $("#keystring").val();
			var keystringlen    = keystring.length;
			
			if(yournamelen < 1) {
				$("#yourname").addClass("error");
			}
			else if(yournamelen >= 1){
				$("#yourname").removeClass("error");
			}
			
			if(mailvalid == false) {
				$("#email").addClass("error");
			}
			else if(mailvalid == true){
				$("#email").removeClass("error");
			}
			
			if(msglen < 4) {
				$("#msg").addClass("error");
			}
			else if(msglen >= 4){
				$("#msg").removeClass("error");
			}
			
			if(keystringlen < 1) {
				$("#keystring").addClass("error");
			}
			else if(keystringlen >= 1){
				$("#keystring").removeClass("error");
			}
			
			if(mailvalid == true && msglen >= 4 && yournamelen >= 1 && keystringlen >= 1) {
				// если обе проверки пройдены
				// сначала мы скрываем кнопку отправки
				$("#messagebox").css("visibility", "hidden");
				$("#errormsg").html("<em>отправка...</em>");
				
				$.ajax({
					type: 'POST',
					url: 'sendmessage.php',
					data: $("#contact").serialize(),
					success: function(data) {
						if(data == "true") {
							$("#contact").fadeOut("fast", function(){
								$(this).before("<p><strong>Успешно! Ваше сообщение отправлено  :)</strong></p>");
								setTimeout("$.fancybox.close()", 1000);
							});
						}
						if(data == "captcha") {
							$("#errormsg").html("<p style='color:#F00'><strong>Текст не совпал</strong></p>");
							$("#messagebox").html("<p><img src='kcaptcha/?<?php echo session_name()?>=<?php echo session_id()?>'></p>");
							$("#messagebox").css("visibility", "visible");
							
						}
					}
				});
			}
		});
	});
</script>
</body>
</html> 

</body>
</html>