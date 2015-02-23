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
	require_once "templates/language/".$settings['language']."/edituser.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	if(!empty($_POST["action"]))
	{
		$_POST['name'] = htmlspecialchars(trim($_POST['name']));
		$_POST['email'] = strtolower(trim($_POST['email']));

		if(empty($_POST['name'])) error(MSG_NONAME);
		if(empty($_POST['email'])) error(MSG_NOEMAIL);

		if(check_email($_POST['email'] != true)) { error(MSG_WRONG_EMAIL); }

		$_POST['name'] = $dbh->real_escape_string($_POST['name']);
		$_POST['email'] = $dbh->real_escape_string($_POST['email']);
		$_POST['id_user'] = $dbh->real_escape_string($_POST['id_user']);

		$update = "UPDATE ".DB_USERS." SET name = '".$_POST['name']."',
											email = '".$_POST['email']."'
					WHERE id_user=".$_POST['id_user'];

		if($dbh->query($update))
		{
			$delete = "DELETE FROM ".DB_SUB." WHERE id_user = ".$_POST['id_user'];

			if(!$dbh->query($delete)) throw new ExceptionMySQL($dbh->error,$delete,"Error executing SQL query!");

			if($_POST['id_cat'])
			{
				foreach($_POST['id_cat'] as $id_cat)
				{
					if(preg_match("|^[\d]+$|",$id_cat))
					{
						$result=$dbh->prepare("INSERT INTO ".DB_SUB." (id_sub,id_user,id_cat)  VALUES (0, ".$_POST['id_user'].", ".$id_cat.")");
						$result->execute();
					}
				}
			}

			redirect(MSG_CHANGE,'users.php',2);
		}
		else
		{
			throw new ExceptionMySQL($dbh->error,$update,"Error executing SQL query!");
		}
	}
	else
	{
		if(!preg_match("|^[\d]*$|",$_GET['id_user'])) exit();

		include "top.php";

		$query = "SELECT * FROM ".DB_USERS." WHERE id_user=".$_GET['id_user'];
		$result = $dbh->query($query);

		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

		$row = $result->fetch_array();		

?>
<a href="users.php"><?php echo BACK; ?></a><br><br>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="id_user" value="<?php echo $row['id_user']; ?>">
<div class="tableform" style="width: 380px">
<table border="0"><tr>
<td width="130"><?php echo TABLECOLMN_NAME; ?></td>
<td width="250"><input size="30" type="text" name="name" value='<?php echo $row['name']; ?>'></td>
</tr>
<tr><td width="130"><?php echo TABLECOLMN_EMAIL; ?></td>
<td width="250"><input size="30" type="text" name="email" value='<?php echo $row['email']; ?>'></td>
</tr>
<tr><td width="130"><?php echo TABLECOLMN_CATEGORY; ?></td>
<td width="250">
<?php

		$result->close();

		$query = "SELECT * FROM ".DB_CAT." ORDER BY name";
		$result = $dbh->query($query);

		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

		while($category = $result->fetch_array())
		{
			$query = "SELECT id_user FROM ".DB_SUB." WHERE id_cat=".$category['id_cat']." AND id_user=".$_GET['id_user'];
			$result2 = $dbh->query($query);

			if(!$result2) throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

			if($result2->num_rows>0)
			{
				echo "<p><input type=\"checkbox\" value=\"".$category['id_cat']."\" name=\"id_cat[]\" checked>".$category['name']."</p>";
			}
			else { echo "<p><input type=\"checkbox\" value=\"".$category['id_cat']."\" name=\"id_cat[]\">".$category['name']."</p>"; }

			$result2->close();
		}

		$result->close();

?>
</td>
</tr>
<tr><td><input type="submit" name="action" class="inputsubmit" value="<?php echo EDIT; ?>"></td><td></td>
</tr></table>
</div>
</form>
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
