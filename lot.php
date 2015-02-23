<?
if(!$_GET[id]){
	header("Location: index.php");
   			 exit;
} 
require_once("admin/baza.php");
			$add.=" AND category.id=main.category_id";
			$add.=" AND objtype.id=main.objtype_id";
			$add.=" AND city.id=main.city_id";
			$add.=" AND region.id=main.region_id";
			$query="SELECT DISTINCT * FROM category,objtype,city,region,main WHERE main.id='$_GET[id]'".$add;
			$result = mysql_query($query) or die('MySql Error' . mysql_error());
			$row=mysql_fetch_array($result);
			if(!$row['active']){
				require_once("include/membersite_config.php");
				if(!($fgmembersite->CheckLogin()))
					{
    					$fgmembersite->RedirectToURL("index.php");
   			 			exit;
					}
			}
			session_start(); 
   	$_SESSION['looked'][] =(int)$row['id'];
	$links = array_unique($_SESSION['looked']);
	
							if (count($links)>10) {
								array_shift($links );
								$_SESSION['looked'] = $links;
							}
$title=$row[title_ru];
$description1=$row[description_ru];
$description=$row[seo_description_ru];

$keywords=$row[seo_keywords_ru];
$dir="admin/uploads/".$_GET[id] ;
$image=$dir."/ready/mid/".$row['image'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-translate-customization" content="152f8d57a44c342a-0052517fa9bfb665-gea7eae232f5e6f38-b"></meta>
<title><?=$title?></title>
<meta name="keywords" content="<?=$keywords?>" />
<meta name="description" content="<?=$description?>" />
<meta name="og:type" content="website" />
<meta name="og:locale" content="ru" />
<meta name="og:image" content="<?=$image?>" />
<meta name="og:title" content="<?=$title?>" />
<meta name="og:description" content="<?=$description1?>" />

<link rel="image_src" href="<?=$image?>" />
<meta name="mrc__share_description" content="<?=$description1?>" />
<meta name="mrc__share_title" content="<?=$title?>" />
	
	<link rel="stylesheet" type="text/css" 	href="css/kriframework.css"  /> 
	<link rel="stylesheet" type="text/css" 	href="css/stylelot.css"  />	
    <link rel="stylesheet" type="text/css" 	href="css/style1lot.css"  />
	<link rel="stylesheet" type="text/css"	href="css/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" 	href="modal/css/kstyle.css"/>
  	<link rel="stylesheet" type="text/css" 	href="modal/fancybox2/source/jquery.fancybox.css"/>
	<link rel="stylesheet" type="text/css"	href="css/mycss.css" />
    <link rel="stylesheet" 	type="text/css" href="lib/jquery.ad-gallery.css"/>
	<link rel="stylesheet" 	type="text/css"	href="include/fancyBox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	<link rel="stylesheet" 	type="text/css" href="include/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7"  media="screen" />
  
	<script type='text/javascript' src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="lib/jquery.ad-gallery.js"></script>
	<script type="text/javascript"	src="include/fancyBox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<script type="text/javascript" src="include/fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    <script type='text/javascript' src="js/jquery-ui-1.10.2.custom.min.js"></script>
	<script type="text/javascript" 	src="http://maps.google.com/maps/api/js?sensor=false&amp;language=ru"></script>
    
 
<script type="text/javascript">
//<![CDATA[
function kreditcalc(){
		var calcsum = $('#sum').val();
		var calcperiod = $('#period').val();
		var calcpersent = $('#persent').val();
		var sxal = "неверно";
		if(calcsum =="" || calcperiod == "" || calcpersent == "" ) return sxal;
		if(isNaN(calcsum) || isNaN(calcperiod) || isNaN(calcpersent) ) return sxal;
		if(calcsum > 10000000 || calcperiod > 30 || calcpersent > 100 || calcsum < 0 || calcperiod < 0 || calcpersent < 0 ) return sxal;
		calcperiod = calcperiod*12;
		calcpersent = calcpersent/1200;
		calcsum = calcsum*1;
		var temp = calcpersent+1;
		var stepen = temp;
		for(var i= 1; i<calcperiod; i++){
			temp = temp*stepen;
		}
		temp = 1-1/temp;
		var verch = calcsum*calcpersent/temp;
		var m = Math.pow(10,2);
		verch = Math.round(verch*m)/m;

		return verch;
	}
//]]>
function changeimgin() {
		$('#lotimg').attr('src', 'images/lot1.png');
	}
	function changeimgout() {
		$('#lotimg').attr('src', 'images/lot.png');
	}

function go_table(){
	   if($('#pr_table').css('display')=='none'){
			$('#pr_table').css('display', 'block');
			$('#prvalue').text('Скрыть')  
	   }
	   else{
		   $('#pr_table').css('display', 'none');
			$('#prvalue').text('Подробнее')
	   }
   }
	
 $(function() {
    var galleries = $('.ad-gallery').adGallery({update_window_hash: false}); 
  });
  
  var geocoder;
var map;
var marker;
function initialize(lat,lng){
	
//Определение карты
  var latlng = new google.maps.LatLng(lat,lng);
  var options = {
    zoom: 10,
    center: latlng,
	scrollwheel: false,
    mapTypeId: google.maps.MapTypeId.MAP
  };
 map = new google.maps.Map(document.getElementById("map_canvas"), options);
   //Определение геокодера
  geocoder = new google.maps.Geocoder();
  marker = new google.maps.Marker({
	position: latlng,
	map: map,
    draggable: false
  });
}
</script>
<script type="text/javascript">

$(document).ready(function() {
	var gin = $('#gin').html();
		$('#sum').val(gin);
		var kredit = kreditcalc();
		$('#sumres').val(kredit);
    	$('#sum').bind("change keyup input click", function() {
   			 if (this.value.match(/[^0-9]/g)) {
        		this.value = this.value.replace(/[^0-9]/g, '');
    		}
			var kredit = kreditcalc();
			$('#sumres').val(kredit);
			
		});
		$('#period').bind("change keyup input click", function() {
			var period = $('#period').val();
   			if (this.value.match(/[^0-9]/g)){
				  this.value = this.value.replace(/[^0-9]/g, '');  
    		}
			var kredit = kreditcalc();
			$('#sumres').val(kredit);
		});
		$('#persent').bind("change keyup input click", function() {
   			 if (this.value.match(/[^0-9]/g)) {
        		this.value = this.value.replace(/[^0-9.]/g, '');
    		}
			var kredit = kreditcalc();
			$('#sumres').val(kredit);
		});
			
	$(".modalbox").fancybox({
		scrolling	: 'auto',
		maxWidth	: 530,
		maxHeight	: 530,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		
	});
	var latcont=$('#latlot').val();
	var lngcont=$('#lnglot').val();
	initialize(latcont,lngcont); 
			geocoder.geocode({'latLng': marker.getPosition()});
			
	
	$(".ad-gallery").on("click", ".ad-image", function() {
		var biglink=$(".ad-image").find("img").attr("src");
		$('a[href="'+biglink+'"][charset="utf-8"]').removeAttr("rel");
	});
});	

	$(".fancybox").fancybox({
			helpers:  {
        		thumbs : {
            		width: 120,
            		height: 90
        		}
    		},
			
			
		});

</script>		

<script type='text/javascript'>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'ru', includedLanguages: 'be,en,es,uk', layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT, autoDisplay: false}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51353079-1', 'casa-de-lujo.com');
  ga('send', 'pageview');

</script>
</head>
<body id='top' style="color:#40311E;font-size:14px"> 
<?  require_once("top.inc");?>

	<div class="wrap_fullwidth" id='second_header'>
		<div class='center'>
			<p class="logo "><a href="index.php" title="CASA DE LUJO">CASA DE LUJO</a></p>
			<ul id="nav">
            	<li><a href="index.php">Главная страница</a></li>
				<? if($row[deal]==2){ ?>
                		<li><a href="properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=1">Продажа</a>
                        <? }
					else {?>
						<li class='current'><a href="properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=1">Продажа</a>
                        <? }?>
                <ul>
                	<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=37&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt=""/>Апартаменты</a></li>
                	<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=38&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Таунхаусы</a></li>
                	<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=39&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Бунгало</a></li>
                	<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=36&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Дуплекс</a></li>
                	<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=35&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Виллы</a></li>
				</ul>
                </li>
				<? if($row[deal]==2){ ?>
                		<li class='current'><a  href="<?=$_SERVER['PHP_SELF']?>?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=2">Аренда</a></li>
                        <? }
					else {?>
						<li><a href="properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=2">Аренда</a></li> 
                        <? }?> 
                <li><a href="services.php?pg=service">Услуги</a></li>
                <li><a href="services.php?pg=info">Полезная информация</a></li>
                <li><a href="services.php?pg=contacts">Контакты</a></li>
			</ul>
		</div>
	</div>
	<div class="wrap_fullwidth small_margin" id='main'>
		<div class='center'>
        	<span class='latest_work merguynpoqr'>Продажа:</span>
            <div class='content_fullwidth'> 
                    <div class='content_one_third portfolio_item'>
                        <div class='item_data rounded'>
                        	<h2><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=37&amp;deal=1'>Апартаменты</a></h2>
                            <a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=37&amp;deal=1'><img src='uploads/tun2.jpg' alt=''/></a>
                            
                        </div>
                    </div>
                    <div class='content_one_third portfolio_item'>
                        <div class='item_data rounded'>
                        	<h2><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=38&amp;deal=1'>Таунхаусы</a></h2>
                            <a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=38&amp;deal=1'><img src='uploads/tun1.jpg' alt=''/></a>
                            
                        </div>
                    </div> 
                    <div class='content_one_third portfolio_item'>
                        <div class='item_data rounded'>
                        	<h2><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=39&amp;deal=1'>Бунгало</a></h2>
                            <a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=39&amp;deal=1'><img src='uploads/tun4.jpg' alt=''/></a>
                            
                        </div>
                    </div>
                    <div class='content_one_third portfolio_item'> 
                        <div class='item_data rounded'>
                        	<h2><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=36&amp;deal=1'>Дуплекс</a></h2>
                            <a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=36&amp;deal=1'><img src='uploads/tun3.jpg' alt=''/></a>
                            
                        </div>
                    </div>		
                    <div class='content_one_third portfolio_item'>
                        <div class='item_data rounded'>
                        	<h2><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=35&amp;deal=1'>Виллы</a></h2>
                            <a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=35&amp;deal=1'><img src='uploads/tun5.jpg' alt=''/></a> 
                            
                        </div> 
                    </div>
            </div>
        </div>
    </div>
   	<div class="wrap_fullwidth" > 
		<div class='center' style="background-color:#FFF4DD">
		<?	if($row[deal]==2){ 
				$dealalt="аренда";?>
                <span class='latest_work merguynpoqr'>сдаётся в аренду</span><br /><hr size="1" style="margin-top:0px;border:none; background-color:#A8231A;height:1px; color:#A8231A" /> <? }
			else { 
				$dealalt="продажа";?>
                <span class='latest_work merguynpoqr'>продаётся</span><br /><hr size="1" style="margin-top:0px;border:none; background-color:#A8231A;height:1px; color:#A8231A" /> <? }
			$query_price="SELECT DISTINCT * FROM price_lend WHERE item_id='$_GET[id]'";
			$result_price = mysql_query($query_price) or die('MySql Error' . mysql_error());
			$row_price=mysql_fetch_array($result_price);
			?>
            
           	<div class="left_float">
           		<div id="gallery" style="padding:20px 25px 0 0" class="ad-gallery">
                
                	<? if($row['is_special_offer']){ ?><div class="right_float" style="opacity:0.8; position: absolute; margin-left:468px; z-index: 1000"><img src="images/spec10.png" alt="" /></div> <? } ?> 
                			<div class="ad-image-wrapper"></div>
                			<div class="ad-controls"></div>
                			<div class="ad-nav">
                    			<div class="ad-thumbs">
                  					<ul class="ad-thumb-list"> 
                                  <?	if($_GET[id]) $dir="admin/uploads/".$_GET[id] ;
										if(!$row['image'])	{
											$mainimg="admin/images/noimage.jpg";
											$mainimgbig="admin/images/noimage.jpg";
										}
				 						else {
											$mainimg=$dir."/ready/low/".$row['image'];
											$mainimgbig=$dir."/ready/high/".$row['image'];
										}
									?>
									<li><a charset="utf-8" class="fancybox" rel="group" href="<?=$mainimgbig?>"><img width="120px" src="<?=$mainimg?>" 	alt="<?=$dealalt?> , <?=$row[objtype]?> в <?=$row[city]?>"/></a></li>
                                   <?	
									if (is_dir($dir)) {
            								if ($dh = opendir($dir)) {
                								while (($file = readdir($dh)) !== false) { 
                    								if (is_file($dir."/ready/low/".$file) && $file!=$row['image']){?>
                                      		<li><a charset="utf-8" class="fancybox" rel="group" href="<?=$dir?>/ready/high/<?=$file?>"><img width="120px" src="<?=$dir?>/ready/low/<?=$file?>" 	alt="<?=$dealalt?> , <?=$row[objtype]?> в <?=$row[city]?>"/></a></li>              
                   					<? $i++;}
                									}
            										closedir($dh);
           										}
        								}?>
                   					</ul>
                  				</div>
                			</div>
              			</div>
            </div>
            <div>
                		<table class="mytable" width="307px" >
                     <? if($row[price_ot])$ot=$row[price_ot];
						else $ot="";
						if($row[deal]==2){ 
						 if($row[price] && $row[price]!=""){?>
                  			    <tr>
                                	<th><p ><b>Стоимость<br />долгосрочной<br />аренды:</b></p></th>
                        			<td><b style="display:inline"><?=$ot?> </b><h1 id="gin" style="color:#F00; display:inline"><?=$row[price]?></h1><h1 style="color:#F00; display:inline"> € </h1><b>в месяц</b></td>
                              	</tr>
                              <? 
							  	if($row_price[May_1m] || $row_price[May_1w] || $row_price[May_2w] || $row_price[June_1m] || $row_price[June_1w] || $row_price[June_2w] || $row_price[August_1m] || $row_price[August_1w] || $row_price[August_2w] || $row_price[month_1m] || $row_price[month_1w] || $row_price[month_2w]){?>
                  				<tr>
                    				<th><p ><b>Стоимость<br />аренды</b></p></th>
                        			<td><a onclick="go_table()" class="pricerent rounded" href="javascript:void()" title="Показать стоимость по месяцам." style="color:#F00; display:inline" id="prvalue">Подробнее</a></td>
                               </tr>
                      <tr >
                      <td colspan="2">
                      <div id="pr_table" style="display:none">
    					<table border="1" bgcolor="#FFFFFF" style="border-collapse:collapse">
      						<tr style="font-size:11px;font-weight:bold">  
                				<td class="pricetablemenu"></td>                				
            					<td class="pricetablemenu">Май</td>
              					<td class="pricetablemenu">Июнь<br />Сентябрь<br />Рождество</td>
             					<td class="pricetablemenu">Июль<br />Август</td>
             					<td class="pricetablemenu">Остальное<br />время</td>
            				</tr>
            				<tr>
            					<td class="pricetablemenu">1 месяц</td>
            					<td class="pricetable"><? if($row_price[May_1m]) echo $row_price[May_1m]?>€</td>
                				<td class="pricetable"><? if($row_price[June_1m]) echo $row_price[June_1m]?>€</td>
               					<td class="pricetable"><? if($row_price[August_1m]) echo $row_price[August_1m]?>€</td>
                				<td class="pricetable"><? if($row_price[month_1m]) echo $row_price[month_1m]?>€</td>
            				</tr>
            				<tr>
            					<td class="pricetablemenu">2 недели</td>
               					<td class="pricetable"><? if($row_price[May_2w]) echo $row_price[May_2w]?>€</td>
               					<td class="pricetable"><? if($row_price[June_2w]) echo $row_price[June_2w]?>€</td> 
               					<td class="pricetable"><? if($row_price[August_2w]) echo $row_price[August_2w]?>€</td>
               					<td class="pricetable"><? if($row_price[month_2w]) echo $row_price[month_2w]?>€</td>
           					</tr>
            				<tr>
            					<td class="pricetablemenu">1 неделя</td>
                				<td class="pricetable"><? if($row_price[May_1w]) echo $row_price[May_1w]?>€</td>
                				<td class="pricetable"><? if($row_price[June_1w]) echo $row_price[June_1w]?>€</td>
               					<td class="pricetable"><? if($row_price[August_1w]) echo $row_price[August_1w]?>€</td>
                				<td class="pricetable"><? if($row_price[month_1w]) echo $row_price[month_1w]?>€</td>
			 				</tr>
        				</table>
     		</div> 
            </td>
            </tr>
            
                			<? }
                     		}
						}
						else {
							if($row[price] && $row[price]!=""){?>
                  				<tr>
                    				<th><p ><b>Цена:</b></p></th>
                        			<td><h1 style="color:#F00; display:inline"><?=$ot?> </h1><h1 id="gin" style="color:#F00; display:inline"><?=$row[price]?></h1><h1 style="color:#F00; display:inline"> €</h1></td>
                               </tr>
                			<? }
						}
						if($row[artikul] && $row[artikul]!=""){?> 
                			<tr>
                    			<th><p ><b>ЛОТ:</b></p></th>
                        		<td><p><b><?=$row[artikul]?></b></p></td>
                			</tr>
                            <? }
						if($row[objtype_id] && $row[objtype_id]!=""){?>
                    		<tr>
                    			<th><p ><b>Тип:</b></p></th>
                        		<td><p ><b><?=$row[objtype]?></b></p></td>
                			</tr>
                            <? }
						if($row[year_built] && $row[year_built]!=""){?>
                            <tr>
                    			<th><p ><b>Год постройки:</b></p></th>
                        		<td><p ><b><?=$row[year_built]?></b></p></td>
                			</tr>
                            <? }
						if($row[category_id] && $row[category_id]!=""){?>
                    		<tr>
                    			<th><p><b>Категория:</b></p></th>
                        		<td><p><b><?=$row[category]?></b></p></td>
                            </tr>
                            <? }
						if($row[region_id] && $row[region_id]!=""){?>
                			<tr>
                    			<th><p><b>Побережье:</b></p></th>
                        		<td><p><b><?=$row[region]?></b></p></td>
                			</tr>
                            <? }
						if($row[city_id] && $row[city_id]!=""){?>
                    		<tr>
                    			<th><p><b>Город:</b></p></th>
                        		<td><p><b><?=$row[city]?></b></p></td>
                			</tr>
                            <? }
						if($row[squarehouse] && $row[squarehouse]!=""){?>
                   			<tr>
                    			<th><p><b>Площадь дома:</b></p></th>
                        		<td><p><b><?=$row[squarehouse]?> m<sup>2</sup></b></p></td>
                			</tr>
                            <? }
						if($row[squarearea] && $row[squarearea]!=""){?>
                            <tr>
                    			<th><p><b>Площадь участка:</b></p></th>
                        		<td><p><b><?=$row[squarearea]?> m<sup>2</sup></b></p></td>
                			</tr>
                            <? }
						if($row[squareterrace] && $row[squareterrace]!=""){?>
                    		<tr>
                    			<th><p><b>Площадь террасы:</b></p></th>
                        		<td><p><b><?=$row[squareterrace]?> m<sup>2</sup></b></p></td>
                			</tr>
                            <? }
						if($row[squarsun] && $row[squarsun]!=""){?>
                    		<tr>
                    			<th><p><b>Площадь солярия:</b></p></th>
                        		<td><p><b><?=$row[squarsun]?> m<sup>2</sup></b></p></td>
                			</tr>
                            <? }
						if($row[num_of_rooms] && $row[num_of_rooms]!=""){?>
                    		<tr>
                    			<th><p><b>Кол-во комнат:&nbsp;</b></p></th>
                        		<td><p><b><?=$row[num_of_rooms]?></b></p></td>
                			</tr>
                            <? }
						if($row[num_of_bath] && $row[num_of_bath]!=""){?>
                    		<tr>
                    			<th><p><b>Кол-во ванных:&nbsp;</b></p></th>
                        		<td><p><b><?=$row[num_of_bath]?></b></p></td>
                			</tr>
                            <? }
						if($row[floor] && $row[floor]!=""){?>
                            <tr>
                    			<th><p><b>Этаж:&nbsp;</b></p></th>
                        		<td><p><b><?=$row[floor]?></b></p></td>
                			</tr>
                            <? }
						if($row[floor_total] && $row[floor_total]!=""){?>
                            <tr>
                    			<th><p><b>Этажей:&nbsp;</b></p></th>
                        		<td><p><b><?=$row[floor_total]?></b></p></td>
                			</tr>
                            <? }
						if($row[condominimum] && $row[condominimum]!=""){?>
                            <tr>
                    			<th><p><b>Кондоминимум</b></p></th>
                        		<td><p><b><?=$row[condominimum]?> € в <?=$row[condominimum_unit]?></b></p></td>
                			</tr>
                            <? }
						if($row[distsea] && $row[distsea]!=""){?>
                            <tr>
                    			<th><p><b>До моря</b></p></th>
                        		<td><p><b><?=$row[distsea]?> <?=$row[distsea_unit]?></b></p></td>
                			</tr>
                            <? }
						if($row[distair] && $row[distair]!=""){?>
                            <tr>
                    			<th><p><b>До аэропорта</b></p></th>
                        		<td><p><b><?=$row[distair]?> <?=$row[distair_unit]?></b></p></td>
                			</tr>
                            <? }
						if($row['distcity'] && $row['distcity']!=""){?>
                            <tr>
                    			<th><p><b>До центра города</b></p></th>
                        		<td><p><b><?=$row['distcity']?> <?=$row['distcity_unit']?></b></p></td>
                			</tr>
                            <? } 
                        if($row['infrastructure'] && $row['infrastructure']!=""){?>
                            <tr>
                    			<th><p><b>Инфраструктура</b></p></th>
                        		<td><p><b><?=$row['infrastructure']?> <?=$row['infrastructure_unit']?></b></p></td>
                			</tr>
                            <? } ?>
                	</table>
                    <input type="hidden" id="latlot" value="<?=$row[lat]?>" />
                	<input type="hidden" id="lnglot" value="<?=$row[lng]?>" />
         		</div>
		</div>
    </div>
 	<div class="wrap_fullwidth"> 
    	<div class='center'>
        	<div class="left_float" id="map_canvas" style="width:607px; height:400px"></div>
        	<? if($row[description_ru] && $row[description_ru]!=""){?>
            <p><?=$row[description_ru]?></p> <? }?>
    	</div>
    	<div class="wrap_fullwidth">
        	<div class='center'>
            	<div class="left_float" style="width:560px">
                	<div>
                	<? if($row['properties_id'] && $row['properties_id']!=""){?>
                    	<span class='latest_work merguynpoqr'>особенности</span><br /><hr size="1" style="margin-top:0px;border:none; background-color:#A8231A;height:1px; color:#A8231A" />
 					<?	$properties = explode(",", $row['properties_id']);
						$i=0;?>
                        <table align="center">
                        	<tr>
							<? foreach ($properties as $value) {
                            		$i++;
    								$query_properties = "SELECT properties FROM `properties` WHERE `id`='$value'";
									$result_properties = mysql_query($query_properties) or die('MySql Error' . mysql_error());
									$row_properties=mysql_fetch_array($result_properties);?>
									<td width="10px"></td>
                                    <td width="275px"><img src="images/tick.png" alt="" /> <?=$row_properties['properties']?></td>
								<?	if(!($i%2)){?> </tr><tr><? }
					 			} 
								if(!($i%2)){?> <td></td><? }?>
   					  		</tr>
                         </table>
                      <? } ?>
               		</div> 
               		<br />
               		<div>
					<? if($row['nearservices_id'] && $row['nearservices_id']!=""){?>
                    		<span class='latest_work merguynpoqr'>рядом c объектом</span><br /><hr size="1" style="margin-top:0px;border:none; background-color:#A8231A;height:1px; color:#A8231A" />
    					<?	$near = explode(",", $row['nearservices_id']);
							$i=0;?>
                        	<table align="center">
                            	<tr>
								<? foreach ($near as $value) {
									$i++;
									$query_nearservices = "SELECT nearservices FROM `nearservices` WHERE `id`='$value'";
									$result_nearservices = mysql_query($query_nearservices) or die('MySql Error' . mysql_error());
									$row_nearservices = mysql_fetch_array($result_nearservices);?>
                        			<td width="10px"></td>
                                    <td width="275px"><img src="images/tick.png" alt="" /><?=$row_nearservices['nearservices']?></td>
								<?	if(!($i%2)){?> </tr><tr><? }
                	 				} 
									if(!($i%2)){?> <td></td><? }?>
   					 			</tr>
                           </table>
                     <? }?>
                    </div>
             	</div>
             	<div class="right_float" style="width:362px">
             <? if($row[deal]!=2){?>
             	<div class="kreditdiv rounded"  style=" background-color:#FFF4DD;">
                    <span class='latest_work merguynpoqr'>Расчет кредита на объект</span><br />
					<div style="font-size:12px">
						<table border="0" cellpadding="0" cellspacing="5px">
							<tr>
								<td>Сумма кредита, €:</td>
								<td><input class="kredit" type="text" name="sum" id="sum" value=""  /></td>
								<td>1 - 10 000 000</td>
							</tr>
							<tr>
								<td>Срок кредита, лет:</td>
                        		<td><input class="kredit" type="text" name="period" id="period" value="10" /></td>
								<td>1 год - 30 лет</td> 
							</tr>
							<tr>
								<td>Годовая процентная ставка, %:</td>
								<td><input class="kredit" type="text" name="persent" id="persent" value="5" /></td>
								<td>1 - 100</td>
							</tr>
                        	<tr>
								<td><b>Ежемесячный платёж, €: &nbsp;</b></td>
								<td><input class="kredit" disabled="disabled" type="text" name="sumres" id="sumres" value="" /></td>
								<td></td>
							</tr>
						</table>
					</div>
                  
				</div><br />
               <? }
			   $query="SELECT * FROM  `homenumbers` WHERE `whereuse`='lot1' or `whereuse`='lot2' or `whereuse`='lot3' or `whereuse`='lot4' ";
   $result = mysql_query($query) or die('MySql Error' . mysql_error());
   ;?>
               <div  style="background-color:#FFF4DD" align="center">
                	<table class="mytable" >
                    <? while($row2=mysql_fetch_array($result)){?>
                  			<tr>
                                <th><p><b><?=$row2[city]?> </b></p></th>
                        		<td><p><b><?=$row2[phone]?></b></p></td>
                           	</tr>
                            <? } ?> 
                     </table> 
                    
                </div>
               <div style="background-color:#FFF4DD" align="center">
                	<a  class="modalbox  fancybox.iframe merguynpoqr noborder" href="message.php?lot=<?=$row[id]?>"><img  title="Отправить заявку на этот объект." id="lotimg" onmouseover="changeimgin()" onmouseout="changeimgout()" src="images/lot.png" alt="" /></a> 
            	</div>
             </div>
			</div>
     	</div>
	</div>
    <? $add.=" AND category.id=main.category_id";
			$add.=" AND objtype.id=main.objtype_id";
			$add.=" AND city.id=main.city_id";
			$add.=" AND region.id=main.region_id";
			$differents=$row[price]*20/100;
			$differents1=$row[price]+$differents;
			$differents2=$row[price]-$differents;
			
			$query="SELECT DISTINCT * FROM category,objtype,city,region,main WHERE main.active=1 AND main.id!='$row[id]' AND `deal`='$row[deal]' AND `num_of_rooms`='$row[num_of_rooms]' AND `objtype_id`='$row[objtype_id]' AND `price`<'$differents1' AND `price`>'$differents2'".$add;
   			$query_data = $query." ORDER BY date_created ASC LIMIT 0, 5";
			$result = mysql_query($query_data) or die('MySql Error' . mysql_error());
			$count = mysql_num_rows($result);
			
			
			if($count<5) {
			$query="SELECT DISTINCT * FROM category,objtype,city,region,main WHERE main.active=1 AND `deal`='$row[deal]' AND main.id!='$row[id]' AND`price`<'$differents1' AND `price`>'$differents2'".$add;
			$query_data1 = $query." ORDER BY date_created ASC LIMIT 0, 5";
   			$result = mysql_query($query_data1) or die('MySql Error' . mysql_error());
			};	
			$count = mysql_num_rows($result);
			
			
			if($count!=0) {	 

			if($row[deal]==2)$showdeal='Аренда,';
			else $showdeal='Продажа,'; ?>
			  
			
 
       <div class="wrap_fullwidth">  
    	<div class='center'> 
         <span class='latest_work merguynpoqr'>Похожие предложения</span><br /><hr size="1" style="margin-top:0px;border:none; background-color:#A8231A;height:1px; color:#A8231A" />
						<? while($row3=mysql_fetch_array($result)){
							if(!$row3['image'])	$mainimg="admin/images/noimage.jpg";
				 	else $mainimg="admin/uploads/".$row3['id']."/ready/low/".$row3['image'];
				 	$mainimgmid="admin/uploads/".$row3['id']."/ready/mid/".$row3['image']; 
					$specc='';?>
                     		
                        <div class="content_one_third portfolio_item" style="background: transparent url(../images/skin3/bg_portfolio_item1.png) center bottom no-repeat;">
                         
                          <div style="width:171px; height:330px; float:right;"     class="itemm2">
							<? if($row3['is_special_offer']=='1'){
                     			 $specc='спец. предложение';?>
								 	<div class="right_float spec" style="margin-left:140px; margin-top: 0px;"><img src="images/star.png"  alt="" /></div> <? } ?>
                                <table>	
                                 <tr>
                                	<td class="mt">  
                            			<a href='lot.php?id=<?=$row3['id']?>'> <img  src='<?=$mainimg?>' alt="" /></a> 
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="mt"> 
                                   
                                    		<h2><a href="lot.php?id=<?=$row3['id']?>">
											<?=$showdeal?> <br />
											<?=$row3[objtype]?> <br />
                                            <?=$row3[city]?></a></h2>
                        			</td>
                                 </tr>
                                 <tr>
                					<td class="mt">
                						<span class="sliderdate"><b style="font-size:11px; text-align:left; color:#F00"><?=$specc?></b></span> <h2 class="activered"><sup>&nbsp;</sup><?=$row3[price]?> €<sup>&nbsp;</sup></h2>
                					</td>
                				</tr>
                            	<tr>
                                    <td   class="mt">
                                    	<a href='lot.php?id=<?=$row3['id']?>'>ЛОТ:<?=$row3[artikul]?>, <?=$row3[category]?>, <?=$row3[region]?>, <?=$row3[num_of_rooms]?> спальни</a>
                                     </td>
                                 </tr>
                                 <tr>   
                                	<td style="display:none" class="mt">
                						<h2 style="text-transform:none"> <?=$row3[squarehouse]?>m<sup>2</sup></h2>
                					</td>
                                 </tr>
                               
                              </table>    
                			</div></div> <? } ?> 
        </div>
      </div>
                                 
   <? };
    require_once("bottom.inc");?>
</body>
</html>