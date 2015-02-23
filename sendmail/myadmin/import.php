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
	require_once "templates/language/".$settings['language']."/import.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	$title = TITLE;

	if(empty($_POST["action"]))
	{
		include "top.php";

?>
<div class="tableform">
<form enctype='multipart/form-data' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="0"><tr>
<td width="30%"><?php echo TABLECOLMN_DATABASE_FILE; ?>:</td>
<td><input class="input" type="file" name="file" size="20"></td>
</tr>
<tr>
<td width="30%"><?php echo TABLECOLMN_CATEGORY; ?>:</td>
<td>
<?php

		$query = "SELECT *,cat.id_cat as id FROM ".DB_CAT." cat LEFT JOIN ".DB_SUB." subs ON cat.id_cat=subs.id_cat GROUP by id ORDER BY name";
		$result = $dbh->query($query);

		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

		while($category = $result->fetch_array())
		{
			echo "<p><input type=\"checkbox\" value=\"".$category['id']."\" name=\"id_cat[]\">".$category['name']."</p>";
		}

		$result->close();

?>
</td>
</tr>
<tr>
<td><input class="inputsubmit" type="submit" name="action" value="<?php echo ADD; ?>"></td>
</tr></table>
</form>
</div>
<?php

		include "bottom.php";
	}
	else
	{
		if(empty($_FILES['file']['tmp_name'])) error(MSG_ENTER_PATH_TO_FILE);
		if(!($fp = @fopen($_FILES['file']['tmp_name'],"rb")))
		{
			error(MSG_OPEN_FILE);
		}

		$buffer = fread($fp,filesize($_FILES['file']['tmp_name']));

		fclose($fp);

		$buffer = str_replace("'", "`",$buffer);
		$tok = strtok($buffer,"\n");
		$strtmp[] = $tok;

		while ($tok)
		{
			$tok = strtok("\n");
			$strtmp[] = $tok;
		}

		$count = 0;

		for($i=0; $i<count($strtmp); $i++)
		{
			$email = "";
			$name = "";

			preg_match('/([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)/uis', $strtmp[$i], $out);

			$email = $out[0];
			$name = str_replace($email,'',$strtmp[$i]);
			$email = strtolower($email);
			$name = trim($name);

			if(strlen($name)>150) { $name = ''; }

			if(!empty($email))
			{
				$query = "SELECT * FROM ".DB_USERS." WHERE email LIKE '".$email."'";
				$result = $dbh->query($query);

				if(!$result)
				{
					throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
				}

				if($result->num_rows>0) {}
				else
				{
					if(empty($name)) $name = '';
					$cod = getRandomCod();
					$count++;
					
					if(!get_magic_quotes_gpc())
					{
						$name = $dbh->real_escape_string($name);
					}

					$insert = "INSERT INTO ".DB_USERS." VALUES (0, '".$name."','".$email."','','".$cod."',NOW(),'active','0000-00-00 00:00:00');";
					$result2 = $dbh->prepare($insert);

					if(!$result2) throw new ExceptionMySQL($dbh->error,$insert,"Error executing SQL query!");

					$result2->execute();

					$id = $result2->insert_id;

					if($_POST['id_cat'])
					{
						foreach($_POST['id_cat'] as $id_cat)
						{
							if(preg_match("|^[\d]+$|",$id_cat))
							{
								$result3=$dbh->prepare("INSERT INTO ".DB_SUB." (id_sub,id_user,id_cat) VALUES (0, ".$id.", ".$id_cat.")");
								$result3->execute();
							}
						}
					}
				}

				$result->close();
			}
		}

		redirect("".MSG_ADD_DATA.": ".$count."",'import.php',2);
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