<style>
	a {
		color: #000000;
		font-family: Arial,Helvetica,sans-serif;
		font-size: 12px;
		text-decoration: none;
	}
	#tab-vin,#button-filter,#content h1,#htabs,#epc-g{display:none;}
</style>
<h1>MAZDA</h1>
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
		setUrl("parsers/mazda/index.php?step=1&route=catalog/mazda");
	});
	
	function decodecfg() {
		jQuery.ajax({
			type: 'POST',
			url: 'parsers/mazda/index.php?route=catalog/mazda/variants&cat=' + encodeURIComponent(jQuery('select[name=\'cat\']').val()),
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
					saveUrl('parsers/mazda/index.php?route=catalog/mazda&step=3&cat=' + json['id']);
					setUrl('parsers/mazda/index.php?route=catalog/mazda&step=3&cat=' + json['id']);
				}
			}
		});
	}

</script>




