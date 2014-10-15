<?php
	//nissan
    header ("Content-Type: text/html; charset=utf-8");
	include("../../configuration.php");
	include('../dictionary_details_function.php');
	
	$CountryID = '82'; //KZ = 82 / CountryID const
   
	$url = 'http://japancars.ru/index.php';
	$step = $_GET['step'];
	$get = '?';$sep = '';
	foreach($_GET as $k=>$v)
		{
			$get .= $sep.$k.'='.$v;
			$sep = '&';
		}
	$url .= $get;
	$post = '';
	foreach($_POST as $k=>$v)
		{
			$post .= '&'.$k.'='.$v;
		}
	
    $ch = curl_init();
	//if ($step == 2) $url = 'http://japancars.ru/index.php?route=catalog/nissan/variants&mdl=121';
	//echo $url.'<br>';
	
	
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
    curl_setopt($ch, CURLOPT_POST, 100); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 

    $result = curl_exec($ch); // run the whole process
	
    if($result === FALSE){
            echo "cURL error: ".curl_error($ch);
    }

    curl_close($ch);
	
	switch($step)
		{
			case 1:
				{
?>
<script>
	jQuery("document").ready(function(){
		jQuery("scriptus").remove()
		jQuery("#result a").attr("href","#");
		
		jQuery('select[name=\'carea\']').bind('change', function() {
			jQuery.ajax({
				url: 'parsers/nissan/index.php?route=catalog/nissan/variants&step=2&carea=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'carea\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html1 = '<option value=""></option>';
					if (json['cdindex'])
						for (i = 0; i < json['cdindex'].length; i++) {
							html1 += '<option value="' + i + '">' + json['cdindex'][i]['ModelName'] + '&nbsp;&nbsp;&nbsp;[' + json['cdindex'][i]['ModelSeries'] + ']' + ' &nbsp;&nbsp;&nbsp;Выпуск с ' + json['cdindex'][i]['frm'] + ' по ' + json['cdindex'][i]['upto'] + '</option>';
						}
					jQuery("tr[id^='var_cb']").remove();
					jQuery('select[name=\'model\']').html(html1);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
		jQuery('select[name=\'model\']').bind('change', function() {
			jQuery.ajax({
				url: 'parsers/nissan/index.php?route=catalog/nissan/variants&step=2&carea=' + encodeURIComponent(jQuery('select[name=\'carea\']').val())+'&mdl=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'model\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html = '';
					if (json['var'])
						for (i = 0; i < json['var'].length; i++) {
							html += '<tr id="var_cb'+ i + '"><td>' + json['var'][i]['name'] + '</td>';
							html += '<td><select name="cb' + i + '">';
							// html += '<option value="">Все</option>';
							for (j = 0; j < json['var'][i]['list'].length; j++)
								html += '<option value="' + json['var'][i]['list'][j]['variation'] + '"' + (json['var'][i]['list'].length==1?' selected ':'') + '>' + json['var'][i]['list'][j]['description'] + '</option>';
							html += '</select></td><td></td>';
						}
					jQuery("tr[id^='var_cb']").remove();
					jQuery('#var_mdl').after(html);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
	});
</script>	
<?php	
					$st = strpos($result,'<div id="content">');
					$ed = strpos($result,'<div id="footer">');
					$result = substr($result, $st, $ed - $st);

					$arr1 = array('<script','</script>');
					$arr2 = array('<scriptus','</scriptus>');
					$result = str_replace($arr1,$arr2,$result);
				}
			case 2:
				{
					break;
				}
			case 3:
			case 4:
				{
?>
<script>
	jQuery("document").ready(function(){
		jQuery("scriptus").remove();
		jQuery("#result a").click(function(){
			var hr = jQuery(this).attr("hrf");
			var arr = new Array();
			arr = hr.split('?');
			var url = arr[1];
			setUrl('parsers/nissan/index.php?step=<?php echo $step+1; ?>&'+url);
			saveUrl('parsers/nissan/index.php?step=<?php echo $step+1; ?>&'+url);
		});
		
	});
</script>	
<?php
					$st = strpos($result,'<div id="tab-model-info">');
					$ed = strpos($result,'<div id="footer">');
					$result = substr($result, $st, $ed - $st);

					$arr1 = array('<script','</script>','href');
					$arr2 = array('<scriptus','</scriptus>','hrf');
					$result = str_replace($arr1,$arr2,$result);
					break;
				}
			case 5:
				{
?>
<script>
	jQuery("document").ready(function(){
		jQuery("scriptus").remove();
		
		jQuery("#result table.list tr th:last-child").remove();
		jQuery("#result table.list tr th:last-child").remove();
		jQuery("#result table.list tr td:last-child").remove();
		jQuery("#result table.list tr td:last-child").remove();
		jQuery('table.list tbody tr').click(function() {
			var id = this.id;
			
			jQuery("#"+id+" td").each(function(i,elem){
				if (i==2) 
					{
						detailCode = jQuery(this).html();
						parentMainFind(detailCode);
					}
			});
			
			jQuery('body,html').animate({scrollTop: 300}, 600);
		});
		
		jQuery.fn.tabs = function() {
			var selector = this;
			this.each(function() {
				var obj = $(this);
				jQuery(obj.attr('href')).hide();
				jQuery(obj).click(function() {
					jQuery(selector).removeClass('selected');
					jQuery(selector).each(function(i, element) {
						jQuery(jQuery(element).attr('href')).hide();
					});
					jQuery(this).addClass('selected');
					jQuery(jQuery(this).attr('href')).fadeIn();
					return false;
				});
			});
			jQuery(this).show();
			jQuery(this).first().click();
		};
	});
</script>	
<?php
					$st = strpos($result,'<div id="tab-model-info">');
					$ed = strpos($result,'<div id="footer">');
					$result = substr($result, $st, $ed - $st);

					$arr1 = array('<script','</script>','src="');
					$arr2 = array('<scriptus','</scriptus>','src="http://japancars.ru');
					$result = str_replace($arr1,$arr2,$result);
					break;
				}
		}
	
	echo $result;
?>

	
	

    