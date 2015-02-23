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

ob_start();

require "class/class.exception_mysql.php";
require "class/class.exception_object.php";
require "class/class.exception_member.php";

try
{
	require_once "lib/functions.inc";
	require_once "lib/connect.inc";
	require_once "lib/set.inc";
	require_once "templates/language/".$settings['language']."/add_category.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	//require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	require_once("include/membersite_config.php");
	if(!$fgmembersite->CheckLogin()) {
		echo "<html><head>";
		echo '<meta http-equiv="refresh" content="1; url=/admin/login.php">';
		echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">";
		echo "</head><body>";
		echo "</body></html>";
    	exit;
		}

	$title = TITLE;

	if(!empty($_POST["action"]))
	{
		$_POST['name'] = trim(htmlspecialchars($_POST['name']));

		if(empty($_POST['name'])) error(MSG_NONAME);

		$_POST['name'] = $dbh->real_escape_string($_POST['name']);

		$query = "SELECT * FROM ".DB_CAT." WHERE name LIKE '".$_POST['name']."'";
		$result = $dbh->query($query);

		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

		if($result->num_rows > 0)
		{
			error(MSG_CATEGORY_EXISTS);
		}

		$result->close();

		$insert = "INSERT INTO ".DB_CAT." (id_cat, name) VALUES (0,'".$_POST['name']."');";
		$result = $dbh->prepare($insert);

		if($result)
		{
			$result->execute();

			$dbh->close();

			redirect(MSG_ADD_CATEGORY,'category.php',2);
		}
		else
		{
			throw new ExceptionMySQL($dbh->error,$insert,"Error executing SQL query!");
		}
	}
	else
	{
		include "top.php";

?>
<a href="category.php"><?php echo BACK; ?></a><br><br>
<div class="tableform" style="width: 330px">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=post>
<input type="hidden" name="action" value="post">
<table border="0"><tr>
<td width="130"><?php echo TABLECOLMN_NAME; ?></td>
<td width="200"><input size="20" type="text" name="name" value='<?php echo $_POST['name']; ?>'></td>
</tr>
<tr>
<td><input type="submit" class="inputsubmit" value="<?php echo ADD; ?>"></td>
</tr></table>
</form>
</div>
<?php

		include "bottom.php";
	}

	$dbh->close();
}
catch(ExceptionObject $exc)
{
	require_once("lib/exception_object_debug.inc");
}
catch(ExceptionMySQL $exc)
{
	require_once("lib/exception_mysql_debug.inc");
}
catch(ExceptionMember $exc)
{
	require_once("lib/exception_member_debug.inc");
}

?>
