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
	require_once "templates/language/".$settings['language']."/users.inc";
	require_once "templates/language/".$settings['language']."/language.inc";
	require_once "lib/authenticate.inc";
	require_once "lib/delete.inc";

	if(empty($_POST["action"]))
	{
		$_GET['search'] = $dbh->real_escape_string($_GET['search']);
		
		$_GET['search'] = trim($_GET['search']);

		$title = TITLE;

		$srch = $_POST['srch'];

		if(empty($settings['count_user'])) $count_user = 5;
		else $count_user = $settings['count_user'];

		$page = $_GET['page'];

		if(empty($page)) $page = 1;
		$begin = ($page - 1)*$count_user;

		include "top.php";

		$order = array();
		$order['name'] = "name";
		$order['email'] = "email";
		$order['time'] = "time";
		$order['status'] = "status";

		$strtmp = "name";

		foreach($order as $parametr => $field)
		{
			if(isset($_GET["".$parametr.""]))
			{
				if($_GET["".$parametr.""] == "up")
				{
					$_GET["".$parametr.""] = "down";
					$strtmp = $field;
					$pl = "&".$field."=up";
					$thclass["$parametr"] = ' headerSortUp'; 
				}
				else
				{
					$_GET["".$parametr.""] = "up";
					$strtmp = "".$field." DESC";
					$pl = "&".$field."=down";
					 $thclass["$parametr"] = ' headerSortDown'; 
				}
			}
			else {
				$_GET["".$parametr.""] = "up";
				$thclass["$parametr"] = ''; 
			}
		}
		
?>
<script type="text/javascript">

  var DOM = (typeof(document.getElementById) != 'undefined');

  function Check_action()
  {
	  if(document.forms[1].action.value==0) {window.alert('<?php echo ALERTSELECTACTION; ?>');}
  }

  function CheckAll_Activate(Element,Name)
  {
	  if(DOM)
	  {
		  thisCheckBoxes = Element.parentNode.parentNode.parentNode.getElementsByTagName('input');

		  var m=0;

		  for(var i=1; i < thisCheckBoxes.length; i++)
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
	  var All=document.forms[1];

	  var m=0;

	  for(var i=0; i < All.elements.length; ++i)
	  {
		  if(All.elements[i].checked) { m++; }
	  }

	  if(m > 0) { document.getElementById("Apply_").disabled = false; }
	  else { document.getElementById("Apply_").disabled = true;  }
  }

</script>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
<div class="tableform" style="width: 300px">
<table border="0">
<tr><td><?php echo FORMSEARCH_NAME; ?>:</td><td><input size="20" type="text" value="<?php echo urldecode($_GET['search']); ?>" name="search"></td></tr>
<tr><td><input type="submit" class="inputsubmit" value="<?php echo FIND; ?>"></td>
<td></td>
</table>
</div>
</form><br>
<?php

		if(empty($_GET['search']))
		{
			$query = "SELECT *,DATE_FORMAT(time,'%d.%m.%y') as putdate_format FROM ".DB_USERS."
						ORDER BY ".$strtmp."
						LIMIT ".$begin.", ".$count_user."";
		}
		else
		{
			$temp = strtok($_GET['search']," ");
			
			$temp = "%".$temp."%";
			$logstr = "or";

			while ($temp)
			{
				if($is_query) { $tmp1 .= " $logstr (name LIKE '".$temp."' OR email LIKE '".$temp."') "; }
				else { $tmp1 .= "(name LIKE '".$temp."' OR email LIKE '".$temp."') "; }

				$is_query = true;
				$temp = strtok(" ");
			}

			$query = "SELECT *,DATE_FORMAT(time,'%d.%m.%y') as putdate_format FROM ".DB_USERS."
						WHERE ".$tmp1."
						GROUP BY id_user
						ORDER BY name
						LIMIT ".$begin.", ".$count_user."";
		}
		
		$result = $dbh->query($query);

		if(!$result) { throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!"); }

		if($result->num_rows>0)
		{
			if($_GET['search']) { echo "<p><a href=\"users.php\">".BACK."</a></p>"; }

			if($page>1) $pagenav = "&page=".$page."";
			else $pagenav = '';
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="if(document.forms[1].action.value==0){window.alert('<?php echo ALERTSELECTACTION; ?>');return false;}if(document.forms[1].action.value==2){return confirm('<?php echo ALERTCONFIRMREMOVE; ?>');}" method="post">
<table class="cattab content" cellSpacing="1" cellPadding="5" border="0" width="100%"><tr>
<td class="catmenu toptab"><input type="checkbox" title="<?php echo TABLECOLMN_CHECK_ALLBOX; ?>" onclick="CheckAll_Activate(this,'activate[]');"></td>
<td width="350" class="catmenu toptab<?php echo $thclass["name"]; ?>"><?php if(empty($_GET['search'])) { echo "<a href=\"?name=".$_GET['name']."".$pagenav."\">".TABLECOLMN_NAME."</a>"; ?><br><span class="tbs-icon">&nbsp;&nbsp;</span> <?php }else echo TABLECOLMN_NAME; ?></td>
<td width="350" class="catmenu toptab<?php echo $thclass["email"]; ?>"><?php if(empty($_GET['search'])) { echo "<a href=\"?email=".$_GET['email']."".$pagenav."\">".TABLECOLMN_EMAIL."</a>"; ?><br><span class="tbs-icon">&nbsp;&nbsp;</span> <?php }else echo TABLECOLMN_EMAIL; ?></td>
<td class="catmenu toptab<?php echo $thclass["time"]; ?>"><?php if(empty($_GET['search'])) { echo "<a href=?time=".$_GET['time']."".$pagenav.">".TABLECOLMN_ADDED."</a>"; ?><br><span class="tbs-icon">&nbsp;&nbsp;</span> <?php }else echo TABLECOLMN_ADDED; ?></td>
<td width="300" class="catmenu toptab">IP</td>
<td class="catmenu toptab<?php echo $thclass["status"]; ?>"><?php if(empty($_GET['search'])) { echo "<a href=?status=".$_GET['status']."".$pagenav.">".TABLECOLMN_STATUS."</a>"; ?><br><span class="tbs-icon">&nbsp;&nbsp;</span> <?php }else echo TABLECOLMN_STATUS; ?></td>
<td class="catmenu toptab"><?php echo EDIT; ?></td>
</tr>
<?php

			while($users = $result->fetch_array())
			{
				$str_stat = ($users['status'] == 'active' ? STATUS_ACTIVE : STATUS_NOACTIVE);

				if($users['status'] == 'active') echo "<tr onMouseOver=\"this.style.background='#D2FFD2';\" onMouseOut=\"this.style.background='#eeeeee';\" class=trcat>";
				else echo "<tr class=trcat2 onMouseOver=\"this.style.background='#FD733E';\" onMouseOut=\"this.style.background='#FEC5AF';\">";

?>
<td align=center><input type="checkbox" onclick="Count_checked();" title="<?php echo TABLECOLMN_CHECKBOX; ?>" value="<?php echo $users['id_user']; ?>" name=activate[]></td>
<td><?php echo $users['name']; ?></td>
<td><?php echo $users['email']; ?></td>
<td align=center><?php echo $users['putdate_format']; ?></td>
<td align=center><a href="ip.php?ip=<?php echo $users['ip']; ?>" title="хост: <?php echo "".(@gethostbyaddr($users['ip'])).""; ?>"><?php echo $users['ip']; ?></a></td>
<?php

				if($str_stat == STATUS_ACTIVE) { echo "<td align=center>".$str_stat."</td>"; }
				else { echo "<td align=center>".$str_stat."</td>"; }

?>
<td align=center><a href="edituser.php?id_user=<?php echo $users['id_user']; ?>" title="<?php echo EDITUSER; ?>"><img border="0" src="images/edit.gif" width="24" height="24"></a></td>
</tr>
<?php

			}

			$result->close();

?>
</table><br>
<select size="1" name="action">
<option value="0">--<?php echo ACTION; ?>--</option>
<option value="1"><?php echo ACTIVATE; ?></option>
<option value="2"><?php echo REMOVE; ?></option>
</select>&nbsp;
<input type="submit" id="Apply_" value="<?php echo APPLY; ?>" disabled="" name="">
</form>
<?php

		}
		else { if($_GET['search']) echo "<font class=error>".MSG_NOTFOUND."</font><br><br>"; }

		if(empty($_GET['search']))
		{
			$query = "SELECT COUNT(*) FROM ".DB_USERS."";
			$result = $dbh->query($query);

			if(!$result) { throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!"); }

			$total = $result->fetch_assoc();

			$result->close();

			$number = intval(($total['COUNT(*)'] - 1) / $count_user) + 1;

			if($page != 1) $pervpage = '<a href=users.php?page=1'.$pl.'>&lt;&lt;</a>
												<a href=users.php?page='.($page - 1).''.$pl.'>&lt;</a> ';

			if($page != $number) $nextpage = ' <a href=users.php?page='.($page + 1).''.$pl.'>&gt;</a>
														<a href=users.php?page='.$number.''.$pl.'>&gt;&gt;</a>';

			if($page - 2 > 0) $page2left = '<a href=users.php?page='.($page - 2).''.$pl.'>...'.($page - 2).'</a> | ';
			if($page - 1 > 0) $page1left = '<a href=users.php?page='.($page - 1).''.$pl.'>'.($page - 1).'</a> | ';
			if($page + 2 <= $number) $page2right = ' | <a href=users.php?page='.($page + 2).''.$pl.'>'.($page + 2).'...</a>';
			if($page + 1 <= $number) $page1right = ' | <a href=users.php?page='.($page + 1).''.$pl.'>'.($page + 1).'</a>';
		}
		else
		{
			$query = "SELECT COUNT(*) FROM ".DB_USERS." WHERE $tmp1";
			$result = $dbh->query($query);

			if(!$result) { throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!"); }

			$total = $result->fetch_assoc();

			$result->close();

			$number = intval(($total['COUNT(*)'] - 1) / $count_user) + 1;

			if($page != 1) $pervpage = '<a href=users.php?search='.urlencode($_GET['search']).'&page=1>&lt;&lt;</a>
												<a href=users.php?search='.urlencode($_GET['search']).'&page='.($page - 1).'>&lt;</a> ';

			if($page != $number) $nextpage = ' <a href=users.php?search='.urlencode($_GET['search']).'&page='.($page + 1).'>&gt;</a>
														<a href=users.php?search='.urlencode($_GET['search']).'&page='.$number.'>&gt;&gt;</a>';

			if($page - 2 > 0) $page2left = '<a href=users.php?search='.urlencode($_GET['search']).'&page='.($page - 2).'>...'.($page - 2).'</a> | ';
			if($page - 1 > 0) $page1left = '<a href=users.php?search='.urlencode($_GET['search']).'&page='.($page - 1).'>'.($page - 1).'</a> | ';
			if($page + 2 <= $number) $page2right = ' | <a href=users.php?search='.urlencode($_GET['search']).'&page='.($page + 2).'>'.($page + 2).'...</a>';
			if($page + 1 <= $number) $page1right = ' | <a href=users.php?search='.urlencode($_GET['search']).'&page='.($page + 1).'>'.($page + 1).'</a>';
		}

		echo "<p>".NUMBER_OF_SUBSCRIBERS.": [".$total['COUNT(*)']."] ".PAGES.":&nbsp;";
		echo $pervpage.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$nextpage;
		echo "</p>";

		include "bottom.php";
	}
	else
	{
		$temp = array();

		foreach($_POST['activate'] as $id_user)
		{
			if(preg_match("|^[\d]+$|",$id_user))
			{
				$temp[] = $id_user;
			}
		}

		if($_POST["action"] == 1)
		{
			$update = "UPDATE ".DB_USERS." SET status='active' WHERE id_user IN (".implode(",",$temp).")";

			if(!$dbh->query($update))
			{
				throw new ExceptionMySQL($dbh->error,$update,"Error executing SQL query!");
			}
			else
			{
				unset($temp);
				unset($id_user);
			}
		}
		else if($_POST["action"] == 2)
		{
			$delete = "DELETE FROM ".DB_USERS." WHERE id_user IN (".implode(",",$temp).")";

			if($dbh->query($delete))
			{
				$delete = "DELETE FROM ".DB_SUB." WHERE id_user IN (".implode(",",$temp).")";

				if($dbh->query($delete))
				{
					unset($temp);
					unset($id_user);
				}
				else
				{
					throw new ExceptionMySQL($dbh->error,$delete,"Error executing SQL query!");
				}
			}
			else
			{
				throw new ExceptionMySQL($dbh->error,$delete,"Error executing SQL query!");
			}
		}
		else
		{
			unset($temp);
			unset($id_user);

			redirect(MSG_CHANGE,$_SERVER["HTTP_REFERER"],2);
		}

		redirect(MSG_CHANGE,$_SERVER["HTTP_REFERER"],2);
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