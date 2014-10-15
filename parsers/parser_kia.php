<style>
a {
        color: #000000;
        font-family: Arial,Helvetica,sans-serif;
        font-size: 12px;
        text-decoration: none;
}
#tab-vin,#content h1,#htabs,#epc-g{display:none;}
</style>
<h1>KIA</h1>
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
	function parentMainFind(str)
		{
			//alert(str);
			mainFind(str);
		}
	function parentSaveUrl(url)
		{
			saveUrl(url);
		}
	jQuery(document).ready(function() {
		setUrl("parsers/kia/index.php?step=1&route=catalog/kia");
	});
	function decodecfg() {
			url = 'parsers/kia/index.php?route=catalog/kia&step=3';
			val = jQuery('select[name=\'carea\']').val();
			url += '&area=' + encodeURIComponent(val);
			val = jQuery('select[name=\'cat\']').val();
			url += '&cat=' + encodeURIComponent(val);
			val = jQuery('select[name=\'clf\']').val();
			url += '&clf=' + encodeURIComponent(val);
			
			saveUrl(url);
			setUrl(url);
		}
</script>
