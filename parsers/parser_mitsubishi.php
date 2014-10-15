<style>
	a {
		color: #000000;
		font-family: Arial,Helvetica,sans-serif;
		font-size: 12px;
		text-decoration: none;
	}
</style>
<h1>MITSUBISHI</h1>
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
	jQuery(document).ready(function() {
		jQuery.ajax({
			type: "POST",
			url: "parsers/mitsubishi/index.php",
			async: true,
			data: { step: "1" }
			}).done(function(data) {
				jQuery("#result").html(data);
		});
	});
</script>

