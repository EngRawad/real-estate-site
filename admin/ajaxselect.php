<?
require_once("baza.php");

if($_POST[country]){
	$select_region='<select size="1" required name="selregion" id="selregion"	onchange="runregion()"><option disabled>Выберите регион</option>';
	$q = mysql_query("SELECT * FROM `region` WHERE `country_id`='$_POST[country]'");
	while($res=mysql_fetch_array($q )){
		if ($res[region]) $region=$res[region];
		else  $region=$res[region_eng];
		$select_region=$select_region."<option value=".$res[id].">".$region."</option>";
		}
		$select_region=$select_region.'</select>';
		
	$select_city='<select size="1" required name="selcity" id="selcity"	onchange="runcity()">
	<option disabled>Выберите город</option>';
	$q = mysql_query("SELECT * FROM `city` WHERE `country_id`='$_POST[country]'");
	while($res=mysql_fetch_array($q )){
		if ($res[city]) $city=$res[city];
		else $city=$res[city_eng];
		$select_city=$select_city."<option value=".$res[id].">".$city."</option>";
		}
		$select_city=$select_city."</select>";		
	$mas[region]=$select_region;
	$mas[city]=$select_city;	
	echo json_encode($mas);

}

if($_POST[region]){

$select_city='<select size="1" required name="selcity" id="selcity"	onchange="runcity()"><option value="all">Все города</option>';
	if($_POST[region]=="all"){
		$q = mysql_query("SELECT * FROM `city`");
	}
	else{
	$q = mysql_query("SELECT * FROM `city` WHERE `region_id`='$_POST[region]'");
	}
	while($rescity=mysql_fetch_array($q )){
		if ($rescity[city]) $city=$rescity[city];
		else $city=$rescity[city_eng];
		$select_city=$select_city."<option value=".$rescity[id].">".$city."</option>";
		}
		$select_city=$select_city."</select>";		
	$mas[city]=$select_city;	
	echo json_encode($mas);
}

if($_POST[city]){
	
	$select_region='<select size="1" required name="selregion" id="selregion"	onchange="runregion()"><option value="all">Все регионы</option>';
	if($_POST[city]=="all"){
		$q = mysql_query("SELECT * FROM `region`");
	}
	else{
		$rowreg = mysql_query("SELECT * FROM `city` WHERE `id`='$_POST[city]'");
		$rowregion=mysql_fetch_array($rowreg );
		$reg_id=$rowregion[region_id];		
		$q = mysql_query("SELECT * FROM `region` WHERE `id`='$reg_id'");
	}
	while($resregion=mysql_fetch_array($q )){
		if ($resregion[region]) $region=$resregion[region];
		else  $region=$resregion[region_eng];
		$select_region=$select_region."<option selected='selected' value=".$resregion[id].">".$region."</option>";
		}
		$select_region=$select_region.'</select>';
	
	$mas[region]=$select_region;
	echo json_encode($mas);
}