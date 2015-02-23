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
	require_once "templates/language/".$settings['language']."/settings.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	$title = TITLE;

	if(empty($_POST["action"]))
	{
		include "top.php";

?>
<script type=text/javascript>

function smtp(form)
{
	if(form.smtp_host.value == "") { alert("<?php echo ALERT_ENTER_SMTP_HOST; ?>"); }
	if(form.smtp_port.value == "") { alert("<?php echo ALERT_ENTER_SMTP_PORT; ?>"); }
}

function dflt()
{
	document.forms[0].count_send.value = '5';
	document.forms[0].count_user.value = '20';
	document.forms[0].email.value = 'admin@mysite.com';
	document.forms[0].from.value = '<?php echo $_SERVER['SERVER_NAME']; ?>';
	document.forms[0].organization.value = '';
	document.forms[0].smtp_host.value = 'smtp.gmail.com';
	document.forms[0].smtp_username.value = '';
	document.forms[0].smtp_password.value = '';
	document.forms[0].id_charset.value = '1';
	document.forms[0].smtp_port.value = '25';
	document.forms[0].subjecttextconfirm.value = '<?php echo SUBJECTTEXTCONFIRM; ?>';
	document.forms[0].unsublink.value = '<?php echo UNSUBLINK; ?>';
	document.forms[0].textconfirmation.value = '<?php echo TEXTCONFIRMATION; ?>';
	document.forms[0].smtp_aut[0].checked = true;
	document.forms[0].smtp_ssl.checked = false;
	document.forms[0].smtp_timeout.value = 5;
	document.forms[0].show_email.checked = false;
	document.forms[0].newsubscribernotify.checked = false;
	document.forms[0].unsubscribe.checked = true;
	document.forms[0].reply.checked = false;
	document.forms[0].count_interval.value = '1';
	document.forms[0].interval_type.value = '0';
	document.forms[0].many_send.checked = true;
	document.forms[0].limit_number.value = '100';
	document.forms[0].send_limit.checked = true;
	document.forms[0].day.value = '7';
	document.forms[0].del.checked = true;
	document.forms[0].ContentType.value = '1';
	document.forms[0].send_server[0].checked = true;
}

</script>
<div class="tableform">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="0" width="1050">
<tr><td colspan="2"><b><?php echo FORM_INTERFACE_SETTINGS; ?></b><hr></td></tr>
<tr><td width="40%"><?php echo FORM_LANGUAGE; ?>:</td><td>
<select name="language">
<option value="en" <?php echo ($settings['language'] == "en" ? ' selected="selected"' : ""); ?>><?php echo FORM_LANGUAGE_EN; ?></option>
<option value="ru" <?php echo ($settings['language'] == "ru" ? ' selected="selected"' : ""); ?>><?php echo FORM_LANGUAGE_RU; ?></option>
</select></td></tr>
<tr><td width="40%"><?php echo FORM_COUNT_SEND; ?>:</td><td><input type="text" class="input" name="count_send" size="3" maxlength="4" value="<?php echo $settings['count_send']; ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_COUNT_USER; ?>:</td><td><input class="input" type="text" name="count_user" size="3" maxlength="4" value="<?php echo $settings['count_user']; ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_EMAIL; ?>:</td><td><input class="input" type=text name="email" size="45" maxlength="100" value="<?php echo $settings['email']; ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_SHOWADMIN; ?>:</td><td><input type=checkbox name="show_email"<?php echo ($settings['show_email'] == "yes" ? ' checked="checked"' : ""); ?>></td></tr>
<tr><td width="40%"><?php echo FORM_SUBSCRIBERNOTIFY; ?>:</td><td><input type=checkbox name="newsubscribernotify"<?php echo ($settings['newsubscribernotify'] == "yes" ? " checked" : ""); ?>></td></tr>
<tr><td width="40%"><?php echo FORM_FROM; ?>:</td><td><input class="input" type=text name="from" size="45" maxlength="100" value="<?php if(empty($settings['from_mail'])) echo $_SERVER['SERVER_NAME']; else echo htmlspecialchars($settings['from_mail']); ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_ORGANIZATION; ?>:</td><td><input class="input" type=text name="organization" size="45" maxlength="100" value="<?php echo htmlspecialchars($settings['organization']); ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_SUBJECTTEXTCONFIRM; ?>:</td><td><input class="input" type=text name="subjecttextconfirm" size="45" maxlength="100" value="<?php echo $settings['subjecttextconfirm']; ?>"><br></td></tr>
<tr><td width="40%"><?php echo FORM_TEXTCONFIRMATION; ?>:</td><td><textarea rows="5" name="textconfirmation" cols="25"><?php echo $settings['textconfirmation']; ?></textarea></td></tr>
<tr><td width="40%"><?php echo FORM_UNSUBLINK; ?>:</td><td><textarea rows="3" name="unsublink" cols="25"><?php echo $settings['unsublink']; ?></textarea></td></tr>
<tr><td colspan="2"><b><?php echo FORM_SMTP_SETTINGS; ?></b><hr></td></tr>
<tr><td width="40%"><?php echo FORM_SMTP_HOST; ?>:</td><td><input class="input" type=text name="smtp_host" size="45" maxlength="100" value="<?php echo $settings['smtp_host']; ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_SMTP_USERNAME; ?>:</td><td><input class="input" type=text name="smtp_username" size="45" maxlength="100" value="<?php echo $settings['smtp_username'] ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_SMTP_PASSWORD; ?>:</td><td><input class="input" type=text name="smtp_password" size="45" maxlength="100" value="<?php echo $settings['smtp_password']; ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_SMTP_PORT; ?>:</td><td><input class="input" type=text name="smtp_port" size="6" maxlength="20" value="<?php echo $settings['smtp_port']; ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_SMTP_TIMEOUT; ?>:</td><td><input class="input" type=text name="smtp_timeout" size="6" maxlength="20" value="<?php echo $settings['smtp_timeout']; ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_SMTP_SSL; ?>:</td><td><input type=checkbox name="smtp_ssl"<?php echo ($settings['smtp_ssl'] == "yes" ? ' checked="checked"' : ""); ?>></td></tr>
<tr><td><?php echo FORM_SMTP_AUT; ?>:</td>
<td><p><input type="radio" value="1"<?php echo (($settings['smtp_aut'] == "1") || ($settings['smtp_aut'] == '') ? ' checked="checked"' : ""); ?> name="smtp_aut"><?php echo FORM_SMTP_AUT_1; ?><input type="radio" name="smtp_aut"<?php echo ($settings['smtp_aut'] == "2" ? ' checked="checked"' : ""); ?> value="2"><?php echo FORM_SMTP_AUT_2; ?></td>
</tr>
<tr><td colspan="2"><b><?php echo FORM_PARAMETERS; ?></b><hr></td></tr>
<tr><td width="40%"><?php echo FORM_UNSUBSCRIBE; ?>:</td><td><input type=checkbox name="unsubscribe" <?php if($settings['unsubscribe'] == "yes") echo "checked"; ?>></td></tr>
<tr><td width="40%"><?php echo FORM_REPLY; ?>:</td><td><input type=checkbox name="reply" <?php if($settings['reply'] == "yes") echo "checked"; ?>></td></tr>
<tr><td width="40%"><?php echo FORM_INTERVAL_TYPE; ?><select name="interval_type">
<option value="0" <?php echo ($settings['interval_type'] == "no" ? ' selected="selected"' : ""); ?>><?php echo FORM_INTERVAL_TYPE_NO; ?></option>
<option value="1" <?php echo ($settings['interval_type'] == "m" ? ' selected="selected"' : ""); ?>><?php echo FORM_INTERVAL_TYPE_M; ?></option>
<option value="2" <?php echo ($settings['interval_type'] == "h" ? ' selected="selected"' : ""); ?>><?php echo FORM_INTERVAL_TYPE_H; ?></option>
<option value="3" <?php echo ($settings['interval_type'] == "d" ? ' selected="selected"' : ""); ?>><?php echo FORM_INTERVAL_TYPE_D; ?></option>
</select>:</td><td><input class="input" type="text" name="count_interval" size="3" maxlength="4" value="<?php echo $settings['count_interval']; ?>"></td></tr>
<tr><td width="40%"><?php echo FORM_MANY_SEND; ?>:</td><td><input type=checkbox name="many_send"<?php echo ($settings['many_send'] == "yes" ? ' checked="checked"' : ""); ?>></td></tr>
<tr><td><p><?php echo FORM_LIMIT_NUMBER; ?>: <input size="2" type=text name="limit_number" size="3" maxlength="4" value="<?php echo $settings['limit_number']; ?>"></td>
<td><input type="checkbox" name="send_limit" <?php echo ($settings['send_limit'] == "yes" ? ' checked="checked"' : ""); ?>></td></tr>
<tr><td><p><?php echo FORM_DAY; ?>:&nbsp;<input size="2" type=text name="day" size="3" maxlength="4" value="<?php echo $settings['day']; ?>"></td>
<td><input type="checkbox" name="del" <?php echo ($settings['del'] == "yes" ? ' checked="checked"' : ""); ?>></td></tr>
<tr><td width="40%"><?php echo FORM_CHARSET; ?>:</td>
<td> 
<select name="id_charset">
<?php

$query = "SELECT * FROM ".DB_CHAR."";
$result = $dbh->query($query);

if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

while($row = $result->fetch_array())
{
	$temp[$row['id_charset']] = charsetlist($row['charset']);
}

$result->close();

asort($temp);

foreach($temp as $key => $value)
{
	$selected = ($key == $settings['id_charset'] ? ' selected="selected"' : "");
	echo "<option value=\"".$key."\"".$selected.">".$value."</option>";
}

?>
</select>
</td>
</tr>
<tr><td><p><?php echo FORM_CONTENTTYPE; ?>:</td>
<td><select name="ContentType">
<option value="1"<?php echo ($settings['ContentType'] == "1" ? ' selected="selected"' : ""); ?>>plain</option>
<option value="2"<?php echo ($settings['ContentType'] == "2" ? ' selected="selected"' : ""); ?>>html</option>
</select>
</td>
</tr>
<tr><td><?php echo FORM_SEND_SERVER; ?>:</td>
<td><p><input type="radio" value="1"<?php echo (($settings['send_server'] == "1") || ($settings['send_server'] == "") ? ' checked="checked"' : ""); ?> name="send_server"><?php echo FORM_SEND_SERVER_1; ?><input type="radio" onChange="smtp(this.form);" name="send_server"<?php echo ($settings['send_server'] == "2" ? ' checked="checked"' : ""); ?> value="2"><?php echo FORM_SEND_SERVER_2; ?></td>
</tr>
<tr><td>&nbsp;</td><tr><td><input class="inputsubmit" type="submit" value="<?php echo FORM_SAVE_CHANGES; ?>">&nbsp;&nbsp;<input class="inputsubmit" type="button" value="<?php echo FORM_BY_DEFAULT; ?>" onclick="dflt()">
<input type="hidden" name="action" value="post">
</td>
</tr></table></form>
</div>
<?php

		include "bottom.php";
	}
	else
	{
		$_POST['count_send'] = (int)$_POST['count_send'];
		$_POST['count_user'] = (int)$_POST['count_user'];
		$_POST['limit_number'] = (int)$_POST['limit_number'];
		$_POST['smtp_port'] = (int)$_POST['smtp_port'];
		$_POST['day'] = (int)$_POST['day'];
		$_POST['smtp_timeout'] = (int)$_POST['smtp_timeout'];
		$_POST['count_interval'] = (int)$_POST['count_interval'];
		$_POST['subjecttextconfirm'] = stripslashes($_POST['subjecttextconfirm']);
		$_POST['textconfirmation'] = stripslashes($_POST['textconfirmation']);
		$_POST['organization'] = trim(stripslashes($_POST['organization']));
		$_POST['from'] = trim(stripslashes($_POST['from']));
		$_POST['from'] = str_replace(';','',$_POST['from']);

		if(!preg_match("|^[\d]*$|",$_POST['count_send'])) $_POST['count_send'] = $settings['count_send'];
		if(!preg_match("|^[\d]*$|",$_POST['count_user'])) $_POST['count_user'] = $settings['count_user'];
		if(!preg_match("|^[\d]*$|",$_POST['limit_number'])) $_POST['limit_number'] = $settings['limit_number'];
		if(!preg_match("|^[\d]*$|",$_POST['smtp_port'])) $_POST['smtp_port'] = $settings['smtp_port'];
		if(!preg_match("|^[\d]*$|",$_POST['day'])) $_POST['day'] = $settings['day'];
		if(!preg_match("|^[\d]*$|",$_POST['count_day'])) $_POST['count_day'] = $settings['count_day'];
		
		$_POST['email'] = $dbh->real_escape_string($_POST['email']);
		$_POST['day'] = $dbh->real_escape_string($_POST['day']);
		$_POST['smtp_host'] = $dbh->real_escape_string($_POST['smtp_host']);
		$_POST['smtp_username'] = $dbh->real_escape_string($_POST['smtp_username']);
		$_POST['smtp_password'] = $dbh->real_escape_string($_POST['smtp_password']);
		$_POST['smtp_port'] = $dbh->real_escape_string($_POST['smtp_port']);
		$_POST['smtp_aut'] = $dbh->real_escape_string($_POST['smtp_aut']);
		$_POST['count_send'] = $dbh->real_escape_string($_POST['count_send']);
		$_POST['send_server'] = $dbh->real_escape_string($_POST['send_server']);
		$_POST['smtp_ssl'] = $dbh->real_escape_string($_POST['smtp_ssl']);
		$_POST['ContentType'] = $dbh->real_escape_string($_POST['ContentType']);
		$_POST['from'] = $dbh->real_escape_string($_POST['from']);
		$_POST['subjecttextconfirm'] = $dbh->real_escape_string($_POST['subjecttextconfirm']);
		$_POST['textconfirmation'] = $dbh->real_escape_string($_POST['textconfirmation']);
		$_POST['unsublink'] = $dbh->real_escape_string($_POST['unsublink']);
		$_POST['id_charset'] = $dbh->real_escape_string($_POST['id_charset']);
		$_POST['organization'] = $dbh->real_escape_string($_POST['organization']);
		$_POST['language'] = $dbh->real_escape_string($_POST['language']);		
		
		$_POST['del'] = ($_POST['del'] == 'on' ? "yes" : "no");
		$_POST['show_email'] = ($_POST['show_email'] == 'on' ? "yes" : "no");
		$_POST['newsubscribernotify'] = ($_POST['newsubscribernotify'] == 'on' ? "yes" : "no");
		$_POST['send_limit'] = ($_POST['send_limit'] == 'on' ? "yes" : "no");
		$_POST['many_send']	= ($_POST['many_send'] == 'on' ? "yes" : "no");
		$_POST['reply'] = ($_POST['reply'] == 'on' ? "yes" : "no");
		$_POST['smtp_ssl'] = ($_POST['smtp_ssl'] == 'on' ? "yes" : "no");
		$_POST['unsubscribe'] = ($_POST['unsubscribe'] == 'on' ? "yes" : "no");

		if($_POST['interval_type'] == '1') { $_POST['interval_type'] = 'm'; }
		else if($_POST['interval_type'] == '2') { $_POST['interval_type'] = 'h'; }
		else if($_POST['interval_type'] == '3') { $_POST['interval_type'] = 'd'; }
		else { $_POST['interval_type'] = 'no'; }

		$update = "UPDATE ".DB_SETTING." SET language = '".$_POST['language']."',
												count_send = ".$_POST['count_send'].",
												count_user = ".$_POST['count_user'].",
												email = '".$_POST['email']."',
												organization = '".$_POST['organization']."',
												limit_number = ".$_POST['limit_number'].",
												send_limit = '".$_POST['send_limit']."',
												many_send = '".$_POST['many_send']."',
												smtp_host = '".$_POST['smtp_host']."',
												smtp_username = '".$_POST['smtp_username']."',
												smtp_password = '".$_POST['smtp_password']."',
												smtp_port = ".$_POST['smtp_port'].",
												smtp_aut = '".$_POST['smtp_aut']."',
												send_server = '".$_POST['send_server']."',
												smtp_ssl = '".$_POST['smtp_ssl']."',
												smtp_timeout = '".$_POST['smtp_timeout']."',
												id_charset = ".$_POST['id_charset'].",
												ContentType = '".$_POST['ContentType']."',
												day = ".$_POST['day'].",
												count_interval = ".$_POST['count_interval'].",
												del = '".$_POST['del']."',
												unsubscribe = '".$_POST['unsubscribe']."',
												reply = '".$_POST['reply']."',
												from_mail = '".$_POST['from']."',
												show_email = '".$_POST['show_email']."',
												newsubscribernotify = '".$_POST['newsubscribernotify']."',
												subjecttextconfirm = '".$_POST['subjecttextconfirm']."',
												textconfirmation = '".$_POST['textconfirmation']."',
												unsublink = '".$_POST['unsublink']."',
												interval_type = '".$_POST['interval_type']."'";

		if($dbh->query($update))
		{
			redirect(MSG_CHANGE,'settings.php',2);
		}
		else
		{
			throw new ExceptionMySQL($dbh->error,$update,"Error executing SQL query!");
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