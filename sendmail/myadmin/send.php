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

@set_time_limit(0);
ob_start();

require "class/class.exception_mysql.php";
require "class/class.exception_object.php";
require "class/class.exception_member.php";
require "class/class.libmail.php";

try
{
	if(!preg_match("|^[\d]*$|",$_GET['id_send'])) exit();

	require_once "lib/functions.inc";
	require_once "lib/connect.inc";
	require_once "lib/set.inc";
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

	$root = strpos($_SERVER["REQUEST_URI"], "admin");
	$dir = substr($_SERVER["REQUEST_URI"], 0, $root);
	$mailcount = 0;

	$query = "SELECT * FROM ".DB_SEND." WHERE id_send = ".$_GET['id_send'];
	$result = $dbh->query($query);

	if(!$result)
	{
		throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
	}

	$send = $result->fetch_array();

	$result->close();
	
	if($send['active'] == 'yes')
	{
		$query = "SELECT * FROM ".DB_CHAR." WHERE id_charset = ".$settings['id_charset'];
		$result = $dbh->query($query);

		if(!$result)
		{
			throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
		}

		$char = $result->fetch_array();
		$charset = $char['charset'];

		$result->close();

		$subject = $send['name'];
		$from = ($settings['from_mail'] == '' ? $_SERVER["SERVER_NAME"] : $settings['from_mail']);

		if($charset != CHARSET) {
			$from = iconv(CHARSET,$charset,$from);
			$subject = iconv(CHARSET,$charset,$subject);
			if(!empty($settings['organization'])) $settings['organization'] = iconv(CHARSET,$charset,$settings['organization']);
		}

		if($settings['interval_type'] == 'm')
		{
			$interval = "AND (time_send < NOW() - INTERVAL '".$settings['count_interval']."' MINUTE)";
		}
		else if($settings['interval_type'] == 'h')
		{
			$interval = "AND (time_send < NOW() - INTERVAL '".$settings['count_interval']."' HOUR)";
		}
		else if($settings['interval_type'] == 'd')
		{
			$interval = "AND (time_send < NOW() - INTERVAL '".$settings['count_interval']."' DAY)";
		}
		else { $interval = ''; }

		$limit = ($settings['send_limit'] == "yes" ? "LIMIT ".$settings['limit_number']."" : "");

		if($settings['many_send'] == "no") { 
	
			if($send['id_cat'] == 0) 
				$query_users = "SELECT *,u.id_user as id FROM ".DB_USERS." u LEFT JOIN ".DB_READY." r ON u.id_user=r.id_user AND r.id_send=".$_GET['id_send']." WHERE (r.id_user IS NULL) AND (status='active') ".$interval." ".$limit."";		
			else 
				$query_users = "SELECT *,u.id_user as id FROM ".DB_USERS." u 
					LEFT JOIN ".DB_SUB." s ON u.id_user=s.id_user
					LEFT JOIN ".DB_READY." r ON u.id_user=r.id_user AND r.id_send=".$_GET['id_send']." 
					WHERE (r.id_user IS NULL) AND (id_cat=".$send['id_cat'].") AND (status='active') ".$interval." 
					".$limit."";		
		}
		else
		{
			if($send['id_cat'] == 0) 
				$query_users = "SELECT *,id_user as id FROM ".DB_USERS." WHERE status='active' ".$interval." ".$limit."";
		
			else 
				$query_users = "SELECT *,u.id_user as id FROM ".DB_USERS." u LEFT JOIN ".DB_SUB." s ON u.id_user=s.id_user WHERE (id_cat=".$send['id_cat'].") AND (status='active') ".$interval."
				".$limit."";	
		}
	
		$result_users = $dbh->query($query_users);	
	
		if(!$result_users) throw new ExceptionMySQL($dbh->error,$query_users,"Error executing SQL query!");
	
		if($result_users->num_rows > 0)
		{
			$m = new Mail($charset);
			if($settings['show_email'] == "no") $m->From("".$from.";noreply@".$_SERVER['SERVER_NAME']."");
			else $m->From("".$from.";".$settings['email']."");
			$m->Subject($subject);
			if($send['prior'] == "1") $m->Priority(1);
			else if($send['prior'] == "2") $m->Priority(5);
			else $m->Priority(3);

			if($settings['reply'] == 'yes') $m->Receipt();
			if(!empty($settings['organization'])) $m->Organization($settings['organization']);

			if($settings['send_server'] == "2") {
				if($settings['smtp_ssl'] == "yes") $m->smtp_on("ssl://".$settings['smtp_host'], $settings['smtp_username'], $settings['smtp_password'], $settings['smtp_port'], $settings['smtp_timeout']);
				else $m->smtp_on($settings['smtp_host'], $settings['smtp_username'], $settings['smtp_password'], $settings['smtp_port'], $settings['smtp_timeout']);
			}
	
			if($settings['smtp_aut'] == 2) $m->Smtp_aut();	

			$query = "SELECT * FROM ".DB_ATTACH." WHERE id_send = ".$_GET['id_send'];
			$result_attach = $dbh->query($query);

			if(!$result_attach)  throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

			if($result_attach->num_rows>0)
			{
				while($row = $result_attach->fetch_array())
				{
					if($fp = @fopen($row['path'],"rb"))
					{
						$file = fread($fp, filesize($row['path']));

						fclose($fp);

						if($charset != CHARSET) { $row['name'] = iconv(CHARSET,$charset,$row['name']); }

						$ext = strrchr($row['path'], ".");
						$mime_type = get_mime_type($ext);

						$m->Attach($row['path'], $row['name'], $mime_type);
					}
				}
			}

			$result_attach->close();
		
			while($user = $result_users->fetch_array())
			{
				$cod = $user['cod'];
				$UNSUB = "http://".$_SERVER["SERVER_NAME"].$dir."unsubscribe.php?id=".$user['id']."&key=".$user['cod']."";
			
				//$user['name'] = iconv(CHARSET,$charset,$user['name']);
				if($user['name']) $m->To( "".$user['name'].";".$user['email']."" );
				else $m->To( $user['email'] );
			
				$unsublink = str_replace('%UNSUB%', $UNSUB, $settings['unsublink']);

				if($settings['unsubscribe'] == "yes" and !empty($settings['unsublink'])) { $msg = "".$send['message']."<br><br>".$unsublink.""; }
				else { $msg = $send['message']; }

				$msg = str_replace('%NAME%', $user['name'], $msg);
				$msg = str_replace('%DAYS%', $settings['day'], $msg);
				$msg = str_replace('%UNSUB%', $UNSUB, $msg);
				$msg = str_replace('%SERVER_NAME%', $_SERVER['SERVER_NAME'], $msg);

				if($charset != CHARSET) { $msg = iconv(CHARSET, $charset, $msg); }
				
				if($settings['ContentType'] == "1")
				{
					$msg = preg_replace('/<br(\s\/)?>/i', "\n", $msg);
					$msg = remove_html_tags($msg);
					$m->Body($msg);
				}
				else { $m->Body($msg, "html"); }			

				if($m->Send())
				{
					if($settings['many_send'] == "no")
					{				
						$insert = "INSERT INTO ".DB_READY." (id_ready_send,id_user,id_send) VALUES (0,".$user['id'].",".$send['id_send'].")";
						$result_insert = $dbh->prepare($insert);

						if($result_insert)
						{
							$result_insert->execute();
						}
						else
						{
							throw new ExceptionMySQL($dbh->error,$insert,"Error executing SQL query!");
						}					
					}

					$update = "UPDATE ".DB_USERS." SET time_send = NOW() WHERE id_user = ".$user['id']."";
					$dbh->query($update);	

					$mailcount = $mailcount+1;	
				}
				else
				{
					echo showerror($m->Show_error());
				}					
			}	
		}	
	}

	logsend($mailcount);

	echo $mailcount;

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