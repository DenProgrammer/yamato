<?php
	header('Content-type: text/html; charset=x-sjis');
	
	function pr($var)
		{
			echo '<pre>';
			print_r($var);
			echo '</pre>';
		}
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
			curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); // сохран€ть куки в файл
			curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');

			$data = curl_exec($ch);
			$response = curl_getinfo ($ch);
			//pr(curl_getinfo($ch));
			curl_close($ch);
			$f = fopen('logcurl.txt','a');
			fwrite($f,$data);
			fclose($f);
			//$data = iconv(mb_detect_encoding($data),'utf-8',$data);
			
			return $data;
		}
		
	$url = 'http://was.autoserver.co.jp/indexe.asp';
	//$url = 'http://rambler.ru';
	
	$step = (int) $_GET['step'];
	$p = base64_decode($_GET['p']);
	if ($p) $url = $p;
	$post_data = '';
	$data = getData($url,$post_data);

	if (((strpos($data,'user_ID')) and (strpos($data,'passwd'))) or (strpos($data,'history.back')))
		{
			$post_data = 'user_ID=E0000274&passwd=1fc9sgk5';
			$url = 'http://was.autoserver.co.jp/asnete/top/cookie.asp';
			$data = getData($url,$post_data);
			
			$url = 'http://was.autoserver.co.jp/asnete/ct/main/maker.asp';
			$data = getData($url,'');
		}
	
	//echo $url.'<br>';
	
	if ($step >= 3)
		{
			//$mas = explode('?',$url);
			$result = $url;//$mas[1];
		}
	$search = array('<style','</style>','<script','</script>','http://was.autoserver.co.jp/','href=\'','href="','//','oncontextmenu="return false"');
	$replace = array('<styleus','</styleus>','<scriptus','</scriptus>','','href=\'/','href="/','/','');
	$data = str_ireplace($search, $replace, $data);

	echo '<div class="curl">'.$data.'</div>';
	
	$pos = strrpos($url,'/');
	$domen = substr($url,0,$pos);
?>
<style>
div.curl table tr td{
	text-align:left;
	padding-left:10px;
}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>


	var Base64 = {
		_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
		
		encode : function (input) {
			var output = "";
			var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
			var i = 0
			input = Base64._utf8_encode(input);
			while (i < input.length) {
				chr1 = input.charCodeAt(i++);
				chr2 = input.charCodeAt(i++);
				chr3 = input.charCodeAt(i++);
				enc1 = chr1 >> 2;
				enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
				enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
				enc4 = chr3 & 63;
				if( isNaN(chr2) ) {
					enc3 = enc4 = 64;
				}else if( isNaN(chr3) ){
					enc4 = 64;
				}
				output = output +
				this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
				this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
			}
			return output;
		},
 
		decode : function (input) {
			var output = "";
			var chr1, chr2, chr3;
			var enc1, enc2, enc3, enc4;
			var i = 0;
			input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
			while (i < input.length) {
				enc1 = this._keyStr.indexOf(input.charAt(i++));
				enc2 = this._keyStr.indexOf(input.charAt(i++));
				enc3 = this._keyStr.indexOf(input.charAt(i++));
				enc4 = this._keyStr.indexOf(input.charAt(i++));
				chr1 = (enc1 << 2) | (enc2 >> 4);
				chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
				chr3 = ((enc3 & 3) << 6) | enc4;
				output = output + String.fromCharCode(chr1);
				if( enc3 != 64 ){
					output = output + String.fromCharCode(chr2);
				}
				if( enc4 != 64 ) {
					output = output + String.fromCharCode(chr3);
				}
			}
			output = Base64._utf8_decode(output);
			return output;
		},
		
		_utf8_encode : function (string) {
			string = string.replace(/\r\n/g,"\n");
			var utftext = "";
			for (var n = 0; n < string.length; n++) {
				var c = string.charCodeAt(n);
				if( c < 128 ){
					utftext += String.fromCharCode(c);
				}else if( (c > 127) && (c < 2048) ){
					utftext += String.fromCharCode((c >> 6) | 192);
					utftext += String.fromCharCode((c & 63) | 128);
				}else {
					utftext += String.fromCharCode((c >> 12) | 224);
					utftext += String.fromCharCode(((c >> 6) & 63) | 128);
					utftext += String.fromCharCode((c & 63) | 128);
				}
			}
			return utftext;
		},
 
		_utf8_decode : function (utftext) {
			var string = "";
			var i = 0;
			var c = c1 = c2 = 0;
			while( i < utftext.length ){
				c = utftext.charCodeAt(i);
				if (c < 128) {
					string += String.fromCharCode(c);
					i++;
				}else if( (c > 191) && (c < 224) ) {
					c2 = utftext.charCodeAt(i+1);
					string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
					i += 2;
				}else {
					c2 = utftext.charCodeAt(i+1);
					c3 = utftext.charCodeAt(i+2);
					string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
					i += 3;
				}
			}
		return string;
		}
	}
	
	jQuery.noConflict();
	jQuery('document').ready(function($){

		$('div.curl scriptus').remove();
		$('div.curl styleus').remove();
		
		$('div.curl img').each(function(){
			var src = $(this).attr('src');
			
			var url = domen+'/'+src;
			if (url.indexOf('../cardetail'))
				{
					url = url.replace('cardetail','');
					if (loststep == 1) 
						{
							url = url.replace(/asnete.[a-z]+.main/,'');
						}
					if (p == 1) url = url.replace('asnete/top/','');
				}
			$(this).attr('src',url);
		});
		
		$('div.curl a').click(function(){
			if (p == 1) document.location = 'curl.php?p='+Base64.encode('http://was.autoserver.co.jp/asnete/ct/main'+$(this).attr('href'))+'&step='+parseInt(step+1);
			if (p > 1) document.location = 'curl.php?p='+Base64.encode(domen+$(this).attr('href'))+'&step='+parseInt(step+1);
			return false;
		})
		
		if (result) 
			{
				$('div.curl').prepend('<div><input id="zakaz" type="button" value="SAVE" /></div>')
				$('#zakaz').click(function(){
					$.get('index.php?option=com_auk&view=mail',{link:result},function(data){
						alert('—сылка на выбранное авто отправлена на почту администратору');
					});
				});
			}
			
			
		switch(step)
			{
				case 0:
				case 1:
				case 2:
					{
						$('div.curl table:first tr:first').remove();
						$('div.curl table:first tr:first td:first').remove();
						break;
					}
				case 3:
					{
						$('div.curl a img.posabs').remove();
						break;
					}
			}
	});
	
	
	var domen = '<?php echo $domen; ?>';
	var p = '<?php if ($p) echo 2; else echo 1; ?>';
	var step = <?php echo $step; ?>;
	var loststep = '<?php if ((strpos($p,'cardetail.asp')) or (strpos($p,'cardetail_il.asp'))) echo 1; else echo 0; ?>';
	var result = '<?php echo $result; ?>';
</script>