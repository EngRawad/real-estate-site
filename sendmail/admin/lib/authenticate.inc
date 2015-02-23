<?php

//////////////////////////////////////
// PHP Newsletter v3.5.4            //
// (C) 2006-2013 Alexander Yanitsky //
// Website: http://janicky.com      //
// E-mail: janickiy@mail.ru         //
// Skype: janickiy                  //
//////////////////////////////////////

session_start();

$query = "SELECT * FROM ".DB_AUT."";
$result = $dbh->query($query);

if(!$result)
{
	throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
}

$aut = $result->fetch_array();
$passw_aut = $aut['passw'];

$result->close();

if(!empty($_POST['admin']))
{
	if($_SESSION['sess_admin'] != "ok")
	{
		$sess_pass = md5(trim($_POST['password']));
	}

	if($sess_pass === $passw_aut)
	{
		$_SESSION['sess_admin'] = "ok";
	}
	else
	{

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?php echo AUT_TITLE_INCORRECT_AUTHENTICATION; ?></title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
</head>
<body>
<script type="text/javascript">
window.alert('<?php echo AUT_ALERT; ?>');
window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>';
</script>
</body>
</html>
<?php

		exit();
	}
}
else
{
	if($_SESSION['sess_admin'] != "ok")
	{

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?php echo AUT_TITLE; ?></title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<link rel="StyleSheet" type="text/css" href="style.css">
</head>
<body>
<div class="block-on-center">
<div class="aut">
<form method="post">
<table cellspacing="2" cellpadding="4" border="0" width="300"><tr>
<td width="15" rowspan="2"><img border="0" src="images/key.gif" width="35" height="40"></td>
<td width="150"><b><?php echo AUT_ENTER_PASSWD; ?>:</b></td>
<td width="150"><input type="password" name="password" size="12"></td>
</tr>
<tr><td width="300" colspan="2" valign="middle"><input type="submit" class="button" name="admin" value=" OK "></td>
</tr></table>
</form>
</div>
</div>
</body>
</html>
<?php

		exit();
	}
}

?>
