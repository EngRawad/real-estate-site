<?php

//////////////////////////////////////
// PHP Newsletter v3.5.6            //
// (C) 2006-2013 Alexander Yanitsky //
// Website: http://janicky.com      //
// E-mail: janickiy@mail.ru         //
// Skype: janickiy                  //
//////////////////////////////////////

if($settings['del'] == "yes")
{
	$day_clear = $settings['day']*24*3600;

	$delete = "DELETE FROM ".DB_USERS." WHERE status = 'noactive' AND time < NOW() - INTERVAL '".$settings['day']."' DAY";

	if(!$dbh->query($delete))
	{
		throw new ExceptionMySQL($dbh->error,$delete,"Error executing SQL query!");
	}
}

?>
