<?
session_start(); 

require_once("include/membersite_config.php");

if(!$fgmembersite->CheckLogin()) 
{
    $fgmembersite->RedirectToURL("login.php"); 
    exit;
}

require_once("baza.php");
require_once("include/php_functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>панель администратора</title>

<link rel="stylesheet"	type="text/css"	media="screen"	href="style/karen.css" />
<link rel="stylesheet"	type="text/css" media="screen"	href="style/fg_membersite.css" />
<link rel="stylesheet"	type="text/css" media="screen"	href="style/pwdwidget.css" />
<link rel="stylesheet"	type="text/css"	media="screen"	href="style/fineuploader.css" />

<link rel="stylesheet" type="text/css" media="screen" 	href="css/overcast/jquery-ui-1.10.3.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" 	href="css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen"	href="css/jquery.arcticmodal-0.3.css" />
<link rel="stylesheet" type="text/css" media="screen"	href="style/css/imgareaselect-default.css" />


<script type="text/javascript"	src="scripts/jquery-1.9.1.min.js"></script>
<script type="text/javascript"	src="scripts/gen_validatorv4.js" ></script>
<script type="text/javascript"	src="scripts/pwdwidget.js"></script>
<script type="text/javascript"	src="scripts/jquery.form.js"></script>
<script type="text/javascript"	src="scripts/jquery.fineuploader-3.3.1.js" ></script>
<script type="text/javascript"	src="scripts/i18n/grid.locale-ru.js" ></script>
<script type="text/javascript"	src="scripts/jquery.jqGrid.min.js" ></script>
<script type="text/javascript"	src="scripts/jquery.arcticmodal-0.3.min.js" ></script>
<script type="text/javascript" 	src="scripts/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript"	src="ckeditor/ckeditor.js"></script>
<script type="text/javascript"	src="ckeditor/adapters/jquery.js"></script>
<script type="text/javascript"	src="scripts/jquery-ui-1.10.2.custom.min.js"></script>
<script type="text/javascript"	src="scripts/js_functions.js"></script>
<script type="text/javascript" 	src="http://maps.google.com/maps/api/js?sensor=false&language=ru"></script>

<!--edit_news-->

<script type="application/javascript">
   $(document).ready(function(){
function ab_afterShowForm(ids){ 
	if( CKEDITOR.instances.story )
    {
		try {
         	CKEDITOR.instances.story.destroy(true);
        } catch(e) {
            CKEDITOR.remove( 'story' );
        }
    }
    CKEDITOR.replace( 'story',{height: 300,});
    selID = $('#catdnd').getGridParam('selrow'); // get selected row
    if( !($('a#pData').is(':hidden') || $('a#nData').is(':hidden') && selID==null))
    { 
        va = $('#catdnd').getRowData(selID);
        CKEDITOR.instances.story.setData( va['story'] );
    }
};
function ab_beforeSubmit(data)
{
    data['story'] = CKEDITOR.instances.story.getData();
	try {
         	CKEDITOR.instances.story.destroy(true);
        } catch(e) {
            CKEDITOR.remove( 'story' );
        }
	return [true];
};
function ab_afterclickPgButtons(whichbutton, formid, rowid)
{
    va = $('#catdnd').getRowData(rowid);
	CKEDITOR.instances.story.setData( va['story'] );
};


<!--edit_news java-->

getColumnIndexByName = function (grid, columnName) {
   var cm = grid.jqGrid('getGridParam', 'colModel'), i, l = cm.length;
      for (i = 0; i < l; i++) {
         if (cm[i].name === columnName) {
            return i; // return the index
         }
     }
  return -1;
},
jQuery("#custbut").jqGrid({        
   	url:'edit_news_ajax.php?q=2', 
	datatype: "json", 
	editurl:'ajaxnovosti.php?q=2',
	height: 'auto',
	width: 1200,
	rowheight: 30,
	colNames:['','','Статус','Название статьи ','Статья','','заметка','создано', 'обновлено','date'],
   	colModel:[
		{name:'edit',hidden: true,index:'edit', sortable:false,editable: true,search:false,resize:false},	
		{name: 'myname',width:70, sortable:false,search:false,resize:false, formatter:'actions', formatoptions:{
						keys: true,					  
				        editformbutton: true,
						editOptions: {
							height:731, width:850,
							afterSubmit: function (server, postdata) {
								$("#custbut").jqGrid("setGridParam", {datatype: 'json'}).trigger("reloadGrid");
								$(".ui-icon-closethick").trigger('click');
								return [success,response.hidden]
                        	},
							afterShowForm: ab_afterShowForm,
							afterclickPgButtons: ab_afterclickPgButtons,
        					beforeSubmit: ab_beforeSubmit,
							onClose:function () {
								try {
         							CKEDITOR.instances.story.destroy(true);
        						} 
								catch(e) {
            						CKEDITOR.remove( 'story' );
        						}
							}
       			        },
						delOptions: {
							afterSubmit: function (server, postdata) {
								$("#custbut").jqGrid("setGridParam", {datatype: 'json'}).trigger("reloadGrid");
								$(".ui-icon-closethick").trigger('click');
     							return [success,response.hidden]
                       			}
						}
			}
		},
		
   		
		{name:'active',index:'active',width:110,editable:true,editrules:{required:true},edittype:"select",
		editoptions:{value:"Активно:Активно;Неактивно:Неактивно"}},
		{name:'story_name',index:'story_name', width:150,editable:true,editrules:{required:true},editoptions:{size:121}},
		{name:'story_sthtml',index:'story_sthtml',edittype:"textarea", width:150,hidden: true },
   		{name:'story',index:'story', width:150,hidden: true,width:150,editable:true,edittype:"textarea",editrules:{edithidden:true}},
		{name:'description',index:'description', width:150, editable:true,edittype:"textarea",
            editoptions:{rows:"2",cols:"120"}},
		{name:'date_created',index:'date_created', width:110},
   		{name:'date_updated',index:'date_updated', width:110},
		{name:'datepicker',index:'datepicker', width:70,editrules:{required:true},editable:true,
			editoptions:{
				size:12,
				dataInit:function(el){
					$(el).datepicker({dateFormat:'yy-mm-dd'});
					$.datepicker.setDefaults( $.datepicker.regional[''] = { // Default regional settings
		clearText: 'Очистить', // Display text for clear link
		clearStatus: 'Стереть текущую дату', // Status text for clear link
		closeText: 'Закрыть', // Display text for close link
		closeStatus: 'Закрыть без сохранения', // Status text for close link
		prevText: '&#x3c;Пред', // Display text for previous month link
		prevStatus: 'Предыдущий месяц', // Status text for previous month link
		nextText: 'След&#x3e;', // Display text for next month link
		nextStatus: 'Следующий месяц', // Status text for next month link
		currentText: 'Сегодня', // Display text for current month link
		currentStatus: 'Текущий месяц', // Status text for current month link
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
			'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], // Names of months for drop-down and formatting
		monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'], // For formatting
		monthStatus: 'Показать другой месяц', // Status text for selecting a month
		yearStatus: 'Показать другой год', // Status text for selecting a year
		weekHeader: 'Нед', // Header for the week of the year column
		weekStatus: 'Неделя года', // Status text for the week of the year column
		dayNames: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'], // For formatting
		dayNamesShort: ['Вск', 'Пнд', 'Втр', 'Срд', 'Чтв', 'Птн', 'Сбт'], // For formatting
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'], // Column headings for days starting at Sunday
		dayStatus: 'Установить первым днем недели', // Status text for the day of the week selection
		dateStatus: 'Выбрать день, месяц, год', // Status text for the date selection
		dateFormat: 'dd.mm.yy', // See format options on parseDate
		firstDay: 1, // The first day of the week, Sun = 0, Mon = 1, ...
		initStatus: 'Выбрать дату', // Initial Status text on opening
		isRTL: false // True if right-to-left language, false if left-to-right
	} );
					},
				defaultValue: function(){
					var currentTime = new Date();
					var month = parseInt(currentTime.getMonth() + 1);
					month = month <= 9 ? "0"+month : month;
					var day = currentTime.getDate();
					day = day <= 9 ? "0"+day : day;
					var year = currentTime.getFullYear();
					return year+"-"+month + "-"+day;
				}
			}
			},
	
	],
   	rowNum:20,
	rowTotal: -1,
   	rowList:[20,40,60],
   	pager: '#pcustbut',
   	sortname: 'id',
	viewrecords: true,
	loadonce:true,
	ignoreCase: true,
	mtype: "GET",
	rownumbers: true,
	gridview: true,
	sortorder: "desc",
 	caption:"Статья",
	async: false,
	loadComplete: function() {
	 	setSearchSelect1('active');
	 	setSearchSelect1('id');
	 	jQuery("#custbut").jqGrid('navGrid','#pcustbut',{edit:false,add:true,del:false,search:false,refresh:true},
		{},
		{
			height:731, width:850,
		  	afterSubmit: function (server, postdata) {
				$("#custbut").jqGrid("setGridParam", {datatype: 'json'}).trigger("reloadGrid");
				$(".ui-icon-closethick").trigger('click');
				return [success,response.hidden]
           	},
			afterShowForm: ab_afterShowForm,
       		beforeSubmit: ab_beforeSubmit,
			onClose:function () {
				try {
         			CKEDITOR.instances.story.destroy(true);
        		} catch(e) {
            		CKEDITOR.remove( 'story' );
        		}
			}
        }, 
		{}
	 );
	jQuery("#custbut").jqGrid('filterToolbar',{stringResult:true, searchOnEnter:true, defaultSearch:"cn"});
	jQuery ("table.ui-jqgrid-htable", jQuery("#custbut")).css ("height", 30);	
	var iCol = getColumnIndexByName($("#custbut"), 'myname');
    $(this).find(">tbody>tr.jqgrow>td:nth-child(" + (iCol + 1) + ")")
        .each(function() {
            $("<div>", {
                title: "Вид выбранной записи",
                mouseover: function() {
                    $(this).addClass('ui-state-hover');
                },
                mouseout: function() {
                    $(this).removeClass('ui-state-hover');
                },
                click: function(e) {
					window.location.href="/services.php?id="+
                        $(e.target).closest("tr.jqgrow").attr("id");
                }
            }
          ).css({"margin-right": "5px", float: "left", cursor: "pointer"})
           .addClass("ui-pg-div ui-inline-custom")
           .append('<span class="ui-icon ui-icon-document"></span>')
           .prependTo($(this).children("div"));
    });
		}
	
});
getUniqueNames1 = function(columnName) {
        var texts = jQuery("#custbut").jqGrid('getCol',columnName),
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
    },
buildSearchSelect1 = function(uniqueNames) {
        var values=":All";
	    $.each (uniqueNames, function() {
        	values += ";" + this + ":" + this;
       });
       return values;
    },
setSearchSelect1 = function(columnName) {
       jQuery("#custbut").jqGrid('setColProp', columnName,
       {
           stype: 'select',
           searchoptions: {
              value:buildSearchSelect1(getUniqueNames1(columnName)),
              sopt:['eq']
	          }
	   }
    );
};

});
</script>
<!--maintable-->
<script type="application/javascript">
   $(document).ready(function(){
	            getColumnIndexByName = function (grid, columnName) {
                var cm = grid.jqGrid('getGridParam', 'colModel'), i, l = cm.length;
                for (i = 0; i < l; i++) {
                    if (cm[i].name === columnName) {
                        return i; // return the index
                    }
                }
                return -1;
            },

jQuery("#list2").jqGrid({
	url:'table.php?q=2',
	datatype: "json", 
	height: 'auto',
	editurl:'mainajax.php?q=2',
	width: 1200,
   	colNames:['','','Лот','Тип сделки','Статус','Специальное предложение','Заметки','Категория', 'Тип недвижимости','Регион','Город','Цена €','Описание','Спальни','Ванны','Площадь дома','Год постройки','Создано', 'Обновлено'],
   	colModel:[
		{name:'edit',hidden: true,index:'edit', sortable:false,editable: true,search:false,resize:false},
   		{name: 'myname',width:110, sortable:false,search:false,resize:false, formatter:'actions',
			formatoptions:{
						onEdit:function(rowid){window.location.search="?pan=nn&id="+rowid;},	
						delOptions: {
							afterSubmit: function (server, postdata) {
								var response = eval('('+server.responseText+')'); 
          						success = false;
          						if(response.answerType == 'OK')success = true;
                				return [success,response.hidden]
                       		 }
						}
					}
				},
		{name:'artikul',index:'artikul', width:50},		
		{name:'deal',index:'deal',width:80},
		{name:'status',index:'status',width:80},
		{name:'is_special_offer',index:'is_special_offer',width:80},
		{name:'notes',index:'notes', width:100},
		{name:'category',index:'category', width:100},
		{name:'objtype',index:'objtype', width:100},
		{name:'region',index:'region', width:100},
		{name:'city',index:'city', width:100},		
   		{name:'price',index:'price',sorttype:'number', width:50},		
   		{name:'description_ru',index:'description_ru', width:150},
		{name:'num_of_rooms',index:'num_of_rooms',sorttype:'number', width:50},
		{name:'num_of_bath',index:'num_of_bath',sorttype:'number', width:50},
		{name:'squarehouse',index:'squarehouse',sorttype:'number', width:50},
		{name:'year_built',index:'year_built',sorttype:'number', width:50},
		{name:'date_created',index:'date_created', width:80},
   		{name:'date_updated',index:'date_updated', width:80}
	
   	],
   	rowNum:25,
	rowTotal: -1,
   	rowList:[25,50,100,150],
   	pager: '#pager2',
   	sortname: 'id',
    viewrecords: true,
	loadonce:true,
	ignoreCase: true,
   	mtype: "GET",
	rownumbers: true,
	gridview: true,	
    sortorder: "desc",
    caption:"Изделия",
	async: false,
	
    loadComplete: function() {
		
		setSearchSelect('status');
		setSearchSelect('deal');
		setSearchSelect('category');
		setSearchSelect('objtype');
		setSearchSelect('region');
		setSearchSelect('city');
		setSearchSelect('is_special_offer');
		jQuery("#list2").jqGrid('filterToolbar',{stringResult:true, searchOnEnter:true, defaultSearch:"cn"});
		var iCol = getColumnIndexByName($("#list2"), 'myname');
    $(this).find(">tbody>tr.jqgrow>td:nth-child(" + (iCol + 1) + ")")
        .each(function() {
            $("<div>", {
                title: "Вид выбранной записи",
                mouseover: function() {
                    $(this).addClass('ui-state-hover');
                },
                mouseout: function() {
                    $(this).removeClass('ui-state-hover');
                },
                click: function(e) {
					window.location.href="/lot.php?id="+
                        $(e.target).closest("tr.jqgrow").attr("id");
				}
            }
          ).css({"margin-right": "5px", float: "left", cursor: "pointer"})
           .addClass("ui-pg-div ui-inline-custom")
           .append('<span class="ui-icon ui-icon-document"></span>')
           .prependTo($(this).children("div"));
    });
		}
	
});


jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false,search:false,refresh:true});


getUniqueNames = function(columnName) {

         var texts = jQuery("#list2").jqGrid('getCol',columnName),
		 uniqueTexts = [],
         textsLength = texts.length,
		 text, 
		 textsMap = {}, i;
		
         for (i=0;i<textsLength;i++) {
            text = texts[i];
			
            if (text !== undefined && texts[i] !== "" && texts[i] !== null && textsMap[text] === undefined ) {
                // to test whether the texts is unique we place it in the map.
                textsMap[text] = true;
                uniqueTexts.push(text);
            }
        }
        return uniqueTexts;
    },
    buildSearchSelect = function(uniqueNames) {
        var values=":All";
        $.each (uniqueNames, function() {
            values += ";" + this + ":" + this;
        });
        return values;
    },
    setSearchSelect = function(columnName) {
        jQuery("#list2").jqGrid('setColProp', columnName,
                    {
                        stype: 'select',
                        searchoptions: {
							
                            value:buildSearchSelect(getUniqueNames(columnName)),
                            sopt:['eq']
							
                        }
                    }
        );
    };
   })
</script>
 <script>
<!--create record-->
		$('#aptform').ajaxForm(
		{ 
			dataType: "json",
			success: function(data)
			{ 
			if(data.uveren){
				$("#uveren").val(data.uveren);
				if(confirm("Вы уверены?")){
					 $("#aptform").submit();
					 $("#anun").html("");
					 $("#uveren").val("");
					 } 
				 else {
					 $("#uveren").val("");
					 edititem(data.id);
					} 
			}
			else{
				if($("#hidden").val()) {
					$("#anun").html("<h2 style='color:#F00'>Объявление успешно изменено</h2>");
				}
				else {
					$("#anun").html("<h2 style='color:#F00'>Объявление успешно добавлено</h2>");
					$('#address_ru').val($('#address').val());
				}
				
				if(data.id){
					$("#hidden").val(data.id);
					$("#btn0").val("сохранить");
					$("#update").css("visibility", "visible");
					$("#title").val(data.artikul);
					$("#sozdano").val(data.date_created);
					$("#upd").val(data.date_updated);
					$( "#tabs" ).tabs( "enable" );
					$("#title_ru").val(data.title_ru);
					$("#seo_description_ru").val(data.seo_description_ru);
					$("#seo_keywords_ru").val(data.seo_keywords_ru);
				}
			}
			}
	}); 
 

 <!--upload-->
	fulltable(); 			  
		
    $fub = $('#fine-uploader');
    $messages = $('#messages');
	
 	
	
    var uploader = new qq.FineUploader({
      element: $('#filelimit-fine-uploader')[0],
      request: {
        endpoint: 'uploaderserv.php'
      },
      validation: {
        allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
        sizeLimit: 5120000, // 500 kB = 500 * 1024 bytes
        //itemLimit: numfile
      },
      callbacks: {
        onSubmit: function(id, fileName) {
          $messages.append('<div id="file-' + id + '" class="alert" style="margin: 20px 0 0"></div>');
        },
        onUpload: function(id, fileName) {
          $('#file-' + id).addClass('alert-info')
                          .html('<img src="images/ajax-loader.gif" alt="Initializing. Please hold."> ' +
                                'Initializing ' +
                                '“' + fileName + '”');
        },
        onProgress: function(id, fileName, loaded, total) {
          if (loaded < total) {
            progress = Math.round(loaded / total * 100) + '% of ' + Math.round(total / 1024) + ' kB';
            $('#file-' + id).removeClass('alert-info')
                            .html('<img src="images/ajax-loader.gif" alt="In progress. Please hold."> ' +
                                  'Uploading ' +
                                  '“' + fileName + '” ' +
                                  progress);
          } else {
            $('#file-' + id).addClass('alert-info')
                            .html('<img src="images/ajax-loader.gif" alt="Saving. Please hold."> ' +
                                  'Saving ' +
                                  '“' + fileName + '”');
          }
        },
        onComplete: function(id, fileName, responseJSON) {	
          if (responseJSON.success) {
				
           $('#file-' + id).remove();
		fulltable();
		
								
			
					  
          } else {
            $('#file-' + id).removeClass('alert-info') 
                            .addClass('alert-error')
                            .html('<i class="icon-exclamation-sign"></i> ' +
                                  'Error with ' +
                                  '“' + fileName + '”: ' +
                                  responseJSON.error);
          }
        }
      }
    
 });

</script>  
<script type="text/javascript">

$(document).ready(function(){
	
	$("#deal").change(showhide);
	$("#selcity").change(runcity);$("#selregion").change(runregion);
	
	$( 'textarea#editor1' ).ckeditor();
	$( 'textarea#editor2' ).ckeditor();
	$( 'textarea#editor3' ).ckeditor();
	$( 'textarea#editnews' ).ckeditor();

	$('#error3').arcticmodal();
	$('#error4').arcticmodal();
	$('#error5').arcticmodal();
	$('#error6').arcticmodal(); 
	
	$("#tabs").tabs({ disabled: [1,2,3 ] });
	$("#tabb").tabs();
	$("#tabbb").tabs();
	$("#tabbbb").tabs();
	
 
$('#price').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});

$('#year_built').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});
$('#distsea').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});
$('#distair').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});
$('#distcity').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});

$('#floor').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});
 
$('#floors').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
}); 

$('#squarehouse').bind("change keyup input click", function() {
	
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
}); 
$('#squarearea').bind("change keyup input click", function() {
	
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
}); 
$('#squareterrace').bind("change keyup input click", function() {
	
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});      
$('#num_of_rooms').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});
$('#num_of_bath').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});
$('#condominimum').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});
$('#squarsun').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});
$('#infrastructure').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});

$('.numint').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});
$('.numphone').bind("change keyup input click", function() {
    if (this.value.match(/[^0-9\-+\(\)]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});
});
</script>
</head>  
<body>
<?
mysql_query("CREATE TABLE IF NOT EXISTS `price_lend` (
	`id` INT(11)NOT NULL AUTO_INCREMENT,
	`item_id` int(11) NOT NULL DEFAULT '0',
	`May_1m` int(11) NOT NULL DEFAULT '0',
	`May_1w` int(11) NOT NULL DEFAULT '0',
	`May_2w` int(11) NOT NULL DEFAULT '0',
	`June_1m` int(11) NOT NULL DEFAULT '0',
	`June_1w` int(11) NOT NULL DEFAULT '0',
	`June_2w` int(11) NOT NULL DEFAULT '0',
	`August_1m` int(11) NOT NULL DEFAULT '0',
	`August_1w` int(11) NOT NULL DEFAULT '0',
	`August_2w` int(11) NOT NULL DEFAULT '0',
	`month_1m` int(11) NOT NULL DEFAULT '0', 
	`month_1w` int(11) NOT NULL DEFAULT '0',
	`month_2w` int(11) NOT NULL DEFAULT '0',
 KEY `id` (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `seo` (`id` INT(11)NOT NULL AUTO_INCREMENT, `update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, `title` TEXT NOT NULL COLLATE utf8_general_ci, `description` TEXT NOT NULL COLLATE utf8_general_ci, `keywords` TEXT NOT NULL COLLATE utf8_general_ci, `page` TEXT NOT NULL COLLATE utf8_general_ci, KEY `id` (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12") or die(mysql_error());
mysql_query ("CREATE TABLE IF NOT EXISTS `main`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artikul` text NOT NULL,
  `deal` varchar(255) NOT NULL,
  `objtype_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `price_ot` varchar(255) NOT NULL,
  `num_of_rooms` tinyint(4) NOT NULL DEFAULT '0',
  `num_of_bath` tinyint(4) NOT NULL DEFAULT '0',
  `floor` tinyint(4) NOT NULL DEFAULT '0',
  `floor_total` tinyint(4) NOT NULL DEFAULT '0',
  `squarehouse` smallint(6) NOT NULL DEFAULT '0',
  `squarearea` smallint(6) NOT NULL DEFAULT '0',
  `squareterrace` smallint(6) NOT NULL DEFAULT '0',
  `squarsun` smallint(6) NOT NULL DEFAULT '0',
  `condominimum` smallint(6) NOT NULL DEFAULT '0',
  `condominimum_unit` varchar(255) NOT NULL,
  `distsea` smallint(6) NOT NULL DEFAULT '0',
  `distsea_unit` varchar(255) NOT NULL,
  `distair` smallint(6) NOT NULL DEFAULT '0',
  `distair_unit` varchar(255) NOT NULL,
  `distcity` smallint(6) NOT NULL DEFAULT '0',
  `distcity_unit` varchar(255) NOT NULL,
  `infrastructure` smallint(6) NOT NULL DEFAULT '0',
  `infrastructure_unit` varchar(255) NOT NULL,
  `year_built` smallint(6) NOT NULL DEFAULT '0',
  `title_ru` text NOT NULL,
  `description_ru` text NOT NULL,
  `notes` text NOT NULL,
  `image` text NOT NULL, 
  `address` text NOT NULL,
  `active` tinyint(4) NOT NULL,
  `properties_id`text NOT NULL,
  `nearservices_id` text NOT NULL,
  `lat` varchar(25) NOT NULL DEFAULT '0',
  `lng` varchar(25) NOT NULL DEFAULT '0',
  `is_special_offer` tinyint(4) NOT NULL,
  `seo_keywords_ru` varchar(255) NOT NULL,
  `seo_description_ru` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`),
  KEY `city_id` (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31") or die(mysql_error());
?>


<div class="centre">
<!--LEFT PANEL-->
<table>
<tr>
 <td valign="top" >
<div class="adminmenu">
<br />
<h3>НАСТРОЙКИ</h3>
<ul>
  <li><a href="<?=$_SERVER['PHP_SELF']."?pan=p";?>">пароль администратора</a></li>
  <li><a href="<?=$_SERVER['PHP_SELF']."?pan=ss";?>">SEO</a></li>
  <li><a href="/sendmail/myadmin/index.php" target="_blank">рассылка</a></li>
  <li><a href="<?=$_SERVER['PHP_SELF']."?pan=adr";?>">телефоны,skype,email</a></li>
  </ul><br />
<h3>НАПОЛНЕНИЕ</h3>
<ul>
 <li><a href="<?=$_SERVER['PHP_SELF']."?dept=services";?>">услуги</a></li> 
 <li><a href="<?=$_SERVER['PHP_SELF']."?dept=info";?>">полезная информация</a></li>
 <li><a href="<?=$_SERVER['PHP_SELF']."?dept=contacts";?>">контакты</a></li>
 </ul>
<br />
<h3>ОБЪЯВЛЕНИЯ</h3>
<ul>
 <li><a href="<?=$_SERVER['PHP_SELF']."?pan=n";?>">объявления</a></li>
 <li><a href="<?=$_SERVER['PHP_SELF']."?pan=nn";?>">новое объявление</a></li> 
 
</ul><br />
<h3>СПРАВОЧНИК</h3>
<ul>
 <!--<li><a href="<?=$_SERVER['PHP_SELF']."?pan=type";?>">тип</a></li>-->
 <li><a href="<?=$_SERVER['PHP_SELF']."?pan=cat";?>">категория</a></li> 
 <li><a href="<?=$_SERVER['PHP_SELF']."?pan=pr";?>">свойства</a></li>
 <li><a href="<?=$_SERVER['PHP_SELF']."?pan=ne";?>">поблизости</a></li>  
</ul>
<ul>
 <li><a href="<?=$_SERVER['PHP_SELF']."?pan=r";?>">регионы</a></li> 
 <li><a href="<?=$_SERVER['PHP_SELF']."?pan=ci";?>">города</a></li>
</ul>

<p align="center"><a href='logout.php'>выход</a></p>
</div>
 </td>
 <td valign="top">
<!--RIGHT PANEL-->
<div class="adminpanel">
<!--obyavleniya-->
<?

if($_GET[pan]==n){ ?>

<table id="list2"></table> 
<div id="pager2"></div>

<? }

if($_GET[pan]==nn){ ?>
<div id='fg_membersite'  style="padding:15px" >
<h2>Добавление объявления</h2>
<div id="anun"></div>
<!--<div class='short_explanation'>Поля, отмеченные *, являются обязательными для заполнения.</div>-->

<table><tr>
			<td><label style="text-align:center;"  for="title">Лот</label><br />
			<input style="width:193px; text-align:center;" disabled="disabled" type="text" name="title" id="title" value="" ></td>
        
            <td><label style="text-align:center;" for="sozdano">Создано</label><br />
			<input style="width:193px; text-align:center;" disabled="disabled" type="text" name="sozdano" id="sozdano" value=""></td>
        
            <td><label style="text-align:center;" for="upd">Обновлено</label><br />
			<input style="width:193px; text-align:center;" disabled="disabled" type="text" name="upd" id="upd" value=""><br /></td></tr></table> 
<div id="tabs">
	<ul>
    	<li><a href="#tabs-1">Основные</a></li>
		<li><a href="#tabs-2">Допол.</a></li>
        <li><a href="#tabs-3" >Фотографии</a></li>
		<li><a href="#tabs-4">SEO</a></li> 
    </ul>
<form action="ajaxcreate.php" id="aptform" method="post" > 
<div id="tabs-1">
	<div class='container'>
     	<label for="radio">Специальное предложение</label>
    	<input type="checkbox" name="is_special_offer" value="1" id="radio"/>
    </div>
    <div class='container'>
		<label for="selactive">Статус</label><br />
		<select  name="selactive" id="selactive">
			<option value="1">активно</option>
    		<option value="0" selected="selected">Неактивно</option>  
    	</select>
    </div>
   
    
   	<div class='container'>
    	<label for="deal">Тип сделки</label><br />
    	<select  id="deal" name="deal" >
    		<option value="1" selected="selected">Продажа</option>
    		<option value="2" >Аренда</option>
    	</select>
    </div>
	<div class='container'>
    	<label for="seltypeobj">Тип недвижимости </label><br />
			<select size="1" required name='seltypeobj' id="seltypeobj">
				<option disabled>Тип недвижимости </option>
     			<?  $resulttype=mysql_query("SELECT * FROM `objtype`") or die(mysql_error());
					while($rowtype=mysql_fetch_array($resulttype)){ 
						if($rowtype['objtype']) $rowselect=$rowtype['objtype']; ?>
						<option  value="<?=$rowtype['id'] ?>"><?=$rowselect?></option>
   					<? } ?>
   			</select>
   	</div>
   	<div class='container'>
    	<label for="selcategory">Категория</label><br />
   			<select size="1" required name='selcategory' id="selcategory">
   				<option disabled>Категория</option>
   				<?  $result=mysql_query("SELECT * FROM  `category` ") or die(mysql_error());
   					while($row=mysql_fetch_array($result)){ 
						if($row['category']) $cselect=$row['category'];?>
						<option value="<?=$row['id'] ?>"><?=$cselect?></option>
   					<? } ?>
			</select>
    </div>    
   
	<div class='container'>
    	<label id="pr" for="price">Цена € </label><br />
        <select style="width:50px" size="1" required name='price_ot' id="price_ot" >
			<option value="0" selected="selected"></option>
			<option value="от" >от</option>
   		</select> 
    	<input style="width:165px" type="text" name="price" id="price" value="" maxlength="8" />
        
    </div>
    <div id="pr_table" class='container' style="display:none"> 
    	<table border="1">
        	<tr>
            	<td>
                </td>
            	<td>
                	<label>Май</label>
        		</td>
                <td>
                	<label>Июнь<br />Сентябрь<br />Рождество</label>
                </td>
                <td>
                	<label>Июль<br />Август</label>
                </td>                	
                <td>
                	<label>Остальное <br />время</label>
                </td>
            </tr>
            <tr>
            	<td>
                	<label>1 месяц</label>
                </td>
                <td>
                	<input  class="numint" type="text" name="May_1m" id="May_1m" value="" maxlength="6" />
                </td>
                <td>
                	<input class="numint" type="text" name="June_1m" id="June_1m" value="" maxlength="6" />
                </td>
                <td>
                	<input class="numint" type="text" name="August_1m" id="August_1m" value="" maxlength="6" />
                </td>
                <td>
                	<input class="numint" type="text" name="month_1m" id="month_1m" value="" maxlength="6" />
                </td>
            </tr>
            <tr>
            	<td>
                	<label>2 недели</label>
                </td>
               <td>
                	<input class="numint" type="text" name="May_2w" id="May_2w" value="" maxlength="6" />
                </td>
                <td>
                	<input class="numint" type="text" name="June_2w" id="June_2w" value="" maxlength="6" />
                </td>
                <td>
                	<input class="numint" type="text" name="August_2w" id="August_2w" value="" maxlength="6" />
                </td>
                <td>
                	<input class="numint" type="text" name="month_2w" id="month_2w" value="" maxlength="6" />
            </tr>
            <tr>
            	<td>
                	<label>1 неделя</label>
                </td>
                <td>
                	<input class="numint" type="text" name="May_1w" id="May_1w" value="" maxlength="6" />
                </td>
                <td>
                	<input class="numint" type="text" name="June_1w" id="June_1w" value="" maxlength="6" />
                </td>
                <td>
                	<input class="numint" type="text" name="August_1w" id="August_1w" value="" maxlength="6" />
                </td>
                <td>
                	<input class="numint" type="text" name="month_1w" id="month_1w" value="" maxlength="6" />
            </tr>
        </table>
    	
        
    </div>
    
    
    
	<div class='container'><label for="selregion">Выберите регион</label><br>
				<div id="region">
                	<select size="1" required name='selregion' id="selregion" >
						<option value="all">Все регионы</option>
					<? 	$result=mysql_query("SELECT * FROM `region`") or die(mysql_error()) ;
						while($row=mysql_fetch_array($result)){ 
							if($row['region']) $regselect=$row['region'];?>
  							<option value="<?=$row['id']?>" ><?=$regselect?></option>
   						<? } ?> 
   					</select></div></div>
	<div class='container'>
    	<label for="selcity">Выберите город</label><br>
		<div id="city">
        	<select size="1" required name='selcity' id="selcity">
				<option value="all">Все города</option>
				<? $result=mysql_query("SELECT * FROM `city` ") or die(mysql_error()) ;
					while($row=mysql_fetch_array($result)){ 
						if($row['city']) $cityselect=$row['city'];?>
						<option value="<?=$row['id']?>" ><?=$cityselect?></option>
					<? } ?> 
  			</select>
         </div>
   	</div>
	<div class='container'>
    	<label>Адрес для поиска: </label><br>
		<input id="address" name="address" style="width:600px;" type="text"/>
    </div>
    <script type="text/javascript">
		$(document).ready(function(){		
			initialize(38.3459963,-0.4906855000000405);
			geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
      			if (status == google.maps.GeocoderStatus.OK) {
       			 	if (results[0]) {
						//if($("#address").val !="Все города") $('#address').val(results[0].formatted_address);
          				$('#latitude').val(marker.getPosition().lat());
          				$('#longitude').val(marker.getPosition().lng());
        			}
     		 	}
   			});
			$(function() {
				
    			$("#address").autocomplete({
					//Определяем значение для адреса при геокодировании
      				source: function(request, response) {
        				geocoder.geocode( {'address': request.term}, function(results, status) {
          					response($.map(results, function(item) {
            					return {
              						label:  item.formatted_address,
              						value: item.formatted_address,
              						latitude: item.geometry.location.lat(),
              						longitude: item.geometry.location.lng()
            					}
          					}));
       				 	})
     				},
      				//Выполняется при выборе конкретного адреса
      				select: function(event, ui) {
        						$("#latitude").val(ui.item.latitude);
        						$("#longitude").val(ui.item.longitude);
       							var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
        						marker.setPosition(location);
       							map.setCenter(location);
      							}
    			});
				
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
	});
	</script>
	<div id="map_canvas" style="width:607px; height:400px"></div><br/> 
	<input  id="latitude" name="latitude" type="hidden"/>
	<input  id="longitude" name="longitude" type="hidden"/>
</div>

<div id="tabs-2">
	<div class='container'>
    <label for="year_built">Год постройки</label><br /> 
    <input  type="text" name="year_built" id="year_built" value=""  maxlength="4"/></div>
   <div class='container'>
    <label for="condominimum">Кондоминимум €</label><br /> 
    <input style="width:155px" type="text" name="condominimum" id="condominimum" value=""  maxlength="8"/>
   	<select style="width:60px" size="1" required name='condominimum_unit' id="condominimum_unit" >
			<option value="год" selected="selected">год</option>
			<option value="месяц" >месяц</option>
            
   	</select>
     </div>
	
	<div class='container'><label for="num_of_bath">Количество ванн</label><br />    
    <input type="text" name="num_of_bath" id="num_of_bath" value="" maxlength="2"/>
    </div>
	<div class='container'><label for="num_of_rooms">Количество спален</label><br />    
    <input type="text" name="num_of_rooms" id="num_of_rooms" value="" maxlength="2"/>
    </div> 
    <div class='container'>
    <label for="floor">Этаж/</label> <label for="floors">Этажей всего</label><br /> 
    <input style="width:104px" type="text" name="floor" id="floor" value=""  maxlength="2"/>
    <input style="width:104px" type="text" name="floors" id="floors" value="" maxlength="2" />
    </div>
   	<div class='container'>
    <label for="squarehouse">Площадь дома</label><br /> 
    <input  type="text" name="squarehouse" id="squarehouse" value=""  maxlength="4"/></div>
    <div class='container'>
    <label for="squarearea"> Площадь участка</label><br /> 
	<input  type="text" name="squarearea" id="squarearea" value=""  maxlength="4"/></div>
    <div class='container'>
    <label for="squareterrace">Площадь террасы</label><br /> 
    <input  type="text" name="squareterrace" id="squareterrace" value=""  maxlength="4"/></div>
    <div class='container'>
    <label for="squarsun">Площадь солярия</label><br /> 
    <input  type="text" name="squarsun" id="squarsun" value=""  maxlength="4"/></div> 
    <div class='container'>
    <label for="distsea">Расстояние до моря</label><br /> 
    <input style="width:155px" type="text" name="distsea" id="distsea" value=""  maxlength="4"/>
   	<select style="width:60px" size="1" required name='distsea_unit' id="distsea_unit" >
			<option value="м" selected="selected">м</option>
			<option value="км" >км</option>
            <option value="мин" >мин</option>
   	</select>
     </div>
     
     
   <div class='container'>
    <label for="distair">Расстояние до аэропорта</label><br />
    <input style="width:155px" type="text" name="distair" id="distair" value=""  maxlength="4"/>
    <select style="width:60px" size="1" required name='distair_unit' id="distair_unit" >
			<option value="м" selected="selected">м</option>
			<option value="км" >км</option>
            <option value="мин" >мин</option>
   	</select>
    </div>
   
   <div class='container'>
    <label for="distcity">Расстояние до центра города</label><br />
    <input style="width:155px"  type="text" name="distcity" id="distcity" value=""  maxlength="4"/>
    <select style="width:60px" size="1" required name='distcity_unit' id="distcity_unit" >
			<option value="м" selected="selected">м</option>
			<option value="км" >км</option>
            <option value="мин" >мин</option>
   	</select>
    </div>
    
   <div class='container'>
    <label for="infrastructure">Расстояние до инфраструктуры</label><br />
    <input style="width:155px"  type="text" name="infrastructure" id="infrastructure" value=""  maxlength="4"/>
    <select style="width:60px" size="1" required name='infrastructure_unit' id="infrastructure_unit" >
			<option value="м" selected="selected">м</option>
			<option value="км" >км</option>
            <option value="мин" >мин</option> 
   	</select>
    </div>
    <div class='container'><label for="description_ru">Описание</label><br />
	<textarea  name="description_ru" id="description_ru" value="" style="width:600px;"/></textarea>
	</div>
    <div class='container'><label for="notes">Замечания(не публикуется на сайте)</label><br />
	<textarea  name="notes" id="notes" value="" style="width:600px;"/></textarea>
	</div>
	
	<div class='container'><label for="property">Свойства</label><br />
  	<? $result=mysql_query("SELECT * FROM `properties` ORDER BY `id`") or die(mysql_error());?>
	<table><tr>
		<?
		$i=0;
		while($row=mysql_fetch_array($result)){ 
			$i++;
			if($row['properties']) $cproperty=$row['properties'];?>
		 	<td><input type="checkbox" name="check[]" id="prop<?=$row['id'] ?>" value="<?=$row['id'] ?>" /><?=$cproperty?></td>
        	<?
			if(!($i%2)){?> </tr><? }
			
		 } ?>
    
    </table>
	</div></br>
    <div class='container'><label for="nearservices">Поблизости</label><br />
  	<? $result=mysql_query("SELECT * FROM `nearservices` ORDER BY `id`") or die(mysql_error());?>
	<table><tr>
		<? 
		$i=0;
		while($row=mysql_fetch_array($result)){ 
			$i++;
			if($row['nearservices']) $cproperty=$row['nearservices'];?>
		 	<td><input type="checkbox" id="near<?=$row['id'] ?>" name="checknear[]" value="<?=$row['id'] ?>" /><?=$cproperty?></td>
        	<?
			if(!($i%2)){?> </tr><? }
		 } ?>
    
    </table>
	</div>
    
</div>				

<div id="tabs-3">
		
		<div class="wrapper"> 
			<div  id="filelimit-fine-uploader"></div>
			<div  id="messages"></div>
		</div>
		<div  id="edit"></div>
		<div  id="111"></div>	
		<div id="messages"></div>
 
<script>



  $(document).ready(function() {
	   
    fulltable(); 			  
		
    $fub = $('#fine-uploader');
    $messages = $('#messages');
	
 
     var uploader = new qq.FineUploader({
      element: $('#filelimit-fine-uploader')[0],
      request: {
        endpoint: 'uploaderserv.php'
      },
      validation: {
        allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
        sizeLimit: 5120000, // 500 kB = 500 * 1024 bytes
        //itemLimit: numfile
      },
      callbacks: {
        onSubmit: function(id, fileName) {
          $messages.append('<div id="file-' + id + '" class="alert" style="margin: 20px 0 0"></div>');
        },
        onUpload: function(id, fileName) {
          $('#file-' + id).addClass('alert-info')
                          .html('<img src="images/ajax-loader.gif" alt="Initializing. Please hold."> ' +
                                'Initializing ' +
                                '“' + fileName + '”');
        },
        onProgress: function(id, fileName, loaded, total) {
          if (loaded < total) {
            progress = Math.round(loaded / total * 100) + '% of ' + Math.round(total / 1024) + ' kB';
            $('#file-' + id).removeClass('alert-info')
                            .html('<img src="images/ajax-loader.gif" alt="In progress. Please hold."> ' +
                                  'Uploading ' +
                                  '“' + fileName + '” ' +
                                  progress);
          } else {
            $('#file-' + id).addClass('alert-info')
                            .html('<img src="images/ajax-loader.gif" alt="Saving. Please hold."> ' +
                                  'Saving ' +
                                  '“' + fileName + '”');
          }
        },
        onComplete: function(id, fileName, responseJSON) {	
          if (responseJSON.success) {
				
           $('#file-' + id).remove();
		   fulltable();
		
								
			
					  
          } else {
            $('#file-' + id).removeClass('alert-info') 
                            .addClass('alert-error')
                            .html('<i class="icon-exclamation-sign"></i> ' +
                                  'Error with ' +
                                  '“' + fileName + '”: ' +
                                  responseJSON.error);
          }
        }
      }
    });
  });
</script>  

</div>

<div id="tabs-4">
 <div class='container'>
		<label for="title_ru">Заголовок</label><br />
		<input style="width:400px" type="text" name="title_ru" id="title_ru" value="" />
    </div>
    
<div class='container'><label for="seo_keywords_ru">SEO_keywords</label><br />
<input style="width:400px" type="text" name="seo_keywords_ru" id="seo_keywords_ru" value="" /></div>
<div class='container'><label for="seo_description_ru">SEO_description</label><br />
<input style="width:400px" type="text" name="seo_description_ru" id="seo_description_ru" value="" /></div>
</div>
</div><br /><br />	
  	<input type="hidden" id="hidden" name="hidden" />
    
   	<input type="hidden" id="uveren" name="uveren" />
   
    <input type="submit"  onclick="$('#anun').html('')" name="submit"  value="Создать" id = "btn0" /> 
  
</form>

<?  
if($_GET[id]){?>
		<script>
			edititem("<?=$_GET[id]?>");			
		</script>
	<?	
	 }
	 ?>
<!--<script type="text/javascript">
 var frmvalidator  = new Validator("aptform");
 frmvalidator.addValidation("title_ru","req","Необходимо заполнить поле Название");
 //frmvalidator.addValidation("price","req","Необходимо заполнить поле Цена");
 frmvalidator.EnableOnPageErrorDisplay();
 frmvalidator.EnableMsgsTogether();
</script>-->

</td>

</tr>

</table>
</div>
<? } ?>



<!--SEO-->
<? if($_GET[pan]==ss){ 
		seopage($_POST[home_title],$_POST[home_metadescription],$_POST[home_metakeywords],"home");
	 } ?>
<!--about-->
<?  if($_GET[dept]==info){
mysql_query("CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `datepicker` date NOT NULL DEFAULT '0000-00-00',
  `story_name` text CHARACTER SET utf8 NOT NULL,
  `story` text CHARACTER SET utf8 NOT NULL,
  `story_sthtml` text CHARACTER SET utf8 NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `active` text CHARACTER SET utf8 NOT NULL,
  KEY `id` (`id`),
  KEY `date_updated` (`date_updated`),
  FULLTEXT KEY `story` (`story`,`story_name`))
" )or die(mysql_error());?>


     
<table id="custbut" ></table>
<div id="pcustbut"></div>
<br/>
<div id=sms></div>

<?

    if($_POST[ntitle]){
		$ntitle = strip_tags($_POST[ntitle]);
		$ntitle	= trim($ntitle);
		$ntitle = htmlspecialchars($ntitle);
		$ntitle = mysql_escape_string($ntitle);
		$ntitle = mb_substr($ntitle, 0,140, 'UTF-8');
		$nmetadescription = strip_tags($_POST[nmetadescription]);
		$nmetadescription	= trim($nmetadescription);
		$nmetadescription = htmlspecialchars($nmetadescription);
		$nmetadescription = mysql_escape_string($nmetadescription);
		$nmetadescription = mb_substr($nmetadescription, 0,140, 'UTF-8');
		$nmetakeywords = strip_tags($_POST[nmetakeywords]);
		$nmetakeywords	= trim($nmetakeywords);
		$nmetakeywords = htmlspecialchars($nmetakeywords);
		$nmetakeywords = mysql_escape_string($nmetakeywords);
		$nmetakeywords = mb_substr($nmetakeywords, 0,140, 'UTF-8');
		if($ntitle=="" ||$ntitle==" ") { ?>
          <div style="display: none;">
    		<div class="box-modal" id="error6">
        		<div class="box-modal_close arcticmodal-close">закрыть</div>
        		Невозможно добавить.Используются недопустимые символы или пустая строка
    		</div>
		  </div>
         <? }
		else{
			$result=mysql_query("SELECT * FROM `seo` WHERE `page`='news' ");
			$total=mysql_num_rows($result); 
			if(!$total)$rres=mysql_query ("INSERT INTO seo (title, description, keywords, page) VALUES('$ntitle' ,'$nmetadescription', '$nmetakeywords' , 'news')") or die(mysql_error());
			else $rres=mysql_query ("UPDATE seo SET `title`= '$ntitle', `description`='$nmetadescription', `keywords`='$nmetakeywords' WHERE `page`='news'") or die(mysql_error());
		}
	}
	$result=mysql_query("SELECT * FROM `seo` WHERE `page`='info' ");
	$row=mysql_fetch_array($result);	
		 ?>
       
<? seopage($_POST[info_title],$_POST[info_metadescription],$_POST[info_metakeywords],"info");
   
 }?>

<!--services-->
<? if($_GET[dept]==services){
		if(isset($_POST[editor2])){
		$file ="../service.html";
		$fservices=fopen($file,"w+") or die("невозможно открыть/создать файл");
		fwrite($fservices, $_POST[editor2]) or die ('Не записал');
		fclose($fservices);
		}?>
        <form method="post" action="" >
        <h2>УСЛУГИ</h2>
		<textarea name="editor2" style="width:1045px" id="editor2"><?=file_get_contents("../service.html")?></textarea>
        <input type="submit" name="submit" value="Сохранить"/>
        </form>
        
          <? 
	seopage($_POST[services_title],$_POST[services_metadescription],$_POST[services_metakeywords],"services");
 }  ?>
<!--company-->
<? if($_GET[dept]==contacts){
		/* if(isset($_POST[editor3])){
		$file ="../contacts.html";
		$company=fopen($file,"w+") or die("невозможно открыть/создать файл");
		fwrite($company, $_POST[editor3]) or die ('Не записал');
		fclose($company);
		}?>
        <form method="post" action="" >
        <h2>КОНТАКТЫ</h2>
		<textarea name="editor3" style="width:1045px" id="editor3"><?=file_get_contents("../contacts.html")?></textarea>
        <input type="submit" name="submit" value="Сохранить"/>
        </form>
       
        <?   */ 
		if($_POST['addresscont'] && $_POST['subcont']){
			$input_text = strip_tags($_POST['addresscont']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$addresscont = mb_substr($input_text, 0,140, 'UTF-8');
		
		$qq=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='home'") or die(mysql_error());
		$count = mysql_num_rows($qq);
		if($count) mysql_query("UPDATE `homenumbers` SET `address`='$addresscont',`lat`='$_POST[latitudecont]',`lng`='$_POST[longitudecont]' WHERE `whereuse`='home'") or die(mysql_error());
		else mysql_query("INSERT INTO `homenumbers` (`address`,`lat`,`lng`,`whereuse`) VALUES ('$addresscont','$_POST[latitudecont]','$_POST[longitudecont]','home')") or die(mysql_error());
		}
		$cont=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='home'") or die(mysql_error());
		$count = mysql_num_rows($cont);
		
		$rescont = mysql_fetch_assoc($cont);
		?>
        <form method="post" action="" >
        <h2>КОНТАКТЫ</h2>
		<div class='container'>
    	<label>Адрес для поиска: </label><br>
		<input id="addresscont" name="addresscont" style="width:600px;" type="text" value="<?=$rescont[address]?>"/>
    </div>
    <script type="text/javascript">
		function initializecont(lat,lng){
	
//Определение карты
  var latlng = new google.maps.LatLng(lat,lng);
  var options = {
    zoom: 16,
    center: latlng,
	scrollwheel: false,
    mapTypeId: google.maps.MapTypeId.MAP
  };
 map = new google.maps.Map(document.getElementById("map_canvas_cont"), options);
   //Определение геокодера
  geocoder = new google.maps.Geocoder();
  marker = new google.maps.Marker({
	position: latlng,
	map: map,
    draggable: true
  });
}

		$(document).ready(function(){	
		var latcont=$('#latitudecont').val();
		var lngcont=$('#longitudecont').val();
			initializecont(latcont,lngcont);
			geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) { 
      			if (status == google.maps.GeocoderStatus.OK) {
       			 	if (results[0]) {
						//if($("#address").val !="Все города") $('#address').val(results[0].formatted_address);
          				$('#latitudecont').val(marker.getPosition().lat());
          				$('#longitudecont').val(marker.getPosition().lng());
        			}
     		 	}
   			});
			$(function() {
				
    			$("#addresscont").autocomplete({
					//Определяем значение для адреса при геокодировании
      				source: function(request, response) {
        				geocoder.geocode( {'address': request.term}, function(results, status) {
          					response($.map(results, function(item) {
            					return {
              						label:  item.formatted_address,
              						value: item.formatted_address,
              						latitude: item.geometry.location.lat(),
              						longitude: item.geometry.location.lng()
            					}
          					}));
       				 	})
     				},
      				//Выполняется при выборе конкретного адреса
      				select: function(event, ui) {
        						$("#latitudecont").val(ui.item.latitude);
        						$("#longitudecont").val(ui.item.longitude);
       							var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
        						marker.setPosition(location);
       							map.setCenter(location);
      							}
    			});
				
  			});
  			//Добавляем слушателя события обратного геокодирования для маркера при его перемещении  
  			google.maps.event.addListener(marker, 'drag', function() {
    			geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
      				if (status == google.maps.GeocoderStatus.OK) {
        				if (results[0]) {
          					$('#addresscont').val(results[0].formatted_address);
          					$('#latitudecont').val(marker.getPosition().lat());
          					$('#longitudecont').val(marker.getPosition().lng());
        				}
      				}
    			});
  			});
	});
	</script>
	<div id="map_canvas_cont" style="width:607px; height:400px"></div><br/> 
    <input type="submit" id="subcont" name="subcont" />
	<input  id="latitudecont" name="latitudecont" type="hidden" value="<?=$rescont[lat]?>"/>
	<input  id="longitudecont" name="longitudecont" type="hidden" value="<?=$rescont[lng]?>"/>
</div> 
</form><? 
		seopage($_POST[contacts_title],$_POST[contacts_metadescription],$_POST[contacts_metakeywords],"contacts");
 } ?>
 
 <!--tel,skype,email-->
<? if($_GET[pan]==adr){
	mysql_query("CREATE TABLE IF NOT EXISTS `homenumbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(255),
  `city` varchar(255),
  `email` varchar(255),
  `skype` varchar(255),
  `whereuse` varchar(255),
  `address` text NOT NULL,
  `lat` varchar(25) NOT NULL DEFAULT '38.3459963',
  `lng` varchar(25) NOT NULL DEFAULT '-0.4906855000000405', 
   KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8") or die(mysql_error());

	if($_POST['mainphone'] || $_POST['mainemail'] || $_POST['mainskype']){
		if($_POST['mainphone']){
			$input_text = strip_tags($_POST['mainphone']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$mainphone = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $mainphone = "000-00-00-00";
		if($_POST['mainemail']){
			$input_text = strip_tags($_POST['mainemail']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$mainemail = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $mainemail = "mail@mail.mail";
		if($_POST['mainskype']){
			$input_text = strip_tags($_POST['mainskype']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$mainskype = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $mainphone = "skype_id";
		
		$q=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='home'") or die(mysql_error());
		$count = mysql_num_rows($q);
		if($count) mysql_query("UPDATE `homenumbers` SET `phone`='$mainphone',`email`='$mainemail',`skype`='$mainskype' WHERE `whereuse`='home'") or die(mysql_error());
		else mysql_query("INSERT INTO `homenumbers` (`phone`,`email`,`skype`,`whereuse`) VALUES ('$mainphone','$mainemail','$mainskype','home')") or die(mysql_error());
		
		$q=mysql_query("SELECT * FROM sm_settings") or die(mysql_error());
		$count = mysql_num_rows($q);
		if($count) mysql_query("UPDATE `sm_settings` SET `email`='$mainemail', `from_mail`='$_SERVER[SERVER_NAME]'") or die(mysql_error());
		else mysql_query("INSERT INTO `sm_settings` (`email`,`from_mail`) VALUES ('$mainemail','$_SERVER[SERVER_NAME]')") or die(mysql_error());
		
	};
	if($_POST['phone1'] || $_POST['phone2'] || $_POST['phone3']){
		if($_POST['phone1']){
			$input_text = strip_tags($_POST['phone1']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$phone1 = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $phone1 = "000-00-00-00";
		if($_POST['city1']){
			$input_text = strip_tags($_POST['city1']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$city1 = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $city1 = "";
		if($_POST['phone2']){
			$input_text = strip_tags($_POST['phone2']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$phone2 = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $phone2 = "000-00-00-00";
		if($_POST['city2']){
			$input_text = strip_tags($_POST['city2']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$city2 = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $city2 = "";
		if($_POST['phone3']){
			$input_text = strip_tags($_POST['phone3']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$phone3 = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $phone3 = "000-00-00-00";
		if($_POST['city3']){
			$input_text = strip_tags($_POST['city3']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$city3 = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $city3 = "";
		if($_POST['phone4']){
			$input_text = strip_tags($_POST['phone4']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$phone4 = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $phone4 = "000-00-00-00";
		if($_POST['city4']){
			$input_text = strip_tags($_POST['city4']);
			$input_text	= trim($input_text);
			$input_text = htmlspecialchars($input_text);
			$input_text = mysql_escape_string($input_text);
			$city4 = mb_substr($input_text, 0,140, 'UTF-8');
		}
		else $city4 = "";
		
		$q=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='lot1'") or die(mysql_error());
		$count = mysql_num_rows($q);
		if($count)mysql_query("UPDATE `homenumbers` SET `phone`='$phone1' ,`city`='$city1' WHERE `whereuse`='lot1'") or die(mysql_error());
		else mysql_query("INSERT INTO `homenumbers` (`phone`,`city`,`whereuse`) VALUES ('$phone1','$city1','lot1')") or die(mysql_error());
		
		$q=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='lot2'") or die(mysql_error());
		$count = mysql_num_rows($q);
		if($count)mysql_query("UPDATE `homenumbers` SET `phone`='$phone2',`city`='$city2' WHERE `whereuse`='lot2'") or die(mysql_error());
		else mysql_query("INSERT INTO `homenumbers` (`phone`,`city`,`whereuse`) VALUES ('$phone2','$city2','lot2')") or die(mysql_error());
		
		$q=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='lot3'") or die(mysql_error());
		$count = mysql_num_rows($q);
		if($count)mysql_query("UPDATE `homenumbers` SET `phone`='$phone3',`city`='$city3' WHERE `whereuse`='lot3'") or die(mysql_error());
		else mysql_query("INSERT INTO `homenumbers` (`phone`,`city`,`whereuse`) VALUES ('$phone3','$city3','lot3')") or die(mysql_error());
		
		$q=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='lot4'") or die(mysql_error());
		$count = mysql_num_rows($q);
		if($count)mysql_query("UPDATE `homenumbers` SET `phone`='$phone4',`city`='$city4' WHERE `whereuse`='lot4'") or die(mysql_error());
		else mysql_query("INSERT INTO `homenumbers` (`phone`,`city`,`whereuse`) VALUES ('$phone4','$city4','lot4')") or die(mysql_error());
	
	};
	$q=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='home'") or die(mysql_error());
	$res = mysql_fetch_assoc($q);
	$qq=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='lot1'") or die(mysql_error());
	$res_lot1 = mysql_fetch_assoc($qq);
	$qqq=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='lot2'") or die(mysql_error());
	$res_lot2 = mysql_fetch_assoc($qqq);
	$qqqq=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='lot3'") or die(mysql_error());
	$res_lot3 = mysql_fetch_assoc($qqqq);
	$qqqqq=mysql_query("SELECT * FROM homenumbers WHERE `whereuse`='lot4'") or die(mysql_error());
	$res_lot4 = mysql_fetch_assoc($qqqqq);
	
?>
	<h2>Контакты</h2>
	<form action="" method="post">
    <label for="mainphone">телефон на главной странице</label><br />
    <input class="numphone" required="required" type="tel"  value="<?=$res[phone]?>" id="mainphone" name="mainphone"/><br /><br />
   	<label for="mainskype">email на главной странице</label><br />
    <input required="required" type="email" value="<?=$res[email]?>" id="mainemail" name="mainemail"  /><br /><br />
   	<label for="mainskype">учётная запись skype</label><br />
    <input required="required" type="text"  value="<?=$res[skype]?>" id="mainskype" name="mainskype"  /><br /><br />
    <input type="submit" id="butt" value="изменить">
    </form><br /><br />
    <h2>Телефоны</h2>
    <form action="" method="post">
    <table>
    <tr>
    <td>
    	<label for="phone1">телефон 1</label><br />
    	<input class="numphone" required="required" type="tel"  value="<?=$res_lot1[phone]?>" id="phone1" name="phone1"/>
    </td>
    <td>
    	<label for="city1">город</label><br />
    	<input type="text"  value="<?=$res_lot1[city]?>" id="city1" name="city1"/>
    </td>
    </tr>
    <tr>
    <td>
   	<label for="phone2">телефон 2</label><br />    
    <input class="numphone" required="required" type="tel" value="<?=$res_lot2[phone]?>" id="phone2" name="phone2"  /></td>
    <td>
    	<label for="city2">город</label><br />
    	<input type="text"  value="<?=$res_lot2[city]?>" id="city2" name="city2"/>
    </td>
    </tr>
    <tr>
    <td>
   	<label for="phone3">телефон 3</label><br />
    <input class="numphone" required="required" type="tel"  value="<?=$res_lot3[phone]?>" id="phone3" name="phone3"  /></td>
    <td>
    	<label for="city3">город</label><br />
    	<input type="text"  value="<?=$res_lot3[city]?>" id="city3" name="city3"/>
    </td>
    </tr>
    <tr>
    <td>
    <label for="phone4">телефон 4</label><br />
    <input class="numphone" required="required" type="tel"  value="<?=$res_lot4[phone]?>" id="phone4" name="phone4"  /></td>
    <td>
    	<label for="city4">город</label><br />
    	<input type="text"  value="<?=$res_lot4[city]?>" id="city4" name="city4"/>
    </td>
    </tr>
    <tr>
    <td>
    <input type="submit" id="butt1" value="изменить"></td>
    </tr>
    </table>
    </form>
	<? }
	?>
<!--pass-->
<? if($_GET[pan]==p){
	
if(isset($_POST['submittedd']))
{
   if($fgmembersite->ChangePasswordInDBmer())
   { ?>
 <div id='fg_membersite_content'>

<h3 style="color:#F00">Ваш пароль обновлен!</h3>

<p>
<a href='logout.php'>logout</a>
</p>
</div>
 <?  }
}?>
<div id='fg_membersite' class="tableform"  style="width:330px; margin-left:20px">
<h2>Сменить пароль</h2>
<form id='changepwd'  method='post' accept-charset='UTF-8'>
<input type='hidden' name='submittedd' id='submittedd' value='1'/>
<div class='short_explanation'>* Обязательные поля</div>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>

<div class='container'>
    <label for='oldpwd' >Текущий пароль:*:</label><br/>
    <div class='pwdwidgetdiv' id='oldpwddiv' ></div><br/>
    <noscript>
    <input  type='password' name='oldpwd' id='oldpwd' maxlength="50" />
    </noscript>    
    <span id='changepwd_oldpwd_errorloc' class='error'></span>
</div>

<div class='container'>
    <label for='newpwd' >Новый пароль*:</label><br/>
    <div class='pwdwidgetdiv' id='newpwddiv' ></div>
    <noscript>
    <input type='password' name='newpwd' id='newpwd' maxlength="50" /><br/>
    </noscript>
    <span id='changepwd_newpwd_errorloc' class='error'></span>
</div>
<br/>
<div class='container'>
    <label for='confpwd' >Повтор пароля:*:</label><br/>  
    <div class='pwdwidgetdiv' id='confpwddiv' ></div><br/>
    <noscript>
    <input type='password' name='confpwd' id='confpwd' maxlength="50" />
    </noscript>    
    <span id='changepwd_confpwd_errorloc' class='error'></span>
</div>
<br/>
<div class='container'>  
    <input type='submit' name='Submit' value='сменить' />
</div>


</form>
<script type='text/javascript'>
// <![CDATA[
    var pwdwidget = new PasswordWidget('oldpwddiv','oldpwd');
    pwdwidget.enableGenerate = false;
    pwdwidget.enableShowStrength=false;
    pwdwidget.enableShowStrengthStr =false;
    pwdwidget.MakePWDWidget();
    
    var pwdwidget = new PasswordWidget('newpwddiv','newpwd'); 
    pwdwidget.MakePWDWidget();
	
	var pwdwidget = new PasswordWidget('confpwddiv','confpwd');
    pwdwidget.enableGenerate = false;
    pwdwidget.enableShowStrength=false;
    pwdwidget.enableShowStrengthStr =false;
    pwdwidget.MakePWDWidget();
    
    var frmvalidator  = new Validator("changepwd");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("oldpwd","req","Пожалуйста, укажите ваш старый пароль");
    
    frmvalidator.addValidation("newpwd","req","Пожалуйста, укажите ваш новый пароль");
	
	frmvalidator.addValidation("confpwd","req","Подтвердите Ваш новый пароль");
	
	frmvalidator.addValidation("confpwd","eqelmnt=newpwd","Пароль не совпадает");

// ]]>
</script>

</div>
<? }?>
<!--type-->
<? if($_GET[pan]==type)	tablnew("objtype","type","тип","type","тип");?>
<!--CATEGORY-->
<? if($_GET[pan]==cat)	tablnew("category","cat","категория","category","категорию"); ?>
<!--properies-->
<? if($_GET[pan]==pr)	tablnewprop("properties","pr","свойство","property","свойство"); ?> 
<!--near-->
<? if($_GET[pan]==ne)	tablnewprop("nearservices","ne","услуги поблизости","services","услугу поблизости"); ?>
<!--country-->
<? //if($_GET[pan]==c)	tablnew("country","c","страна","country","страну"); ?>
<!--region-->
<? //if($_GET[pan]==r)	tablnew1("region","r","регион","region","регион","country","страна");
	if($_GET[pan]==r)	tablnew("region","r","регион","region","регион"); ?> 
<!--city-->
<? //if($_GET[pan]==ci)	tablnew2("city","ci","город","city","город","country","страна","region","регион","propertiescity","свойство города"); 
	if($_GET[pan]==ci)	tablnew1("city","ci","город","city","город","region","регион");?>
<!--city properies-->
<? //if($_GET[pan]==pci)	tablnew("propertiescity","pci","свойство города","city properties","свойство города"); ?>
</div>
</td>
</tr>
</table>
</div>
</body>
</html>