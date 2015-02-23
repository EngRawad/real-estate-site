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
	$error = "";
	$action = "";
	$action = $_POST["action"];

	require_once "lib/functions.inc";
	require_once "lib/connect.inc";
	require_once "lib/set.inc";
	require_once "templates/language/".$settings['language']."/change.inc";
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

	if(!empty($action))
	{
		$password = $_POST["password"];
		$password_again = $_POST["password_again"];
		$sess_password = $_POST["sess_password"];

		if(empty($_POST["sess_password"]))
		{
			$action = "";
			$error = $error."<li>".MSG_ENTER_CURRENT_PASSWD."</li>";
		}

		if(empty($_POST["password"]))
		{
			$action = "";
			$error = $error."<li>".MSG_PASSWORD_ISNT_ENTERED."</li>";
		}

		if(empty($_POST["password_again"]))
		{
			$action = "";
			$error = $error."<li>".MSG_REENTER_PASSWORD."</li>";
		}

		if(!empty($_POST["password"]) and !empty($_POST["password_again"]))
		{
			if($password != $password_again)
			{
				$action = "";
				$error = $error."<li>".MSG_PASSWORDS_DONT_MATCH."</li>";
			}
		}

		if(!empty($_POST["sess_password"]))
		{
			$sess_password = md5(trim($sess_password));

			if($passw_aut != $sess_password)
			{
				$action = "";
				$error = $error."<li>".MSG_CURRENT_PASSWD_INCORRECT."</li>";
			}
		}

		if(empty($error))
		{
			$password = md5(trim($password));

			$update = "UPDATE ".DB_AUT." SET passw='".$password."'";

			if($dbh->query($update))
			{
				redirect(PASSWD_CHANGED,'index.php',2);
			}
			else
			{
				throw new ExceptionMySQL($dbh->error,$update,"Error executing SQL query!");
			}
		}
	}

	if(empty($action))
	{
		require "top.php";

?>
<p><?php echo ENTER_NEW_PASSWORD; ?></p>
<div class="tableform" style="width: 330px">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="0">
<tr><td><?php echo TABLECOLMN_CURRENT_PASSWD; ?>:</td><td><input type="password" name="sess_password" maxlength="40" size="25"></td></tr>
<tr><td><?php echo TABLECOLMN_PASSWD; ?>:</td><td><input type="password" name="password" maxlength="40" size="25"></td></tr>
<tr><td><?php echo TABLECOLMN_AGAIN_PASSWD; ?>:</td><td><input type="password" name="password_again" maxlength="40" size="25"></td></tr>
<tr><td></td><td><input class="inputsubmit" type="submit" value="<?php echo SAVE; ?>"><input type="hidden" name="action" value="post"></td>
</tr></table>
</form>
</div>
<?php

		if(!empty($error))
		{
			echo "<p class=error>".IDENTIFIED_FOLLOWING_ERRORS.": </p>";
			echo "<ul class=error>";
			echo $error;
			echo "</ul>";
		}

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
