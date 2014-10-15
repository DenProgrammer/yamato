<?php

	$katalog = ($_GET['katalog']) ? htmlspecialchars($_GET['katalog']) : 'toyota';
	$filename = 'parsers/parser_'.$katalog.'.php';
	
	if (file_exists($filename)) include($filename);

?>
<link rel="stylesheet" href="parsers/<?php echo $katalog; ?>/style.css" type="text/css" />