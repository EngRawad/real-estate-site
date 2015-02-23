<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Подписаться на рассылку</title>
<link rel="stylesheet" type="text/css" media="all" 		href="modal/css/style.css">
<script type='text/javascript' src="js/jquery-1.9.1.min.js"></script>
</head>

<body>
<h2>Подписаться на рассылку</h2>

	<form id="contact" action="sendmail/sendmail.php" method="post">
    	<label for="name">Ваше имя&nbsp&nbsp</label>
		<input type="text" id="name" name="name" type=text class="txt">
        <br />
		<label for="email">Ваш E-mail</label>
		<input type="text" id="email" name="email" class="txt">
		<br />
		<input type=hidden name="action" value=post>
		
      	<input id="send" type="submit" value="Подписаться" />
        
	</form>
  

</body>
</html>