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
			var url = 'index.php?option=com_details&view=isuzu&Itemid=<?php echo $this->Itemid; ?>&step='+z+'&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
	});
	
	function decodecfg() {
		jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_details&Itemid=3&step=3&ajax=1&layout=ajax&view=mazda&route=catalog/mazda/variants&cat=' + encodeURIComponent(jQuery('select[name=\'cat\']').val()),
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
					document.location = 'index.php?option=com_details&Itemid=3&view=mazda&route=catalog/mazda&step=4&cat=' + json['id'];
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
	function select_items()
		{
		
		}
	function row_over()
		{
		
		}
	function row_out()
		{
		
		}
	jQuery(document).ready(function() {
		jQuery("scriptus").remove();
		
		jQuery("#result a.cat_article").each(function(){
			jQuery(this).removeAttr("href").removeAttr("target");
		});
		jQuery("#result a.cat_article").click(function(){
			jQuery(this).click(mainFind(jQuery(this).html()));
			jQuery('body,html').animate({scrollTop: 300}, 600);
		});
	});
</script>
<div id="result">
	<?php echo $this->data; ?>
</div>
<?php
					break;
				}
		}

?>

