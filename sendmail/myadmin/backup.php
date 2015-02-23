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
	require_once "templates/language/".$settings['language']."/backup.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	$title = TITLE;

	include "top.php";

	if(!isset($_GET['action']))
	{

?>
<p><?php echo SELECT_ACTIONS; ?></p>
<ul>
<li><a href="backup.php?action=backup" title="<?php echo CREATE_BACKUP; ?>"><?php echo CREATE_BACKUP; ?></a></li>
<li><a href="backup.php?action=download" title="<?php echo DOWNLOAD_PACKED_BACKUP; ?>"><?php echo DOWNLOAD_PACKED_BACKUP; ?></a></li>
<li><a href="backup.php?action=remove" title="<?php echo REMOVE_BACKUP_DIRECTORY; ?>" onclick="return confirm('<?php echo CONFIRM_REMOVE_DIRECTORY; ?>');"><?php echo REMOVE_BACKUP_DIRECTORY; ?></a></li>
</ul>
<?php

	}

	if($_GET["action"] == "backup")
	{
		$rnd = getRandomCod();

		@chmod("backup", 0777);

		$folder = "backup/".date("d_m_Y", microtime(time()));
		$makefolder = @mkdir($folder, 0777);
		$result_t = $dbh->query("show tables;");

		echo "<p class=msg>";

		$zapros_table = "";
		$string_query = "";

		while($tables = $result_t->fetch_array())
		{
			$prim_k = "";
			$query_t_struc = $dbh->query("DESCRIBE ".$tables['Tables_in_'.$db_name].";");
			$query = "\r\n--\r-- table structure `".$tables['Tables_in_'.$db_name]."`\r--\r\n\r\nCREATE TABLE IF NOT EXISTS ".$tables['Tables_in_'.$db_name]." (";

			if("".DB_AUT."" == $tables['Tables_in_'.$db_name] OR "".DB_ATTACH."" == $tables['Tables_in_'.$db_name] OR "".DB_CAT."" == $tables['Tables_in_'.$db_name] OR "".DB_CHAR."" == $tables['Tables_in_'.$db_name] OR "".DB_SETTING."" == $tables['Tables_in_'.$db_name] OR "".DB_SUB."" == $tables['Tables_in_'.$db_name] OR "".DB_READY."" == $tables['Tables_in_'.$db_name] OR "".DB_SEND."" == $tables['Tables_in_'.$db_name] OR "".DB_LOG."" == $tables['Tables_in_'.$db_name] OR "".DB_USERS."" == $tables['Tables_in_'.$db_name])
			{
				$table_name = $tables['Tables_in_'.$db_name];

				$result = $dbh->query("DESCRIBE ".$table_name.";");
				$column_num = 0;

				while($describe = $result->fetch_array())
				{
					if($describe[1] == "datetime" || $describe[1] == "text") $kav[$column_num] = 1;
					else $kav[$column_num] = 0;

					$column_num++;
				}

				$result->close();

				$result_column = $dbh->query("select * from ".$table_name.";");
				$result = $dbh->query("select count(*) from ".$table_name.";");
				$count_row = $result->fetch_array();

				$result->close();

				if($count_row[0]!= 0)
				{
					$zapros = "";

					while($column = $result_column->fetch_array())
					{
						$column_string = "";

						for($z = 0; $z<$column_num; $z++)
						{
							if($z<($column_num-1))
							{

								if($kav[$z] == 1) $column_string = $column_string."'".$column[$z]."', ";
								else $column_string = $column_string."'".$column[$z]."', ";
							}
							else
							{
								if($kav[$z] == 1) $column_string = $column_string."'".$column[$z]."'";
								else $column_string = $column_string."'".$column[$z]."'";
							}
						}

						$zapros[] = "\r\nINSERT INTO ".$table_name." values(".$column_string.");\r";
					}

					$result_column->close();

					$string = "";

					for($i = 0; $i<count($zapros); $i++)
					{
						$string = $string.$zapros[$i]."";
					}

					$string_query .= "--\r-- Table dump `".$table_name."`\r--\r\n".$string."\r\n";
				}

				if($query_t_struc->num_rows > 1)
				{
					for($i=0; $i<$query_t_struc->num_rows; $i++)
					{
						if($i<($query_t_struc->num_rows-1))
						{
							$t_str = $query_t_struc->fetch_array();
							$t = "";

							if($t_str['Key'] == "PRI") $prim_k = $t_str['Field'];
							if($t_str['Null'] == "") $t = "not null";

							$query = $query.$t_str['Field']." ".$t_str['Type']." ".$t." ".$t_str['Extra'].", ";
						}
						else
						{
							$t_str = $query_t_struc->fetch_array();
							$t = "";

							if($t_str['Key'] == "PRI") $prim_k = $t_str['Field'];
							if($t_str['Null'] == "") $t = "not null";

							$query = $query.$t_str['Field']." ".$t_str['Type']." ".$t." ".$t_str['Extra']." ";
						}
					}
				}

				if($query_t_struc->num_rows == 1)
				{
					$t_str = $query_t_struc->fetch_array();
					$t = "";

					if($t_str['Null'] == "") $t = "not null";
					$query = $query.$t_str['Field']." ".$t_str['Type']." ".$t." ".$t_str['Extra']."";
				}

				if($prim_k != "") $zapros_table = $zapros_table.$query." , Primary key (".$prim_k.")) ENGINE=MyISAM;\r";
				else  $zapros_table = $zapros_table.$query.") ENGINE=MyISAM;\r";
			}

			$query_t_struc->close();
		}

		$result_t->close();

		$zapros_table = preg_replace("/\s+,/", ",", $zapros_table);
		$file_t = fopen($folder."/dump.sql", 'w');

		fputs($file_t, $zapros_table);
		fputs($file_t, $string_query);

		fclose($file_t);

		$dir = opendir("backup/");

		while($line = readdir($dir))
		{
			$packing = explode("_",$line);

			if(is_dir("backup/".$line) && $line != "." && $line != ".." && $packing[(count($packing)-1)]!= "pack")
			{
				$dir_file = opendir("backup/".$line);

				while($files = readdir($dir_file))
				{
					if(is_file("backup/".$line."/".$files))
					{
						$string = "";
						$query_file = file("backup/".$line."/".$files);

						for($i = 0; $i<count($query_file); $i++)
						{
							$string = $string.$query_file[$i];
						}

						@mkdir("backup/".$line."_".$rnd."_pack/", 0777);

						$zp = gzopen("backup/".$line."_".$rnd."_pack/".$files.".gz", "w9");

						gzwrite($zp, $string);
						gzclose($zp);

						$msg = str_replace('%FILENAME%', "backup/".$line."_".$rnd."_pack/".$files.".gz", GZIP_PACK_MSG);

						echo $msg;

						@unlink("backup/".$line."/".$files);
					}
				}

				closedir($dir_file);

				rmdir("backup/".$line);
			}
		}
		echo "".MSG_REQUEST_IS_READY." ".$folder.$line."_".$rnd."_pack/dump.sql</p>";
		echo "<script type='text/javascript'>setTimeout(\"document.location=\\\"backup.php\\\";\",3000);</script>";
	}

	if($_GET["action"] == "remove")
	{
		echo "<p class=msg>";

		$dir = opendir("backup/");

		while($line = readdir($dir))
		{
			if(is_dir("backup/".$line) && $line != "." && $line!="..")
			{
				remove_dir("backup/".$line, REMOVE_DIR_MSG);
			}
		}

		echo "<br /><script type='text/javascript'>setTimeout(\"document.location=\\\"backup.php\\\";\",3000);</script>";
	}

	if($_GET["action"] == "download")
	{
		echo "<a href=backup.php>".BACK."</a>";

		$dir = opendir("backup/");

		while($line = readdir($dir))
		{
			$packing = explode("_",$line);

			if(is_dir("backup/".$line) && $line != "." && $line != ".." && $packing[(count($packing)-1)] == "pack")
			{
				preg_match("/(\d{2})_(\d{2})_(\d{4})\w+_pack/", $line, $date);

				echo "<h5><hr align=left width='40%'>".DIRECTORY_BACKUP.": <i>backup/".$line."/</i><br />
				".DATECREATION_BACKUP.": <i>".$date[1].".".$date[2].".".$date[3]."</i></h5>";

				$dir_file = opendir("backup/".$line);

				while($files = readdir($dir_file))
				{
					if(is_file("backup/".$line."/".$files))  echo "<a href='backup/".$line."/".$files."' title='".TO_DOWNLOAD_CLICK_LINK."'>".$files."</a>\n<br />\n";
				}

				echo "<br /><br />";

				closedir($dir_file);
			}
		}
	}

	include "bottom.php";

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
