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
	require_once "templates/language/".$settings['language']."/del_category.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	if(!preg_match("|^[\d]*$|",$_GET['id_cat'])) exit();

	$delete = "DELETE FROM ".DB_CAT." WHERE id_cat=".$_GET['id_cat'];

	if($dbh->query($delete))
	{
		$query2 = "DELETE FROM ".DB_SUB." WHERE id_cat=".$_GET['id_cat'];
		$dbh->query($query2);

		redirect(MSG_REMOVE_CATEGORY,$_SERVER["HTTP_REFERER"],2);
	}
	else
	{
		throw new ExceptionMySQL($dbh->error,$delete,"Error executing SQL query!");
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