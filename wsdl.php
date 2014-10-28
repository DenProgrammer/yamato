<?php
function pr($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
class Array2XML {
     
    private $writer;
    private $version = '1.0';
    private $encoding = 'UTF-8';
     
 
    function __construct() 
		{
			$this->writer = new XMLWriter();
		}
     
    public function convert($data) 
		{
			$this->writer->openMemory();
			$this->writer->startDocument($this->version, $this->encoding);
			if ((is_array($data)) or (is_object($data))) 
				{
					$this->getXML($data);
				}
			$this->writer->endElement();
			return $this->writer->outputMemory();
		}
    public function setVersion($version) 
		{
			$this->version = $version;
		}
    public function setEncoding($encoding) 
		{
			$this->encoding = $encoding;
		}
    public function setRootName($rootName) 
		{
			$this->rootName = $rootName;
		}
    private function getXML($data) 
		{
			foreach ($data as $key=>$val) 
				{
					if (is_numeric($key)) 
						{
							$key = 'row'.$key;
						}
					if (is_array($val)) 
						{
							$this->writer->startElement($key);
							$this->getXML($val);
							$this->writer->endElement();
						}
					elseif (is_object($val)) 
						{
							$this->writer->startElement($key);
							$this->getXML($val);
							$this->writer->endElement();
						}
					else 
						{
							$this->writer->writeElement($key, $val);
						}
				}
		}
}
class XML implements ArrayAccess, IteratorAggregate, Countable 
	{
		private $pointer;
		private $tagName;
		private $attributes = array();
		private $cdata;
		private $parent;
		private $childs = array();
         
		public function __construct($data) 
			{
				if (is_array($data)) 
					{
						list($this->tagName, $this->attributes) = $data;
					} 
				else if (is_string($data))
				$this->parse($data);
			}
         
		public function __toString() 
			{
				return $this->cdata.'';
			}

		public function __get($name) 
			{
				if (isset($this->childs[$name])) 
					{
						if (count($this->childs[$name]) == 1) return $this->childs[$name][0]; else return $this->childs[$name];
					}
				throw new Exception("UFO steals [$name]!");
			}
         
		public function offsetGet($offset) 
			{
				if (isset($this->attributes[$offset])) return $this->attributes[$offset];
				throw new Exception("Holy cow! There is'nt [$offset] attribute!");
			}
         
		public function offsetExists($offset) 
			{
				return isset($this->attributes[$offset]);
			}
         
		public function offsetSet($offset, $value) { return; }
		public function offsetUnset($offset) { return; }

		public function count() 
			{
				if ($this->parent != null) return count($this->parent->childs[$this->tagName]);
				return 1;
			}
         
		public function getIterator() 
			{
				if ($this->parent != null) return new ArrayIterator($this->parent->childs[$this->tagName]);
				return new ArrayIterator(array($this));
			}
     
		public function getAttributes() 
			{
				return $this->attributes;
			}
         
		public function appendChild($tag, $attributes) 
			{
				$element = new XML(array($tag, $attributes));
				$element->setParent($this);
				$this->childs[$tag][] = $element;
				return $element;
			}
         
		public function setParent(XML $parent) 
			{
				$this->parent =& $parent;
			}
         
		public function getParent()
			{
				return $this->parent;
			}
         
		public function setCData($cdata) 
			{
				$this->cdata = $cdata;
			}
         
		private function parse($data) 
			{
				$this->pointer =& $this;
				$parser = xml_parser_create();
				xml_set_object($parser, $this);
				xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
				xml_set_element_handler($parser, "tag_open", "tag_close");
				xml_set_character_data_handler($parser, "cdata");
				xml_parse($parser, $data);
			}
        
		private function tag_open($parser, $tag, $attributes) 
			{
				$this->pointer =& $this->pointer->appendChild($tag, $attributes);
			}
     
		private function cdata($parser, $cdata) 
			{
				$this->pointer->setCData($cdata);
			}
     
		private function tag_close($parser, $tag) 
			{
				$this->pointer =& $this->pointer->getParent();
			}
	}
	
	require('configuration.php');
	header('Content-type: text/html; charset=utf-8');
	function GetListOrders()
		{
			$config = new JConfig;
			
			$prfx = $config->dbprefix;
			mysql_connect($config->host,$config->user,$config->password) or die('no connect');
			mysql_select_db($config->db) or die('no select db');
			
			$sql = 'SELECT * FROM `'.$prfx.'vm_orders`';
			$rs = mysql_query($sql);
			while($r = mysql_fetch_object($rs))
				{
					$sql = 'SELECT * FROM `'.$prfx.'vm_order_item` WHERE `order_id`='.$r->order_id;
					$rows = mysql_query($sql);
					while($row = mysql_fetch_object($rows))
						{
							$r->items = $row;
						}
					$orders[] = $r;
				}
				
			$obj->a = 1;	
			$obj->b = 2;	
			$obj->c = 3;

			$arr = array('0'=>'arr1','1'=>'arr2','2'=>'arr3');
			
			$str = 'string';
				
				
			return $arr;	
			/*$converter = new Array2XML();
			$xmlStr = $converter->convert($orders);
			 
			return $xmlStr;*/
		}
	//echo GetListOrders();
	ini_set("soap.wsdl_cache_enabled", "0");
	$server = new SoapServer('1.wsdl');

	$server->addFunction('GetListOrders');
	$server->handle();

?>