<?php

//////////////////////////////////////
// PHP Newsletter v3.5.6            //
// (C) 2006-2013 Alexander Yanitsky //
// Website: http://janicky.com      //
// E-mail: janickiy@mail.ru         //
// Skype: janickiy                  //
//////////////////////////////////////

Error_Reporting(E_ALL & ~E_NOTICE);

define("DEBUG", 0);

require "admin/class/class.exception_mysql.php";
require "admin/class/class.exception_object.php";
require "admin/class/class.exception_member.php";

try
{
	require_once "admin/lib/functions.inc";
	require_once "admin/lib/connect.inc";

?>
<!DOCTYPE html>
<html>
<head>
<title>Subscript</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php

	$url = "http://".$_SERVER["SERVER_NAME"].root()."form.php";

	$get_content = file($url);
	$get_content = implode($get_content, "\r\n");

	preg_match("/<div class=\"form\">(.*)<\/div>/isU", $get_content, $out);

	echo $out[1];
}
catch(ExceptionObject $exc)
{
	require_once("admin/lib/exception_object_debug.inc");
}
catch(ExceptionMySQL $exc)
{
	require_once("admin/lib/exception_mysql_debug.inc");
}
catch(ExceptionMember $exc)
{
	require_once("admin/lib/exception_member_debug.inc");
}

?>
