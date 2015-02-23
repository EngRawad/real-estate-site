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
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	$title = TITLE;

	if(!empty($_POST["action"]))
	{
		$_POST['name'] = htmlspecialchars(trim($_POST['name']));

		if(empty($_POST['name'])) error(MSG_NONAME);

		$_POST['name'] = $dbh->real_escape_string($_POST['name']);
		$_POST['id_cat'] = $dbh->real_escape_string($_POST['id_cat']);

		$query = "SELECT * FROM ".DB_CAT." WHERE id_cat!= ".$_POST['id_cat']." AND name LIKE '".$_POST['name']."'";
		$result = $dbh->query($query);

		if($result)
		{
			if($result->num_rows > 0)
			{
				error(MSG_CATEGORY_EXISTS);
			}
		}
		else
		{
			throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
		}

		$result->close();

		$update = "UPDATE ".DB_CAT." SET name='".$_POST['name']."' WHERE id_cat=".$_POST['id_cat'];

		if($dbh->query($update))
		{
			redirect(MSG_CHANGE,'category.php',2);
		}
		else
		{
			throw new ExceptionMySQL($dbh->error,$update,"Error executing SQL query!");
		}
	}
	else
	{
		if(!preg_match("|^[\d]*$|",$_GET['id_cat'])) exit();

		$query = "SELECT name FROM ".DB_CAT." WHERE id_cat=".$_GET['id_cat'];
		$result = $dbh->query($query);

		if($result)
		{
			$row = $result->fetch_array();
		}
		else
		{
			throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
		}

		$result->close();

		include "top.php";

?>
<a href="category.php"><?php echo BACK; ?></a><br>
<br>
<div class="tableform" style="width: 330px">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=post>
  	<input type="hidden" name="id_cat" value="<?php echo $_GET['id_cat']; ?>">
	<input type="hidden" name="action" value="post">
	 <table border="0">
		<tr>
		  <td width="130"><?php echo TABLECOLMN_NAME; ?></td>
		  <td width="250"><input size="20" type="text" name="name" value="<?php echo $row['name']; ?>"></td>
		</tr>
		<tr>
		  <td><input type="submit" class="inputsubmit" value="<?php echo EDIT; ?>"></td>
		  <td>&nbsp;</td>
		</tr>
	 </table>
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