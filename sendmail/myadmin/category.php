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
	require_once "templates/language/".$settings['language']."/category.inc";
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

	include "top.php";

?>
<table class="cattab content" cellSpacing="1" cellPadding="5" border="0" width="100%"><tr>
<td class="catmenu toptab"><?php echo TABLECOLMN_POS; ?></td>
<td class="catmenu toptab" align="middle"><?php echo TABLECOLMN_NAME; ?></td>
<td class="catmenu toptab" align="middle"><?php echo TABLECOLMN_NUMBER_SUBSCRIBERS; ?></td>
<td class="catmenu toptab" align="middle"><?php echo EDIT; ?></td>
<td class="catmenu toptab" align="middle"><?php echo REMOVE; ?></td>
</tr>
<?php

	$query = "SELECT * FROM ".DB_CAT." ORDER BY name";
	$result = $dbh->query($query);

	if(!$result)
	{
		throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
	}

	$i = 1;

	while($row = $result->fetch_array())
	{
		$query = "SELECT COUNT(*) FROM ".DB_SUB." WHERE id_cat = ".$row['id_cat'];
		$result_count = $dbh->query($query);

		if(!$result_count)
		{
			throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
		}

		$count = $result_count->fetch_assoc();
		$result_count->close();

		echo "<tr class=trcat>
		<td width=12 align=middle>".($i++).".</td>
		<td align=middle>".$row['name']."</td>
		<td align=middle>".$count['COUNT(*)']."</td>
		<td align=middle><a title='".EDIT."' href=\"edit_category.php?id_cat=".$row['id_cat']."\"><img border=\"0\" src=\"images/edit.gif\" width=\"24\" height=\"24\"></a></td>";

		if($count['COUNT(*)']>0)
		{
			echo "<td align=middle><a title=\"".REMOVE."\" href=\"del_category.php?id_cat=".$row['id_cat']."\" onclick=\"return confirm('".ALERT_REMOVE."');\"><img border=\"0\" src=\"images/delete.gif\" width=\"24\" height=\"24\"></a></td>";
		}
		else echo "<td align=middle><a title=\"".REMOVE."\" href=\"del_category.php?id_cat=".$row['id_cat']."\"><img border=\"0\" src=\"images/delete.gif\" width=\"24\" height=\"24\"></a></td>";
	}

	$result->close();

?>
</tr></table><br>
<form action="add_category.php" method=post>
<input type="submit" class="button" value="<?php echo ADD_CATEGORY; ?>">
</form>
<?php

	$dbh->close();

	include "bottom.php";
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
