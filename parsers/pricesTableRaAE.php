<?php
	header ("Content-Type: text/html; charset=utf-8");
	function pr($var)
		{
			echo '<pre>';
			print_r($var);
			echo '</pre>';
		}
		
	include('../configuration.php');
	
	$conf = new JConfig;
	mysql_connect($conf->host,$conf->user,$conf->password);
	mysql_select_db($conf->db);
	
	function getPrice($price)
		{
			global $conf; 
			$pr = (float) $price;
			if ($pr>0)
				{
					$sql = 'SELECT * FROM `'.$conf->dbprefix.'car_detail_prices` WHERE `p_id`=10 AND `price`>'.$pr.' ORDER BY `price` LIMIT 1';//echo $sql.'<br>';
					$rows = mysql_query($sql);
					while($row = mysql_fetch_object($rows))
						{
							$mas->price = $row->price;
							$mas->type = $row->type;
							$mas->value = $row->value;
						}
					if ($mas->type=='*')
						{
							$pr = $pr + $mas->value;
						}
					if ($mas->type=='%')
						{
							$pr = round(($price*(1 + $mas->value/100)),2);
						}
					$price = $pr;
				}
			return $price;
		}
		
	$CountryID = '82'; //KZ = 82 / CountryID const
	$textPartN = ($_GET['art']) ? $_GET['art'] : '';
	$chkIncludeSubs = true;
	$postfields = "CountryID=".$CountryID."&txtPartN=".$textPartN."&chkIncludeSubs=".chkIncludeSubs; 
	$url = 'http://ra.ae/priceonline.php';

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
	
	$startIndex = strpos($result, "<table class='PriceOnlineParts'"); 
	$endIndex = strpos($result, "<br><input type = 'submit' name = 'btnAddToCartFromPriceOnline");
	$result = substr($result, $startIndex, $endIndex - $startIndex);
	
	$mas = new stdClass;
	$mas->table->tr = array();
	$counttr = substr_count($result,'<tr');
	$trpos = 0;
	$trposed = 0;
	for($i=0;$i<$counttr;$i++)
		{
			$trpos = strpos($result,'<tr',$trpos+1);
			$trposed = strpos($result,'</tr>',$trposed+1)+5;
			$text = substr($result,$trpos,$trposed-$trpos);
			
			$tdpos = 0;
			$tdposed = 0;
			$counttd = substr_count($text,'<td');
			$countth = substr_count($text,'<th');
			for($j=0;$j<$counttd;$j++)
				{
					$tdpos = strpos($text,'<td',$tdpos+1);
					$tdposed = strpos($text,'</td>',$tdposed+1)+5;
					$mas->table->tr[$i]->td[$j]->text = substr($text,$tdpos,$tdposed-$tdpos);
				}
			for($j=0;$j<$countth;$j++)
				{
					$tdpos = strpos($text,'<th',$tdpos+1);
					$tdposed = strpos($text,'</th>',$tdposed+1)+5;
					$mas->table->tr[$i]->th[$j]->text = substr($text,$tdpos,$tdposed-$tdpos);
				}
		}
	//pr($mas);
	//echo $result;
	
	echo '<table class="PriceOnlineParts" width="100%">';
	if (count($mas->table->tr)>0)
		{
			foreach($mas->table->tr as $tr)
				{
					echo '<tr>';$i=0;
					if ($tr->td) foreach($tr->td as $td)
						{
							if (($i==9) or ($i==10))
								{
									$price = strip_tags($td->text);
									$newprice = getPrice($price);
									echo '<td>'.$newprice.'</td>';
								}
							else
								{
									echo $td->text;
								}
							$i++;
						}
					if ($tr->th) foreach($tr->th as $td)
						{
							echo $td->text;
						}
					echo '</tr>';
				}
		}
	else
		{
			echo '<tr>
				<th>По вашему запросу ничего не найдено</th>
				<th></th>
				<th></th>
			</tr>
			<tr>
				<th>По вашему запросу ничего не найдено</th>
				<th></th>
				<th></th>
			</tr>';
				
		}
	echo '</table>';
	
	
	
	