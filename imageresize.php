<?php
header('Content-Type: text/plain; charset=utf8');
error_reporting(0);
function create_small($name_big,$name_small,$max_x, $max_y) {
	if (is_file($name_big))
		{
			list($x, $y, $t, $attr) = getimagesize($name_big);
 
			if ($t == IMAGETYPE_GIF)
				$big = imagecreatefromgif($name_big);
			else if ($t == IMAGETYPE_JPEG)
				$big = imagecreatefromjpeg($name_big);
			else if ($t == IMAGETYPE_PNG)
				$big = imagecreatefrompng($name_big);
 
			if ($x > $y)
				{
					$xs = $max_x;
					$ys = $max_x/($x/$y);
				}
			else
				{
					$ys = $max_y;
					$xs = $max_y/($y/$x);
				}
			$small = imagecreatetruecolor ($xs,$ys);
			$res = imagecopyresampled($small,$big,0,0,0,0,$xs,$ys,$x,$y);
			imagedestroy($big);
			imagejpeg($small,$name_small, 90);
			imagedestroy($small);  
		}
} 		
function searchimg($path)
	{
		$max_width = 800;
		$max_height = 600;
		
		$dir = opendir($path);
		while($file = readdir($dir))
			{
				if (($file != '.') and ($file != '..')) 
					{
						if (is_dir($path.'/'.$file))
							{
								searchimg($path.'/'.$file);
							}
						else
							{
								try{
									$image = getimagesize($path.'/'.$file);
									$width = $image[0];
									$height = $image[1];
									$mime_type = $image['mime'];
								} catch (Exception $e) {
									$mime_type = '';
									$width = 0;
									$height = 0;
								}
								
								if (in_array($mime_type, $access_mime)) {
									if ($width > $max_width) {		
										//system("convert -quality 90 -resize $max_width".'x'."$max_height $path/$file $path/$file");	
										create_small("$path/$file", "$path/$file", $max_width, $max_height);	
									}
								}
							}
					}
			}
	}
searchimg('./1c');  

?>