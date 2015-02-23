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
	<script type='text/javascript' src="searchtable.js"></script>
    
<script type='text/javascript'>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'ru', includedLanguages: 'be,en,es,uk', layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT, autoDisplay: false}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
$(document).ready(function(){
	var deal=getUrlVars()['deal'];
	if(deal==2)	$("#tabb").tabs({ active: 1 }); 
	else $("#tabb").tabs(); 
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
	//go();
	//gorent();
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
<? require_once("admin/baza.php");
require_once("func.inc");?>
</head>
<body id='top' >
<? 

require_once("top.inc");?>
<div class="wrap_fullwidth" id='second_header'>
		<div class='center'>
		
			<p class="logo"><a href="index.php" title="CASA DE LUJO">CASA DE LUJO</a></p>
			<ul id="nav">
            	
				<li ><a href="index.php">Главная страница</a></li>
				<? if($_REQUEST[deal]==2){ ?>
                		<li><a href="<?=$_SERVER['PHP_SELF']?>?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=1">Продажа</a>
                        <? }
					else {?>
						<li class='current'><a href="<?=$_SERVER['PHP_SELF']?>?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=1">Продажа</a>
                        <? }?>
                <ul>
                	<li><a href='<?=$_SERVER['PHP_SELF']?>?cat=all&amp;reg=all&amp;city=all&amp;type=37&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt=""/>Апартаменты</a></li>
                	<li><a href='<?=$_SERVER['PHP_SELF']?>?cat=all&amp;reg=all&amp;city=all&amp;type=38&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Таунхаусы</a></li>
                	<li><a href='<?=$_SERVER['PHP_SELF']?>?cat=all&amp;reg=all&amp;city=all&amp;type=39&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Бунгало</a></li>
                	<li><a href='<?=$_SERVER['PHP_SELF']?>?cat=all&amp;reg=all&amp;city=all&amp;type=36&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Дуплекс</a></li>
                	<li><a href='<?=$_SERVER['PHP_SELF']?>?cat=all&amp;reg=all&amp;city=all&amp;type=35&amp;deal=1'><img class="my_margin" src="images/logo_menus1.png" alt="" />Виллы</a></li>
				</ul>
                </li>
                <? if($_REQUEST[deal]==2){ ?>
                		<li class='current'><a  href="<?=$_SERVER['PHP_SELF']?>?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=2">Аренда</a></li>
                        <? }
					else {?>
						<li><a href="<?=$_SERVER['PHP_SELF']?>?cat=all&amp;reg=all&amp;city=all&amp;type=all&amp;deal=2">Аренда</a></li> 
                        <? }?>
				
                <li><a href="services.php?pg=services">Услуги</a></li>
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
                        	<h2> <a href='properties.php?cat=all&amp;reg=all&amp;city=all&amp;type=37&amp;deal=1'>Апартаменты</a></h2>
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
   
 <? 

$param=$param="";
if($_SERVER['QUERY_STRING']=="")$urll=$dest=$_SERVER['PHP_SELF']."?";
else {
	if($_REQUEST[st])$param="st=".$_REQUEST[st]."&amp;";
	if($_REQUEST[cat])$paramm=$paramm."cat=".$_REQUEST[cat]."&amp;";
	if($_REQUEST[reg])$paramm=$paramm."reg=".$_REQUEST[reg]."&amp;";
	if($_REQUEST[city])$paramm=$paramm."city=".$_REQUEST[city]."&amp;";
	if($_REQUEST[type])$paramm=$paramm."type=".$_REQUEST[type]."&amp;";
	if($_REQUEST[prcl])$paramm=$paramm."prcl=".$_REQUEST[prcl]."&amp;";
	if($_REQUEST[prch])$paramm=$paramm."prch=".$_REQUEST[prch]."&amp;";
	if($_REQUEST[sq])$paramm=$paramm."sq=".$_REQUEST[sq]."&amp;";
	if($_REQUEST[sq1])$paramm=$paramm."sq1=".$_REQUEST[sq1]."&amp;";
	if($_REQUEST[rooms])$paramm=$paramm."rooms=".$_REQUEST[rooms]."&amp;";
	if($_REQUEST[rooms1])$paramm=$paramm."rooms1=".$_REQUEST[rooms1]."&amp;";
	if($_REQUEST[bathl])$paramm=$paramm."bathl=".$_REQUEST[bathl]."&amp;";
	if($_REQUEST[bathh])$paramm=$paramm."bathh=".$_REQUEST[bathh]."&amp;";
	if($_REQUEST[sow])$paramm=$paramm."sow=".$_REQUEST[sow]."&amp;";
	if($_REQUEST[deal])$paramm=$paramm."deal=".$_REQUEST[deal]."&amp;";
	$urll=$_SERVER['PHP_SELF']."?".$paramm;
						$dest=$urll.$param;
	
	}
$addquery="";
if($_REQUEST[cat]!=="all")  $addquery.=" AND `category_id`= '$_REQUEST[cat]'";
if($_REQUEST[reg]!=="all")$addquery.=" AND `region_id`= '$_REQUEST[reg]'";
if($_REQUEST[city]!=="all")$addquery.="AND `city_id`= '$_REQUEST[city]'";
if($_REQUEST[type]!=="all")$addquery.="AND `objtype_id`= '$_REQUEST[type]'";
if($_REQUEST[sq] || $_REQUEST[sq1]) $addquery.=" AND `squarehouse`>= '$_REQUEST[sq]' AND `squarehouse`<= '$_REQUEST[sq1]'";
if($_REQUEST[rooms] || $_REQUEST[rooms1]) $addquery.=" AND `num_of_rooms`>= '$_REQUEST[rooms]' AND `num_of_rooms`<= '$_REQUEST[rooms1]'";
if($_REQUEST[prcl] || $_REQUEST[prch]) $addquery.=" AND `price`>= '$_REQUEST[prcl]' AND `price`<= '$_REQUEST[prch]'";
if($_REQUEST[bathl] || $_REQUEST[bathh]) $addquery.=" AND `num_of_bath`>= '$_REQUEST[bathl]' AND `num_of_bath`<= '$_REQUEST[bathh]'";
	  

$queryall="SELECT * FROM `main`  WHERE `active`='1' AND `deal`='$_REQUEST[deal]'" .$addquery;	
if($_REQUEST[sow]=='spec') $queryall="SELECT * FROM `main`  WHERE `active`='1' AND `is_special_offer`='1' AND `deal`='$_REQUEST[deal]'" .$addquery;
$num=6; 
if($_REQUEST[p]){
	$page=$_REQUEST[p];
	$start=$num*$page-$num; 	
}
else {
	$page=1;
	$start=0;
}
if($_REQUEST[sow]=='look' && $_SESSION['looked']){
	$links = array_unique($_SESSION['looked']);
	$queryall="SELECT * FROM main  WHERE `active`='1'  AND `id` in( ";
	$addlook=implode( ',' ,$links );
	$queryall=$queryall.$addlook." )";
}
$resnum=mysql_query($queryall)or die('MySql Error' .mysql_error());
$count = mysql_num_rows($resnum);
if($_REQUEST[deal]==2)$otherdeal=1;
else $otherdeal=2;
$otherqueryall="SELECT * FROM `main`  WHERE `active`='1' AND `deal`='$otherdeal'" ;	
if($_REQUEST[sow]=='spec') $otherqueryall="SELECT * FROM `main`  WHERE `active`='1' AND `is_special_offer`='1' AND `deal`='$otherdeal'" .$addquery;
$otherresnum=mysql_query($otherqueryall)or die('MySql Error' .mysql_error());
$othercount = mysql_num_rows($otherresnum);

$pages=ceil ($count/$num); 
$query_pag_data = $queryall." ORDER BY date_created ASC LIMIT $start, $num";      
if($_REQUEST[st]){
	if($_REQUEST[st]=="pr") $query_pag_data = $queryall." ORDER BY price  ASC  LIMIT $start, $num";
	if($_REQUEST[st]=="prDESC") $query_pag_data = $queryall." ORDER BY price DESC LIMIT $start, $num";
	if($_REQUEST[st]=="sq") $query_pag_data = $queryall." ORDER BY squarehouse ASC LIMIT $start, $num";
	if($_REQUEST[st]=="sqDESC") $query_pag_data = $queryall." ORDER BY squarehouse DESC LIMIT $start, $num";
	if($_REQUEST[st]=="new") $query_pag_data = $queryall." ORDER BY date_created ASC LIMIT $start, $num";
	if($_REQUEST[st]=="newDESC") $query_pag_data = $queryall." ORDER BY date_created DESC LIMIT $start, $num";
}
$resall=mysql_query($query_pag_data)or die('MySql Error' .mysql_error());


		$show=$showdeal='';
		if($_REQUEST[sow]=="look")$show='просмотренных предложений';
		if($_REQUEST[sow]=="spec")$show='специальных предложений';
		
		if($_REQUEST[sow]!="look"){
			if($_REQUEST[deal]==2)$showdeal='аренда: ';
			else $showdeal='продажа: ';
		}
		
		require_once("searchtable.inc");
?>
      <div class="wrap_fullwidth small_margin" style="min-height:230px">
		<div class='center' style="overflow:visible">
          <? if($count == 0 || ($_REQUEST[sow]=='look' && !$_SESSION['looked'])){
				echo '<h2 class="error" " class="alert-error">' . "Ничего не найдено" . '</h2>'; 
				}
			else{ ?> 
            	<span class='latest_work merguynpoqr'><?=$showdeal?> </span>
         		<div class='itemmain'>
   							<table>  
                            	<tr>
                                	<td  class="mtlong">
                                    	<h3 style="text-decoration:!important none">Всего найдено <?=$show?>: <?=$count?></h3>
                                    </td>
                                   <? if($count>1){?>
                                    <td class="mtlong2">
                                           <? 
										if($_REQUEST[st]){   
                                    	   	 if($_REQUEST[st]=="new"){?>
                                            	<a title="сортировать по времени добавления" class='hmenu activered' href="<?=$urll?>st=newDESC">сначала новые</a>
                                        	<? }
											 elseif($_REQUEST[st]=="newDESC"){?>
                                         		<a title="сортировать по времени добавления" class='hmenu activered' href="<?=$urll?>st=new">сначала новые</a>
                                             <? }
                                    	 	else { ?>
                                				<a title="сортировать по времени добавления" class='hmenu' href="<?=$urll?>st=new">сначала новые</a>
                                             <? }
											}
										else {?>
                                  				<a title="сортировать по времени добавления" class='hmenu activered' href="<?=$urll?>st=new">сначала новые</a>
                                             <? }?>
                					</td>
                                    <td class="mt">
                                    	<? if($_REQUEST[st]=="sq"){?>
                                        
                                       			<a title="сортировать по площади" class='hmenu activered' href="<?=$urll?>st=sqDESC">площадь</a>
                                        	<? }
											elseif($_REQUEST[st]=="sqDESC") {?>
                                    	 		<a title="сортировать по площади" class='hmenu activered' href="<?=$urll?>st=sq">площадь</a>
                                             <? }
                                             else {?>
                                    	 		<a title="сортировать по площади" class='hmenu' href="<?=$urll?>st=sq">площадь</a>
                                             <? }?>
                                    </td>
                					<td class="mt">
                                    	<? if($_REQUEST[st]=="pr"){?>
                                        
                                       			<a title="сортировать по цене" class='hmenu activered' href="<?=$urll?>st=prDESC">цена</a>
                                        	<? }
											elseif($_REQUEST[st]=="prDESC") {?> 
                                    	 		<a title="сортировать по цене" class='hmenu activered' href="<?=$urll?>st=pr">цена</a>
                                             <? } 
                                      else {?> 
                                    	 		<a title="сортировать по цене" class='hmenu ' href="<?=$urll?>st=pr">цена</a>
                                             <? } ?> 

                					</td><? }?>
                				</tr>
                			</table>
                    	                    
			</div>
                    
         		<? 
                while ($row = mysql_fetch_array($resall)) { 
					$query_all = "SELECT category.category, objtype.objtype ,city.city, region.region FROM category,objtype,city,region WHERE category.id='$row[category_id]' AND objtype.id='$row[objtype_id]' AND city.id='$row[city_id]' AND region.id='$row[region_id]'";
					$result_all = mysql_query($query_all) or die('MySql Error' . mysql_error());
					$row_all = mysql_fetch_array($result_all);
					$deal_type="Продаётся ";
					if($row['objtype_id']==37)$deal_type="Продаются ";
					if($row['deal']==2){
						$deal_type="Сдаётся в аренду ";
						if($row['objtype_id']==37)$deal_type="Сдаются в аренду ";
					}
			 	 	if(!$row['image'])	$mainimg="admin/images/noimage.jpg";
				 	else $mainimg="admin/uploads/".$row['id']."/ready/low/".$row['image'];
				 	$mainimgmid="admin/uploads/".$row['id']."/ready/mid/".$row['image'];
				 ?>
			
                    <div class='itemm'>
                   <? if($row['is_special_offer']=='1'){?>
                        <div class="right_float spec"><img src="images/spec10.png" alt="" /></div> <? } ?>
							<table> 
                            	<tr>
                                	<td width="164px">
                            			<a class="thumbnail" href='lot.php?id=<?=$row['id']?>'>
                                        <img  src='<?=$mainimg?>' alt="" /><span><img  src='<?=$mainimgmid?>' alt="" /></span></a>
                                    </td>
                                    <td class="mtlong">
                                    		<h2><a href='lot.php?id=<?=$row['id']?>'> <?=$deal_type.$row_all[objtype]?> в <?=$row_all[city]?></a></h2>
                        					<a href='lot.php?id=<?=$row['id']?>'>ЛОТ: <?=$row[artikul]?>, <?=$row_all[category]?>, <?=$row_all[region]?>, спальни: <?=$row[num_of_rooms]?>, ванны: <?=$row[num_of_bath]?></a>
                                  	</td>
                                    
                                	<td class="mt">
                						<h2><?=$row[squarehouse]?> m<sup>2</sup></h2>
                					</td>
                					<td class="mt">
                						<h2 class="activered"><sup>&nbsp;</sup><?=$row[price]?> €<sup>&nbsp;</sup></h2>
                					</td>
                				</tr> 
                			</table>
                   		</div>
                	<? } 
        }?> 
     </div>
   </div>                  
 		
    <div class="pagination">
    	<div class='center'>
    		<? if($pages>1) mypagesnew($num,$page,$pages, $dest);?>
		</div>
   	</div>
   
<? 
require_once("bottom.inc");?>
	
</body>
</html>