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
	require_once "templates/language/".$settings['language']."/index.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";
	
	if(empty($_POST["action"]))
	{
		if(!preg_match("|^[\d]*$|",$_GET['page'])) exit();

		if(empty($settings['count_send'])) 
			$count_send = 5;
		else 
			$count_send = $settings['count_send'];

		$page = $_GET['page'];
		if(empty($page)) $page = 1;
		$begin = ($page - 1)*$count_send;

		$title = TITLE;

		include "top.php";

		$query = "SELECT *,cat.name as catname, send.name as sendname FROM ".DB_SEND." send LEFT JOIN ".DB_CAT." cat ON cat.id_cat=send.id_cat
					ORDER BY send.pos
					LIMIT ".$begin.", ".$count_send."";

		$result = $dbh->query($query);

		if(!$result) throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");

?>
<script type="text/javascript">

function sendout(str)
{
	id_send = str;
	process();
}

var xmlHttp = createXmlHttpRequestObject();

function createXmlHttpRequestObject()
{
	var xmlHttp;

	try
	{
		xmlHttp = new XMLHttpRequest();
	}
	catch (trymicrosoft)
	{
		try
		{
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (othermicrosoft)
		{
			try
			{
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (failed)
			{
				xmlHttp = false;
			}
		}
	}

	if (!xmlHttp) alert("<?php echo ALERTERRORINTERFACE; ?>");
	else return xmlHttp;
}

function process()
{
	document.getElementById("idsend_" + id_send).innerHTML = '<img src=images/loader.gif>';
	document.getElementById("sendout_" + id_send).style.display = 'none';

	if(xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
	{
		if(id_send != '')
		{
			var url = "send.php?id_send=" + escape(id_send);
			xmlHttp.open("GET", url, true);
			xmlHttp.onreadystatechange = handleServerResponse;
			xmlHttp.send(null);
		}
	}
	else
	{
		setTimeout('process()', 1000);
	}
}

function handleServerResponse()
{
	document.getElementById("idsend_" + id_send).innerHTML = '<img src=images/loader.gif>';
	document.getElementById("sendout_" + id_send).style.display = 'none';

	if(xmlHttp.readyState == 4)
	{
		if(xmlHttp.status == 200)
		{
			var msg = decodeURIComponent(xmlHttp.responseText);
		 
			document.getElementById("idsend_" + id_send).innerHTML = "<?php echo COUNTSENT; ?> " + msg;
			setTimeout(function() { 
				document.getElementById("idsend_" + id_send).innerHTML = '';
				document.getElementById("sendout_" + id_send).style.display = '';
			}, 3000);
		}
		else
		{
			alert("<?php echo ALERTERRORSERVER; ?> " + xmlHttp.statusText);
		}
	}
}

var DOM = (typeof(document.getElementById) != 'undefined');

function Check_action()
{
	if(document.forms[0].action.value==0) {window.alert('<?php echo ALERTSELECTACTION; ?>');}
}

function CheckAll_Activate(Element,Name)
{
	if(DOM)
	{
		thisCheckBoxes = Element.parentNode.parentNode.parentNode.getElementsByTagName('input');

		var m=0;

		for(var i = 1; i < thisCheckBoxes.length; i++)
		{
			if(thisCheckBoxes[i].name == Name)
			{
				thisCheckBoxes[i].checked = Element.checked;
				if(thisCheckBoxes[i].checked == true) m++;
				if(thisCheckBoxes[i].checked == false) m--;
			}
		}

		if(m > 0) { document.getElementById("Apply_").disabled = false; }
		else { document.getElementById("Apply_").disabled = true;  }
	}
}

function Count_checked()
{
	var All=document.forms[0];

	var m=0;

	for(var i = 0; i < All.elements.length; ++i)
	{
		if(All.elements[i].checked) { m++; }
	}

	if(m > 0) { document.getElementById("Apply_").disabled = false; }
	else { document.getElementById("Apply_").disabled = true;  }
}

</script>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="if(document.forms[0].action.value==0){window.alert('<?php echo ALERTSELECTACTION; ?>');return false;}if(document.forms[0].action.value==3){return confirm('<?php echo ALERTCONFIRMREMOVE; ?>');}" method="post">
<table class="cattab content" cellspacing="1" cellpadding="3" border="0" width="100%"><tr align="center">
<td class="catmenu"><input type="checkbox" title="<?php echo TABLECOLMN_CHECK_ALLBOX; ?>" onclick="CheckAll_Activate(this,'activate[]');"></td>
<td width="50%" class="catmenu toptab"><?php echo TABLECOLMN_MAILER; ?></td>
<td width="120" class="catmenu toptab"><?php echo TABLECOLMN_DATE_CREATION; ?></td>
<td class="catmenu toptab"><?php echo TABLECOLMN_CATEGORY; ?></td>
<td class="catmenu toptab"><?php echo TABLECOLMN_ACTIVITY; ?></td>
<td class="catmenu toptab"><?php echo TABLECOLMN_POSITION; ?></td>
<td class="catmenu toptab"><?php echo TABLECOLMN_EDIT; ?></td>
<td class="catmenu toptab"><?php echo TABLECOLMN_SEND; ?></td>
</tr>
<?php

		while($send = $result->fetch_array())
		{
			if($send['id_cat'] == 0) { $send['catname'] = GENERAL; }

			$active = ($send['active'] == 'yes' ? YES : NO);
			
			$send['message'] = preg_replace('/<br(\s\/)?>/siU', "\n", $send['message']);
			$send['message'] = remove_html_tags($send['message']);
			$send['message'] = preg_replace('/\n/sU', "<br>", $send['message']);
			$pos = strpos(substr($send['message'],500), " ");

			if(strlen($send['message'])>500) $srttmpend = "...";
			else $strtmpend = "";

			$alert = ($send['active'] == 'no' ? "onclick=\"alert('".ALERTSEND."');return false;\"" : "");

?>
<tr class="trcat">
<td align="center" class="td2"><input type="checkbox" onclick="Count_checked();" title="<?php echo TABLECOLMN_CHECKBOX; ?>" value="<?php echo $send['id_send']; ?>" name=activate[]></td>
<td><a title='<?php echo TABLECOLMN_EDIT_MAILINGTEXT; ?>' href="editsend.php?id_send=<?php echo $send['id_send']; ?>"><?php echo $send['sendname']; ?></a><br><br><?php echo "".substr($send['message'], 0, 500+$pos).$srttmpend; ?></td>
<td align="center" class="td2"><?php echo $send['date']; ?></td>
<td align="center"><?php echo $send['catname']; ?></td>
<td align="center"><?php echo $active; ?></td>
<td align="center"><a href="up.php?id_send=<?php echo $send['id_send']; ?>" title='<?php echo TABLECOLMN_UP; ?>'><img border="0" src="images/up.gif" width="20" height="20"></a><br><br><a href="down.php?id_send=<?php echo $send['id_send']; ?>" title='<?php echo TABLECOLMN_DOWN; ?>'><img border="0" src="images/down.gif" width="20" height="20"></a></td>
<td align="center"><a href="editsend.php?id_send=<?php echo $send['id_send']; ?>" title='<?php echo TABLECOLMN_EDIT_MAILINGTEXT; ?>'><img border="0" src="images/edit.gif" width="24" height="24"></a></td>
<td align="center"><a id="sendout_<?php echo $send['id_send']; ?>" onClick="sendout(<?php echo $send['id_send']; ?>);" href="#" title='<?php echo TABLECOLMN_SEND_MAIL; ?>' <?php echo $alert; ?>><img border="0" src="images/send.gif" width="24" height="24"></a><span id="idsend_<?php echo $send['id_send']; ?>"></span></td>
</tr>
<?php

		}
		echo "</table><br>";
?>
<select size="1" name="action">
  <option value="0">--<?php echo ACTION; ?>--</option>
  <option value="1"><?php echo ACTIVATE; ?></option>
  <option value="2"><?php echo DEACTIVATE; ?></option>
  <option value="3"><?php echo REMOVE; ?></option>
</select>&nbsp;
<input type="submit" id="Apply_" value="<?php echo APPLY; ?>" disabled="" name="">
</form>
<?php

		$result->close();

		$query = "SELECT COUNT(*) FROM ".DB_SEND."";
		$result = $dbh->query($query);

		if(!$result)
		{
			throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
		}

		$total = $result->fetch_assoc();

		$result->close();

		$number = intval(($total['COUNT(*)'] - 1) / $count_send) + 1;

		if($page != 1) $pervpage = '<a href=index.php?page=1>&lt;&lt;</a>
											 <a href=index.php?page='.($page - 1).'>&lt;</a>';

		if($page != $number) $nextpage = ' <a href=index.php?page='.($page + 1).'>&gt;</a>
													  <a href=index.php?page='.$number.'>&gt;&gt;</a>';

		if($page - 2 > 0) $page2left = '<a href=index.php?page='.($page - 2).'>...'.($page - 2).'</a> | ';
		if($page - 1 > 0) $page1left = ' <a href=index.php?page='.($page - 1).'>'.($page - 1).'</a> | ';
		if($page + 2 <= $number) $page2right = ' | <a href=index.php?page='.($page + 2).'>'.($page + 2).'...</a>';
		if($page + 1 <= $number) $page1right = ' | <a href=index.php?page='.($page + 1).'>'.($page + 1).'</a>';

		echo "<p>".PAGES.":&nbsp;&nbsp;";
		echo $pervpage.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$nextpage;
		echo "</p>";

		include "bottom.php";
	}
	else
	{
		$temp = array();

		foreach($_POST['activate'] as $id_send)
		{
			if(preg_match("|^[\d]+$|",$id_send))
			{
				$temp[] = $id_send;
			}
		}

		if($_POST["action"] == 1)
		{
			$update = "UPDATE ".DB_SEND." SET active='yes' WHERE id_send IN (".implode(",",$temp).")";

			if(!$dbh->query($update))
			{
				throw new ExceptionMySQL($dbh->error,$update,"Error executing SQL query!");
			}
			else
			{
				unset($temp);
				unset($id_send);

				redirect(MSG_CHANGE,$_SERVER["HTTP_REFERER"],2);
			}
		}
		else if($_POST["action"] == 2)
		{
			$update = "UPDATE ".DB_SEND." SET active='no' WHERE id_send IN (".implode(",",$temp).")";

			if(!$dbh->query($update))
			{
				throw new ExceptionMySQL($dbh->error,$update,"Error executing SQL query!");
			}
			else
			{
				unset($temp);
				unset($id_send);

				redirect(MSG_CHANGE,$_SERVER["HTTP_REFERER"],2);
			}
		}
		else if($_POST["action"] == 3)
		{
			$query = "SELECT * FROM ".DB_ATTACH." WHERE id_send IN (".implode(",",$temp).")";
			$result = $dbh->query($query);

			if(!$result)
			{
				throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
			}

			while($row = $result->fetch_array())
			{
				if(file_exists($row['path'])) @unlink($row['path']);
			}

			$result->close();

			$delete = "DELETE FROM ".DB_SEND." WHERE id_send IN (".implode(",",$temp).")";

			if($dbh->query($delete))
			{
				$delete2 = "DELETE FROM ".DB_ATTACH." WHERE id_send IN (".implode(",",$temp).")";
				$dbh->query($delete2);

				unset($temp);
				unset($id_send);

				redirect(MSG_CHANGE,$_SERVER["HTTP_REFERER"],2);
			}
			else
			{
				throw new ExceptionMySQL($dbh->error,$delete,"Error executing SQL query!");
			}
		}
		else
		{
			redirect(MSG_CHANGE,$_SERVER["HTTP_REFERER"],2);
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
