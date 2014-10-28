<style>
a {
        color: #000000;
        font-family: Arial,Helvetica,sans-serif;
        font-size: 12px;
        text-decoration: none;
}
</style>
<h1>SUZUKI</h1>
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
			mainFind(str);
		}
	function parentSaveUrl(url)
		{
			saveUrl(url);
		}
	jQuery(document).ready(function() {
		setUrl("parsers/suzuki/index.php?step=1");
	});
</script>
