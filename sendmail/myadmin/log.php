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
	require_once "templates/language/".$settings['language']."/log.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	$title = TITLE;

	$pnumber = 20;

	$page = $_GET['page'];
	if(empty($page)) $page = 1;
	$begin = ($page - 1)*$pnumber;

	include "top.php";

	$query =  "SELECT *,DATE_FORMAT(time,'%d.%m.%Y %H:%i') as send_time FROM ".DB_LOG." ORDER BY id_log desc LIMIT ".$begin.", ".$pnumber."";
	$result = $dbh->query($query);

	if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

?>
<table class="cattab content" cellspacing="1" cellpadding="3" border="0" width="100%">
<tr align="center">
<td class="catmenu"><?php echo TABLECOLMN_TIME; ?></td>
<td class="catmenu"><?php echo TABLECOLMN_SENT; ?></td>
</tr>
<?php

	while($row = $result->fetch_array())
	{

?>
<tr class=trcat>
	<td><?php echo $row['send_time']; ?></td>
	<td><?php echo $row['count']; ?></td>
</tr>
<?php

	}

	$result->close();

?>
</table>
<?php

	$query = "SELECT COUNT(*) FROM ".DB_LOG."";
	$result = $dbh->query($query);

	if(!$result)
	{
		 throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
	}

	$total = $result->fetch_assoc();

	$result->close();

	$number = intval(($total['COUNT(*)'] - 1) / $pnumber) + 1;

	if($page != 1) $pervpage = '<a href=log.php?page=1>&lt;&lt;</a>
										 <a href=log.php?page='.($page - 1).'>&lt;</a>';

	if($page != $number) $nextpage = ' <a href=log.php?page='.($page + 1).'>&gt;</a>
												  <a href=log.php?page='.$number.'>&gt;&gt;</a>';

	if($page - 2 > 0) $page2left = ' <a href=log.php?page='.($page - 2).'>...'.($page - 2).'</a> | ';
	if($page - 1 > 0) $page1left = ' <a href=log.php?page='.($page - 1).'>'.($page - 1).'</a> | ';
	if($page + 2 <= $number) $page2right = ' | <a href=log.php?page='.($page + 2).'>'.($page + 2).'...</a>';
	if($page + 1 <= $number) $page1right = ' | <a href=log.php?page='.($page + 1).'>'.($page + 1).'</a>';

	echo "<p>".PAGES.":&nbsp;&nbsp;";
	echo $pervpage.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$nextpage;
	echo "</p>";

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