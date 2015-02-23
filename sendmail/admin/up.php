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
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";
	
	if(!preg_match("|^[\d]*$|",$_GET['id_send'])) exit();

	$query = "SELECT * FROM ".DB_SEND." ORDER BY pos DESC";
	$result = $dbh->query($query);

	if($result)
	{
		while($row = $result->fetch_array())
		{
			if($row["id_send"] == $_GET['id_send'])
			{
				$pos = $row["pos"];
				$row = $result->fetch_array();
				$id_sendnext = $row["id_send"];
				$posnext = $row["pos"];
			}
		}
	}
	else
	{
		throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
	}

	$result->close();

	if($id_sendnext)
	{
		$query1 = "UPDATE ".DB_SEND." SET pos = ".$pos." WHERE id_send = ".$id_sendnext."";
		$query2 = "UPDATE ".DB_SEND." SET pos = ".$posnext." WHERE id_send = ".$_GET['id_send'];

		if($dbh->query($query1) AND $dbh->query($query2))
		{
			$dbh->close();

			header("Location: ".$_SERVER["HTTP_REFERER"]."");
			exit();
		}
		else
		{
			throw new ExceptionMySQL($dbh->error,'',"Error executing SQL query!");
		}
	}

	$dbh->close();

	header("Location: ".$_SERVER["HTTP_REFERER"]."");
	exit();
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
