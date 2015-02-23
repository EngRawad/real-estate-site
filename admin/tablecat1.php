<?
require_once("baza.php");
$cat=$_GET['cat'];
$depend=$_GET['depend'];
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$cat_eng=$cat."_eng";
$depend_id=$depend."_id";
$depend_eng=$depend."_eng";
if(!$sidx) $sidx =1;
// connect to the database
$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
if($totalrows) {
	$limit = $totalrows;
}
$result = mysql_query("SELECT COUNT(*) AS count FROM $cat");
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];
if ($limit<0) $limit = $count+10;
if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)
$SQL = "SELECT * FROM $cat  ORDER BY $sidx $sord LIMIT $start , $limit";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());

$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	$resultcat=mysql_query("SELECT * FROM $depend WHERE `id`= '$row[$depend_id]'") or die(mysql_error());
	$rowcat=mysql_fetch_array($resultcat);
	if($rowcat[$depend]) $dependcat=$rowcat[$depend];
	else $dependcat=$rowcat[$depend_eng];
	$responce->rows[$i]['id']=$row[id];
    $responce->rows[$i]['cell']=array($row[id],$row[$cat],$row[$cat_eng],$dependcat,$row[update]);
    $i++;
}        
echo json_encode($responce);
?>
