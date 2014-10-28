<?php
/**
 * @version		$Id: controller.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Weblinks Component Controller
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class SincroniseController extends JController
{
	var $head;
	var $url = '';
	var $weburl = '';
	var $user = '';
	var $pass = '';
	
	function pr($var)
		{
			echo '<pre>';
			print_r($var);
			echo '</pre>';
		}
	//выбор действия
	public function selectLoad()
		{
			$db = JFactory::getDBO();
			
			$sql = 'SELECT `params` FROM `#__components` WHERE `option`=\'com_sincronise\'';
			$db->setQuery($sql);
			$str = $db->LoadResult();
			$mas = unserialize($str);
			
			$this->url = $mas['server1cip'];
			$this->user = $mas['server1clogin'];
			$this->pass = $mas['server1cpass'];
			
			
			$type = JRequest::getVar("type");
			
			ob_start();
			try{
				Report::getInstance()->init($type);
				
				switch($type)
					{
						case 'loadAll'://загрузить весь список
							{
								$this->loadAll();
								
								break;
							}
						case 'loadCost'://загрузить весь список
							{
								$this->loadCost();
								
								break;
							}
						case 'loadCurrency':
							{
								$this->loadAllCurrency();
								
								break;
							}
						case 'loadCars'://загрузить весь список
							{
								$this->loadAllCars();
								
								break;
							}
						case 'loadMasla'://загрузить весь список
							{
								$this->loadMasla();
								
								break;
							}
						case 'loadRezina'://загрузить весь список
							{
								$this->loadRezina();
								
								break;
							}
						case 'loadAccumulyatory'://загрузить весь список
							{
								$this->loadAccumulyatory();
								
								break;
							}
						case 'loadItem'://обновить конкретное поле
							{
								$this->loadItem();
								break;
							}
						case 'loadCustomer'://загрузка контрагента
							{
								$this->loadCustomer();
								break;
							}
						case 'createAEProduct'://создание продукта с арабского сайта
							{
								$this->createAEProduct();
								break;
							}
						case 'findExcel'://поиск в данных из эксель файла
							{
								$this->findExcel();//поиск в данных виртуемарта
								break;
							}
						case 'findProduct':
							{
								$this->findProduct();
								break;
							}
						case 'loadExcel'://загрузка данных из эксель файла
							{
								$this->loadExcel();
								break;
							}
						case 'exportOrders':
							{
								$this->exportOrders();
								break;
							}
						case 'checkNoSincOrder':
							{
								$this->checkNoSincOrder();
								break;
							}
						case 'create1COrder':
							{
								$this->create1COrder();
								break;
							}
						case 'showOrderFinans':
							{
								$this->showOrderFinans();
								break;
							}
						case 'showOrderFinans2':
							{
								$this->showOrderFinans2();
								break;
							}
						case 'updateLink':
							{
								$this->updateLink();
								break;
							}
						case 'showDoc':
							{
								$this->showDoc();
								break;
							}
						case 'test':
							{
								$this->test();
								break;
							}
						case 'loadLists':
							{
								$this->loadLists();
								
								break;
							}
						case 'getballans':
							{
								$user = JFactory::getUser();
								$sql = 'SELECT `link` FROM `#__users` WHERE `id`='.$user->id;
								$db->setQuery($sql);
								$link = $db->LoadResult();
								$date = date("dmY");
								
								$ballans = $this->MK_GetReportForCustomers_Balance($link, $date);
								
								break;
							}
						case 'listorders':
							{
								$this->MK_GetListOfOrdersStatus();
								
								break;
							}
						case 'system'://системные функции
							{
								$this->sysExec();
								break; 
							}
					}
				
				Report::getInstance()->stop(ob_get_contents());
				
			} catch(Exception $e) {
				Report::getInstance()->stop($e->getMessage());
				echo 'ERROR';
			}
			ob_end_flush();
		}
	//загрузка всех данных
	public function loadAll()
		{
			
			$this->loadAllManufacturer();//загрузка производителей
			$this->loadAllCustomer();//загрузка контрагентов
			$this->loadAllCurrency();//загрузка валют
			$this->loadAllCars();//загрузка авто
			$this->MK_GetListOfOrdersStatus();//загрузка этапов доставки авто
			$this->loadMasla();//загрузка масел
			$this->loadAccumulyatory();//загрузка аккамуляторов
			$this->loadRezina();//загрузка шин
			echo 'OK';
		}
	//создание продукта с арабского сайта
	public function createAEProduct()
		{
			$detcode = JRequest::getVar('detcode');
			$detname = JRequest::getVar('detname');
			$detdesc = JRequest::getVar('detdesc');
			$detprice = JRequest::getVar('detprice');
			$detmarka = JRequest::getVar('detmarka');
			
			$db = JFactory::getDBO();
			//проверка нет ли уже такого продукта в базе
			$sql = "SELECT `product_id` FROM `#__vm_product` WHERE `product_sku` = '$detcode' OR `product_sku` = 'ae_$detcode' LIMIT 1";
			$db->setQuery($sql);
			$product_id = $db->LoadResult();
			
			if ($product_id>0)
				{
				
				}
			else
				{
					//создание продукта
					$obj = new stdClass;
					$obj->link = '';
					$obj->product_sku = 'ae_'.$detcode;
					$obj->product_s_desc = $detmarka;
					$obj->product_desc = '';
					$obj->product_thumb_image = '';
					$obj->product_full_image = '';
					$obj->product_in_stock = 0;
					$obj->product_name = $detname;
					$obj->product_price = $detprice;
					$obj->product_currency = 'USD';
					$obj->product_category_id = 14;
					
					$product_id = SincroniseModelSincronise::updateProduct($obj);
				}
				
			$url = "index.php?page=shop.product_details&flypage=flypage-ask.tpl&product_id=$product_id&category_id=14&option=com_virtuemart";
			$status = 1;
			
			echo "<xml version='1.0' encode='utf8'>
	<url>$url</url>
	<status>$status</status>
</xml>";
		}
	
	public function loadLists()
		{
					
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			
			$param = array('ID'=>'');
			$obj = $client->MK_GetTipyKuzova($param);
			
			if ($obj->return == 'Error')
				{
					echo 'TipyKuzova: ошибка , нет данных';
				}
			else
				{
					$rss = new SimpleXMLElement($obj->return);
					//pr($rss);
					
					unset($rss->column);
					
					$db = JFactory::getDBO();
					$db->setQuery('DELETE FROM `#__list_type_kuzov`');
					$db->query();
					
					foreach($rss->row as $item)
					{
						$link = (string) $item->Value[0];
						$title = (string) $item->Value[1];
						
						$sql = "INSERT INTO `#__list_type_kuzov` (`link`, `title`) VALUES ('$link', '$title')";
						$db->setQuery($sql);
						$db->query();
					}
				}
				
			
			$param = array('ID'=>'');
			$obj = $client->MK_GetTipySalona($param);
			
			if ($obj->return == 'Error')
				{
					echo 'TipySalona: ошибка , нет данных';
				}
			else
				{
					$rss = new SimpleXMLElement($obj->return);
					//pr($rss);
					
					unset($rss->column);
					
					$db = JFactory::getDBO();
					$db->setQuery('DELETE FROM `#__list_type_salon`');
					$db->query();
					
					foreach($rss->row as $item)
					{
						$link = (string) $item->Value[0];
						$title = (string) $item->Value[1];
						
						$sql = "INSERT INTO `#__list_type_salon` (`link`, `title`) VALUES ('$link', '$title')";
						$db->setQuery($sql);
						$db->query();
					}
				}
					
			
			$param = array('ID'=>'');
			$obj = $client->MK_GetTipyKPP($param);
			
			if ($obj->return == 'Error')
				{
					echo 'TipyKPP: ошибка , нет данных';
				}
			else
				{
					$rss = new SimpleXMLElement($obj->return);
					//pr($rss);
					
					unset($rss->column);
					
					$db = JFactory::getDBO();
					$db->setQuery('DELETE FROM `#__list_type_kpp`');
					$db->query();
					
					foreach($rss->row as $item)
					{
						$link = (string) $item->Value[0];
						$title = (string) $item->Value[1];
						
						$sql = "INSERT INTO `#__list_type_kpp` (`link`, `title`) VALUES ('$link', '$title')";
						$db->setQuery($sql);
						$db->query();
					}
				}
				
			
			$param = array('ID'=>'');
			$obj = $client->MK_GetCvetaKuzova($param);
			
			if ($obj->return == 'Error')
				{
					echo 'CvetaKuzova: ошибка , нет данных';
				}
			else
				{
					$rss = new SimpleXMLElement($obj->return);
					//pr($rss);
					
					unset($rss->column);
					
					$db = JFactory::getDBO();
					$db->setQuery('DELETE FROM `#__list_cveta_kuzova`');
					$db->query();
					
					foreach($rss->row as $item)
					{
						$link = (string) $item->Value[0];
						$title = (string) $item->Value[1];
						
						$sql = "INSERT INTO `#__list_cveta_kuzova` (`link`, `title`) VALUES ('$link', '$title')";
						$db->setQuery($sql);
						$db->query();
					}
				}
			
			
			$param = array('ID'=>'');
			$obj = $client->MK_GetCvetaSalona($param);
			
			if ($obj->return == 'Error')
				{
					echo 'CvetaSalona: ошибка , нет данных';
				}
			else
				{
					$rss = new SimpleXMLElement($obj->return);
					//pr($rss);
					
					unset($rss->column);
					
					$db = JFactory::getDBO();
					$db->setQuery('DELETE FROM `#__list_cveta_salona`');
					$db->query();
					
					foreach($rss->row as $item)
					{
						$link = (string) $item->Value[0];
						$title = (string) $item->Value[1];
						
						$sql = "INSERT INTO `#__list_cveta_salona` (`link`, `title`) VALUES ('$link', '$title')";
						$db->setQuery($sql);
						$db->query();
					}
				}
			
			
			$param = array('ID'=>'');
			$obj = $client->MK_GetTipyTopliva($param);
			
			if ($obj->return == 'Error')
				{
					echo 'TipyTopliva: ошибка , нет данных';
				}
			else
				{
					$rss = new SimpleXMLElement($obj->return);
					//pr($rss);
					
					unset($rss->column);
					
					$db = JFactory::getDBO();
					$db->setQuery('DELETE FROM `#__list_type_toplivo`');
					$db->query();
					
					foreach($rss->row as $item)
					{
						$link = (string) $item->Value[0];
						$title = (string) $item->Value[1];
						
						$sql = "INSERT INTO `#__list_type_toplivo` (`link`, `title`) VALUES ('$link', '$title')";
						$db->setQuery($sql);
						$db->query();
					}
				}
			
			
			$param = array('ID'=>'');
			$obj = $client->MK_GetTipyPrivoda($param);
			
			if ($obj->return == 'Error')
				{
					echo 'TipyPrivoda: ошибка , нет данных';
				}
			else
				{
					$rss = new SimpleXMLElement($obj->return);
					//pr($rss);
					
					unset($rss->column);
					
					$db = JFactory::getDBO();
					$db->setQuery('DELETE FROM `#__list_type_privod`');
					$db->query();
					
					foreach($rss->row as $item)
					{
						$link = (string) $item->Value[0];
						$title = (string) $item->Value[1];
						
						$sql = "INSERT INTO `#__list_type_privod` (`link`, `title`) VALUES ('$link', '$title')";
						$db->setQuery($sql);
						$db->query();
					}
				}
			
		}
		
	public function loadCost()
		{
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			$link = JRequest::getVar('link');
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			
			$param = array('ID'=>$link);
			$obj = $client->MK_LoadCost($param);
			
			if ($obj->return == 'Error')
				{
					echo 'TipyPrivoda: ошибка , нет данных';
				}
			else
				{
					$string = $obj->return.'';
					//echo $string.'<br>';
					$xml = new SimpleXMLElement($string);
			
					$columns = array();$i = 0;
					foreach($xml->column as $k=>$item)
						{
							$columns[strval($item->Name)] = $i;
							$i++;
						}
				
					$cost = $xml->row->Value[$columns['Sebestoimost']];
					
					echo $cost;
					
					$db = JFactory::getDbo();
					$db->setQuery("UPDATE #__vm_product SET Sebestoimost = '$cost' WHERE link = '$link'");
					$db->query();
				}	
		}
		
	//загрузка обьекта
	public function loadItem()
		{
			$obj = JRequest::getVar('obj');
			$id = JRequest::getVar('id');
			
			if (($obj) and ($id>0))
				{
					switch($obj)
						{
							case 'cars'://обновление машины
								{
									$this->loadCars($id);
									break;
								}
							case 'user'://обновление контрагента
								{
									$this->loadCustomer($id);
									break;
								}
						}
				}
		}
	public function sysExec()
		{
			/*echo 'поиск не синхронизированых заказов<br><br>';
			
			$db = JFactory::getDBO();
			$sql = 'SELECT * FROM `#__vm_orders` WHERE `sincronize`=0';
			$db->setQuery($sql);
			$rows = $db->LoadObjectList();
			if (count($rows)>0)
				{
					foreach($rows as $row)
						{
							$get = '?';
							$post = '?';
							
							$get .= '&type=neworder';
							$post .= '';
						
							$url = $this->weburl.$get;
							curl_setopt($ch, CURLOPT_URL, $url); 
							curl_setopt($ch, CURLOPT_FAILONERROR, 1);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
							curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
							curl_setopt($ch, CURLOPT_POST, 100); 
							curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

							$result = curl_exec($ch); // run the whole process

							if($result === FALSE) echo "cURL error: ".curl_error($ch);

							curl_close($ch);
						}
					echo 'обновление завершено, синхронизировано заказов - '.count($rows).'<br><br>';
				}
			else echo 'не синхронизированых заказов не обнаружено';
			*/
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			$db = JFactory::getDBO();
			
			$sql = 'SELECT `user_id`,`order_id`,`cdate` FROM `#__vm_orders`';
			$db->setQuery($sql);
			$orders = $db->LoadObjectList();//Дата, Контрагент, Договор контрагента, Дата Отгрузки,валюта
			if ($orders) foreach($orders as &$order)
				{
					$sql = 'SELECT * FROM `#__vm_order_item` WHERE `order_id`='.$order->order_id;
					$db->setQuery($sql);
					$order->items = $db->LoadObjectList();
					if ($order->items) foreach($order->items as &$item)
						{
							$sql = 'SELECT `link` FROM `#__vm_product` WHERE `product_id`='.$item->product_id;
							$db->setQuery($sql);
							$item->linkus = $db->LoadResult();
						}
				}
				
			$ord->root = $orders;
			$converter = new Array2XML();
			$xmlStr = $converter->convert($ord);
			 
			$ordersstr = str_replace('><',">\n<",$xmlStr);
			echo $ordersstr;
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('ParamIn'=>$ordersstr);
			$obj = $client->CreateOrderByWeb($param);
		}
	//показать отчет по финансовым движениям клиента
	public function showOrderFinans()
		{
			$db = JFactory::getDBO();
			$user = JFactory::getUser();
			$cagent = JRequest::getInt('cagent');
			if ($cagent > 0) {
				$user = JFactory::getUser($cagent);
			}
			
			$sql = 'SELECT `link` FROM `#__users` WHERE `id`='.$user->id;
			$db->setQuery($sql);
			$link = $db->LoadResult();
			$link = trim($link);
			
			if (!$link)
				{
					echo 'Неизвестный пользователь';
					return;
				}
			$date1 = JRequest::getVar("date1");
			$date2 = JRequest::getVar("date2");
			
			$ballansst = $this->MK_GetReportForCustomers_Balance($link, $date1.' 00:00:01');
			$ballansed = $this->MK_GetReportForCustomers_Balance($link, $date2.' 23:59:59');
			$date1 = date("Ymd000001",strtotime($date1));
			$date2 = date("Ymd235959",strtotime($date2));
			//pr($ballansst);
			//pr($ballansed);
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			
			if (!$user->id) 
				{
					echo 'Доступ только для авторизованых пользователей';
					return;
				}
				
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('Customer'=>$link,'Date1'=>$date1,'Date2'=>$date2);
			$obj = $client->GetReportForCustomers($param);
			
			if ($obj->return == 'Error')
				{
					echo 'ошибка , нет данных для выбранного диапазона';
				}
			else
				{
					$saldost = '';
					$countsaldost = count($ballansst);$i=0;
					foreach($ballansst as $k=>$v)
						{
							$saldost .= '<tr class="gray">';
							if ($i==0) $saldost .= '	<td align="left" width="75" rowspan="'.$countsaldost.'" >&nbsp;</td>
											<td align="left" rowspan="'.$countsaldost.'" >Сальдо на начало периода</td>';
							$saldost .= '<td colspan="2">'.$k.'</td><td>'.$v.'</td>';
							$saldost .= '</tr>';
							$i++;
						}
						
					$saldoed = '';
					$countsaldoed = count($ballansed);$i=0;
					foreach($ballansed as $k=>$v)
						{
							$saldoed .= '<tr class="gray">';
							if ($i==0) $saldoed .= '	<td align="left" width="75" rowspan="'.$countsaldoed.'" >&nbsp;</td>
											<td align="left" rowspan="'.$countsaldoed.'" >Сальдо на конец периода</td>';
							$saldoed .= '<td colspan="2">'.$k.'</td><td>'.$v.'</td>';
							$saldoed .= '</tr>';
							$i++;
						}
					$table = '<table cellspacing="0" cellpadding="0" class="kabtable">
								<thead>
									<tr>
										<td colspan="5">Контрагент: '.$user->name.'</td>
									</tr>
									'.$saldost.$saldoed.'
									<tr>
										<td align="left">Дата</td>
										<td align="left">Наименование услуги</td>
										<td width="50">Валюта</td>
										<td width="80">Приход</td>
										<td width="80">Расход</td>
									</tr>
								</thead>
							</table>
							<div class="report_body">
							<table cellspacing="0" cellpadding="0" class="kabtable">
								<tbody>';
									
					$rss = new SimpleXMLElement($obj->return);
					//pr($rss);
					unset($rss->column);
					$z=1;$bool = true;$currences = $body = $dt = $kt = array();
					for($i=0;$i<count($rss->row);$i++)
						{
							$bool = !$bool;
							$link = $rss->row[$i]->Value[0];
							$title = $rss->row[$i]->Value[1];
							$data = $rss->row[$i]->Value[2];
							$debet = (float) $rss->row[$i]->Value[4];
							$kredit = (float) $rss->row[$i]->Value[3];
							$currency = (string) $rss->row[$i]->Value[6];
							
							if (!isset($currences[$currency])) 
								{
									$currences[$currency]->id = $z;
									$currences[$currency]->cur = $currency;
									$z++;
								}
							$dt[$currency] += $debet;
							$kt[$currency] += $kredit;
							
							if ($data)
								{
									$d = substr($data,0,10);
									
								}
							else
								{
									$d = '';
								}
							$class = ($bool) ? 'one' : 'two';
							
							$debet = number_format($debet,2,',','');
							$kredit = number_format($kredit,2,',','');
							
							if ($link) $func = 'onclick="showDoc(\''.$link.'\')"'; else $func = 'style="cursor:default;"';
							$body[$currency] .= "<tr class='$class sc_".$currences[$currency]->id." sc_currences' $func >
									<td align='left'>$d</td>
									<td align='left'>$title</td>
									<td align='right' width='50'>$currency</td>
									<td align='right' width='80'>$debet</td>
									<td align='right' width='80'>$kredit</td>
								</tr>";
						}
						
					foreach($body as $k=>$v)
						{
							$table .= $v.'<tr class="itog sc_'.$currences[$k]->id.' sc_currences">
									<td>&nbsp;</td>
									<td colspan="2" style="text-align:right;padding-right:10px;">Оборот за период</td>
									<td align="right">'.number_format($dt[$k],2,',','').'</td>
									<td align="right">'.number_format($kt[$k],2,',','').'</td>
								</tr>';
						}
						
					$table .= $saldoed;	
					$table .= "</tbody>
							</table>
						</div>";
					
					if (count($currences)>1)
						{
							echo '<br /><select id="total_currency" >';
								echo '<option value="0" >Все валюты</option>';
							foreach($currences as $k=>$v)
								{
									echo '<option value="'.$v->id.'" >'.$v->cur.'</option>';
								}
							echo '</select>';
						}
						
					echo $table;
				}
		}
	//показать детализированого отчета
	public function showOrderFinans2()
		{
			$db = JFactory::getDBO();
			$user = JFactory::getUser();
			
			$sql = 'SELECT `link` FROM `#__users` WHERE `id`='.$user->id;
			$db->setQuery($sql);
			$link = $db->LoadResult();
			$link = trim($link);
			
			if (!$link)
				{
					echo 'Неизвестный пользователь';
					return;
				}
			$date1 = JRequest::getVar("date1");
			$date2 = JRequest::getVar("date2");
			
			$date1 = date("Ymd000001",strtotime($date1));
			$date2 = date("Ymd235959",strtotime($date2));
			//pr($ballansst);
			//pr($ballansed);
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			
			if (!$user->id) 
				{
					echo 'Доступ только для авторизованых пользователей';
					return;
				}
				
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('Customer'=>$link,'Date1'=>$date1,'Date2'=>$date2);
			$obj = $client->MK_GetClientPaymentsReport_old($param);
			
			if ($obj->return == 'Error')
				{
					echo 'ошибка , нет данных для выбранного диапазона';
				}
			else
				{
					echo $obj->return;
				}
		}
	//получение наценки к товару
	function getPrice($price)
		{
			$db = JFactory::getDBO();
			$pr = (float) $price;
			if ($pr>0)
				{
					$sql = 'SELECT * FROM `#__car_detail_prices` WHERE `p_id`=9 AND `price`>'.$pr.' ORDER BY `price` LIMIT 1';//echo $sql.'<br>';
					$db->setQuery($sql);
					$rows = $db->LoadObjectList();
					foreach($rows as $row)
						{
							$mas->price = $row->price;
							$mas->type = $row->type;
							$mas->value = $row->value;
						}
					if ($mas->type=='*')
						{
							$pr = $pr + $mas->value;
						}
					if ($mas->type=='%')
						{
							$pr = round(($price*(1 + $mas->value/100)),2);
						}
					$price = $pr;
				}
			return $price;
		}
	//загрузка продуктов из экселевского файла
	public function loadExcel()
		{
			$db = JFactory::getDBO();
			
			$count = 0;
			$d = dir("images/excel");
			while ($entry = $d->read()) {
				if (($entry == '.') or ($entry == '..')) continue;
				$name = iconv("windows-1251","UTF-8//IGNORE", $entry);
			   
			   $data = file("images/excel/".$entry);
			   $i = 0;$time = time();
			   foreach($data as $item)
				{
					$i++;
					if ($i<=2) continue;
					
					$item = iconv("windows-1251","UTF-8//IGNORE", $item);
					$arr = explode(';',$item);
					
					$manufacturer = mysql_real_escape_string($arr[0]);
					$art = mysql_real_escape_string($arr[1]);
					$type = mysql_real_escape_string($arr[2]);
					$name = mysql_real_escape_string($arr[3]);
					$model = mysql_real_escape_string($arr[4]);
					$pack = mysql_real_escape_string($arr[5]);
					$oe = mysql_real_escape_string($arr[6]);
					$order = mysql_real_escape_string($arr[7]);
					$price = (float) mysql_real_escape_string($arr[8]);
					$ost = mysql_real_escape_string($arr[9]);
					$prihod = mysql_real_escape_string($arr[10]);
					
					$art = 'excel_'.$oe;
					if ((!$name) or (!$art)) continue;
					
					$price = $this->getPrice($price);
					
					unset($obj);
					$obj->link = '';
					$obj->product_sku = $art;
					$obj->product_s_desc = $type;
					$obj->product_desc = $type;
					$obj->product_thumb_image = '';
					$obj->product_full_image = '';
					$obj->product_in_stock = $ost;
					$obj->product_name = $name;
					$obj->product_price = $price;
					$obj->product_currency = 'EUR';
					$obj->product_category_id = 14;
					$obj->marka = '';
					$obj->model = $model;
					$obj->year = 0;
					
					SincroniseModelSincronise::updateProduct($obj);
					$count++;
				}
			}
			$d->close();
			
			echo '<?xml version="1.0"?>
	<root>
		<status>OK</status>
		<count>'.$count.'</count>
	</root>';
		}
	//поиск не выгруженых заказов для 1С
	public function checkNoSincOrder()
		{
			$db = JFactory::getDBO();
			
			$sql = 'SELECT * FROM `#__vm_orders` WHERE `sincronize`=0';
			$db->setQuery($sql);
			$orders = $db->LoadObjectList();
			if ($orders) foreach($orders as $order)
				{
					
				}
		}
	//обновление статуса заказа после выгрузки его в 1С
	public function create1COrder()
		{
			$db = JFactory::getDBO();
			$order_id = JRequest::getInt('order_id');
			$link = JRequest::getVar('link');
			
			if (($order_id>0) and ($link))
				{
					$sql = "SELECT `order_id` FROM `#__vm_orders` WHERE `order_id`=$order_id";
					$db->setQuery($sql);
					$checkid = $db->LoadResult();
					
					if ($checkid>0)
						{
							$sql = "UPDATE `#__vm_orders` SET `link`='$link', `sincronize`=1 WHERE `order_id`=$order_id";
							$db->setQuery($sql);
							$db->query();
							
							echo 'OK';
						}
					else
						{
							echo 'ERROR';
						}
				}
			else
				{
					echo 'ERROR';
				}
		}
	//вывод заказов для 1С
	public function exportOrders($id = 0)
		{
			header('Content-Type: text/html; charset=utf8');
			
			$db = JFactory::getDBO();
			
			$sql = 'SELECT * FROM `#__vm_currency`';
			$db->setQuery($sql);
			$rows = $db->LoadObjectList();
			foreach($rows as $row)
				{
					$currencis[$row->currency_code] = $row->link;
				}
			
			$sql = 'SELECT `o`.*, (SELECT `1c_id` FROM `#__site_1c_id` WHERE `site_id`=`o`.`user_id`) AS `user_link` FROM `#__vm_orders` AS `o` WHERE `sincronize`=0';
			$db->setQuery($sql);
			$orders = $db->LoadObjectList();
			if ($orders) foreach($orders as &$order)
				{
					$mas[$order->order_id]->order_id = $order->order_id;
					$mas[$order->order_id]->cdate = date("Ymd",$order->cdate);
					$mas[$order->order_id]->user_link = $order->user_link;
					$mas[$order->order_id]->order_total = $order->order_total;
					$mas[$order->order_id]->order_currency = $currencis[$order->order_currency];
					
					$sql = 'SELECT `oi`.*, (
												SELECT `link` 
												FROM `#__vm_product` 
												WHERE `product_id`=`oi`.`product_id`
											) AS `product_link`, 
											(
												SELECT `product_sku` 
												FROM `#__vm_product` 
												WHERE `product_id`=`oi`.`product_id`
											) AS `product_sku`, 
											(
												SELECT `category_id` 
												FROM `#__vm_product_category_xref`
												WHERE `product_id`=`oi`.`product_id`
											) AS `product_type`
							FROM `#__vm_order_item` AS `oi` 
							WHERE `oi`.`order_id`='.$order->order_id;
					$db->setQuery($sql);
					$order->items = $db->LoadObjectList();
					foreach($order->items as $items)
						{
							$mas[$order->order_id]->items[$items->order_item_id]->product_link = ($items->product_link) ? $items->product_link : 'product_link_none';
							$mas[$order->order_id]->items[$items->order_item_id]->product_name = $items->order_item_name;
							$mas[$order->order_id]->items[$items->order_item_id]->product_sku = $items->product_sku;
							$mas[$order->order_id]->items[$items->order_item_id]->product_type = ($items->product_type == 1) ? 1 : 2;
							$mas[$order->order_id]->items[$items->order_item_id]->order_item_sku = $items->order_item_sku;
							$mas[$order->order_id]->items[$items->order_item_id]->order_item_name = $items->order_item_name;
							$mas[$order->order_id]->items[$items->order_item_id]->product_quantity = $items->product_quantity;
							$mas[$order->order_id]->items[$items->order_item_id]->product_final_price = $items->product_final_price;
							$mas[$order->order_id]->items[$items->order_item_id]->order_item_currency = $currencis[$items->order_item_currency];
						}
				}
			$obj->root = $mas;
			
			$converter = new Array2XML();
			$xmlStr = $converter->convert($obj);
			$xmlStr = str_replace('><',">\n<",$xmlStr);
			echo ''.$xmlStr.'';
		}
	//загрузка списка валют
	public function loadAllCurrency()
		{
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			//echo 'load currency<br>';exit;
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('ID'=>'');
			$obj = $client->GetListOfCurrency();
			
			$rss = new XML($obj->return);
			
			$rows = array();
			for($i=0;$i<count($rss->ValueTable->column);$i++)
				{
					$rows[$i] = ''.$rss->ValueTable->column[$i]->Title;
				}
				
			$this->head = $rows;

			$currency = array();
			for($i = 0;$i<count($rss->ValueTable->row);$i++)
				{
					foreach($rows as $k=>$v)
						{
							$v = ''.$v;
							$k = ''.$k;
							$id = $rss->ValueTable->row[$i]->Value[0].'';
							$val = '';
							if (isset($rss->ValueTable->row[$i]->Value[$k])) 
								{
									$val = $rss->ValueTable->row[$i]->Value[$k].'';
								}
							$currency[$id][$v] = $val;
						}
				}
			$i=0;
			foreach($currency as $k=>$item)
				{
					$i++;
					unset($obj);
					$obj->currency_id = $this->getSiteId($item['Link']);
					$obj->currency_link = $item['Link'];
					$obj->currency_name = $item['Name'];
					$obj->currency_code = $item['Name'];
					
					SincroniseModelSincronise::updateCurrency($obj);
				}
		}
	//вывод квитанции
	public function showDoc()
		{
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			$db = JFactory::getDBO();
			$link = JRequest::getVar('link');
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('ID'=>$link);
			$obj = $client->MK_GetClientPaymentsTranscript($param);
			//echo $obj->return;
			
			if ($obj->return){
				echo $obj->return;
			} else {
				?>
				<table style="width: 100%; height: 100%;">
					<tr>
						<td style="text-align:center; vertical-align: middle;">
							В данном случае подробной информации не предусмотрено
						</td>
					</tr>
				</table>
				<?php
			}
		}
	//загрузка сопоставлений заказаных авто
	public function MK_GetListOfOrdersStatus()
		{
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			$db = JFactory::getDBO();
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('ID'=>'');
			$obj = $client->MK_GetListOfOrdersStatus();
			//echo $obj->return;
			$rss = new SimpleXMLElement($obj->return);
			//pr($rss);
			unset($rss->column);
			
			$sql = "DELETE FROM `#__cagents_avto`";
			$db->setQuery($sql);
			$db->query();
					
			for($i = 0;$i<count($rss->row); $i++)
				{
					$data = strtotime(str_replace('T',' ',$rss->row[$i]->Value[0]));
					$cagent_link = $rss->row[$i]->Value[1];
					$avto_link = $rss->row[$i]->Value[3];
					$etap_dostavki = trim($rss->row[$i]->Value[6]);
					
					$sql = "INSERT INTO `#__cagents_avto` (
								`cdate`, `cagent_link`, `avto_link`, `etap_dostavki`
								) VALUES (
								'$data', '$cagent_link', '$avto_link', '$etap_dostavki')";
					$db->setQuery($sql);
					$db->query();
				}
		}
	//загрузка списка автомобилей
	public function loadAllCars()
		{
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			$link = JRequest::getVar('link');
			
			if ($link){
				$this->loadCars($link);
			} else {
				$limit = 500;
				$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
				$client = new SoapClient($this->url,$dop_param);
				$param = array(
					'ID' => '',
					'GetQuantityOnly' => 1,
					'StartFrom' => 1,
					'Quantity' => $limit
				);
				$obj = $client->GetListOfCars($param);
				
				$xml = new SimpleXMLElement($obj->return);
				
				$countRow = $xml[0];
				
				$Quantity = ceil($countRow / $limit);
				
				for($i = 0; $i < $Quantity; $i++){
					$this->loadCars(null, ($i * $limit + 1), $limit);
				}
			}
		}
	//загузка автомобиля
	public function loadCars($id = null, $StartFrom = 1, $Quantity = 100)
		{
			if (!$id) $id = JRequest::getVar('link');
			$updateforce = JRequest::getVar('updateforce');
			
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			//error_reporting(0);
			$db = JFactory::getDBO();
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array(
				'ID' => $id,
				'GetQuantityOnly' => 0,
				'StartFrom' => $StartFrom,
				'Quantity' => $Quantity
			);
			
			$obj = $client->GetListOfCars($param);
			
			$sql = "SELECT `mf_name`, `link` FROM `#__vm_manufacturer`";
			$db->setQuery($sql);
			$mfs = $db->LoadObjectList();
			foreach($mfs as $item)
				{
					if (trim($item->link)){
						$mfarr[trim($item->link)] = $item->mf_name;
					}
				}
				
			$sql = "SELECT `link`, `currency_code` FROM `#__vm_currency`";
			$db->setQuery($sql);
			$pcs = $db->LoadObjectList();
			foreach($pcs as $item)
				{
					if (trim($item->link)){
						$pcarr[trim($item->link)] = $item->currency_code;
					}
				}
				
			$string = $obj->return.'';
			//echo $string.'<br>';
			$xml = new SimpleXMLElement($string);
			
			$columns = array();$i = 0;
			foreach($xml->column as $k=>$item)
				{
					$columns[strval($item->Name)] = $i;
					$i++;
				}
				
			$model = new SincroniseModelSincronise;
			$model->db = $db;$count = 0;
			foreach($xml->row as $k=>$item)
				{$count++;
					unset($obj);
					
					$images = $item->Value[$columns['ArraysOfFoto']];
					/*if ($images) {
						echo 'Исходные пути<br>';
						foreach($images->row as $z)
							{
								echo strval($z->Value[0]).'<br>';
							}
					}*/
						
					$obj->link = $item->Value[$columns['Link']].'';
					$obj->product_sku = $item->Value[$columns['Article']].'';
					$obj->cdate = strtotime(strval($item->Value[$columns['Date']]));
					$obj->product_s_desc = trim($item->Value[$columns['Model']].'');
					$image = array();
					if ($images->row) foreach($images->row as $z)
						{
							$img = strval($z->Value[0]);
							$img = str_replace('\\','/',$img);
							$image[] = str_ireplace('D:/xampp/htdocs/','http://',$img);
						}
					$obj->product_image = $image;
					$obj->product_name = trim($item->Value[$columns['Name']].'');
					$obj->product_price = $item->Value[$columns['Cost']].'';
					$obj->product_currency_link = $item->Value[$columns['Currency']].'';
					$obj->product_currency = (isset($pcarr[$obj->product_currency_link])) ? $pcarr[$obj->product_currency_link] : '';
					$pub = strval($item->Value[$columns['FlagVygrujatNaSait']]);
					$obj->product_publish = ($pub == 'true') ? 'Y' : 'N';
					$obj->product_category_id = 1;
					$m = trim($item->Value[$columns['Proizvoditel']]);//марка
					$obj->marka = (isset($mfarr[$m])) ? $mfarr[$m] : '';
					$obj->model = trim($item->Value[$columns['Model']].'');
					$obj->year = (int) $item->Value[$columns['YearOfRegistration']].'';
					$desc = trim(strval($item->Value[$columns['AutoInfo']]));
					$desc = str_replace("'", '"', $desc);
					$st = strpos($desc,'<body');
					$ed = strpos($desc,'</body');
					if (($st>0) and ($ed>0)) $obj->product_desc = substr($desc,$st+6,$ed-$st-6); else $obj->product_desc = $desc;
					$obj->RaspolojenieRulya = trim($item->Value[$columns['RaspolojenieRulya']].'');
					$obj->TipKPP = trim($item->Value[$columns['TipKPP']].'');
					$obj->TipKuzova = trim($item->Value[$columns['TipKuzova']].'');
					$obj->EngineSize = trim($item->Value[$columns['EngineSize']].'');
					$obj->NomerKuzov = trim($item->Value[$columns['NomerKuzova']].'');
					$obj->Probeg = ($item->Value[$columns['Probeg']].'');
					$obj->TipTopliva = trim($item->Value[$columns['TipTopliva']].'');
					$obj->CvetSalona = trim($item->Value[$columns['CvetSalona']].'');
					$obj->AukcionnayaCena = trim($item->Value[$columns['AukcionnayaCena']].'');
					$obj->ValutaAukcionnoiCeny = trim($item->Value[$columns['ValutaAukcionnoiCeny']].'');
					$obj->product_type = 'automobil';
					$PerezagruzitFoto = trim($item->Value[$columns['PerezagruzitFoto']].'');
					$obj->CenaProdaji = trim($item->Value[$columns['CenaProdaji']].'');
					$obj->ValutaCenyProdaji = trim($item->Value[$columns['ValutaCenyProdaji']].'');
					$obj->Dostavlen = trim($item->Value[$columns['Dostavlen']].'');
					$obj->product_in_stock = ($obj->Dostavlen == 'true') ? 1 : 0;
					$obj->DneiSMomentaPokupki = strval($item->Value[$columns['DneiSMomentaPokupki']]);
					$obj->status = strval($item->Value[$columns['Status']]);
					$obj->DataDostavki = strtotime(strval($item->Value[$columns['DataDostavki']]));
					$obj->Sebestoimost = floatval($item->Value[$columns['Sebestoimost']]);
					$obj->TipSalona = trim($item->Value[$columns['TipSalona']].'');
					$obj->CustomerLink = trim($item->Value[$columns['CustomerLink']].'');
					$obj->DataPokupki = trim($item->Value[$columns['DataPokupki']].'');
					$obj->Postavshik = trim($item->Value[$columns['Postavshik']].'');
					
					$updateimg = true;
					
					if (trim($item->Value[$columns['Prodan']].'') == 'true')
						{
							$obj->Prodan = 1;
							$obj->DataProdaji = strtotime(substr(trim($item->Value[$columns['DataProdaji']].''),0,strpos(trim($item->Value[$columns['DataProdaji']].''),'T')));
							$obj->product_in_stock = 0;
						}
					else
						{
							$obj->Prodan = 0;
							$obj->DataProdaji = 0;
						}
					//pr($obj);
					$model->updateProduct($obj, $updateimg);
				}
				
			//echo "updating auto = $count<br>";
		}
		
	//загузка масла
	public function loadMasla($link = null)
		{
			$db = JFactory::getDBO();
			if (!$link) $link = JRequest::getVar('link');
			$id = JRequest::getInt('id');
			$updateforce = JRequest::getVar('updateforce');
			
			if ($id > 0) {
				$sql = 'SELECT `link` FROM `#__vm_product` WHERE `product_id` = '.$id;
				$db->setQuery($sql);
				$prod_link = $db->LoadResult();
				if ($prod_link) $link = $prod_link;
			}
			
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('ID'=>$link);
			$obj = $client->MK_GetListOfMasla($param);
			
			$currency = json_decode(implode(file('files/currency.txt')));
			
			$string = strval($obj->return);
			//echo $string;
			
			if ($string == 'Error') return;
			$xml = new SimpleXMLElement($string);
			
			$columns = array();$i = 0;
			foreach($xml->column as $k=>$item)
				{
					$columns[strval($item->Name)] = $i;
					$i++;
				}
			//pr($columns);
			
			$model = new SincroniseModelSincronise;
			$model->db = $db;
			
			foreach($xml->row as $k=>$item)
				{
					unset($obj);$image = array();
					$obj->link = $item->Value[$columns['Link']].'';
					$obj->product_sku = $item->Value[$columns['Code']].'';
					$obj->product_s_desc = $item->Value[$columns['Description']].'';
					
					$images = $item->Value[$columns['ArraysOfFoto']];$img = '';
					if ($images->row) foreach($images->row as $z)
						{
							$img = strval($z->Value[0]);
							$img = str_replace('\\','/',$img);
							$image[] = str_ireplace('D:/xampp/htdocs/','http://',$img);
						}
					$obj->product_image = $image;
					
					$obj->product_in_stock = $item->Value[$columns['Kolichestvo']].'';
					$obj->product_name = trim($item->Value[$columns['Name']].'');
					$obj->product_currency_link = '';
					$obj->product_price = $item->Value[$columns['Cena']].'';
					$obj->product_currency = $item->Value[$columns['Valyuta']].'';
					
					if ($obj->product_currency == 'Сом'){
						$kurs_usd = $currency->USD;
						
						$obj->product_currency = 'USD';
						$obj->product_price = round(($obj->product_price / $kurs_usd), 2);
					}
					
					$obj->product_publish = 'Y';
					$obj->product_category_id = 16;
					$obj->marka = $this->getModelForMasla($obj->product_name);
					$obj->model = '';
					$obj->year = 0;
					$obj->product_desc = '';
					$obj->RaspolojenieRulya = '';
					$obj->TipKPP = '';
					$obj->TipKuzova = '';
					$obj->EngineSize = '';
					$obj->NomerKuzov = '';
					$obj->Probeg = '';
					$obj->TipTopliva = '';
					$obj->CvetSalona = '';
					$obj->TipSalona = '';
					$obj->AukcionnayaCena = '';
					$obj->ValutaAukcionnoiCeny = '';
					$obj->product_type = 'masla';
					$obj->product_weight_uom = 'л.';
					$obj->Prodan = 0;
					$obj->DataProdaji = 0;
					$PerezagruzitFoto = trim($item->Value[$columns['PerezagruzitFoto']].'');
					$obj->TipPoSostavu = strval($item->Value[$columns['TipPoSostavu']]);
					$obj->TipPoNaznacheniyu = strval($item->Value[$columns['TipPoNaznacheniyu']]);
					$obj->Razmer = strval($item->Value[$columns['Razmer']]);
					$obj->group_uom = 'л';
					$obj->group_article = strval($item->Value[$columns['Article']]);
					
					$updateimg = true; 		
							
					//pr($obj);
					$model->updateProduct($obj, $updateimg);
				}
		}
		
	//загузка аккамуляторов
	public function loadAccumulyatory($id = null)
		{
			if (!$id) $id = JRequest::getVar('link');
			$updateforce = JRequest::getVar('updateforce');
			
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			$db = JFactory::getDBO();
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('ID'=>$id);
			$obj = $client->MK_GetListOfAccumulyatory($param);
			
			$currency = json_decode(implode(file('files/currency.txt')));
			
			if (!$id>0)
				{
					$sql = 'UPDATE  `#__vm_product` SET  `product_publish` =  \'N\' WHERE `product_id` IN (
												SELECT `product_id` 
												FROM `#__vm_product_category_xref` 
												WHERE `category_id`=15
															)';
					$db->setQuery($sql);
					$db->query();
				}
			$string = $obj->return.'';
			//echo $string;
			$xml = new SimpleXMLElement($string);
			
			$model = new SincroniseModelSincronise;
			$model->db = $db;
			foreach($xml->row as $k=>$item)
				{
					unset($obj);unset($image);
					$obj->link = $item->Value[0].'';
					$obj->product_sku = $item->Value[2].'';
					
					$images = $item->Value[6];$img = '';
					if ($images->row) foreach($images->row as $z)
						{
							$img = strval($z->Value[0]);
							$img = str_replace('\\','/',$img);
							$image[] = str_ireplace('D:/xampp/htdocs/','http://',$img);
						}
					$obj->product_image = $image;
					$obj->product_in_stock = $item->Value[4].'';
					$obj->product_name = trim($item->Value[1].'');
					$obj->product_price = $item->Value[3].'';
					$obj->product_currency_link = '';
					$obj->product_currency = $item->Value[5].'';
					
					if ($obj->product_currency == 'Сом'){
						$kurs_usd = $currency->USD;
						
						$obj->product_currency = 'USD';
						$obj->product_price = round(($obj->product_price / $kurs_usd), 2);
					}
					
					$obj->product_s_desc = $item->Value[7].'';
					$obj->product_publish = 'Y';
					$obj->product_category_id = 15;
					$obj->marka = '';
					$obj->model = '';
					$obj->year = 0;
					$obj->product_desc = '';
					$obj->RaspolojenieRulya = '';
					$obj->TipKPP = '';
					$obj->TipKuzova = '';
					$obj->EngineSize = '';
					$obj->NomerKuzov = '';
					$obj->Probeg = '';
					$obj->TipTopliva = '';
					$obj->CvetSalona = '';
					$obj->TipSalona = '';
					$obj->AukcionnayaCena = '';
					$obj->ValutaAukcionnoiCeny = '';
					$obj->product_type = 'accumulyatory';
					$obj->Prodan = 0;
					$obj->DataProdaji = 0;
					$PerezagruzitFoto = trim($item->Value[8].'');
					
					$updateimg = true; 
							
					//pr($obj);
					$model->updateProduct($obj, $updateimg);
				}
		}
		
	//загузка шин
	public function loadRezina($id = null)
		{
			if (!$id) $id = JRequest::getVar('link');
			$updateforce = JRequest::getVar('updateforce');
			
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			$db = JFactory::getDBO();
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('ID'=>$id);
			$obj = $client->MK_GetListOfRezina($param);
			
			$currency = json_decode(implode(file('files/currency.txt')));
			
			if (!$id>0)
				{
					$sql = 'UPDATE  `#__vm_product` SET  `product_publish` =  \'N\' WHERE `product_id` IN (
												SELECT `product_id` 
												FROM `#__vm_product_category_xref` 
												WHERE `category_id`=17
															)';
					$db->setQuery($sql);
					$db->query();
				}
			$string = $obj->return.'';
			//echo $string;
			$xml = new SimpleXMLElement($string);
			
			$model = new SincroniseModelSincronise;
			$model->db = $db;
			foreach($xml->row as $k=>$item)
				{
					unset($obj);unset($image);
					$obj->link = $item->Value[0].'';
					$obj->product_sku = $item->Value[2].'';
					$obj->product_s_desc = $item->Value[7].'';
					
					$images = $item->Value[6];$img = '';
					if ($images->row) foreach($images->row as $z)
						{
							$img = strval($z->Value[0]);
							$img = str_replace('\\','/',$img);
							$image[] = str_ireplace('D:/xampp/htdocs/','http://',$img);
						}
					$obj->product_image = $image;
					$obj->product_in_stock = $item->Value[4].'';
					$obj->product_name = trim($item->Value[1].'');
					$obj->product_price = $item->Value[3].'';
					$obj->product_currency_link = '';
					$obj->product_currency = $item->Value[5].'';
					
					if ($obj->product_currency == 'Сом'){
						$kurs_usd = $currency->USD;
						
						$obj->product_currency = 'USD';
						$obj->product_price = round(($obj->product_price / $kurs_usd), 2);
					}
					
					$obj->product_publish = 'Y';
					$obj->product_category_id = 17;
					$obj->marka = '';
					$obj->model = '';
					$obj->year = 0;
					$obj->product_desc = '';
					$obj->RaspolojenieRulya = '';
					$obj->TipKPP = '';
					$obj->TipKuzova = '';
					$obj->EngineSize = '';
					$obj->NomerKuzov = '';
					$obj->Probeg = '';
					$obj->TipTopliva = '';
					$obj->CvetSalona = '';
					$obj->TipSalona = '';
					$obj->AukcionnayaCena = '';
					$obj->ValutaAukcionnoiCeny = '';
					$obj->product_type = 'rezina';
					$obj->Prodan = 0;
					$obj->DataProdaji = 0;
					$PerezagruzitFoto = trim($item->Value[8].'');
					
					$updateimg = true; 
							
					//pr($obj);
					$model->updateProduct($obj, $updateimg);
				}
		}
	
	public function getModelForMasla($product_name){
		$result = '';
		if (strpos($product_name, 'Моторное') > -1){
			$result = 'engine';
		}
		if (strpos($product_name, 'Полусинтети') > -1){
			$result = 'semi-sintetic';
		}
		if ((strpos($product_name, 'Полностью') > -1) and (strpos($product_name, 'синтет') > -1)){
			$result = 'sintetic';
		}
		if (strpos($product_name, 'Трансмис') > -1){
			$result = 'transmission';
		}
		if (strpos($product_name, 'промывочн') > -1){
			$result = 'flushing';
		}
		
		return $result;
	}
	//тестирование функций
	public function test()
		{
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			$db = JFactory::getDBO();
			$user = JFactory::getUser();
			
			$sql = 'SELECT `link` FROM `#__users` WHERE `id`='.$user->id;
			$db->setQuery($sql);
			$link = $db->LoadResult();
			$link = trim($link);
			
			if (!$link)
				{
					echo 'Неизвестный пользователь';
					return;
				}
			$date1 = JRequest::getVar("date1");
			$date2 = JRequest::getVar("date2");
			
			$date1 = date("Ymd000001",strtotime($date1));
			$date2 = date("Ymd235959",strtotime($date2));
			//pr($ballansst);
			//pr($ballansed);
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			
			if (!$user->id) 
				{
					echo 'Доступ только для авторизованых пользователей';
					return;
				}
				
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('Customer'=>$link,'Date1'=>$date1,'Date2'=>$date2);
			$obj = $client->MK_GetClientPaymentsReport($param);
			
			//echo $obj->return;
			
			$doc = simplexml_load_string($obj->return);
			
			unset($doc->column);
			$html = '<table border="1" class="kabtable kabtableHeader">
						<thead>
							<tr>
								<td width="300">Документ / Регистратор / Валюта</td>
								<td>Автомобили</td>
								<td width="50">Долг Перед Контр агентом На Начало</td>
								<td width="50">Долг Контр агента На Начало</td>
								<td width="50">Увел-е Долга Перед Контр агентом</td>
								<td width="50">Увел-е Долга Контр агента</td>
								<td width="50">Долг Перед Контр агентом На Конец</td>
								<td width="50">Долг Контр агента На Конец</td>
							</tr>
						</thead>
					</table>
					<div style="overflow:auto; height:600px;">
					<table cellspacing="0" cellpadding="0" class="kabtable">
						<tbody>';
			
			for($i = count($doc->row)-1; $i>=0; $i--){
				$row = $doc->row[$i];
				$document_array = array();
				if (strval($row->Value[5])) $document_array[] = strval($row->Value[5]);
				if (strval($row->Value[8])) $document_array[] = strval($row->Value[8]);
				if (strval($row->Value[3])) $document_array[] = strval($row->Value[3]);
				$document_html = implode($document_array, ' / ');
				
				if (strval($row->Value[7])) {
					$onclick = 'onClick="showDoc(\''.strval($row->Value[7]).'\')"';
					$ank1 = '<a>';
					$ank2 = '</a>';
				} else {
					$onclick = 'style="cursor:default;"' ;
					$ank1 = '';
					$ank2 = '';
				}
				$html .= '<tr class="level'.strval($row->Value[1]).'" '.$onclick.' >
							<td width="300">'.$ank1.$document_html.$ank2.'&nbsp;</td>
							<td>'.$ank1.strval($row->Value[6]).$ank2.'&nbsp;</td>
							<td width="50">'.$ank1.strval($row->Value[9]).$ank2.'&nbsp;</td>
							<td width="50">'.$ank1.strval($row->Value[10]).$ank2.'&nbsp;</td>
							<td width="50">'.$ank1.strval($row->Value[11]).$ank2.'&nbsp;</td>
							<td width="50">'.$ank1.strval($row->Value[12]).$ank2.'&nbsp;</td>
							<td width="50">'.$ank1.strval($row->Value[13]).$ank2.'&nbsp;</td>
							<td width="50">'.$ank1.strval($row->Value[14]).$ank2.'&nbsp;</td>
						</tr>';
			}
			$html .= '</tbody>
				</table></div>';
			
			echo $html;
			exit;
		}
	//получение балланса контрагента на заданный период
	public function MK_GetReportForCustomers_Balance($link, $date)
		{
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			$fdate = (string) date("Ymd",strtotime($date));
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('Customer'=>$link, 'Date'=>$fdate);
			
			$obj = $client->MK_GetReportForCustomers_Balance($param);
			
			if ($obj->return == 'Error') 
				{
					return array('Все валюты'=>0);
				}
			else
				{
					$xml = new SimpleXMLElement($obj->return);//pr($xml);
					unset($xml->column);
					
					$mass = array();
					
					foreach($xml->row as $item)
						{
							$currency = (string) $item->Value[2];
							$value = -(float) $item->Value[0];
							$mass[$currency] = $value;
						}
					return($mass);
				}
		}
	//обновление линков товаров
	public function updateLink()
		{
			$db = JFactory::getDBO();
			
			$link = JRequest::getVar('link');
			$product_sku = JRequest::getVar('scu');
			
			if (($link) and ($product_sku))
				{
					$sql = "UPDATE `#__vm_product` SET `link`='$link' WHERE `product_sku`='$product_sku' LIMIT 1";
					$db->setQuery($sql);
					$db->query();
				}
		}
	//загрузка контрагентов
	public function loadAllCustomer()
		{
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			SincroniseModelSincronise::delUser();
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('ID'=>'');
			$obj = $client->GetListOfCustomer($param);
			//echo $obj->return;
			$rss = new XML($obj->return);

			$rows = array();
			for($i=0;$i<count($rss->ValueTable->column);$i++)
				{
					$rows[$i] = ''.$rss->ValueTable->column[$i]->Title;
				}
				
			$this->head = $rows;

			$users = array();
			for($i = 0;$i<count($rss->ValueTable->row);$i++)
				{
					foreach($rows as $k=>$v)
						{
							$v = ''.$v;
							$k = ''.$k;
							$id = $rss->ValueTable->row[$i]->Value[0].'';
							$val = '';
							if (isset($rss->ValueTable->row[$i]->Value[$k])) 
								{
									$val = $rss->ValueTable->row[$i]->Value[$k].'';
								}
							$users[$id][$v] = $val;
						}
				}
			$i=0;
			foreach($users as $k=>$item)
				{
					$i++;
					unset($obj); 	
					$obj->id = $this->getSiteId($item['Link']);
					$obj->link = $item['Link'];
					$obj->name = $item['Name'];
					$obj->username = ($item['Email']) ? $item['Email'] : md5($item['Name']);
					$obj->email = $item['Email'];
					$obj->password = 'd421d97531529fc6519096ae970dfa15:g4nYvNRUQybwhgawelEEVmGApD9qgejs';
					$obj->usertype = 'Registered';
					$obj->gid = 19;
					$obj->block = 0;
					$obj->sendEmail = 0;
					$obj->registerDate = '0000-00-00 00:00:00';
					$obj->lastvisitDate = '0000-00-00 00:00:00';
					$obj->activation = '';
					$obj->params = '';
					$obj->ballans = (float) $item['Баланс'];
					$obj->phone_1 = $item['Telefon'];
					$obj->address_1 = $item['PochtovyiAdress'];
					//pr($obj);
					SincroniseModelSincronise::updateUser($obj);
				}
		}
	//загрузка списка производителей
	public function loadAllManufacturer()
		{
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('ID'=>'');
			$obj = $client->GetListOfManufacturer($param);
			
			$rss = new XML($obj->return);

			$rows = array();
			for($i=0;$i<count($rss->ValueTable->column);$i++)
				{
					$rows[$i] = ''.$rss->ValueTable->column[$i]->Title;
				}
				
			$this->head = $rows;

			$model = array();
			for($i = 0;$i<count($rss->ValueTable->row);$i++)
				{
					foreach($rows as $k=>$v)
						{
							$v = ''.$v;
							$k = ''.$k;
							$id = $rss->ValueTable->row[$i]->Value[0].'';
							$val = '';
							if (isset($rss->ValueTable->row[$i]->Value[$k])) 
								{
									$val = $rss->ValueTable->row[$i]->Value[$k].'';
								}
							$model[$id][$v] = $val;
						}
				}
			$i=0;
			foreach($model as $k=>$item)
				{
					$i++;
					unset($obj); 	
					$obj->link = $item['Link'];
					$obj->name = $item['Name'];
					
					SincroniseModelSincronise::updateManufacturer($obj);
				}
		}
	//загрузка контрагентов
	public function loadCustomer($id = null)
		{
			if (empty($id)) $id = trim(JRequest::getVar('link'));
		
			header('Content-type: text/html; charset=utf-8');
			ini_set("soap.wsdl_cache_enabled", "0");
			
			$dop_param = array('login'=>$this->user, 'password'=>$this->pass);
			$client = new SoapClient($this->url,$dop_param);
			$param = array('ID'=>$id);
			$obj = $client->GetListOfCustomer($param);
			
			$data = '<row>
						<Value xsi:type="xs:string">none</Value>
						<Value xsi:type="xs:string">none</Value>
					</row>';
			$rss = new XML(str_replace('</ValueTable>',$data.'</ValueTable>',$obj->return));

			$rows = array();
			for($i=0;$i<count($rss->ValueTable->column);$i++)
				{
					$rows[$i] = ''.$rss->ValueTable->column[$i]->Title;
				}
				
			$this->head = $rows;

			$users = array();
			for($i = 0;$i<count($rss->ValueTable->row);$i++)
				{
					foreach($rows as $k=>$v)
						{
							$v = ''.$v;
							$k = ''.$k;
							$id = $rss->ValueTable->row[$i]->Value[0].'';
							$val = '';
							if (isset($rss->ValueTable->row[$i]->Value[$k])) 
								{
									$val = $rss->ValueTable->row[$i]->Value[$k].'';
								}
							$users[$id][$v] = $val;
						}
				}
				
			unset($users['none']);$i=0;
			foreach($users as $k=>$item)
				{
					$i++;
					unset($obj); 	
					$obj->link = $item['Link'];
					$obj->name = $item['Name'];
					$obj->username = ($item['Email']) ? $item['Email'] : md5($item['Name']);
					$obj->email = $item['Email'];
					$obj->password = 'd421d97531529fc6519096ae970dfa15:g4nYvNRUQybwhgawelEEVmGApD9qgejs';
					$obj->usertype = 'Registered';
					$obj->gid = 19;
					$obj->block = 0;
					$obj->sendEmail = 0;
					$obj->registerDate = '0000-00-00 00:00:00';
					$obj->lastvisitDate = '0000-00-00 00:00:00';
					$obj->activation = '';
					$obj->params = '';
					$obj->ballans = 0;
					$obj->phone_1 = $item['Telefon'];
					$obj->address_1 = $item['PochtovyiAdress'];
					//pr($obj);
					SincroniseModelSincronise::updateUser($obj);
				}
		}
	//вывод результатов поиска в продуктах из экселя
	public function findExcel()
		{
			$db = JFactory::getDBO();
			$model = mysql_real_escape_string(JRequest::getVar('model'));
			
			$sql = "SELECT * FROM `#__parce_excel` WHERE `oe` LIKE '%$model%'";
			$db->setQuery($sql);
			$rows = $db->LoadObjectList();
			foreach($rows as $row)
				{
					$oe = $row->oe;
					$name = $row->name;
					$model = $row->model;
					$manufacturer = $row->manufacturer;
					$price = $row->price;
					
					$result .= "<tr>
									<td>$oe</td>
									<td>$name</td>
									<td>$model</td>
									<td>$manufacturer</td>
									<td>$price</td>
									<td>&nbsp;</td>
								</tr>";
				}
		
			echo '<content>';
			echo $result;
			echo '</content>';
		}
	//вывод результатов поиска в продуктах из виртуемарта
	public function findProduct()
		{
			$db = JFactory::getDBO();
			$model = mysql_real_escape_string(JRequest::getVar('model'));
			
			$result = '';
			if ($model) 
				{
					$sql = "SELECT `p`.*, (
								SELECT `mf_name` 
								FROM `#__vm_manufacturer` 
								WHERE `manufacturer_id` = (
									SELECT `manufacturer_id` 
									FROM `#__vm_product_mf_xref`
									WHERE `product_id`=`p`.`product_id`
									LIMIT 1
															)	
								LIMIT 1
											) AS `manufacturer`, (
								SELECT `product_price` 
								FROM `jos_vm_product_price` 
								WHERE `product_id`=`p`.`product_id`
								LIMIT 1) AS `price`
							FROM `#__vm_product` AS `p` 
							WHERE `p`.`product_sku` LIKE '%$model%'";
					$db->setQuery($sql);
					$rows = $db->LoadObjectList();
					foreach($rows as $row)
						{
							$oe = $row->product_sku;
							$name = $row->product_name;
							$model = $row->product_s_desc;
							$manufacturer = $row->manufacturer;
							$price = number_format($row->price,2,',','');
							
							$result .= "<tr>
											<td>$oe</td>
											<td>$name</td>
											<td>$model</td>
											<td>$manufacturer</td>
											<td>$price</td>
											<td>&nbsp;</td>
										</tr>";
						}
				}
			echo '<content>';
			echo $result;
			echo '</content>';
		}
	public function getSiteId($_1cid)
		{
			$db = JFactory::getDBO();
			$sql = "SELECT `site_id` FROM `#__site_1c_id` WHERE `1c_id`='$_1cid' LIMIT 1";
			$db->setQuery($sql);
			$site_id = $db->LoadResult();
			
			if (!$site_id)
				{
					$sql = "INSERT INTO `#__site_1c_id` (`1c_id`) VALUES ('$_1cid')";
					$db->setQuery($sql);
					$db->query();
					$site_id = $db->insertid();
				}
			return $site_id;
		}
	
}

class Array2XML {
     
    private $writer;
    private $version = '1.0';
    private $encoding = 'UTF-8';
    private $rootName = 'root';
     
 
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
					$this->getXML($data,'order');
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
			$this->rootName = 'root';
		}
    private function getXML($data,$lvl = '') 
		{
			foreach ($data as $key=>$val) 
				{
					if (is_numeric($key)) 
						{
							if ($lvl=='root') $key = 'orders'; else $key = $lvl.'_'.$key;
							if ($lvl=='items') $key = 'item'; else $key = $lvl.'_'.$key;
						}
					if (is_array($val)) 
						{
							$this->writer->startElement($key);
							$this->getXML($val,$key);
							$this->writer->endElement();
						}
					elseif (is_object($val)) 
						{
							$this->writer->startElement($key);
							$this->getXML($val,$key);
							$this->writer->endElement();
						}
					else 
						{
							$this->writer->writeElement($key, $val);
						}
				}
		}
}
class XML implements ArrayAccess, IteratorAggregate, Countable {
      /**
       * Указатель на текущий элемент
       * @var XML
       */
      private $pointer;
      /**
       * Название элемента
       * @var string
       */
      private $tagName;
      /**
       * Ассоциативный массив атрибутов
       * @var array
       */
      private $attributes = array();
      /**
       * Содержимое элемента
       * @var string
       */
      private $cdata;
      /**
       * Указатель на родительский элемент
       * @var XML
       */   
      private $parent;
      /**
       * Массив потомков, вида:
       * array('tag1' => array(0 =>, 1 => ...) ...)
       * @var array
       */
      private $childs = array();
         
      /**
       * Конструктор из строки с xml-текстом
       * или данных вида array('название', array('атрибуты'))
       * @var array|string $data
       */
      public function __construct($data) {
          if (is_array($data)) {
            list($this->tagName, $this->attributes) = $data;
          } else if (is_string($data))
              $this->parse($data);
      }
         
      /**
       * Метод для доступа к содержанию элемента
       * @return stirng
       */
      public function __toString() {
          return $this->cdata.'';
      }
         
      /**
       * Доступ к потомку или массиву потомков
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
          //throw new Exception("UFO steals [$name]!");
      }
         
      /**
       * Доступ к атрибутам текущего элемента
       * @var string $offset
       * @return mixed
       */
      public function offsetGet($offset) {
          if (isset($this->attributes[$offset]))
            return $this->attributes[$offset];
            throw new Exception("Holy cow! There is'nt [$offset] attribute!");
      }
         
      /**
       * Проверка на существование атрибута
       * @var string $offset
       * @return bool
       */
      public function offsetExists($offset) {
          return isset($this->attributes[$offset]);
      }
         
      /**
       * Затычки
       */
      public function offsetSet($offset, $value) { return; }
      public function offsetUnset($offset) { return; }
     
      /**
       * Возвращает количество элементов с этим именем у родителя
       * @return integer
       */
      public function count() {
            if ($this->parent != null)
                  return count($this->parent->childs[$this->tagName]);
            return 1;
      }
         
      /**
       * Возвращает итератор по массиву одноименных элементов
       * @return ArrayIterator
       */
      public function getIterator() {
            if ($this->parent != null)
                  return new ArrayIterator($this->parent->childs[$this->tagName]);
            return new ArrayIterator(array($this));
      }
     
      /**
       * Получить массив атрибутов
       * @return array
       */
      public function getAttributes() {
            return $this->attributes;
      }
         
      /**
       * Добавить потомка
       * @var string $tag
       * @var array $attributes
       * @return XML
       */
      public function appendChild($tag, $attributes) {
          $element = new XML(array($tag, $attributes));
          $element->setParent($this);
          $this->childs[$tag][] = $element;
          return $element;
      }
         
      /**
       * Установить родительский элемент
       * @var XML $parent
       */
      public function setParent(XML $parent) {
          $this->parent =& $parent;
      }
         
      /**
       * Поулчить родительский элемент
       * @return XML
       */
      public function getParent() {
          return $this->parent;
      }
         
      /**
       * Установить данные элемента
       * @var string $cdata
      */
      public function setCData($cdata) {
          $this->cdata = $cdata;
      }
         
      /**
       * Парсим xml-строку и делаем дерево элементов
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
       * При открытии тега, добавляем дите и устанавливаем указатель на него
       */
      private function tag_open($parser, $tag, $attributes) {
          $this->pointer =& $this->pointer->appendChild($tag, $attributes);
      }
     
      /**
       * При получении данных
       */
      private function cdata($parser, $cdata) {
          $this->pointer->setCData($cdata);
      }
     
      /**
       * При закрытии тега, возвращаем указатель на предка
       */
      private function tag_close($parser, $tag) {
          $this->pointer =& $this->pointer->getParent();
      }
}
