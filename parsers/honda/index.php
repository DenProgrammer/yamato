<?php
    header ("Content-Type: text/html; charset=utf-8");
	include("../../configuration.php");
	include('../dictionary_details_function.php');
	
	$katalog = 'honda';
	
	function clearText($result)
		{
			$result = str_replace('src="images', 'src="parsers/honda/images/', $result);
			$result = str_ireplace('submit', 'button', $result);
			$result = str_ireplace('onChange', 'onch', $result);
			
			//$result = iconv("windows-1251","UTF-8//IGNORE", $result);
			
			$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">','src="image.php');
			$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','typ="tecss">','src="http://old.japancars.ru/cat/honda/image.php');
		   
			$result = str_replace($arr1,$arr2,$result);
			
			return $result;
		}

	if($_GET['step']>0) $step = $_GET['step']; else	$step = 1;
	
	$sep = '&';
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
	$get = str_replace(' ','%20',$get);
	$url = "http://japancars.ru/index.php?route=catalog/honda$get";
	
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
    curl_setopt($ch, CURLOPT_POST, 100); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    $result = clearText(curl_exec($ch)); // run the whole process

    if($result === FALSE) echo "cURL error: ".curl_error($ch);

    curl_close($ch);
	
	switch($step)
		{
			case 1:
				{
					$startIndex = strpos($result, '<div id="tab-model">'); 
					$endIndex = strpos($result, '<div id="footer">', $startIndex + 1);
					$result = substr($result, $startIndex, $endIndex - $startIndex);
?>
<script>	
	jQuery(document).ready(function() {
	
	jQuery("#result table.form tbody tr:first-child td:last-child").attr("rowspan",4)
	
	jQuery('select[name=\'cmodnamepc\']').bind('change', function() {
	showPreloader();
	jQuery.ajax({
		url: 'parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda/variants&step=2&cmodnamepc=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			jQuery('select[name=\'cmodnamepc\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			jQuery('.wait').remove();
		},			
		success: function(json) {

			html1 = '';
			html2 = '';
			html3 = '';
			html4 = '';
			html5 = '';
			html6 = '';
			
			for (i = 0; i < json['xcardrs'].length; i++) {
       			html1 += '<option value="' + json['xcardrs'][i] + '">' + json['xcardrs'][i] + '</option>';
			}
			for (i = 0; i < json['dmodyr'].length; i++) {
       			html2 += '<option value="' + json['dmodyr'][i] + '">' + json['dmodyr'][i] + '</option>';
			}
			for (i = 0; i < json['carea'].length; i++) {
       			html3 += '<option value="' + json['carea'][i] + '">' + json['carea'][i] + '</option>';
			}
			for (i = 0; i < json['ctrsmtyp'].length; i++) {
       			html4 += '<option value="' + json['ctrsmtyp'][i] + '">' + json['ctrsmtyp'][i] + '</option>';
			}
			for (i = 0; i < json['xgrade'].length; i++) {
       			html5 += '<option value="' + json['xgrade'][i] + '">' + json['xgrade'][i] + '</option>';
			}
			for (i = 0; i < json['equip'].length; i++) {
       			html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
			}
			
			jQuery('select[name=\'xcardrs\']').html(html1).trigger("change");
			jQuery('select[name=\'dmodyr\']').html(html2).trigger("change");
			jQuery('select[name=\'carea\']').html(html3).trigger("change");
			jQuery('select[name=\'ctrsmtyp\']').html(html4);
			jQuery('select[name=\'xgrade\']').html(html5);
			jQuery("#equip").html(html6).trigger("change");
			
   			jQuery('#button-filter').attr('href', 'javascript:setUrl("parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda&step=3&hmodtyp=' + json['hmodtypes']+'")');
			hidePreloader();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

jQuery('select[name=\'xcardrs\']').bind('change', function() {
	showPreloader();
	jQuery.ajax({
		url: 'parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda/variants&step=2&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			jQuery('select[name=\'xcardrs\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			jQuery('.wait').remove();
		},			
		success: function(json) {

			html2 = '';
			html3 = '';
			html4 = '';
			html5 = '';
			html6 = '';
			
			for (i = 0; i < json['dmodyr'].length; i++) {
       			html2 += '<option value="' + json['dmodyr'][i] + '">' + json['dmodyr'][i] + '</option>';
			}
			for (i = 0; i < json['carea'].length; i++) {
       			html3 += '<option value="' + json['carea'][i] + '">' + json['carea'][i] + '</option>';
			}
			for (i = 0; i < json['ctrsmtyp'].length; i++) {
       			html4 += '<option value="' + json['ctrsmtyp'][i] + '">' + json['ctrsmtyp'][i] + '</option>';
			}
			for (i = 0; i < json['xgrade'].length; i++) {
       			html5 += '<option value="' + json['xgrade'][i] + '">' + json['xgrade'][i] + '</option>';
			}
			for (i = 0; i < json['equip'].length; i++) {
       			html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
			}
			
			jQuery('select[name=\'dmodyr\']').html(html2).trigger("change");
			jQuery('select[name=\'carea\']').html(html3).trigger("change");
			jQuery('select[name=\'ctrsmtyp\']').html(html4);
			jQuery('select[name=\'xgrade\']').html(html5);
			jQuery("#equip").html(html6)

   			jQuery('#button-filter').attr('href', 'javascript:setUrl("parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda&step=3&hmodtyp=' + json['hmodtypes']+'")');
			hidePreloader();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

jQuery('select[name=\'dmodyr\']').bind('change', function() {
	showPreloader();
	jQuery.ajax({
		url: 'parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda/variants&step=2&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			jQuery('select[name=\'dmodyr\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			jQuery('.wait').remove();
		},			
		success: function(json) {

			html3 = '';
			html4 = '';
			html5 = '';
			html6 = '';
			
			for (i = 0; i < json['carea'].length; i++) {
       			html3 += '<option value="' + json['carea'][i] + '">' + json['carea'][i] + '</option>';
			}
			for (i = 0; i < json['ctrsmtyp'].length; i++) {
       			html4 += '<option value="' + json['ctrsmtyp'][i] + '">' + json['ctrsmtyp'][i] + '</option>';
			}
			for (i = 0; i < json['xgrade'].length; i++) {
       			html5 += '<option value="' + json['xgrade'][i] + '">' + json['xgrade'][i] + '</option>';
			}
			for (i = 0; i < json['equip'].length; i++) {
       			html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
			}
			
			jQuery('select[name=\'carea\']').html(html3).trigger("change");
			jQuery('select[name=\'ctrsmtyp\']').html(html4);
			jQuery('select[name=\'xgrade\']').html(html5);
			jQuery("#equip").html(html6)

   			jQuery('#button-filter').attr('href', 'javascript:setUrl("parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda&step=3&hmodtyp=' + json['hmodtypes']+'")');
			hidePreloader();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
jQuery('select[name=\'carea\']').bind('change', function() {
	showPreloader();
	jQuery.ajax({
		url: 'parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda/variants&step=2&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			jQuery('select[name=\'carea\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			jQuery('.wait').remove();
		},			
		success: function(json) {

			html4 = '';
			html5 = '';
			html6 = '';
			
			for (i = 0; i < json['ctrsmtyp'].length; i++) {
       			html4 += '<option value="' + json['ctrsmtyp'][i] + '">' + json['ctrsmtyp'][i] + '</option>';
			}
			for (i = 0; i < json['xgrade'].length; i++) {
       			html5 += '<option value="' + json['xgrade'][i] + '">' + json['xgrade'][i] + '</option>';
			}
			for (i = 0; i < json['equip'].length; i++) {
       			html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
			}
			
			jQuery('select[name=\'ctrsmtyp\']').html(html4);
			jQuery('select[name=\'xgrade\']').html(html5);
			jQuery("#equip").html(html6)
			
   			jQuery('#button-filter').attr('href', 'javascript:setUrl("parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda&step=3&hmodtyp=' + json['hmodtypes'] + '&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val())  + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' + encodeURIComponent(jQuery('select[name=\'carea\']').val()) +'")');
			hidePreloader();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

jQuery('select[name=\'ctrsmtyp\']').bind('change', function() {
	showPreloader();
	jQuery.ajax({
		url: 'parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda/variants&step=2&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' + 
		 encodeURIComponent(jQuery('select[name=\'carea\']').val()) + (jQuery('select[name=\'xgrade\']').val() != ''?'&xgrade=' + encodeURIComponent(jQuery('select[name=\'xgrade\']').val()):'') + '&ctrsmtyp=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			jQuery('select[name=\'ctrsmtyp\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			jQuery('.wait').remove();
		},			
		success: function(json) {

			html5 = '';
			html6 = '';
			
			for (i = 0; i < json['xgrade'].length; i++) {
       			html5 += '<option value="' + json['xgrade'][i] + '"' + (jQuery('select[name=\'xgrade\']').val() == json['xgrade'][i]?' selected ':'') + '>' + json['xgrade'][i] + '</option>';
			}
			for (i = 0; i < json['equip'].length; i++) {
       			html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
			}
			
			jQuery('select[name=\'xgrade\']').html(html5);
			jQuery("#equip").html(html6)

   			jQuery('#button-filter').attr('href', 'javascript:setUrl("parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda&step=3&hmodtyp=' + json['hmodtypes'] + '&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val())  + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' + encodeURIComponent(jQuery('select[name=\'carea\']').val()) + (jQuery('select[name=\'ctrsmtyp\']').val() != ''?'&ctrsmtyp=' + encodeURIComponent(jQuery('select[name=\'ctrsmtyp\']').val()):'') + (jQuery('select[name=\'xgrade\']').val() != ''?'&xgrade=' + encodeURIComponent(jQuery('select[name=\'xgrade\']').val()):'') +'")');
			hidePreloader();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

jQuery('select[name=\'xgrade\']').bind('change', function() {
	showPreloader();
	jQuery.ajax({
		url: 'parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda/variants&step=2&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val()) + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' + 
		 encodeURIComponent(jQuery('select[name=\'carea\']').val()) + (jQuery('select[name=\'ctrsmtyp\']').val() != ''?'&ctrsmtyp=' + encodeURIComponent(jQuery('select[name=\'ctrsmtyp\']').val()):'') + '&xgrade=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			jQuery('select[name=\'xgrade\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			jQuery('.wait').remove();
		},			
		success: function(json) {

			html5 = '';
			html6 = '';
			
			for (i = 0; i < json['ctrsmtyp'].length; i++) {
       			html5 += '<option value="' + json['ctrsmtyp'][i] + '"' + (jQuery('select[name=\'ctrsmtyp\']').val() == json['ctrsmtyp'][i]?' selected ':'') + '>' + json['ctrsmtyp'][i] + '</option>';
			}
			for (i = 0; i < json['equip'].length; i++) {
       			html6 += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
			}
			
			if (html5) jQuery('select[name=\'ctrsmtyp\']').html(html5);
			jQuery("#equip").html(html6)

   			jQuery('#button-filter').attr('href', 'javascript:setUrl("parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda&step=3&hmodtyp=' + json['hmodtypes'] + '&cmodnamepc=' + encodeURIComponent(jQuery('select[name=\'cmodnamepc\']').val())  + '&xcardr=' + encodeURIComponent(jQuery('select[name=\'xcardrs\']').val()) + '&dmodyr=' + encodeURIComponent(jQuery('select[name=\'dmodyr\']').val()) + '&carea=' + encodeURIComponent(jQuery('select[name=\'carea\']').val()) + (jQuery('select[name=\'ctrsmtyp\']').val() != ''?'&ctrsmtyp=' + encodeURIComponent(jQuery('select[name=\'ctrsmtyp\']').val()):'') + (jQuery('select[name=\'xgrade\']').val() != ''?'&xgrade=' + encodeURIComponent(jQuery('select[name=\'xgrade\']').val()):'') +'")');
			hidePreloader();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function decodevin() {	
	jQuery.ajax({
		type: 'POST',
		url: 'parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda/variants&step=2&vin=' + encodeURIComponent(jQuery('input[name=\'VIN\']').val()),
		dataType: 'json',
		beforeSend: function() {
			jQuery('.success, .warning').remove();
			jQuery('#button-vin').attr('disabled', true);
			jQuery('select[name=\'carea1\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			jQuery('#button-vin').attr('disabled', false);
			jQuery('.attention').remove();
			jQuery('.wait').remove();
		},
		success: function(json) {
			jQuery('.success, .warning').remove();

			if (json['error']) {
				jQuery('#tab-vin').after('<div class="warning">' + json['error'] + '</div>');
			}
			else {

				jQuery('input[name=\'VIN\']').prop('disabled', true);
				html = '';

				for (i = 0; i < json['hmodtypes'].length; i++) {
   					html += '<option value="' + json['hmodtypes'][i]['carea'] + '">' + json['hmodtypes'][i]['carea'] + '</option>';
				}
		
				jQuery('select[name=\'carea1\']').html(html);				
				jQuery('select[name=\'carea1\']').val('KG').trigger("change");
			}
		}
	});	
};

jQuery('select[name=\'carea1\']').bind('change', function() {
	jQuery.ajax({
		url: 'parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda/variants&step=2&vin=' + encodeURIComponent(jQuery('input[name=\'VIN\']').val()) + '&carea=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			jQuery('select[name=\'carea1\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			jQuery('.wait').remove();
		},			
		success: function(json) {

			html = '';
			
			for (i = 0; i < json['equip'].length; i++) {
       			html += '<input type="checkbox" name="eq_'+ json['equip'][i]['cmnopt']+'" value="0" title="' + json['equip'][i]['xmnopt'] + '">'+ json['equip'][i]['cmnopt']+'&nbsp;(' + json['equip'][i]['xmnopt'] + ')<br>';
			}
			
			jQuery("#equip1").html(html);
			jQuery('#button-vin').attr('href', 'parsers/<?php echo $katalog; ?>/index.php?route=catalog/honda&step=2&hmodtyp=' + json['hmodtypes'][0]['hmodtyp'] + '&cmodnamepc=' + json['hmodtypes'][0]['cmodnamepc'] + '&xcardr=' + json['hmodtypes'][0]['xcardrs'] + '&dmodyr=' + json['hmodtypes'][0]['dmodyr'] + '&carea=' + json['hmodtypes'][0]['carea'] + '&ctrsmtyp=' + json['hmodtypes'][0]['ctrsmtyp'] + '&xgrade=' + json['hmodtypes'][0]['xgradefulnam']);
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

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
				{	
					$startIndex = strpos($result, '<div id="content">'); 
					$endIndex = strpos($result, '<div id="footer">', $startIndex + 1);
					$result = substr($result, $startIndex, $endIndex - $startIndex);
					
					$result = str_replace('http://japancars.ru','',$result);
					$result = str_replace('src="','src="http://japancars.ru',$result)
?>	
<script>
	jQuery(document).ready(function() {
		jQuery('a').click(function(event){
			event.preventDefault();
		});
		
		jQuery('a').click(function() {
			var params = jQuery(this).attr('href');
			var url = 'index.php' + params;
			
			var pageUrl = "parsers/honda/index.php"+params+"&step=4";
			parentSaveUrl(pageUrl);
			setUrl(pageUrl);
		});
	});
</script>	
<?php
					break;
				}
			case 4:
				{	
					$startIndex = strpos($result, '<div id="content">'); 
					$endIndex = strpos($result, '<div id="footer">', $startIndex + 1);
					$result = substr($result, $startIndex, $endIndex - $startIndex);
					
					$result = str_replace('http://japancars.ru','',$result);
					$result = str_replace('src="','src="http://japancars.ru',$result);
?>	
<script>
	jQuery(document).ready(function() {
		jQuery('a').click(function(event){
			event.preventDefault();
		});
		
		jQuery('a').click(function() {
			var params = jQuery(this).attr('href');
			var url = 'index.php' + params;
			
			var pageUrl = "parsers/honda/index.php"+params+"&step=5";
			parentSaveUrl(pageUrl);
			setUrl(pageUrl);
		});
	});
</script>	
<?php
					break;
				}
			case 5:
				{		
					$startIndex = strpos($result, '<div id="content">'); 
					$endIndex = strpos($result, '<div id="footer">', $startIndex + 1);
					$result = substr($result, $startIndex, $endIndex - $startIndex);
					
					$result = str_replace('src="','src="http://japancars.ru',$result);
?>
<script>
	var oActive = null; 
	jQuery(document).ready(function() {			
		jQuery('table.list tbody tr').click(function() {
			var id = this.id;
			
			jQuery("#"+id+" td").each(function(i,elem){
				if (i==2) 
					{
						detailCode = jQuery(this).html();
						parentMainFind(detailCode);
					}
			});
		});
	});
		
</script>
<?php
					break;
				}
			default:
				{
					
				}
		}
	$dict = new Dictionary;
	$result = $dict->translate($result);
	echo $result;
?>

	
	

    