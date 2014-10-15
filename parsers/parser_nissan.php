<style>
a {
        color: #000000;
        font-family: Arial,Helvetica,sans-serif;
        font-size: 12px;
        text-decoration: none;
}
#tab-vin,#content h1,#htabs,#epc-g{display:none;}
</style>
<h1>NISSAN</h1>
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
		setUrl("parsers/nissan/index.php?step=1&route=catalog/nissan");
	});
	
	function decodecfg() {
		url = '';
		val = jQuery('select[name=\'carea\']').val();
		if (val) url += '&carea=' + encodeURIComponent(val);
		val = jQuery('select[name=\'model\']').val();
		if (val) url += '&mdl=' + encodeURIComponent(val);
		val = jQuery('select[name=\'cb0\']').val();
		if (val) url += '&cb1=' + encodeURIComponent(val);
		val = jQuery('select[name=\'cb1\']').val();
		if (val) url += '&cb2=' + encodeURIComponent(val);
		val = jQuery('select[name=\'cb2\']').val();
		if (val) url += '&cb3=' + encodeURIComponent(val);
		val = jQuery('select[name=\'cb3\']').val();
		if (val) url += '&cb4=' + encodeURIComponent(val);
		val = jQuery('select[name=\'cb4\']').val();
		if (val) url += '&cb5=' + encodeURIComponent(val);
		val = jQuery('select[name=\'cb5\']').val();
		if (val) url += '&cb6=' + encodeURIComponent(val);
		val = jQuery('select[name=\'cb6\']').val();
		if (val) url += '&cb7=' + encodeURIComponent(val);
		val = jQuery('select[name=\'cb7\']').val();
		if (val) url += '&cb8=' + encodeURIComponent(val);
		if (url) jQuery.ajax({
				type: 'POST',
				url: 'parsers/nissan/index.php?route=catalog/nissan/variants&step=2&cfg_id'+url,
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
						var sendurl = 'parsers/nissan/index.php?route=catalog/nissan&step=3&ext=' + json['pn']['ext'] +'&cfg_id=' + json['pn']['posname_no'] + '&cat=' + json['pn']['idx'];
						saveUrl(sendurl);
						setUrl(sendurl);
					}
				}
			});
	}; 
</script>
