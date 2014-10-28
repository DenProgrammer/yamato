<?php
header ("Content-Type: text/html; charset=utf-8");
class Dictionary
	{
		var $host;
		var $user;
		var $db;
		var $pass;
		function __construct()
			{
				$config = new JConfig;
				
				$this->db = $config->db; //Имя базы данных
				$this->user = $config->user; //Имя пользователя базы данных
				$this->pass = $config->password; //Пароль пользователя базы данных
				$this->host = $config->host; //Сервер базы данных
			}
		function query($sql)
			{
				$mysql_connect  = mysql_connect($this->host, $this->user, $this->pass);
				mysql_select_db($this->db);
				mysql_query("SET NAMES 'UTF8'");
				
				return  mysql_query($sql);
			}
		function translate($curl_html)
			{
				$sql1 = "SELECT * FROM jos_dictionary_of_carparts";
				$sql2 = "SELECT * FROM jos_dictionary_of_carparts_phrases";
				
				$dictionary_words = array();
				$dictionary_phrase = array();
				$result  = $this->query($sql1);
				while($row = mysql_fetch_object($result)){
						$dictionary_words[$row->en_name] = $row->ru_name;
				}
				$result2  = $this->query($sql2);
				while($row = mysql_fetch_object($result2)){
						$dictionary_phrase[$row->en_name] = $row->ru_name;
				}
				
				
				$en_array = array();
				$ru_array = array();
				
				$en_array_phrase = array();
				$ru_array_phrase = array();
				
				foreach($dictionary_phrase as $key => $value)
				{
					array_push($en_array_phrase, $key);
					array_push($ru_array_phrase, $value);
				}
				
				foreach($dictionary_words as $key => $value)
				{
					array_push($en_array, $key);
					array_push($ru_array, $value);
				}
				
				//$curl_html = mb_strtolower($curl_html,'UTF8');
				$curl_html = str_ireplace($en_array_phrase, $ru_array_phrase, $curl_html);
				$curl_html = str_ireplace($en_array, $ru_array, $curl_html);
				return $curl_html;
	
			}	
	}
	
	
	//echo $dict->translate("<b>"."Body parts consists of different oil engine categories. HEATING & AIR CONDITIONING - WATER PIPING is provided by our toyota Dealer"."<b>"."<br />");
?>

	
	
