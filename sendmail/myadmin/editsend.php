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
	require_once "templates/language/".$settings['language']."/editsend.inc";
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

	if(!empty($_POST["action"]))
	{
		$_POST['name'] = trim($_POST['name']);
		$_POST['msg'] = trim($_POST['msg']);

		if(empty($_POST['name'])) error(MSG_SUBJECT_EMPTY);
		if(empty($_POST['msg'])) error(MSG_TEXT_EMPTY);

		$_POST['name'] = $dbh->real_escape_string($_POST['name']);
		$_POST['msg'] = $dbh->real_escape_string($_POST['msg']);
		$_POST['id_cat'] = $dbh->real_escape_string($_POST['id_cat']);
		$_POST['prior'] = $dbh->real_escape_string($_POST['prior']);
		$_POST['id_send'] = $dbh->real_escape_string($_POST['id_send']);

		$update = "UPDATE ".DB_SEND." SET name = '".$_POST['name']."',
											message = '".$_POST['msg']."',
											prior = '".$_POST['prior']."',
											id_cat = ".$_POST['id_cat']."
											WHERE id_send = ".$_POST['id_send'];

		if($dbh->query($update))
		{
			$del = 0;

			for($i = 0; $i < count($_FILES); $i++)
			{
				if(!empty($_FILES["mail_file_$i"]["name"]))
				{
					if($del == 0)
					{
						$query = "SELECT * FROM ".DB_ATTACH." WHERE id_send=".$_POST['id_send'];
						$result = $dbh->query($query);

						while($row = $result->fetch_array())
						{
							if(file_exists($row['path'])) @unlink($row['path']);
						}

						$result->close();

						$delete = "DELETE FROM ".DB_ATTACH." WHERE id_send = ".$_POST['id_send'];
						$dbh->query($delete);

						$del = 1;
					}

					@$file = "attach/".$i.getRandomCod().strrchr($_FILES["mail_file_$i"]["name"]).strrchr($_FILES["mail_file_".$i.""]["name"], ".");

					if(@copy($_FILES["mail_file_".$i.""]["tmp_name"], $file)) { @unlink($_FILES["mail_file_".$i.""]["tmp_name"]); }

					$insert = "INSERT INTO ".DB_ATTACH." (id_attachment,name,path,id_send) VALUES (0,'".$_FILES["mail_file_".$i.""]["name"]."','".$file."','".$_POST['id_send']."')";
					$result = $dbh->prepare($insert);
					$result->execute();

					$result->close();
				}
			}

			redirect(MSG_CHANGE,'index.php',2);
		}
		else
		{
			throw new ExceptionMySQL($dbh->error,$update,"Error executing SQL query!");
		}
	}
	else
	{
		if(!preg_match("|^[\d]*$|",$_GET['id_send'])) exit();

		include "top.php";

		$query = "SELECT * FROM ".DB_SEND." WHERE id_send=".$_GET['id_send'];
		$result = $dbh->query($query);

		if($result)
		{
			$send = $result->fetch_array();
			$id_cat = $send['id_cat'];
		}
		else
		{
			throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
		}

		$result->close();

?>
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">

function add_mail_file(bl_name, num)
{
	var addF = document.forms['addF'];
	prev_num = parseInt(num)-1;
	bl_name += "_";
	par_div = document.getElementById(bl_name+prev_num).parentNode;
	adding_block = document.createElement("div");
	adding_block.id = bl_name+num;

	if(bl_name == "loadfile_") adding_block.innerHTML = "<div id=loadfile_"+(parseInt(num))+"><table border=0 cellpadding=0 cellspacing=0 id=addf_table_"+(parseInt(num))+"><tr><td><div id=\"Div_File_"+(parseInt(num))+"\"><input type=\"file\" onChange=\"add_mail_file('loadfile', '"+((parseInt(num))+1)+"'); return false;\" size=\"50\" class=\"input\" id=\"file_"+(parseInt(num))+"\" name=\"mail_file_"+(parseInt(num))+"\"></div></td><td valign=middle>&nbsp;&nbsp;<a class=l_text onclick=\"del_pole(this);\" href=\"#\">Удалить</a></td></tr></table></div>";

	par_div.appendChild(adding_block);
}

function del_pole(btn)
{
	if(document.getElementById)
	{
		while(btn.tagName != 'TR') btn = btn.parentNode;
		btn.parentNode.removeChild(btn);
	}
}

tinyMCE.init({

	forced_root_block : false,
	force_br_newlines : true,
	force_p_newlines : false,
	relative_urls : false,
	remove_script_host : true,
	convert_urls : false,

	// General options
	mode : "textareas",
	theme : "advanced",
	language : "<?php echo $settings['language']; ?>",
	plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	// Example content CSS (should be your site CSS)
	content_css : "css/content.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",

	// Style formats
	style_formats : [
		{title : 'Bold text', inline : 'b'},
		{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
		{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
		{title : 'Example 1', inline : 'span', classes : 'example1'},
		{title : 'Example 2', inline : 'span', classes : 'example2'},
		{title : 'Table styles'},
		{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
	],

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
});

</script>
<div class="tableform">
<form enctype='multipart/form-data' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table class="content" width="640"><tr>
<td valign="top">
<tr><td width="97"><?php echo FORM_SUBJECT; ?>:</td><td colspan="2"><input class="input" size="50" type="text" name="name" value='<?php echo $send['name']; ?>'></td></tr>
<tr><td width="97"><?php echo FORM_CONTENTS; ?>:</td>
<td colspan="2"><textarea class="input2" id="msg" name="msg" rows="15" cols="60"><?php echo $send['message']; ?></textarea></td>
</tr>
<tr><td  colspan="2"><?php echo FORM_NOTE; ?></td></tr>
<tr>
<?php

	$select = "SELECT * FROM ".DB_ATTACH." WHERE id_send = ".$_GET['id_send']." ORDER BY name";
	$result = $dbh->query($select);

	if(!$result)
	{
		throw new ExceptionMySQL($dbh->error,$select,"Error executing SQL query!");
	}

	$attach_file = "";

	while($row = $result->fetch_array())
	{
		$attach_file .= "".$row['name']."&nbsp;";
	}

	$result->close();

	if(!empty($attach_file)) { echo "<tr><td width=97><p>".FORM_ATTACHMENTS.": </p></td><td colspan=2><p>".$attach_file." <a href=\"del_attach.php?id_send=".$_GET['id_send']."\" title=\"".FORM_DEL_ATTACHMENTS."\">".FORM_DEL_ATTACHMENTS."</a></p></td></tr>"; }

?>
<td width="97"><?php echo FORM_ATTACH; ?>:</td>
<td width="97" colspan="2">
<div id=loadfile_0>
<table border="0" cellpadding="0" cellspacing="0"><tr>
<td><input type="file" size="50" name="mail_file_0" class="input" id="file_0_input" onChange="add_mail_file('loadfile', '1'); return false;"></td>
</tr></table>
</div>
</td>
</tr>
<tr><td width="97"><?php echo FORM_CATEGORY_SUBSCRIBERS; ?>:</td>
<td colspan="2">
<select type=text name="id_cat">
<?php

	$query = "SELECT * FROM ".DB_CAT." ORDER BY name";
	$result = $dbh->query($query);

	if(!$result)
	{
		throw new ExceptionMySQL($dbh->error,$update,"Error executing SQL query!");
	}

	$selected = ($id_cat == 0 ? ' selected="selected"' : "");

	echo "<option value=\"0\"".$selected.">".FORM_SENT_TO_ALL."</option>";

	while($category = $result->fetch_array())
	{
		$selected = ($id_cat == $category['id_cat'] ? ' selected="selected"' : "");

		echo "<option value=".$category['id_cat'].$selected.">".$category['name']."</option>";
	}

	$result->close();

?>
</select>
</td>
</tr>
<tr>
<td width="97"><?php echo FORM_PRIORITY; ?>:</td>
<td>
<table class="content" border="0"><tr>
<td><input name="prior" type="radio" value="3" <?php if(($send['prior'] == "3") OR empty($send['prior'])) echo "checked"; ?>><?php echo FORM_PRIORITY_NORMAL; ?></td>
<td><input type="radio" name="prior" value="2" <?php if($send['prior'] == "2") echo "checked"; ?>><?php echo FORM_PRIORITY_LOW; ?></td>
<td><input type="radio" name="prior" value="1" <?php if($send['prior'] == "1") echo "checked"; ?>><?php echo FORM_PRIORITY_HIGH; ?></td>
</tr></table>
</td>
</tr>
<tr><td></td><td colspan="2">&nbsp;</td></tr>
<tr><td></td><td><input type="submit" class="inputsubmit" value="<?php echo EDIT; ?>">
<input type=hidden name="action" value="post">
<input type=hidden name="id_send" value=<?php echo $_GET['id_send']; ?>>
</td>
</tr></table>
</form>
</div>
<?php

		include "bottom.php";
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
