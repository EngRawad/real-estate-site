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

require "class/class.exception_mysql.php";
require "class/class.exception_object.php";
require "class/class.exception_member.php";

try
{
	require_once "lib/functions.inc";
	require_once "lib/connect.inc";
	require_once "lib/set.inc";
	require_once "templates/language/".$settings['language']."/ip.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	if(!empty($_GET['ip']))
	{
		$title = TITLE;

		include "top.php";

?>
<table class="cattab content" cellspacing="1" cellpadding="3" border="0" width="100%"><tr align="center">
<td class="catmenu menu"><?php echo TITLE; ?></td>
</tr>
<?php

		$sock = @fsockopen("whois.ripe.net",43,$errno,$errstr);

		if(!$sock)
		{
			echo("$errno($errstr)");
		}
		else
		{
			fputs ($sock, $_GET['ip']."\r\n");

			while (!feof($sock))
			{
				echo "<tr class=trcat><td>";
				echo str_replace(":",":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ,fgets ($sock,128))."<br>";
				echo "</td></tr>";
			}
			echo "</table>";
		}

		fclose($sock);

		include "bottom.php";
	}
	else
	{
		error(MSG_SERVICE_ISNT_AVAILABLE);
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
