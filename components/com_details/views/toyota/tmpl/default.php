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
#result ul li{
	font:bold 18px Arial;
}
#result ul li:hover,#result ul li:hover a{
	color:red;
}
</style>
<h1>TOYOTA</h1>
<ul class="regionmenu">
	<li id="rm_li_J" <?php if ($this->carea == 'J') echo 'class="active"'; ?> onclick="setRegion('J')">Япония</li>
	<li id="rm_li_G" <?php if ($this->carea == 'G') echo 'class="active"'; ?> onclick="setRegion('G')">Ближний восток</li>
	<li id="rm_li_E" <?php if ($this->carea == 'E') echo 'class="active"'; ?> onclick="setRegion('E')">Европа</li>
	<li id="rm_li_U" <?php if ($this->carea == 'U') echo 'class="active"'; ?> onclick="setRegion('U')">США</li>
</ul>
<div id="price"></div>

<script>
	function setRegion(carArea)
		{
			var url = 'index.php?option=com_details&view=toyota&Itemid=<?php echo $this->Itemid; ?>&step=2&carea='+carArea;
			document.location = url;
		}
	jQuery(document).ready(function(){
		jQuery("#result").css("cursor","pointer");
		
	});
</script>
<?php
	
	switch($this->step)
		{
			case 2:
				{
					$select = '';
					$s = strpos($this->data,'<select class=text name="mdl">');
					$e = strpos($this->data,'</select>',$s);
					$select = substr($this->data,$s, $e-$s);
?>
<script>	
	jQuery(document).ready(function() {
		jQuery("input[name='frame1']").parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().hide();
		jQuery("scriptus").remove();
		
		jQuery('select[name=mdl]').change(function() {
			var carArea = '<?php echo $this->carea; ?>';
			var carModel = jQuery('select[name=mdl] option:selected').val();
			
			var url = "index.php?option=com_details&view=toyota&Itemid=<?php echo $this->Itemid; ?>&step=3&carea="+carArea+"&cat="+carModel;
			document.location = url;
		});
				
	});
</script>
<div id="result"><?php echo $select; ?></select></div>
<?php
					break;
				}
			case 3:
				{
?>
<script>
	jQuery(document).ready(function() {
		jQuery("scriptus").remove();
		
		jQuery("#result table tr:first-child th").attr("bgcolor","#c3c3c3");
		jQuery("table").attr("width","100%");
		jQuery("td[width='1%']").attr("width","100%");
		
		jQuery('#result a').each(function(i,elem) {
			var params = jQuery(this).attr('href');
			var mas = new Array();
			mas = params.split('?');
			var p = mas[1];
			var url = 'index.php?option=com_details&view=toyota&Itemid=<?php echo $this->Itemid; ?>&step=4&carea=<?php echo $this->carea; ?>&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
		
		jQuery('td[height="1%"]').hide();
	});
</script>	
<div id="result"><?php echo $this->data; ?></select></div></div></td></tr></table>
<?php
					break;
				}
			case 4:
				{
?>
<script>
	jQuery(document).ready(function() {
		
		jQuery("scriptus").remove();
		jQuery("#result table tr:first-child th").attr("bgcolor","#c3c3c3");
		jQuery("table").attr("width","100%");
		jQuery("td[width='1%']").attr("width","100%");
		
		jQuery('#result a').each(function(i,elem) {
			var params = jQuery(this).attr('href');
			var mas = new Array();
			mas = params.split('?');
			var p = mas[1];
			var url = 'index.php?option=com_details&view=toyota&Itemid=<?php echo $this->Itemid; ?>&step=5&carea=<?php echo $this->carea; ?>&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
		
		jQuery('td[height="1%"]').hide();
	});
</script>	
<div id="result"><?php echo $this->data; ?></select></div>
<?php
					break;
				}
			case 5:
				{
?>
<script>
	jQuery(document).ready(function() {
		
		jQuery("scriptus").remove();
		jQuery("#result table tr:first-child th").attr("bgcolor","#c3c3c3");
		jQuery("table").attr("width","100%");
		jQuery("td[width='1%']").attr("width","100%");
		
		jQuery('#result a').each(function(i,elem) {
			var params = jQuery(this).attr('href');
			var mas = new Array();
			mas = params.split('?');
			var p = mas[1];
			var url = 'index.php?option=com_details&view=toyota&Itemid=<?php echo $this->Itemid; ?>&step=6&carea=<?php echo $this->carea; ?>&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
		
		jQuery('#result area').each(function(i,elem) {
			var params = jQuery(this).attr('href');
			var mas = new Array();
			mas = params.split('?');
			var p = mas[1];
			var url = 'index.php?option=com_details&view=toyota&Itemid=<?php echo $this->Itemid; ?>&step=6&carea=<?php echo $this->carea; ?>&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
		
		jQuery('td[height="1%"]').hide();
		
		jQuery("map[name=HotspotsA10]").after('<div style="position:relative;"><div class="mapborder" style="cursor:pointer;position:absolute;border:solid 1px red;"></div></div>');
		jQuery("map[name=HotspotsA00]").after('<div style="position:relative;"><div class="mapborder" style="cursor:pointer;position:absolute;border:solid 1px red;"></div></div>');
		
		jQuery("map[name=HotspotsA10] area").mouseover(function(){
			var coords = jQuery(this).attr('coords');
			var href = jQuery(this).attr('href');
			var mas = coords.split(',');
			
			var x1 = mas[0];
			var y1 = mas[1];
			var x2 = mas[2];
			var y2 = mas[3];
			
			var width = x2 - x1;
			var height = y2 - y1;
			
			jQuery(".mapborder").css("width",width).css("height",height)
				.css("left",x1+"px").css("top",y1+"px")
				.css("display","block").attr("onclick","document.location='"+href+"'");
			
		});
		jQuery("map[name=HotspotsA00] area").mouseover(function(){
			var coords = jQuery(this).attr('coords');
			var href = jQuery(this).attr('href');
			var mas = coords.split(',');
			
			var x1 = mas[0];
			var y1 = mas[1];
			var x2 = mas[2];
			var y2 = mas[3];
			
			var width = x2 - x1;
			var height = y2 - y1;
			
			jQuery(".mapborder").css("width",width).css("height",height)
				.css("left",x1+"px").css("top",y1+"px")
				.css("display","block").attr("onclick","document.location='"+href+"'");
			
		});
		jQuery(".mapborder").mouseout(function(){
			jQuery(".mapborder").css("display","none");
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
	function rollout(oId)
		{
			var detailCode = jQuery("div #d" + oId +" nobr b").html();
			mainFind(detailCode);
			jQuery('body,html').animate({scrollTop: 300}, 600);
		}
	jQuery(document).ready(function(){
		jQuery("scriptus").remove();
		jQuery("#result a img").remove();
		
		jQuery("img[usemap=#Hotspots0]").before('<div style="position:relative;"><div id="mapborder" style="cursor:pointer;position:absolute;border:solid 1px red;"></div></div>');
		
		jQuery("map[name=Hotspots0] area").mouseover(function(){
			var coords = jQuery(this).attr('coords');
			var href = jQuery(this).attr('onclick');
			var mas = coords.split(',');
			
			var x1 = mas[0];
			var y1 = mas[1];
			var x2 = mas[2];
			var y2 = mas[3];
			
			var width = x2 - x1;
			var height = y2 - y1;
			
			jQuery("#mapborder").css("width",width).css("height",height)
				.css("left",(x1-1+1+5)+"px").css("top",y1+"px")
				.css("display","block").attr("onclick",href);
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

