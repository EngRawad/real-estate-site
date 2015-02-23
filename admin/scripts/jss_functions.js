// JavaScript Document

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
			$("#country").html(data.country);
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
		})
	}

<!--cancel-->
function cancel(){
	var ankap=(Math.random());
	var val = $('#name').val();
	var i = $('#ident').val();
	var id=$("#hidden").val();
	var main=$("#main").val();
	$('#img-' + i).imgAreaSelect({remove: true });
	 if(main=='false'){
     $('#'+i+'').html('<table class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+id+'/ready/'+ val + '?salt='+ankap+'" alt="' + val + '"/></td><td width="150px"><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+false+','+i+')">повернуть налево</a><br /><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+false+','+i+')">повернуть направо</a><br /><a href="javascript:void(0)" onClick="edit(\''+ val + '\','+false+','+i+')">миниатюра</a><br /><a href="javascript:void(0)" onClick="del(\''+ val + '\','+i+')" >удалить</a><br/><a href="javascript:void(0)" onClick="makemain(\''+ val + '\','+i+')" >сделать главной</a></td></tr></table>');  }
	 else {
		 $('#'+i+'').html('<table id="mainimage" class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+id+'/ready/'+ val + '?salt='+ankap+'" alt="' + val + '" title="' + val + '"/></td><td width="150px"><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+true+','+i+')">повернуть налево</a><br /><a class="mylink" href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+true+','+i+')">повернуть направо</a><br /><a class="mylink" href="javascript:void(0)" onClick="edit(\''+ val + '\','+true+','+i+')">миниатюра</a><br /><h2 id="mainimage">Главная</h2></td></tr></table>');
	 }
}		

<!--crop-->
function crop(){
	var ankap=(Math.random());
	if(!$('#x2').val()) alert('выделите область');
	else{
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		var val = $('#name').val();
		var i = $('#ident').val();
		var main=$("#main").val();
		var id=$("#hidden").val();
		
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
				 id:$("#hidden").val() 
				},
		success: function(data)
		  {
		 if(main=='false'){
     $('#'+i+'').html('<table class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+id+'/ready/'+ val + '?salt='+ankap+'" alt="' + val + '"/></td><td width="150px"><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+false+','+i+')">повернуть налево</a><br /><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+false+','+i+')">повернуть направо</a><br /><a href="javascript:void(0)" onClick="edit(\''+ val + '\','+false+','+i+')">миниатюра</a><br /><a href="javascript:void(0)" onClick="del(\''+ val + '\','+i+')" >удалить</a><br/><a href="javascript:void(0)" onClick="makemain(\''+ val + '\','+i+')" >сделать главной</a></td></tr></table>');  }
	 else {
		 $('#'+i+'').html('<table id="mainimage" class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+id+'/ready/'+ val + '?salt='+ankap+'" alt="' + val + '" title="' + val + '"/></td><td width="150px"><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+true+','+i+')">повернуть налево</a><br /><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+true+','+i+')">повернуть направо</a><br /><a class="mylink" href="javascript:void(0)" onClick="edit(\''+ val + '\','+true+','+i+')">миниатюра</a><br /><h2 id="mainimage">Главная</h2></td></tr></table>');
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
     $('#'+i+'').html('<table class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+id+'/ready/'+ val + '?salt='+ankap+'" alt="' + val + '"/></td><td width="150px"><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+false+','+i+')">повернуть налево</a><br /><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+false+','+i+')">повернуть направо</a><br /><a href="javascript:void(0)" onClick="edit(\''+ val + '\','+false+','+i+')">миниатюра</a><br /><a href="javascript:void(0)" onClick="del(\''+ val + '\','+i+')" >удалить</a><br/><a href="javascript:void(0)" onClick="makemain(\''+ val + '\','+i+')" >сделать главной</a></td></tr></table>');  }
	 else {
		 $('#'+i+'').html('<table id="mainimage" class="table table-striped table-bordered  table-condensed"><tr><td><img  width="200px" src="uploads/'+id+'/ready/'+ val + '?salt='+ankap+'" alt="' + val + '" title="' + val + '"/></td><td width="150px"><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+true+','+i+')">повернуть налево</a><br /><a class="mylink" href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+true+','+i+')">повернуть направо</a><br /><a class="mylink"  href="javascript:void(0)" onClick="edit(\''+ val + '\','+true+','+i+')">миниатюра</a><br /><h2 id="mainimage">Главная</h2></td></tr></table>');
	 }
 	}
	})
}

<!--edit-->
function edit(val,main,i){
	var ankap=(Math.random());
	var id=$("#hidden").val();
		$('#'+i+'').html('<br/><div class="btn-group"><input type="hidden" name="x1" value="" id="x1"/><input type="hidden" name="main" value="" id="main"/><input type="hidden" name="y1" value="" id="y1"/><input type="hidden" name="x2" value="" id="x2"/><input type="hidden" name="y2" value="" id="y2"/><input type="hidden" name="w" value="" id="w"/><input type="hidden" name="h" value="" id="h"/><input type="hidden" name="name" value="" id="name"/><input type="hidden" name="ident" value="" id="ident"/><button class="btn" onclick="crop()">обрезать</button><button class="btn" onclick="cancel()">отменить</button></div><br/><img id="img-'+i+'"  onload="imgselect(\''+i+'\')" src="uploads/'+id+'/' + val + '?a='+ankap+'" alt="' + val + '">');

$('#img-' + i).imgAreaSelect({aspectRatio: "4:3", handles: true, onSelectEnd: function (img, selection) {
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
	        } });
	
$('#ident').val(i);	
$('#name').val(val);
$('#main').val(main);
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
     $('#111').append('<div id="'+i+'"><table class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+data.id+'/ready/'+ val + '?a='+ankap+'" alt="' + val + '?a='+ankap+'"></td><td width="150px"><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+false+','+i+')">повернуть налево</a><br /><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+false+','+i+')">повернуть направо</a><br /><a href="javascript:void(0)" onClick="edit(\''+ val + '\','+false+','+i+')">миниатюра</a><br /><a href="javascript:void(0)" onClick="del(\''+ val + '\','+i+')" >удалить</a><br/><a href="javascript:void(0)" onClick="makemain(\''+ val + '\','+i+')" >сделать главной</a></td></tr></table><div>');  }
	 else {
		 $('#111').append('<div id="'+i+'"><table id="mainimage" class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+data.id+'/ready/'+ val + '?a='+ankap+'" alt="' + val + '" title="' + val + '"></td><td width="150px"><a class="mylink" href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+true+','+i+')">повернуть налево</a><br /><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+true+','+i+')">повернуть направо</a><br /><a class="mylink"  href="javascript:void(0)" onClick="edit(\''+ val + '\','+true+','+i+')">миниатюра</a><br /><h2 id="mainimage">Главная</h2></td></tr></table><div>');
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
	$("#title_ru").val(data.title_ru);
	$("#title_eng").val(data.title_eng);
	$("#sozdano").val(data.date_created);
	$("#upd").val(data.date_updated);
	$("#selactive").val(data.active);
	
	
	$("#hidtitle_ru").val(data.title_ru);	
	$("#hidtitle_eng").val(data.title_eng);				
	$("#hiddataupd").val(data.date_updated);
	$("#hiddatacrt").val(data.date_created);
	$("#hidselactive").val(data.active);
	
	$("#hidden").val(id);
	$("#btn0").val("изменить");	
	$("#filelimit-fine-uploader").css("visibility", "visible");	
	$("#111").css("visibility", "visible");
	$("#messages").css("visibility", "visible");
	$("#edit").css("visibility", "visible");
	$("#seo").css("visibility", "visible");
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
		  url: "ajaxcreateid.php",
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
     $('#111').append('<div id="'+i+'"><table class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+data.id+'/ready/'+ val + '?salt='+ankap+'" alt="' + val + '"/></td><td width="150px"><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+false+','+i+')">повернуть налево</a><br /><a href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+false+','+i+')">повернуть направо</a><br /><a href="javascript:void(0)" onClick="edit(\''+ val + '\','+false+','+i+')">миниатюра</a><br /><a href="javascript:void(0)" onClick="del(\''+ val + '\','+i+')" >удалить</a><br/><a href="javascript:void(0)" onClick="makemain(\''+ val + '\','+i+')" >сделать главной</a></td></tr></table><div>');  }
	 else {
		 $('#111').append('<div id="'+i+'"><table id="mainimage"  class="table table-striped table-bordered  table-condensed"><tr><td><img width="200px" src="uploads/'+data.id+'/ready/'+ val + '?salt='+ankap+'" alt="' + val + '" title="' + val + '"/></td><td width="150px"><a  class="mylink" href="javascript:void(0)" onClick="rot(\''+ val + '\',\'left\','+true+','+i+')">повернуть налево</a><br /><a class="mylink"  href="javascript:void(0)" onClick="rot(\''+ val + '\',\'rigth\','+true+','+i+')">повернуть направо</a><br /><a class="mylink"  href="javascript:void(0)" onClick="edit(\''+ val + '\','+true+','+i+')">миниатюра</a><br /><h2 id="mainimage">Главная</h2></td></tr></table><div>');
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
		{name:cateng,index:cateng, width:100,editable:true,editrules:{required:false}},
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
		{name:cateng,index:cateng, width:100,editable:true,editrules:{required:false}},
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
function initialize(){
//Определение карты
  var latlng = new google.maps.LatLng(55.749646,37.623680000000036);
  var options = {
    zoom: 15,
    center: latlng,
	scrollwheel: false,
    mapTypeId: google.maps.MapTypeId.SATELLITE
  };
 map = new google.maps.Map(document.getElementById("map_canvas"), options);
   //Определение геокодера
  geocoder = new google.maps.Geocoder();
  marker = new google.maps.Marker({
	map: map,
    draggable: true
  });
}
