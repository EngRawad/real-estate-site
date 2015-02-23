<?
function tablnew($tablename,$getname,$lablename,$lablename_eng,$lablename2){
	$tablename_eng=$tablename.'_eng';
	$getname_eng=$getname.'_eng';
	$tabletable=$tablename."table";
	$tablepager=$tablename."pager";?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#<?=$tablename?>').arcticmodal();
		$('#<?=$tablename_eng?>').arcticmodal();
		$('#<?=$getname?>').arcticmodal();
		$('#<?=$getname_eng?>').arcticmodal();
		cattable("<?=$tablename?>","<?=$lablename?>","<?=$lablename_eng?>");
	});
	</script>
<? mysql_query("CREATE TABLE IF NOT EXISTS `$tablename` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `$tablename` text NOT NULL,
  `$tablename_eng` text NOT NULL,
   KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12") or die(mysql_error());
	$flag=0; 
	$flag_eng=0;
	 if($_POST[ru]){
		$input_text = strip_tags($_POST[ru]);
		$input_text	= trim($input_text);
		$input_text = htmlspecialchars($input_text);
		$input_text = mysql_escape_string($input_text);
		$input_text = mb_substr($input_text, 0,140, 'UTF-8');
		if($input_text=="" ||$input_text==" ") { ?>
          <div style="display: none;">
    		<div class="box-modal" id="<?=$tablename?>">
        		<div class="box-modal_close arcticmodal-close">закрыть</div>
        		Невозможно добавить.Используются недопустимые символы или пустая строка в названии.
    		</div>
		  </div>
         <? }
		else{
			$result=mysql_query("SELECT * FROM `$tablename` WHERE `$tablename`='$input_text'");
			$total=mysql_num_rows($result); 
			if($total)$flag=1;
			if(!$flag) {
				$rres=mysql_query ("INSERT INTO $tablename($tablename) VALUES('$input_text')") or die(mysql_error());
				$id=mysql_insert_id();
				if($_POST[eng]){
		$input_text_eng = strip_tags($_POST[eng]);
		$input_text_eng	= trim($input_text_eng);
		$input_text_eng = htmlspecialchars($input_text_eng);
		$input_text_eng = mysql_escape_string($input_text_eng);
		$input_text_eng = mb_substr($input_text_eng, 0,140, 'UTF-8');
		if($input_text_eng=="" ||$input_text_eng==" ") { ?>
          <div style="display: none;">
    		<div class="box-modal" id="<?=$tablename_eng?>">
        		<div class="box-modal_close arcticmodal-close">закрыть</div>
        		Невозможно добавить.Используются недопустимые символы или пустая строка в английском названии.
    		</div>
		  </div>
         <? }
		else{
			$result=mysql_query("SELECT * FROM `$tablename` WHERE `$tablename_eng`='$input_text_eng'");
			$total=mysql_num_rows($result); 
			if($total)$flag_eng=1;
			if(!$flag_eng) {
				$rres=mysql_query ("UPDATE  `$tablename` SET `$tablename_eng`='$input_text_eng' WHERE `id`='$id'") or die(mysql_error());
			}
			if($flag_eng) {?>
        		<div style="display: none;">
    				<div class="box-modal" id="<?=$getname_eng?>">
        				<div class="box-modal_close arcticmodal-close">закрыть</div>
        				Невозможно добавить.Запись на английском существует.
    				</div>
		  		</div>
			<? }
		}
	 }
			}
			if($flag) {?>
        		<div style="display: none;">
    				<div class="box-modal" id="<?=$getname?>">
        				<div class="box-modal_close arcticmodal-close">закрыть</div>
        				Невозможно добавить.Запись существует.
    				</div>
		  		</div>
			<? }
		}
	 }
	 
	 ?>
     
	<div class="mytable" style="padding:15px">
    <h2>Добавить <?=$lablename2?></h2>
  	<form  action="" method="post">    
    
    <label><?=$lablename?>:</label><br/>
    <input required="required"  type='text' name='ru' maxlength="50" /><br/>
    
    <input type="submit" name="add" value="добавить" />
    </form>
    </div>
    <br />
   	<span><table id="<?=$tabletable?>"><tr><td></td></tr></table></span>
    <div id="<?=$tablepager?>"></div>
<? }
function tablnewprop($tablename,$getname,$lablename,$lablename_eng,$lablename2){
	$tablename_eng=$tablename.'_eng';
	$getname_eng=$getname.'_eng';
	$tabletable=$tablename."table";
	$tablepager=$tablename."pager";?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#<?=$tablename?>').arcticmodal();
		$('#<?=$tablename_eng?>').arcticmodal();
		$('#<?=$getname?>').arcticmodal();
		$('#<?=$getname_eng?>').arcticmodal();
		cattableprop("<?=$tablename?>","<?=$lablename?>","<?=$lablename_eng?>");
	});
	</script>
<? mysql_query("CREATE TABLE IF NOT EXISTS `$tablename` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `$tablename` text NOT NULL,
  `$tablename_eng` text NOT NULL,
   KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12") or die(mysql_error());
	$flag=0; 
	$flag_eng=0;
	 if($_POST[ru]){
		$input_text = strip_tags($_POST[ru]);
		$input_text	= trim($input_text);
		$input_text = htmlspecialchars($input_text);
		$input_text = mysql_escape_string($input_text);
		$input_text = mb_substr($input_text, 0,140, 'UTF-8');
		if($input_text=="" ||$input_text==" ") { ?>
          <div style="display: none;">
    		<div class="box-modal" id="<?=$tablename?>">
        		<div class="box-modal_close arcticmodal-close">закрыть</div>
        		Невозможно добавить.Используются недопустимые символы или пустая строка в названии.
    		</div>
		  </div>
         <? }
		else{
			$result=mysql_query("SELECT * FROM `$tablename` WHERE `$tablename`='$input_text'");
			$total=mysql_num_rows($result); 
			if($total)$flag=1;
			if(!$flag) {
				$rres=mysql_query ("INSERT INTO $tablename($tablename) VALUES('$input_text')") or die(mysql_error());
				$id=mysql_insert_id();
				if($_POST[eng]){
		$input_text_eng = strip_tags($_POST[eng]);
		$input_text_eng	= trim($input_text_eng);
		$input_text_eng = htmlspecialchars($input_text_eng);
		$input_text_eng = mysql_escape_string($input_text_eng);
		$input_text_eng = mb_substr($input_text_eng, 0,140, 'UTF-8');
		if($input_text_eng=="" ||$input_text_eng==" ") { ?>
          <div style="display: none;">
    		<div class="box-modal" id="<?=$tablename_eng?>">
        		<div class="box-modal_close arcticmodal-close">закрыть</div>
        		Невозможно добавить.Используются недопустимые символы или пустая строка в английском названии.
    		</div>
		  </div>
         <? }
		else{
			$result=mysql_query("SELECT * FROM `$tablename` WHERE `$tablename_eng`='$input_text_eng'");
			$total=mysql_num_rows($result); 
			if($total)$flag_eng=1;
			if(!$flag_eng) {
				$rres=mysql_query ("UPDATE  `$tablename` SET `$tablename_eng`='$input_text_eng' WHERE `id`='$id'") or die(mysql_error());
			}
			if($flag_eng) {?>
        		<div style="display: none;">
    				<div class="box-modal" id="<?=$getname_eng?>">
        				<div class="box-modal_close arcticmodal-close">закрыть</div>
        				Невозможно добавить.Запись на английском существует.
    				</div>
		  		</div>
			<? }
		}
	 }
			}
			if($flag) {?>
        		<div style="display: none;">
    				<div class="box-modal" id="<?=$getname?>">
        				<div class="box-modal_close arcticmodal-close">закрыть</div>
        				Невозможно добавить.Запись существует.
    				</div>
		  		</div>
			<? }
		}
	 }
	 
	 ?>
     
	<div class="mytable" style="padding:15px">
    <h2>Добавить <?=$lablename2?></h2>
  	<form  action="" method="post">    
    
    <label><?=$lablename?>:</label><br/>
    <input required="required"  type='text' name='ru' maxlength="50" /><br/>
    
    <input type="submit" name="add" value="добавить" />
    </form>
    </div>
    <br />
   	<span><table id="<?=$tabletable?>"><tr><td></td></tr></table></span>
    <div id="<?=$tablepager?>"></div>
<? }

function tablnew1($tablename,$getname,$lablename,$lablename_eng,$lablename2,$depend,$rudepend){
	$tablename_eng=$tablename.'_eng';
	$getname_eng=$getname.'_eng';
	$tabletable=$tablename."table";
	$tablepager=$tablename."pager";
	$depend_id=$depend."_id";
	$depend_eng=$depend."_eng";?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#<?=$tablename?>').arcticmodal();
		$('#<?=$tablename_eng?>').arcticmodal();
		$('#<?=$getname?>').arcticmodal();
		$('#<?=$getname_eng?>').arcticmodal();
		cattable1("<?=$tablename?>","<?=$lablename?>","<?=$lablename_eng?>","<?=$depend?>","<?=$rudepend?>");
	});
	</script>
<? mysql_query("CREATE TABLE IF NOT EXISTS `$tablename` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `$tablename` text NOT NULL,
  `$tablename_eng` text NOT NULL,
  `$depend_id` int(11) NOT NULL,
   KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12") or die(mysql_error());
	$flag=0;
	$flag_eng=0;
	 if($_POST[ru]){
		$input_text = strip_tags($_POST[ru]);
		$input_text	= trim($input_text);
		$input_text = htmlspecialchars($input_text);
		$input_text = mysql_escape_string($input_text);
		$input_text = mb_substr($input_text, 0,140, 'UTF-8');
		if($_POST[sel]) $_POST[sel]=(int)$_POST[sel];
		if($input_text=="" ||$input_text==" ") { ?>
          <div style="display: none;">
    		<div class="box-modal" id="<?=$tablename?>">
        		<div class="box-modal_close arcticmodal-close">закрыть</div>
        		Невозможно добавить.Используются недопустимые символы или пустая строка в русском названии.
    		</div>
		  </div>
         <? }
		else{
			$result=mysql_query("SELECT * FROM `$tablename` WHERE `$tablename`='$input_text' AND `$depend_id`='$_POST[sel]'");
			$total=mysql_num_rows($result); 
			if($total)$flag=1;
			if(!$flag) {
				$rres=mysql_query ("INSERT INTO `$tablename`(`$tablename`,`$depend_id`) VALUES('$input_text','$_POST[sel]')") or die(mysql_error());
				$id=mysql_insert_id();
				if($_POST[eng]){
		$input_text_eng = strip_tags($_POST[eng]);
		$input_text_eng	= trim($input_text_eng);
		$input_text_eng = htmlspecialchars($input_text_eng);
		$input_text_eng = mysql_escape_string($input_text_eng);
		$input_text_eng = mb_substr($input_text_eng, 0,140, 'UTF-8');
		if($input_text_eng=="" ||$input_text_eng==" ") { ?>
          <div style="display: none;">
    		<div class="box-modal" id="<?=$tablename_eng?>">
        		<div class="box-modal_close arcticmodal-close">закрыть</div>
        		Невозможно добавить.Используются недопустимые символы или пустая строка в английском названии.
    		</div>
		  </div>
         <? }
		else{
			$result=mysql_query("SELECT * FROM `$tablename` WHERE `$tablename_eng` ='$input_text_eng' AND `$depend_id`='$_POST[sel]'");
			$total=mysql_num_rows($result); 
			if($total)$flag_eng=1;
			if(!$flag_eng) {
				$rres=mysql_query ("UPDATE  `$tablename` SET `$tablename_eng`='$input_text_eng' WHERE `id`='$id'") or die(mysql_error());
			}
			if($flag_eng) {?>
        		<div style="display: none;">
    				<div class="box-modal" id="<?=$getname_eng?>">
        				<div class="box-modal_close arcticmodal-close">закрыть</div>
        				Невозможно добавить.Запись на английском существует.
    				</div>
		  		</div>
			<? }
		}
	 }
			}
			if($flag) {?>
        		<div style="display: none;">
    				<div class="box-modal" id="<?=$getname?>">
        				<div class="box-modal_close arcticmodal-close">закрыть</div>
        				Невозможно добавить.Запись на русском существует. 
    				</div>
		  		</div>
			<? }
		}
	 }?>

	<div class="mytable" style="padding:15px">
    <h2>Добавить <?=$lablename2?></h2>
  	<form  action="" method="post">
    <select size="1" name="sel">
	<option disabled="disabled">Выберите <?=$rudepend?></option>
	<?  $result=mysql_query("SELECT * FROM `$depend`") or die(mysql_error());
	while($row=mysql_fetch_array($result)){ 
		if($row[$depend]) $countselect=$row[$depend];
		else $countselect=$row[$depend_eng];?>
		<option value="<?=$row['id']?>" ><?=$countselect?></option>
   	<? } ?>
   	</select><br />
    <label><?=$lablename?>:</label><br/>
    <input required="required"  type='text' name='ru' maxlength="50" /><br/>
    <!--<label><? //$lablename_eng?>:</label><br/>
    <input  type='text' name='eng' maxlength="50" /><br/>-->
    
    <input type="submit" name="add" value="добавить" />
    </form>
    </div>
    <br />
   	<span><table id="<?=$tabletable?>"><tr><td></td></tr></table></span>
    <div id="<?=$tablepager?>"></div>
<? } 
function tablnew2($tablename,$getname,$lablename,$lablename_eng,$lablename2,$depend,$rudepend,$depend2,$rudepend2,$nodepend,$runodepend){
	$tablename_eng=$tablename.'_eng';
	$getname_eng=$getname.'_eng';
	$tabletable=$tablename."table";
	$tablepager=$tablename."pager";
	$depend_id=$depend."_id";
	$depend_eng=$depend."_eng";
	$depend2_id=$depend2."_id";
	$depend2_eng=$depend2."_eng";
	$nodepend_id=$nodepend."_id";
	$nodepend_eng=$nodepend."_eng";?>
	<script type="text/javascript">
	function runcountryyy(){
		  var countryid=$('#selcountry').val();
		  $.ajax({
			  type: "POST",
			  url: "ajaxselecttt.php",
			  dataType: "json",
			  data: "country="+countryid,
			  success: function(data){
				$("#region").html(data.region);
				 } 
			})
	}	
	
	$(document).ready(function(){
		$('#<?=$tablename?>').arcticmodal();
		$('#<?=$tablename_eng?>').arcticmodal();
		$('#<?=$getname?>').arcticmodal();
		$('#<?=$getname_eng?>').arcticmodal(); 
		runcountryyy();
		
		cattable2("<?=$tablename?>","<?=$lablename?>","<?=$lablename_eng?>","<?=$depend?>","<?=$rudepend?>","<?=$depend2?>","<?=$rudepend2?>","<?=$nodepend?>","<?=$runodepend?>");
	});
	</script>
<? mysql_query("CREATE TABLE IF NOT EXISTS `$tablename` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `$tablename` text NOT NULL,
  `$tablename_eng` text NOT NULL,
  `$depend_id` int(11) NOT NULL,
  `$depend2_id` int(11) NOT NULL,
  `$nodepend_id` int(11) NOT NULL,
   KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12") or die(mysql_error());
	$flag=0;
	$flag_eng=0;
	 if($_POST[ru]){
		$input_text = strip_tags($_POST[ru]);
		$input_text	= trim($input_text);
		$input_text = htmlspecialchars($input_text);
		$input_text = mysql_escape_string($input_text);
		$input_text = mb_substr($input_text, 0,140, 'UTF-8');
		if($_POST[sel]) $_POST[sel]=(int)$_POST[sel];
		if($input_text=="" ||$input_text==" ") { ?>
          <div style="display: none;">
    		<div class="box-modal" id="<?=$tablename?>">
        		<div class="box-modal_close arcticmodal-close">закрыть</div>
        		Невозможно добавить.Используются недопустимые символы или пустая строка в русском названии.
    		</div>
		  </div>
         <? }
		else{
			$result=mysql_query("SELECT * FROM `$tablename` WHERE `$tablename`='$input_text' AND `$depend_id`='$_POST[selcountry]' AND `$depend2_id`='$_POST[selregion]'");
			$total=mysql_num_rows($result); 
			if($total)$flag=1;
			if(!$flag) {
				$rres=mysql_query ("INSERT INTO `$tablename`(`$tablename`,`$depend_id`,`$depend2_id`,`$nodepend_id`) VALUES('$input_text','$_POST[selcountry]','$_POST[selregion]','$_POST[selproperty]')") or die(mysql_error());
				$id=mysql_insert_id();
				if($_POST[eng]){
		$input_text_eng = strip_tags($_POST[eng]);
		$input_text_eng	= trim($input_text_eng);
		$input_text_eng = htmlspecialchars($input_text_eng);
		$input_text_eng = mysql_escape_string($input_text_eng);
		$input_text_eng = mb_substr($input_text_eng, 0,140, 'UTF-8');
		if($input_text_eng=="" ||$input_text_eng==" ") { ?>
          <div style="display: none;">
    		<div class="box-modal" id="<?=$tablename_eng?>">
        		<div class="box-modal_close arcticmodal-close">закрыть</div>
        		Невозможно добавить.Используются недопустимые символы или пустая строка в английском названии.
    		</div>
		  </div>
         <? }
		else{
			$result=mysql_query("SELECT * FROM `$tablename` WHERE `$tablename_eng` ='$input_text_eng' AND `$depend_id`='$_POST[sel]'");
			$total=mysql_num_rows($result); 
			if($total)$flag_eng=1;
			if(!$flag_eng) {
				$rres=mysql_query ("UPDATE  `$tablename` SET `$tablename_eng`='$input_text_eng' WHERE `id`='$id'") or die(mysql_error());
			}
			if($flag_eng) {?>
        		<div style="display: none;">
    				<div class="box-modal" id="<?=$getname_eng?>">
        				<div class="box-modal_close arcticmodal-close">закрыть</div>
        				Невозможно добавить.Запись на английском существует.
    				</div>
		  		</div>
			<? }
		}
	 }
			}
			if($flag) {?>
        		<div style="display: none;">
    				<div class="box-modal" id="<?=$getname?>">
        				<div class="box-modal_close arcticmodal-close">закрыть</div>
        				Невозможно добавить.Запись на русском существует. 
    				</div>
		  		</div>
			<? }
		}
	 }?>

	<div class="mytable" style="padding:15px">
    <h2>Добавить <?=$lablename2?></h2>
  	<form  action="" method="post">    
    <div id="country">
    <select size="1"  name="selcountry" id="selcountry" onchange="runcountryyy()">
	<option disabled="disabled">Выберите страну</option>
	<?  $result=mysql_query("SELECT * FROM `$depend`") or die(mysql_error());
	
	while($row=mysql_fetch_array($result)){ 
		if($row[$depend]) $countselect=$row[$depend];
		else $countselect=$row[$depend_eng];?>
		<option value="<?=$row['id']?>" ><?=$countselect?></option>
   	<? } ?>
   	</select></div><br />
    <div id="region">
	<select size="1"  name='selregion' id="selregion" >
	<option disabled>Выберите регион</option>
	<? 	$result=mysql_query("SELECT * FROM `$depend2` ") or die(mysql_error()) ;
	
	while($row=mysql_fetch_array($result)){ 
		if($row[$depend2]) $regselect=$row[$depend2];
		else $regselect=$row[$depend2_eng];?>
  	<option value="<?=$row['id']?>" ><?=$regselect?></option>
   	<? } ?> 
   	</select></div><br />
    <select size="1"  name='selproperty' >
	<option disabled>Выберите свойство города</option>
	<? 	$result=mysql_query("SELECT * FROM `$nodepend` ") or die(mysql_error()) ;
	while($row=mysql_fetch_array($result)){ 
		if($row[$nodepend]) $propselect=$row[$nodepend];
		else $propselect=$row[$nodepend_eng];?>
  	<option value="<?=$row['id']?>" ><?=$propselect?></option>
   	<? } ?> 
   	</select><br />
    
    <label><?=$lablename?>:</label><br/>
    <input required="required"  type='text' name='ru' maxlength="50" /><br/>
    <label><?=$lablename_eng?>:</label><br/>
    <input  type='text' name='eng' maxlength="50" /><br/>
    
    <input type="submit" name="add" value="добавить" />
    </form>
    </div>
    <br />
   	<span><table id="<?=$tabletable?>"><tr><td></td></tr></table></span>
    <div id="<?=$tablepager?>"></div>
<? } 
 function seopage($seo_title,$seo_metadescription,$seo_metakeywords,$page){
 if($seo_title){
		$seo_title = strip_tags($seo_title);
		$seo_title	= trim($seo_title);
		$seo_title = htmlspecialchars($seo_title);
		$seo_title = mysql_escape_string($seo_title);
		$seo_title = mb_substr($seo_title, 0,140, 'UTF-8');
		$seo_metadescription = strip_tags($seo_metadescription);
		$seo_metadescription= trim($seo_metadescription);
		$seo_metadescription = htmlspecialchars($seo_metadescription);
		$seo_metadescription = mysql_escape_string($seo_metadescription);
		$seo_metadescription = mb_substr($seo_metadescription, 0,140, 'UTF-8');
		$seo_metakeywords = strip_tags($seo_metakeywords);
		$seo_metakeywords	= trim($seo_metakeywords);
		$seo_metakeywords= htmlspecialchars($seo_metakeywords);
		$seo_metakeywords = mysql_escape_string($seo_metakeywords);
		$seo_metakeywords = mb_substr($seo_metakeywords, 0,140, 'UTF-8');
		if($seo_title=="" || $seo_title==" ") { ?>
          <div style="display: none;">
    		<div class="box-modal" id="error3">
        		<div class="box-modal_close arcticmodal-close">закрыть</div>
        		Невозможно добавить.Используются недопустимые символы или пустая строка
    		</div>
		  </div>
         <? }
		else{
			$result=mysql_query("SELECT * FROM `seo` WHERE `page`='$page' ");
			$total=mysql_num_rows($result); 
			if(!$total)$rres=mysql_query ("INSERT INTO seo (title, description, keywords, page) VALUES('$seo_title' ,'$seo_metadescription', '$seo_metakeywords' , '$page')") or die(mysql_error());
			else $rres=mysql_query ("UPDATE seo SET `title`= '$seo_title', `description`='$seo_metadescription', `keywords`='$seo_metakeywords' WHERE `page`='$page'") or die(mysql_error());
		} 
   }
 	$result=mysql_query("SELECT * FROM `seo` WHERE `page`='$page' ");
	$row=mysql_fetch_array($result);	
		 ?>  
   <div>
    <form id="<?=$page."title"?>" name="<?=$page."title"?>" method="post" action="">
        <div class='container'>
        	<label  for="<?=$page."_title"?>">Тег "title" (Название) *</label><br />
			<textarea required="required"  maxlength="200" name="<?=$page."_title"?>" id="<?=$page."_title"?>" value="" style="width:295px; height:74px" /><?=$row[title]?></textarea><br/>
           
        </div>
        <div class='container'>
        	<label  for="<?=$page."_metadescription"?>">SEO "Description" (Описание)</label><br />
			<textarea  maxlength="200" name="<?=$page."_metadescription"?>" id="<?=$page."_metadescription"?>" value="" style="width:295px; height:74px" /><?=$row[description]?></textarea><br/>
            
        </div>
        <div class='container'>
        	<label  for="<?=$page."_metakeywords"?>">SEO "Keywords" (Ключевые слова)</label><br />
			<textarea  maxlength="200" name="<?=$page."_metakeywords"?>" id="<?=$page."_metakeywords"?>" value="" style="width:295px; height:74px" /><?=$row[keywords]?></textarea><br/>
            <span id='<?=$seo_ametakeywords_errorloc?>' class='error'></span>
        </div>
        <input type="submit" value="изменить" name="<?=$page."_seo"?>" id="<?=$page."_seo"?>"/>
     </form>
     </div>




<? } ?>  