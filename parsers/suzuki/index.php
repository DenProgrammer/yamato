<?php
    header ("Content-Type: text/html; charset=utf-8");
	include("../../configuration.php");
	include('../dictionary_details_function.php');
	
	$katalog = 'suzuki';
	
	function clearText($result)
		{
			global $katalog;
			$result = str_replace('src="images', 'src="parsers/'.$katalog.'/images/', $result);
			$result = str_ireplace('submit', 'button', $result);
			$result = str_ireplace('onChange', 'onch', $result);
			$result = str_ireplace('onmouseout', 'onmou', $result);
			$result = str_ireplace('onmouseover', 'onmov', $result);
			$result = str_ireplace('onclick', 'oncl', $result);
			
			$result = iconv("windows-1251","UTF-8//IGNORE", $result);
			
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
	
	$url = "http://epc.japancars.ru/$katalog/$get";
	//echo 'step = '.$step.'; url = '.$url.'<br>';
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
			case 2:
			case 3:
			case 4:
			case 5:
				{
?>
<script>	
	jQuery(document).ready(function() {
		jQuery('tr.row').click(function(){
			str = jQuery(this).attr("oncl");
			var arr = new Array();
			arr = str.split('?');
			
			var params = arr[1];
			
			var pageUrl = "parsers/<?php echo $katalog; ?>/index.php?"+params+"&step=<?php echo $step+1; ?>";
			parentSaveUrl(pageUrl);
			setUrl(pageUrl);
		});
	});
</script>
<?php	
					break;
				}
			case 6:
				{		
					$arr1 = array('image.php?cd=');
					$arr2 = array('http://old.japancars.ru/cat/'.$katalog.'/image.php?cd=');
					$result  = str_replace($arr1, $arr2, $result);
?>
<script>
	var oActive = null; 
	jQuery(document).ready(function() {
		jQuery('td[height="1%"]').hide();
		jQuery(".pad10").hide();
			
		jQuery('a.cat_article').click(function(event) {
			event.stopPropagation();
			jQuery(this).removeAttr("href");
			parentMainFind(jQuery(this).text());
		});
	});
		
</script>
<?php
					break;
				}
		}
	$dict = new Dictionary;
	$result = $dict->translate($result);
	echo $result;
?>

	
	

    