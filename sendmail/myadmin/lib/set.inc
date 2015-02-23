<?php

//////////////////////////////////////
// PHP Newsletter v3.5.6            //
// (C) 2006-2013 Alexander Yanitsky //
// Website: http://janicky.com      //
// E-mail: janickiy@mail.ru         //
// Skype: janickiy                  //
//////////////////////////////////////

$query = "SELECT * FROM ".DB_SETTING."";
$result = $dbh->query($query);

if(!$result)
{
	throw new ExceptionMySQL($dbh->error,$query,"Error executing SQL query!");
}

$settings = $result->fetch_array();

$result->close();

?>
