// JavaScript Document
function showhide()
	{
		  var deal=$('#deal').val();
		  if(deal==2) {
			  $('#pr_table').css('display','block');
			  $('#pr').text('Цена долгосрочной аренды € ');
		  }
		  else {
			  $('#pr_table').css('display','none');
			  $('#pr').text('Цена € ');
		  }
	}	
function runcountry()
	{
		  var countryid=$('#selcountry').val();
		  $.ajax({
		  type: "POST",
		  url: "ajaxselect.php",
		  dataType: "json",
		  data: "country="+countryid,
		  success: function(data)
		  {
			$("#region").html(data.region);
			$("#city").html(data.city);
		  }
		})
	}	
function runregion()
	{
		  var regionid=$('#selregion').val();
		  $.ajax({
		  type: "POST",
		  url: "ajaxselect.php",
		  dataType: "json",
		  data: "region="+regionid,
		  success: function(data)
		  {
			//$("#country").html(data.country);
			$("#city").html(data.city);
		  }
		})
	}
function runcity()
	{
		  var cityid=$('#selcity').val();
		  var ccity=$('#selcity option:selected').text();
		  $.ajax({
		  type: "POST",
		  url: "ajaxselect.php",
		  dataType: "json",
		  data: "city="+cityid,
		  success: function(data) 
		  {
			$("#country").html(data.country);
			$("#region").html(data.region);
			if(ccity!="Все города"){
			 	document.getElementById('address').focus();			 
				$('#address').val(ccity);
			 	var element = document.getElementById('address');
			 	if( window.KeyEvent ) // Для FF
 					{
  						var o = document.createEvent('KeyEvents');
  						o.initKeyEvent( 'keydown', true, true, window, false, false, false, false, 17, 0 );
					} 
			 	else// Для остальных браузеров
 					{
  						var o = document.createEvent('UIEvents');
  						o.initUIEvent( 'keydown', true, true, window, 1 );
  						o.keyCode = 17; // Указываем дополнительный параметр, так как initUIEvent его не принимает
					}
				element.dispatchEvent(o);
			 }
		  }
		})
	}

<!--cancel-->
function cancel(idd){
	var ankap=(Math.random());
	var val = $('#name'+idd+'').val();
	var i = $('#ident'+idd+'').val();
	var id=$('#hidden').val();
	var main=$('#main'+idd+'').val();
	$('#img-' + i).imgAreaSelect({remove: true });
	 if(main=='false'){
     $('#'+i+'').html('<table class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+id+'/ready/low/'+ val + '?salt='+ankap+'" alt="' + val + '"/></td><td width="150px"><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+false+','+i+')">повернуть налево</a><br /><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+false+','+i+')">повернуть направо</a><br /><a href="javascript:void(0)" onClick="edit(\''+ val + '\','+false+','+i+')">миниатюра</a><br /><a href="javascript:void(0)" onClick="del(\''+ val + '\','+i+')" >удалить</a><br/><a href="javascript:void(0)" onClick="makemain(\''+ val + '\','+i+')" >сделать главной</a></td></tr></table>');  }
	 else {
		 $('#'+i+'').html('<table id="mainimage" class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+id+'/ready/low/'+ val + '?salt='+ankap+'" alt="' + val + '" title="' + val + '"/></td><td width="150px"><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+true+','+i+')">повернуть налево</a><br /><a class="mylink" href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+true+','+i+')">повернуть направо</a><br /><a class="mylink" href="javascript:void(0)" onClick="edit(\''+ val + '\','+true+','+i+')">миниатюра</a><br /><h2 id="mainimage">Главная</h2></td></tr></table>');
	 }
}		

<!--crop-->
function crop(idd){
	var ankap=(Math.random());
	if(!$('#x2'+idd+'').val()){
		var val = $('#name'+idd+'').val();
		var i = $('#ident'+idd+'').val();
		var main=$('#main'+idd+'').val();
		var id=$('#hidden').val();
		 alert('выделите область');	
		edit(val,main,i);
		}
	else{
		var x1 = $('#x1'+idd+'').val();
		var y1 = $('#y1'+idd+'').val();
		var x2 = $('#x2'+idd+'').val();
		var y2 = $('#y2'+idd+'').val();
		var w = $('#w'+idd+'').val();
		var h = $('#h'+idd+'').val();
		var val = $('#name'+idd+'').val();
		var i = $('#ident'+idd+'').val();
		var main=$('#main'+idd+'').val();
		var id=$('#hidden').val();
		$('#img-' + i).imgAreaSelect({remove: true });
		$('#'+i+'').html('<img width="150px" src="images/gif-loader.gif" alt="loader"/>');
 		$.ajax({ 
		  	type: "POST",
		  	url: "ajaxcreate.php",
		  	dataType: "json",
		 	data: {
			  	 x1: x1,
				 x2: x2,
				 y1: y1,
				 y2: y2,
				 w: w,
				 h: h,
				 name: val,
				 id:$('#hidden').val()
				},
			success: function(data)
		  {
		 if(main=='false'){
     $('#'+i+'').html('<table class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+id+'/ready/low/'+ val + '?salt='+ankap+'" alt="' + val + '"/></td><td width="150px"><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+false+','+i+')">повернуть налево</a><br /><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+false+','+i+')">повернуть направо</a><br /><a href="javascript:void(0)" onClick="edit(\''+ val + '\','+false+','+i+')">миниатюра</a><br /><a href="javascript:void(0)" onClick="del(\''+ val + '\','+i+')" >удалить</a><br/><a href="javascript:void(0)" onClick="makemain(\''+ val + '\','+i+')" >сделать главной</a></td></tr></table>');  }
	 else {
		 $('#'+i+'').html('<table id="mainimage" class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+id+'/ready/low/'+ val + '?salt='+ankap+'" alt="' + val + '" title="' + val + '"/></td><td width="150px"><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+true+','+i+')">повернуть налево</a><br /><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+true+','+i+')">повернуть направо</a><br /><a class="mylink" href="javascript:void(0)" onClick="edit(\''+ val + '\','+true+','+i+')">миниатюра</a><br /><h2 id="mainimage">Главная</h2></td></tr></table>');
	 }
			}
		})
	}
}
<!--rotate-->
function rot(val,d,main,i){
	var ankap=(Math.random());
	var id=$("#hidden").val();
	$('#'+i+'').html('<img width="150px" src="images/gif-loader.gif" alt="loader"/>');
	
	$.ajax({ 
		  type: "POST",
		  url: "ajaxcreate.php",
		  dataType: "json",
		
		 data: {
			  		 rot: val, 
					 direction: d,
					 id:$("#hidden").val()
				},
		success: function(data)
		  {
	
	 if(main==false){
     $('#'+i+'').html('<table class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+id+'/ready/low/'+ val + '?salt='+ankap+'" alt="' + val + '"/></td><td width="150px"><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+false+','+i+')">повернуть налево</a><br /><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+false+','+i+')">повернуть направо</a><br /><a href="javascript:void(0)" onClick="edit(\''+ val + '\','+false+','+i+')">миниатюра</a><br /><a href="javascript:void(0)" onClick="del(\''+ val + '\','+i+')" >удалить</a><br/><a href="javascript:void(0)" onClick="makemain(\''+ val + '\','+i+')" >сделать главной</a></td></tr></table>');  }
	 else {
		 $('#'+i+'').html('<table id="mainimage" class="table table-striped table-bordered  table-condensed"><tr><td><img  width="200px" src="uploads/'+id+'/ready/low/'+ val + '?salt='+ankap+'" alt="' + val + '" title="' + val + '"/></td><td width="150px"><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+true+','+i+')">повернуть налево</a><br /><a class="mylink" href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+true+','+i+')">повернуть направо</a><br /><a class="mylink"  href="javascript:void(0)" onClick="edit(\''+ val + '\','+true+','+i+')">миниатюра</a><br /><h2 id="mainimage">Главная</h2></td></tr></table>');
	 }
 	}
	})
}

<!--edit-->
function edit(val,main,i){
	var ankap=(Math.random());
	var id=$("#hidden").val();
		$('#'+i+'').html('<br/><div class="btn-group"><input type="hidden" name="x1'+i+'" value="" id="x1'+i+'"/><input type="hidden" name="main'+i+'" value="" id="main'+i+'"/><input type="hidden" name="y1'+i+'" value="" id="y1'+i+'"/><input type="hidden" name="x2'+i+'" value="" id="x2'+i+'"/><input type="hidden" name="y2'+i+'" value="" id="y2'+i+'"/><input type="hidden" name="w'+i+'" value="" id="w'+i+'"/><input type="hidden" name="h'+i+'" value="" id="h'+i+'"/><input type="hidden" name="name'+i+'" value="" id="name'+i+'"/><input type="hidden" name="ident'+i+'" value="" id="ident'+i+'"/><button class="btn" onclick="crop('+i+')">обрезать</button><button class="btn" onclick="cancel('+i+')">отменить</button></div><br/><img id="img-'+i+'"  onload="imgselect(\''+i+'\')" src="uploads/'+id+'/' + val + '?a='+ankap+'" alt="' + val + '">');

$('#img-' + i).imgAreaSelect({aspectRatio: "4:3", handles: true, onSelectEnd: function (img, selection) {
	$('#x1'+i+'').val(selection.x1);
	$('#y1'+i+'').val(selection.y1);
	$('#x2'+i+'').val(selection.x2);
	$('#y2'+i+'').val(selection.y2);
	$('#w'+i+'').val(selection.width);
	$('#h'+i+'').val(selection.height);
	        } });
	
$('#ident'+i+'').val(i);	
$('#name'+i+'').val(val);
$('#main'+i+'').val(main);
			};
<!--makemain-->
function makemain(val, i){
	var ankap=(Math.random());
	$.ajax({ 
		  
		  type: "POST",
		  url: "ajaxcreate.php",
		  dataType: "json",
		
		 data: {
			  	 makemain:val,
				 id:$("#hidden").val()
				 },
		
		success: function(data)
		  {
		$('#111').empty();
		jQuery.each(data.files,function(i,val) {
	 if(val!==data.main){
     $('#111').append('<div id="'+i+'"><table class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+data.id+'/ready/low/'+ val + '?a='+ankap+'" alt="' + val + '?a='+ankap+'"></td><td width="150px"><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+false+','+i+')">повернуть налево</a><br /><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+false+','+i+')">повернуть направо</a><br /><a href="javascript:void(0)" onClick="edit(\''+ val + '\','+false+','+i+')">миниатюра</a><br /><a href="javascript:void(0)" onClick="del(\''+ val + '\','+i+')" >удалить</a><br/><a href="javascript:void(0)" onClick="makemain(\''+ val + '\','+i+')" >сделать главной</a></td></tr></table><div>');  }
	 else {
		 $('#111').append('<div id="'+i+'"><table id="mainimage" class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+data.id+'/ready/low/'+ val + '?a='+ankap+'" alt="' + val + '" title="' + val + '"></td><td width="150px"><a class="mylink" href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+true+','+i+')">повернуть налево</a><br /><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+true+','+i+')">повернуть направо</a><br /><a class="mylink"  href="javascript:void(0)" onClick="edit(\''+ val + '\','+true+','+i+')">миниатюра</a><br /><h2 id="mainimage">Главная</h2></td></tr></table><div>');
	 }
     });
	
			}
			});
}
<!--delete-->
function del(val, i){
	var ankap=(Math.random());
	var itemid =$("#hidden").val();
	if(confirm("Вы уверены?")){
	$('#img-' + i).attr('src', 'images/ajax-loader.gif');
		$.ajax({ 
		  type: "POST",
		  url: "ajaxcreate.php",
		  dataType: "json",
		
		 data: {
			  	 del: val, 
				 itemid: itemid	
				},
		success: function(data) 
		  {		
		 $('#'+i+'').empty();
		} 
		})
	}
}
<!--edititem-->
function edititem(id){
	
	$.ajax({ 
		  
		  type: "POST",
		  url: "ajaxcreate.php",
		  dataType: "json",
		  
		
		 data: {
			  	 edit:id,
				},
		
		success: function(data)
				  {	
				  	if(data.is_special_offer=="0")	document.getElementById('radio').checked=false;					 	
					else document.getElementById('radio').checked=true;	
					if(data.price_ot!=0) $("#price_ot").val(data.price_ot); 
					 
					$("#title").val(data.artikul);
					$("#sozdano").val(data.date_created);
					$("#upd").val(data.date_updated);
					$("#selactive").val(data.active);
					$("#deal").val(data.deal);
					if(data.objtype_id!=0) $("#seltypeobj").val(data.objtype_id);
					if(data.category_id!=0) $("#selcategory").val(data.category_id);
					$("#price").val(data.price);
					
					$("#condominimum").val(data.condominimum);
					$("#condominimum_unit").val(data.condominimum_unit);
					$("#distsea").val(data.distsea);
					$("#distsea_unit").val(data.distsea_unit);
					$("#distair").val(data.distair);
					$("#distair_unit").val(data.distair_unit);
					
					$("#distcity").val(data.distcity);
					$("#distcity_unit").val(data.distcity_unit);
					$("#infrastructure").val(data.infrastructure);
					$("#infrastructure_unit").val(data.infrastructure_unit);
					$("#year_built").val(data.year_built);
					
					$("#num_of_rooms").val(data.num_of_rooms);
					$("#floor").val(data.floor);
					$("#floors").val(data.floor_total);
					$("#squarehouse").val(data.squarehouse);
					$("#squarearea").val(data.squarearea);
					$("#squareterrace").val(data.squareterrace);
					$("#squarsun").val(data.squarsun);
					
					$("#num_of_bath").val(data.num_of_bath);
					$("#description_ru").val(data.description_ru);
					$("#title_ru").val(data.title_ru); 
					$("#seo_keywords_ru").val(data.seo_keywords_ru);
					$("#seo_description_ru").val(data.seo_description_ru);
					$("#update").css("visibility", "visible");
					
					$("#May_1m").val(data.May_1m);
					$("#May_1w").val(data.May_1w);
					$("#May_2w").val(data.May_2w);
					
					$("#June_1m").val(data.June_1m);
					$("#June_1w").val(data.June_1w);
					$("#June_2w").val(data.June_2w);
					
					$("#August_1m").val(data.August_1m);
					$("#August_1w").val(data.August_1w);
					$("#August_2w").val(data.August_2w);
					
					$("#month_1m").val(data.month_1m);
					$("#month_1w").val(data.month_1w);
					$("#month_2w").val(data.month_2w);
					
					
					$("#notes").val(data.notes);
					if(data.city_id!=0){
						$("#selcity").val(data.city_id);    
						
					}
					if(data.region_id!=0){
						$("#selregion").val(data.region_id);      
						
					}
					if(data.nearfull!=""){
						jQuery.each(data.nearfull,function(i,val) {
							document.getElementById("near"+val).checked=false
						})
					}
					if(data.nearrr!=""){
						jQuery.each(data.nearrr,function(i,val) {
							document.getElementById("near"+val).checked=true
						})
					}
					if(data.propertiesfull!=""){
						jQuery.each(data.propertiesfull,function(i,val) {
							document.getElementById("prop"+val).checked=false
						})
					}
					
					if(data.properties!=""){
						jQuery.each(data.properties,function(i,val) {
							document.getElementById("prop"+val).checked=true
						})
					}
					$("#address_ru").val(data.address_ru);
					initialize(data.lat,data.lng);
					geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
      					if (status == google.maps.GeocoderStatus.OK) {
        					if (results[0]) {
         						$("#address").val(data.address);
								$('#latitude').val(data.lat);
								$('#longitude').val(data.lng);
        						}
      						}
   					 });
					  
  //Добавляем слушателя события обратного геокодирования для маркера при его перемещении  
  google.maps.event.addListener(marker, 'drag', function() {
    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
          $('#address').val(results[0].formatted_address);
          $('#latitude').val(marker.getPosition().lat());
          $('#longitude').val(marker.getPosition().lng());
        }
      }
    });
  });
					
	showhide();
	$("#hidden").val(id); 
	$("#btn0").val("сохранить");
	$("#filelimit-fine-uploader").css("visibility", "visible");	
	$("#111").css("visibility", "visible");
	$("#messages").css("visibility", "visible");
	$("#edit").css("visibility", "visible");
	$("#seo").css("visibility", "visible");
	$( "#tabs" ).tabs( "enable" );
	$('#111').empty();
		fulltable();
		}
			});
	
}
<!--upload-->

function fulltable(){
	var ankap=(Math.random());
	$.ajax({ 
		  
		  type: "POST",
		  url: "ajaxcreate.php",
		  dataType: "json",
		
		 data: { 
			  	 upload:true,
				 id:$("#hidden").val()
				 },
		 
		success: function(data)
		  { 
		
		$('#111').empty();
		jQuery.each(data.files,function(i,val) {
	 if(val!==data.main){
     $('#111').append('<div id="'+i+'"><table class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+data.id+'/ready/low/'+ val + '?salt='+ankap+'" alt="' + val + '"/></td><td width="150px"><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+false+','+i+')">повернуть налево</a><br /><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+false+','+i+')">повернуть направо</a><br /><a href="javascript:void(0)" onClick="edit(\''+ val + '\','+false+','+i+')">миниатюра</a><br /><a href="javascript:void(0)" onClick="del(\''+ val + '\','+i+')" >удалить</a><br/><a href="javascript:void(0)" onClick="makemain(\''+ val + '\','+i+')" >сделать главной</a></td></tr></table><div>');  }
	 else {
		 $('#111').append('<div id="'+i+'"><table id="mainimage"  class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+data.id+'/ready/low/'+ val + '?salt='+ankap+'" alt="' + val + '" title="' + val + '"/></td><td width="150px"><a  class="mylink" href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+true+','+i+')">повернуть налево</a><br /><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+true+','+i+')">повернуть направо</a><br /><a class="mylink"  href="javascript:void(0)" onClick="edit(\''+ val + '\','+true+','+i+')">миниатюра</a><br /><h2 id="mainimage">Главная</h2></td></tr></table><div>');
	 }
     });
	
			}
			});
}
function cattable(cat,rus,eng){
	var cattable=cat+"table";
	var pager=cat+"pager";
	var cateng=cat+"_eng";
	jQuery("#"+cattable).jqGrid({
	url:'tablecat.php?cat='+cat,
	datatype: "json",
	editurl:'tableajax.php?cat='+cat,
	cellEdit : false,	
	height: 'auto',
	width: 600,
   	colNames:['id',rus,eng, 'обновлено' ,''],
   	colModel:[
   		{name:'id',index:'id', width:40, hidden: true},
		{name:cat,index:cat, width:100,editable:true,editrules:{required:true}},
		{name:cateng,index:cateng, width:100,editrules:{required:false},hidden: true},
		{name:'update',index:'update', width:100}, 
		
		{name: 'myname', sortable:false,search:false,resize:false,width:30, formatter:'actions',
			formatoptions:{
				  keys: true,
				  editformbutton: true,
                  editOptions: {
                       afterSubmit: function (server, postdata) {
							var response = eval('('+server.responseText+')'); 
          					success = false;
          					if(response.answerType == 'OK'){
                				success = true;
								$('#'+cattable).jqGrid("setGridParam", {datatype: 'json'}).trigger("reloadGrid");
								$(".ui-icon-closethick").trigger('click');
							};
								
							return [success,response.hidden]
                        }
                    },
					
					delOptions: {
						afterSubmit: function (server, postdata) {
							var response = eval('('+server.responseText+')'); 
          					success = false;
          					if(response.answerType == 'OK'){
                				success = true;
								
          						};
     						return [success,response.hidden]
                        }
					}
				}
			}			
   	],
   	rowNum:25,
	rowTotal: -1,
   	rowList:[25,50,75],
   	pager: '#'+pager,
   	sortname: 'id',
  	viewrecords: true,
	loadonce:true,
	ignoreCase: true,
   	mtype: "GET",
	rownumbers: true,
	gridview: true,	
    sortorder: "desc",
    caption:rus,	
	async: false,
	loadComplete: function() {
		 jQuery("#"+cattable).jqGrid('navGrid','#'+pager,{edit:false,add:false,del:false,search:false,refresh:true});
		 jQuery("#"+cattable).jqGrid('filterToolbar',{stringResult:true, searchOnEnter:true, defaultSearch:"cn"});	
		}
	});
};
function cattableprop(cat,rus,eng){
	var cattable=cat+"table";
	var pager=cat+"pager";
	var cateng=cat+"_eng";
	jQuery("#"+cattable).jqGrid({
	url:'tablecat.php?cat='+cat,
	datatype: "json",
	editurl:'tableajaxprop.php?cat='+cat,
	cellEdit : false,	
	height: 'auto',
	width: 600,
   	colNames:['id',rus,eng, 'обновлено' ,''],
   	colModel:[
   		{name:'id',index:'id', width:40, hidden: true},
		{name:cat,index:cat, width:100,editable:true,editrules:{required:true}},
		{name:cateng,index:cateng, width:100,editrules:{required:false},hidden: true},
		{name:'update',index:'update', width:100}, 
		
		{name: 'myname', sortable:false,search:false,resize:false,width:30, formatter:'actions',
			formatoptions:{
				  keys: true,
				  editformbutton: true,
                  editOptions: {
                       afterSubmit: function (server, postdata) {
							var response = eval('('+server.responseText+')'); 
          					success = false;
          					if(response.answerType == 'OK'){
                				success = true;
								$('#'+cattable).jqGrid("setGridParam", {datatype: 'json'}).trigger("reloadGrid");
								$(".ui-icon-closethick").trigger('click');
							};
								
							return [success,response.hidden]
                        }
                    },
					
					delOptions: {
						afterSubmit: function (server, postdata) {
							var response = eval('('+server.responseText+')'); 
          					success = false;
          					if(response.answerType == 'OK'){
                				success = true;
								
          						};
     						return [success,response.hidden]
                        }
					}
				}
			}			
   	],
   	rowNum:25,
	rowTotal: -1,
   	rowList:[25,50,75],
   	pager: '#'+pager,
   	sortname: 'id',
  	viewrecords: true,
	loadonce:true,
	ignoreCase: true,
   	mtype: "GET",
	rownumbers: true,
	gridview: true,	
    sortorder: "desc",
    caption:rus,	
	async: false,
	loadComplete: function() {
		 jQuery("#"+cattable).jqGrid('navGrid','#'+pager,{edit:false,add:false,del:false,search:false,refresh:true});
		 jQuery("#"+cattable).jqGrid('filterToolbar',{stringResult:true, searchOnEnter:true, defaultSearch:"cn"});	
		}
	});
};
function cattable1(cat,rus,eng,depend,rudepend){
	var cattable=cat+"table";
	var pager=cat+"pager";
	var cateng=cat+"_eng";
	var depend_id=depend+"_id";
	
getColumnIndexByName1 = function (grid, columnName) {
   var cm = grid.jqGrid('getGridParam', 'colModel'), i, l = cm.length;
      for (i = 0; i < l; i++) {
         if (cm[i].name === columnName) {
            return i; // return the index
         }
     }
  return -1;
},
getUniqueNames1 = function(columnName) {
        var texts = jQuery("#"+cattable).jqGrid('getCol',columnName),
		uniqueTexts = [],
        textsLength = texts.length,
		text, 
		textsMap = {}, i;
		for (i=0;i<textsLength;i++) {
            text = texts[i];
            if (text !== undefined && textsMap[text] === undefined) {
				textsMap[text] = true;
                uniqueTexts.push(text);
            }
        }
        return uniqueTexts;
    };
buildSearchSelect1 = function(uniqueNames) {
        var values=":All";
	    $.each (uniqueNames, function() {
        	values += ";" + this + ":" + this;
       });
       return values;
    };
setSearchSelect1 = function(columnName) {
       jQuery("#"+cattable).jqGrid('setColProp', columnName,
       {
           stype: 'select',
           searchoptions: {
              value:buildSearchSelect1(getUniqueNames1(columnName)),
              sopt:['eq']
	          }
	   }
    );
};

	jQuery("#"+cattable).jqGrid({
	url:'tablecat1.php?cat='+cat+'&depend='+depend,
	datatype: "json",
	editurl:'tableajax.php?cat='+cat,
	cellEdit : false,	
	height: 'auto',
	width: 700,
   	colNames:['id',rus,eng,rudepend, 'обновлено' ,''],
   	colModel:[
   		{name:'id',index:'id', width:40, hidden: true},
		{name:cat,index:cat, width:100,editable:true,editrules:{required:true}},
		{name:cateng,index:cateng, width:100,hidden: true,editrules:{required:false}},
		{name:depend,index:depend, width:100,editable:false},
		{name:'update',index:'update', width:100}, 
		
		{name: 'myname', sortable:false,search:false,resize:false,width:30, formatter:'actions',
			formatoptions:{
				  keys: true,
				  editformbutton: true,
                  editOptions: {
                       afterSubmit: function (server, postdata) {
							var response = eval('('+server.responseText+')'); 
          					success = false;
          					if(response.answerType == 'OK'){
                				success = true;
								$('#'+cattable).jqGrid("setGridParam", {datatype: 'json'}).trigger("reloadGrid");
								$(".ui-icon-closethick").trigger('click');
							};
								
							return [success,response.hidden]
                        }
                    },
					
					delOptions: {
						afterSubmit: function (server, postdata) {
							var response = eval('('+server.responseText+')'); 
          					success = false;
          					if(response.answerType == 'OK'){
                				success = true;
          						};
     						return [success,response.hidden]
                        }
					}
				}
			}			
   	],
   	rowNum:25,
	rowTotal: -1,
   	rowList:[25,50,75],
   	pager: '#'+pager,
   	sortname: 'id',
  	viewrecords: true,
	loadonce:true,
	ignoreCase: true,
   	mtype: "GET",
	rownumbers: true,
	gridview: true,	
    sortorder: "desc",
    caption:rus,	
	async: false,
	loadComplete: function() {
		setSearchSelect1(depend);
		 jQuery("#"+cattable).jqGrid('navGrid','#'+pager,{edit:false,add:false,del:false,search:false,refresh:true});
		 jQuery("#"+cattable).jqGrid('filterToolbar',{stringResult:true, searchOnEnter:true, defaultSearch:"cn"});	
		}
	});
};
function cattable2(cat,rus,eng,depend,rudepend,depend2,rudepend2,nodepend,runodepend){
	var cattable=cat+"table";
	var pager=cat+"pager";
	var cateng=cat+"_eng";
	var depend_id=depend+"_id";
	var depend2_id=depend2+"_id";
	var nodepend_id=nodepend+"_id";
getColumnIndexByName1 = function (grid, columnName) {
   var cm = grid.jqGrid('getGridParam', 'colModel'), i, l = cm.length;
      for (i = 0; i < l; i++) {
         if (cm[i].name === columnName) {
            return i; // return the index
         }
     }
  return -1;
},
getUniqueNames1 = function(columnName) {
        var texts = jQuery("#"+cattable).jqGrid('getCol',columnName),
		uniqueTexts = [],
        textsLength = texts.length,
		text, 
		textsMap = {}, i;
		for (i=0;i<textsLength;i++) {
            text = texts[i];
            if (text !== undefined && textsMap[text] === undefined) {
				textsMap[text] = true;
                uniqueTexts.push(text);
            }
        }
        return uniqueTexts;
    };
buildSearchSelect1 = function(uniqueNames) {
        var values=":All";
	    $.each (uniqueNames, function() {
        	values += ";" + this + ":" + this;
       });
       return values;
    };
setSearchSelect1 = function(columnName) {
       jQuery("#"+cattable).jqGrid('setColProp', columnName,
       {
           stype: 'select',
           searchoptions: {
              value:buildSearchSelect1(getUniqueNames1(columnName)),
              sopt:['eq']
	          }
	   }
    );
};

	jQuery("#"+cattable).jqGrid({
	url:'tablecat2.php?cat='+cat+'&depend='+depend+'&depend2='+depend2+'&nodepend='+nodepend,
	datatype: "json",
	editurl:'tableajax.php?cat='+cat,
	cellEdit : false,	
	height: 'auto',
	width: 1000,
   	colNames:['id',rus,eng,rudepend,rudepend2,runodepend, 'обновлено' ,''],
   	colModel:[
   		{name:'id',index:'id', width:40, hidden: true},
		{name:cat,index:cat, width:50,editable:true,editrules:{required:true}},
		{name:cateng,index:cateng, width:50,editable:true,editrules:{required:false}},
		{name:depend,index:depend, width:80,editable:false},
		{name:depend2,index:depend2, width:80,editable:false},
		{name:nodepend,index:nodepend, width:80,editable:false},
		{name:'update',index:'update', width:80}, 
		
		{name: 'myname', sortable:false,search:false,resize:false,width:30, formatter:'actions',
			formatoptions:{
				  keys: true,
				  editformbutton: true,
                  editOptions: {
                       afterSubmit: function (server, postdata) {
							var response = eval('('+server.responseText+')'); 
          					success = false;
          					if(response.answerType == 'OK'){
                				success = true;
								$('#'+cattable).jqGrid("setGridParam", {datatype: 'json'}).trigger("reloadGrid");
								$(".ui-icon-closethick").trigger('click');
							};
								
							return [success,response.hidden]
                        }
                    },
					
					delOptions: {
						afterSubmit: function (server, postdata) {
							var response = eval('('+server.responseText+')'); 
          					success = false;
          					if(response.answerType == 'OK'){
                				success = true;
          						};
     						return [success,response.hidden]
                        }
					}
				}
			}			
   	],
   	rowNum:25,
	rowTotal: -1,
   	rowList:[25,50,75],
   	pager: '#'+pager,
   	sortname: 'id',
  	viewrecords: true,
	loadonce:true,
	ignoreCase: true,
   	mtype: "GET",
	rownumbers: true,
	gridview: true,	
    sortorder: "desc",
    caption:rus,	
	async: false,
	loadComplete: function() {
		setSearchSelect1(depend);
		setSearchSelect1(depend2);
		setSearchSelect1(nodepend);
		 jQuery("#"+cattable).jqGrid('navGrid','#'+pager,{edit:false,add:false,del:false,search:false,refresh:true});
		 jQuery("#"+cattable).jqGrid('filterToolbar',{stringResult:true, searchOnEnter:true, defaultSearch:"cn"});	
		}
	});
};
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
    draggable: true
  });
}
