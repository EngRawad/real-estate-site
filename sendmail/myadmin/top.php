<?php

//////////////////////////////////////
// PHP Newsletter v3.5.6            //
// (C) 2006-2013 Alexander Yanitsky //
// Website: http://janicky.com      //
// E-mail: janickiy@mail.ru         //
// Skype: janickiy                  //
//////////////////////////////////////

$url_name = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="StyleSheet" type="text/css" href="style.css">
<title>панель администратора</title>
</head>
<body>
<h1><?php echo NAME; ?></h1>
<p> <?php echo $version; ?></p>
<h2 align="center"><?php echo $title; ?></h2>
<div class="menu">
<ul>
<li class="<?php if('index.php' == $url_name) echo 'menu-active'; ?>"><a href="index.php" title="<?php echo MENU_INDEX_TITLE; ?>"><?php echo MENU_INDEX; ?></a></li>
<li class="<?php if('addsend.php' == $url_name) echo 'menu-active'; ?>"><a href="addsend.php" title="<?php echo MENU_ADDSEND_TITLE; ?>"><?php echo MENU_ADDSEND; ?></a></li>
<li class="<?php if('users.php' == $url_name) echo 'menu-active'; ?>"><a href="users.php" title="<?php echo MENU_USERS_TITLE; ?>"><?php echo MENU_USERS; ?></a></li>
<li class="<?php if('category.php' == $url_name) echo 'menu-active'; ?>"><a href="category.php" title="<?php echo MENU_CATEGORY_TITLE; ?>"><?php echo MENU_CATEGORY; ?></a></li>
<!--<li class="<?php if('settings.php' == $url_name) echo 'menu-active'; ?>"><a href="settings.php" title="<?php echo MENU_SETTINGS_TITLE; ?>"><?php echo MENU_SETTINGS; ?></a></li>
<li class="<?php if('change.php' == $url_name) echo 'menu-active'; ?>"><a href="change.php" title="<?php echo MENU_CHANGE_TITLE; ?>"><?php echo MENU_CHANGE; ?></a></li>
<li class="<?php if('backup.php' == $url_name) echo 'menu-active'; ?>"><a href="backup.php" title="<?php echo MENU_BACKUP_TITLE; ?>"><?php echo MENU_BACKUP; ?></a></li>
<li class="<?php if('export.php' == $url_name) echo 'menu-active'; ?>"><a href="export.php" title="<?php  echo MENU_EXPORT_TITLE; ?>"><?php echo MENU_EXPORT; ?></a></li>
<li class="<?php if('import.php' == $url_name) echo 'menu-active'; ?>"><a href="import.php" title="<?php echo MENU_IMPORT_TITLE; ?>"><?php echo MENU_IMPORT; ?></a></li>
<li class="<?php if('log.php' == $url_name) echo 'menu-active'; ?>"><a href="log.php" title="<?php echo MENU_LOG_TITLE; ?>"><?php echo MENU_LOG; ?></a></li>-->
</ul>
</div><br><br>
