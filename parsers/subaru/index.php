<?php
    header ("Content-Type: text/html; charset=utf-8");
	
	$katalog = 'subaru';
	
	function clearText($result)
		{
			global $katalog;
			$result = str_replace('src="images', 'src="parsers/'.$katalog.'/images/', $result);
			$result = str_ireplace('submit', 'button', $result);
			
			//$result = iconv("windows-1251","UTF-8//IGNORE", $result);
			
			$arr1 = array('HM.set','<script','</script>');
			$arr2 = array('setUrlAjax','<scriptus','</scriptus>');
		   
			$result = str_replace($arr1,$arr2,$result);
			
			return $result;
		}
	
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

	echo $result;
?>
<script>	
	jQuery(document).ready(function() {
		jQuery("ul.way img").each(function(){
			var src = jQuery(this).attr("src");
			src = 'http://epc.japancars.ru'+src;
			jQuery(this).attr("src",src);
		})
	});
	function setUrlAjax(url)
		{
			var pageUrl = "parsers/<?php echo $katalog; ?>/index.php?fromchanged=true&l="+url;
			parentSaveUrl(pageUrl);
			setUrl(pageUrl);
		}
	function articleRow(art)
		{
			parentMainFind(art)
		}
	var page = 1;
	function page_change(si)
		{
			jQuery("#data_row"+page).css("display","none");
			jQuery("#data_row"+si).css("display","block");
			page = si;
		}
	function goToCalloutRow()
		{
		
		}
</script>

	
	

    