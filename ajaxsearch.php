 <?php

require_once("admin/baza.php"); 
require_once("func.inc");


if($_REQUEST[cat] || $_REQUEST[reg] || $_REQUEST[city] || $_REQUEST[type]){
	
	$mas=selectpaint($_REQUEST[cat],$_REQUEST[reg],$_REQUEST[city],$_REQUEST[type],$_REQUEST[deal]);
	echo json_encode($mas);
}
if($_REQUEST[lot]){
	$query="SELECT `id` FROM  `main` WHERE id='$_REQUEST[lot]' AND active='1' ";
	$result = mysql_query($query) or die('MySql Error' . mysql_error());
	$numrow= mysql_num_rows($result);
	if($numrow)echo json_encode($_REQUEST[lot]);
	else echo json_encode("NO"); 
}
 ?>            
