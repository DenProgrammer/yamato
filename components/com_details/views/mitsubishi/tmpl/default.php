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
a.button {
    display: inline-block;
    padding: 6px 12px;
    text-decoration: none;
}
a.button, input.button {
    background: #1eaae7;
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
			var url = 'index.php?option=com_details&view=mitsubishi&Itemid=<?php echo $this->Itemid; ?>&step='+z+'&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
	});
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
</script>
<?php
	
	switch($this->step)
		{
			case 2:
				{
					echo $this->data;
					break;
				}
			case 1:
				{
?>
<script>	
	jQuery(document).ready(function() {
		jQuery("scriptus").remove();
		
		jQuery('select[name=\'carea\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=mitsubishi&ajax=1&layout=ajax&route=catalog/mitsubishi/variants&area=' + this.value,
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
						html += '<option value="' + json['result'][i]['Catalog'] + '">' + json['result'][i]['Description'] + '&nbsp;&nbsp;&nbsp;[' + json['result'][i]['model'] + '] &nbsp;&nbsp;&nbsp;Выпуск с ' + json['result'][i]['StartDate'] + ' по ' + json['result'][i]['EndDate'] + '</option>';
					}
					jQuery('select[name=\'cat\']').html(html);
					jQuery('select[name=\'mdl\']').html('');
					jQuery('select[name=\'clf\']').html('');
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
		jQuery('select[name=\'cat\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=mitsubishi&ajax=1&layout=ajax&route=catalog/mitsubishi/variants&area=' + encodeURIComponent(jQuery('select[name=\'carea\']').val())+'&cat=' + this.value,
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
						html += '<option value="' + json['result'][i]['Model'] + '">' + json['result'][i]['Model'] + ' - ' + json['result'][i]['Description'] + '</option>';
					}
					jQuery('select[name=\'mdl\']').html(html);
					jQuery('select[name=\'clf\']').html('');
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
		jQuery('select[name=\'mdl\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=mitsubishi&ajax=1&layout=ajax&route=catalog/mitsubishi/variants&area=' + encodeURIComponent(jQuery('select[name=\'carea\']').val()) + '&cat=' + encodeURIComponent(jQuery('select[name=\'cat\']').val()) + '&mdl=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'mdl\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html = '<option value=""></option>';
					if (json['result'])
					for (i = 0; i < json['result'].length; i++) {
						html += '<option value="' + json['result'][i]['Classification'] + '">' + json['result'][i]['Classification'] + ' - ' + json['result'][i]['Description'] + '</option>';
					}
					jQuery('select[name=\'clf\']').html(html);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

	});
	
	function decodevin() {
		jQuery.ajax({
			type: 'GET',
			url: 'index.php?option=com_details&Itemid=3&view=mitsubishi&ajax=1&layout=ajax&route=catalog/mitsubishi/variants&vin=' + encodeURIComponent(jQuery('input[name=\'VIN\']').val()),
			dataType: 'json',
			beforeSend: function() {
				jQuery('.success, .warning').remove();
				jQuery('#button-vin').attr('disabled', true);
			},
			complete: function() {
				jQuery('#button-vin').attr('disabled', false);
				jQuery('.attention').remove();
				jQuery('.wait').remove();
			},
			success: function(json) {
				jQuery('.success, .warning').remove();
				if (json['error']) {
					jQuery('#tab-vin').find('.form').after('<div class="warning">' + json['error'] + '</div>');
				}
				else {
					jQuery('input[name=\'VIN\']').prop('disabled', true);
					jQuery(location).attr('href','index.php?option=com_details&Itemid=3&view=mitsubishi&ajax=1&layout=ajax&route=catalog/mitsubishi&area=' + json['pn']['Area'] + '&cat=' + json['pn']['Catalog'] + '&mdl=' + json['pn']['Model'] + '&clf=' + json['pn']['Classification'] + '&vin=' + json['pn']['vin'] + '&cfg_id=1');
				}
			}
		});
	};
	
	function decodecfg() {
		url = '';
		val = jQuery('select[name=\'carea\']').val();
		if (val) url += '&area=' + encodeURIComponent(val);
		val = jQuery('select[name=\'cat\']').val();
		if (val) url += '&cat=' + encodeURIComponent(val);
		val = jQuery('select[name=\'mdl\']').val();
		if (val) url += '&mdl=' + encodeURIComponent(val);
		val = jQuery('select[name=\'clf\']').val();
		if (val) url += '&clf=' + encodeURIComponent(val);
		if (url) jQuery.ajax({
			type: 'GET',
			url: 'index.php?option=com_details&Itemid=3&view=mitsubishi&step=2&ajax=1&layout=ajax&route=catalog/mitsubishi/variants&cfg_id'+url,
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
					jQuery(location).attr('href','index.php?option=com_details&Itemid=3&view=mitsubishi&step=3&route=catalog/mitsubishi&cfg_id=1' + url);
				}
			}
		});
	}; 
</script>
<div id="result"><?php echo $this->data; ?></div>
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
			var url = 'index.php?option=com_details&view=mitsubishi&Itemid=<?php echo $this->Itemid; ?>&step=<?php echo $this->step+1; ?>&' + p;
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
				.css("display","block").attr("onclick","document.location='index.php?option=com_details&view=mitsubishi&Itemid=<?php echo $this->Itemid; ?>&step=<?php echo $this->step+1; ?>&"+p+"'");
			
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
	jQuery(document).ready(function(){
		jQuery("#result a img").remove();
		
		jQuery("#result table.list thead th:first-child").remove();
		jQuery("#result table.list thead th:last-child").remove();
		jQuery("#result table.list thead th:last-child").remove();
		jQuery("#result table.list tbody td:first-child").remove();
		jQuery("#result table.list tbody td:last-child").remove();
		jQuery("#result table.list tbody td:last-child").remove();
		
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

