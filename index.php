<?  session_start();
	require_once("admin/baza.php");
	$q = mysql_query("SELECT * FROM seo WHERE `page`='home'");			
	$res = mysql_fetch_assoc($q);
	$title=$res[title];
	$description=$res[description];
	$keywords=$res[keywords]; 
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
<meta name="og:image" content="/images/skin3/logo_og.png" />
<meta name="og:title" content="<?=$title?>" />
<meta name="og:description" content="<?=$description?>" />

<link rel="image_src" href="/images/skin3/logo_og.png" />
<meta name="mrc__share_description" content="<?=$description?>" />
<meta name="mrc__share_title" content="<?=$title?>" />

	<link rel="stylesheet" type="text/css" 	href="css/kriframework.css"  />
	<link rel="stylesheet" type="text/css" 	href="css/style.css"  />	
    <link rel="stylesheet" type="text/css" 	href="css/style1.css"  />
	<link rel="stylesheet" type="text/css"	href="css/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" 	href="modal/css/kstyle.css"/>
  	<link rel="stylesheet" type="text/css" 	href="modal/fancybox2/source/jquery.fancybox.css"/>
	<link rel="stylesheet" type="text/css"	href="css/mycss.css" />
   	
	    
  	<script type='text/javascript' src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src='modal/fancybox2/source/jquery.fancybox.js'></script>
    <script type='text/javascript' src="js/jquery-ui-1.10.2.custom.min.js"></script>
	<script type='text/javascript' src='js/jquery.js'></script>
	<script type='text/javascript' src='js/cufon.js'></script>
	<script type='text/javascript' src='prettyphoto/js/jquery.prettyPhoto.js'  charset="utf-8"></script>
	<script type='text/javascript' src='js/custom.js'></script>
    <script type='text/javascript' src='js/myjs.js'></script>
   	<script type='text/javascript' src="searchtable.js"></script>
	
    
    
<script type='text/javascript'>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'ru', includedLanguages: 'be,en,es,uk', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL, autoDisplay: false},  'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#tabb").tabs();
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
	$('.numint').bind("change keyup input click", function() {
    	if (this.value.match(/[^0-9]/g)) {
        	this.value = this.value.replace(/[^0-9]/g, '');
    	}
	});
	go();
	gorent();
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

<? require_once("top.inc");?>

	<div class="wrap_fullwidth" id='second_header'>
		<div class='center'>
		
			<p class="logo"><a href='index.php' title="CASA DE LUJO">CASA DE LUJO</a></p>
			<ul id="nav">
            	<li class='current'><a href='index.php'>Главная страница</a></li>
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
                <li><a href="services.php?pg=services">Услуги</a></li>
                <li><a href="services.php?pg=info">Полезная информация</a></li>
                <li><a href="services.php?pg=contacts">Контакты</a></li>
			</ul>
		
		</div>

	</div>
	<div class="wrap_fullwidth" id='feature_background'>	

		<div class='center' id="feature_wrap">
  
			<div id="featured" class='newsslider'>		
				<div style="opacity:0.9; position: absolute; z-index: 1000;">
					<img  src="images/novinka.png" alt="" />
				</div>
                
	<?  $query="SELECT * FROM `main`  WHERE `active`='1' ORDER BY date_created DESC  LIMIT 0, 10 ";
		$result=mysql_query($query)or die(mysql_error());
		$res = mysql_num_rows($result); 
		
			while ($row = mysql_fetch_array($result)) { 
				$query_all = "SELECT objtype.objtype ,city.city FROM objtype,city WHERE  objtype.id='$row[objtype_id]' AND city.id='$row[city_id]' ";
				$result_all = mysql_query($query_all) or die('MySql Error' . mysql_error());
				$row_all = mysql_fetch_array($result_all);?>
					<div class="featured featured">
                   <? $specc='';
                      if($row['is_special_offer']=='1'){
                      $specc='специальное предложение';?>
                        <div class="right_float" style="opacity:0.8; position: absolute; margin-left:565px; margin-top:0px; z-index: 1000"><img src="images/spec10.png" alt="" /></div> <? } ?>
                    
					 <? if(!$row['image'])	$mainimg="admin/images/noimage.jpg";
				 		else $mainimg="admin/uploads/".$row['id']."/ready/wide/".$row['image'];?>
                        <a href='lot.php?id=<?=$row['id']?>'>
							<img src='<?=$mainimg;?>' alt=""  />
                                                  
                        
							<span class='feature_excerpt'>
								<strong class='sliderheading'><?=$row_all[objtype]?>, <?=$row_all[city]?>,<?=$row['squarehouse']?>m<sup>2</sup></strong>
								<span class="sliderdate"><b style="font-size:15px"><?=$row['price']?>€</b> <?=$specc?></span>
								<span style="color:#FA8416">S</span><span style="color:#666563">pain</span><span style="color:#FA8416">R</span><span style="color:#666563">ealty</span><span style="color:#FA8416">G</span><span style="color:#666563">roup </span>
                                <span class='slidercontent merguyn'> Недвижимость в Испании!</span>
							</span>
						</a>
					</div>
					<?  }?>	 
					
					
				</div>
				
				
				<span class='bottom_right_rounded_corner '></span>
				<span class='bottom_left_rounded_corner '></span>
				<span class='top_right_rounded_corner '></span>
				<span class='top_left_rounded_corner '></span>
		
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
<?  require_once("searchtable.inc");?> 
<?  require_once("bottom.inc");?> 
</body>
</html>