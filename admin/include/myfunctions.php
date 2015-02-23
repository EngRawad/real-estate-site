
<?

function mypages($num,$page,$pages, $dest){
	echo "<h1 align='center'>Страница ".$page." из "." ".$pages." </h1>";
		 if($page==1){?>
         	<<<
         <? }
		 else {
			 ?>
         	<a href="<?=$dest?>p=<?=$page-1?>"><<<</a>
         <? }
		
		 for($i=1;$i<$pages+1;$i++){
			 
			 if($pages<12){
				 if($i==$page)echo $i;
				 else {?>
				 	<a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a>
				 <? }
			  }
			  else {				  
				  if($page<7){
					if($i==$page)echo $i;
					if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i<10 && $i!=$page)){?>
				 	<a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a> 	<?	}
					if(($i==$page+4 && ($page+4 < $pages) && $page>5) || ($pages>10 && $i==10)) echo "..." ;				 	
				 	}
				  elseif($page>$pages-6){
					 if($i==$page)echo $i;
					if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i>$pages-9 && $i!=$page)){?>
				 	<a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a> 	<?	}
					if(($i==$page-4 && ($page-4 < $pages) && $page<$pages-9) || ($pages>10 && $i==1)) echo "..." ;				 	
				 	}	
				  else {
					if($i==$page)echo $i; 					
					if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i>$page-4 && $i<$page+4 && $i!=$page)){?>
				 		<a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a> 	<? }				 
					if(($i==$page+3 && ($page+4 < $pages)) || ($i==$page-4) && ($page-4 > 1)) echo "..." ;
				 	  }
			  	}
		 }
		 if($page==$pages ||$page>$pages-1) echo " >>>";
		 else { 
		  ?>
         	<a href="<?=$dest?>p=<?=$page+1 ?>"> >>></a>
         <? }
}

function mythumbnails($x=100,$y=100,$path,$picture,$destin, $prefix){
	$im = @imagecreatefromjpeg($path.$picture);
	$ext="jpg";
	if ($im === false) {
		$im = @imagecreatefromgif($path.$picture);
		$ext="gif";
		if ($im === false) {
			$im = @imagecreatefrompng($path.$picture);
			$ext="png";
			}
		else {
			$ext=false;
			return false;
			}
		}
	if ($im){
	$size=array();
	$size=@getimagesize($path.$picture);
	$srcx= $size[0];
	$srcy= $size[1];
	if($srcx>$srcy){ 
		$dstx= $x;
		$dsty= $srcy/$srcx*$x;
		}
	else {
		$dsty= $y;
		$dstx= $srcx/$srcy*$y;
		}
	$dest = imagecreatetruecolor($dstx,$dsty);
	
	imagecopyresampled($dest, $im, 0, 0, 0 ,0, $dstx, $dsty, $srcx, $srcy);
	$verch=imagejpeg($dest,$destin.$prefix.$picture);
	if($verch) return $destin.$prefix.$picture;
	else return false;}
}


function mypagesnew($num,$page,$pages, $dest){?>
<table  align="center">
<tr> <?
	//echo "<p align='center'>Страница ".$page." из "." ".$pages." </p>";
		 if($page==1){?>
         	 <td>
<ul id="nav">	
<li ><a style="margin-right:30px">Страница <?=$page?> из <?=$pages?> </a> <a><<<</a></li>
</ul>
</td>
         <? }
		 else {
			 ?>
             <td>
<ul id="nav">	
<li ><a style="margin-right:30px">Страница <?=$page?> из <?=$pages?> </a> <a href="<?=$dest?>p=<?=$page-1?>"><<<</a></li>
</ul>
</td>
         	
         <? }
		
		 for($i=1;$i<$pages+1;$i++){
			 
			 if($pages<12){
				 if($i==$page){ ?>
                 	<td>
					<ul id="nav">	
					 <a style="background-color:#FFF"><h2><?=$i ?></h2></a>
                     </ul>
					</td>
                 <? ; }
				 else {?>
                 <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a></li>
</ul>
</td>
				 	
				 <? }
			  }
			  else {				  
				  if($page<7){
					if($i==$page){ ?>
                 	<td>
					<ul id="nav">	
					 <a style="background-color:#FFF"><h2><?=$i ?></h2></a>
                     </ul>
					</td>
                 <? ; }
					if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i<10 && $i!=$page)){?>
                    <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a></li>
</ul>
</td>
				 	 	<?	}
					if(($i==$page+4 && ($page+4 < $pages) && $page>5) || ($pages>10 && $i==10)){ ?>
                 	<td>
					<ul id="nav">	
					 <a>...</a>
                     </ul>
					</td>
                 <? ; }				 					 	
				 	}
				  elseif($page>$pages-6){
					 if($i==$page){ ?>
                 	<td>
					<ul id="nav">	
					 <a style="background-color:#FFF"><h2><?=$i ?></h2></a>
                     </ul>
					</td>
                 <? ; }
					if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i>$pages-9 && $i!=$page)){?>
                       <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a></li>
</ul>
</td>
				 	 	<?	}
					if(($i==$page-4 && ($page-4 < $pages) && $page<$pages-9) || ($pages>10 && $i==1)){ ?>
                 	<td>
					<ul id="nav">	
					 <a>...</a>
                     </ul>
					</td>
                 <? ; }				 	
				 	}	
				  else {
					if($i==$page){ ?>
                 	<td>
					<ul id="nav">	
					 <a style="background-color:#FFF"><h2><?=$i ?></h2></a>
                     </ul>
					</td>
                 <? ; }		
					if(($i==1 && $i!=$page) || ($i==$pages && $page!=$pages) || ($i>$page-4 && $i<$page+4 && $i!=$page)){?>
                     <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$i?>"><?=$i ?></a></li>
</ul>
</td>
				 		 	<? }				 
					if(($i==$page+3 && ($page+4 < $pages)) || ($i==$page-4) && ($page-4 > 1)){ ?>
                 	<td>
					<ul id="nav">	
					 <a>...</a>
                     </ul>
					</td>
                 <? ; }				 	
				 	  }
			  	}
		 }
		 if($page==$pages ||$page>$pages-1){?>
           <td>
<ul id="nav">	
<li ><a > >>></a></li>
</ul>
</td>
         <? ;}
		 else { 
		  ?>
          <td>
<ul id="nav">	
<li ><a href="<?=$dest?>p=<?=$page+1 ?>"> >>></a></li>
</ul>
</td>
        
         <? } ?>
         </tr>
</table> <?
}

function karenicalendar($year, $month){
	$dayinmonth = cal_days_in_month(CAL_GREGORIAN,$month, $year);
	$first=jddayofweek(cal_to_jd(CAL_GREGORIAN,$month ,1 ,$year) );
	if($first==0) $first=7;
	$numofweeks =ceil(($dayinmonth+$first)/7);
	$mycalendar=array();
	for($i=1;$i<$numofweeks*7+1;$i++){
		if($i<$first || $i>($dayinmonth+$first-1))$mycalendar[$i]=" ";
		else $mycalendar[$i]=$i-$first+1;
	}
	$allweeks=array();
	for($i=1,$j=0;$i<$numofweeks+1;$i++,$j=$j+7){
		$allweeks[]=array_slice($mycalendar,$j,7);
		}
	return $allweeks;
	
}

function stylecalendar($year, $month,$day){ ?>

<table align="center" cellspacing="3px" height="150px" width="170px">
<tr>
<td>
<ul id="cal">	
<li >Mon</li>
</ul>
</td>
<td>
<ul id="cal">	
<li >Tue</li>
</ul>
</td>
<td>
<ul id="cal">	
<li >Wed</li>
</ul>
</td>
<td>
<ul id="cal">	
<li >Thu</li>
</ul>
</td>
<td>
<ul id="cal">	
<li >Fri</li>
</ul>
</td>
<td>
<ul id="calred">	
<li >Sat</li>
</ul>
</td>
<td>
<ul id="calred">	
<li >Sun</li>
</ul>
</td>
</tr>
<?
$dayinmonth = cal_days_in_month(CAL_GREGORIAN,$month, $year);
	$first=jddayofweek(cal_to_jd(CAL_GREGORIAN,$month ,1 ,$year) );
	if($first==0) $first=7;
	$numofweeks =ceil(($dayinmonth+$first)/7);
	$mycalendar=array();
	for($i=1;$i<$numofweeks*7+1;$i++){
		if($i<$first || $i>($dayinmonth+$first-1))$mycalendar[$i]=" ";
		else $mycalendar[$i]=$i-$first+1;
	}
	$calend=array();
	for($i=1,$j=0;$i<$numofweeks+1;$i++,$j=$j+7){
		$calend[]=array_slice($mycalendar,$j,7);
		}
if($numofweeks<6){
	$dop=array(" "," "," "," "," "," "," ",);
	$doppp=6-$numofweeks;
	if($doppp==2) $calend[]=$dop;
	$calend[]=$dop;
}
$q=1;
$qq=1;
foreach($calend as $f){
	 ?>
	<tr>
    <? foreach($f as $or){ ?>
    		<td> 
            <? if($or==" "){
				if($q<$first){
					if($month>1) $pastmonth = cal_days_in_month(CAL_GREGORIAN,$month-1, $year);
					else $pastmonth=31;
					$pasfirst=$pastmonth-$first+1;?>
					<font size="-1"><?=($pasfirst+$q)?></font><? ;
					$q++;			
					}
				 else {?>
					<ul id="calendar"><li ><font size="-1"><?=$qq?></font></li></ul><? ;
					$qq++; 
				 }
				}
				else { 
					$q++;
					if($day==$or  && $year==date("Y") && $month==date("n")){?>
            <ul id="calen">	
				<li ><a href='#'><?=$or?></a></li>
			</ul> <? 					
					}
					else {?>
            <ul id="calendar">	
				<li ><a href='#'><font size="-1"><?=$or?></font></a></li>
			</ul> <? ;}
			}?>
            </td>
    <?  } ?>
    </tr> <? 
}
?>
</table>
 <?
}

function monthes($year, $month){
	?>
	
<table align="center" cellspacing="3px" height="150px" width="170px">
<tr>
<td>
<? if(date("n")==1 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=1&y=<?=$year?>&status=calend'>January</a></li>
</ul>
</td>
<td>
<? if(date("n")==2 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=2&y=<?=$year?>&status=calend'>February</a></li>
</ul>
</td>
<td>
<? if(date("n")==3 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=3&y=<?=$year?>&status=calend'>March</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<? if(date("n")==4 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=4&y=<?=$year?>&status=calend'>April</a></li>
</ul>
</td>
<td>
<? if(date("n")==5 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=5&y=<?=$year?>&status=calend'>May</a></li>
</ul>
</td>
<td>
<? if(date("n")==6 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=6&y=<?=$year?>&status=calend'>June</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<? if(date("n")==7 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=7&y=<?=$year?>&status=calend'>July</a></li>
</ul>
</td>
<td>
<? if(date("n")==8 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=8&y=<?=$year?>&status=calend'>August</a></li>
</ul>
</td>
<td>
<? if(date("n")==9 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=9&y=<?=$year?>&status=calend'>September</a></li>
</ul>
</td>
</tr>
<tr>
<td>
<? if(date("n")==10 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=10&y=<?=$year?>&status=calend'>October</a></li>
</ul>
</td>
<td>
<? if(date("n")==11 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=11&y=<?=$year?>&status=calend'>November</a></li>
</ul>
</td>
<td>
<? if(date("n")==12 && $year==date("Y")){?>
<ul id="calenmon">
<? } 
else {?>
<ul id="calendarmon">
<? } ?>	
<li ><a href='<?=$_SERVER['SCRIPT_NAME']?>?m=12&y=<?=$year?>&status=calend'>December</a></li>
</ul>
</td>
</tr>
</table>
<? }
function years($year){
	?>
	
<table  align="center" cellspacing="3px" height="150px" width="170px">
<? 
$yea=1910;
$yeaa=1925;
while(!(($yea<$year && $year<$yeaa)||$yea==$year||$yeaa==$year))
{
	$yea=$yea+16;
	$yeaa=$yeaa+16;
	}
$yyyy=$yea;
for($i=1;$i<5;$i++){?>
	<tr>
    	<?  for($j=1;$j<5;$j++){ ?>
				<td>
					<? if($yyyy==date("Y")){?>
							<ul id="calen">
							<? } 
						else {?>
							<ul id="calendar">
							<? } ?>
						<li ><a style="width:40px" href='<?=$_SERVER['SCRIPT_NAME']?>?&y=<?=$yyyy?>&status=month'><?=$yyyy?></a></li>
							</ul>
				</td>
        <?
		$yyyy++;
		 } ?>
	</tr>
<? }?>
</table>
<? }
function groupyears($year){
	?>
	
<table  align="center" height="150px" width="170px">
<? 
		$yea=1910;
		$yeaa=1925;
		for($i=1;$i<5;$i++){?>
		<tr>
    	<?  for($j=1;$j<4;$j++){ ?>
				<td>
					<? if(($yea<date("Y") && date("Y")<$yeaa)||$yea==date("Y")||$yeaa==date("Y")){?>
							<ul id="calen">
							<? } 
						else {?>
							<ul id="calendar" >
							<? } ?>
						<li  ><a style="width:45px; height:32px" href='<?=$_SERVER['SCRIPT_NAME']?>?y=<?=$yea?>&status=year'><?=$yea?>-<?=$yeaa?></a></li>
							</ul>
				</td>
        <?
		$yea=$yea+16;
		$yeaa=$yeaa+16;
		 } ?>
	</tr>
<? }?>
</table>
<? }
$_SERVER['QUERY_STRING'];
$_SERVER['PHP_SELF'];
$_SERVER['SCRIPT_NAME'];
$_SERVER['REQUEST_URI'];
?>
