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
</style>
<h1>TOYOTA</h1>
<ul class="regionmenu">
	<li id="rm_li_J" onclick="setRegion('J')">Япония</li>
	<li id="rm_li_G" onclick="setRegion('G')">Ближний восток</li>
	<li id="rm_li_E" onclick="setRegion('E')">Европа</li>
	<li id="rm_li_U" onclick="setRegion('U')">США</li>
</ul>
<div id="active_carArea" style="display:none;"></div>
<div id="price"></div>

<div id="result"> </div>
<script>
	function setUrl(url)
		{
			showPreloader();
			jQuery.get(url,{},function(data){
				jQuery("#result").html(data);
				hidePreloader();
			})
		}
	function setRegion(carArea)
		{
			var url = 'http://yamato.kg/new/parsers/toyota/index2.php?carea='+carArea;
			var pageUrl = "parsers/toyota/index.php?step=2&carea="+carArea;
			
			jQuery("ul.regionmenu li").removeClass("active");
			jQuery("#rm_li_"+carArea).addClass("active");
			jQuery("#active_carArea").html(carArea);
			saveUrl(pageUrl);
			setUrl(pageUrl);
		}
</script>

