<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	fwrite(fopen('d:/xampp/htdocs/dev.yamato.kg/log.txt', 'a+'), date("d.m.Y H:i:s")."\r\n\r\n");
	foreach($this->links as $item){
		$link = $item->link;
		
		$ch = curl_init();

		$url = 'http://yamato.kg/index.php?option=com_sincronise&type=loadCars&tmpl=ajax&link='.$link;
		curl_setopt($ch, CURLOPT_URL, $url[$step]);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$request = curl_exec($ch);

		fwrite(fopen('d:/xampp/htdocs/dev.yamato.kg/log.txt', 'a+'), "link = $link\r\nrequest data - $request\r\n\r\n");
	}