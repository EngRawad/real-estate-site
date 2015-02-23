<?php

//////////////////////////////////////
// PHP Newsletter v3.5.6            //
// (C) 2006-2013 Alexander Yanitsky //
// Website: http://janicky.com      //
// E-mail: janickiy@mail.ru         //
// Skype: janickiy                  //
//////////////////////////////////////

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
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div class="form">
<form action="sendmail.php" method="post" >
<?php

	$query = "SELECT * FROM ".DB_CAT."";
	$result = $dbh->query($query);

	if(!$result) { throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!"); }

	if($result->num_rows>0)
	{
		while($row = $result->fetch_array())
		{
			echo "<p><input type=\"checkbox\" value=\"".$row['id_cat']."\" name=\"id_cat[]\">".$row['name']."</p>";
		}
	}
?>
<table cellpadding="0" cellspacing="6">
<tr><td>Name</td><td><input size="30" type="text" name="name"></td></tr>
<tr><td>E-mail</td><td><input size="30" type="text" name="email"></td></tr>
<tr><td></td><td><input type="submit" value="Subscript"></td></tr>
<input type="hidden" name="action" value="post">
</table>
</form>
</div>
</body>
</html>
<?php

	$dbh->close();
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
