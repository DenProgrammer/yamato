<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
* ECB Currency Converter Module
* 
* @version $Id: convertECB.php 1948 2009-09-30 14:32:48Z soeren_nb $
* @package VirtueMart
* @subpackage classes
* @copyright Copyright (C) 2004-2007 soeren - All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/

/**
 * This class uses the currency rates provided by an XML file from the European Central Bank
 * Requires cURL or allow_url_fopen
 */
 
 class myXML implements ArrayAccess, IteratorAggregate, Countable {
      /**
       * ��������� �� ������� �������
       * @var XML
       */
      private $pointer;
      /**
       * �������� ��������
       * @var string
       */
      private $tagName;
      /**
       * ������������� ������ ���������
       * @var array
       */
      private $attributes = array();
      /**
       * ���������� ��������
       * @var string
       */
      private $cdata;
      /**
       * ��������� �� ������������ �������
       * @var XML
       */   
      private $parent;
      /**
       * ������ ��������, ����:
       * array('tag1' => array(0 =>, 1 => ...) ...)
       * @var array
       */
      private $childs = array();
         
      /**
       * ����������� �� ������ � xml-�������
       * ��� ������ ���� array('��������', array('��������'))
       * @var array|string $data
       */
      public function __construct($data) {
          if (is_array($data)) {
            list($this->tagName, $this->attributes) = $data;
          } else if (is_string($data))
              $this->parse($data);
      }
         
      /**
       * ����� ��� ������� � ���������� ��������
       * @return stirng
       */
      public function __toString() {
          return $this->cdata.'';
      }
         
      /**
       * ������ � ������� ��� ������� ��������
       * @var string $name
       * @return XML|array
       */
      public function __get($name) {
          if (isset($this->childs[$name])) {
            if (count($this->childs[$name]) == 1)
                  return $this->childs[$name][0];
            else
                  return $this->childs[$name];
          }
          throw new Exception("UFO steals [$name]!");
      }
         
      /**
       * ������ � ��������� �������� ��������
       * @var string $offset
       * @return mixed
       */
      public function offsetGet($offset) {
          if (isset($this->attributes[$offset]))
            return $this->attributes[$offset];
            throw new Exception("Holy cow! There is'nt [$offset] attribute!");
      }
         
      /**
       * �������� �� ������������� ��������
       * @var string $offset
       * @return bool
       */
      public function offsetExists($offset) {
          return isset($this->attributes[$offset]);
      }
         
      /**
       * �������
       */
      public function offsetSet($offset, $value) { return; }
      public function offsetUnset($offset) { return; }
     
      /**
       * ���������� ���������� ��������� � ���� ������ � ��������
       * @return integer
       */
      public function count() {
            if ($this->parent != null)
                  return count($this->parent->childs[$this->tagName]);
            return 1;
      }
         
      /**
       * ���������� �������� �� ������� ����������� ���������
       * @return ArrayIterator
       */
      public function getIterator() {
            if ($this->parent != null)
                  return new ArrayIterator($this->parent->childs[$this->tagName]);
            return new ArrayIterator(array($this));
      }
     
      /**
       * �������� ������ ���������
       * @return array
       */
      public function getAttributes() {
            return $this->attributes;
      }
         
      /**
       * �������� �������
       * @var string $tag
       * @var array $attributes
       * @return XML
       */
      public function appendChild($tag, $attributes) {
          $element = new myXML(array($tag, $attributes));
          $element->setParent($this);
          $this->childs[$tag][] = $element;
          return $element;
      }
         
      /**
       * ���������� ������������ �������
       * @var XML $parent
       */
      public function setParent(myXML $parent) {
          $this->parent =& $parent;
      }
         
      /**
       * �������� ������������ �������
       * @return XML
       */
      public function getParent() {
          return $this->parent;
      }
         
      /**
       * ���������� ������ ��������
       * @var string $cdata
      */
      public function setCData($cdata) {
          $this->cdata = $cdata;
      }
         
      /**
       * ������ xml-������ � ������ ������ ���������
       * @var string $data
       */
      private function parse($data) {
          $this->pointer =& $this;
          $parser = xml_parser_create();
          xml_set_object($parser, $this);
          xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
          xml_set_element_handler($parser, "tag_open", "tag_close");
          xml_set_character_data_handler($parser, "cdata");
          xml_parse($parser, $data);
      }
        
      /**
       * ��� �������� ����, ��������� ���� � ������������� ��������� �� ����
       */
      private function tag_open($parser, $tag, $attributes) {
          $this->pointer =& $this->pointer->appendChild($tag, $attributes);
      }
     
      /**
       * ��� ��������� ������
       */
      private function cdata($parser, $cdata) {
          $this->pointer->setCData($cdata);
      }
     
      /**
       * ��� �������� ����, ���������� ��������� �� ������
       */
      private function tag_close($parser, $tag) {
          $this->pointer =& $this->pointer->getParent();
      }
}
 
class convertNBKR {
	
	var $archive = true;
	var $last_updated = '';
	
	var $document_address = 'http://www.nbkr.kg/XML/weekly.xml';
	var $document_address2 = 'http://www.nbkr.kg/XML/daily.xml';
	var $supplier = 'National Bank of the Kyrgyz Republic';
	
	/**
	 * Initializes the global currency converter array
	 *
	 * @return mixed
	 */
	function init() {
		global $mosConfig_cachepath, $mosConfig_absolute_path,
				$vendor_currency, $vmLogger;
		
		if( !is_array($GLOBALS['converter_array']) && $GLOBALS['converter_array'] !== -1 ) {
				
				$contents = @file_get_contents( $this->document_address );
				if ($contents)
					{
						$xml = new myXML($contents);
						
						foreach($xml->CurrencyRates->Currency as $item)
							{
								$currency[$item['ISOCode'].''] = str_replace(',','.',$item->Value.'');
							}
						$GLOBALS['converter_array'] = $currency;
						
						$contents = @file_get_contents( $this->document_address2 );
						if ($contents)
							{
								$xml = new myXML($contents);
								
								foreach($xml->CurrencyRates->Currency as $item)
									{
										$currency[$item['ISOCode'].''] = str_replace(',','.',$item->Value.'');
									}
								$GLOBALS['converter_array'] = $currency;
							}
							
						$json_currency = json_encode($currency);
						$f = fopen('files/currency.txt', 'w');
						fwrite($f, $json_currency);
						fclose($f);
					}
				else
					{
						return false;
					}
		}
		return true;
	}
	/**
	 * Converts an amount from one currency into another using
	 * the rate conversion table from the European Central Bank
	 *
	 * @param float $amountA
	 * @param string $currA defaults to $vendor_currency
	 * @param string $currB defaults to $GLOBALS['product_currency'] (and that defaults to $vendor_currency)
	 * @return mixed The converted amount when successful, false on failure
	 */
	function convert( $amountA, $currA='', $currB='' ) {
		global $vendor_currency;
	
		// global $vendor_currency is DEFAULT!
		if( !$currA ) {
			$currA = $vendor_currency;
		}
		if( !$currB ) {
			$currB = $GLOBALS['product_currency'];
		}
		// If both currency codes match, do nothing
		if( $currA == $currB ) {		
			return $amountA;
		}
		if( !$this->init()) {
			$GLOBALS['product_currency'] = $vendor_currency;
			return $amountA;
		}
		$valA = isset( $GLOBALS['converter_array'][$currA] ) ? $GLOBALS['converter_array'][$currA] : 1;
		$valB = isset( $GLOBALS['converter_array'][$currB] ) ? $GLOBALS['converter_array'][$currB] : 1;
		
		$val = $amountA * $valA / $valB;
		//$vmLogger->debug('Converted '.$amountA.' '.$currA.' to '.$val.' '.$currB);
		
		return $val;
	} // end function convertecb
}
?>
