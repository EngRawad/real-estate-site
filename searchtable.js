// JavaScript Document
function setClear(elem) {
            if (elem.value == elem.defaultValue) {
                elem.value = '';
            } 
        }
        
        function setDefault(elem) {
            if (!elem.value) {
                elem.value = elem.defaultValue;
            } 
        }
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
function golot(lotid) {
	//<![CDATA[
	$('#lot').focus();
$.ajax
   	({
        	type: "POST", 
          	url: "ajaxsearch.php", 
			dataType: "json",
			data:{
				lot:lotid
				},
			success: function(data){
				if(data=="NO") {
					$('#errorlot').css('display','inline');
					}
				else document.location.href="/lot.php?id="+data;
				}
	});

	}

//]]>
function go() {
	//<![CDATA[
var selcategory=$("#selcategory").val();
var selregion=$('#selregion').val();
var selcity=$('#selcity').val();
var selobjtype=$("#selobjtype").val();
var square=$("#square").val();
var square1=$("#square1").val();
var num_of_rooms=$("#num_of_rooms").val();
var num_of_rooms1=$("#num_of_rooms1").val();
var prcl=$("#prcl").val();
var prch=$("#prch").val();
var bathl=$("#bathl").val();
var bathh=$("#bathh").val();
var num=$("#tivh").val();
$("#tiv").html('<img src="images/ajax-loader.gif" alt="" />'); 

$.ajax
   	({
        	type: "POST", 
          	url: "ajaxsearch.php", 
			dataType: "json",
			data:{
				cat:selcategory,
				reg:selregion,
				city:selcity,
				type:selobjtype,
				sq: square,
				sq1: square1,
				rooms: num_of_rooms,
				rooms1: num_of_rooms1,
				prcl:prcl,
				prch:prch,
				bathl:bathl,
				bathh:bathh,
				deal:1,
				},
			success: function(data){
			
				if(data.objtype) $("#objtype").html(data.objtype);
				if(data.city) $("#city").html(data.city);
				if(data.region) $("#region").html(data.region); 
				if(data.category) $("#category").html(data.category); 
				$("#tivh").val(data.numrow);
				$("#tiv").text($("#tivh").val());
               }
	});
	}

//]]>
function gogo(){	
		
	var selcategory=$("#selcategory").val();
	cat="cat="+selcategory+"\u0026";	
	var selregion=$("#selregion").val();
	reg="reg="+selregion+"\u0026";
	var selcity=$("#selcity").val();
	city="city="+selcity+"\u0026";
	var selobjtype=$("#selobjtype").val();
	type="type="+selobjtype+"\u0026";
	
	var square=$("#square").val();
	if(square!="") sq="sq="+square+"\u0026";
	else sq="";
	
	var square1=$("#square1").val(); 
	if(square1!="") sq1="sq1="+square1+"\u0026";
	else sq1="";
	var num_of_rooms=$("#num_of_rooms").val();
	if(num_of_rooms!="") rooms="rooms="+num_of_rooms+"\u0026";
	else rooms="";
	var num_of_rooms1=$("#num_of_rooms1").val();
	if(num_of_rooms1!="") rooms1="rooms1="+num_of_rooms1+"\u0026";
	else rooms1="";
	var prcl=$("#prcl").val();
	if(prcl!="") prcl="prcl="+prcl+"\u0026";
	else prcl="";
	var prch=$("#prch").val();
	if(prch!="") prch="prch="+prch+"\u0026";
	else prch="";
	
	var bathl=$("#bathl").val();
	if(bathl!="") bathl="bathl="+bathl+"\u0026";
	else bathl="";
	var bathh=$("#bathh").val();
	if(bathh!="") bathh="bathh="+bathh+"\u0026";
	else bathh="";
	
	document.location.href="/properties.php?"+cat+reg+city+type+prcl+prch+sq+sq1+rooms+rooms1+bathl+bathh+"deal=1";
}  

//arenda//
function gorent() {
	//<![CDATA[
var selcategoryrent=$("#selcategoryrent").val();
var selregionrent=$('#selregionrent').val();
var selcityrent=$('#selcityrent').val();
var selobjtyperent=$("#selobjtyperent").val();
var squarerent=$("#squarerent").val();
var square1rent=$("#square1rent").val();
var num_of_roomsrent=$("#num_of_roomsrent").val();
var num_of_rooms1rent=$("#num_of_rooms1rent").val();
var prclrent=$("#prclrent").val();
var prchrent=$("#prchrent").val();
var bathlrent=$("#bathlrent").val();
var bathhrent=$("#bathhrent").val();
var numrent=$("#tivhrent").val();
$("#tivrent").html('<img src="images/ajax-loader.gif" alt="" />'); 

$.ajax
   	({
        	type: "POST", 
          	url: "ajaxsearch.php",
			dataType: "json",
			data:{
				cat:selcategoryrent, 
				reg:selregionrent,
				city:selcityrent,
				type:selobjtyperent,
				sq: squarerent,
				sq1: square1rent,
				rooms: num_of_roomsrent,
				rooms1: num_of_rooms1rent,
				prcl:prclrent,
				prch:prchrent,
				bathl:bathlrent,
				bathh:bathhrent,
				deal:2,
				},
			success: function(data){
				
				if(data.objtype) $("#objtyperent").html(data.objtype);
				if(data.city) $("#cityrent").html(data.city);
				if(data.region) $("#regionrent").html(data.region); 
				if(data.category) $("#categoryrent").html(data.category); 
				$("#tivhrent").val(data.numrow);
				$("#tivrent").text($("#tivhrent").val());
               }
	});
	}

//]]>
function gogorent(){	
		
	var selcategoryrent=$("#selcategoryrent").val();
	cat="cat="+selcategoryrent+"\u0026";	
	var selregionrent=$("#selregionrent").val();
	reg="reg="+selregionrent+"\u0026";
	var selcityrent=$("#selcityrent").val();
	city="city="+selcityrent+"\u0026";
	var selobjtyperent=$("#selobjtyperent").val();
	type="type="+selobjtyperent+"\u0026";
	
	var squarerent=$("#squarerent").val();
	if(squarerent!="") sq="sq="+squarerent+"\u0026";
	else sq="";
	
	var square1rent=$("#square1rent").val(); 
	if(square1rent!="") sq1="sq1="+square1rent+"\u0026";
	else sq1="";
	var num_of_roomsrent=$("#num_of_roomsrent").val();
	if(num_of_roomsrent!="") rooms="rooms="+num_of_roomsrent+"\u0026";
	else rooms="";
	var num_of_rooms1rent=$("#num_of_rooms1rent").val();
	if(num_of_rooms1rent!="") rooms1="rooms1="+num_of_rooms1rent+"\u0026";
	else rooms1="";
	var prclrent=$("#prclrent").val();
	if(prclrent!="") prcl="prcl="+prclrent+"\u0026";
	else prcl="";
	var prchrent=$("#prchrent").val();
	if(prchrent!="") prch="prch="+prchrent+"\u0026";
	else prch="";
	var bathlrent=$("#bathlrent").val();
	if(bathlrent!="") bathl="bathl="+bathlrent+"\u0026";
	else bathl="";
	var bathhrent=$("#bathhrent").val();
	if(bathhrent!="") bathh="bathh="+bathhrent+"\u0026";
	else bathh="";
	
	document.location.href="/properties.php?"+cat+reg+city+type+prcl+prch+sq+sq1+rooms+rooms1+bathl+bathh+"deal=2";
} 
function submit_golot(form) {
				golot($('#lot').val()); 
 				return false;
			}
