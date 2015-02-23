<?
require_once("baza.php");
require_once("include/membersite_config.php");
/*if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}*/

$page = $_GET['page']=1; // get the requested page
$limit = $_GET['rows']=5; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction 
if(!$sidx) $sidx=1;

$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
if($totalrows) {
	$limit = $totalrows;
}

$SQL = "SELECT * FROM main ";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
$count = mysql_num_rows($result);
if ($limit<0) $limit = $count;
if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)
$SQL = "SELECT * FROM main ORDER BY $sidx $sord LIMIT $start , $limit";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());

$responce->page = $page;
$responce->total = $total_pages;  
$responce->records = $count;
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	$resultcat=mysql_query("SELECT * FROM `category` WHERE `id`= '$row[category_id]'") or die(mysql_error());
	 $rowcat=mysql_fetch_array($resultcat);
	 
	 $resultobjtype=mysql_query("SELECT * FROM `objtype` WHERE `id`= '$row[objtype_id]'") or die(mysql_error());
	 $rowobjtype=mysql_fetch_array($resultobjtype); 
	  
	  //$resultcountry=mysql_query("SELECT * FROM `country` WHERE `id`= '$row[country_id]'") or die(mysql_error());
	 //$rowcountry=mysql_fetch_array($resultcountry);
	 
	  $resultregion=mysql_query("SELECT * FROM `region` WHERE `id`= '$row[region_id]'") or die(mysql_error());
	 $rowregion=mysql_fetch_array($resultregion);
	 
	 
	  $resultcity=mysql_query("SELECT * FROM `city` WHERE `id`= '$row[city_id]'") or die(mysql_error());
	 $rowcity=mysql_fetch_array( $resultcity);
	  
	 
	 if($row[active]==1) $status="активно";
	 else $status="неактивно";
	 
	  if($row[deal]==1) $deal="Продажа";
	 else $deal="Аренда";
	 $empty='';
	 if($row[is_special_offer]==1) $is_special_offer="Да";
	 else $is_special_offer="Нет";
	  
	     $responce->rows[$i]['id']=$row[id];
    $responce->rows[$i]['cell']=array($empty,$row[id],$row[artikul],$deal,$status,$is_special_offer,$row[notes],$rowcat[category],$rowobjtype[objtype],$rowregion[region],$rowcity[city],$row[price],$row[description_ru],$row[num_of_rooms],$row[num_of_bath],$row[squarehouse],$row[year_built],$row[date_created],$row[date_updated]);
    $i++;
}        
echo json_encode($responce);

?>
