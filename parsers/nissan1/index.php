<?php
    header ("Content-Type: text/html; charset=utf-8");

	if($_GET['step']>0) $step = $_GET['step']; else	$step = 1;
	
	
	if ($_POST['cat']) $cat  = $_POST['cat']; else $cat  = $_GET['cat'];
	if ($_POST['mdl']) $mdl  = $_POST['mdl']; else $mdl  = $_GET['mdl'];
	if ($_POST['cd'])  $cd   = $_POST['cd']; else $cd    = $_GET['cd'];
	if ($_POST['carea']) $ca = $_POST['carea']; else $ca = $_GET['carea'];
	if ($_POST['grp']) $grp  = $_POST['grp']; else $grp  = $_GET['grp'];
	if ($_POST['artikul']) $textPartN = $_POST['artikul']; else $textPartN = $_GET['artikul'];
   
	if ($_POST['cb0']) $cb0 = $_POST['cb0']; else $cb0 = $_GET['cb0'];
	if ($_POST['cb1']) $cb1 = $_POST['cb1']; else $cb1 = $_GET['cb1'];
	if ($_POST['cb2']) $cb2 = $_POST['cb2']; else $cb2 = $_GET['cb2'];
	if ($_POST['cb3']) $cb3 = $_POST['cb3']; else $cb3 = $_GET['cb3'];
	if ($_POST['cb4']) $cb4 = $_POST['cb4']; else $cb4 = $_GET['cb4'];
	if ($_POST['cb5']) $cb5 = $_POST['cb5']; else $cb5 = $_GET['cb5'];
	
	if ($_POST['pn']) $pn = $_POST['pn']; else $pn = $_GET['pn'];
	if ($_POST['sec']) $sec = $_POST['sec']; else $sec = $_GET['sec'];
	if ($_POST['gi']) $pn = $_POST['gi']; else $gi = $_GET['gi'];
	if ($_POST['x']) $x = $_POST['x']; else $x = $_GET['x'];
        
	$CountryID = '82'; //KZ = 82 / CountryID const
	$postfields = ''; 
	
	if($step == 1){
		$url = "http://old.japancars.ru/cat/nissan/";
                //echo $url;
        }
	else if($step == 2)
        {
		$url = 'http://old.japancars.ru/cat/nissan/?carea=' . $ca; 
                //echo $url;
        }
	else if($step == 3)
        {
		$url = 'http://old.japancars.ru/cat/nissan/index.php?carea='.$ca.'&mdl='.$mdl;
                //echo $url;
        }
        
	else if($step == 4)
        {
            $url = 'http://old.japancars.ru/cat/nissan/index.php?carea='.$ca.'&mdl='.$mdl.'&cb0='.$cb0.'&search=%C4%E0%EB%E5%E5 ';
            //echo $url;
        }
        
	else if($step == 5)   
        {
            $url = 'http://old.japancars.ru/cat/nissan/index.php?x='.$x.'&cat='.$cat.'&pn='.$pn.'&gi='.$gi;
            //echo $url;
        }
		
	else if($step == 6)
	{
            $url = 'http://old.japancars.ru/cat/nissan/index.php?x='.$x.'&cat='.$cat.'&pn='.$pn.'&gi='.$gi.'&sec='.$sec;
            //echo $url;
	}
	else if ($step == 7)
	{
		$postfields = "CountryID=".$CountryID."&txtPartN=".$textPartN; 
		$url = 'http://ra.ae/priceonline.php';
		//echo $postfields;
	}
	else if($step == 8)
	{
		$textPartN = "09111-35140";
		$postfields = "CountryID=".$CountryID."&txtPartN=".$textPartN; 
		$url = 'http://ra.ae/priceonline.php';
		echo $postfields;
	}
	//else 
		//$url = "http://old.japancars.ru/cat/nissan/";
		
		
		
    if (!$url) die('url not found');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
    curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
    curl_setopt($ch, CURLOPT_POST, 100); 
    if($step == 4)
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
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
		$result = str_replace('src="images', 'src="parsers/nissan/images/', $result);
		//$result = str_replace('src="images', 'src="parsers/nissan/images', $result); //На хостинге
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
				jQuery('select[name=carea]').change(function(){
					var carArea = jQuery('select[name=carea] option:selected').val();
					var url = 'http://yamato.kg/new/parsers/nissan/index2.php?carea='+carArea;
					var pageUrl = "parsers/nissan/index.php?step=2&carea="+carArea;
					saveUrl(pageUrl);
					setUrl(pageUrl);
				}); 
			});
		</script>
		<?php	
	}
	
	else if($step == 2)
	{
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
		
		$startIndex = strpos($result, '<form action="" method="get"  name="ModelForm"'); 
		$endIndex = strpos($result, "</form>", $startIndex+10);
		$result = substr($result, $startIndex, $endIndex);
		
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','typ="tecss">');
	   
                $result = str_ireplace('onch', 'onChange', $result);
		echo $result = str_replace($arr1,$arr2,$result);

		?>
		
		<script>	
			jQuery(document).ready(function() {
				jQuery("input[name='frame1']").parent().parent().parent().hide();
				jQuery("input[name='vin']").parent().parent().parent().hide();
				jQuery('.headerr:first').hide();
				jQuery('.headerr:eq(1)').hide();
				jQuery("scriptus").html("");
				
				jQuery(':button[name=search]').click(function() {
					
					var carArea = jQuery('select[name=carea] option:selected').val();
					var carModel = jQuery('select[name=mdl] option:selected').val();
                                 	
					var pageUrl = "parsers/nissan/index.php?step=3&carea="+carArea+"&mdl="+carModel;
					saveUrl(pageUrl);
					setUrl(pageUrl);
				});
                                
				jQuery(document).on('change', 'select[name=carea]', function(){
					var carArea = jQuery('select[name=carea] option:selected').val();
					var url = 'index.php?carea='+carArea;
				});
			});
		</script>
		<?php			
	}
	
        else if($step == 3)
	{
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
		
		$startIndex = strpos($result, '<form action="" method="get"  name="ModelForm"'); 
		$endIndex = strpos($result, "</form>", $startIndex+10);
		$result = substr($result, $startIndex, $endIndex);
		
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','typ="tecss">');
	   
                $result = str_ireplace('onch', 'onChange', $result);
		echo $result = str_replace($arr1,$arr2,$result);

		?>
		
		<script>	
			jQuery(document).ready(function() {
                               
				jQuery("input[name='frame1']").parent().parent().parent().hide();
				jQuery("input[name='vin']").parent().parent().parent().hide();
				jQuery('.headerr:first').hide();
				jQuery('.headerr:eq(1)').hide();
				jQuery("scriptus").html("");
				
				jQuery(':button[name=search]').click(function() {
					
					var carArea = jQuery('select[name=carea] option:selected').val();
					var carModel = jQuery('select[name=mdl] option:selected').val();
					var cb0 = jQuery('select[name=cb0] option:selected').val(); 
					var cb1 = jQuery('select[name=cb1] option:selected').val(); 
					var cb2 = jQuery('select[name=cb2] option:selected').val(); 
					var cb3 = jQuery('select[name=cb3] option:selected').val(); 
					var cb4 = jQuery('select[name=cb4] option:selected').val(); 
					var cb5 = jQuery('select[name=cb5] option:selected').val(); 
					var cb6 = jQuery('select[name=cb6] option:selected').val(); 
					
					var pageUrl = "parsers/nissan/index.php?step=4&carea=" + carArea + "&mdl=" + carModel + "&cb0=" + cb0 + "&cb1=" + cb1 + "&cb2=" + cb2 + "&cb3=" + cb3 + "&cb4=" + cb4 + "&cb5=" + cb5 + "&search=%C4%E0%EB%E5%E5";
					saveUrl(pageUrl);
					setUrl(pageUrl);
				});
                                
				jQuery('select[name=carea]').onchange(function(){
					var carArea = jQuery('select[name=carea] option:selected').val();
					var url = 'index.php?carea='+carArea;
				});
			});
                     
		</script>
		<?php			
	}
        
	else if($step == 4)
	{
            $arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
            $arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','typ="tecss">');

            $result = str_ireplace('onch', 'onChange', $result);
            $result = iconv("windows-1251","UTF-8//IGNORE", $result);
            
            $result = str_replace($arr1,$arr2,$result);
            
            $arr1 = array('genimg.php?');
            $arr2 = array('http://old.japancars.ru/cat/mazda/genimg.php?');
           
            $result = str_replace($arr1,$arr2,$result);
            echo $result;

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
					var pageUrl = "parsers/nissan/index.php"+params+"&step=5";
					saveUrl(pageUrl);
					setUrl(pageUrl);
				});
			});
                     
		</script>
		<?php			
	}

	else if($step == 5)
	{
		//echo "Step 5";
		$arr1 = array('image.php?cd=');
		$arr2 = array('http://old.japancars.ru/cat/nissan/image.php?cd=');
	  
		$result  = str_replace($arr1, $arr2, $result);
	   
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','type="text/css"></linkus>');
	   
		$result = str_replace($arr1, $arr2, $result);
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
	   
        $result = removeScriptus($result);
		echo $result;
		
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
						
				var pageUrl = "parsers/nissan/index.php"+params+"&step=6";
				saveUrl(pageUrl);
				setUrl(pageUrl);
				
			});	
		});		
			</script>
		
		<?php
	}
        
        else if($step == 6)
	{
		//echo "Step 5";
		$arr1 = array('image.php?cd=');
		$arr2 = array('http://old.japancars.ru/cat/nissan/image.php?cd=');
	  
		$arr3 = array('href="?cd=');
		//$arr4 = array('href="carDetailsGroup2.php/?cd=');
		$arr4 = array('href="http://yamato.kg/new/parsers/nissan/carDetailsGroup2.php/?cd=');
		
		$result  = str_replace($arr1, $arr2, $result);
		//$result  = str_replace($arr3, $arr4, $result);
	   
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','type="text/css"></linkus>');
	   
		$result = str_replace($arr1, $arr2, $result);
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
	   
                $result = removeScriptus($result);
		echo $result;
		
		?>
		
		<script>
		
		jQuery(document).ready(function() {
				jQuery('a').click(function(event){
					event.preventDefault();
				});

                               var oActive = null; 
			
				jQuery('td[height="1%"]').hide();
				jQuery(".pad10").hide();
					
				jQuery('td a').click(function() {
                                    
                                    
					str = this.onclick;
					str += '';
					str = str.replace('function','');
					str = str.replace('onclick(event)','');
					str = str.replace('{','');
					str = str.replace('rollout','');
					str = str.replace('(','');
					str = str.replace(')','');
					str = str.replace('}','');
					str = jQuery.trim(str);

					var id = str;
					jQuery("div #d" + id +" table tr:first-child").remove();
					var detailCode = jQuery("div #d" + id +" table tr:first-child td:first-child nobr b").html();
					mainFind(detailCode);
				});	
			});
                
			</script>
		
		<?php
	}
	
	else if($step == 66)
	{		
		//echo "Step 6";
	
		$arr1 = array('image.php?cd=');
		$arr2 = array('http://old.japancars.ru/cat/nissan/image.php?cd=');
	  
		$arr3 = array('href="?cd=');
		//$arr4 = array('href="carDetailsGroup2.php/?cd=');
		$arr4 = array('href="http://yamato.kg/new/parsers/nissan/carDetailsGroup2.php/?cd=');
		
		$result  = str_replace($arr1, $arr2, $result);
		//$result  = str_replace($arr3, $arr4, $result);
	   
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','type="text/css"></linkus>');
	   
		$result = str_replace($arr1, $arr2, $result);
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
	   
	    $result = removeScriptus($result);
		echo $result;
		
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
						document.getElementById("i"+oId).src = "images/collapse.gif";
						oActive = oId;
					}

					var params = jQuery(this).attr('href');  
					
					
					var pageUrl = "parsers/nissan/index.php"+params+"&step=7";
					//saveUrl(pageUrl);
					mainFind(detailCode);
					});
			});
				
		</script>
		<?php
	}
	
	else if($step == 7)
	{
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

	
	

    