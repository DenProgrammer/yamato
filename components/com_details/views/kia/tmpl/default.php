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
ul.regionmenu li{
	width:120px;
	height:42px;
	display:inline-block;
	list-style:none;
	text-align:center;
	background:#c3c3c3;
	border:solid 2px #ffffff;
	border-radius:10px;
	margin:0 10px;
	color:#000000;
	font:normal 14px/42px Arial;
	box-shadow:0 0 3px rgba(0,0,0,0.7);
	cursor:pointer;
}
ul.regionmenu li.active{
	background:#ffffff;
}
#epc{
	text-align:left;
}
ul.regionmenu li{
	width:110px;
	height:42px;
	display:inline-block;
	list-style:none;
	text-align:center;
	background:#c3c3c3;
	border:solid 2px #ffffff;
	border-radius:10px;
	margin:5px 10px;
	color:#000000;
	font:normal 14px/42px Arial;
	box-shadow:0 0 3px rgba(0,0,0,0.7);
	cursor:pointer;
}
ul.regionmenu li.active{
	background:#ffffff;
}
select[name=carea]{display:none;}
</style>
<ul class="regionmenu">
	<li id="rm_li_AUS" <?php if ($this->area == 'AUS') echo 'class="active"'; ?> onclick="setRegion('AUS')">Австралия</li>
	<li id="rm_li_CAN" <?php if ($this->area == 'CAN') echo 'class="active"'; ?> onclick="setRegion('CAN')">Канада</li>
	<li id="rm_li_EUR" <?php if ($this->area == 'EUR') echo 'class="active"'; ?> onclick="setRegion('EUR')">Европа</li>
	<li id="rm_li_GEN" <?php if ($this->area == 'GEN') echo 'class="active"'; ?> onclick="setRegion('GEN')">Общий</li>
	<li id="rm_li_MES" <?php if ($this->area == 'MES') echo 'class="active"'; ?> onclick="setRegion('MES')">Ближний восток</li>
	<li id="rm_li_USA" <?php if ($this->area == 'USA') echo 'class="active"'; ?> onclick="setRegion('USA')">США</li>
</ul>
<div id="price"></div>
<script>
	function setRegion(carArea)
		{
			document.location = 'index.php?option=com_details&Itemid=3&view=kia&area='+carArea
		}
		
	
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
			var url = 'index.php?option=com_details&view=mazda&Itemid=<?php echo $this->Itemid; ?>&step='+z+'&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
		jQuery("select[name='carea'] option[value='<?php echo $this->area ?>']").attr("selected","selected")
		jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=kia&step=2&ajax=1&layout=ajax&route=catalog/kia/variants&area=<?php echo $this->area ?>',
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'carea\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html = '<option value=""></option>';
					if (json['result'])
					for (i = 0; i < json['result'].length; i++) {
						html += '<option value="' + json['result'][i]['CMBPNO'] + '">' + json['result'][i]['CMSGDS'] + '&nbsp;&nbsp;&nbsp;' + json['result'][i]['CMCRNM'] + ' &nbsp;&nbsp;&nbsp;Выпуск с ' + json['result'][i]['StartDate'] + ' по ' + json['result'][i]['EndDate'] + '</option>';
					}
					jQuery('select[name=\'cat\']').html(html);
					jQuery('select[name=\'clf\']').html('');
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
	});
	function getCode(id)
		{
			var detailCode = '';
			jQuery("#"+id+" td").each(function(i,elem){
				if (i==1) 
					{
						detailCode = jQuery(this).html();
						mainFind(detailCode);
						jQuery('body,html').animate({scrollTop: 300}, 600);
					}
			});
		}
	function decodecfg() {
		url = '';
		val = jQuery('select[name=\'carea\']').val();
		url += '&area=' + encodeURIComponent(val);
		val = jQuery('select[name=\'cat\']').val();
		url += '&cat=' + encodeURIComponent(val);
		val = jQuery('select[name=\'clf\']').val();
		url += '&clf=' + encodeURIComponent(val);
		if (url) jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_details&Itemid=3&view=kia&step=2&ajax=1&layout=ajax&route=catalog/kia/variants'+url,
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
				if (json['error']) {
					jQuery('#tab-model').find('.form').after('<div class="warning">' + json['error'] + '</div>');
				}
				else {
					jQuery(location).attr('href','index.php?option=com_details&Itemid=3&view=kia&step=3&route=catalog/kia' + url);
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
		//jQuery("input[name='frame1']").parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().hide();
		jQuery("scriptus").remove();
		
		jQuery('select[name=\'carea\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=kia&step=2&ajax=1&layout=ajax&route=catalog/kia/variants&area=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'carea\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html = '<option value=""></option>';
					if (json['result'])
					for (i = 0; i < json['result'].length; i++) {
						html += '<option value="' + json['result'][i]['CMBPNO'] + '">' + json['result'][i]['CMSGDS'] + '&nbsp;&nbsp;&nbsp;' + json['result'][i]['CMCRNM'] + ' &nbsp;&nbsp;&nbsp;Выпуск с ' + json['result'][i]['StartDate'] + ' по ' + json['result'][i]['EndDate'] + '</option>';
					}
					jQuery('select[name=\'cat\']').html(html);
					jQuery('select[name=\'clf\']').html('');
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		jQuery('select[name=\'cat\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=kia&step=2&ajax=1&layout=ajax&route=catalog/kia/variants&area=' + encodeURIComponent(jQuery('select[name=\'carea\']').val())+'&cat=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'cat\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html = '<option value=""></option>';
					if (json['result'])
					for (i = 0; i < json['result'].length; i++) {
						html += '<option value="' + json['result'][i]['id'] + '">' + json['result'][i]['id'] + ' - ' + json['result'][i]['description'] + '</option>';
					}
					jQuery('select[name=\'clf\']').html(html);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}); 
	});
</script>
<div id="result">
	<h1>Каталог запчастей KIA</h1>
	<table style="margin:10px 0 0 200px;">
		<tr><td align="left"><?php echo $select; ?></select></td></tr>
		<tr><td align="left"><select name="cat"><option value="">Выберите регион</option></select></td></tr>
		<tr><td align="left"><select name="clf" onchange="decodecfg()"><option value="">Выберите регион</option></select></select></td></tr>
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
		
		jQuery('#result a').each(function(i,elem) {
			var params = jQuery(this).attr('href');
			var mas = new Array();
			mas = params.split('?');
			var p = mas[1];
			var url = 'index.php?option=com_details&view=kia&Itemid=<?php echo $this->Itemid; ?>&step=<?php echo $this->step+1; ?>&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
		
		jQuery('td[height="1%"]').hide();
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

