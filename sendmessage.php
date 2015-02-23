<?php
session_start();
$sendto   = "info@casa-de-lujo.com";
$usermail = $_POST['email'];

$content  = nl2br($_POST['msg']);
// Формирование заголовка письма
$subject  = "message from your site";

$headers .= "Reply-To: ".$usermail. "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html;charset=utf-8 \r\n";
// Формирование тела письма
$msg  = "<html><body style='font-family:Arial,sans-serif;'>";
$msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Новое сообщение</h2>\r\n";
$msg .= "<p><strong>От кого:</strong> ".$usermail."</p>\r\n";
$msg .= "<p><strong>Сообщение:</strong> ".$content."</p>\r\n";
$msg .= "</body></html>";

if(count($_POST)>0){
	if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['keystring']){
		if(@mail($sendto, $subject, $msg, $headers)) {
				echo "true";
			} 
		else {
			echo "false";
			}
	}else{
		echo "captcha";
	}
}
unset($_SESSION['captcha_keystring']);

// отправка сообщения


?>