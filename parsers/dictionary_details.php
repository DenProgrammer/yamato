<?php header('Content-Type: text/html; charset=windows-1251'); ?> 
<?php
	include("../configuration.php");
	$config = new JConfig;
	
	$mysql_database = $config->db; //��� ���� ������
	$mysql_username = $config->user; //��� ������������ ���� ������
	$mysql_password = $config->password; //������ ������������ ���� ������
	$mysql_host 	= $config->host; //������ ���� ������
	$dbpf			= "jos_"; //������� ������ � ���� ������
	
	//����������� � ����� ������
	$mysql_connect  = mysql_connect($mysql_host, $mysql_username, $mysql_password);
	//�������� ���� ������ ��� ������
	mysql_select_db($mysql_database);
	//������������� ��������� ��� ���������� ���� ������
	mysql_query("SET NAMES cp1251");
	
	$result  = mysql_query("SELECT * FROM jos_dictionary_of_carparts");
	$result2 = mysql_query("SELECT * FROM jos_dictionary_of_carparts_phrases");
	
	$dictionary_words = array();
	$dictionary_phrase = array();
	
	$en_array = array();
	$ru_array = array();
	
	$en_array_phrase = array();
	$ru_array_phrase = array();
	
	echo "<h2> ������� ��������� </h2>";
	
	while($row = mysql_fetch_object($result2)){
			$dictionary_phrase[$row->en_name] = $row->ru_name;
	}
	
	while($row = mysql_fetch_object($result)){
			$dictionary_words[$row->en_name] = $row->ru_name;
	}
	
	/*
	echo '<pre>';
		print_r($dictionary_phrase);
	echo '</pre>';
	*/
	
	foreach($dictionary_phrase as $key => $value)
	{
		echo $key.' '. ' ' .$value . ' '.'<br />';
		array_push($en_array_phrase, $key);
		array_push($ru_array_phrase, $value);
	}
	
	foreach($dictionary_words as $key => $value)
	{
		echo $key.' '. ' ' .$value . ' '.'<br />';
		array_push($en_array, $key);
		array_push($ru_array, $value);
	}
	
	for($i = 0; $i < count($dictionary_phrase); $i++)
	{
		echo $dictionary_phrase[$i];
	}
	
	echo "<br />";
	$curl_html = "<b>"."Body parts consists of different oil engine categories. HEATING & AIR CONDITIONING - WATER PIPING is provided by our toyota Dealer"."<b>"."<br />";
	echo $curl_html;
	
	$curl_html = strtolower($curl_html);
	$curl_html = str_replace($en_array_phrase, $ru_array_phrase, $curl_html);
	$curl_html = str_replace($en_array, $ru_array, $curl_html);
	echo $curl_html;
?>

<hr />
<form action="">
	����. ����� <input type="text" name="en_name" />
	������� ��������<input type="text" name="ru_name" />
	<br />
	<input type="submit" value="�������� �����">
</form>

<form action="">
	����. ����� <input type="text" name="en_name" />
	������� ��������<input type="text" name="ru_name" />
	<br />
	<input type="submit" value="�������� ��������������">
</form>
	
	
	
