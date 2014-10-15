<?php
/**
 * @version		$Id: edit.php 20549 2011-02-04 15:01:51Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

?>
<style>
a {
	color: #000000;
	font-family: Arial,Helvetica,sans-serif;
	font-size: 12px;
	text-decoration: none;
}
ul.regionmenu{

}
#result ul.regionmenu li{
	width:120px;
	height:42px;
	display:inline-block;
	list-style:none;
	text-align:center;
	background:#c3c3c3;
	border:solid 2px #ffffff;
	border-radius:10px;
	margin:0 5px;
	color:#000000;
	font:normal 14px/42px Arial;
	box-shadow:0 0 3px rgba(0,0,0,0.7);
	cursor:pointer;
}
#result ul.regionmenu li.active{
	background:#ffffff;
}
#epc{
	text-align:left;
}
a.button {
    display: inline-block;
    padding: 6px 12px;
    text-decoration: none;
}
a.button, input.button {
    background: none repeat scroll 0 0 #1EAAE7;
    border-radius: 7px 7px 7px 7px;
    box-shadow: 0 2px 2px #DDDDDD;
    color: #FFFFFF;
    cursor: pointer;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: bold;
    line-height: 12px;
}
</style>
<div id="price"></div>
<script>
	jQuery(document).ready(function(){
		jQuery("scriptus").remove();
		
		jQuery("div.breadcrumb a:first-child").remove();
		jQuery("div.breadcrumb a:first-child").remove();
		
		jQuery("div.breadcrumb a").each(function(i,elem){
			var z = i+2;
			if (i == 0) z = 1;
			if (i == 1) z = 3;
			var params = jQuery(this).attr('href');
			var mas = new Array();
			mas = params.split('?');
			var p = mas[1];
			var url = 'index.php?option=com_details&view=nissan&Itemid=<?php echo $this->Itemid; ?>&step='+z+'&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
	});
	function setRegion(id)
		{			
			jQuery("ul.regionmenu li").removeClass('active');
			jQuery("#rm_li_"+id).addClass('active');
			
			jQuery('select[name=\'carea\'] option[value='+id+']').attr('selected','selected');
			jQuery('select[name=\'carea\']').change();
		}
	function getCode(id)
		{
			var detailCode = '';
			jQuery("tr #"+id+" td").each(function(i,elem){
				if (i==1) 
					{
						detailCode = jQuery(this).html();
						mainFind(detailCode);
						jQuery('body,html').animate({scrollTop: 300}, 600);
					}
			});
		}
	function decodecfg() 
		{
			url = '';
			val = jQuery('select[name=\'carea\']').val();
			if (val) url += '&carea=' + encodeURIComponent(val);
			val = jQuery('select[name=\'model\']').val();
			if (val) url += '&mdl=' + encodeURIComponent(val);
			val = jQuery('select[name=\'cb0\']').val();
			if (val) url += '&cb1=' + encodeURIComponent(val);
			val = jQuery('select[name=\'cb1\']').val();
			if (val) url += '&cb2=' + encodeURIComponent(val);
			val = jQuery('select[name=\'cb2\']').val();
			if (val) url += '&cb3=' + encodeURIComponent(val);
			val = jQuery('select[name=\'cb3\']').val();
			if (val) url += '&cb4=' + encodeURIComponent(val);
			val = jQuery('select[name=\'cb4\']').val();
			if (val) url += '&cb5=' + encodeURIComponent(val);
			val = jQuery('select[name=\'cb5\']').val();
			if (val) url += '&cb6=' + encodeURIComponent(val);
			val = jQuery('select[name=\'cb6\']').val();
			if (val) url += '&cb7=' + encodeURIComponent(val);
			val = jQuery('select[name=\'cb7\']').val();
			if (val) url += '&cb8=' + encodeURIComponent(val);
			if (url) jQuery.ajax({
				type: 'POST',
				url: 'index.php?option=com_details&Itemid=<?php echo $this->Itemid; ?>&view=nissan&step=2&ajax=1&layout=ajax&route=catalog/nissan/variants&cfg_id'+url,
				dataType: 'json',
				beforeSend: function() {
					jQuery('.success, .warning').remove();
					jQuery('#button-filter').attr('disabled', true);
				},
				complete: function() {
					jQuery('#button-filter').attr('disabled', false);
					jQuery('.attention').remove();
					jQuery('.wait').remove();
				},
				success: function(json) {
					jQuery('.success, .warning').remove();
					if (json['error']) {alert( json['error']);
						jQuery('#tab-model').find('.form').after('<div class="warning">' + json['error'] + '</div>');
					}
					else {
						jQuery(location).attr('href','index.php?option=com_details&Itemid=<?php echo $this->Itemid; ?>&view=nissan&step=3route=catalog/nissan&ext=' + json['pn']['ext'] +'&cfg_id=' + json['pn']['posname_no'] + '&cat=' + json['pn']['idx']);
					}
				}
			});
		}
</script>
<?php
	
	switch($this->step)
		{
			case 1:
				{
					$select = '';
					$s = strpos($this->data,'<select name="carea">');
					$e = strpos($this->data,'</select>',$s);
					$select = substr($this->data,$s, $e-$s);
?>
<script>	
	jQuery(document).ready(function() {
		jQuery("scriptus").remove();
		
		jQuery('select[name=\'carea\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=<?php echo $this->Itemid; ?>&view=nissan&step=2&ajax=1&layout=ajax&route=catalog/nissan/variants&carea=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'carea\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html1 = '<option value=""></option>';
					if (json['cdindex'])
					for (i = 0; i < json['cdindex'].length; i++) {
						html1 += '<option value="' + i + '">' + json['cdindex'][i]['ModelName'] + '&nbsp;&nbsp;&nbsp;[' + json['cdindex'][i]['ModelSeries'] + ']' + ' &nbsp;&nbsp;&nbsp;Выпуск с ' + json['cdindex'][i]['frm'] + ' по ' + json['cdindex'][i]['upto'] + '</option>';
					}
					jQuery("tr[id^='var_cb']").remove();
					jQuery('select[name=\'model\']').html(html1);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
		jQuery('select[name=\'model\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=<?php echo $this->Itemid; ?>&view=nissan&step=2&ajax=1&layout=ajax&route=catalog/nissan/variants&carea=' + encodeURIComponent(jQuery('select[name=\'carea\']').val())+'&mdl=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'model\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html = '';
					if (json['var'])
					for (i = 0; i < json['var'].length; i++) {
						html += '<tr><td>'+json['var'][i]['name']+'</td><td><select name="cb' + i + '">';
						// html += '<option value="">Все</option>';
						for (j = 0; j < json['var'][i]['list'].length; j++)
							html += '<option value="' + json['var'][i]['list'][j]['variation'] + '"' + (json['var'][i]['list'].length==1?' selected ':'') + '>' + json['var'][i]['list'][j]['description'] + '</option>';
						html += '</select></td></tr>';
					}
					jQuery("tr[id^='var_cb']").remove();
					jQuery('#var_mdl').after(html);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}); 
	});
</script>
<div id="result">
	<h1>Каталог запчастей NISSAN и INFINITI</h1>
	<table style="text-align:left;width:100%;">
		<tr>
			<td colspan="2">				
<select name="carea" style="display:none;">
	<option value="CA">Канада</option>
	<option value="EL">Европа</option>
	<option value="ER">Англия</option>
	<option value="GL">Ближний восток (левый руль)</option>
	<option value="GR">Ближний восток (правый руль)</option>
	<option value="US">США</option>
</select>
				
<ul class="regionmenu">
	<li onclick="setRegion('CA')" id="rm_li_CA">Канада</li>
	<li onclick="setRegion('EL')" id="rm_li_EL">Европа</li>
	<li onclick="setRegion('ER')" id="rm_li_ER">Англия</li>
	<li onclick="setRegion('GL')" id="rm_li_GL">Бл. восток (лев.)</li>
	<li onclick="setRegion('GR')" id="rm_li_GR">Бл. восток (прав.)</li>
	<li onclick="setRegion('US')" id="rm_li_US">США</li>
</ul>

			</td>
		</tr>
		<tr id="var_mdl">
			<td>Модель </td>
			<td>
				<select name="model"><option value="">Выберите регион</option></select>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;" colspan="2"><a class="button" id="button-filter" onclick="decodecfg();">Продолжить</a></td>
		</tr>
	</table>
</div>
<?php
					break;
				}
			case 3:
			case 4:
				{
?>
<script>
	jQuery(document).ready(function() {
		
		jQuery("#header").remove();
		jQuery("div.breadcrumb").remove();
		
		jQuery('#result a').each(function(i,elem) {
			var params = jQuery(this).attr('href');
			var mas = new Array();
			mas = params.split('?');
			var p = mas[1];
			var url = 'index.php?option=com_details&view=nissan&Itemid=<?php echo $this->Itemid; ?>&step=<?php echo $this->step+1; ?>&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
		
		jQuery("img[usemap=#hotspots]").before('<div style="position:relative;"><div id="mapborder" style="cursor:pointer;position:absolute;border:solid 1px red;"></div></div>');
		
		jQuery("map[name=hotspots] area").mouseover(function(){
			var coords = jQuery(this).attr('coords');
			var id = jQuery(this).attr('id');
			var href = jQuery(this).attr('href');
			var hrefmas = href.split('?');
			var p = hrefmas[1];
			var mas = coords.split(',');
			
			var x1 = mas[0];
			var y1 = mas[1];
			var x2 = mas[2];
			var y2 = mas[3];
			
			var width = x2 - x1;
			var height = y2 - y1;
			
			jQuery("#mapborder").css("width",width).css("height",height)
				.css("left",x1+"px").css("top",y1+"px")
				.css("display","block").attr("onclick","document.location='index.php?option=com_details&view=nissan&Itemid=<?php echo $this->Itemid; ?>&step=<?php echo $this->step+1; ?>&"+p+"'");
			
		});
		
		jQuery("#mapborder").mouseout(function(){
			jQuery("#mapborder").css("display","none");
		});
	});
</script>	
<div id="result"><?php echo $this->data; ?></div>
<?php
					break;
				}
			case 5:
				{
?>
<script>
	jQuery(document).ready(function() {
		
		jQuery("#result table tr:first-child th").attr("bgcolor","#c3c3c3");
		jQuery("table").attr("width","100%");
		jQuery("td[width='1%']").attr("width","100%");
		
		jQuery("table.list tr td:last-child").remove();
		jQuery("table.list tr th:last-child").remove();
		jQuery("table.list tr th:first-child").remove();
		jQuery("table.list tr td:first-child").remove();
		
		jQuery('table.list tbody tr').each(function() {
			jQuery(this).click(function(){
				jQuery(this).find("td").each(function(i,elem){
					if (i==1) 
						{
							detailCode = jQuery(this).html();
							mainFind(detailCode);
						}
				});
				jQuery('body,html').animate({scrollTop: 300}, 600);
			});
		});
		
		jQuery("img[usemap=#hotspots-001-1]").before('<div style="position:relative;"><div id="mapborder" style="cursor:pointer;position:absolute;border:solid 1px red;"></div></div>');
		
		jQuery("map[name=hotspots-001-1] area").mouseover(function(){
			var coords = jQuery(this).attr('coords');
			var id = jQuery(this).attr('id');
			var mas = coords.split(',');
			
			var x1 = mas[0];
			var y1 = mas[1];
			var x2 = mas[2];
			var y2 = mas[3];
			
			var width = x2 - x1;
			var height = y2 - y1;
			
			jQuery("#mapborder").css("width",width).css("height",height)
				.css("left",x1+"px").css("top",y1+"px")
				.css("display","block").attr("onclick","getCode('"+id+"')");
			
		});
		
		jQuery("#mapborder").mouseout(function(){
			jQuery("#mapborder").css("display","none");
		});
	});
	
	
</script>	
<div id="result"><?php echo $this->data; ?></select></div>
<?php
					break;
				}
			case 6:
				{
?>
<script>
	jQuery(document).ready(function(){
		jQuery("#result a img").remove();
		
		jQuery("table.list tr td:last-child").remove();
		jQuery("table.list tr th:last-child").remove();
		jQuery("table.list tr th:first-child").remove();
		jQuery("table.list tr td:first-child").remove();
		
		jQuery('table.list tbody tr').each(function() {
			jQuery(this).click(function(){
				jQuery(this).find("td").each(function(i,elem){
					if (i==1) 
						{
							detailCode = jQuery(this).html();
							mainFind(detailCode);
						}
				});
				jQuery('body,html').animate({scrollTop: 300}, 600);
			});
		});
		
		jQuery("img[usemap=#hotspots-1-1]").before('<div style="position:relative;"><div id="mapborder" style="cursor:pointer;position:absolute;border:solid 1px red;"></div></div>');
		
		jQuery("map[name=hotspots-1-1] area").mouseover(function(){
			var coords = jQuery(this).attr('coords');
			var id = jQuery(this).attr('id');
			var mas = coords.split(',');
			
			var x1 = mas[0];
			var y1 = mas[1];
			var x2 = mas[2];
			var y2 = mas[3];
			
			var width = x2 - x1;
			var height = y2 - y1;
			
			jQuery("#mapborder").css("width",width).css("height",height)
				.css("left",x1+"px").css("top",y1+"px")
				.css("display","block").attr("onclick","getCode('"+id+"')");
			
		});
		
		jQuery("#mapborder").mouseout(function(){
			jQuery("#mapborder").css("display","none");
		});
	});		
	
</script>	
<div id="result"><?php echo $this->data; ?></select></div>
<?php
					break;
				}
		}

?>

