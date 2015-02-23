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
	require_once "templates/language/".$settings['language']."/export.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	$title = TITLE;

	if(empty($_POST["action"]))
	{
		include "top.php";

?>
<div class="tableform">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" target=_blank method="post">
	 <table border="0" cellpadding="5">
		<tr>
		  <td colspan="2"></td>
		</tr>
		<tr>
		  <td width="90"><?php echo TABLECOLMN_EXTENSION; ?>:</td>
		  <td><input size="3" name="ext" value="txt"></td>
		</tr>
		<tr>
		  <td width="90"><?php echo TABLECOLMN_FIELDS; ?>:</td>
		  <td><input type=radio checked value="1" name="pos_el">e-mail : name
		  <input type=radio value="2" name="pos_el">name : e-mail </td>
		</tr>
		<tr>
		  <td width="90"><?php echo TABLECOLMN_COMPRESSION; ?>:</td>
		  <td><input type=radio checked value="1" name="zip">
			 <?php echo TABLECOLMN_COMPRESSION_OPTION_1; ?>
			 <input type="radio" value="2" name="zip">
			 <?php echo TABLECOLMN_COMPRESSION_OPTION_2; ?></td>
		</tr>
		<tr>
			<td><input class="inputsubmit" name="action" type="submit" value="<?php echo APPLY; ?>"></td>
		</tr>
	 </table>
  </form>
</div>
<?php

		include "bottom.php";
	}
	else
	{
		if(empty($_POST['ext'])) error(MSG_ENTER_FILE_EXTENSION);

		$select = "SELECT name,email FROM ".DB_USERS." WHERE status = 'active'";
		$result = $dbh->query($select);

		if(!$result) throw new ExceptionMySQL($dbh->error,$select,"Error executing SQL query!");

		while($row = $result->fetch_array())
		{
			if($_POST['pos_el'] == 1)
			{
				$content .= "".$row['email']." ".$row['name']."\r\n";
			}
			else
			{
				$content .= "".$row['name']." ".$row['email']."\r\n";
			}
		}

		$result->close();
		
		$filename="export_email.".$_POST['ext']."";
		
		if($_POST['zip'] == 1)
		{
			header('Content-type: '.get_mime_type(".".$_POST['ext']).'');
			header('Content-Disposition: attachment; filename='.$filename.'');
			echo $content;
			exit();
		}
		else
		{
			header('Content-type: application/zip');
			header('Content-Disposition: attachment; filename=export_email.zip');

			$fout = fopen("php://output", "wb");
	
			if ($fout !== FALSE) {
				fwrite($fout, "\x1F\x8B\x08\x08".pack("V", '')."\0\xFF", 10);

				$oname = str_replace("\0", "", $filename);
				fwrite($fout, $oname."\0", 1+strlen($oname));

				$fltr = stream_filter_append($fout, "zlib.deflate", STREAM_FILTER_WRITE, -1);
				$hctx = hash_init("crc32b");
  
				if(!ini_get("safe_mode")) set_time_limit(0);
		 
				hash_update($hctx, $content);
				$fsize = strlen($content);
		
				fwrite($fout, $content, $fsize);

				stream_filter_remove($fltr);

				$crc = hash_final($hctx, TRUE);

				fwrite($fout, $crc[3].$crc[2].$crc[1].$crc[0], 4);
				fwrite($fout, pack("V", $fsize), 4);
				fclose($fout);
			}
	
			exit();
		}
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
