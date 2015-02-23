 <div class="wrap_fullwidth small_margin">  
		<div class='mycenter'>
   <?   /* $query="SELECT `id` FROM  `main` WHERE active='1' AND deal='$_REQUEST[deal]'";
		$result = mysql_query($query) or die('MySql Error' . mysql_error());
		$numrow= mysql_num_rows($result);
		$query="SELECT `id` FROM  `main` WHERE active='1' AND deal='$_REQUEST[deal]'";
		$result = mysql_query($query) or die('MySql Error' . mysql_error());
		$numrowrent= mysql_num_rows($result);*/
					
		$add_reg=$add_city=$add_type=$add_cat=$add_reg_rent=$add_city_rent=$add_type_rent=$add_cat_rent=$sq=$sq_rent=$sq1=$sq1_rent=$prch=$prch_rent=$prcl=$prcl_rent=$rooms=$rooms_rent=$rooms1=$rooms1_rent=$bathh=$bathh_rent=$bathl=$bathl_rent="";		
		$add=" AND main.active=1 AND main.deal=1";
		$add_rent=" AND main.active=1 AND main.deal=2";
		
		if($_REQUEST[deal]==2){
			if($_REQUEST[reg]!="all" && $_REQUEST[reg])$add_reg_rent=" AND main.region_id=$_REQUEST[reg]";
			if($_REQUEST[city]!="all" && $_REQUEST[city])$add_city_rent=" AND main.city_id=$_REQUEST[city]";
			if($_REQUEST[type]!="all" && $_REQUEST[type])$add_type_rent=" AND main.objtype_id=$_REQUEST[type]";
			if($_REQUEST[cat]!="all" && $_REQUEST[cat])$add_cat_rent=" AND main.category_id=$_REQUEST[cat]";
			if($_REQUEST[sq]!=0 && $_REQUEST[sq])$sq_rent=$_REQUEST[sq];
			if($_REQUEST[sq1]<99999999 && $_REQUEST[sq1])$sq1_rent=$_REQUEST[sq1];
			if($_REQUEST[prcl]!=0 && $_REQUEST[prcl])$prcl_rent=$_REQUEST[prcl];
			if($_REQUEST[prch]<99999999 && $_REQUEST[prch])$prch_rent=$_REQUEST[prch];
			if($_REQUEST[rooms]!=0 && $_REQUEST[rooms])$rooms_rent=$_REQUEST[rooms];
			if($_REQUEST[rooms1]<99999999 && $_REQUEST[rooms1])$rooms1_rent=$_REQUEST[rooms1];
			if($_REQUEST[bathl]!=0 && $_REQUEST[bathl])$bathl_rent=$_REQUEST[bathl];
			if($_REQUEST[bathh]<99999999 && $_REQUEST[bathh])$bathh_rent=$_REQUEST[bathh];
		}
		else {
			if($_REQUEST[reg]!="all" && $_REQUEST[reg])$add_reg=" AND main.region_id=$_REQUEST[reg]";
			if($_REQUEST[city]!="all" && $_REQUEST[city])$add_city=" AND main.city_id=$_REQUEST[city]";
			if($_REQUEST[type]!="all" && $_REQUEST[type]){
				$querytype="SELECT `id` FROM  `main` WHERE active='1' AND deal='1' AND objtype_id=$_REQUEST[type]";
				$resulttype = mysql_query($querytype) or die('MySql Error' . mysql_error());
				$numrowtype= mysql_num_rows($resulttype);
				if($numrowtype) $add_type=" AND main.objtype_id=$_REQUEST[type]";
			}
			if($_REQUEST[cat]!="all" && $_REQUEST[cat])$add_cat=" AND main.category_id=$_REQUEST[cat]";
			if($_REQUEST[sq]!=0 && $_REQUEST[sq])$sq=$_REQUEST[sq];
			if($_REQUEST[sq1]<99999999 && $_REQUEST[sq1])$sq1=$_REQUEST[sq1];
			if($_REQUEST[prcl]!=0 && $_REQUEST[prcl])$prcl=$_REQUEST[prcl];
			if($_REQUEST[prch]<99999999 && $_REQUEST[prch])$prch=$_REQUEST[prch]; 
			if($_REQUEST[rooms]!=0 && $_REQUEST[rooms])$rooms=$_REQUEST[rooms];
			if($_REQUEST[rooms1]<99999999 && $_REQUEST[rooms1])$rooms1=$_REQUEST[rooms1];
			if($_REQUEST[bathl]!=0 && $_REQUEST[bathl])$bathl=$_REQUEST[bathl];
			if($_REQUEST[bathh]<99999999 && $_REQUEST[bathh])$bathh=$_REQUEST[bathh];
		}
		
		?>
        
        <span class='latest_work merguynpoqr'>Наши предложения:</span>
        	<div class='content_fullwidth'> 
        		<div id="tabb">
					<ul>
                 <? if($_REQUEST[deal]==2){?>
						<li><a href="#tabs1">Продажа: <span id="tiv" class="tivfont redd"><?=$othercount?></span></a></li>
                        <li><a href="#tabs2">Аренда: <span id="tivrent" class="tivfont redd"><?=$count?></span></a></li> 
                        <? }
					else {?>
                    	<li><a href="#tabs1">Продажа: <span id="tiv" class="tivfont redd"><?=$count?></span></a></li>
                        <li><a href="#tabs2">Аренда: <span id="tivrent" class="tivfont redd"><?=$othercount?></span></a></li> 
                    <? }?>
					</ul>
					<div id="tabs1" >
                    	<div style="padding:8px 0 0 0 ">
						 	<form  action="javascript:void(0)">
                				<table style="text-align:right"><tr>
            						
                        			<td><label>Категория</label></td>
                                        <td><div id="category">
                        						<select size="1" name="selcategory" onchange="go()"  id="selcategory"  class="searchArea myselect">
                         						<option selected="selected" value="all">Все </option>
                       						<? 	$query="SELECT DISTINCT category.category,category.id FROM  category,main WHERE main.category_id=category.id  ".$add.$add_reg.$add_city.$add_type;
												$result = mysql_query($query) or die('MySql Error' . mysql_error());
												while($row=mysql_fetch_array($result)){
													if($row[id]==$_REQUEST[cat] && $_REQUEST[deal]!=2){?>
                                            	<option selected="selected"  value="<?=$row[id]?>"> <?=$row[category]?></option>
                                            		<? }
                                            		else{?>
												<option value="<?=$row[id]?>"> <?=$row[category]?></option>
													 <? }
                                                  }?>
												</select>
                        					</div></td>
                                   
                 						<td><label>Побережье</label></td>
                                        <td>
                                        	<div id="region">
                        						<select size="1"  name='selregion'  onchange="go()" id="selregion"  class="searchArea myselect">
                                                <option selected="selected" value="all">Все </option>
                   							<? 	$query="SELECT DISTINCT region.region,region.id FROM  main,region,city WHERE main.city_id=city.id AND region.id=city.region_id ".$add.$add_city.$add_type.$add_cat;
												$result = mysql_query($query) or die('MySql Error' . mysql_error());
												while($row=mysql_fetch_array($result)){
													if($row[id]==$_REQUEST[reg] && $_REQUEST[deal]!=2){?>
                                            			<option selected="selected"  value="<?=$row[id]?>"> <?=$row[region]?></option>
                                           			 <? }
                                            		else{?>
														<option value="<?=$row[id]?>"> <?=$row[region]?></option>
										 			<? }
												}?> 
                        						</select> 
                        					</div>
                                            </td>
                                         
                 		 				<td><label>Город</label></td>
                                        <td>
                                        <div id="city">
                        					<select size="1" name='selcity' id="selcity" onchange="go()" class="searchArea myselect">
                             				<option selected="selected" value="all">Все </option>
                              			<?	$query="SELECT DISTINCT city.city,city.id FROM  main,region,city WHERE main.city_id=city.id AND region.id=city.region_id ".$add.$add_type.$add_cat.$add_reg;
											$result = mysql_query($query) or die('MySql Error' . mysql_error());
											while($row=mysql_fetch_array($result)){
												if($row[id]==$_REQUEST[city] && $_REQUEST[deal]!=2){?>
                                            		<option selected="selected"  value="<?=$row[id]?>"> <?=$row[city]?></option>
                                           		 <? }
                                            	else{?>
													<option value="<?=$row[id]?>"> <?=$row[city]?></option>
												 <? }
											}?> 
                        					</select> 
                        				</div>
                                        </td>
                                   
                        				<td><label>Тип</label></td>
                                        	<td><div id="objtype">
                        						<select name="selobjtype" id="selobjtype" onchange="go()" class="searchArea myselect"> 
                             					<option selected="selected" value="all">Все </option>
                             				<? 	$query="SELECT DISTINCT objtype.objtype,objtype.id FROM  objtype,main WHERE main.objtype_id=objtype.id ".$add.$add_cat.$add_reg.$add_city;
												$result = mysql_query($query) or die('MySql Error' . mysql_error());
												while($row=mysql_fetch_array($result)){
													if($row[id]==$_REQUEST[type] && $_REQUEST[deal]!=2){?>
                                            			<option selected="selected"  value="<?=$row[id]?>"> <?=$row[objtype]?></option>
                                            		<? }
                                            		else{?>
														<option value="<?=$row[id]?>"> <?=$row[objtype]?></option>
													 <? }
													}?> 
                        						</select>
                                            </div></td>
  									</tr>
                       				<tr>
                        			<td><label>Площадь m<sup>2</sup></label></td> 
                        			<td align="left"><input maxlength="6" style="width:70px" type="text" value="<?=$sq ?>"  name="square" id="square" class="numint"   onkeyup="go()"  />
                      - <input maxlength="6" style="width:70px" class="numint" value="<?=$sq1?>" type="text" onkeyup="go()"  name="square1" id="square1" /></td>
                      				<td><label>Спальни</label></td>
                      				<td align="left"><input maxlength="2" style="width:70px" class="numint" value="<?=$rooms ?>" type="text" onkeyup="go()" name="num_of_rooms" id="num_of_rooms"  />
                      - <input maxlength="2" style="width:70px" class="numint" value="<?=$rooms1 ?>" type="text" onkeyup="go()" name="num_of_rooms1" id="num_of_rooms1" /></td>
                      				<td><label>Цена €</label></td>
                    				<td align="left"><input maxlength="8" style="width:70px" type="text" value="<?=$prcl ?>" class="numint" onkeyup="go()"  name="prcl" id="prcl"  />
                     - <input maxlength="8" style="width:70px" type="text" value="<?=$prch ?>" class="numint" onkeyup="go()" name="prch" id="prch"  /></td> 
                     				<td><label>Ванны</label></td>
                    				<td align="left"><input maxlength="2" style="width:70px" type="text" value="<?=$bathl ?>" class="numint" onkeyup="go()"  name="bathl" id="bathl"  />
                     - <input maxlength="2" style="width:70px" type="text" value="<?=$bathh ?>" class="numint" onkeyup="go()" name="bathh" id="bathh"  /></td> 
                        			
                         			
                                    </tr></table>
                         
                     <input type="hidden"  value="" id="tivh" name="tivh" />
                     <a href='#' onclick='gogo()' class='show_portfolio'>Найти</a>
                   	 <a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=1'  class='show_portfolio'>Все предложения</a>
                     <a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;sow=spec&amp;deal=1' style="color:#F00"  class='show_portfolio'>Специальные предложения</a>  
                       		
            </form>
					</div>
                    </div>
					<div id="tabs2">
                    	<div style="padding:8px 0 0 0 ;">
   						 <form action="javascript:void(0)">
                				<table style="text-align:right"><tr>
            						
                        			<td><label>Категория</label></td>
                                        <td><div id="categoryrent">
                        						<select size="1" name="selcategoryrent" onchange="gorent()"  id="selcategoryrent"  class="searchArea myselect">
                         						<option selected="selected" value="all">Все </option>
                       						<? 	$query="SELECT DISTINCT category.category,category.id FROM  category,main WHERE main.category_id=category.id  ".$add_rent.$add_reg_rent.$add_city_rent.$add_type_rent;
												$result = mysql_query($query) or die('MySql Error' . mysql_error());
												while($row=mysql_fetch_array($result)){
                                        			if($row[id]==$_REQUEST[cat] && $_REQUEST[deal]==2){?>
                                            			<option selected="selected"  value="<?=$row[id]?>"> <?=$row[category]?></option>
                                            		<? }
                                            		else{?>
														<option value="<?=$row[id]?>"> <?=$row[category]?></option>
										 			<? }
												}?> 
												</select>
                        					</div></td>
                                   
                 						<td><label>Побережье</label></td>
                                        <td>
                                        	<div id="regionrent">
                        						<select size="1"  name='selregionrent'  onchange="gorent()" id="selregionrent"  class="searchArea myselect">
                                                <option selected="selected" value="all">Все </option>
                   							<? 	$query="SELECT DISTINCT region.region,region.id FROM  main,region,city WHERE main.city_id=city.id AND region.id=city.region_id ".$add_rent.$add_city_rent.$add_type_rent.$add_cat_rent;
												$result = mysql_query($query) or die('MySql Error' . mysql_error());
												while($row=mysql_fetch_array($result)){
													if($row[id]==$_REQUEST[reg] && $_REQUEST[deal]==2){?>
                                            			<option selected="selected"  value="<?=$row[id]?>"> <?=$row[region]?></option>
                                            		<? }
                                            		else{?>
														<option value="<?=$row[id]?>"> <?=$row[region]?></option>
													 <? }
													}?> 
                        						</select> 
                        					</div>
                                       	</td>
                                    	<td><label>Город</label></td>
                                        <td>
                                        	<div id="cityrent">
                        						<select size="1" name='selcityrent' id="selcityrent" onchange="gorent()" class="searchArea myselect">
                             						<option selected="selected" value="all">Все </option>
                              					<?	$query="SELECT DISTINCT city.city,city.id FROM  main,region,city WHERE main.city_id=city.id AND region.id=city.region_id ".$add_rent.$add_type_rent.$add_cat_rent.$add_reg_rent;
													$result = mysql_query($query) or die('MySql Error' . mysql_error());
													while($row=mysql_fetch_array($result)){
														if($row[id]==$_REQUEST[city] && $_REQUEST[deal]==2){?>
                                            				<option selected="selected"  value="<?=$row[id]?>"> <?=$row[city]?></option>
                                           		 		<? }
                                            			else{?>
															<option value="<?=$row[id]?>"> <?=$row[city]?></option>
										 				<? }
													}?> 
                        						</select> 
                        					</div>
                                        </td>
                                   		<td><label>Тип</label></td>
                                        <td><div id="objtyperent">
                        					<select name="selobjtyperent" id="selobjtyperent" onchange="gorent()" class="searchArea myselect"> 
                             					<option selected="selected" value="all">Все </option>
                             				<? 	$query="SELECT DISTINCT objtype.objtype,objtype.id FROM  objtype,main WHERE main.objtype_id=objtype.id ".$add_rent.$add_cat_rent.$add_reg_rent.$add_city_rent;
												$result = mysql_query($query) or die('MySql Error' . mysql_error());
												while($row=mysql_fetch_array($result)){
													if($row[id]==$_REQUEST[type] && $_REQUEST[deal]==2){?>
                                            			<option selected="selected"  value="<?=$row[id]?>"> <?=$row[objtype]?></option>
                                           			 <? }
                                            		else{?>
														<option value="<?=$row[id]?>"> <?=$row[objtype]?></option>
										 			<? }
													}?> 
                        						</select>
                                            </div>
                                         </td>
  									</tr>
                       				<tr>
                        				<td><label>Площадь m<sup>2</sup></label></td> 
                        				<td align="left"><input maxlength="6" style="width:70px" type="text" value="<?=$sq_rent ?>"  name="squarerent" id="squarerent" class="numint"   onkeyup="gorent()"  />
                      - <input maxlength="6" style="width:70px" class="numint" value="<?=$sq1_rent ?>" type="text" onkeyup="gorent()"  name="square1" id="square1rent" /></td>
                      					<td><label>Спальни</label></td>
                      					<td align="left"><input maxlength="2" style="width:70px" class="numint" value="<?=$rooms_rent ?>" type="text" onkeyup="gorent()" name="num_of_roomsrent" id="num_of_roomsrent"  />
                      - <input maxlength="2" style="width:70px" class="numint" value="<?=$rooms1_rent ?>" type="text" onkeyup="gorent()" name="num_of_rooms1" id="num_of_rooms1rent" /></td> 
                   						<td><label>Цена €</label></td>
                    					<td align="left"><input maxlength="8" style="width:70px" type="text" value="<?=$prcl_rent ?>" class="numint" onkeyup="gorent()"  name="prclrent" id="prclrent"  />
                     - <input maxlength="8" style="width:70px" type="text" value="<?=$prch_rent ?>" class="numint" onkeyup="gorent()" name="prchrent" id="prchrent"  /></td>
                          
                    <td><label>Ванны</label></td>
                    <td align="left"><input maxlength="2" style="width:70px" type="text" value="<?=$bathl_rent ?>" class="numint" onkeyup="gorent()"  name="bathlrent" id="bathlrent"  />
                     - <input maxlength="2" style="width:70px" type="text" value="<?=$bathh_rent ?>" class="numint" onkeyup="gorent()" name="bathhrent" id="bathhrent"  /></td>
                     
                 </tr>
            </table>
            <input type="hidden"  value="" id="tivhrent" name="tivhrent" />
     		<a href='#' onclick='gogorent()' class='show_portfolio'>Найти</a>
            <a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=2'  class='show_portfolio'>Все предложения</a>
            <a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;sow=spec&amp;deal=2' style="color:#F00"  class='show_portfolio'>Специальные предложения</a>
            </form>
		</div>
     </div>
  </div>
  
  <ul  class="pagination">
     <? if(isset($_SESSION['looked'])) {?>
            <li style="display:inline; float:right"><a style="background:#3399FF; font-size:12px" href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;sow=look'>Просмотренные предложения</a></li>
         <? }?>
       		<li style="display:inline; float:right" >
            <form action="javascript:void(0)" onsubmit="return submit_golot(this)">
            <input onblur="$('#errorlot').css('display','none'); setDefault(this);" onfocus="setClear(this);" value=" номер лота"  style="width:90px; float:left; margin:2px -2px 0px 0px; ; border:solid 2px #81A63A; height:20px"  class="numint" type="text" name="lot" id="lot"/>
            <a onclick="golot($('#lot').val())" style="background:#81A63A; font-size:12px" href='javascript:void(0)'>Показать лот</a>
        	</form>
            </li>
            <li id="errorlot" style="display:none; float:right; border:solid #81A63A; margin-right:3px; margin-top:2px">
               	<h3 style="margin:0px 5px 0px 5px;">Нет такого лота.</h3>
            </li>
    </ul>
 </div>
</div>
</div>