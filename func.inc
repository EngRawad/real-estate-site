<?
function selsel($sel_value,$sel,$add,$deal){
	$query="SELECT DISTINCT ".$sel.",".$sel."_id FROM ".$sel.",main WHERE main.active=1 AND main.deal=".$deal." AND main.".$sel."_id=".$sel.".id ".$add;
	$result = mysql_query($query) or die('MySql Error' . mysql_error());
	$select="";
	while($row=mysql_fetch_array($result)){
		$already_selected=0;
		if($sel_value==$row[$sel."_id"]){
			$select = $select."<option selected='selected' value=".$row[$sel."_id"].">".$row[$sel]."</option>";
			$already_selected=1; 
		}
		else{
			$select = $select."<option value=".$row[$sel."_id"].">".$row[$sel]."</option>";
			}
		}
	if($already_selected) {
		if($deal==2) $select="<select size='1' onChange='gorent()' name='sel".$sel."rent' id='sel".$sel."rent' class='searchArea myselect'><option  value='all' >Все </option>".$select."</select>";
		else $select="<select size='1' onChange='go()' name='sel".$sel."' id='sel".$sel."' class='searchArea myselect'><option  value='all' >Все </option>".$select."</select>";
	}
	else {
		if($deal==2) $select="<select size='1' onChange='gorent()' name='sel".$sel."rent' id='sel".$sel."rent' class='searchArea myselect'><option selected='selected' value='all' >Все </option>".$select."</select>";
		else $select="<select size='1' onChange='go()' name='sel".$sel."' id='sel".$sel."' class='searchArea myselect'><option selected='selected' value='all' >Все </option>".$select."</select>";
	}
	return $select;
}
function selectpaint($category_value, $region_value,$city_value, $objtype_value,$deal)
{
	$add="";
	if($category_value!="all")$add.=" AND main.category_id=".$category_value;
	if($region_value!="all")$add.=" AND main.region_id=".$region_value;
	if($city_value!="all")$add.=" AND main.city_id=".$city_value;
	if($objtype_value!="all")$add.=" AND main.objtype_id=".$objtype_value;	
	
	if($_REQUEST[sq] && $_REQUEST[sq1])$add.=" AND `squarehouse` >= '$_REQUEST[sq]' AND `squarehouse`<= '$_REQUEST[sq1]'";
	if($_REQUEST[prcl] && $_REQUEST[prch])$add.=" AND `price`>= '$_REQUEST[prcl]' AND `price`<= '$_REQUEST[prch]'";
	if($_REQUEST[rooms] && $_REQUEST[rooms1])$add.=" AND `num_of_rooms`>= '$_REQUEST[rooms]' AND `num_of_rooms`<= '$_REQUEST[rooms1]'";
	if($_REQUEST[bathl] && $_REQUEST[bathh]) $add.=" AND `num_of_bath`>= '$_REQUEST[bathl]' AND `num_of_bath`<= '$_REQUEST[bathh]'";
	
	$mas[category] = selsel($category_value,"category",$add,$deal);	
	$mas[region] = selsel($region_value,"region",$add,$deal);	
	$mas[city] = selsel($city_value,"city",$add,$deal);	
	$mas[objtype] = selsel($objtype_value,"objtype",$add,$deal);
	
	$query="SELECT `id` FROM  `main` WHERE active=1 AND deal=".$deal."" .$add;
	$result = mysql_query($query) or die('MySql Error' . mysql_error());
	$numrow= mysql_num_rows($result);
	$mas[numrow]=$numrow;
	return $mas;
}
function chekdata($mydata){
		$mydata = strip_tags($mydata);
		$mydata = trim($mydata);
		$mydata = htmlspecialchars($mydata);
		$mydata = mysql_escape_string($mydata);
		$mydata = mb_substr($mydata, 0,140, 'UTF-8');
		return $mydata;
}
function chekdigit($digit){
	if($digit<0)$digit=0;
	if($digit>99999998)$digit=99999998;
	return $digit;
}
function mypagesnew($num,$page,$pages, $dest){
 	if($page==1){?>
    	<a class="inactive">Страница <?=$page?> из <?=$pages?> </a> <a>&lt;&lt;&lt;</a>
	<? }
	else { ?>
 		<a class="inactive">Страница <?=$page?> из <?=$pages?> </a> <a class="inactive" href="<?=$dest?>p=<?=$page-1?>">&lt;&lt;&lt;</a>
    <? }
	for($i=1;$i<$pages+1;$i++){
		if($pages<12){
			if($i==$page){ ?>
               <span class="current"><?=$i ?></span>
           	<? ; }
			else {?>
 				<a class="inactive" href="<?=$dest?>p=<?=$i?>"><?=$i ?></a>
			<? }
		}
		else {				  
			if($page<7){
				if($i==$page){ ?>
               		<span class="current"><?=$i ?></span>
            	<? ; }
				if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i<10 && $i!=$page)){?>
					<a class="inactive" href="<?=$dest?>p=<?=$i?>"><?=$i ?></a>
				<?	}
				if(($i==$page+4 && ($page+4 < $pages) && $page>5) || ($pages>10 && $i==10)){ ?>
            		<a class="inactive">...</a>
             	<? ; }				 					 	
			}
			elseif($page>$pages-6){
				if($i==$page){ ?>
              		<span class="current"><?=$i ?></span>
            	<? ; }
				if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i>$pages-9 && $i!=$page)){?>
					<a class="inactive" href="<?=$dest?>p=<?=$i?>"><?=$i ?></a>
				<?	}
				if(($i==$page-4 && ($page-4 < $pages) && $page<$pages-9) || ($pages>10 && $i==1)){ ?>
            		<a class="inactive">...</a>
             	<? ; }				 	
			}	
			else {
				if($i==$page){ ?>
                 	<span class="current"><?=$i ?></span>
               	<? ; }		
				if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i>$page-4 && $i<$page+4 && $i!=$page)){?>
					<a class="inactive" href="<?=$dest?>p=<?=$i?>"><?=$i ?></a>
				<? }				 
				if(($i==$page+3 && ($page+4 < $pages)) || ($i==$page-4) && ($page-4 > 1)){ ?>
               		<a class="inactive">...</a>
              	<? ; }				 	
			}
		}
	}
	if($page==$pages ||$page>$pages-1){?>
		<a class="inactive"> &gt;&gt;&gt;</a> 
	<? ;}
	else { ?>
		<a class="inactive" href="<?=$dest?>p=<?=$page+1 ?>"> &gt;&gt;&gt;</a>
	<? }
}


$pattern = '([^0-9])';
if($_REQUEST[deal]==1 || $_REQUEST[deal]==2)$_REQUEST[deal] = $_REQUEST[deal];
else $_REQUEST[deal]="";
if($_REQUEST[cat])	$_REQUEST[cat] = chekdata($_REQUEST[cat]);
if($_REQUEST[reg])	$_REQUEST[reg] = chekdata($_REQUEST[reg]);
if($_REQUEST[city])	$_REQUEST[city] = chekdata($_REQUEST[city]);
if($_REQUEST[type])	$_REQUEST[type] = chekdata($_REQUEST[type]);
if($_REQUEST[sq])	$_REQUEST[sq] = preg_replace($pattern,"",chekdigit(chekdata($_REQUEST[sq])));
if($_REQUEST[sq1])	$_REQUEST[sq1] = preg_replace($pattern,"",chekdigit(chekdata($_REQUEST[sq1])));
if($_REQUEST[rooms]) $_REQUEST[rooms] = preg_replace($pattern,"",chekdigit(chekdata($_REQUEST[rooms])));
if($_REQUEST[rooms1]) $_REQUEST[rooms1] = preg_replace($pattern,"",chekdigit(chekdata($_REQUEST[rooms1])));
if($_REQUEST[prcl])	$_REQUEST[prcl] = preg_replace($pattern,"",chekdigit(chekdata($_REQUEST[prcl])));
if($_REQUEST[prch])	$_REQUEST[prch] = preg_replace($pattern,"",chekdigit(chekdata($_REQUEST[prch])));
if($_REQUEST[bathl])$_REQUEST[bathl] = preg_replace($pattern,"",chekdigit(chekdata($_REQUEST[bathl])));
if($_REQUEST[bathh])$_REQUEST[bathh] = preg_replace($pattern,"",chekdigit(chekdata($_REQUEST[bathh])));

if($_REQUEST[sq] || $_REQUEST[sq1]){
	if(!$_REQUEST[sq])$_REQUEST[sq]=1;
	if(!$_REQUEST[sq1])$_REQUEST[sq1]=99999999;
}
if($_REQUEST[sq] && $_REQUEST[sq1]){
	if($_REQUEST[sq]>$_REQUEST[sq1]){
		$temp=$_REQUEST[sq1];
		$_REQUEST[sq1]=$_REQUEST[sq];  
		$_REQUEST[sq]=$temp;
		}
}  
if($_REQUEST[rooms] || $_REQUEST[rooms1]){
	if(!$_REQUEST[rooms])$_REQUEST[rooms]=1;
	if(!$_REQUEST[rooms1])$_REQUEST[rooms1]=99999999;
}
if($_REQUEST[rooms] && $_REQUEST[rooms1]){
	if($_REQUEST[rooms]>$_REQUEST[rooms1]){
		$temp=$_REQUEST[rooms1];
		$_REQUEST[rooms1]=$_REQUEST[rooms];  
		$_REQUEST[rooms]=$temp;
		}
}
if($_REQUEST[prcl] || $_REQUEST[prch]){
	if(!$_REQUEST[prcl])$_REQUEST[prcl]=1;
	if(!$_REQUEST[prch])$_REQUEST[prch]=99999999;
}
if($_REQUEST[prcl] && $_REQUEST[prch]){
	if($_REQUEST[prcl]>$_REQUEST[prch]){
		$temp=$_REQUEST[prch];
		$_REQUEST[prch]=$_REQUEST[prcl];  
		$_REQUEST[prcl]=$temp;
		}
}
if($_REQUEST[bathl] || $_REQUEST[bathh]){
	if(!$_REQUEST[bathl])$_REQUEST[bathl]=1;
	if(!$_REQUEST[bathh])$_REQUEST[bathh]=99999999;
}
if($_REQUEST[bathl] && $_REQUEST[bathh]){
	if($_REQUEST[bathl]>$_REQUEST[bathh]){
		$temp=$_REQUEST[bathh];
		$_REQUEST[bathh]=$_REQUEST[bathl];  
		$_REQUEST[bathl]=$temp;
		}
}
?>