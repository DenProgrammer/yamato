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
tr.row:hover{
	background:blue;
	color:#fff;
	cursor:pointer;
}
</style>
<h1>SUZUKI</h1>
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
			var url = 'index.php?option=com_details&view=mazda&Itemid=<?php echo $this->Itemid; ?>&step='+z+'&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
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
<div id="result"><?php echo $this->data; ?></div>
<?php
					break;
				}
			case 2:
				{
?>
<script>
	jQuery(document).ready(function() {
		
		jQuery("#scriptus").remove();
		
		jQuery('a.cat_article').each(function(i,elem) {
			jQuery(this).removeAttr("href").removeAttr("target");
		});
		jQuery('a.cat_article').click(function() {
			var detailCode = jQuery(this).html();
			mainFind(detailCode);
			jQuery('body,html').animate({scrollTop: 300}, 600);
		});
		
		jQuery('td[height="1%"]').hide();
	});
</script>	
<div id="result"><?php echo $this->data; ?></div>
<?php
					break;
				}
		}

?>

