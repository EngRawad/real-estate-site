 <? $num=5; 
			if($_GET[p]){
				$page=$_GET[p];
				$start=$num*$page-$num;
				
			}
			else {
				$page=1;
				$start=0;
			}
 if(!$_GET['search'])
 {
	
   ?>	 
     <form action="services.php?pg=info" >
    <input type="text" name="search" value=""/>
    <input type="submit" title="Найти в новостях" name="submit" value="Найти" class="gosub" style="width: 60px; margin-bottom:9px; margin-left:3px; height:30px"/>
     </form> 
	<?
$a=mysql_query("SELECT * FROM `pages`  WHERE `active`='Активно' AND DATE(datepicker)<= DATE(NOW())")or die(mysql_error());
   $total=mysql_num_rows($a);
   $pages=ceil ($total/$num);			
  // $start=$num*$page-$num;
   $dest=$_SERVER['PHP_SELF']."?";  
   $limit = mysql_query("SELECT * FROM `pages` WHERE `active`='Активно' AND DATE(datepicker)<= DATE(NOW()) ORDER BY DATE(datepicker) DESC, `date_created` DESC LIMIT $start, $num")or die(mysql_error());?>
   
<table align="center">	
<? while($result=mysql_fetch_assoc( $limit)){ 	
   $id=$result[id];
	?>  
		<tr>
        <td>
       
		<? echo  '<h2 align="center" style="color:#003F4F">'.$result[story_name].'</h2><p align="center"> '.$result[datepicker].'</p>'; ?>
        <? echo $result[story]; ?>
        
		</td> 
		</tr>
       <tr><td>
		
        </td></tr>
  <?
	}?> 
</table>
<?  
  if($total>$num) mypagesnew($num,$page,$pages, $dest);          
 }
 else 
 {
	ini_set(magic_quotes_gpc,0);
	mysql_query("REPAIR TABLE `pages` QUICK");
	$search=$_GET['search'];
	$search = trim($search);
	$search = stripslashes($search);
	$search = htmlspecialchars($search);
	$search = mb_substr($search, 0, 128, 'utf-8');
	$search_hilights = preg_replace("/ +/", " ", $search);	
	$tempp=explode(" ",	$search_hilights);
	$temp=array();
	foreach($tempp as $f){
			if(mb_strlen($f,'UTF-8') > 2) $temp[]=$f;
			}
	$search_hilights=implode(" ", $temp);
	$search=mysql_real_escape_string($search_hilights);
	if($_GET['submit']=="Найти"){
		$query = "SELECT * FROM pages WHERE   `active`='Активно' AND DATE(datepicker)<= DATE(NOW())  AND (story_name  LIKE '%". str_replace(" ", "%' OR story_name LIKE '%", $search). "%' OR story_sthtml LIKE '%". str_replace(" ", "%' OR story_sthtml LIKE '%", $search). "%') ORDER BY DATE(datepicker) DESC, `date_created` DESC";}
	if(mb_strlen($search,'UTF-8') >2){
		$result=mysql_query ($query) or die(mysql_error());
		$total=mysql_num_rows($result); 
		$pages=ceil($total/$num);?>
		<table align="left"><tr><td> 
		<form action="services.php?pg=info" >
		<input type="text" name="search" value="<?=$search?>"/>
		<input type="submit" title="Найти в новостях" name="submit" value="Найти" class="gosub" style="width: 60px; margin-bottom:9px; margin-left:3px; height:30px"/>
		</form>
		</td>
		<td width="700px"> 
        <? if($total){?>
		<p style="font-size:0.8em;margin-left:10px; font-weight:bold">Результаты запроса: <?=$total?></p>
        <? }
		else { ?>
        	<p style="font-size:0.8em;margin-left:10px; font-weight:bold">По Вашему запросу ничего не найдено </p>
            <? } ?>
		</td>
		</tr>
		</table>
		<br/><br/>
		<? 	if($total>$num){
			if($_GET['submit']){
				$result=mysql_query( "SELECT * FROM pages WHERE   `active`='Активно' AND DATE(datepicker)<= DATE(NOW())  AND (story_name  LIKE '%". str_replace(" ", "%' OR story_name LIKE '%", $search). "%' OR story_sthtml LIKE '%". str_replace(" ", "%' OR story_sthtml LIKE '%", $search). "%') ORDER BY DATE(datepicker) DESC, `date_created` DESC LIMIT $start,$num") or die(mysql_error());}
			}?>
			<table align="center">
			<?  	
			while($row=mysql_fetch_array($result))
				{ 
					$rowarray=explode(" ",$row['story']);
					$i=0;
					foreach($rowarray as $e){		
						foreach($temp as $f){				
							if(mb_strrichr($e,$f,true,'utf-8')!==false){
								$skizb=mb_strrichr($e,$f,true,'utf-8');
								$verch=mb_strrichr($e,$f,false,'utf-8');
								$sovpadenie=mb_substr($e,mb_strlen($skizb,'utf-8'),mb_strlen($f,'utf-8'),'utf-8');				
								$ostatok=mb_substr($e,mb_strlen($skizb,'utf-8')+ mb_strlen($f,'utf-8'),mb_strlen($e,'utf-8')-mb_strlen($skizb,'utf-8')- mb_strlen($f,'utf-8'),'utf-8');
								$sovpadenie="<span style='background-color:#C7C7C7'>".$sovpadenie."</span>";
								$rowarray[$i]=$skizb.$sovpadenie.$ostatok;
							}
						}
						$i++;	
					}
					$row['story']= implode(" ",$rowarray);
					
					$rowarray=explode(" ",$row['story_name']);
					$i=0;
					foreach($rowarray as $e){		
						foreach($temp as $f){				
							if(mb_strrichr($e,$f,true,'utf-8')!==false){
								$skizb=mb_strrichr($e,$f,true,'utf-8');
								$verch=mb_strrichr($e,$f,false,'utf-8');
								$sovpadenie=mb_substr($e,mb_strlen($skizb,'utf-8'),mb_strlen($f,'utf-8'),'utf-8');				
								$ostatok=mb_substr($e,mb_strlen($skizb,'utf-8')+ mb_strlen($f,'utf-8'),mb_strlen($e,'utf-8')-mb_strlen($skizb,'utf-8')- mb_strlen($f,'utf-8'),'utf-8');
								$sovpadenie="<span  style='background-color:#C7C7C7'>".$sovpadenie."</span>";
								$rowarray[$i]=$skizb.$sovpadenie.$ostatok;
							}
						}
						$i++;	
					}
					$row['story_name']= implode(" ",$rowarray);
					?>    
				
				<tr>
						<td>
					   
						<? echo  '<h2 align="center" style="color:#003F4F">'.$row[story_name].'</h2><p align="center"> '.$row[datepicker].'</p>'; ?>
						<? echo $row[story]; ?>
						
						</td> 
						</tr>
					   <tr><td>
						<hr/>
						</td></tr>
				
				<?
				}
				?>
			</table> 	
			<?
			$dest="services.php?pg=info&search=".$_GET['search']."&submit=".$_GET['submit']."&";
			if($total>$num)mypagesnew($num,$page,$pages, $dest);
}
	else { ?>
    <form action="services.php?pg=info" >
    <input type="text" name="search" value=""/>
    <input type="submit" title="Найти в новостях" name="submit" value="Найти" class="gosub" style="width: 60px; margin-bottom:9px; margin-left:3px; height:30px"/>
     </form> 
<table align="center">	
 <tr>
  	<td width="700px">  
     
        	<p style="font-size:1em;margin-left:10px; font-weight:bold">Строка поиска содержит менее 3 символов, в связи с чем поиск был приостановлен.</p>
       
		</td>
  </tr>
</table>  
<? 
}
 } 
 ?>
