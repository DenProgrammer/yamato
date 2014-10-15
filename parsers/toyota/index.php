<?php
    header ("Content-Type: text/html; charset=utf-8");
	include("../../configuration.php");
	include('../dictionary_details_function.php');
	
	if($_GET['step']>0) $step = $_GET['step']; else	$step = 1;
	
	
	if ($_POST['cat']) $cat  = $_POST['cat']; else $cat  = $_GET['cat'];
	if ($_POST['mdl']) $mdl  = $_POST['mdl']; else $mdl  = $_GET['mdl'];
	if ($_POST['cd'])  $cd   = $_POST['cd']; else $cd    = $_GET['cd'];
	if ($_POST['carea']) $ca = $_POST['carea']; else $ca = $_GET['carea'];
	if ($_POST['grp']) $grp  = $_POST['grp']; else $grp  = $_GET['grp'];
	if ($_POST['sec']) $sec  = $_POST['sec']; else $sec  = $_GET['sec'];
	if ($_POST['artikul']) $textPartN = $_POST['artikul']; else $textPartN = $_GET['artikul'];
	
	$CountryID = '82'; //KZ = 82 / CountryID const
   
	$postfields = ''; 
	
	if($step == 1)
		$url = "http://old.japancars.ru/cat/toyota/";
	
	else if($step == 2)
		$url = 'http://old.japancars.ru/cat/toyota/?carea=' . $ca;
	
	else if($step == 3)
		$url = 'http://old.japancars.ru/cat/toyota/index.php?carea='.$ca.'&cat='.$cat;
	
	else if($step == 4)
		$url = 'http://old.japancars.ru/cat/toyota/index.php?cd='.$cd.'&cat='.$cat.'&mdl='.$mdl;
	
	else if($step == 5)
		$url = 'http://old.japancars.ru/cat/toyota/index.php?cd='.$cd.'&cat='.$cat.'&mdl='.$mdl.'&grp='.$grp;
		
	else if($step == 6)
	{
		$url = 'http://old.japancars.ru/cat/toyota/index.php?cd='.$cd.'&cat='.$cat.'&mdl='.$mdl.'&sec='.$sec;
	}
	else if ($step == 7)
	{
		$postfields = "CountryID=".$CountryID."&txtPartN=".$textPartN; 
		$url = 'http://ra.ae/priceonline.php';
		echo $postfields;
	}
	else if($step == 8)
	{
		$textPartN = "09111-35140";
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
	
	if($step > 0)
	{
		$result = str_replace('src="images', 'src="parsers/toyota/images/', $result);
		$result = str_ireplace('submit', 'button', $result);
		$result = str_ireplace('onChange', 'onch', $result);
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
		
		$result = substr($result, $startIndex, $endIndex); 
		
		?>
		<script>	
			jQuery(document).ready(function() {
				jQuery('select[name=carea]').change(function(){
					var carArea = $('select[name=carea] option:selected').val();
					var url = 'http://yamato.kg/new/parsers/toyota/index2.php?carea='+carArea;
					var pageUrl = "parsers/toyota/index.php?step=2&carea="+carArea;
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
	   
		$result = str_replace($arr1,$arr2,$result);

		?>
		
		<script>	
			jQuery(document).ready(function() {
				jQuery("input[name='frame1']").parent().parent().parent().hide();
				jQuery("input[name='vin']").parent().parent().parent().hide();
				jQuery('.headerr:first').hide();
				jQuery('.headerr:eq(1)').hide();
				jQuery("scriptus").remove();
				
				var obj = '<table><tr><td><b>Модель</b></td><td><select name="mdl" class="text">'+jQuery('select[name=mdl]').html()+'</select></td></tr></table>';
				jQuery("#result").html(obj);
				
				jQuery('select[name=mdl]').change(function() {
					var carArea = jQuery("#active_carArea").html();
					var carModel = jQuery('select[name=mdl] option:selected').val();
					
					var pageUrl = "parsers/toyota/index.php?step=3&carea="+carArea+"&cat="+carModel;
					saveUrl(pageUrl);
					setUrl(pageUrl);
				});
						
			});
		</script>
		<?php			
	}
	
	else if($step == 3)
	{
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">','<br>','<nobr>');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','type="text/css"></linkus>','','');
	    $result = str_replace($arr1,$arr2,$result);
		
		
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
		
		$result = removeScriptus($result);
		
		$dict = new Dictionary;
		$result = $dict->translate($result);
		
		?>
		
		<script>
			jQuery(document).ready(function() {
				
				jQuery("#result table tr:first-child th").attr("bgcolor","#c3c3c3");
				jQuery("table").attr("width","100%");
				jQuery("td[width='1%']").attr("width","100%");
				
				jQuery('#dataupload a').click(function(event){
					event.preventDefault();
				});
				
				jQuery('#dataupload a').click(function() {
					var params = jQuery(this).attr('href');
					var url = 'index.php' + params;
					
					var pageUrl = "parsers/toyota/index.php"+params+"&step=4";
					saveUrl(pageUrl);
					setUrl(pageUrl);
				});
				
				jQuery('td[height="1%"]').hide();
			});
		</script>	
		<?php
	}
	
	else if($step == 4)
	{
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','type="text/css"></linkus>');
	    
		$result = str_replace($arr1,$arr2,$result);
		
		$result = removeScriptus($result);
		
		$dict = new Dictionary;
		$result = $dict->translate($result);
		
		?>
			<script>
			jQuery(document).ready(function() {
				jQuery('#dataupload a').click(function(event){
					event.preventDefault();
				});
				
				jQuery('#dataupload li a').click(function() {
					var params = jQuery(this).attr('href');                    							
							
					var pageUrl = "parsers/toyota/index.php"+params+"&step=5";
					saveUrl(pageUrl);
					setUrl(pageUrl);
				});
				
				jQuery('#result ul').css('list-style-type: none;');
				jQuery('td[height="1%"]').hide();
				jQuery(".pad10").hide();
			});
			</script>
		<?php
	}
	
	else if($step == 5)
	{
		//echo "Step 5";
		$arr1 = array('image.php?cd=');
		$arr2 = array('http://old.japancars.ru/cat/toyota/image.php?cd=');
		
		$result  = str_replace($arr1, $arr2, $result);
	   
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','type="text/css"></linkus>');
	   
		$result = str_replace($arr1, $arr2, $result);
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
	   
	    $result = removeScriptus($result);
		
		$dict = new Dictionary;
		$result = $dict->translate($result);
		
		?>
		
		<script>
		
		jQuery(document).ready(function() {
			jQuery('td[height="1%"]').hide();
			jQuery(".pad10").hide();
			jQuery("#result table tr:first-child th").attr("bgcolor","#c3c3c3");
			
			jQuery('#dataupload a').click(function(event){
				event.preventDefault();
			});
			
			jQuery('body,html').animate({scrollTop: 0}, 400);
			
			jQuery('#dataupload td a').click(function() {
				var params = jQuery(this).attr('href');                    							
						
				var pageUrl = "parsers/toyota/index.php"+params+"&step=6";
				saveUrl(pageUrl);
				setUrl(pageUrl);
				
			});	
			jQuery('a img').hide();
		});		
			</script>
		
		<?php
	}
	
	else if($step == 6)
	{		
		$arr1 = array('image.php?cd=');
		$arr2 = array('http://old.japancars.ru/cat/toyota/image.php?cd=');
	  
		$result  = str_replace($arr1, $arr2, $result);
	   
		$arr1 = array('<script','</script>','<style','</style>','<link','type="text/css">');
		$arr2 = array('<scriptus','</scriptus>','<styleus','</styleus>','<linkus','type="text/css"></linkus>');
	   
		$result = str_replace($arr1, $arr2, $result);
		$result = iconv("windows-1251","UTF-8//IGNORE", $result);
	   
	    $result = removeScriptus($result);
		
		$dict = new Dictionary;
		$result = $dict->translate($result);
		
		?>
		<script>
		function rollout(id)
			{
			
			}
		var oActive = null; 
			jQuery(document).ready(function() {
				jQuery('td[height="1%"]').hide();
				jQuery(".pad10").hide();
					
				jQuery('#dataupload td a').click(function() {
					var id = this.id;
					
					id2 = id.replace('t', 'd1');
				
					var detailCode = jQuery("div #" + id2 +" nobr b").html();
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
					var pageUrl = "parsers/toyota/index.php"+params+"&step=7";
					mainFind(detailCode);
				});
			
				jQuery('a img').hide();
			});
				
		</script>
		<?php
	}

	echo $result; 
?>

	
	

    