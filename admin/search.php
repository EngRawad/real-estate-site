<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?
 function search()
    {
		$addquery="";
		   	if($_GET[search_cat])$addquery.="AND `category_id`= '$_GET[cat]'";
		   	if($_GET[search_region])$addquery.="AND `region_id`= '$_GET[search_region]'";
		   	if($_GET[search_city])$addquery.="AND `city_id`= '$_GET[search_city]'";
				if($_GET[search_objtype])$addquery.="AND `objtype_id`= '$_GET[search_objtype]'";
			
		   	if($_GET[square] || $_GET[square1]) $addquery.="AND `square`>= '$_GET[square]' AND `square`<= '$_GET[square1]'";
		    if($_GET[num_of_rooms] || $_GET[num_of_rooms1]) $addquery.="AND `num_of_rooms`>= '$_GET[num_of_rooms]' AND `num_of_rooms`<= '$_GET[num_of_rooms1]'";
			if($_GET[prcl] || $_GET[prch]) $addquery.="AND `price`>= '$_GET[prcl]' AND `price`<= '$_GET[prch]'";
			if($_GET[location])$addquery.="AND `artikul`= '$_GET[location]'";
			
			$queryall="SELECT * FROM `main`  WHERE `active`='1'".$addquery;
			$result=mysql_query($queryall)or die(mysql_error());
			$res = mysql_num_rows($result); 
		
		
		if (mysql_num_rows($result_pag_data) == 0) {?>
                    <table height="400px" align="center"><tr><td> <?
    				 echo '<h4 align="center" class="alert-error">' . "Ничего не найдено" . '</h4>'; 
				 }
			else {						
					$count = mysql_num_rows($result); { ?>
                   
					<p style="font-size:0.8em; font-weight:bold">Всего найдено <?=$count?></p>
					<? return true;
				}
					
		} 	
			 
			  if(!isset($_SESSION)) session_start(); 
			//$pages=ceil ($res/$num);			
			//$start=$num*$page-$num;
	
		
       
		
    }
	
?>
	
	
	


		    
</body>
</html>