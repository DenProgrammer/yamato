<?php
	//MAZDA
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
	//if ($step == 2) $url = 'http://japancars.ru/index.php?route=catalog/mazda/variants&mdl=121';
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
		
		jQuery('select[name=\'mdl\']').change(function() {
			jQuery.ajax({
				url: 'parsers/mazda/index.php?route=catalog/mazda/variants&mdl=' + jQuery(this).val() + '&step=2',
				dataType: 'json',
				beforeSend: function() {
					jQuery('select[name=\'mdl\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					jQuery('.wait, .warning').remove();
				},
				success: function(json) {
					html = '<option value=""></option>';
					if (json['result'])
					for (i = 0; i < json['result'].length; i++) {
					html += '<option value="' + json['result'][i]['XC26GPCG'] + '">Модельный год&nbsp;' + json['result'][i]['XC26CYYF'] + '&nbsp;&nbsp;Выпуск с&nbsp;' + json['result'][i]['XC26CYMF'] + '&nbsp;&nbsp;Серия ' + json['result'][i]['VIN'] + '</option>';
					}
					jQuery('select[name=\'cat\']').html(html);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
		jQuery('select[name=\'cat\']').change(function() {
			decodecfg();
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
			setUrl('parsers/mazda/index.php?step=<?php echo $step+1; ?>&'+url);
			saveUrl('parsers/mazda/index.php?step=<?php echo $step+1; ?>&'+url);
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

	
	

    