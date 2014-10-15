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
#tab-vin{display:none;}
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
			var url = 'index.php?option=com_details&view=honda&Itemid=<?php echo $this->Itemid; ?>&step='+z+'&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
	});
	
	function decodecfg() {
		jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_details&Itemid=3&step=3&ajax=1&layout=ajax&view=honda&route=catalog/honda/variants&cat=' + encodeURIComponent(jQuery('select[name=\'cat\']').val()),
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
					document.location = 'index.php?option=com_details&Itemid=3&view=honda&route=catalog/honda&step=4&cat=' + json['id'];
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

	function decodevin() {
		jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_details&Itemid=3&view=honda&step=2&ajax=1&layout=ajax&route=catalog/honda/variants&vin=' + encodeURIComponent(jQuery('input[name=\'VIN\']').val()),
			dataType: 'json',
			beforeSend: function() {
				jQuery('.success, .warning').remove();
				jQuery('#button-vin').attr('disabled', true);
				jQuery('select[name=\'carea1\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
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
					html = '';
					for (i = 0; i < json['hmodtypes'].length; i++) {
						html += '<option value="' + json['hmodtypes'][i]['carea'] + '">' + json['hmodtypes'][i]['carea'] + '</option>';
					}
					jQuery('select[name=\'carea1\']').html(html);
					jQuery('select[name=\'carea1\']').val('KG').trigger("change");
				}
			}
		});
	};

	jQuery(document).ready(function() {
		jQuery("scriptus").remove();
		
		jQuery('select[name=\'cmodnamepc\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=honda&step=2&ajax=1&layout=ajax&route=catalog/honda/variants&cmodnamepc=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'cmodnamepc\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait').remove();
				},
				success: function(json) {
					html1 = '';
					html2 = '';
					html3 = '';
					html4 = '';
					html5 = '';
					html6 = '';
					for (i = 0; i < json['xcardrs'].length; i++) {
						html1 += '<option value="' + json['xcardrs'][i] + '">' + json['xcardrs'][i] + '</option>';
					}
					for (i = 0; i < json['dmodyr'].length; i++) {
						html2 += '<option value="' + json['dmodyr'][i] + '">' + json['dmodyr'][i] + '</option>';
					}
					for (i = 0; i < json['carea'].length; i++) {
						html3 += '<option value="' + json['carea'][i] + '">' + json['carea'][i] + '</option>';
					}
					for (i = 0; i < json['ctrsmtyp'].length; i++) {
						html4 += '<option value="' + json['ctrsmtyp'][i] + '">' + json['ctrsmtyp'][i] + '</option>';
					}
					for (i = 0; i < json['xgrade'].length; i++) {
						html5 += '<option value="' + json['xgrade'][i] + '">' + json['xgrade'][i] + '</option>';
					}
					for (i = 0; i < json['equip'].length; i++) {
						html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
					}
					jQuery('select[name=\'xcardrs\']').html(html1).trigger("change");
					jQuery('select[name=\'dmodyr\']').html(html2).trigger("change");
					jQuery('select[name=\'carea\']').html(html3).trigger("change");
					jQuery('select[name=\'ctrsmtyp\']').html(html4);
					jQuery('select[name=\'xgrade\']').html(html5);
					jQuery("#equip").html(html6).trigger("change");
					jQuery('#button-filter').attr('href', 'index.php?option=com_details&Itemid=3&view=honda&step=3&route=catalog/honda&hmodtyp=' + json['hmodtypes']);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
		jQuery('select[name=\'xcardrs\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=honda&step=2&ajax=1&layout=ajax&route=catalog/honda/variants&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'xcardrs\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait').remove();
				},
				success: function(json) {
					html2 = '';
					html3 = '';
					html4 = '';
					html5 = '';
					html6 = '';
					for (i = 0; i < json['dmodyr'].length; i++) {
						html2 += '<option value="' + json['dmodyr'][i] + '">' + json['dmodyr'][i] + '</option>';
					}
					for (i = 0; i < json['carea'].length; i++) {
						html3 += '<option value="' + json['carea'][i] + '">' + json['carea'][i] + '</option>';
					}
					for (i = 0; i < json['ctrsmtyp'].length; i++) {
						html4 += '<option value="' + json['ctrsmtyp'][i] + '">' + json['ctrsmtyp'][i] + '</option>';
					}
					for (i = 0; i < json['xgrade'].length; i++) {
						html5 += '<option value="' + json['xgrade'][i] + '">' + json['xgrade'][i] + '</option>';
					}
					for (i = 0; i < json['equip'].length; i++) {
						html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
					}
					jQuery('select[name=\'dmodyr\']').html(html2).trigger("change");
					jQuery('select[name=\'carea\']').html(html3).trigger("change");
					jQuery('select[name=\'ctrsmtyp\']').html(html4);
					jQuery('select[name=\'xgrade\']').html(html5);
					jQuery("#equip").html(html6)
					jQuery('#button-filter').attr('href', 'index.php?option=com_details&Itemid=3&view=honda&step=3&route=catalog/honda&hmodtyp=' + json['hmodtypes']);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		jQuery('select[name=\'dmodyr\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=honda&step=2&ajax=1&layout=ajax&route=catalog/honda/variants&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'dmodyr\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait').remove();
				},
				success: function(json) {
					html3 = '';
					html4 = '';
					html5 = '';
					html6 = '';
					for (i = 0; i < json['carea'].length; i++) {
						html3 += '<option value="' + json['carea'][i] + '">' + json['carea'][i] + '</option>';
					}
					for (i = 0; i < json['ctrsmtyp'].length; i++) {
						html4 += '<option value="' + json['ctrsmtyp'][i] + '">' + json['ctrsmtyp'][i] + '</option>';
					}
					for (i = 0; i < json['xgrade'].length; i++) {
						html5 += '<option value="' + json['xgrade'][i] + '">' + json['xgrade'][i] + '</option>';
					}
					for (i = 0; i < json['equip'].length; i++) {
						html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
					}
					jQuery('select[name=\'carea\']').html(html3).trigger("change");
					jQuery('select[name=\'ctrsmtyp\']').html(html4);
					jQuery('select[name=\'xgrade\']').html(html5);
					jQuery("#equip").html(html6)
					jQuery('#button-filter').attr('href', 'index.php?option=com_details&Itemid=3&view=honda&step=3&route=catalog/honda&hmodtyp=' + json['hmodtypes']);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		jQuery('select[name=\'carea\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=honda&step=2&ajax=1&layout=ajax&route=catalog/honda/variants&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'carea\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait').remove();
				},
				success: function(json) {
					html4 = '';
					html5 = '';
					html6 = '';
					for (i = 0; i < json['ctrsmtyp'].length; i++) {
						html4 += '<option value="' + json['ctrsmtyp'][i] + '">' + json['ctrsmtyp'][i] + '</option>';
					}
					for (i = 0; i < json['xgrade'].length; i++) {
						html5 += '<option value="' + json['xgrade'][i] + '">' + json['xgrade'][i] + '</option>';
					}
					for (i = 0; i < json['equip'].length; i++) {
						html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
					}
					jQuery('select[name=\'ctrsmtyp\']').html(html4);
					jQuery('select[name=\'xgrade\']').html(html5);
					jQuery("#equip").html(html6)
					jQuery('#button-filter').attr('href', 'index.php?option=com_details&Itemid=3&view=honda&step=3&route=catalog/honda&hmodtyp=' + json['hmodtypes'] + '&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' + encodeURIComponent(jQuery('select[name=\'carea\']').val()) );
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
		jQuery('select[name=\'ctrsmtyp\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=honda&step=2&ajax=1&layout=ajax&route=catalog/honda/variants&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' +
					encodeURIComponent(jQuery('select[name=\'carea\']').val()) + (jQuery('select[name=\'xgrade\']').val() != ''?'&xgrade=' + encodeURIComponent(jQuery('select[name=\'xgrade\']').val()):'') + '&ctrsmtyp=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'ctrsmtyp\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait').remove();
				},
				success: function(json) {
					html5 = '';
					html6 = '';
					for (i = 0; i < json['xgrade'].length; i++) {
						html5 += '<option value="' + json['xgrade'][i] + '"' + (jQuery('select[name=\'xgrade\']').val() == json['xgrade'][i]?' selected ':'') + '>' + json['xgrade'][i] + '</option>';
					}
					for (i = 0; i < json['equip'].length; i++) {
						html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
					}
					jQuery('select[name=\'xgrade\']').html(html5);
					jQuery("#equip").html(html6)
					jQuery('#button-filter').attr('href', 'index.php?option=com_details&Itemid=3&view=honda&step=3&route=catalog/honda&hmodtyp=' + json['hmodtypes'] + '&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' + encodeURIComponent(jQuery('select[name=\'carea\']').val()) + (jQuery('select[name=\'ctrsmtyp\']').val() != ''?'&ctrsmtyp=' + encodeURIComponent(jQuery('select[name=\'ctrsmtyp\']').val()):'') + (jQuery('select[name=\'xgrade\']').val() != ''?'&xgrade=' + encodeURIComponent(jQuery('select[name=\'xgrade\']').val()):'') );
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		jQuery('select[name=\'xgrade\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=honda&step=2&ajax=1&layout=ajax&route=catalog/honda/variants&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' +
					encodeURIComponent(jQuery('select[name=\'carea\']').val()) + (jQuery('select[name=\'ctrsmtyp\']').val() != ''?'&ctrsmtyp=' + encodeURIComponent(jQuery('select[name=\'ctrsmtyp\']').val()):'') + '&xgrade=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'xgrade\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait').remove();
				},
				success: function(json) {
					html5 = '';
					html6 = '';
					for (i = 0; i < json['ctrsmtyp'].length; i++) {
						html5 += '<option value="' + json['ctrsmtyp'][i] + '"' + (jQuery('select[name=\'ctrsmtyp\']').val() == json['ctrsmtyp'][i]?' selected ':'') + '>' + json['ctrsmtyp'][i] + '</option>';
					}
					for (i = 0; i < json['equip'].length; i++) {
						html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
					}
					jQuery('select[name=\'ctrsmtyp\']').html(html5);
					jQuery("#equip").html(html6)
					jQuery('#button-filter').attr('href', 'index.php?option=com_details&Itemid=3&view=honda&step=3&route=catalog/honda&hmodtyp=' + json['hmodtypes'] + '&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' + encodeURIComponent(jQuery('select[name=\'carea\']').val()) + (jQuery('select[name=\'ctrsmtyp\']').val() != ''?'&ctrsmtyp=' + encodeURIComponent(jQuery('select[name=\'ctrsmtyp\']').val()):'') + (jQuery('select[name=\'xgrade\']').val() != ''?'&xgrade=' + encodeURIComponent(jQuery('select[name=\'xgrade\']').val()):'') );
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
		jQuery('select[name=\'carea1\']').bind('change', function() {
			jQuery.ajax({
				url: 'index.php?option=com_details&Itemid=3&view=honda&step=2&ajax=1&layout=ajax&route=catalog/honda/variants&vin=' + encodeURIComponent(jQuery('input[name=\'VIN\']').val()) + '&carea=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'carea1\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait').remove();
				},
				success: function(json) {
					html = '';
					for (i = 0; i < json['equip'].length; i++) {
					html += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
					}
					jQuery("#equip1").html(html);
					jQuery('#button-vin').attr('href', 'index.php?option=com_details&Itemid=3&view=honda&step=3&route=catalog/honda&hmodtyp=' + json['hmodtypes'][0]['hmodtyp'] + '&cmodnamepc=' + json['hmodtypes'][0]['cmodnamepc'] + '&xcardr=' + json['hmodtypes'][0]['xcardrs'] + '&dmodyr=' + json['hmodtypes'][0]['dmodyr'] + '&carea=' + json['hmodtypes'][0]['carea'] + '&ctrsmtyp=' + json['hmodtypes'][0]['ctrsmtyp'] + '&xgrade=' + json['hmodtypes'][0]['xgradefulnam']);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}); 
	});
</script>
<div id="result">
	<?php echo $this->data; ?>
</div>
<?php
					break;
				}
			case 2:
				{
					echo $this->data; 
					break;
				}
			case 3:
			case 4:
				{
?>
<script>
	jQuery(document).ready(function() {
		
		jQuery("scriptus").remove();
		jQuery("#header").remove();
		
		jQuery('#result a').each(function(i,elem) {
			var params = jQuery(this).attr('href');
			var mas = new Array();
			mas = params.split('?');
			var p = mas[1];
			var url = 'index.php?option=com_details&view=honda&Itemid=<?php echo $this->Itemid; ?>&step=<?php echo $this->step+1; ?>&' + p;
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
	jQuery(document).ready(function(){
		jQuery("scriptus").remove();
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
		
		jQuery("img[usemap=#hotspots]").before('<div style="position:relative;"><div id="mapborder" style="cursor:pointer;position:absolute;border:solid 1px red;"></div></div>');
		
		jQuery("map[name=hotspots] area").mouseover(function(){
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
</script>	
<div id="result"><?php echo $this->data; ?></select></div>
<?php
					break;
				}
		}

?>

