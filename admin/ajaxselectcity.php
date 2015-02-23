<?
require_once("baza.php");
$p="<select size='1' required name='selcity' id='selcity'>";
if($_POST[key]){
	$q = mysql_query("SELECT * FROM `city` WHERE `region_id`='$_POST[key]'");
	while($res=mysql_fetch_array($q )){
		if ($res[city_rus]) $city=$res[city_rus];
		else $city=$res[city_eng];
		
	
		$p=$p."<option value=".$res[id].">".$city."</option>";
		}
		$p=$p."</select>";
	echo json_encode($p);
}
else {
	$p="<option value=77>ghjghjg</option>";
	$p=$p."</select>";
	echo json_encode($p);
}
