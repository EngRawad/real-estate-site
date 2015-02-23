 <? $num=5; 
			if($_GET[p]){
				$page=$_GET[p];
				$start=$num*$page-$num;
				
			}
			else {
				$page=1;
				$start=0;
			}
 $a=mysql_query("SELECT * FROM `pages`  WHERE `active`='Активно' AND DATE(`datepicker`)<= DATE(NOW())")or die(mysql_error());
   $total=mysql_num_rows($a);
   $pages=ceil ($total/$num);			
  // $start=$num*$page-$num;
   $dest=$_SERVER['PHP_SELF']."?pg=info&amp;";  
   $limit = mysql_query("SELECT * FROM `pages` WHERE `active`='Активно' AND DATE(`datepicker`)<= DATE(NOW()) ORDER BY DATE(`datepicker`) DESC LIMIT $start, $num")or die(mysql_error());?>
   
<table>	
<? while($result=mysql_fetch_assoc( $limit)){ 	
   $id=$result[id];
	?>  
		<tr>
        <td>
       <span class='latest_work merguynpoqr'><?=$result[story_name]?></span><br /><hr size="1" style="margin-top:0px;border:none; background-color:#A8231A;height:1px; color:#A8231A" />
	<?	preg_match_all('/<img[^>]+src="?\'?([^"\']+)"?\'?[^>]*>/i', $result[story], $images, PREG_SET_ORDER);
      	echo $images[0][0];
		echo $mydata ="<p style='display:inline'>".mb_substr($result[story_sthtml], 0,550, 'UTF-8')." ... </p><div class='pagination right_float' style='clear:none; display:inline'><a href='".$_SERVER['PHP_SELF']."?id=".$result[id]."'> далее </a></div>"; ?>
        </td> 
		</tr>
       <tr><td>
		
        </td></tr>
  <?
	}?> 
</table>
<div class="pagination"><? if($total>$num) mypagesnew($num,$page,$pages, $dest);?></div> 