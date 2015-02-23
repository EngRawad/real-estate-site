<?
require_once("baza.php");

if($_POST[country]){
	$select_region='<select size="1" name="selregion"  id="selregion"><option disabled>Выберите регион</option>';
	$q = mysql_query("SELECT * FROM `region` WHERE `country_id`='$_POST[country]'");
	while($res=mysql_fetch_array($q )){
		if ($res[region]) $region=$res[region];
		else  $region=$res[region_eng];
		$select_region=$select_region."<option value=".$res[id].">".$region."</option>";
		}
		$select_region=$select_region.'</select>';
	
	$mas[region]=$select_region;
	
	echo json_encode($mas);

}
