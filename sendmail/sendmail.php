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
require "admin/class/class.libmail.php";

try
{
	require_once "admin/lib/functions.inc";
	require_once "admin/lib/connect.inc";
	require_once "admin/lib/set.inc";
	require "admin/templates/language/".$settings['language']."/language.inc";

	$query = "SELECT * FROM ".DB_CHAR." WHERE id_charset = ".$settings['id_charset'];
	$result = $dbh->query($query);

	if(!$result)
	{
		throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
	}

	$char = $result->fetch_array();
	$charset = $char['charset'];

	$result->close();

	if(empty($_POST['name'])) error(MSG_NONAME);
	if(empty($_POST['email'])) error(MSG_NOEMAIL);

	$_POST['name'] = htmlspecialchars(trim($_POST['name']));
	$_POST['email'] = strtolower(htmlspecialchars(trim($_POST['email'])));

	if(check_email($_POST['email']) != true) { error(MSG_WRONG_EMAIL); }

	$ip = getenv("REMOTE_ADDR");
	$cod = getRandomCod();
	$urlpath = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];

	$query = "SELECT * FROM ".DB_USERS." WHERE email LIKE '".$_POST['email']."'";
	$result = $dbh->query($query);

	if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

	if($result->num_rows > 0)
	{
		error(MSG_SUB_ALREADY_DONE);
	}

	$result->close();

	$_POST['name'] = $dbh->real_escape_string($_POST['name']);
	$_POST['email'] = $dbh->real_escape_string($_POST['email']);
	$_POST['id_category'] = $dbh->real_escape_string($_POST['id_category']);

	if($settings['del'] == "yes") 
		$active = 'noactive';
	else 
		$active = 'active';

	$insert = "INSERT INTO ".DB_USERS." VALUES (0,
												'".$_POST['name']."',
												'".$_POST['email']."',
												'".$ip."',
												'".$cod."',
												NOW(),
												'".$active."',
												'0000-00-00 00:00:00')";

	$result = $dbh->prepare($insert);

	if(!$result) throw new ExceptionMySQL($dbh->error,$insert,"Error executing SQL query!");

	$result->execute();
	$id = $result->insert_id;

	if($_POST['id_cat'])
	{
		foreach($_POST['id_cat'] as $id_cat)
		{
			if(preg_match("|^[\d]+$|",$id_cat))
			{
				$result=$dbh->prepare("INSERT INTO ".DB_SUB." VALUES (0, ".$id.", ".$id_cat.")");
				$result->execute();
			}
		}
	}

	$CONFIRM = "http://".$_SERVER["SERVER_NAME"].root()."subscribe.php?status=active&id=".$id."&key=".$cod."";
	$UNSUB = "http://".$_SERVER["SERVER_NAME"].root()."unsubscribe.php?id=".$id."&key=".$cod."";
	
	if(empty($settings['from_mail']))
	{
		$from_mail = $_SERVER["SERVER_NAME"];
	}
	else
	{
		$from_mail = $settings['from_mail'];
	}

	$settings['textconfirmation'] = str_replace('%NAME%', $_POST['name'], $settings['textconfirmation']);
	$settings['textconfirmation'] = str_replace('%DAYS%', $settings['day'], $settings['textconfirmation']);
	$settings['textconfirmation'] = str_replace('%CONFIRM%', $CONFIRM, $settings['textconfirmation']);
	$settings['textconfirmation'] = str_replace('%UNSUB%', $UNSUB, $settings['textconfirmation']);
	$settings['textconfirmation'] = str_replace('%SERVER_NAME%', $_SERVER['SERVER_NAME'], $settings['textconfirmation']);

	if($charset != CHARSET) {
		$settings['textconfirmation'] = iconv(CHARSET, $charset, $settings['textconfirmation']);
		$settings['subjecttextconfirm'] = iconv(CHARSET, $charset, $settings['subjecttextconfirm']);
		if(!empty($settings['organization'])) $settings['organization'] = iconv(CHARSET,$charset,$settings['organization']);
		$from_mail = iconv(CHARSET,$charset,$from_mail);
	}

	$m = new Mail($charset);

	if($settings['del'] == "yes")
	{
		if($settings['show_email'] == "no") $m->From("".$from_mail.";noreply@".$_SERVER['SERVER_NAME']."");
		else $m->From("".$from_mail.";".$settings['email']."");

		$m->Subject($settings['subjecttextconfirm']);
		if(!empty($settings['organization'])) $m->Organization($settings['organization']);
		$m->To($_POST['email']);
		$m->Body($settings['textconfirmation']);

		$m->Send();
	}

	if($settings['newsubscribernotify'] == 'yes')
	{
		$subject = iconv(CHARSET,$charset,SUBJECT_NOTIFICATION_NEWUSER);
	
		$msg = "".MSG_NOTIFICATION_NEWUSER."\nName: ".$_POST['name']." \nE-mail: ".$_POST['email']."\n";
		$msg = str_replace('%SITE%', $_SERVER['SERVER_NAME'], $msg);
		
		if($charset != CHARSET) $msg = iconv(CHARSET,$charset,$msg);

		$m->From($settings['email']);
		$m->To($settings['email']);
		$m->Subject($subject);
		$m->Body($msg);
		$m->Send();
	}

	echo '<!DOCTYPE html>';
	echo "<html>\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
	echo "<title>".SENDMAIL_SUBJECT."</title>\n";
	echo "</head>\n";
	echo "<body>\n";
	if($settings['del'] == "yes") echo "<center><br>".SENDMAIL_MSG_SUB1."<br><br>\n";
	else echo "<center><br>".SENDMAIL_MSG_SUB2."<br><br>\n";
	echo "<a href=javascript:history.go(-1);>".BACK."</a><br>\n";
	echo "<a href=http://".$_SERVER['SERVER_NAME'].">".SENDMAIL_ON_MAINPAGE."</a><br>\n";
	echo "</center>\n";
	echo "</body>\n";
	echo "</html>";
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