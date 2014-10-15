<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
/*
$html = '<div class="wmcatnav">
			<div class="wmcatarrow wm_prev"></div>
			<div class="wmcatarrow wm_next"></div>
		</div>
		<div class="wmcatbody">
			<ul class="wmcat '.$moduleclass_sfx.'">';
if ($data) foreach($data as $c)
	{
		$html .= '<li id="'.$module->id.'_'.$c->category_id.'" rel="'.$c->category_description.'">
						<img src="components/com_virtuemart/shop_image/category/'.$c->category_full_image.'"><br>
						<span>'.$c->category_name.'</span>
					</li>';
	}
$html .= '	</ul>
		</div>';
	*/	
$html = '<div class="wmcatnav">
			<div class="wmcatarrow wm_prev"></div>
			<div class="wmcatarrow wm_next"></div>
		</div>
		<div class="wmcatbody">'.str_replace('wmcategory','',$data).'</div>';

echo $html;

?>
<script>
	var wm_countitem = '10';
	var wm_itemwidth = 0;
	var wm_left = 0;
	jQuery("document").ready(function(){
		wm_itemwidth = jQuery(".wmcat li").css("width").replace('px','');
		var wm_mainwidth = wm_itemwidth*wm_countitem;
		jQuery(".wmcat").css("width",wm_mainwidth);
		
		jQuery(".wm_prev").click(function(){
			wm_itemwidth = wm_itemwidth - 1 + 1;
			wm_left = wm_left - 1 + 1;
			wm_left = wm_left - wm_itemwidth;
			if (wm_left>=0) jQuery(".wmcat").animate({'left':-wm_left},800); else wm_left = 0;
		});
		jQuery(".wm_next").click(function(){
			wm_itemwidth = wm_itemwidth - 1 + 1;
			wm_left = wm_left - 1 + 1;
			wm_left = wm_left + wm_itemwidth;
			if (wm_left <= (wm_countitem-8)*wm_itemwidth) jQuery(".wmcat").animate({'left':-wm_left},800); else wm_left = (wm_countitem-8)*wm_itemwidth;
		});
		jQuery(".wmcatbody ul li").click(function(){
			var katalog = jQuery("#"+this.id).attr("rel");
			
			document.location = 'index.php?option=com_details&Itemid=3&view='+katalog;
		});
	});
</script>
<style>
.wmcatbody{
	position:relative;
	overflow:hidden;
	width:100%;
	height:90px;
}
.wmcat{
	display:block;
	position:absolute;
	left;0px;
	top:0px;
	z-inddex:1;
}
.wmcat li{
	margin:0 5px;
}
.wmcatnav{
	position:relative;
	width:100%;
}
.wmcatarrow{
	position:absolute;
	top:30px;
	width:20px;
	height:20px;
	z-index:2;
	cursor:pointer;
}
.wm_prev{
	background:url(images/sprait.png) center -22px no-repeat;
	left:-20px;
}
.wm_next{
	background:url(images/sprait.png) no-repeat;
	right:-20px;
}
</style>
