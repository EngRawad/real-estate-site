<?php

//////////////////////////////////////
// PHP Newsletter v3.5.6            //
// (C) 2006-2013 Alexander Yanitsky //
// Website: http://janicky.com      //
// E-mail: janickiy@mail.ru         //
// Skype: janickiy                  //
//////////////////////////////////////

if(DEBUG == 1)
{
	echo "<html><head>";
	echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=utf-8\">";
	echo "</head><body>";
	echo "<p>An error has occurred - try to use as a control object whose class is not derived from the base class field.{$exc->getMessage()}.</p>";
	echo "<p>Error in file {$exc->getFile()} at line {$exc->getLine()}.</p>";
	echo "</body></html>";
	exit();
}
else
{
	header('HTTP/1.1 500 Internal Server Error');
	header("Location: error.php");
	exit();
}

?>
