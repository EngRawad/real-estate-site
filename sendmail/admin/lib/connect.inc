<?php

/*$db_location = "mysql.hostinger.ru"; // database host
$db_name = "u468914271_demo"; // database name
$db_user = "u468914271_olga"; // login
$db_passwd = "Power2013"; // password
$db_charset = "utf8"; // database charset

$version = "3.5.6";*/
define('__ROOT__', dirname(dirname(dirname(dirname(__FILE__)))));
require_once(__ROOT__."/admin/bazadate.inc");

$dbh = new mysqli($db_location, $db_user, $db_passwd, $db_name);

if(mysqli_connect_errno())
{
	error("Error connecting to MySQL database: Database server $db_location is not available!");
}


if(@file_exists("install.php") or @file_exists("../install.php"))
{
	error("Please remove install.php!");
}
 
$versql = $dbh->server_info;
list($major, $minor) = explode(".", $versql);
$ver = $major.".".$minor;

if((float)$ver >= 4.1 AND !empty($db_charset))
{
	$dbh->query("SET NAMES '".$db_charset."'");
}

define("DB_AUT","sm_aut");
define("DB_ATTACH","sm_attach");
define("DB_CAT","sm_category");
define("DB_CHAR","sm_charset");
define("DB_SETTING","sm_settings");
define("DB_SUB","sm_subscription");
define("DB_READY","sm_ready_send");
define("DB_SEND","sm_send");
define("DB_USERS","sm_users");
define("DB_LOG","sm_log");

define("CHARSET","utf-8");

?>