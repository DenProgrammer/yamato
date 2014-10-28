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
div.coord:hover{
	border-color:red !important;
	cursor:pointer;
}
tr.over{
	cursor:pointer;
}
tr.page td a {
    background-image: url(_sysimg/big_catalog2/o2.gif);
    background-position: left top;
    background-repeat: no-repeat;
    color: #282828;
    display: block;
    font-weight: bold;
    height: 23px;
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    width: 59px;
}
tr.page td a.select{
	background-position: left bottom;
    color: #006FA4;
}
.over_td {
    cursor: pointer;
}
li.model {
    border: 2px solid #000000;
    float: left;
    height: 120px;
    list-style: none outside none;
    overflow: hidden;
    width: 135px;
}
li.model div.img {
    height: 81px;
    overflow: hidden;
    width: 107px;
}
.table2{
	/*display:none;*/
}
</style>
<h1>HYUNDAI</h1>
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
			var url = 'index.php?option=com_details&view=hyundai&Itemid=<?php echo $this->Itemid; ?>&step='+z+'&' + p;
			if (mas[1]) jQuery(this).attr('href',url);
		});
		
		jQuery("#search_text").keyup(function(){
			var s = jQuery('#search_text').attr('value');
			s = s.toUpperCase();
			jQuery('li.model').each(function(i,el){
				var title = jQuery(this).find("div[name=title]").html();
				title = title.toUpperCase();
				
				if (title.indexOf(s)!=-1) 
					{
						jQuery(this).css("display","");
					}
				else
					{
						jQuery(this).css("display","none");
					}
			});
		})
	});
	
	function HMset(id)
		{
			document.location = 'index.php?option=com_details&Itemid=3&view=hyundai&l='+id;
		}
	function articleRow(detailCode)
		{
			mainFind(detailCode);
			jQuery('body,html').animate({scrollTop: 300}, 600);
		}
	function goToCalloutRow()
		{
		
		}
</script>
<?php
	echo $this->data; 
?>

