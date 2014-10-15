<html>
<head>
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
			setUrl("parsers/hyundai/index.php?fromchanged=true");
		});

	</script>
</head>
<body>
<h1>HYUNDAI</h1>
<div id="price"></div>

<div id="result"> </div>
</body>
</html>
