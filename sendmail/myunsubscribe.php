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
	require_once "admin/lib/set.inc";
	require "admin/templates/language/".$settings['language']."/language.inc";

	if(!preg_match("|^[\d]*$|",$_GET['id'])) exit();
	
	if(empty($_GET['id'])) error(UNSUBSCRIBE_MSG_ERROR);
	if(empty($_GET['key'])) error(UNSUBSCRIBE_MSG_ERROR);

	$query = "SELECT cod FROM ".DB_USERS." WHERE id_user=".$_GET['id'];
	$result = $dbh->query($query);

	if(!$result)
	{
		throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
	}

	$user = $result->fetch_array();

	$result->close();

	if($user['cod'] == $_GET['key'])
	{
		$delete = "DELETE FROM ".DB_USERS." WHERE id_user=".$_GET['id'];

		if($dbh->query($delete))
		{
			$delete = "DELETE FROM ".DB_SUB." WHERE id_user=".$_GET['id'];

			if($dbh->query($delete))
			{		
				echo '<!DOCTYPE html>';
				echo "<html>\n";
				echo "<head>\n";
				echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
				echo "<title>".UNSUBSCRIBE_SUBJECT."</title>\n";
				echo "</head>\n";
				echo "<body>\n";
				echo "<center><br>".UNSUBSCRIBE_MSG_UNSUB."<br></center>\n";
				echo "</body>\n";
				echo "</html>";
			}
			else
			{
				throw new ExceptionMySQL($dbh->error,$delete,"Error executing SQL query!");
			}
		}
		else
		{
			throw new ExceptionMySQL($dbh->error,$delete,"Error executing SQL query!");
		}
	}
	else error(UNSUBSCRIBE_MSG_ERROR);	
	
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