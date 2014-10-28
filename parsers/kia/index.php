<?php
    header ("Content-Type: text/html; charset=utf-8");
	
	$katalog = 'kia';
	
	function clearText($result)
		{
			global $katalog;
			$result = str_replace('src="images', 'src="parsers/'.$katalog.'/images/', $result);
			$result = str_ireplace('submit', 'button', $result);
			$result = str_ireplace('onChange', 'onch', $result);
			
			$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">','src="image.php');
			$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','typ="tecss">','src="http://old.japancars.ru/cat/'.$katalog.'/image.php');
		   
			$result = str_replace($arr1,$arr2,$result);
			
			return $result;
		}

	if($_GET['step']>0) $step = $_GET['step']; else	$step = 1;
	
	$sep = '?';
	foreach($_GET as $k=>$v)
		{
			$get .= $sep.$k.'='.$v;
			$sep = '&';
		}
	$sep = '?';
	foreach($_POST as $k=>$v)
		{
			$post .= $sep.$k.'='.$v;
			$sep = '&';
		}

    $ch = curl_init();
	
	$url = "http://japancars.ru/index.php$get";
	//if ($step != 2) echo 'step = '.$step.'; url = '.$url.'<br>';
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
    curl_setopt($ch, CURLOPT_POST, 100); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    $result = curl_exec($ch); // run the whole process

    if($result === FALSE) echo "cURL error: ".curl_error($ch);

    curl_close($ch);

	switch($step)
		{
			case 1:
				{
					$st = strpos($result,'<div id="content">');
					$ed = strpos($result,'<div id="footer">');
					$result = substr($result, $st, $ed - $st);

					$arr1 = array('<script','</script>','href');
					$arr2 = array('<scriptus','</scriptus>','hrf');
					$result = str_replace($arr1,$arr2,$result);
?>
<script>	
	jQuery("document").ready(function(){
		jQuery("scriptus").remove()
		
		jQuery('select[name=\'carea\']').bind('change', function() {
			jQuery.ajax({
				url: 'parsers/kia/index.php?step=2&route=catalog/kia/variants&area=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'carea\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html = '<option value=""></option>';
					if (json['result'])
					for (i = 0; i < json['result'].length; i++) {
						html += '<option value="' + json['result'][i]['CMBPNO'] + '">' + json['result'][i]['CMSGDS'] + '&nbsp;&nbsp;&nbsp;' + json['result'][i]['CMCRNM'] + ' &nbsp;&nbsp;&nbsp;Выпуск с ' + json['result'][i]['StartDate'] + ' по ' + json['result'][i]['EndDate'] + '</option>';
					}
					jQuery('select[name=\'cat\']').html(html);
					jQuery('select[name=\'clf\']').html('');
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		jQuery('select[name=\'cat\']').bind('change', function() {
			jQuery.ajax({
				url: 'parsers/kia/index.php?step=2&route=catalog/kia/variants&area=' + encodeURIComponent(jQuery('select[name=\'carea\']').val())+'&cat=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'cat\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html = '';
					if (json['result'])
					for (i = 0; i < json['result'].length; i++) {
						html += '<option value="' + json['result'][i]['id'] + '">' + json['result'][i]['id'] + ' - ' + json['result'][i]['description'] + '</option>';
					}
					jQuery('select[name=\'clf\']').html(html);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		function decodevin() {
			jQuery.ajax({
				type: 'POST',
				url: 'parsers/kia/index.php?route=catalog/kia/variants&vin=' + encodeURIComponent(jQuery('input[name=\'VIN\']').val()),
				dataType: 'json',
				beforeSend: function() {
					jQuery('.success, .warning').remove();
					jQuery('#button-vin').attr('disabled', true);
				},
				complete: function() {
					jQuery('#button-vin').attr('disabled', false);
					jQuery('.attention').remove();
					jQuery('.wait').remove();
				},
				success: function(json) {
					jQuery('.success, .warning').remove();
					if (json['error']) {
						jQuery('#tab-vin').find('.form').after('<div class="warning">' + json['error'] + '</div>');
					}
					else 
					{
						jQuery('input[name=\'VIN\']').prop('disabled', true);
						jQuery(location).attr('href','index.php?route=catalog/kia&cat=' + json['pn']['MLBPNO'] + '&vin=' + json['pn']['vin']);
					}
				}
			});
		}
		
	});
</script>
<?php	
					break;
				}
			case 2:
				{
					break;
				}
			case 3:
			case 4:
				{
					$st = strpos($result,'<div id="content">');
					$ed = strpos($result,'<div id="footer">');
					$result = substr($result, $st, $ed - $st);

					$arr1 = array('<script','</script>','href');
					$arr2 = array('<scriptus','</scriptus>','hrf');
					$result = str_replace($arr1,$arr2,$result);
?>	
<script>	
	jQuery(document).ready(function() {
		jQuery('a').click(function() {
			var hr = jQuery(this).attr("hrf");
			var arr = new Array();
			arr = hr.split('?');
			var url = 'parsers/kia/index.php?step=<?php echo $step+1; ?>&' + arr[1];
			setUrl(url);
			saveUrl(url);
		});
	});
</script>
<?php			
					break;
				}	
			case 5:
				{		
					$st = strpos($result,'<div id="content">');
					$ed = strpos($result,'<div id="footer">');
					$result = substr($result, $st, $ed - $st);

					$arr1 = array('<script','</script>','href');
					$arr2 = array('<scriptus','</scriptus>','hrf');
					$result = str_replace($arr1,$arr2,$result);
?>
<script>
	var oActive = null; 
	jQuery(document).ready(function() {
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
					break;
				}
		}
	echo $result;
?>

	
	

    