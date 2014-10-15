<?php
    header ("Content-Type: text/html; charset=utf-8");
	include("../../configuration.php");
	include('../dictionary_details_function.php');
	
	if($_GET['step'] > 0) 
            $step = $_GET['step']; else	$step = 1;
	
	if ($_POST['cat']) $cat  = $_POST['cat']; else $cat  = $_GET['cat'];
	if ($_POST['mdl']) $mdl  = $_POST['mdl']; else $mdl  = $_GET['mdl'];
	if ($_POST['cd'])  $cd   = $_POST['cd']; else $cd    = $_GET['cd'];
	if ($_POST['area']) $ca = $_POST['area']; else $ca = $_GET['area'];
	if ($_POST['grp']) $grp  = $_POST['grp']; else $grp  = $_GET['grp'];
	if ($_POST['sec']) $sec  = $_POST['sec']; else $sec  = $_GET['sec'];
	if ($_POST['artikul']) $textPartN = $_POST['artikul']; else $textPartN = $_GET['artikul'];
        if ($_POST['clf']) $clf  = $_POST['clf']; else $clf  = $_GET['clf'];
        if ($_POST['mg']) $mg = $_POST['mg']; else $mg = $_GET['mg'];
        if ($_POST['bg']) $bg = $_POST['bg']; else $bg = $_GET['bg'];
	
	$CountryID = '82'; //KZ = 82 / CountryID const
   
	$postfields = ''; 
	
	if($step == 1)
		$url = "http://old.japancars.ru/cat/mitsubishi/";
	
	else if($step == 2)
		$url = 'http://old.japancars.ru/cat/mitsubishi/?area=' . $ca;
	
	else if($step == 3)
		$url = 'http://old.japancars.ru/cat/mitsubishi/index.php?area='.$ca.'&cat='.$cat;
	
	else if($step == 4)
            $url = 'http://old.japancars.ru/cat/mitsubishi/index.php?area='.$ca.'&cat='.$cat.'&mdl='.$mdl;
        
	else if($step == 5)
        {
            echo $url;
            $url = 'http://old.japancars.ru/cat/mitsubishi/index.php?s&area='.$ca.'&cat='.$cat.'&mdl='.$mdl.'&clf='.$clf;
        }
	else if($step == 6)
	{
                //echo $url;
		$url = 'http://old.japancars.ru/cat/mitsubishi/index.php?s&area='.$ca.'&cat='.$cat.'&mdl='.$mdl.'&clf='.$clf.'&mg='.$mg;
	}
	else if ($step == 7)
	{            
                //echo $url;
               $url = 'http://old.japancars.ru/cat/mitsubishi/index.php?s&area='.$ca.'&cat='.$cat.'&mdl='.$mdl.'&clf='.$clf.'&mg='.$mg.'&bg='.$bg;
	}
	else if($step == 8)
	{
		$postfields = "CountryID=".$CountryID."&txtPartN=".$textPartN; 
		$url = 'http://ra.ae/priceonline.php';
		echo $postfields;
	}
	//else 
		//$url = "http://old.japancars.ru/cat/toyota/";
		
		
		
    if (!$url) die('url not found');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
    curl_setopt($ch, CURLOPT_POST, 100); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields); 

    $result = curl_exec($ch); // run the whole process
    
    if($result === FALSE){
            echo "cURL error: ".curl_error($ch);
    }

    curl_close($ch);
	
	function removeScriptus($result){
		$firstOnenScrt = strpos($result, '<scriptus');
		$firstCloseScrt = strpos($result, '</scriptus>');
		
		for($i = $firstOnenScrt; $i <= $firstCloseScrt + 11; $i++)
		{
			$result[$i] = '';
		}
		
		$firstOnenScrt = strpos($result, '<scriptus');
		$firstCloseScrt = strpos($result, '</scriptus>');
		
		for($i = $firstOnenScrt; $i <= $firstCloseScrt + 11; $i++)
		{
			$result[$i] = '';
		}
		
		return $result;
	}
	
	function removeScriptus2($result){
		$firstOnenScrt = strpos($result, '<scriptus');
		$firstCloseScrt = strpos($result, '</scriptus>');
		
		for($i = $firstOnenScrt; $i <= $firstCloseScrt + 11; $i++)
		{
			$result[$i] = '';
		}
	}
	
	/*Добавляем картинки для 1-3 шага*/
	//if($step == 1 || $step == 2 || $step == 3 || $step == 4 )
	if($step > 0)
	{
		$result = str_replace('src="images', 'src="parsers/mitsubishi/images/', $result);
		//$result = str_replace('src="images', 'src="parsers/mitsubishi/images', $result); //На хостинге
		$result = str_ireplace('submit', 'button', $result);
		//$result = str_ireplace('onChange', 'onch', $result);
	}
	
	if($step == 1)
	{
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
		
		$startIndex = strpos($result, '<form action="" method="get"  name="ModelForm"'); 
		$endIndex = strpos($result, "</form>", $startIndex + 1);
		
		/*Убираем скрипты внизу страницы*/
		$arr1 = array('<script type="text/javascript">');
		$arr2 = array('<scriptus');
	   
		$result = str_replace($arr1,$arr2,$result);
		
		echo substr($result, $startIndex, $endIndex); 
		
		?>
		<script>	
			jQuery(document).ready(function() {
				jQuery('select[name=area]').change(function(){
					var carArea = jQuery('select[name=area] option:selected').val();
					var url = 'http://yamato.kg/new/parsers/mitsubishi/index2.php?area='+carArea;
					var pageUrl = "parsers/mitsubishi/index.php?step=2&area="+carArea;
					saveUrl(pageUrl);
					setUrl(pageUrl);
				}); 
			});
		</script>
		<?php	
	}
	
        if($step == 2)
	{
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
		
		$startIndex = strpos($result, '<form action="" method="get"  name="ModelForm"'); 
		$endIndex = strpos($result, "</form>", $startIndex + 1);
		
		/*Убираем скрипты внизу страницы*/
		$arr1 = array('<script type="text/javascript">');
		$arr2 = array('<scriptus');
	   
		$result = str_replace($arr1,$arr2,$result);
		
		echo substr($result, $startIndex, $endIndex); 
		
		?>
		<script>	
			jQuery(document).ready(function() {
				jQuery('select[name=cat]').change(function(){
					var area = jQuery('select[name=area] option:selected').val();
                                        var cat = jQuery('select[name=cat] option:selected').val();
					var url = 'http://yamato.kg/new/parsers/mitsubishi/index2.php?area=' + area + '&cat=' + cat;
					var pageUrl = "parsers/mitsubishi/index.php?step=3&area="+ area + '&cat=' + cat;
					saveUrl(pageUrl);
					setUrl(pageUrl);
				}); 
			});
		</script>
		<?php	
	}
        
        if($step == 3)
	{
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
		
		$startIndex = strpos($result, '<form action="" method="get"  name="ModelForm"'); 
		$endIndex = strpos($result, "</form>", $startIndex + 1);
		
		/*Убираем скрипты внизу страницы*/
		$arr1 = array('<script type="text/javascript">');
		$arr2 = array('<scriptus');
	   
		$result = str_replace($arr1,$arr2,$result);
		
		echo substr($result, $startIndex, $endIndex); 
		
		?>
		<script>	
			jQuery(document).ready(function() {
				jQuery('select[name=mdl]').change(function(){
					var area = jQuery('select[name=area] option:selected').val();
                                        var cat = jQuery('select[name=cat] option:selected').val();
                                        var mdl = jQuery('select[name=mdl] option:selected').val();
					var url = 'http://yamato.kg/new/parsers/mitsubishi/index2.php?area=' + area + '&cat=' + cat + '&mdl=' + mdl;
					var pageUrl = "parsers/mitsubishi/index.php?step=4&area="+ area + '&cat=' + cat + '&mdl=' + mdl;
					saveUrl(pageUrl);
					setUrl(pageUrl);
				}); 
			});
		</script>
		<?php	
	}
        
        if($step == 4)
	{
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
		
		$startIndex = strpos($result, '<form action="" method="get"  name="ModelForm"'); 
		$endIndex = strpos($result, "</form>", $startIndex + 1);
		
		/*Убираем скрипты внизу страницы*/
		$arr1 = array('<script type="text/javascript">');
		$arr2 = array('<scriptus');
	   
		$result = str_replace($arr1,$arr2,$result);
		
		echo substr($result, $startIndex, $endIndex); 
		
		?>
		<script>	
			jQuery(document).ready(function() {
				jQuery(':button[name=search]').click(function() {
					var area = jQuery('select[name=area] option:selected').val();
                                        var cat = jQuery('select[name=cat] option:selected').val();
                                        var mdl = jQuery('select[name=mdl] option:selected').val();
                                        var clf = jQuery('select[name=clf] option:selected').val();
					//var url = 'http://yamato.kg/new/parsers/mitsubishi/index2.php?s&area=' + area + '&cat=' + cat + '&mdl=' + mdl + '&clf=' + clf;
					var pageUrl = "parsers/mitsubishi/index.php?s&step=5&area="+ area + '&cat=' + cat + '&mdl=' + mdl + '&clf=' + clf;
					saveUrl(pageUrl);
					setUrl(pageUrl);
				}); 
			});
		</script>
		<?php	
	}
        
        if($step == 5)
	{
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
		
		//$startIndex = strpos($result, '<form action="" method="get"  name="ModelForm"'); 
		//$endIndex = strpos($result, "</form>", $startIndex + 1);
		
                $arr1 = array('image.php?area=');
		$arr2 = array('http://old.japancars.ru/cat/mitsubishi/image.php?area=');
                $result = str_replace($arr1, $arr2, $result);
                
		/*Убираем скрипты внизу страницы*/
		$arr1 = array('<script type="text/javascript">');
		$arr2 = array('<scriptus');
	   
		$result = str_replace($arr1, $arr2, $result);
		
		//echo substr($result, $startIndex, $endIndex); 
        $dict = new Dictionary;
		echo $dict->translate($result);
		
		?>
		<script>	
			jQuery(document).ready(function() {
                                jQuery('td[height="1%"]').hide();
                                jQuery(".pad10").hide();
                                
                                jQuery('a').click(function(event){
                                    event.preventDefault();
                                });
			
                                jQuery('body,html').animate({scrollTop: 0}, 400);
			
                                jQuery('td a').click(function() {
                                    var params = jQuery(this).attr('href');                    							

                                    var pageUrl = "parsers/mitsubishi/index.php"+params+"&step=6";
                                    saveUrl(pageUrl);
                                    setUrl(pageUrl);
                                });	 
			});
		</script>
		<?php	
	}
        
	else if($step == 6)
	{
		echo "Step 6";
                //echo $url;
		$arr1 = array('image.php?area=');
		$arr2 = array('http://old.japancars.ru/cat/mitsubishi/image.php?area=');

		$result  = str_replace($arr1, $arr2, $result);
		//$result  = str_replace($arr3, $arr4, $result);
	   
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','type="text/css"></linkus>');
	   
		$result = str_replace($arr1, $arr2, $result);
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
	   
        $result = removeScriptus($result);
		$dict = new Dictionary;
		echo $dict->translate($result);
		
		?>
		
		<script>
		
		jQuery(document).ready(function() {
			jQuery('td[height="1%"]').hide();
			jQuery(".pad10").hide();
			
			jQuery('a').click(function(event){
				event.preventDefault();
			});
			
			jQuery('body,html').animate({scrollTop: 0}, 400);
			
			jQuery('td a').click(function() {
				var params = jQuery(this).attr('href');                    								
				var pageUrl = "parsers/mitsubishi/index.php"+params+"&step=7";
                                //alert(pageUrl);
				saveUrl(pageUrl);
				setUrl(pageUrl);
			});	
		});		
			</script>
		
		<?php
	}

        else if($step == 7)
	{
            //echo "Step 7";
		$arr1 = array('image.php?area=');
		$arr2 = array('http://old.japancars.ru/cat/mitsubishi/image.php?area=');
           
		$arr3 = array('href="?cd=');
		//$arr4 = array('href="carDetailsGroup2.php/?cd=');
		$arr4 = array('href="http://yamato.kg/new/parsers/mitsubishi/carDetailsGroup2.php/?cd=');
		
		$result  = str_replace($arr1, $arr2, $result);
		//$result  = str_replace($arr3, $arr4, $result);
	   
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','type="text/css"></linkus>');
	   
		$result = str_replace($arr1, $arr2, $result);
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
	   
                $result = removeScriptus($result);
		$dict = new Dictionary;
		echo $dict->translate($result);
		
		?>
		
		<script>
		
		var oActive = null; 
			jQuery(document).ready(function() {
				jQuery('td[height="1%"]').hide();
				jQuery(".pad10").hide();
					
				jQuery('td a').click(function() {
					var id = this.id;
					
					id2 = id.replace('t', 'd1');
				
					var detailCode = jQuery("div #" + id2 +" nobr b").html();
					//alert("div #" + id2 +" nobr b = "+detailCode);
					
					
					var insertPlace = "#" + id + " td:last-child :odd";
					
					oId = id.replace('t', '1');
					if (oActive != null) {
						document.getElementById("d"+oActive).style.display = "none";
						document.getElementById("i"+oActive).src = "images/expand.gif";
						if (oActive == oId)	{
							oActive = null;
							return;
						}
					}
					if ((document.getElementById("d"+oId) != null)&&(oId!=oActive)) {
						document.getElementById("d"+oId).style.display = "block";
						document.getElementById("i"+oId).src = "images/collapse.gif";
						oActive = oId;
					}

					var params = jQuery(this).attr('href');  
					
					
					var pageUrl = "parsers/toyota/index.php"+params+"&step=8";
					//saveUrl(pageUrl);
					mainFind(detailCode);
					});
					
					jQuery('a img').hide();
			});
				
		
			</script>
		
		<?php
	}
        
        else if($step == 8)
            {		
		//echo "Step 8";
	
		$arr1 = array('image.php?cd=');
		$arr2 = array('http://old.japancars.ru/cat/toyota/image.php?cd=');
	  
		$arr3 = array('href="?cd=');
		//$arr4 = array('href="carDetailsGroup2.php/?cd=');
		$arr4 = array('href="http://yamato.kg/new/parsers/toyota/carDetailsGroup2.php/?cd=');
		
		$result  = str_replace($arr1, $arr2, $result);
		//$result  = str_replace($arr3, $arr4, $result);
	   
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','type="text/css"></linkus>');
	   
		$result = str_replace($arr1, $arr2, $result);
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
	   
	    $result = removeScriptus($result);
		$dict = new Dictionary;
		echo $dict->translate($result);
		
		?>
		<script>
		var oActive = null; 
			jQuery(document).ready(function() {
				jQuery('td[height="1%"]').hide();
				jQuery(".pad10").hide();
					
				jQuery('td a').click(function() {
					var id = this.id;
					
					id2 = id.replace('t', 'd1');
				
					var detailCode = jQuery("div #" + id2 +" nobr b").html();
					//alert("div #" + id2 +" nobr b = "+detailCode);
					
					
					var insertPlace = "#" + id + " td:last-child :odd";
					
					oId = id.replace('t', '1');
					if (oActive != null) {
						document.getElementById("d"+oActive).style.display = "none";
						document.getElementById("i"+oActive).src = "images/expand.gif";
						if (oActive == oId)	{
							oActive = null;
							return;
						}
					}
					if ((document.getElementById("d"+oId) != null)&&(oId!=oActive)) {
						document.getElementById("d"+oId).style.display = "block";
						document.getElementById("i"+oId).src = "images/collapse.gif";
						oActive = oId;
					}

					var params = jQuery(this).attr('href');  
					
					
					var pageUrl = "parsers/toyota/index.php"+params+"&step=8";
					//saveUrl(pageUrl);
					mainFind(detailCode);
					});
					
					jQuery('a img').hide();
			});
				
		</script>
		<?php
	}
        
	else if($step == 8)
	{
		echo "<h1>Step 7</h1>";
		
		/*First Price*/
		//Находим первую PriceForId
		$priceStartIndex = strpos($result, "PriceForId"); 
		//echo "<h3>".$priceStartIndex." Number of symbols in html file ".strlen($result)."</h3>";
		//Кол-во PriceOfId в документе
		$numberOfEntries = substr_count($result, 'PriceForId');
		$arrayOfPrices[] = '';
		
		//echo $numberOfEntries;
		//echo '<br />';
		
		//Массив для индексов начала PriceOfId
		$arrOfPriceOfIdNames[] = $priceStartIndex;
		
		//Так, как один уже есть, начнем с первого
		for($j = 1; $j < $numberOfEntries; $j++)
		{
			$priceStartIndex = strpos($result, "PriceForId", $priceStartIndex + 1); 
			$arrOfPriceOfIdNames[] = $priceStartIndex;
		}
		
		//Массив с индексами элементов PriceOfId
		//print_r($arrOfPriceOfIdNames);
		
		
	   //echo "<h1>".$numberOfEntries."</h1>";
	  
		for($j = 0; $j < $numberOfEntries; $j++)
		{
			/*
			echo $arrOfPriceOfIdNames[$j];
			echo "<br/ >"; */
			for($jj = $arrOfPriceOfIdNames[$j]; $jj < strlen($result); $jj++)
			{
				if($result[$jj] == '>')
						$closeTag += 1;
				if($result[$jj] == '<')
						$openTag += 1;

				//echo "close Tag: ".$closeTag;
				//echo "start Tag: ".$startTag;

				if($openTag == 2 && $closeTag == 3){
					$startIndexC = $jj; 
					$closeTag    = 0;
					$openTag     = 0;
					break;
				}
				if($openTag == 5 && $closeTag == 5){
					$startIndexC = $jj;
					$closeTag    = 0;
					$openTag     = 0;
					break;
				}
			}

		   // echo "<h1>".$startIndexC."</h1>";
			$price = '';
			
			for($i = $startIndexC + 1; $i < strlen($result); $i++)
			{
				if($result[$i] == "\"" || $result[$i] == '<'){
					break;
				}
				$price .= $result[$i];
			}
			$arrayOfPrices[] = $price;
			//echo $price;
		}
		
		$stringOfPrices = '';
		$sep = '';
		foreach($arrayOfPrices as $price){
			if ($price>0)
				{
					$stringOfPrices .= $sep.$price;
					$sep = ', ';
				}
		}
		
		if($stringOfPrices == ''){
			echo "weight is unknown";
		}
		echo $stringOfPrices;
	}
	
	else if($step == 8)
	{
		echo $result;
	}
	
?>

	
	

    