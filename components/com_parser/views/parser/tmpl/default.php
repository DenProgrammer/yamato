<?php defined('_JEXEC') or die('Restricted access'); ?>
<script>
	jQuery("document").ready(function(){
	
		jQuery.get('parser.php',{},function(data){
			jQuery("#dataupload").html(data);
			hidePreloader();
		})
	
	});
</script>
<div id="dataupload">

</div>