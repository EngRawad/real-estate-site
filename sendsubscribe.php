<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>send email</title>
</head>

<body>
<?
$url = 'http://olga.hol.es/new/sendmail/form.php';
$get_content = @file($url);
$get_content = @implode($get_content, "\r\n");
preg_match("/<div class=\"form\">(.*)<\/div>/isU", $get_content, $out);
echo $out[1];
?>
</body>
</html>