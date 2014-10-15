<?php
/**
 * @version		$Id: edit.php 20549 2011-02-04 15:01:51Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

	// No direct access.
	defined('_JEXEC') or die;

	header('Content-type: text/html; charset=utf-8');
	
	function getData($url,$post_data)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLINFO_HEADER_OUT, false);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); // сохранять куки в файл
			curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');

			$data = curl_exec($ch);
			$response = curl_getinfo ($ch);
			
			curl_close($ch);
			
			return $data;
		}
		
	$url = 'http://was.autoserver.co.jp/indexe.asp';
	
	$p = str_replace('&amp;','&',base64_decode($_GET['p']));
	//echo $p.'<br>';
	if (strpos($p, 'asnete/cp')){
		$auk = 'cp';
	}
	if (strpos($p, 'asnete/ct')){
		$auk = 'ct';
	}
	$cor = '';
	$exh = '';
	$mak = '';
	$car = '';
	$typ = '';
	if ($p) 
		{
			$url = $p;
			
			$t1 = explode('?',$p);
			$t2 = explode('&',$t1[1]);
			foreach($t2 as $item)
				{
					$t3 = explode('=',$item);
					$mas[$t3[0]] = $t3[1];
				}
			
			$cor = $mas['cor'];
			$exh = $mas['exh'];
			$mak = $mas['mak'];
			$car = $mas['car'];
			$typ = $mas['typ'];
		}
	$step = 0;
	if ($mak) $step = 1;
	if ($car) $step = 2;
	if ($exh) $step = 4;
	if ($typ) $step = 5;
	$post_data = '';
	$data = getData($url,$post_data);
	
	if (((strpos($data,'user_ID')) and (strpos($data,'passwd'))) or (strpos($data,'history.back')) or (empty($p)))
		{
			$post_data = 'user_ID='.$this->userid.'&passwd='.$this->passwd;
			$url = 'http://was.autoserver.co.jp/asnete/top/cookie.asp';
			$data = getData($url,$post_data);
			
			$url = 'http://was.autoserver.co.jp/asnete/'.$auk.'/main/maker.asp';
			$data = getData($url,'');
		}
	
	$result = '';
	if ($step > 3) $result = $url;
	
	$search = array("'",'<style','</style>','<script','</script>','http://was.autoserver.co.jp/','href=\'','href="','oncontextmenu="return false"');
	$replace = array('"','<styleus','</styleus>','<scriptus','</scriptus>','','href=\'/','href="/','');
	$data = str_ireplace($search, $replace, $data);

	$pos = strrpos($url,'/');
	$domen = substr($url,0,$pos);
	//echo $url.'<br>';
	
	$pattern = '/(href=")(.+)(")/U';
	preg_match_all($pattern, $data, $arr);
	$search = $arr[2];
	$c = count($search);
	if ($p) $d = $domen; else $d = 'http://was.autoserver.co.jp/asnete/'.$auk.'/main';
	for($i=0;$i<$c;$i++)
		{
			$searcharr[$i] = 'href="'.$search[$i].'"';
			$replarr[$i] = 'href="index.php?option=com_auk&p='.base64_encode($d.$search[$i]).'"';
		}
	$data = str_replace($searcharr, $replarr, $data);
?>
<table cellspacing="0" cellpadding="5" border="0" style="margin: 0 auto; table-layout: fixed;" >
	<tr height="110" align="left"> 
		<td width="250">
			<a href="index.php?option=com_auk&p=<?php echo base64_encode('http://was.autoserver.co.jp/asnete/ct/main/maker.asp') ?>">
				<img width="160" height="100" border="0" name="Image12" src="http://was.autoserver.co.jp//asnete/images/icon_oneprice.gif" />
			</a>
		</td>
		<td width="250">
			<a href="index.php?option=com_auk&p=<?php echo base64_encode('http://was.autoserver.co.jp/asnete/cp/main/maker.asp') ?>">
				<img width="160" height="100" border="0" name="Image14" src="http://was.autoserver.co.jp//asnete/images/icon_asmember.gif" />
			</a>
		</td>
		<td width="250" class="sendbtn" ></td>
	</tr>
</table>	
<div class="curl"><?php echo $data; ?></div>
<style>
<?php if ($step == 0) { ?>
div.curl table tr td{
	font-size:0px;
}
<?php } else { ?>
div.curl table tr td{
	text-align:left;
	padding-left:10px;
}
<?php } ?>
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="components/com_auk/assets/auk.js"></script>
<script>
	var domen = '<?php echo $domen; ?>';
	var p = '<?php if ($p) echo 2; else echo 1; ?>';
	var step = <?php echo $step; ?>;
	var loststep = '<?php if ((strpos($p,'cardetail.asp')) or (strpos($p,'cardetail_il.asp'))) echo 1; else echo 0; ?>';
	var result = '<?php echo $result; ?>';
	var result_url = '<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>';
	var auk = '<?php echo $auk; ?>';
</script>