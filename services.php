<? 
if(!$_GET[id] && !$_GET[pg]){
	header("Location: index.php");
   			 exit;
} 
require_once("admin/baza.php");

require_once("func.inc");
	if($_GET[pg]){
		$q = mysql_query("SELECT * FROM seo WHERE `page`='$_GET[pg]' ");			
		$res = mysql_fetch_assoc($q);
		$title=$res[title];
		$description=$res[description];
		$keywords=$res[keywords];
		
	}
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-translate-customization" content="152f8d57a44c342a-0052517fa9bfb665-gea7eae232f5e6f38-b"></meta>
<title><?=$title?></title>
<meta name="keywords" content="<?=$keywords?>" />
<meta name="description" content="<?=$description?>" />
<meta name="og:type" content="website" />
<meta name="og:locale" content="ru" />
<meta name="og:image" content="/images/skin3/logo_og.png" />
<meta name="og:title" content="<?=$title?>" />
<meta name="og:description" content="<?=$description?>" />


<link rel="image_src" href="/images/skin3/logo_og.png" />
<meta name="mrc__share_description" content="<?=$description?>" />
<meta name="mrc__share_title" content="<?=$title?>" />
	
	
	<link rel="stylesheet" type="text/css" media="screen"	href="css/kriframework.css"  />
	<link rel="stylesheet" type="text/css" media="screen"	href="css/style.css"  />	
    <link rel="stylesheet" type="text/css" media="screen"	href="css/style1.css"  />
	<link rel="stylesheet" type="text/css"					href="css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css"					href="css/mycss.css" />
   	<link rel="stylesheet" type="text/css" media="all" 		href="modal/css/kstyle.css"/>
  	<link rel="stylesheet" type="text/css" media="all" 		href="modal/fancybox2/source/jquery.fancybox.css"/>
    
	
   	
	    
  	<script type='text/javascript' src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src='modal/fancybox2/source/jquery.fancybox.js'></script>
    <script type='text/javascript' src="js/jquery-ui-1.10.2.custom.min.js"></script>
	<script type='text/javascript' src='js/jquery.js'></script>
	<script type='text/javascript' src='js/cufon.js'></script>
	<script type='text/javascript' src='prettyphoto/js/jquery.prettyPhoto.js'  charset="utf-8"></script>
	<script type='text/javascript' src='js/custom.js'></script>
	<script type='text/javascript' src='js/myjs.js'></script>
    <script type="text/javascript" 	src="http://maps.google.com/maps/api/js?sensor=false&amp;language=ru"></script>
   
	
    
    
    <script type='text/javascript'>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'ru', includedLanguages: 'be,en,es,uk', layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT, autoDisplay: false}, 'google_translate_element');
}

var geocoder;
var map;
var marker;
function initialize(lat,lng){
	
//Определение карты
  var latlng = new google.maps.LatLng(lat,lng);
  var options = {
    zoom: 16,
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
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
$(document).ready(function(){
	
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
	var latcont=$('#latcont').val();
	var lngcont=$('#lngcont').val();
	initialize(latcont,lngcont); 
			geocoder.geocode({'latLng': marker.getPosition()});
});
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51353079-1', 'casa-de-lujo.com');
  ga('send', 'pageview');

</script>
</head>
<body id='top' >

	<?  require_once("top.inc");?>

	<div class="wrap_fullwidth" id='second_header'>
		<div class='center'>
		
			<p class="logo "><a href="index.php" title="CASA DE LUJO">CASA DE LUJO</a></p>
				<ul id="nav">
            	<li><a href="index.php">Главная страница</a></li>
				<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=1'>Продажа</a>
                <ul>
                	<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=37&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt=""/>Апартаменты</a></li>
                	<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=38&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Таунхаусы</a></li>
                	<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=39&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Бунгало</a></li>
                	<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=36&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Дуплекс</a></li>
                	<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=35&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Виллы</a></li>
				</ul>
                </li>
				<li><a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=2'>Аренда</a></li> 
                <? if($_GET[pg]==services){ ?>
                <li class='current'><a href="services.php?pg=services">Услуги</a></li> 
				 <? }
					else {?> <li><a href="services.php?pg=services">Услуги</a></li> <? }?>
                <? if($_GET[pg]==info || $_GET[id]){ ?>
                	 <li class='current'><a href="services.php?pg=info">Полезная информация</a></li>
                 <? }
					else {?> <li><a href="services.php?pg=info">Полезная информация</a></li><? }?>
               <? if($_GET[pg]==contacts){ ?>
                	 <li class='current'><a href="services.php?pg=contacts">Контакты</a></li>
                 <? }
					else {?> <li><a href="services.php?pg=contacts">Контакты</a></li><? }?>
            </ul>
		
		</div>
	</div>
	
		<div class='center' style="min-height:600px;color:rgb(64, 49, 30);font-size: 14px;">
        <? 	if($_GET[id]){ 
				$limit = mysql_query("SELECT * FROM `pages` WHERE `id`='$_GET[id]'")or die(mysql_error());
				$result=mysql_fetch_assoc( $limit);
				if($result['active'] != 'Активно'){
					require_once("include/membersite_config.php");
						if(!($fgmembersite->CheckLogin()))
							{
    							$fgmembersite->RedirectToURL("index.php");
   			 					exit;
							}
				}
				?>
				<table>	
					<tr>
        				<td>
    					 	<span class='latest_work merguynpoqr'><?=$result[story_name]?></span><br /><hr size="1" style="margin-top:0px;border:none; background-color:#A8231A;height:1px; color:#A8231A" />
						<?	echo $result[story];?>
						
      					</td> 
					</tr>
                </table>
       		<? } 

	
			if($_GET[pg]==info || $_GET[search]) {?>
				<!--<span class='latest_work merguynpoqr'>Полезная информация:</span><br />-->
				<? require_once("info.inc");
		}
			if($_GET[pg]==contacts){
			  ?>
				
                <div class="right_float" id="map_canvas" style="width:600px; height:450px"></div>
                <?
				$query="SELECT * FROM  `homenumbers` WHERE `whereuse`='lot1' or `whereuse`='lot2' or `whereuse`='lot3' or `whereuse`='lot4' ";
   				$result = mysql_query($query) or die('MySql Error' . mysql_error());?>
                
				<div class="left_float"  style="background-color:#FFF4DD; height:420px; width:300px; padding:15px">
                <span style="margin-left:15px" class='latest_work merguynpoqr'>Телефоны:</span><br /><hr size="1" style="margin-top:0px;border:none; background-color:#A8231A;height:1px; color:#A8231A" />
                	<table class="mytable" >
                    <? while($row2=mysql_fetch_array($result)){?>
                  			<tr>
                                <th><p><b><?=$row2[city]?> </b></p></th>
                        		<td><p><b> <?=$row2[phone]?></b></p></td>
                           	</tr>
                            <? } ?> 
                     </table><br />
                     <span style="margin-left:15px" class='latest_work merguynpoqr'>Адрес:</span><br /><hr size="1" style="margin-top:0px;border:none; background-color:#A8231A;height:1px; color:#A8231A" /><span style="color:#FA8416; font-size:20px">S</span><span style="color:#666563; font-size:20px">pain</span><span style="color:#FA8416; font-size:20px">R</span><span style="color:#666563; font-size:20px">ealty</span><span style="color:#FA8416; font-size:20px">G</span><span style="color:#666563; font-size:20px">roup </span>
                     <table class="mytable" >
                     <tr>
                                <th style="line-height:20px"><p><b><?=$row1[address]?></b></p></th>
                        		<td></td>
                     </tr>
                     
                    
                    </table><br />
                     <span style="margin-left:15px" class='latest_work merguynpoqr'>Skype , email:</span><br /><hr size="1" style="margin-top:0px;border:none; background-color:#A8231A;height:1px; color:#A8231A" />
                     <table class="mytable" >
                     		<tr>
                                <th><p><b>Skype: </b></p></th>
                        		<td><p><b><?=$row1[skype]?></b></p></td>
                            </tr>
                    		<tr>
                                <th><p><b>Email: </b></p></th>
                        		<td><p><b><?=$row1[email]?></b></p></td>
                            </tr>
                    </table>
                </div>
				<input type="hidden" id="latcont" value="<?=$row1[lat]?>" />
                <input type="hidden" id="lngcont" value="<?=$row1[lng]?>" />
				<?
            // require_once("contacts.html");	
			};
			if($_GET[pg]==services){ ?>
				<span class='latest_work merguynpoqr'>Услуги:</span><br />
				<? require_once("service.html");
			}
		?>
        </div>
  

   <?  require_once("bottom.inc");?> 
	
</body>
</html>